<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FileManager
 *
 * @author HP
 */
class Filemanager {

    /**
     * Constructor
     */
    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->library('gcm');
        $this->CI->load->library('writelog');
    }

    function create_root_folder($user_id) {
        //$user_id = $user['user_id'];
        $static = BASEPATH . "../folder/profiles/";
        !is_dir($static . $user_id . '/myuploads') ? mkdir($static . $user_id . '/myuploads', 0777, true) : "";
        !is_dir($static . $user_id . '/picture') ? mkdir($static . $user_id . '/picture', 0777, true) : "";
    }

}
