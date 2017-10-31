<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 03/10/2017
 * Time: 20:16
 */

class Patients_model extends MY_Model
{
    function __construct() {
        parent::__construct();
    }

    public function patient_insert($data) {
        $this->db->insert('strack_patients_list', $data);
        return $this->db->insert_id();
    }

    public function patient_update($data, $id) {
        $this->db->where('patient_id', $id);
        $this->db->update('strack_patients_list', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_patient_details($id) {
        $this->db->where("patient_id", $id);
        $this->db->select('strack_patients_list.*,ROUND(DATEDIFF(date(Now()),date(dateofbirth))/365.25) as age,b.suburb_name,b.suburb_id,b.latitude,b.longitude,time_to_hospital,distance_km')
            ->from('strack_patients_list');
        $this->db->join('strack_suburbs b', 'strack_patients_list.suburb_id=b.suburb_id', 'LEFT');
        $this->db->where(array('isdeleted' => '0'));
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_patient_details_by_booking($id) {
        $this->db->where("b.booking_id", $id);
        $this->db->select('p.*,b.procedure_id,b.operation_done,b.booking_id')
            ->from('strack_patients_list p');
        $this->db->join('strack_booking b', 'b.patient_id=p.patient_id');
        $this->db->where(array('p.isdeleted' => '0'));
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_patient_list_data($user_id = '') {
        if (isset($user_id) && $user_id != null) {
            $this->db->where(array("p.created_by" => $user_id));
        }
        $this->db->where(array('p.facility_id'=>$this->auth_facilityid,'p.isdeleted' => '0'));
        $this->db->select('IF(gender = "1","Male","Female") AS gender,patient_id,folder_number,CONCAT("<b>",surname,"</b>",", ",other_names) as fullname,other_names,surname,dateofbirth,email,phone,phone2,phone3,'
            . 'additional_info,insuranceco_name,insurance_number')
            ->from('strack_patients_list p');
        $this->db->join('strack_department_firms f', 'p.firm_id=f.firm_id', 'LEFT');
        $this->db->join('strack_insurance_companies in', 'p.insuranceco_id=in.insuranceco_id', 'LEFT');
        $this->db->order_by('p.created_on', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //Patient's search function needs to be Extended and Optimized for good performance
    public function get_patients_by_search_phrase($search_phrase, $firm = "") {//Intended for search by Folder Number
        $this->db->or_like('folder_number', $search_phrase);
        $this->db->where(array('strack_patients_list.isdeleted' => '0'));
        $this->db->select('IF(gender = "1","Male","Female") AS gender,patient_id,folder_number,CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)) as fullname,other_names,surname,,dateofbirth,email,phone,phone2,phone3,'
            . 'additional_info,strack_patients_list.insuranceco_id,insuranceco_name,insurance_number,strack_patients_list.firm_id')
            ->from('strack_patients_list');
        $this->db->join('strack_department_firms', 'strack_patients_list.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'strack_patients_list.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function general_patients_by_search_phrase($search_phrase) {
        $this->db->or_like('folder_number', $search_phrase);
        $this->db->or_like('surname', $search_phrase);
        $this->db->or_like('phone', $search_phrase);
        $this->db->or_like('other_names', $search_phrase);
        $this->db->or_like('email', $search_phrase);
        //$this->db->or_like('strack_patients_list.firm_id', $firm);
        $this->db->where(array('strack_patients_list.isdeleted' => '0'));
        $this->db->select('IF(gender = "1","Male","Female") AS gender,patient_id,folder_number,CONCAT("<b>",surname,"</b>"," ",SUBSTRING(other_names,1,1)) as fullname,other_names,surname,,dateofbirth,email,phone,phone2,phone3,'
            . 'additional_info,strack_patients_list.insuranceco_id,insuranceco_name,insurance_number,strack_patients_list.firm_id')
            ->from('strack_patients_list');
        $this->db->join('strack_department_firms', 'strack_patients_list.firm_id=strack_department_firms.firm_id', 'LEFT');
        $this->db->join('strack_insurance_companies', 'strack_patients_list.insuranceco_id=strack_insurance_companies.insuranceco_id', 'LEFT');

        $query = $this->db->get();
        $result = $query->result();

        return $result;
    }

    public function delete_patient($id) {
        $this->delete_patient_bookings($id);
        $query = 'UPDATE strack_patients_list SET isdeleted="1", folder_number=CONCAT(folder_number,"_0") WHERE patient_id = ' . $id;
        //$this->db->update('strack_patients_list', array('isdeleted' => '1', 'folder_number' => 'CONCAT(folder_number,"_0")' ), array('patient_id' => $id));
        $this->db->query($query);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_booking($id) {
        $this->db->update('strack_booking', array('isdeleted' => '1'), array('booking_id' => $id));
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_patient_bookings($id) {
        $this->db->where("patient_id", $id);
        $this->db->select('booking_id')
            ->from('strack_booking');
        $query = $this->db->get();
        $result = $query->result();
        foreach ($result as $val) {
            $this->delete_booking($val->booking_id);
        }
        return false;
    }

}