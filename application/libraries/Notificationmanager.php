<?php

class Notificationmanager {

    /**
     * Constructor
     */
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('gcm');
        $this->CI->load->library('writelog');
        $this->CI->load->helper('url');
    }

    public function sendMessage($sender_type, $sender_id, $sender_name, $sender_photo, $recipient, $message_text, $message_title, $message_type, $message_action = array(), $message_action_code = "") {
        $data = array('sender_type' => $sender_type, 'sender_id' => $sender_id, 'sender_name' => $sender_name, 'sender_photo' => $sender_photo, 'reciever_id' => $recipient->user_id, 'message_text' => $message_text, 'message_title' => $message_title, 'message_typex' => $message_type, 'message_action' => json_encode($message_action), 'message_action_code' => $message_action_code, 'mesage_date_time' => date('Y-m-d H:i:s', strtotime('now')));
        $q = $this->CI->db->insert('user_notification', $data);
        if ($q > 0) {
            $this->send_single($recipient, $data);
            return 'Done';
        }
    }

    public function sendBroadcastMessage($sender_type, $sender_id, $sender_name, $sender_photo, $recipients, $message_text, $message_title, $message_type, $message_action = array(), $message_action_code = "") {
        foreach ($recipients as $receiver_id) {
            $data = array('sender_type' => $sender_type, 'sender_id' => $sender_id, 'sender_name' => $sender_name, 'sender_photo' => $sender_photo, 'reciever_id' => $receiver_id, 'message_text' => $message_text, 'message_title' => $message_title, 'message_typex' => $message_type, 'message_action' => json_encode($message_action), 'message_action_code' => $message_action_code, 'mesage_date_time' => date('Y-m-d H:i:s', strtotime('now')));
            $this->CI->db->insert('user_notification', $data);
        }
        $this->send($recipients, $data);
    }

    public function update_status($message_id, $status) {
        $data = array('message_status' => $status);
        $q = $this->CI->db->update('user_notification', $data, array('message_id' => $message_id));
        return($q > 0);
    }

    public function delete($reciever_id, $message_id) {
        $data = array('message_visibility' => '0');
        $q = $this->CI->db->update('user_notification', $data, array('reciever_id' => $reciever_id, 'message_id' => $message_id));
        return ($q > 0);
    }

    public function get_notifications($reciever_id, $status = '') {
        if (!empty($status)) {
            $this->CI->db->where('message_status', $status);
        }
        $this->CI->db->where('reciever_id', $reciever_id);
        $this->CI->db->where('message_visibility', '1');
        $q = $this->CI->db->get('user_notification');
        return $q->result();
    }

    public function send_single($user, $message) {
        $messageObject = (object) $message;
        $this->CI->gcm->setMessage($messageObject->message_text);
        $this->hasvalidgcm = false;
        // add recepient or few
        if (!empty($user->gcm_token)) {
            $this->CI->gcm->addRecepient($user->gcm_token);
            $this->hasvalidgcm = true;
        }
        if ($this->hasvalidgcm) {
// set additional data
            $this->CI->gcm->setData($message);
// also you can add time to live
            $this->CI->gcm->setTtl(500);
// and unset in further
            $this->CI->gcm->setTtl(false);
            $this->CI->gcm->send();
        }
// and see responses for more info
        $this->CI->writelog->writelog($messageObject->sender_id, LOG_GCM_MESSAGE, $messageObject->message_text . "#" . serialize($this->CI->gcm->status));
        return ($this->CI->gcm->status);
    }

    public function send($clients, $message) {
        $messageObject = (object) $message;
        $this->CI->gcm->setMessage($messageObject->message_text);
        $this->hasvalidgcm = false;
        // add recepient or few
        foreach ($clients as $value) {
            if (!empty($value->gcm_token)) {
                $this->CI->gcm->addRecepient($value->gcm_token);
                $this->hasvalidgcm = true;
            }
        }
        if ($this->hasvalidgcm) {
// set additional data
            $this->CI->gcm->setData($message);
// also you can add time to live
            $this->CI->gcm->setTtl(500);
// and unset in further
            $this->CI->gcm->setTtl(false);
            $this->CI->gcm->send();
        }
// and see responses for more info
        $this->CI->writelog->writelog($messageObject->sender_id, LOG_GCM_MESSAGE, $messageObject->message_text . "#" . serialize($this->CI->gcm->status));
        return ($this->CI->gcm->status);
    }

    function sendMail($sender_id, $type, $title, $reciever_email, $data, $attachment = array()) {

        $this->CI->load->library('email');
        //$config['protocol'] = 'sendmail';
        //$config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        $config['protocol'] = 'smtp';
        $config['smtp_user'] = 'admin@surgitrack.co.za';
        $config['smtp_pass'] = 'SurgiTrack2017@@';
        $config['smtp_port'] = '465';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['mail_path'] = 'ssl://smtp.gmail.com';
        $this->CI->email->initialize($config);
        $this->CI->email->from('no-reply', NOREPLY);
        $this->CI->email->reply_to('no-reply', CONTACT_EMAIL);
        $this->CI->email->to($reciever_email);
        $this->CI->email->subject($title, SYSTEM_NAME);
        $this->CI->email->message($this->CI->load->view('email/' . $type . '.php', $data, TRUE));
        $this->CI->email->set_alt_message($this->CI->load->view('email/' . $type . '-txt', $data, TRUE));
        if (!empty($attachment)) {
            foreach ($attachment as $value) {
                $this->CI->email->attach($value);
            }
        }
        $this->CI->writelog->writelog($sender_id, LOG_MAIL_MESSAGE, $title . "#" . serialize($reciever_email));
        if (!$this->CI->email->send()) {
            //die($this->CI->email->print_debugger());
            return FALSE;
        } else {
            return TRUE;
        }
    }

}
