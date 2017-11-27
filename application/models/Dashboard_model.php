<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Dashboard_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function dashstats($firm_id = '') {
        $waittime = $this->get_wait_time($firm_id);

        $dashboard_stats = array(
            'avg_wait_time' => $waittime->wait_time,
            'patients_waiting' => $waittime->patients,
            'theatre_time' => $this->total_theatre_time($firm_id)/60
        );
        return $dashboard_stats;
    }

    private function get_wait_time($firm_id) {

        if (isset($firm_id) && $firm_id != null) {
            $this->db->where(array("b.firm_id" => $firm_id));
        }

        $this->db->select('AVG(DATEDIFF(Now(),booking_date)) as wait_time, count(booking_date) as patients')
            ->from('strack_booking b');
        $this->db->join('strack_department_firms f', 'b.firm_id=f.firm_id');
        $where = '(b.booking_status ="0" OR b.booking_status="1")';
        $this->db->where(array("b.isdeleted" => '0'));
        $this->db->where($where);
        $query = $this->db->get();
        $result = $query->row();

        return $result;
    }

    private function total_theatre_time($firm_id = '') {

        if (isset($firm_id) && $firm_id != null) {
            $this->db->where(array("b.firm_id" => $firm_id));
        }
        $where = '(b.booking_status ="0" OR b.booking_status="1")';
        $this->db->where($where);
        $this->db->select_sum('slot_value')
            ->from('strack_booking b');
        $this->db->join('strack_department_firms f', 'b.firm_id=f.firm_id');
        $this->db->join('strack_facility_time_slots s', 'b.slot_id=s.slot_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->row()->slot_value;

        return $result;
    }


    public function get_highest_lead_time($procedure_id, $firm_id) {
        $this->db->where(array("procedure_id" => $procedure_id, "firm_id" => $firm_id));
        $this->db->select('DATEDIFF( date(Now()),date(MIN(strack_booking.booking_date))) as leadtime')
            ->from('strack_booking');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->row()->leadtime;
        } else {
            return 0;
        }
    }

}
