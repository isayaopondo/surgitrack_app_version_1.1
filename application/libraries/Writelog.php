<?php

class Writelog {

    /**
     * Constructor
     */
    public function __construct() {
        
    }

    public function writelog($user_id='', $log_action='', $log_info='') {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $access_agent = substr($this->CI->input->user_agent(), 0, 120);
        $access_ip = $this->CI->input->ip_address();
        $access_url = $this->CI->uri->uri_string();
        $access_method = strtolower($this->CI->input->server('REQUEST_METHOD'));
        // $access_params=serialize($this->_args);
        $data = array('user_id' => $user_id, 'log_action' => $log_action, 'log_info' => $log_info, 'access_ip' => $access_ip, 'access_agent' => $access_agent, 'log_url' => $access_url, 'log_access_method' => $access_method, 'log_date_time' => date('Y-m-d H:i:s', strtotime('now')));
        $q = $this->CI->db->insert('user_activity_log', $data);
        if ($q > 0) {
            return $this->CI->db->insert_id();
        }
    }

    public function patientlog($user_id, $patient_id, $log_action, $log_info, $log_type = 'user_action') {
        $this->CI = & get_instance();
        $this->CI->load->database();
        $access_agent = substr($this->CI->input->user_agent(), 0, 120);
        $access_ip = $this->CI->input->ip_address();
        $access_url = $this->CI->uri->uri_string();
        $access_method = strtolower($this->CI->input->server('REQUEST_METHOD'));
        // $access_params=serialize($this->_args);
        $data = array(
            'user_id' => $user_id,
            'patient_id' => $patient_id,
            'log_type' => $log_type,
            'log_action' => $log_action,
            'log_info' => $log_info,
            'access_ip' => $access_ip,
            'access_agent' => $access_agent,
            'log_url' => $access_url,
            'log_access_method' => $access_method,
            'log_date_time' => date('Y-m-d H:i:s', strtotime('now'))
        );

        $q = $this->CI->db->insert('strack_patient_log', $data);
        if ($q > 0) {
            return $this->CI->db->insert_id();
        }
    }

}
