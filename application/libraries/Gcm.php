<?php

class Gcm {

    protected $apiKey = '';
    protected $apiSendAddress = '';
    protected $payload = array();
    protected $additionalData = array();
    protected $recepients = array();
    protected $message = '';
    public $status = array();
    public $messagesStatuses = array();
    public $responseData = null;
    public $responseInfo = null;
    protected $errorStatuses = array(
        'Unavailable' => 'Maybe missed API key',
        'MismatchSenderId' => 'Make sure you\'re using one of those when trying to send messages to the device. If you switch to a different sender, the existing registration IDs won\'t work.',
        'MissingRegistration' => 'Check that the request contains a registration ID',
        'InvalidRegistration' => 'Check the formatting of the registration ID that you pass to the server. Make sure it matches the registration ID the phone receives in the google',
        'NotRegistered' => 'Not registered',
        'MessageTooBig' => 'The total size of the payload data that is included in a message can\'t exceed 4096 bytes'
    );

    /**
     * Constructor
     */
    public function __construct() {
        $this->apiKey = GCM_KEY;
        $this->apiSendAddress = GCM_URL;
        if (!$this->apiKey) {
            show_error('GCM: Needed API Key');
        }
        if (!$this->apiSendAddress) {
            show_error('GCM: Needed API Send Address');
        }
    }

    /**
     * Sets additional data which will be send with main apn message
     *
     * @param <array> $ttl
     * @return <array>
     */
    public function setTtl($ttl = '') {
        if (!$ttl) {
            unset($this->payload['time_to_live']);
        } else {
            $this->payload['time_to_live'] = $ttl;
        }
    }

    /**
     * Setting GCM message
     *
     * @param <string> $message
     */
    public function setMessage($message = '') {
        $this->message = $message;
        $this->payload['data']['message'] = $message;
    }

    /**
     * Setting data to message
     *
     * @param <string> $data
     */
    public function setData($data = array()) {
        $this->payload['data'] = $data;
        if ($this->message) {
            $this->payload['data']['message'] = $this->message;
        }
    }

    /**
     * Setting group of messages
     *
     * @param <string> $group
     */
    public function setGroup($group = '') {
        if (!$group) {
            unset($this->payload['collapse_key']);
        } else {
            $this->payload['collapse_key'] = $group;
        }
    }

    /**
     * Adding one recepient
     *
     * @param <string> $registrationId
     */
    public function addRecepient($registrationId) {
        $this->payload['registration_ids'][] = $registrationId;
    }

    /**
     * Setting all recepients
     *
     * @param <string> $registrationIds
     */
    public function setRecepients($registrationIds) {
        $this->payload['registration_ids'] = $registrationIds;
    }

    /**
     * Clearing group of messages
     */
    public function clearRecepients() {
        $this->payload['registration_ids'] = array();
    }

    /**
     * Senging messages to Google Cloud Messaging
     *
     * @param <string> $group
     */
    public function send() {
        $this->payload['registration_ids'] = array_unique($this->payload['registration_ids']);
        sort($this->payload['registration_ids']);
        if (isset($this->payload['time_to_live']) && !isset($this->payload['collapse_key'])) {
            $this->payload['collapse_key'] = 'GCM Notifications';
        }
        $data = json_encode($this->payload);
        return $this->request($data);
    }

    protected function request($data) {
        $headers[] = 'Content-Type:application/json';
        $headers[] = 'Authorization:key=' . $this->apiKey;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $this->apiSendAddress);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $this->responseData = curl_exec($curl);
        $this->responseInfo = curl_getinfo($curl);
        curl_close($curl);
        return $this->parseResponse();
    }

    protected function parseResponse() {
        if ($this->responseInfo['http_code'] == 200) {
            $response = explode("\n", $this->responseData);
            $responseBody = json_decode($response[count($response) - 1]);
            if ($responseBody->success && !$responseBody->failure) {
                $message = 'All messages were sent successfully';
                $error = 0;
            } elseif ($responseBody->success && $responseBody->failure) {
                $message = $responseBody->success . ' of ' . ($responseBody->success + $responseBody->failure) . ' messages were sent successfully';
                $error = 1;
            } elseif (!$responseBody->success && $responseBody->failure) {
                $message = 'No messages cannot be sent. ' . $responseBody->results[0]->error;
                $error = 1;
            }
            $this->status = array(
                'error' => $error,
                'message' => $message
            );
            $this->messagesStatuses = array();
            foreach ($responseBody->results as $key => $result) {
                if (isset($result->error) && $result->error) {
                    $this->messagesStatuses[$key] = array(
                        'error' => 1,
                        'regid' => $this->payload['registration_ids'][$key],
                        'message' => $this->errorStatuses[$result->error],
                        'message_id' => ''
                    );
                } else {
                    $this->messagesStatuses[$key] = array(
                        'error' => 0,
                        'regid' => $this->payload['registration_ids'][$key],
                        'message' => 'Message was sent successfully',
                        'message_id' => $result->message_id
                    );
                }
            }
            return !$error;
        } elseif ($this->responseInfo['http_code'] == 400) {
            $this->status = array(
                'error' => 1,
                'message' => 'Request could not be parsed as JSON'
            );
            return false;
        } elseif ($this->responseInfo['http_code'] == 401) {
            $this->status = array(
                'error' => 1,
                'message' => 'There was an error authenticating the sender account'
            );
            return false;
        } elseif ($this->responseInfo['http_code'] == 500) {
            $this->status = array(
                'error' => 1,
                'message' => 'There was an internal error in the GCM server while trying to process the request'
            );
            return false;
        } elseif ($this->responseInfo['http_code'] == 503) {
            $this->status = array(
                'error' => 1,
                'message' => 'Server is temporarily unavailable'
            );
            return false;
        } else {
            $this->status = array(
                'error' => 1,
                'message' => 'Status undefined'
            );
            return false;
        }
    }

}

/*--

-- --------------------------------------------------------

--
-- Table structure for table `user_notification`
--

CREATE TABLE IF NOT EXISTS `user_notification` (
`id` int(11) NOT NULL,
  `sender_type` varchar(10) NOT NULL,
  `sender_id` bigint(20) NOT NULL,
  `sender_name` varchar(100) NOT NULL,
  `sender_photo` text NOT NULL,
  `reciever_id` bigint(20) NOT NULL,
  `message_text` varchar(250) NOT NULL,
  `message_title` varchar(30) NOT NULL,
  `message_type` int(11) NOT NULL,
  `message_action` varchar(200) NOT NULL,
  `message_action_code` bigint(20) NOT NULL,
  `message_status` enum('sent','delivered','unread','unread') NOT NULL DEFAULT 'sent',
  `message_visibility` enum('1','0') NOT NULL DEFAULT '1',
  `mesage_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user_notification`
--
ALTER TABLE `user_notification`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user_notification`
--
ALTER TABLE `user_notification`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
 * 
 */