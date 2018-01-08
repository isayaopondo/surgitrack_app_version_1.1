<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Settings_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    /*
     * Multi-tenancy Adjustments
     *
     *
     */
    //===================================
    //       Procedures
    //===================================


    public function get_facility_procedure($facility_id = '', $group = '', $sub_group = '')
    {
        if (isset($group) && $group != null) {
            $this->db->where('p.group_id', $group);
        } elseif (isset($sub_group) && $sub_group != null) {
            $this->db->where('p.subgroup_id', $sub_group);
        }

//        if (isset($facility_id) && $facility_id != null) {
//            $this->db->where('p.facility_id', $facility_id);
//        }
        $this->db->where(array('p.facility_id' => $this->auth_facilityid, 'p.isdeleted' => '1'));
        $this->db->select('*')
            ->from('strack_facility_procedures p')
            ->join('strack_departments d ', 'd.department_id=p.department_id', 'LEFT')
            ->join('strack_facility_procedure_groups pg ', 'pg.group_id=p.group_id', 'LEFT')
            ->join('strack_facility_procedure_categories pc', 'pc.category_id=p.category_id', 'LEFT')
            ->join('strack_facility_procedure_subgroups psg', 'p.subgroup_id=psg.subgroup_id', 'LEFT');

        $this->db->order_by("p.rpl_code", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }


    public function get_procedure($facility_id = '', $group = '', $sub_group = '')
    {


        if (isset($group) && $group != null) {
            $this->db->where('p.group_id', $group);
        } elseif (isset($sub_group) && $sub_group != null) {
            $this->db->where('p.subgroup_id', $sub_group);
        }
        $this->db->where(array('p.facility_id' => $this->auth_facilityid, 'p.isdeleted' => '1'));
        $this->db->select('*')
            ->from('strack_facility_procedures p');
           // ->join('strack_facility_procedure_groups pg', 'pg.group_id=p.group_id', 'LEFT')
           // ->join('strack_facility_procedure_categories c', 'c.category_id=p.category_id', 'LEFT')
           // ->join('strack_facility_procedure_subgroups psg', 'psg.subgroup_id=p.subgroup_id', 'LEFT');

        $this->db->order_by("procedure_name", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_rplprocedures($facility_id = '')
    {
//        if (isset($facility_id) && $facility_id != null) {
//            $this->db->where('p.facility_id', $facility_id);
//        }
        $this->db->where(array('p.facility_id' => $this->auth_facilityid, 'p.isdeleted' => '1'));
        $this->db->select('p.*,c.rpl_code')
            ->from('strack_facility_procedures p')
            ->join('strack_rpl_procedure_codes c', 'c.procedure_id=p.procedure_id', 'LEFT');
        $this->db->order_by("c.rpl_code", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_booking_rplprocedures($booking_id)
    {

        $this->db->where(array('p.isdeleted' => '1', 'pc.booking_id' => $booking_id));
        $this->db->select('p.*,c.rpl_code,c.service_fee')
            ->from('strack_facility_procedures p')
            ->join('strack_rpl_procedure_codes c', 'c.procedure_id=p.procedure_id', 'LEFT')
            ->join('strack_booking_procedures_done pc', 'pc.procedure_id=p.procedure_id', 'LEFT');
        $this->db->order_by("c.rpl_code", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_procedure_by_id($id)
    {
        $this->db->where(array('p.isdeleted' => '1'));
        $this->db->where("procedure_id", $id);
        $this->db->select('*')
            ->from('strack_facility_procedures p')
            ->join('strack_facility_procedure_categories c', 'c.category_id=p.category_id', 'LEFT');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function ajaxget_category_by_procedureid($id)
    {
        $this->db->where("p.procedure_id", $id);
        $this->db->where(array('p.isdeleted' => '1'));
        $this->db->select('*')
            ->from('strack_facility_procedures p')
            ->join('strack_facility_procedure_categories c', 'c.category_id=p.category_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function ajaxget_by_procedure_groups($id)
    {
        if ($id != '0') {
            $this->db->where("p.group_id", $id);
        }
        $this->db->select('*')
            ->from('strack_facility_procedures p');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_procedure_list()
    {
        $this->db->where(array('p.facility_id' => $this->auth_facilityid, 'p.isdeleted' => '1'));
        $this->db->select('procedure_id,procedure_name, procedure_description');
        $this->db->order_by("procedure_name", "asc");
        $this->db->from('strack_facility_procedures p')
            ->join('strack_facility_procedure_categories c', 'c.category_id=p.category_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function procedure_insert($data)
    {

        $this->db->insert('strack_facility_procedures', $data);
    }

    public function procedure_update($data, $id)
    {
        $this->db->where('procedure_id', $id);
        $this->db->update('strack_facility_procedures', $data);
    }

    function delete_procedure($id)
    {
        $this->db->where("procedure_id", $id);
        $q = $this->db->get('strack_booking');
        if ($q->num_rows() > 0) {
            return false;
        } else {
            $this->db->delete('strack_facility_procedures', array('procedure_id' => $id));
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function procedure_department_insert($data, $procedure_id, $department_id)
    {

        $this->db->where(array('procedure_id' => $procedure_id, 'department_id' => $department_id));
        $q = $this->db->get('strack_facility_procedures');
        if ($q->num_rows() > 0) {
            $this->db->update('strack_facility_procedures', array('isdeleted' => '0', 'modified' => date('Y-m-d H:i:s', strtotime('now'))), array('department_id' => $department_id));
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        } else {
            $this->db->insert('strack_facility_procedures', $data);
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function procedure_department_update($data, $id)
    {
        $this->db->where('procedure_id', $id);
        $this->db->update('strack_facility_procedures', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function delete_procedure_department($department_id, $modified_by)
    {
        $this->db->update('strack_facility_procedures', array('isdeleted' => '1', 'deleted_on' => date('Y-m-d H:i:s', strtotime('now')), 'modified_by' => $modified_by), array('department_id' => $department_id));
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function reset_procedure_department($department_id, $modified_by)
    {
        $this->db->where(array('department_id' => $department_id));
        $q = $this->db->get('strack_facility_procedures');
        if ($q->num_rows() > 0) {
            $this->delete_procedure_department($department_id, $modified_by);
        }
        return false;
    }



    public function get_procedure_department($departmentid=''){

        $this->db->where(array('p.facility_id' => $this->auth_facilityid, 'p.isdeleted' => '1'));
        if (isset($departmentid) && $departmentid != null) {
            $this->db->where('p.department_id', $departmentid);
        }
        $this->db->select('*')
            ->from('strack_facility_procedures p')
            ->join('strack_departments d ', 'd.department_id=p.department_id', 'LEFT');

        $this->db->order_by("p.rpl_code", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function remove_procedure_department(){

    }

    //===================================
    //       SUBURBs
    //===================================
    public function get_suburbs()
    {
        $this->db->select('*')
            ->from('strack_suburbs')
            ->join('strack_cities', 'strack_cities.city_id=strack_suburbs.city_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_allsuburbs()
    {
        $this->db->select('suburb_id,suburb_name')
            ->from('strack_suburbs');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_suburbs_by_id($id)
    {
        $this->db->where("suburb_id", $id);
        $q = $this->db->get('strack_suburbs');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_suburbs_list()
    {
        $this->db->select('suburb_id,suburb_name,city_id,street_code,postal_code,country_id,latitude,longitude');
        $this->db->order_by("suburb_name", "asc");
        $this->db->from('strack_suburbs');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function suburbs_insert($data)
    {
        $this->db->insert('strack_suburbs', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function suburbs_update($data, $id)
    {
        $this->db->where('suburb_id', $id);
        $this->db->update('strack_suburbs', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_suburbs($id)
    {

        $this->db->where("suburb_id", $id);
        $q = $this->db->get('strack_patients_list');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_suburbs', array('isdeleted' => '1'), array('suburb_id' => $id));
        }
    }

    public function ajaxget_suburb_by_postcode($id)
    {
        $this->db->where("postal_code", $id);
        $this->db->select('*')
            ->from('strack_suburbs');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_cities_list()
    {
        $this->db->select('*')
            ->from('strack_cities');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //===================================
    //       CATEGORIES
    //===================================
    public function get_category($facility_id = '')
    {
        if (isset($facility_id) && $facility_id != null) {
            $this->db->where('facility_id', $facility_id);
        }
        $this->db->select('*')
            ->from('strack_facility_procedure_categories');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_category_by_id($id)
    {
        $this->db->where("category_id", $id);
        $q = $this->db->get('strack_facility_procedure_categories');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_category_list($facility_id = '')
    {
        if (isset($facility_id) && $facility_id != null) {
            $this->db->where('facility_id', $facility_id);
        }
        $this->db->select('category_id,category_name, category_description');
        $this->db->order_by("category_name", "asc");
        $this->db->from('strack_facility_procedure_categories');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function category_insert($data)
    {

        $this->db->insert('strack_facility_procedure_categories', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function category_update($data, $id)
    {
        $this->db->where('category_id', $id);
        $this->db->update('strack_facility_procedure_categories', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_category($id)
    {

        $this->db->where("category_id", $id);
        $q = $this->db->get('strack_booking');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_facility_procedure_categories', array('isdeleted' => '1'), array('category_id' => $id));
        }
    }

    //===================================
    //       PROCEDURE GROUPS
    //===================================
    public function get_procedure_groups()
    {
        $this->db->select('*')
            ->from('rplgroups');
        $this->db->order_by("group_name", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function procedure_groups_by_id($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get('rplgroups');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function procedure_groups_list()
    {
        $this->db->select('id,group_name');
        $this->db->order_by("group_name", "asc");
        $this->db->from('rplgroups');
        $this->db->where(array('isdeleted' => '0'));
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function procedure_groups_insert($data)
    {
        $this->db->insert('rplgroups', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function procedure_groups_update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('rplgroups', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_procedure_groups($id)
    {

        $this->db->where("group_id", $id);
        $q = $this->db->get('strack_facility_procedures');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_facility_procedure_groups', array('isdeleted' => '1'), array('group_id' => $id));
        }
    }

    //===================================
    //       PROCEDURE SUBGROUPS
    //===================================
    public function get_procedure_subgroups()
    {
        $this->db->select('*')
            ->from('rplsubgroups');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function procedure_subgroups_by_id($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get('rplsubgroups');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function procedure_subgroups_list()
    {
        $this->db->select('rplsubgroups.id,sub_group_name,group_name')
            ->from('rplsubgroups')
            ->join('rplgroups', 'rplgroups.id=rplsubgroups.group_id', 'LEFT');
        $this->db->order_by("sub_group_name", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function procedure_subgroups_insert($data)
    {
        $this->db->insert('rplsubgroups', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function procedure_subgroups_update($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('rplsubgroups', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_procedure_subgroups($id)
    {

        $this->db->where("group_id", $id);
        $q = $this->db->get('strack_facility_procedures');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->delete('rplsubgroups',  array('id' => $id));
        }
    }

    //===================================
    //       FACILITIES
    //===================================
    public function get_facilities()
    {
        $this->db->where('ispublic', '1');
        $this->db->select('*')
            ->from('strack_facilities');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_facilities_by_id($id)
    {
        $this->db->where("facility_id", $id);
        $q = $this->db->get('strack_facilities');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_facilities_list($id)
    {
        $this->db->where('facility_id', $id);
        $this->db->select('facility_id,facility_name, facility_town,facility_phone,facility_address');
        $this->db->order_by("facility_name", "asc");
        $this->db->from('strack_facilities');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_myfacilities_list($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->select('strack_facilities.facility_id,facility_name, facility_town,facility_phone,facility_address');
        $this->db->order_by("facility_name", "asc");
        $this->db->from('strack_facilities')
            ->join("strack_facility_users", "strack_facilities.facility_id=strack_facility_users.facility_id");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function facilities_insert($data)
    {
        $this->db->insert('strack_facilities', $data);
    }

    public function facilities_update($data, $id)
    {
        $this->db->where('facility_id', $id);
        $this->db->update('strack_facilities', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_facilities($id)
    {

        $this->db->where("facility_id", $id);
        $q = $this->db->get('strack_booking');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_facilities', array('isdeleted' => '1'), array('facility_id' => $id));
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }

        }
    }

    //===================================
    //       Theatres
    //===================================
    public function get_facility_theatres($facility_id = "")
    {
        $this->db->where('t.facility_id', $this->auth_facilityid);

        $this->db->select('*')
            ->from('strack_facility_theatres t')
            ->join('strack_facilities f', 'f.facility_id=t.facility_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_theatres($facility_id = '')
    {

        $this->db->where('t.facility_id', $this->auth_facilityid);
        $this->db->select('*')
            ->from('strack_facility_theatres t')
            ->join('strack_facilities f', 'f.facility_id=t.facility_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_theatres_by_id($id)
    {
        $this->db->where("theatre_id", $id);
        $q = $this->db->get('strack_facility_theatres');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_theatres_list($facility_id = '')
    {
        $this->db->where('facility_id', $this->auth_facilityid);
        $this->db->select('theatre_id,theatre_name, theatre_info,facility_id,theatre_phone');
        $this->db->order_by("theatre_name", "asc");
        $this->db->from('strack_facility_theatres');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function theatres_insert($data)
    {
        $this->db->insert('strack_facility_theatres', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function theatres_update($data, $id)
    {
        $this->db->where('theatre_id', $id);
        $this->db->update('strack_facility_theatres', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_theatres($id)
    {

        $this->db->where("theatre_id", $id);
        $q = $this->db->get('strack_booking');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_facility_theatres', array('isdeleted' => '1'), array('theatre_id' => $id));
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    //===================================
    //       Wards
    //===================================


    public function get_wards($facility_id = '')
    {
        $this->db->where(array('w.facility_id' => $this->auth_facilityid, 'w.isdeleted' => '0'));
        $this->db->select('*')
            ->from('strack_facility_wards w')
            ->join('strack_facilities f', 'f.facility_id=w.facility_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_wards_by_id($id)
    {
        $this->db->where("ward_id", $id);
        $q = $this->db->get('strack_facility_wards');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_wards_list($facility_id = "")
    {
        $this->db->where(array('facility_id' => $this->auth_facilityid, 'isdeleted' => '0'));
        $this->db->select('ward_id,ward_name, ward_info,facility_id,ward_phone');
        $this->db->order_by("ward_name", "asc");
        $this->db->from('strack_facility_wards');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function wards_insert($data)
    {
        $this->db->insert('strack_facility_wards', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function wards_update($data, $id)
    {
        $this->db->where('ward_id', $id);
        $this->db->update('strack_facility_wards', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_wards($id)
    {

        $this->db->where("ward_id", $id);
        $q = $this->db->get('strack_booking');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_facility_wards', array('isdeleted' => '1'), array('ward_id' => $id));
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function get_laterality()
    {
        $this->db->select('laterality_id,laterality_name');
        $this->db->from('strack_laterality');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_anesthesia()
    {
        $this->db->select('id,anesthesia');
        $this->db->from('strack_anesthesia');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_postopbed()
    {
        $this->db->select('id,postopbed');
        $this->db->from('strack_postopbed');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //===================================
    //       Timeslot
    //===================================
    public function get_timeslots($facility_id = '')
    {
        // $this->db->where(array('facility_id'=>$this->auth_facilityid));
        $this->db->select('*')
            ->from('strack_facility_time_slots');
        $this->db->order_by("slot_value", "asc");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_timeslots_by_id($id)
    {
        $this->db->where("slot_id", $id);
        $q = $this->db->get('strack_facility_time_slots');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_timeslots_list($facility_id = '')
    {
        //  $this->db->where(array('facility_id'=>$this->auth_facilityid));
        $this->db->select('slot_id,slot_name,slot_value');
        $this->db->order_by("slot_value", "asc");
        $this->db->from('strack_facility_time_slots');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function timeslots_insert($data)
    {
        $this->db->insert('strack_facility_time_slots', $data);
    }

    public function timeslots_update($data, $id)
    {
        $this->db->where('slot_id', $id);
        $this->db->update('strack_facility_time_slots', $data);
    }

    function delete_timeslots($id)
    {

        $this->db->where("slot_id", $id);
        $q = $this->db->get('strack_booking');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_facility_time_slots', array('isdeleted' => '1'), array('slot_id' => $id));
        }
    }

    //===================================
    //       Firms
    //===================================
    public function get_firms($auth_facilityid)
    {
        $this->db->where(array('d.facility_id' => $auth_facilityid));
        $this->db->select('*')
            ->from('strack_department_firms f')
            ->join('strack_departments d', 'd.department_id=f.department_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_dropbox_folder_structure($firm_id)
    {
        $this->db->where('firm_id', $firm_id);
        $this->db->select('CONCAT("/",facility_name,"/",department_name,"/",firm_name)   as folder_name')
            ->from('strack_department_firms')
            ->join('strack_departments', 'strack_departments.department_id=strack_department_firms.department_id', 'LEFT')
            ->join('strack_facilities', 'strack_facilities.facility_id=strack_departments.facility_id', 'LEFT');
        $query = $this->db->get();
        $result = preg_replace('/\s+/', '', $query->row()->folder_name);
        return $result;
    }

    public function get_firms_by_id($id)
    {
        $this->db->where("firm_id", $id);
        $q = $this->db->get('strack_department_firms');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_firms_by_department($id, $userid)
    {
        $this->db->where("department_id", $id);
        $this->db->select('firm_id,firm_name, firm_info,department_id,firm_phone');
        $this->db->order_by("firm_name", "asc");
        $this->db->from('strack_department_firms');
        $this->db->where('firm_id NOT IN (SELECT firm_id FROM strack_department_firms_users WHERE user_id=' . $userid . ')', NULL, FALSE);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_all_firms_by_department($department_id = '')
    {
        if (isset($department_id) && $department_id != null && $department_id != '') {
            $this->db->where(array("department_id" => $department_id));
        }
        $this->db->select('firm_id,firm_name, firm_info,department_id,firm_phone');
        $this->db->order_by("firm_name", "asc");
        $this->db->from('strack_department_firms');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_firms_list($department_id = '')
    {
        if (isset($department_id) && $department_id != null && $department_id != '') {
            $this->db->where(array("strack_department_firms.department_id" => $department_id));
        }
        $this->db->select('firm_id,firm_name, firm_info,department_id,firm_phone');
        $this->db->order_by("firm_name", "asc");
        $this->db->from('strack_department_firms');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_myfirms_list($user_id)
    {
        $this->db->where(array('user_id' => $user_id, 'd.facility_id' => $this->auth_facilityid));
        $this->db->select('fu.firm_id,firm_name,current_user, firm_info,f.department_id,firm_phone,approved,user_id');
        $this->db->order_by("firm_name", "asc");
        $this->db->from('strack_department_firms_users fu')
            ->join("strack_department_firms f", "f.firm_id=fu.firm_id")
            ->join('strack_departments d', 'd.department_id=f.department_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_myfirms_user($user_id, $firm_id)
    {

        $this->db->where(array('user_id' => $user_id, 'firm_id' => $firm_id));
        $this->db->select('firm_id,current_user,approved,user_id');
        $this->db->from('strack_department_firms_users');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function get_mydefault_firms($user_id, $department_id)
    {

        $department_firm = $this->get_all_firms_by_department($department_id);
        $firms = array();

        foreach ($department_firm as $firm) {
            $hasfirms = '1';
            $firmuser = $this->get_myfirms_user($user_id, $firm->firm_id);
            if (empty($firmuser)) {
                $hasfirms = '0';
            }

            $myfirm = array(
                'firm_id' => $firm->firm_id,
                'firm_name' => $firm->firm_name,
                'firm_info' => $firm->firm_info,
                'department_id' => $firm->department_id,
                'firm_phone' => $firm->firm_phone,
                'department_id' => $department_id,
                'current_user' => ($hasfirms == 1) ? $firmuser->current_user : '0',
                'approved' => ($hasfirms == 1) ? $firmuser->approved : '0',
                'user_id' => $user_id
            );
            array_push($firms, $myfirm);
        }
        return (OBJECT)$firms;
    }

    public function get_department_users($department_id)
    {
        $this->db->where(array('strack_department_users.department_id' => $department_id,  'current_user' => '1'));
        $this->db->select('DISTINCT(users.user_id) as userid,CONCAT(first_name, " ", last_name) as surgeon');
        $this->db->from('strack_department_users')
            ->join("users", "users.user_id=strack_department_users.user_id");

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_firms_users($firm_id)
    {
        $this->db->where(array('strack_department_firms_users.firm_id' => $firm_id,  'current_user' => '1'));
        $this->db->select('DISTINCT(users.user_id) as userid,CONCAT(first_name, " ", last_name) as surgeon');
        $this->db->from('strack_department_firms_users')
            ->join("users", "users.user_id=strack_department_firms_users.user_id");

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function firms_insert($data)
    {
        $this->db->insert('strack_department_firms', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function firms_update($data, $id)
    {
        $this->db->where('firm_id', $id);
        $this->db->update('strack_department_firms', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_firms($id)
    {

        $this->db->where("firm_id", $id);
        $q = $this->db->get('strack_members');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_department_firms', array('isdeleted' => '1'), array('firm_id' => $id));
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    //===================================
    //       Department
    //===================================
    public function get_departments()
    {
        $this->db->where(array('f.facility_id' => $this->auth_facilityid));
        $this->db->select('*')
            ->from('strack_departments d')
            ->join('strack_facilities f', 'f.facility_id=d.facility_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_department_facility($id)
    {
        $this->db->where("department_id", $id);
        $this->db->from('strack_departments')
            ->join('strack_facilities', 'strack_facilities.facility_id=strack_departments.facility_id', 'LEFT');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_departments_by_id($id)
    {
        $this->db->where("department_id", $id);
        $this->db->from('strack_departments');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function ajaxget_departments_facility($facility_id, $userid)
    {
        $this->db->select('DISTINCT(department_id),department_name,facility_id,department_phone');
        $this->db->order_by("department_name", "asc");
        $this->db->from('strack_departments');
        $this->db->where('facility_id', $facility_id);
        $this->db->where('department_id NOT IN (SELECT department_id FROM strack_department_users WHERE user_id=' . $userid . ' AND current_user=\'1\')', NULL, FALSE);

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_departments_list()
    {
        $this->db->where(array('facility_id' => $this->auth_facilityid));
        $this->db->select('department_id,department_name,facility_id,department_phone');
        $this->db->order_by("department_name", "asc");
        $this->db->from('strack_departments');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_mydepartments_list($user_id)
    {
        $this->db->where(array('user_id' => $user_id, 'd.facility_id' => $this->auth_facilityid));
        $this->db->select('DISTINCT(d.department_id),department_name,f.facility_id,facility_name,department_phone,current_user,approved,user_id');
        $this->db->order_by("department_name", "asc");
        $this->db->from('strack_departments d')
            ->join("strack_department_users du", "d.department_id=du.department_id", 'LEFT')
            ->join('strack_facilities f', 'f.facility_id=d.facility_id', 'LEFT');
        $this->db->where(' current_user', "1");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_mydepartments_filter_list($user_id)
    {
        $this->db->select('strack_departments.department_id,department_name');
        $this->db->order_by('department_name', 'asc');
        $this->db->from('strack_departments');
        $this->db->where('strack_departments.department_id NOT IN (SELECT department_id FROM strack_department_users WHERE user_id=' . $user_id . ' AND current_user=\'1\')');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_mydepartment($user_id)
    {
        $this->db->where(array('user_id' => $user_id, 'current_user' => '1'));
        $this->db->select('strack_departments.department_id,department_name,strack_facilities.facility_id,user_id,facility_name,department_phone');
        $this->db->order_by("department_name", "asc");
        $this->db->from('strack_departments')
            ->join("strack_department_users", "strack_departments.department_id=strack_department_users.department_id")
            ->join('strack_facilities', 'strack_facilities.facility_id=strack_departments.facility_id', 'LEFT');
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function check_user_has_department($user_id)
    {
        $this->db->select('department_id');
        $this->db->from('strack_department_users');
        $this->db->where(array('user_id' => $user_id, 'current_user' => '1'));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return '1';
        } else {
            return '0';
        }
    }


    public function get_myfirm($user_id)
    {
        $this->db->select('*')
            ->from('strack_department_firms_users')
            ->join("strack_department_firms", "strack_department_firms_users.firm_id=strack_department_firms.firm_id", 'LEFT')
            ->where('current_user', '1');
        $this->db->where(array("user_id" => $user_id));
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    function departments_insert($data)
    {
        $this->db->insert('strack_departments', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function departments_update($data, $id)
    {
        $this->db->where('department_id', $id);
        $this->db->update('strack_departments', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function delete_departments($id)
    {

        $this->db->where("department_id", $id);
        $q = $this->db->get('strack_members');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_departments', array('isdeleted' => '1'), array('department_id' => $id));
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    function get_department_firm_peruser($user_id, $department_id = '')
    {
        if (isset($department_id) && $department_id != '') {
            $my_departmentalfirms = $this->get_mydefault_firms($user_id, $department_id);
        } else {
            $my_departmentalfirms = '';
        }
        $firms = '';
        $firms .= '<div class="well padding-10">
                        <h5 class="margin-top-0"><i class="success fa fa-users "></i> MY FIRMS/TEAMS   </h5>

                        <div class="panel panel-default">
                            <div class="panel-body status smart-form vote">';
        $firms .= '<div class="comments">';

        if (!empty($my_departmentalfirms) && $my_departmentalfirms != '') {
            foreach ($my_departmentalfirms as $row) {
                $iscurrent = ($row['current_user'] == '1') ? 'checked="checked"' : '';
                $firms .= '<div class="radio">
                        <label>
                                    <input class="radiobox style-3" ' . $iscurrent . ' name="firm" type="radio" onclick="default_firm(\'' . $row['firm_id'] . '\',\'' . $row['user_id'] . '\',\'' . $row['firm_name'] . '\',\'' . $row['department_id'] . '\')">
                                     <span>' . $row['firm_name'] . ' </span> 
                                </label>
                            </div>';
            }
        }

        $firms .= '</div>
                </div>
            </div>
        </div>';

        return $firms;
    }

    //===================================
    //      Priorities
    //===================================
    public function get_priorities()
    {
        $this->db->select('*')
            ->from('strack_priorities');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //===================================
    //       Insurance Companies
    //===================================
    public function get_insurance_companies($facility_id = '')
    {
        $this->db->where(array('facility_id' => $this->auth_facilityid));
        $this->db->select('*')
            ->from('strack_insurance_companies');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_insurance_companies_by_id($id)
    {
        $this->db->where("insuranceco_id", $id);
        $q = $this->db->get('strack_insurance_companies');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_insurance_companies_list($facility_id = '')
    {
        $this->db->where(array('facility_id' => $this->auth_facilityid));
        $this->db->select('insuranceco_id,insuranceco_name, insuranceco_phone,insuranceco_email,created_by');
        $this->db->order_by("insuranceco_name", "asc");
        $this->db->from('strack_insurance_companies');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function insurance_companies_insert($data)
    {
        $this->db->insert('strack_insurance_companies', $data);
    }

    public function insurance_companies_update($data, $id)
    {
        $this->db->where('insuranceco_id', $id);
        $this->db->update('strack_insurance_companies', $data);
    }

    function delete_insurance_companies($id)
    {

        $this->db->where("insuranceco_id", $id);
        $q = $this->db->get('strack_bookings');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_insurance_companies', array('isdeleted' => '1'), array('insuranceco__id' => $id));
        }
    }

    /**
     * Checks username
     *
     * @return bool
     * @author Mathew
     * */
    public function subscriber_check($email = '')
    {
        if (empty($email)) {
            return FALSE;
        }
        return $this->db->where('subscriber_Email', $email)
                ->group_by("subscriber_Id")
                ->order_by("subscriber_Id", "ASC")
                ->limit(1)
                ->count_all_results('locumer_subscribers') > 0;
    }

    public function nappi_consumables_update($data, $id)
    {
        $this->db->where('consumable_id', $id);
        $this->db->update('strack_nappi_consumables', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function nappi_consumables_insert($data)
    {
        $this->db->insert('strack_nappi_consumables', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_nappi_consumables()
    {
        $this->db->select('*')
            ->from('strack_nappi_consumables');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_rpl_nappi_consumables($rpl_id)
    {
        $this->db->where(array("n.procedure_id" => $rpl_id, 'n.isdeleted' => '0'));
        $this->db->select('n.id,c.*')
            ->from('strack_rpl_consumables n');
        $this->db->join('strack_nappi_consumables c', 'c.consumable_id=n.consumable_id');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function delete_rpl_nappi($id)
    {
        $query = 'UPDATE strack_rpl_consumables SET isdeleted="1" WHERE id = ' . $id;
        $this->db->query($query);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_nappi_consumables_by_id($id)
    {
        $this->db->where("consumable_id", $id);
        $q = $this->db->get('strack_nappi_consumables');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function rpl_procedurecodes_update($data, $id)
    {
        $this->db->where('rpl_id', $id);
        $this->db->update('strack_rpl_procedure_codes', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function rpl_procedurecodes_insert($data)
    {
        $this->db->insert('strack_rpl_procedure_codes', $data);
        return $this->db->insert_id();
    }

    public function rpl_nappi_consumables_insert($data, $consumable_id, $rpl_id)
    {

        $this->db->where(array('consumable_id' => $consumable_id, 'procedure_id' => $rpl_id, 'isdeleted' => '0'));
        $q = $this->db->get('strack_rpl_consumables');
        if ($q->num_rows() > 0) {
            return false;
        } else {
            $this->db->insert('strack_rpl_consumables', $data);
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function get_rpl_procedurecodes()
    {
        $this->db->where(array('facility_id' => $this->auth_facilityid));
        $this->db->select('*')
            ->from('strack_facility_procedures');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_rpl_procedurecodes_by_id($id)
    {
        $this->db->where("procedure_id", $id);
        $this->db->select('*')
            ->from('strack_facility_procedures');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function delete_rpl_procedurecodes($id)
    {

        $this->db->where("rpl_id", $id);
        $q = $this->db->get('strack_rpl_consumables');
        if ($q->num_rows() > 0) {
            return 1;
        } else {
            $this->db->update('strack_rpl_procedure_codes', array('isdeleted' => '1'), array('rpl_id' => $id));
            if ($this->db->affected_rows() >= 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function delete_rpl_procedurecode($id)
    {
        $this->db->where("rpl_id", $id);
        $this->db->delete('strack_rpl_procedure_codes');
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function get_consumables_details($consumable_id)
    {
        $this->db->where(array('consumable_id' => $consumable_id));
        $this->db->select('*')
            ->from('strack_nappi_consumables');
        $query = $this->db->get();
        return $query->row();
    }

    public function get_global_procedure_by_id_local($id)
    {
        $this->db->where("id", $id);
        $this->db->select('*')
            ->from('strack_facility_procedures p');
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_global_procedure_by_id($id)
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ACCOUNTS_URL.'/api/v1/procedures/'.$id
        ));
        // Send the request & save response to $resp
        $procedures = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        return json_decode($procedures,true) ;

    }
}
