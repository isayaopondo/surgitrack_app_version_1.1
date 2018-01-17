<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 17/01/2018
 * Time: 14:16
 */

class Freshdesk
{
    /**
     * The CodeIgniter super object
     *
     * @var object
     * @access public
     */
    public $CI;

    public $api_key = "Am78NoZ1hG1LuaIRWX97";
    public $password = "Surgitrack2018@@";
    public $username = "admin@surgitrack.co.za";
    public $domain = "surgitrack";

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->CI =& get_instance();

    }

    public function create_ticket()
    {
        $ticket_data = json_encode(array(
            "description" => "Some details on the issue ...",
            "subject" => "Support needed..",
            "email" => "isaiah.opondo@gmail.com",
            "priority" => 1,
            "status" => 2,
            "cc_emails" => array("isaya.opondo@gmail.com")
        ));
        $url = "https://surgitrack.freshdesk.com/api/v2/tickets";
        $ch = curl_init($url);
        $header[] = "Content-type: application/json";
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_USERPWD, "Am78NoZ1hG1LuaIRWX97" . ":" . "X");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $ticket_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headers = substr($server_output, 0, $header_size);
        $response = substr($server_output, $header_size);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        if ($info['http_code'] == 201) {
            echo "Ticket created successfully, the response is given below \n";
            echo "Response Headers are \n";
            echo $headers . "\n";
            echo "Response Body \n";
            echo "$response \n";
        } else {
            if ($info['http_code'] == 404) {
                echo "Error, Please check the end point \n";
            } else {
                echo "Error, HTTP Status Code : " . $info['http_code'] . "\n";
                echo "Headers are " . $headers;
                echo "Response are " . $response;
            }
        }
        curl_close($ch);

    }

    public function get_tickets(){
        $url = "https://surgitrack.freshdesk.com/api/v2/tickets";
        $ch = curl_init($url);

        //curl_setopt($ch, CURLOPT_URL, "https://$this->domain.freshdesk.com/api/v2/tickets");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_USERPWD, "Am78NoZ1hG1LuaIRWX97" . ":" . "X");

        $headers = array();
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close ($ch);

    }
}

