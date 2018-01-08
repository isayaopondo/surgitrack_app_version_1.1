<?php
class Administrator_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function get_blocked_surgery_slots(){
        $status_query = "(
                CASE 
                    WHEN blocked_type = '0' THEN 'Blocked Days'
                    WHEN blocked_type = '1' THEN 'Special Day'
                END) AS statusname";
        
        $blocked_color= "(
                CASE 
                    WHEN blocked_type = '0' THEN '#c902b2'
                    WHEN blocked_type = '1' THEN '#a1c901'
                END) AS evtcolor";
        
        $this->db->select('block_id,blocked_date as start,blocked_enddate as end ,blocked_reason as title,'
                . 'blocked_reason_details as description,department_id,'. $status_query.','.$blocked_color)
                ->from('strack_admin_calendar');
        $this->db->where(array('facility_id' => $this->auth_facilityid));
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    public function blocked_date_insert($data) {
        $this->db->insert('strack_admin_calendar', $data);
        $id = $this->db->insert_id();
        if ($id >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function blocked_date_update($data, $id) {
        $this->db->where('block_id', $id);
        $this->db->update('strack_admin_calendar', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }
}