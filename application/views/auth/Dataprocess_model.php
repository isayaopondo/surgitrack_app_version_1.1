<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Dataprocess_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function save_indicator_data($data, $table, $instance) {
        if ($this->data_exist($table, $instance)) {
            return array('message' => 'You have successfully submitted data', 'success' => 1, 'phone_session' => $instance);
        }
        $q = $this->db->insert($table, $data);
        if ($q > 0) {
            return array('message' => 'You have successfully submitted data', 'success' => 1, 'phone_session' => $instance);
        } else {
            $message['err'] = 'true';
            $message['success'] = '0';
            $message['message'] = "Error";
        }

        return $message;
    }

    public function data_exist($table, $instance) {
        $this->db->where("instance_id", $instance);
        $q = $this->db->get($table);
        return $q->num_rows() > 0;
    }

    public function data_exist2($table, $instance) {
        $this->db->where("phone_instance", $instance);
        $q = $this->db->get($table);
        return $q->num_rows() > 0;
    }

    public function save_participant($data, $phoneInstance) {
        if ($this->data_exist2("survey_participant", $phoneInstance)) {
            return array('message' => 'You have successfully submitted data', 'success' => 1, 'phone_session' => $phoneInstance);
        }
        $q = $this->db->insert('survey_participant', $data);
        if ($q > 0) {
            return array('message' => 'You have successfully submitted data', 'success' => 1, 'phone_session' => $phoneInstance);
        } else {
            $message['success'] = '0';
            $message['message'] = "Error transmitting the data";
        }
        return $message;
    }

    public function save_processed($table, $data) {
        $q = $this->db->insert($table, $data);
        if ($q > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function save_device_log($data) {
        $q = $this->db->insert('iccm_device_transactions', $data);
        if ($q > 0) {
            return 1;
        } else {
            return 0;
        }
    }

    public function getData($type, $user = '') {
        switch ($type) {
            case CALL_GET_TERRITORY:
                return $this->get_territory();
            case CALL_GET_REGION:
                return $this->get_region();
            case CALL_GET_CHANNEL:
                return $this->get_channel();
        }
    }

    public function get_territory() {
        $q = $this->db->get("eds_teritory");
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            return array();
        }
    }

    public function get_region() {
        $q = $this->db->get("eds_regions");
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            return array();
        }
    }

    public function get_channel() {
        $q = $this->db->get("eds_sales_channel");
        if ($q->num_rows() > 0) {
            return $q->result();
        } else {
            return array();
        }
    }

# process json for indicators
#
#

    public function get_indicator_data($table) {
        $this->db->where('processed', '0');
        $q = $this->db->get($table);
        return $q->result();
    }

    public function update_processed($table, $field, $id) {

        $this->db->update($table, array('processed' => '1'), array($field => $id));
    }

    public function parseBuffers() {
        $sql = "SHOW TABLES LIKE  '%_buffer'";
        $q = $this->db->query($sql);
        return $q->result();
    }

}
