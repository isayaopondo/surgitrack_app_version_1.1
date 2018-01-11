<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 02/11/2017
 * Time: 10:07
 */

class Setup_model extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    public function is_setup_complete($facilityid)
    {
        $this->db->where(array("facility_id" => $facilityid));
        $this->db->where('is_complete!=0');
        $query = $this->db->get('strack_facilities_setup');
        if ($query->num_rows() >= 1){
            $this->check_facility_repository($facilityid);
            return TRUE;
        }else
            return FALSE;
    }

    public function get_Users($facilityid)
    {
        $this->db->select('u.user_id,u.first_name,u.email,u.last_name,fu.auth_level,d.department_name,')
            ->from('users u')
            ->where('fu.facility_id', $facilityid)
            ->join("strack_department_users du", "u.user_id=du.user_id AND current_user='1'", 'LEFT')
            ->join("strack_facility_users fu", "u.user_id=fu.user_id", 'INNER')
            ->join("strack_departments d", "du.department_id=d.department_id");
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    public function get_User_by_id($userid)
    {
        $this->db->select('u.user_id,u.first_name,u.email,u.last_name,fu.auth_level,d.department_name,')
            ->from('users u')
            ->where('u.user_id', $userid)
            ->join("strack_department_users du", "u.user_id=du.user_id AND current_user='1'", 'LEFT')
            ->join("strack_facility_users fu", "u.user_id=fu.user_id")
            ->join("strack_departments d", "du.department_id=d.department_id");
        $query = $this->db->get();
        $result = $query->row();
        return $result;
    }

    public function get_setup_stats($facilityid)
    {
        $stats['susers'] = $this->get_total_stats($facilityid, 'strack_facility_users');
        $stats['sdepartments'] = $this->get_total_stats($facilityid, 'strack_departments');
        $stats['sfirms'] = $this->get_total_firms($facilityid);
        $stats['swards'] = $this->get_total_stats($facilityid, 'strack_facility_wards');
        $stats['stheatres'] = $this->get_total_stats($facilityid, 'strack_facility_theatres');
        $stats['sprocedures'] = $this->get_total_stats($facilityid, 'strack_facility_procedures');
        $stats['sstatus'] = $this->get_completion_status($facilityid);
        return $stats;
    }

    public function get_total_stats($facilityid, $table)
    {
        $this->db->where(array("facility_id" => $facilityid));
        $query = $this->db->get($table);
        if ($query->num_rows() >= 1)
            return '<span class="badge badge-primary pull-right">' . $query->num_rows() . '</span>';
        else
            return '<span class="badge badge-warning pull-right">0</span>';;

    }

    public function get_completion_status($facilityid)
    {
        $this->db->where(array("facility_id" => $facilityid, 'is_complete' => '1'));
        $query = $this->db->get('strack_facilities_setup');
        if ($query->num_rows() >= 1)
            return '<span class="badge badge-success pull-right">READY</span>';
        else
            return '<span class="badge badge-danger pull-right">INCOMPLeTE</span>';

    }

    public function get_total_firms($facilityid)
    {
        $this->db->where(array("d.facility_id" => $facilityid));
        $this->db->select()
            ->from('strack_department_firms f')
            ->join("strack_departments d", "f.department_id=d.department_id");
        $query = $this->db->get();
        if ($query->num_rows() >= 1)
            return '<span class="badge badge-primary pull-right">' . $query->num_rows() . '</span>';
        else
            return '<span class="badge badge-warning pull-right">0</span>';

    }

    public function get_full_procedure_list()
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ACCOUNTS_URL.'/api/v1/procedures'
        ));
        // Send the request & save response to $resp
        $procedures = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        return json_decode($procedures) ;

    }

    public function get_procedure_groups()
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ACCOUNTS_URL.'/api/v1/groups'
        ));
        // Send the request & save response to $resp
        $procedures = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        return json_decode($procedures) ;
    }

    public function get_procedure_subgroups()
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ACCOUNTS_URL.'/api/v1/subgroups'
        ));
        // Send the request & save response to $resp
        $procedures = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        return json_decode($procedures) ;
    }

    public function procedures_by_groups($group_id)
    {
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => ACCOUNTS_URL.'/api/v1/procedures/groups/'.$group_id
        ));
        // Send the request & save response to $resp
        $procedures = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        return $procedures ;
    }


    public function check_facility_repository($facilityid){
        $codingfolderPath= OPCODING_REPOSITORY . $facilityid;
        if(FALSE !== ($path = $this->folder_exist($codingfolderPath)))
        {
        }else{
            mkdir($codingfolderPath, 0777, true) || chmod($codingfolderPath, 0777);
        }


        $notesfolderPath= OPNOTES_REPOSITORY . $facilityid;
        if(FALSE !== ($notespath = $this->folder_exist($notesfolderPath)))
        {
        }else{
            mkdir($notesfolderPath, 0777, true) || chmod($notesfolderPath, 0777);
        }


    }



    private function folder_exist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        return ($path !== false AND is_dir($path)) ? $path : false;
    }




}