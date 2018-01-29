<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends MY_Model
{

    var $table = 'users';
    var $sc = 'iccm_sub_counties_users';

    function __construct()
    {
        parent::__construct();
    }

//create user
    public function approve_department($id, $department)
    {
        $data = array('approved' => '1');
        $this->db->where(array("user_id" => $id, "department_id" => $department));
        $this->db->update('strack_department_users', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function remove_department($id, $department)
    {
        $data = array('current_user' => '0', 'date_unassigned' => date('Y-m-d H:i:s', strtotime('now')));
        $this->db->where(array("user_id" => $id, "department_id" => $department));
        $this->db->update('strack_department_users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delink_department($id, $department)
    {
        $data = array('approved' => '0');
        $this->db->where(array("user_id" => $id, "department_id" => $department));
        $this->db->update('strack_department_users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function approve_firm($id, $firm)
    {
        $data = array('approved' => '1');
        $this->db->where(array("user_id" => $id, "firm_id" => $firm));
        $this->db->update('strack_department_firms_users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function delink_firm($id, $firm)
    {
        $data = array('approved' => '0');
        $this->db->where(array("user_id" => $id, "firm_id" => $firm));
        $this->db->update('strack_department_firms_users', $data);
        return ($this->db->affected_rows() != 1) ? false : true;
    }

    public function default_firm($userid, $firm, $department = "")
    {
        $this->unset_default_firms($userid, $department);

        $data = array('current_user' => '1');
        $this->db->where(array("user_id" => $userid, "firm_id" => $firm));
        $this->db->update('strack_department_firms_users', $data);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            $data_user = array(
                'user_id' => $userid,
                'firm_id' => $firm,
                'current_user' => '1',
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $userid,
            );
            return $this->add_user_firm($data_user);
        }
    }

    function add($data)
    {
        $this->db->insert($this->table, $data);
    }

    public function unset_default_firms($userid, $department)
    {

        $data = array(
            'current_user' => '0',
            'date_unassigned' => date('Y-m-d H:i:s', strtotime('now'))
        );
        $this->db->where("user_id", $userid);
        $this->db->update('strack_department_firms_users', $data);
        $this->db->where('`firm_id` IN (SELECT `firm_id` FROM `strack_department_firms` WHERE department_id=' . $department . ')', NULL, FALSE);

        //return ($this->db->affected_rows() > 0) ? true : false;
    }

    function update_user($data, $id)
    {
        $this->db->where("user_id", $id);
        $this->db->update($this->table, $data);
    }

    function add_user_firm($data)
    {
        $this->db->insert('strack_department_firms_users', $data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function identity_check($identity = '')
    {
        $this->trigger_events('identity_check');
        if (empty($identity)) {
            return FALSE;
        }
        return $this->db->where($this->identity_column, $identity)
                ->count_all_results($this->tables['users']) > 0;
    }

    function add_user_department($data)
    {
        $this->db->insert('strack_department_users', $data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }


    function add_user_facility($data)
    {
        $this->db->insert('strack_facility_users', $data);
    }

    function get_user_by_id($id)
    {
        $this->db->where("user_id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    function delete_user($id)
    {
       // $this->db->update($this->table, array('isdelete' => '1'), array('user_id' => $id));
        $this->db->where("user_id", $id);
        $this->db->delete($this->table);
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }

    }

    public function get_users_department($user_id)
    {
        $this->db->select('*')
            ->from('strack_department_users')
            ->join("strack_departments", "strack_department_users.department_id=strack_departments.department_id", 'LEFT')
            ->where('current_user', '1');
        $this->db->where(array("user_id" => $user_id));
        $q = $this->db->get();

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function get_facility_department($user_id, $facility)
    {
        $this->db->select('*')
            ->from('strack_department_users u')
            ->join("strack_departments d", "u.department_id=d.department_id", 'LEFT')
            ->where('u.current_user', '1');
        $this->db->where(array("u.user_id" => $user_id, "d.facility_id" => $facility));
        $q = $this->db->get();


        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    /* function delete_user($id) {
      $this->db->where("user_id", $id);
      $this->db->delete($this->table);
      } */

    public function get_groups()
    {
        $this->db->select('*')
            ->from('groups');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_user($userid)
    {
        $this->db->select('users.*')
            ->from('users')
            ->where(array('users.user_id' => $userid));
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function get_user_level($userid)
    {
        $this->db->select('user_group')
            ->from('users')
            ->where(array('user_id' => $userid));
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function get_user_group($userid)
    {
        $this->db->select('group_id')
            ->from('users_groups')
            ->where(array('user_id' => $userid));
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }


//get users
    function get_Users()
    {
        $this->db->select('*')
            ->from('users u')
            ->join("strack_department_users du", "u.user_id=du.user_id", 'LEFT')
            ->join("strack_departments d", "du.department_id=d.department_id", 'LEFT');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_audit_trail($user_id)
    {

        if (isset($user_id) && $user_id != null) {
            $this->db->where(array("user_id" => $user_id));
        }
        $this->db->select('*')
            ->from('user_activity_log')
            ->order_by('log_date_time', 'DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_audit_trail_all()
    {

        $this->db->select('log_id,log_date_time,log_info,log_action,email,CONCAT(users.first_name," ",users.last_name) AS loggername')
            ->from('user_activity_log')
            ->join("users", "user_activity_log.user_id=users.user_id")
            ->order_by('log_date_time', 'DESC');

        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_user_firm_table($id)
    {
        $userlevel = $this->get_user_level($id);
        $level = $userlevel->user_group;
        $this->db->select('users_table,users_unit_id,users_unit_name,assign_transunit')
            ->from('groups')
            ->where(array('group_id' => $level));
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function get_user_firms_specifics($id)
    {
        $userttable = $this->get_user_firm_table($id);
        if ($userttable->assign_transunit == 'yes') {
            $unittable_name = $userttable->users_table;
            $users_unit_id = $userttable->users_unit_id;
            $users_unit_name = $userttable->users_unit_name;

            $userttable_name = $unittable_name . '_users';

            $this->db->select($users_unit_id . ' AS unit_id')
                ->from($unittable_name)
                ->join($userttable_name, $unittable_name . '.' . $users_unit_id . '=' . $userttable_name . '.unit_id')
                ->where(array($userttable_name . '.user_id' => $id));

            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }

    public function get_user_firms($id)
    {

        $userttable = $this->get_user_firm_table($id);
        if ($userttable->assign_transunit == 'yes') {
            $unittable_name = $userttable->users_table;
            $users_unit_id = $userttable->users_unit_id;
            $users_unit_name = $userttable->users_unit_name;

            $userttable_name = $unittable_name . '_users';

            $this->db->select($users_unit_id . ' AS unit_id, ' . $users_unit_name . ' AS unit_name , unit_current_user')
                ->from($unittable_name)
                ->join($userttable_name, $unittable_name . '.' . $users_unit_id . '=' . $userttable_name . '.unit_id')
                ->where(array($userttable_name . '.user_id' => $id, $userttable_name . '.unit_current_user' => '1'));

            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }

    public function get_past_user_firms($id)
    {

        $userttable = $this->get_user_firm_table($id);
        if ($userttable->assign_transunit == 'yes') {
            $unittable_name = $userttable->users_table;
            $users_unit_id = $userttable->users_unit_id;
            $users_unit_name = $userttable->users_unit_name;

            $userttable_name = $unittable_name . '_users';

            $this->db->select($users_unit_id . ' AS unit_id, ' . $users_unit_name . ' AS unit_name , unit_current_user')
                ->from($unittable_name)
                ->join($userttable_name, $unittable_name . '.' . $users_unit_id . '=' . $userttable_name . '.unit_id')
                ->where(array($userttable_name . '.user_id' => $id, $userttable_name . '.unit_current_user' => '0'));

            $query = $this->db->get();
            $result = $query->result();
            return $result;
        }
    }

    function unassign_firm($id, $unit_id)
    {
        $userttable = $this->get_user_firm_table($id);
        $unittable_name = $userttable->users_table . '_users';
        $data = array(
            'unit_current_user' => '0',
            'date_updated' => date('Y-m-d H:i:s', strtotime('now')),
        );
        $this->db->where(array('user_id' => $id, 'unit_id' => $unit_id));
        $this->db->update($unittable_name, $data);
    }

    function reassign_firm($id, $unit_id)
    {


        $userttable = $this->get_user_firm_table($id);
        $unittable_name = $userttable->users_table . '_users';
        $data = array(
            'unit_current_user' => '1',
            'date_updated' => date('Y-m-d H:i:s', strtotime('now')),
        );
        $this->db->where(array('user_id' => $id, 'unit_id' => $unit_id));
        if ($this->db->update($unittable_name, $data)) {
            $this->logger->logAction('User Re-assigned', (array)$this);
        }
    }

    public function get_users_list()
    {
        $query = $this->db->get('users');
        $result = $query->result();
        return $result;
    }

    public function update_userid($id,$new_id)
    {
        $data = array(
            'user_id' => $new_id
        );
        $this->db->where(array('_id' => $id));
        $this->db->update('users', $data);

    }

    public function migrate_users($old_id,$new_id){
        //$this->update_id($table, $variable, $old_id,$new_id);

        $this->update_id('strack_booking', 'booked_by', $old_id,$new_id);
        $this->update_id('strack_booking', 'admitted_by', $old_id,$new_id);
        $this->update_id('strack_booking', 'op_recorded_by', $old_id,$new_id);
        $this->update_id('strack_booking', 'opnotes_generated_by', $old_id,$new_id);
        $this->update_id('strack_booking', 'opcoding_generated_by', $old_id,$new_id);
        $this->update_id('strack_booking', 'created_by', $old_id,$new_id);
        $this->update_id('strack_booking', 'last_modified_by', $old_id,$new_id);

        $this->update_id('strack_mapt_patients_score_instance', 'created_by', $old_id,$new_id);
        $this->update_id('strack_patients_list', 'created_by', $old_id,$new_id);



        $this->update_id('strack_department_firms_users', 'user_id', $old_id,$new_id);
        $this->update_id('strack_department_firms_users', 'created_by', $old_id,$new_id);

        $this->update_id('strack_department_users', 'user_id', $old_id,$new_id);
        $this->update_id('strack_department_users', 'created_by', $old_id,$new_id);

        $this->update_id('strack_facility_theatres', 'created_by', $old_id,$new_id);

        $this->update_id('strack_facility_procedures', 'created_by', $old_id,$new_id);

        $this->update_id('strack_patient_log', 'user_id', $old_id,$new_id);


        $this->update_id('strack_booking_op_surgeon', 'op_user_id', $old_id,$new_id);
        $this->update_id('strack_booking_op_surgeon', 'created_by', $old_id,$new_id);
        // $this->update_id($table, $variable, $old_id,$new_id);
        //$this->update_id($table, $variable, $old_id,$new_id);
        //$this->update_id($table, $variable, $old_id,$new_id);
        //$this->update_id($table, $variable, $old_id,$new_id);
        //$this->update_id($table, $variable, $old_id,$new_id);
        //$this->update_id($table, $variable, $old_id,$new_id);
        //$this->update_id($table, $variable, $old_id,$new_id);
    }

    public function update_id($table, $variable, $old_id,$new_id)
    {
        $this->db->where(array($variable => $old_id));
        $this->db->update($table, array($variable => $new_id));
    }

    public function map_users_facilities($data)
    {
        $this->db->insert('strack_facility_users', $data);
    }

    public function get_procedure_list(){
        $query = $this->db->get('procedure_migrate');
        $result = $query->result();
        return $result;
    }

    public function map_procedures($procedureid, $rpl){
        $this->db->where(array('procedure_id' => $procedureid));
        $this->db->update('strack_facility_procedures_copy', array('procedure_id_' => $procedureid,'rpl_code'=>$rpl));

    }



}
