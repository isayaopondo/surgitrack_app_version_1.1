<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 03/10/2017
 * Time: 12:15
 */

class Booking_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }


    //=======================================
    // Multi-Attribute Priotitization Tool (MAPT) methods
    //=======================================

    public function mapt_insert($data)
    {
        $this->db->insert('strack_mapt', $data);
        return $this->db->insert_id();
    }

    public function mapt_criteria_insert($data)
    {
        $this->db->insert('strack_mapt_criteria', $data);
        return $this->db->insert_id();
    }

    public function mapt_scores_insert($options, $qid)
    {
        foreach ($options as $option) {
            $data['criteria_id'] = $qid;
            $data['score_value'] = $option['score_value'];
            $data['score_text'] = $option['score_text'];
            $this->insert_scores($data);
        }
    }

//Save criteria scores
    private function insert_scores($data)
    {
        $this->db->insert('strack_mapt_criteria_scores', $data);
    }

    public function mapt_formfill_insert($data)
    {
        $this->db->insert('strack_mapt_patients_score_instance', $data);
        return $this->db->insert_id();
    }

    public function mapt_formfill_scores_insert($options, $qid)
    {

        foreach ($options as $key => $option) {
            $data['mapt_score_id'] = $qid;
            $data['criteria_id'] = $key;
            $data['score_id'] = $option;
            $this->insert_formfill_scores($data);
        }
    }

    private function insert_formfill_scores($data)
    {
        $this->db->insert('strack_mapt_patients_score', $data);
        return $this->db->insert_id();
    }

    public function mapt_list_data($department_id = '')
    {
        if (isset($department_id) && $department_id != null) {
            $this->db->where(array("strack_mapt.department_id" => $department_id));
        }
        $this->db->select('mapt_id,department_name,procedure_name,mapt_name,keywords,notes')
            ->from('strack_mapt');
        $this->db->join('strack_facility_procedures pr', 'strack_mapt.procedure_id=pr.procedure_id');
        $this->db->join('strack_departments', 'strack_mapt.department_id=strack_departments.department_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function get_mapt_details($mapt_id)
    {
        $this->db->where(array("mapt_id" => $mapt_id));
        $this->db->select('mapt_id,department_name,procedure_name,category_name,mapt_name,keywords,notes')
            ->from('strack_mapt');
        $this->db->join('strack_facility_procedures pr', 'strack_mapt.procedure_id=pr.procedure_id');
        $this->db->join('strack_departments', 'strack_mapt.department_id=strack_departments.department_id', 'LEFT');
        $this->db->join('strack_facility_procedure_categories pc', 'strack_mapt.category_id=pc.category_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->row();

        return $result;
    }

    public function get_mapt_by_procedure($procedure_id)
    {
        $this->db->where(array("pr.procedure_id" => $procedure_id));
        $this->db->select('mapt_id,department_name,procedure_name,category_name,mapt_name,keywords,notes')
            ->from('strack_mapt');
        $this->db->join('strack_facility_procedures pr', 'strack_mapt.procedure_id=pr.procedure_id');
        $this->db->join('strack_departments', 'strack_mapt.department_id=strack_departments.department_id', 'LEFT');
        $this->db->join('strack_facility_procedure_categories pc', 'strack_mapt.category_id=pc.category_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->row();

        return $result;
    }

    public function get_mapt_criteria_details($mapt_id)
    {
        $this->db->where(array("mapt_id" => $mapt_id));
        $this->db->select('criteria_id,mapt_id,criteria_name,criteria_weight,additional_info')
            ->from('strack_mapt_criteria');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_mapt_criteria_score($criteria_id)
    {
        $this->db->where(array("criteria_id" => $criteria_id));
        $this->db->select('criteria_id,score_value,score_text,score_id')
            ->from('strack_mapt_criteria_scores');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_mapt_patient_score($mapt_score_id)
    {
        $this->db->where(array("in.mapt_score_id" => $mapt_score_id));
        $this->db->select('criteria_name,criteria_weight, cs.score_value,cs.score_text,cs.score_id')
            ->from('strack_mapt_patients_score_instance in ');
        $this->db->join('strack_mapt_patients_score ps', 'in.mapt_score_id=ps.mapt_score_id');
        $this->db->join('strack_mapt_criteria c', 'c.criteria_id=ps.criteria_id');
        $this->db->join('strack_mapt_criteria_scores cs', 'cs.score_id=ps.score_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_total_mapt_patient_score($mapt_score_id)
    {
        $this->db->where(array("in.mapt_score_id" => $mapt_score_id));
        $this->db->select('criteria_name,criteria_weight, cs.score_value,cs.score_text,cs.score_id')
            ->from('strack_mapt_patients_score_instance in ');
        $this->db->join('strack_mapt_patients_score ps', 'in.mapt_score_id=ps.mapt_score_id');
        $this->db->join('strack_mapt_criteria c', 'c.criteria_id=ps.criteria_id');
        $this->db->join('strack_mapt_criteria_scores cs', 'cs.score_id=ps.score_id');
        $query = $this->db->get();
        $result = $query->result();
        $totascore = 0;
        foreach ($result as $key) {
            $percentage_score = ($key->criteria_weight / 100) * $key->score_value;
            $totascore = $totascore + $percentage_score;
        }
        return $totascore;
    }

    public function get_maptDateScores($booking_id)
    {
        $this->db->where(array("booking_id" => $booking_id));
        $this->db->select('*')
            ->from('strack_mapt_patients_score_instance');
        $this->db->order_by('scoredate', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_current_maptDateScores($booking_id)
    {
        $this->db->where(array("booking_id" => $booking_id));
        $this->db->select('*')
            ->from('strack_mapt_patients_score_instance');
        $this->db->order_by('scoredate', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            $mapt_score_id = $query->row()->mapt_score_id;
            $resultscore = $this->get_total_mapt_patient_score($mapt_score_id);
        } else {
            $resultscore = 0;
        }
        return $resultscore;
    }

    public function get_highest_lead_time($procedure_id, $firm_id)
    {
        $this->db->where(array("procedure_id" => $procedure_id, "firm_id" => $firm_id));
        $this->db->select('DATEDIFF( date(Now()),date(MIN(b.booking_date))) as leadtime')
            ->from('strack_booking b');
        $query = $this->db->get();
        if ($query->num_rows() >= 1) {
            return $query->row()->leadtime;
        } else {
            return 0;
        }
    }

    /*
     * NOTE: Booking is an instance of patient's surgical process.
     *       One patient may have multiple bookings at different levels
     *       Each booking may have multiple procedures
     */

    //======================================
    //     Case Booking
    //======================================

    public function booking_insert($data)
    {
        $this->db->insert('strack_booking', $data);
        $id = $this->db->insert_id();
        if (is_numeric($id) && $id != 0) {
            return $id;
        } else {
            return false;
        }
    }

    public function booking_update($data, $id)
    {
        $this->db->where('booking_id', $id);
        $this->db->update('strack_booking', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function booking_procedure_id($id)
    {
        $this->db->where('booking_id', $id);
        $this->db->select('*')
            ->from('strack_booking b');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->procedure_id;
        } else {
            return false;
        }
    }

    public function surgeon_insert($data)
    {
        $this->db->insert('strack_booking_op_surgeon', $data);
        $id = $this->db->insert_id();
        if ($id >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_existing_booking_surgeon($id)
    {
        $this->db->where('booking_id', $id);
        $this->db->delete('strack_booking_op_surgeon');
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    //Updating details of the Surgeon who performed the operation
    public function surgeon_update($data)
    {
        $this->db->where('booking_id', $id);
        $this->db->update('strack_booking_op_surgeon', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function check_ifsurgeon_booking_exist($booking_id, $op_user_id)
    {
        $this->db->where(array("booking_id" => $booking_id, "op_user_id" => $op_user_id));
        $this->db->select('*')
            ->from('strack_booking_op_surgeon');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function check_if_patient_has_open_booking($procedure_id = '', $patient_id = '')
    {
        if (isset($procedure_id) && $procedure_id != null) {
            $this->db->where(array("procedure_id" => $procedure_id));
        }
        if (isset($patient_id) && $patient_id != null) {
            $this->db->where(array("patient_id" => $patient_id));
        }

        $where = " ( booking_status='0' OR booking_status='1' OR booking_status='2')";
        $this->db->where($where);
        $this->db->select('*')
            ->from('strack_booking b');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_booking($id)
    {
        $this->db->update('strack_booking b', array('isdeleted' => '1'), array('booking_id' => $id));
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_user_booked_by($user_id = '')
    {
        if (isset($user_id) && $user_id != null) {
            $this->db->where(array("users.user_id" => $user_id));
            $this->db->select('CONCAT(users.first_name," ",users.last_name) AS bookedby')
                ->from('users');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $res = $query->row();
                return $res->bookedby;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function get_user_admitted_by($user_id = '')
    {
        if (isset($user_id) && $user_id != null) {
            $this->db->where(array("users.user_id" => $user_id));
            $this->db->select('CONCAT(users.first_name," ",users.last_name) AS bookedby')
                ->from('users');
            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $res = $query->row();
                return $res->bookedby;
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function get_user_surgeon_name($booking_id = '', $op_role)
    {
        if (isset($booking_id) && $booking_id != null) {
            $this->db->where(array("strack_booking_op_surgeon.booking_id" => $booking_id, "strack_booking_op_surgeon.op_role" => $op_role));
            $this->db->select('CONCAT(SUBSTRING(users.first_name,1,1)," . ",users.last_name) AS surgeon_name')
                ->from('users');
            $this->db->join("strack_booking_op_surgeon", "strack_booking_op_surgeon.op_user_id=users.user_id");
            $query = $this->db->get();
            $surgeon_names = array();
            if ($query->num_rows() > 0) {
                $res = $query->result();
                foreach ($res as $key) {
                    $surgeon_names[] = $key->surgeon_name;
                }
                return implode(", ", $surgeon_names);
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    public function get_user_surgeon_id($booking_id = '', $op_role)
    {
        if (isset($booking_id) && $booking_id != null) {
            $this->db->where(array("strack_booking_op_surgeon.booking_id" => $booking_id, "strack_booking_op_surgeon.op_role" => $op_role));
            $this->db->select('op_user_id AS surgeon_id')
                ->from('strack_booking_op_surgeon');
            $query = $this->db->get();
            $surgeon_names = array();
            if ($query->num_rows() > 0) {
                if ($op_role != 'assistant') {
                    $res = $query->row();
                    return $res->surgeon_id;
                } else {
                    $res = $query->result();
                    foreach ($res as $key) {
                        $surgeon_names[] = $key->surgeon_id;
                    }
                    return implode(", ", $surgeon_names);
                    //return json_encode($surgeon_names,true);
                }
            } else {
                return '';
            }
        } else {
            return '';
        }
    }

    /*
     * The query generating this list and the subsequent lists should be optimized to reduce on
     * the time taken to pull data
     */

    public function get_booking_list_data($department_id = '', $patient_id = '', $status = '', $firm_id = '')
    {

        if (isset($firm_id) && $firm_id != null) {
            $this->db->where(array("strack_department_firms.firm_id" => $firm_id));
        } elseif (isset($department_id) && $department_id != null) {
            $this->db->where(array("strack_department_firms.department_id" => $department_id));
        }
        if (isset($patient_id) && $patient_id != null) {
            $this->db->where(array("b.patient_id" => $patient_id));
        }
        $status_query = "(
                CASE 
                    WHEN b.booking_status = '0' THEN 'Waiting'
                    WHEN b.booking_status = '1' THEN 'Admission'
                    WHEN b.booking_status = '2' THEN 'Theatre'
                    WHEN b.booking_status = '3' THEN 'Surgery'
                    WHEN b.booking_status = '99' THEN 'Cancelled'
                END) AS status_name";

        $this->db->select('pl.patient_id,booking_id,folder_number,CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)," ",SUBSTRING(SUBSTRING_INDEX(other_names, " ", -1),1,1)) as fullname,other_names,surname,dateofbirth,IF(gender = "1","Male","Female") AS gender,'
            . 'theatre_name,surgerydate,date(b.created_on) as bookingdate,booking_date,category_name,surgery_indication,booking_status,b.procedure_id,'
            . 'procedure_name,admission_date,booking_info,insuranceco_name,insurance_number,DATEDIFF( date(Now()),date(b.booking_date)) as leadtime,'
            . 'anesthesia,postopbed,laterality,b.firm_id,strack_department_firms.department_id,booked_by,admitted_by,'
            . 'ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25) as age,firm_name,DATE_ADD(surgerydate,INTERVAL slot_value MINUTE) as end,'
            . 'slot_name,ward_name,department_name,' . $status_query)
            ->from('strack_booking b');
        $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
        $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
        $this->db->join('strack_facility_procedures pr', 'b.procedure_id=pr.procedure_id');
        //$this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
        $this->db->join('strack_facility_wards w', 'b.ward_id=w.ward_id', 'LEFT');
        $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_departments', 'strack_departments.department_id=strack_department_firms.department_id', 'LEFT');
        $this->db->join('strack_facility_time_slots ts', 'b.slot_id=ts.slot_id', 'LEFT');
        $this->db->join('strack_facility_procedure_categories pc', 'b.category_id=pc.category_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
        // $this->db->join("users", "b.booked_by=users.user_id");

        if ((isset($status) && $status != null) || $status != '') {
            $this->db->where(array("b.booking_status" => $status));
            if ($status == '0') {
                $this->db->order_by('b.booking_date', 'DESC');
            } elseif ($status == '1') {
                $this->db->order_by('b.admission_date', 'DESC');
            } elseif ($status == '2') {
                $this->db->order_by('b.surgerydate', 'DESC');
            }
        } else {
            $this->db->order_by('b.created_on', 'DESC');
        }
        $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.isdeleted" => '0'));

        $this->db->where("b.booking_status != '99'");
        $query = $this->db->get();
        $result = $query->result();
        //echo $this->db->last_query();
        $end_res = array();
        foreach ($result as $res) {

            $mapt = array();
            $curr_mapt_scores = $this->get_current_maptDateScores($res->booking_id);
            $maxleadtime = $this->get_highest_lead_time($res->procedure_id, $res->firm_id);
            if ($res->leadtime != 0 && $maxleadtime != 0) {
                $weighted_lead = ($res->leadtime / $maxleadtime) * 100;
            } else {
                $weighted_lead = 0;
            }
            $mapt['bookedby'] = $this->get_user_booked_by($res->booked_by);
            $mapt['admittedby'] = $this->get_user_admitted_by($res->admitted_by);
            $mapt['mapt'] = number_format($curr_mapt_scores, 2);
            $mapt['cpscore'] = number_format((($curr_mapt_scores + $weighted_lead) / 2), 2);

            $results = array_merge((array)$res, $mapt);
            array_push($end_res, $results);
        }
        return $end_res;
    }


    public function get_emergencybooking_list_data($department_id = '', $patient_id = '', $status = '', $firm_id = '')
    {

        if (isset($firm_id) && $firm_id != null) {
            $this->db->where(array("strack_department_firms.firm_id" => $firm_id));
        } elseif (isset($department_id) && $department_id != null) {
            $this->db->where(array("strack_department_firms.department_id" => $department_id));
        }
        if (isset($patient_id) && $patient_id != null) {
            $this->db->where(array("b.patient_id" => $patient_id));
        }
        $status_query = "(
                CASE 
                    WHEN b.booking_status = '0' THEN 'Waiting'
                    WHEN b.booking_status = '1' THEN 'Admission'
                    WHEN b.booking_status = '2' THEN 'Theatre'
                    WHEN b.booking_status = '3' THEN 'Surgery'
                    WHEN b.booking_status = '99' THEN 'Cancelled'
                END) AS status_name";

        $this->db->select('pl.patient_id,booking_id,folder_number,CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)," ",SUBSTRING(SUBSTRING_INDEX(other_names, " ", -1),1,1)) as fullname,other_names,surname,dateofbirth,IF(gender = "1","Male","Female") AS gender,'
            . 'theatre_name,surgerydate,date(b.created_on) as bookingdate,booking_date,category_name,surgery_indication,booking_status,b.procedure_id,'
            . 'procedure_name,admission_date,booking_info,insuranceco_name,insurance_number,TIMEDIFF( Now(),b.created_on) as leadtime,b.surgery_type,'
            . 'anesthesia,postopbed,laterality,b.firm_id,strack_department_firms.department_id,booked_by,admitted_by,'
            . 'ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25) as age,firm_name,DATE_ADD(surgerydate,INTERVAL slot_value MINUTE) as end,'
            . 'slot_name,ward_name,department_name,' . $status_query)
            ->from('strack_booking b');
        $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
        $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
        $this->db->join('strack_facility_procedures pr', 'b.procedure_id=pr.procedure_id');
        //$this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
        $this->db->join('strack_facility_wards w', 'b.ward_id=w.ward_id', 'LEFT');
        $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_departments', 'strack_departments.department_id=strack_department_firms.department_id', 'LEFT');
        $this->db->join('strack_facility_time_slots ts', 'b.slot_id=ts.slot_id', 'LEFT');
        $this->db->join('strack_facility_procedure_categories pc', 'b.category_id=pc.category_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
        // $this->db->join("users", "b.booked_by=users.user_id");

        $this->db->where("b.surgery_type = '1'");
        if ((isset($status) && $status != null) || $status != '') {
            $this->db->where(array("b.booking_status" => $status));
            if ($status == '0') {
                $this->db->order_by('b.booking_date', 'DESC');
            } elseif ($status == '1') {
                $this->db->order_by('b.admission_date', 'DESC');
            } elseif ($status == '2') {
                $this->db->order_by('b.surgerydate', 'DESC');
            }
        } else {
            $this->db->order_by('b.created_on', 'DESC');
        }
        $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.isdeleted" => '0'));

        $this->db->where("b.booking_status != '99'");
        $query = $this->db->get();
        $result = $query->result();
        //echo $this->db->last_query();
        $end_res = array();
        foreach ($result as $res) {

            $mapt = array();
            $curr_mapt_scores = $this->get_current_maptDateScores($res->booking_id);
            $maxleadtime = $this->get_highest_lead_time($res->procedure_id, $res->firm_id);
            if ($res->leadtime != 0 && $maxleadtime != 0) {
                $weighted_lead = ($res->leadtime / $maxleadtime) * 100;
            } else {
                $weighted_lead = 0;
            }
            $mapt['bookedby'] = $this->get_user_booked_by($res->booked_by);
            $mapt['admittedby'] = $this->get_user_admitted_by($res->admitted_by);
            $mapt['mapt'] = number_format($curr_mapt_scores, 2);
            $mapt['cpscore'] = number_format((($curr_mapt_scores + $weighted_lead) / 2), 2);

            $results = array_merge((array)$res, $mapt);
            array_push($end_res, $results);
        }
        return $end_res;
    }
    //Should optimize the SQL Query

    public function get_booking_list_phone($patient_id = '', $status = '', $firm_id = '')
    {

        if (isset($firm_id) && $firm_id != null) {
            $this->db->where(array("strack_department_firms.firm_id" => $firm_id));
        }
        if (isset($patient_id) && $patient_id != null) {
            $this->db->where(array("b.patient_id" => $patient_id));
        }
        $status_query = "(
                CASE 
                    WHEN b.booking_status = '0' THEN 'Waiting'
                    WHEN b.booking_status = '1' THEN 'Admission'
                    WHEN b.booking_status = '2' THEN 'Theatre'
                    WHEN b.booking_status = '3' THEN 'Surgery'
                    WHEN b.booking_status = '99' THEN 'Cancelled'
                END) AS status_name";

        $this->db->select('pl.patient_id,booking_id,folder_number,CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)," ",SUBSTRING(SUBSTRING_INDEX(other_names, " ", -1),1,1)) as fullname,other_names,surname,dateofbirth,IF(gender = "1","Male","Female") AS gender,'
            . 'theatre_name,surgerydate,date(b.created_on) as bookingdate,booking_date,category_name,surgery_indication,booking_status,b.procedure_id,'
            . 'procedure_name,admission_date,booking_info,insuranceco_name,insurance_number,DATEDIFF( date(Now()),date(b.booking_date)) as leadtime,booked_by,admitted_by,'
            . 'anesthesia,postopbed,laterality,b.firm_id,phone,'
            . 'ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25) as age,firm_name,DATE_ADD(surgerydate,INTERVAL slot_value MINUTE) as end,'
            . 'slot_name,ward_name,' . $status_query)
            ->from('strack_booking b');
        $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
        $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
        $this->db->join('strack_facility_procedures pr', 'b.procedure_id=pr.procedure_id');
        //$this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
        $this->db->join('strack_facility_wards w', 'b.ward_id=w.ward_id', 'LEFT');
        $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_facility_time_slots ts', 'b.slot_id=ts.slot_id', 'LEFT');
        $this->db->join('strack_facility_procedure_categories pc', 'b.category_id=pc.category_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
        // $this->db->join("users", "b.booked_by=users.user_id");
        $this->db->order_by('b.created_on', 'DECS');
        if ((isset($status) && $status != null) || $status != '') {
            $this->db->where(array("b.booking_status" => $status));
        }
        $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.isdeleted" => '0'));
        $query = $this->db->get();
        $result = $query->result();
        //echo $this->db->last_query();
        $end_res = array();
        foreach ($result as $res) {

            $mapt = array();
            $curr_mapt_scores = $this->get_current_maptDateScores($res->booking_id);
            $maxleadtime = $this->get_highest_lead_time($res->procedure_id, $res->firm_id);
            if ($res->leadtime != 0 && $maxleadtime != 0) {
                $weighted_lead = ($res->leadtime / $maxleadtime) * 100;
            } else {
                $weighted_lead = 0;
            }

            $mapt['bookedby'] = $this->get_user_booked_by($res->booked_by);
            $mapt['admittedby'] = $this->get_user_admitted_by($res->admitted_by);
            $mapt['mapt'] = number_format($curr_mapt_scores, 2);
            $mapt['cpscore'] = number_format((($curr_mapt_scores + $weighted_lead) / 2), 2);

            $results = array_merge((array)$res, $mapt);
            array_push($end_res, $results);
        }
        return $end_res;
    }

    //Should optimize the SQL Query
    public function get_caselog_list_data($department_id = '', $patient_id = '', $status = '', $firm_id = '')
    {
        if (isset($firm_id) && $firm_id != null) {
            $this->db->where(array("strack_department_firms.firm_id" => $firm_id));
        } elseif (isset($department_id) && $department_id != null) {
            $this->db->where(array("strack_department_firms.department_id" => $department_id));
        }


        if (isset($patient_id) && $patient_id != null) {
            $this->db->where(array("b.patient_id" => $patient_id));
        }
        $status_query = "(
                CASE 
                    WHEN b.booking_status = '0' THEN 'Waiting'
                    WHEN b.booking_status = '1' THEN 'Admission'
                    WHEN b.booking_status = '2' THEN 'Theatre'
                    WHEN b.booking_status = '3' THEN 'Surgery'
                    WHEN b.booking_status = '9' THEN 'Cancelled'
                    WHEN b.booking_status = '99' THEN 'Removed'
                END) AS status_name";
        //$userquery = "IFNULL(b.surgeon_name, CONCAT(SUBSTRING(users.first_name,1,1),'. ',users.last_name)) AS surgeon_name";

        $this->db->select('pl.patient_id,booking_id,folder_number,CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)) as fullname,other_names,surname,dateofbirth,IF(gender = "1","Male","Female") AS gender,'
            . 'theatre_name,surgerydate,date(b.created_on) as bookingdate,booking_date,category_name,surgery_indication,booking_status,b.procedure_id,'
            . 'procedure_name,admission_date,booking_info,insuranceco_name,insurance_number,DATEDIFF( date(b.op_date_start),date(b.booking_date)) as leadtime,'
            . 'operation_done,booked_by,admitted_by,phone,'
            . 'ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25) as age,firm_name,DATE_ADD(surgerydate,INTERVAL slot_value MINUTE) as end,op_date_start as operationdate,'
            . 'CONCAT(ROUND(time_to_sec((TIMEDIFF(b.op_date_end, b.op_date_start))) / 60)," Min") as surgery_time,'
            . 'surgeon_name,slot_name,ward_name,' . $status_query)
            ->from('strack_booking b');
        $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
        $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
        $this->db->join('strack_facility_procedures pr', 'b.procedure_id=pr.procedure_id');
        //$this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
        $this->db->join('strack_facility_wards w', 'b.ward_id=w.ward_id', 'LEFT');
        $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_facility_time_slots ts', 'b.slot_id=ts.slot_id', 'LEFT');
        $this->db->join('strack_facility_procedure_categories pc', 'b.category_id=pc.category_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
        //$this->db->join("users", "b.booked_by=users.user_id", 'LEFT');
        $this->db->order_by('b.created_on', 'DECS');
        if ((isset($status) && $status != null) || $status != '') {
            $this->db->where(array("b.booking_status" => $status));
        }


        $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.isdeleted" => '0'));
        $query = $this->db->get();

        $result = $query->result();
        $end_res = array();
        foreach ($result as $res) {
            $mapt = array();
            $mapt['bookedby'] = $this->get_user_booked_by($res->booked_by);
            $mapt['admittedby'] = $this->get_user_admitted_by($res->admitted_by);

            $mapt['primary_surgeon'] = $this->get_user_surgeon_name($res->booking_id, 'primary');
            $mapt['assistant_surgeon'] = $this->get_user_surgeon_name($res->booking_id, 'assistant');
            $mapt['supervisor_surgeon'] = $this->get_user_surgeon_name($res->booking_id, 'supervisor');

            $results = array_merge((array)$res, $mapt);
            array_push($end_res, $results);
        }
        return $end_res;
    }

    //Should optimize the SQL Query
    public function get_log_book_data($user_id = '')
    {

        if (isset($user_id) && $user_id != null) {
            $this->db->where(array("strack_booking_op_surgeon.op_user_id" => $user_id));
        }
        $status_query = "(
                CASE 
                    WHEN b.booking_status = '0' THEN 'Waiting'
                    WHEN b.booking_status = '1' THEN 'Admission'
                    WHEN b.booking_status = '2' THEN 'Theatre'
                    WHEN b.booking_status = '3' THEN 'Surgery'
                    WHEN b.booking_status = '9' THEN 'Cancelled'
                    WHEN b.booking_status = '99' THEN 'Removed'
                END) AS status_name";

        $this->db->select('pl.patient_id,b.booking_id,folder_number,CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)) as fullname,other_names,surname,dateofbirth,IF(gender = "1","Male","Female") AS gender,'
            . 'theatre_name,surgerydate,date(b.created_on) as bookingdate,booking_date,category_name,surgery_indication,booking_status,b.procedure_id,'
            . 'procedure_name,admission_date,booking_info,insuranceco_name,insurance_number,DATEDIFF( date(b.op_date_start),date(b.booking_date)) as leadtime,'
            . 'operation_done,booked_by,admitted_by,phone,op_role,'
            . 'ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25) as age,firm_name,DATE_ADD(surgerydate,INTERVAL slot_value MINUTE) as end,op_date_start as operationdate,'
            . 'CONCAT(ROUND(time_to_sec((TIMEDIFF(b.op_date_end, b.op_date_start))) / 60)," Min") as surgery_time,'
            . 'surgeon_name,slot_name,ward_name,' . $status_query)
            ->from('strack_booking_op_surgeon');

        $this->db->join('strack_booking b', 'b.booking_id=strack_booking_op_surgeon.booking_id');
        $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
        $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
        $this->db->join('strack_facility_procedures pr', 'b.procedure_id=pr.procedure_id');
        //$this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
        $this->db->join('strack_facility_wards w', 'b.ward_id=w.ward_id', 'LEFT');
        $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_facility_time_slots ts', 'b.slot_id=ts.slot_id', 'LEFT');
        $this->db->join('strack_facility_procedure_categories pc', 'b.category_id=pc.category_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
        $this->db->order_by('b.created_on', 'DECS');
        //if ((isset($status) && $status != null) || $status != '') {
        //    $this->db->where(array("b.booking_status" => $status));
        // }

        $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.isdeleted" => '0'));
        $query = $this->db->get();

        $result = $query->result();
        $end_res = array();
        foreach ($result as $res) {
            $mapt = array();
            $mapt['bookedby'] = $this->get_user_booked_by($res->booked_by);
            $mapt['admittedby'] = $this->get_user_admitted_by($res->admitted_by);

            $results = array_merge((array)$res, $mapt);
            array_push($end_res, $results);
        }
        return $end_res;
    }

    //Should optimize the SQL Query
    public function get_mybooking_data($department_id = '')
    {
        if (isset($department_id) && $department_id != null) {
            $this->db->where(array("strack_department_firms.department_id" => $department_id));
        }
        $this->db->select('pl.patient_id,booking_id,folder_number,CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)) as fullname,other_names,surname,IF(gender = "1","Male","Female") AS gender,'
            . 'dateofbirth,theatre_name,surgerydate,DATE_ADD(surgerydate,INTERVAL slot_value MINUTE), slot_value,'
            . 'procedure_name,admission_date,additional_info,insuranceco_name,insurance_number')
            ->from('strack_booking b');
        $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
        $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
        $this->db->join('strack_facility_procedures pr', 'b.procedure_id=pr.procedure_id');
       // $this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');

        $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.booking_status" => '2'));
        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function get_procedure_summaries($firm_id = '')
    {
        $firm = '';
        $firm .= ' WHERE p.department_id=' . $this->auth_departmentid;

        if (isset($firm_id) && $firm_id != null) {
            $firm .= ' AND  b.firm_id=' . $firm_id;
        }


        $query = $this->db->query("SELECT p.procedure_name,p.procedure_id,c.category_name,COUNT(b.booking_id) as waiting 
                                    FROM strack_facility_procedures p
                                    LEFT JOIN strack_facility_procedure_categories c ON p.category_id =c.category_id
                                    LEFT JOIN strack_booking b ON b.procedure_id =p.`procedure_id` AND  (b.booking_status='0' OR b.booking_status='1')
                                   " . $firm . "
                                    Group BY p.procedure_id
                                    ORDER BY waiting DESC");

        $result = $query->result();
        return $result;
    }

    public function get_facility_procedures_summaries()
    {
        $firm = ' WHERE p.facility_id=' . $this->auth_facilityid;


        $query = $this->db->query("SELECT p.procedure_name,p.procedure_id,c.category_name,COUNT(b.booking_id) as waiting 
                                    FROM strack_facility_procedures p
                                    LEFT JOIN strack_facility_procedure_categories c ON p.category_id =c.category_id
                                    LEFT JOIN strack_booking b ON b.procedure_id =p.`procedure_id` AND  (b.booking_status='0' OR b.booking_status='1')
                                   " . $firm . "
                                    Group BY p.procedure_id
                                    ORDER BY waiting DESC");

        $result = $query->result();
        return $result;
    }


    public function delete_mapt($id)
    {
        $this->db->where('mapt_id', $id);
        $this->db->delete('strack_mapt');
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_mycase_calendar_data($firm_id = "", $department_id = '')
    {

        //$url = URL . 'dashboard/calendar/'; CONCAT("' . $url . '","",booking_id) as url
        $url = base_url() . 'booking/theatrelists/?folder_number=';
        /* if (isset($department_id) && $department_id != null) {
          $this->db->where(array("strack_department_firms.department_id" => $department_id));
          } */

        if (isset($firm_id) && $firm_id != null) {
            $this->db->where(array("b.firm_id" => $firm_id));
        }
        $this->db->select('pl.patient_id,folder_number as description,booking_id as id,surgerydate as start,IF(gender = "1","Male","Female") AS gender,'
            . 'procedure_name as title, firm_color as evtcolor,CONCAT("' . $url . '","",folder_number) as url,DATE_ADD(surgerydate,INTERVAL slot_value MINUTE) as end, slot_value,')
            ->from('strack_booking b');
        $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
        $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
        $this->db->join('strack_facility_procedures pr', 'b.procedure_id=pr.procedure_id');
        //$this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
        $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_facility_time_slots ts', 'b.slot_id=ts.slot_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
        $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.booking_status" => '2'));
        $query = $this->db->get();
        $result = $query->result();
        $datesblocked = $this->get_blocked_surgery_slots();
        $res = array_merge((array)$result, $datesblocked);
        return $res;
    }

    public function get_blocked_surgery_slots()
    {
        $status_query = "(
                CASE 
                    WHEN blocked_type = '0' THEN 'Blocked Day'
                    WHEN blocked_type = '1' THEN 'Special Day'
                END) AS statusname";

        $blocked_color = "(
                CASE 
                    WHEN blocked_type = '0' THEN '#c902b2'
                    WHEN blocked_type = '1' THEN '#a1c901'
                END) AS evtcolor";

        $this->db->select('block_id,blocked_date as start,blocked_enddate as end ,blocked_reason as title, blocked_reason_details as description,department_id,' . $status_query . ',' . $blocked_color)
            ->from('strack_admin_calendar');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_mycase_details($booking_id = '')
    {

        if (isset($booking_id) && $booking_id != null) {
            $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.booking_id" => $booking_id));

            $userquery = "IFNULL(b.surgeon_name, CONCAT(SUBSTRING(users.first_name,1,1),'. ',users.last_name)) AS surgeon_name";

            $this->db->select('pl.patient_id,booking_id,folder_number,surname,other_names,IF(gender = "1","Male","Female") AS gender,'
                . 'dateofbirth,theatre_name,surgerydate,date(b.created_on) as bookingdate,pl.phone,firm_name,duration,slot_value,'
                . 'procedure_name,admission_date,additional_info,insuranceco_name,insurance_number,DATEDIFF( date(Now()),date(b.booking_date)) as leadtime,booked_by,operation_done,'
                . 'ADDTIME(surgerydate, (slot_value*100)) as end, slot_value,language_id,CONCAT(ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25), " Years") as age,'
                . 'ward_name,op_notes,surgery_indication,anethesia_start,anethesia_end,op_date_start,op_date_end,surgeon_uid,b.procedure_id,slot_name,DATE(op_date_start) as operation_date'
                . ',TIMEDIFF(op_date_end,op_date_start) as operation_duration'
                . ',' . $userquery)
                ->from('strack_booking b');
            $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
            $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
            $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
            $this->db->join('strack_facility_wards w', 'b.ward_id=w.ward_id', 'LEFT ');

            $this->db->join('strack_facility_procedures pr', 'b.procedure_id=pr.procedure_id', 'LEFT ');
           // $this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
            $this->db->join('strack_facility_time_slots ts', 'b.slot_id=ts.slot_id', 'LEFT');
            $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
            $this->db->join("users", "b.surgeon_uid=users.user_id", 'LEFT');
            $query = $this->db->get();
            //echo $this->db->last_query();
            $result = $query->row();
            return $result;
        }
    }

    public function get_patient_details_byfolder_number($folder_number = '')
    {

        if (isset($folder_number) && $folder_number != null) {
            $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "pl.folder_number" => $folder_number));

            $this->db->select('IF(gender = "1","Male","Female") AS gender,patient_id,folder_number,surname,other_names,dateofbirth,email,phone,phone2,phone3,'
                . 'additional_info,pl.insuranceco_id,insuranceco_name,insurance_number,pl.firm_id,CONCAT(ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25), " Years") as age')
                ->from('strack_patients_list pl');
            $this->db->join('strack_department_firms', 'pl.firm_id=strack_department_firms.firm_id', 'LEFT');
            $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
            $query = $this->db->get();
            $result = $query->row();
            return $result;
        }
    }

    public function get_patient_id_byfolder_number($folder_number = '')
    {

        if (isset($folder_number) && $folder_number != null) {
            $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "pl.folder_number" => $folder_number));

            $this->db->select('patient_id,folder_number,surname,other_names')
                ->from('strack_patients_list pl');
            $query = $this->db->get();
            $result = $query->row();
            return $result;
        }
    }

    public function get_patient_details($patient_id = '')
    {

        if (isset($patient_id) && $patient_id != null) {
            $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "pl.patient_id" => $patient_id));

            $this->db->select('IF(gender = "1","Male","Female") AS gender,patient_id,folder_number,surname,other_names,dateofbirth,email,phone,phone2,phone3,'
                . 'additional_info,pl.insuranceco_id,insuranceco_name,insurance_number,pl.firm_id,CONCAT(ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25), " Years") as age')
                ->from('strack_patients_list pl');
            $this->db->join('strack_department_firms', 'pl.firm_id=strack_department_firms.firm_id', 'LEFT');
            $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
            $query = $this->db->get();
            $result = $query->row();
            return $result;
        }
    }

    public function get_patient_booking_details($booking_id)
    {
        $this->db->select('b.*,pc.category_name')
            ->from('strack_booking b');
        $this->db->join('strack_facility_procedure_categories pc', 'b.category_id=pc.category_id', 'LEFT');
        $this->db->where(array("b.booking_id" => $booking_id));
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    /*
     * Communication with the Patient
     * Currently We are only sending SMS with General content and SMS Notice on Admission
     * The SMS Module(Series of functionality) should be extended to allow for Feedback from Patients
     */

    public function get_sms_notification($sms_type, $language = '', $surname = '', $admission_date = '', $surgerydate = '')
    {

        $sms = $this->prepare_sms($sms_type, $language, $surname, $admission_date, $surgerydate);
        return $sms;
    }

    /*
     * Compose the SMS text based patient's details
     */

    private function prepare_sms($smstemplate, $language = '', $surname, $admission_date = '', $surgerydate = "")
    {
        $date = date('d-m-Y H:i:s', strtotime("now"));
        if (isset($language) && $language != null) {
            $this->db->where('language_id', $language);
        } else {
            $this->db->where('language_id', 1);
        }
        $this->db->where(array('sms_type' => $smstemplate));
        $q = $this->db->get('strack_sms_templates');
        if ($q->num_rows() > 0) {

            $temp = $q->row()->template_text;
            $temp = str_replace("<<surname>>", $surname, $temp);
            $temp = str_replace("<<admission_date>>.", $admission_date, $temp);
            $temp = str_replace("<<surgery_date>>", $surgerydate, $temp);

            $smstemplate = strip_tags($temp);

            return $smstemplate;
        } else {
            return (object)NULL;
        }
    }

    /*
     * GENERAL METHODS/FUNCTIONS
     *
     */

    public function get_patient_id_by($booking_id)
    {
        $this->db->select('patient_id')
            ->from('strack_booking b');
        $this->db->where(array("b.booking_id" => $booking_id));
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function back_to_admission($id)
    {
        $data = array('booking_status' => '1');
        $this->db->where(array("booking_id" => $id));
        $this->db->update('strack_booking b', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function return_to_waiting($id)
    {
        $data = array('booking_status' => '0');
        $this->db->where(array("booking_id" => $id));
        $this->db->update('strack_booking b', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function remove_booking($id)
    {
        $data = array('booking_status' => '99');
        $this->db->where(array("booking_id" => $id));
        $this->db->update('strack_booking b', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    /*
     *
     *
     *
     */

    public function get_theatre_list($opt, $opt_val, $surgdate)
    {
        $theatrelist = $this->get_theatre_list_data('2', $opt, $opt_val, $surgdate);
        $theatrename = ($opt == 'theatre') ? $this->get_theatre_name($opt_val) : "";


        $theatre = '<br><br><hr><br><br>';
        $theatre .= '<table border="0.5" cellpadding="2" cellspacing="1" width="100%" class="display projects-table table table-striped table-bordered table-hover" width="100%">
                        <thead>
                            <tr style="background-color:#FFFF00;color:#0000FF;">
                                <th width="20%"><b>Patient Name</b></th>
                                <th width="20%" data-class="expand"><b>Folder</b></th> 
                                <th width="5%" data-hide="expand"><b>Gender</b></th>
                                <th width="5%" data-hide="expand"><b>Age(Yrs)</b></th> 
                                <th width="20%" data-hide="expand"><b>Operation</b></th>
                                <th width="10%" data-hide="expand"><b>Time</b></th>
                                <th width="10%" data-hide="expand"><b>Ward</b></th>
                                <th width="10%" data-hide="expand"><b>Firm</b></th>
                            </tr>
                        </thead>';
        foreach ($theatrelist as $booking) {
            $theatre .= '<tr>
                            <td width="20%">' . $booking->fullname . '</td>
                            <td width="20%">' . $booking->folder_number . '</td> 
                            <td width="5%">' . $booking->gender . '</td>
                            <td width="5%">' . $booking->age . '</td> 
                            <td width="20%">' . $booking->procedure_name . '</td>
                            <td width="10%">' . $booking->slot_name . '</td>
                                <td width="10%">' . $booking->ward_name . '</td>
                            <td width="10%">' . $booking->firm_name . '</td>
                        </tr>';
            if (!in_array($booking->theatre_name, $surgeons)) {
                $surgeons[] = $booking->theatre_name;
            }

            //if (!in_array($booking->firm_name, $firms)) {
            //    $firms[] = $booking->firm_name;
            //}
        }
        $theatre .= ' </table>';


        $header = '<table border="1" cellpadding="2" cellspacing="1" width="100%" >
                        <thead>
                         <tr >
                          <td width="50%" ><b>SURGEON(s)</b>' . implode(', ', $surgeons) . '</td>
                          <td width="50%" > <b>DATE:</b>' . $surgdate . ' </td> 
                         </tr>
                         <tr >
                          <td width="50%" ><b>THEATRE:</b> ' . $theatrename . '</td>
                          <td width="50%" > <b>TIME: </b></td> 
                         </tr>
                        </thead>

                        </table>';

        return $header . $theatre;
    }

    public function get_case_log_list($opt, $opt_val)
    {
        $theatrelist = $this->get_theatre_list_data('3', $opt, $opt_val);
        $theatrename = ($opt == 'theatre') ? $this->get_theatre_name($opt_val) : "";

        $theatre = '<table border="1" cellpadding="2" cellspacing="1" width="100%" >
                        <thead>
                         <tr >
                          <td width="50%" ><b>SURGEON(s)</b></td>
                          <td width="50%" > <b>DATE:</b> </td> 
                         </tr>
                         <tr >
                          <td width="50%" ><b>THEATRE:</b> ' . $theatrename . '</td>
                          <td width="50%" > <b>TIME: </b></td> 
                         </tr>
                        </thead>

                        </table>';
        $theatre .= '<br><br><hr><br><br>';
        $theatre .= '<table border="0.5" cellpadding="2" cellspacing="1" width="100%" class="display projects-table table table-striped table-bordered table-hover" width="100%">
                        <thead>
                            <tr style="background-color:#FFFF00;color:#0000FF;">
                                <th width="20%"><b>Patient Name</b></th>
                                <th width="10%" data-class="expand"><b>Folder</b></th> 
                                <th width="5%" data-hide="expand"><b>Gender</b></th>
                                <th width="5%" data-hide="expand"><b>Age(Yrs)</b></th> 
                                <th width="20%" data-hide="expand"><b>Operation</b></th>
                                <th width="10%" data-hide="expand"><b>Operation Date</b></th>
                                <th width="10%" data-hide="expand"><b>Time</b></th>
                                <th width="10%" data-hide="expand"><b>PostOP Bed</b></th>
                                <th width="10%" data-hide="expand"><b>Firm</b></th>
                            </tr>
                        </thead>';
        foreach ($theatrelist as $booking) {
            $theatre .= '<tr>
                            <td width="20%">' . $booking->fullname . '</td>
                            <td width="10%">' . $booking->folder_number . '</td> 
                            <td width="5%">' . $booking->gender . '</td>
                            <td width="5%">' . $booking->age . '</td> 
                            <td width="20%">' . $booking->op_procedure_name . '</td>
                            <td width="10%">' . $booking->op_date_start . '</td>
                            <td width="10%">' . $booking->duration . '</td>
                            <td width="10%">' . $booking->postopbed . '</td>
                            <td width="10%">' . $booking->firm_name . '</td>
                        </tr>';
        }
        $theatre .= ' </table>';
        return $theatre;
    }

    public function get_full_theatre_list()
    {
        $theatrelist = $this->get_theatre_list_data('2');

        $theatre = '<br><br><hr><br><br>';
        $theatre .= '<table border="0.5" cellpadding="2" cellspacing="1" width="100%" class="display projects-table table table-striped table-bordered table-hover" width="100%">
                        <thead>
                            <tr style="background-color:#FFFF00;color:#0000FF;">
                                <th width="20%"><b>Patient Name</b></th>
                                <th width="15%" data-class="expand"><b>Folder</b></th> 
                                <th width="5%" data-hide="expand"><b>Gender</b></th>
                                <th width="8%" data-hide="expand"><b>Age(Yrs)</b></th> 
                                <th width="12%" data-hide="expand"><b>Operation</b></th>
                                <th width="10%" data-hide="expand"><b>Time</b></th>
                                <th width="10%" data-hide="expand"><b>Theatre</b></th>
                                <th width="10%" data-hide="expand"><b>Ward</b></th>
                                
                                <th width="10%" data-hide="expand"><b>Firm</b></th>
                            </tr>
                        </thead>';
        foreach ($theatrelist as $booking) {
            $theatre .= '<tr>
                            <td width="20%">' . $booking->fullname . '</td>
                            <td width="15%">' . $booking->folder_number . '</td> 
                            <td width="5%">' . $booking->gender . '</td>
                            <td width="8%">' . $booking->age . '</td> 
                            <td width="12%">' . $booking->procedure_name . '</td>
                            <td width="10%">' . $booking->slot_name . '</td>
                            <td width="10%">' . $booking->theatre_name . '</td>
                                <td width="10%">' . $booking->ward_name . '</td>
                            <td width="10%">' . $booking->firm_name . '</td>
                        </tr>';

            if (!in_array($booking->theatre_name, $surgeons)) {
                $surgeons[] = $booking->theatre_name;
            }

            //if (!in_array($booking->firm_name, $firms)) {
            //    $firms[] = $booking->firm_name;
            //}
        }
        $theatre .= ' </table>';

        $header = '<table border="1" cellpadding="2" cellspacing="1" width="100%" >
                        <thead>
                         <tr >
                          <td width="50%" ><b>SURGEON(s)</b>' . implode(', ', $surgeons) . '</td>
                          <td width="50%" > <b>DATE:</b>' . date('Y-m-d') . ' </td> 
                         </tr>
                         
                        </thead>

                        </table>';

        return $header . $theatre;
    }

    public function get_theatre_list_data($status = '', $opt = '', $opt_val = '', $surgdate = '', $opt_val2 = '', $opt_val3 = '')
    {
        if (isset($opt) && $opt != null) {
            if ($opt == 'firm') {
                $this->db->where(array("b.firm_id" => $opt_val));
            } elseif ($opt == 'theatre') {
                $this->db->where(array("b.theatre_id" => $opt_val));
            } elseif ($opt == 'procedure') {
                $this->db->where(array("b.procedure_id" => $opt_val));
            } elseif ($opt == 'admissiondate') {
                $this->db->where(array("b.admission_date" => $opt_val));
            } elseif ($opt == 'multi') {
                $where = " b.admission_date BETWEEN '" . $opt_val . "' AND '" . $opt_val3 . "'";
                //$this->db->where(array("b.admission_date" => $opt_val));
                $this->db->where($where);
                $firms = explode(',', $opt_val2);
                $where = "(";
                $i = 0;
                foreach ($firms as $my_Array) {
                    $i++;
                    if ($i == 1) {
                        $where .= " b.firm_id =" . $my_Array;
                    } else {
                        $where .= " OR b.firm_id=" . $my_Array;
                    }
                }
                $where .= ")";
                $this->db->where($where);
            }
        }
        if (isset($surgdate) && $surgdate != null && $surgdate != '') {
            $this->db->where(array("date(b.surgerydate)" => $surgdate));
        }

        //else {
        //    $this->db->where(array("date(b.surgerydate)=date(NOW())"));
        //}
        $status_query = "(
                CASE 
                    WHEN b.booking_status = '0' THEN 'Waiting'
                    WHEN b.booking_status = '1' THEN 'Admission'
                    WHEN b.booking_status = '2' THEN 'Theatre'
                    WHEN b.booking_status = '3' THEN 'Surgery'
                    WHEN b.booking_status = '99' THEN 'Cancelled'
                END) AS status_name";

        $this->db->select('pl.patient_id,booking_id,folder_number,'
            . 'CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)," ",SUBSTRING(SUBSTRING_INDEX(other_names, " ", -1),1,1)) as fullname,other_names,surname,dateofbirth,IF(gender = "1","Male","Female") AS gender,'
            . 'theatre_name,surgerydate,date(b.created_on) as bookingdate,booking_date,category_name,surgery_indication,booking_status,'
            . 'bproc.procedure_name,admission_date,booking_info,insuranceco_name,insurance_number,DATEDIFF( date(Now()),date(b.booking_date)) as leadtime,booked_by,'
            . 'CONCAT(users.first_name," ",users.last_name) AS bookedby,oproc.procedure_name as op_procedure_name,op_notes,op_date_start,op_date_end,op_recorded_by,op_recorded_on,surgeon_name,duration,'
            . 'postopbed,anesthesia,'
            . 'ROUND(DATEDIFF(date(Now()), date(dateofbirth))/365.25) as age,firm_name,DATE_ADD(surgerydate,INTERVAL slot_value MINUTE) as end,'
            . 'slot_name,ward_name,' . $status_query)
            ->from('strack_booking b');
        $this->db->join('strack_patients_list pl', 'b.patient_id=pl.patient_id');
        $this->db->join('strack_facility_theatres t', 'b.theatre_id=t.theatre_id');
        $this->db->join('strack_facility_procedures bproc', 'b.procedure_id=bproc.procedure_id', 'LEFT');
        $this->db->join('strack_facility_procedures oproc', 'b.op_procedure=oproc.procedure_id', 'LEFT');
        //$this->db->join('strack_priorities', 'b.priority_id=strack_priorities.priority_id', 'LEFT');
        $this->db->join('strack_facility_wards w', 'b.ward_id=w.ward_id', 'LEFT');
        $this->db->join('strack_department_firms', 'b.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_facility_time_slots ts', 'b.slot_id=ts.slot_id', 'LEFT');
        $this->db->join('strack_facility_procedure_categories pc', 'b.category_id=pc.category_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'pl.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');
        $this->db->join("users", "b.booked_by=users.user_id");
        $this->db->order_by('b.created_on', 'DECS');
        if ((isset($status) && $status != null) || $status != '') {
            $this->db->where(array("b.booking_status" => $status));
        }
        $this->db->where(array('pl.facility_id' => $this->auth_facilityid, "b.isdeleted" => '0'));
        $query = $this->db->get();
        //echo ($this->db->last_query());
        $result = $query->result();
        return $result;
    }

    public function get_waiting_list($opt = '', $opt_val = '')
    {
        $theatrelist = $this->get_theatre_list_data('0', $opt, $opt_val);
        $theatrename = ($opt == 'theatre') ? $this->get_theatre_name($opt_val) : "";

        $theatre = '<table border="1" cellpadding="2" cellspacing="1" width="100%" >
                        <thead>
                         <tr >
                          <td width="50%" ><b>SURGEON(s)</b></td>
                          <td width="50%" >  </td> 
                         </tr>
                         <tr >
                          <td width="50%" ><b>THEATRE:</b> ' . $theatrename . '</td>
                          <td width="50%" > </td> 
                         </tr>
                        </thead>

                        </table>';
        $theatre .= '<br><br>'
            . 'Created on :' . date('Y-m-d H:i:s')
            . '<hr><br><br>';
        $theatre .= '<table border="0.5" cellpadding="2" cellspacing="1" width="100%" class="display projects-table table table-striped table-bordered table-hover" width="100%">
                        <thead>
                            <tr style="background-color:#FFFF00;color:#0000FF;">
                                <th width="20%"><b>Patient Name</b></th>
                                <th width="15%" data-class="expand"><b>Folder</b></th> 
                                <th width="5%" data-hide="expand"><b>Gender</b></th>
                                <th width="5%" data-hide="expand"><b>Age(Yrs)</b></th> 
                                <th width="20%" data-hide="expand"><b>Operation</b></th>
                                <th width="10%" data-hide="expand"><b>Time</b></th>
                                <th width="10%" data-hide="expand"><b>Lead Time(Days)</b></th>
                                <th width="15%" data-hide="expand"><b>Firm</b></th>
                            </tr>
                        </thead>';
        foreach ($theatrelist as $booking) {
            $theatre .= '<tr>
                            <td width="20%">' . $booking->fullname . '</td>
                            <td width="15%">' . $booking->folder_number . '</td> 
                            <td width="5%">' . $booking->gender . '</td>
                            <td width="5%">' . $booking->age . '</td> 
                            <td width="20%">' . $booking->procedure_name . '</td>
                            <td width="10%">' . $booking->slot_name . '</td>
                                <td width="10%">' . $booking->leadtime . '</td>
                            <td width="15%">' . $booking->firm_name . '</td>
                        </tr>';
        }
        $theatre .= ' </table>';
        return $theatre;
    }

    public function get_admission_list($opt = '', $opt_val = '', $opt_val2 = '', $opt_val3 = '')
    {
        $theatrelist = $this->get_theatre_list_data('1', $opt, $opt_val, '', $opt_val2, $opt_val3);
        $theatrename = ($opt == 'theatre') ? $this->get_theatre_name($opt_val) : "";


        $theatre = '<br><br>'
            . 'Created on :' . date('Y-m-d H:i:s')
            . '<hr><br><br>';
        $theatre .= '<table border="0.5" cellpadding="2" cellspacing="1" width="100%" class="display projects-table table table-striped table-bordered table-hover" width="100%">
                        <thead>
                            <tr style="background-color:#FFFF00;color:#0000FF;">
                                <th width="15%"><b>Patient Name</b></th>
                                <th width="10%" data-class="expand"><b>Folder</b></th> 
                                <th width="5%" data-hide="expand"><b>Gender</b></th>
                                <th width="5%" data-hide="expand"><b>Age(Yrs)</b></th> 
                                <th width="15%" data-hide="expand"><b>Procedure</b></th>
                                <th width="5%" data-hide="expand"><b>Lead Time(Days)</b></th>
                                <th width="10%" data-hide="expand" >Admission date</th>
                                <th width="10%" data-hide="expand">Indication</th>
                                <th width="13%" data-class="expand">Theatre</th>
                                <th width="12%" data-hide="expand"><b>Firm</b></th>
                            </tr>
                        </thead>';
        $theatres = array();
        $firms = array();
        foreach ($theatrelist as $booking) {
            $theatre .= '<tr>
                            <td width="15%">' . $booking->fullname . '</td>
                            <td width="10%">' . $booking->folder_number . '</td> 
                            <td width="5%">' . $booking->gender . '</td>
                            <td width="5%">' . $booking->age . '</td> 
                            <td width="15%">' . $booking->procedure_name . '</td>
                            <td width="5%">' . $booking->leadtime . '</td>
                            <td width="10%">' . $booking->admission_date . '</td>
                            <td width="10%">' . $booking->surgery_indication . '</td>
                            <td width="13%">' . $booking->theatre_name . '</td>
                            <td width="12%">' . $booking->firm_name . '</td>
                        </tr>';
            if (!in_array($booking->theatre_name, $theatres)) {
                $theatres[] = $booking->theatre_name;
            }

            if (!in_array($booking->firm_name, $firms)) {
                $firms[] = $booking->firm_name;
            }
        }
        $theatre .= ' </table>';
        $header = '<table border="1" cellpadding="2" cellspacing="1" width="100%" >
                        <thead>
                         <tr >
                          <td width="50%" ><b>FIRM(s)</b></td>
                          <td width="50%" > ' . implode(', ', $firms) . ' </td> 
                         </tr>
                         <tr >
                          <td width="50%" ><b>THEATRE:</b> </td>
                          <td width="50%" > ' . implode(', ', $theatres) . '</td> 
                         </tr>
                        </thead>

                        </table>';
        return $header . $theatre;
    }

    public function get_theatre_name($id)
    {
        $this->db->where("theatre_id", $id);
        $q = $this->db->get('strack_facility_theatres t');
        //echo $this->db->last_query();
        if ($q->num_rows() > 0) {
            return $q->row()->theatre_name;
        }
        return false;
    }

    public function get_firms_name($id)
    {
        $this->db->where("firm_id", $id);
        $q = $this->db->get('strack_department_firms');
        if ($q->num_rows() > 0) {
            return $q->row()->firm_name;
        }
        return false;
    }

    public function get_patient_log($patient_id)
    {
        $this->db->select('CONCAT("<b>",first_name,"</b>"," ",last_name) as user_name,'
            . 'log_action as action,log_info as logdetails,log_date_time  as logtime,log_type')
            ->from('strack_patient_log');
        $this->db->join('users', 'strack_patient_log.user_id=users.user_id');
        if ((isset($patient_id) && $patient_id != null) || $patient_id != '') {
            $this->db->where(array("strack_patient_log.patient_id" => $patient_id));
        }
        //$this->db->where(array('pl.facility_id' => $this->auth_facilityid));

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function check_patient_exist($folder_number)
    {
        $this->db->where("folder_number", $folder_number);
        $this->db->select('*')
            ->from('strack_patients_list pl');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function save_opnotes_name($booking_id, $data)
    {
        $this->db->where('booking_id', $booking_id);
        $this->db->update('strack_booking b', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_opnotesfile_name($booking_id)
    {
        $this->db->where('booking_id', $booking_id);
        $this->db->select('opnotes_file_name,opnotes_dropbox_folder')
            ->from('strack_booking b');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function get_dropbox_folder_structure($booking_id)
    {
        $this->db->where('booking_id', $booking_id);
        $this->db->select('CONCAT("/",facility_name,"/",department_name,"/",firm_name)   as folder_name')
            ->from('strack_booking b')
            ->join('strack_department_firms', 'strack_department_firms.firm_id=b.firm_id', 'LEFT')
            ->join('strack_departments', 'strack_departments.department_id=strack_department_firms.department_id', 'LEFT')
            ->join('strack_facilities', 'strack_facilities.facility_id=strack_departments.facility_id', 'LEFT');
        $query = $this->db->get();
        $result = preg_replace('/\s+/', '', $query->row()->folder_name);
        return $result;
    }

    public function patients_booking_summary($booking_id)
    {
        $patient_details = $this->get_mycase_details($booking_id);
        $return = '<table width="100%" class="table">';
        $return .= '<tr class="success">'
            . '<th width="15%">Booked Procedure:</th><td width="30%">' . $patient_details->procedure_name . '</td> <th width="15%">Admission Date:</th><td width="15%">' . $patient_details->admission_date . '</td> <th width="15%">Lead Time(DAYS):</th><td width="15%">' . $patient_details->leadtime . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th>Theatre:</th><td>' . $patient_details->theatre_name . '</td> <th>Firm:</th><td>' . $patient_details->firm_name . '</td> <th>Duration:</th><td>' . $patient_details->slot_name . '</td>'
            . '</tr>'
            . '</table>';


        return $return;
    }

    public function patients_opnotes_summary($booking_id)
    {
        $patient_details = $this->get_mycase_details($booking_id);
        $return = '<table width="100%" class="table">';
        $return .= '<tr class="success">'
            . '<th width="15%">Booked Procedure:</th><td width="15%">' . $patient_details->procedure_name . '</td> <th>Theatre:</th><td>' . $patient_details->theatre_name . '</td><th width="15%">Operation Date:</th><td width="15%">' . $patient_details->operation_date . '</td> '
            . '</tr>'
            . '<tr class="danger">'
            . '<th width="15%">Operation Done</th><td width="15%">' . $patient_details->operation_done . '</td> <th>Firm:</th><td>' . $patient_details->firm_name . '</td> <th>Operation Duration:</th><td>' . $patient_details->operation_duration . '</td>'
            . '</tr>'
            . '</table>';


        return $return;
    }

    public function coding_booking_procedure_insert($data)
    {
        $this->db->insert('strack_booking_procedures_done', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_booking_procedure($procedure_id, $booking_id)
    {
        $this->db->where(array('procedure_id' => $procedure_id, 'booking_id' => $booking_id));
        $this->db->delete('strack_booking_procedures_done');
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function remove_unused_consumable($booking_consumable_id)
    {
        $this->db->where(array('booking_consumable_id' => $booking_consumable_id));
        $this->db->delete('strack_booking_consumables');
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_rpl_procedure_consumable($booking_id)
    {
        $this->db->where(array("bc.booking_id" => $booking_id));
        $this->db->select('c.*,bc.price,bc.quantity,bc.booking_consumable_id')
            ->from('strack_booking_consumables bc');
        $this->db->join('strack_nappi_consumables c', 'c.consumable_id=bc.consumable_id');
        $query = $this->db->get();
        $result = $query->result();

        $return = '<thead>
                        <tr>
                            <th style="width:20%">Nappi Code</th>
                            <th style="width:35%">Consumable Name</th>                                            
                            <th style="width:20%">Unit Price</th>
                            <th style="width:15%">Quantity</th>
                            <th style="width:10%"></th>
                        </tr>

                    </thead>';
        $i = 0;
        foreach ($result as $key) {
            $i++;
            $return .= '<tr>';
            $return .= '<td>' . $key->nappi_code . '</td>';
            $return .= '<td>' . $key->product_name . '</td>';
            $return .= '<td> <input type="hidden" name="options[' . $i . '][booking_consumable_id]" id="booking_consumable_id" value="' . $key->booking_consumable_id . '" >'
                . '<input type="text" name="options[' . $i . '][price]" id="price" value="' . $key->price . '" ></td>';
            $return .= '<td ><input type="text" name="options[' . $i . '][quantity]" id="quantity" value="' . $key->quantity . '"  placeholder="Add Quantity"></td>';
            $return .= '<td><a href="#" onclick="remove_unused_consumable(\'' . $key->booking_consumable_id . '\',\'' . $booking_id . '\')"  class=" btn btn-danger btn-xs rounded" title="Remove" ><i class="fa fa-minus"></i></a></td>';
            $return .= '</tr>';
        }
        return $return;
    }

    public function get_booking_consumable($booking_id)
    {
        $this->db->where(array("bc.booking_id" => $booking_id));
        $this->db->select('c.*,bc.price,bc.quantity,bc.booking_consumable_id')
            ->from('strack_booking_consumables bc');
        $this->db->join('strack_nappi_consumables c', 'c.consumable_id=bc.consumable_id');
        $query = $this->db->get();
        $result = $query->result();

        $return = '<table  style="width:100%" cellspacing="0" cellpadding="1" border="1" > 
            <thead>
                        <tr>
                            <th style="width:5%"><b>#</b></th>
                            <th style="width:15%"><b>Nappi Code</b></th>
                            <th style="width:35%"><b>Consumable Name</b></th>                                            
                            <th style="width:20%" align="right"><b>Unit Price</b></th>
                            <th style="width:15%"><b>Quantity</b></th>
                            <th style="width:10%"align="right"><b>Total</b></th>
                        </tr>

                    </thead>';
        $i = 0;
        $totals = 0;
        foreach ($result as $key) {
            $i++;
            $total = $key->quantity * $key->price;
            $totals += $total;
            $return .= '<tr>';
            $return .= '<td style="width:5%">' . $i . '</td>';
            $return .= '<td style="width:15%">' . $key->nappi_code . '</td>';
            $return .= '<td style="width:35%">' . $key->product_name . '</td>';
            $return .= '<td style="width:20%" align="right"> ' . number_format($key->price, 2) . ' </td>';
            $return .= '<td style="width:15%">' . $key->quantity . '</td>';
            $return .= '<td style="width:10%" align="right">' . number_format($total, 2) . '</td>';
            $return .= '</tr>';
        }
        $return .= '<tr>';
        $return .= '<td style="width:90%" colspan="5"><b>TOTALS</b></td>';
        $return .= '<td style="width:10%" align="right"><b>' . number_format($totals, 2) . '</b></td>';
        $return .= '</tr>';
        $return .= '</table>';
        return $return;
    }

    public function get_procedure_consumables($procedure_id)
    {
        $this->db->where(array("p.procedure_id" => $procedure_id));
        $this->db->select('n.id,c.*')
            ->from('strack_rpl_consumables n');
        $this->db->join('strack_nappi_consumables c', 'c.consumable_id=n.consumable_id');
        $this->db->join('strack_rpl_procedure_codes p', 'p.rpl_id=n.rpl_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function add_procedure_consumables($data)
    {
        $this->db->insert('strack_booking_consumables', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function checkif_booking_has_thisconsumables($booking_id, $consumable_id)
    {
        $this->db->where(array("booking_id" => $booking_id, 'consumable_id' => $consumable_id));
        $this->db->select('*')
            ->from('strack_booking_consumables');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function update_booking_consumables($data, $booking_id, $consumable_id)
    {
        $this->db->where(array("booking_id" => $booking_id, 'booking_consumable_id' => $consumable_id));
        $this->db->update('strack_booking_consumables', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

}
