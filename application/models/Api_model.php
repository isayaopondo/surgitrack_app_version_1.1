<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 29/10/2017
 * Time: 00:22
 */

class Api_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function facilities_insert($data)
    {
        if (is_array($data)) {
            $facility_name = $data['facility_name'];

            if (!$this->facility_exist($facility_name)) {
                $this->db->insert('strack_facilities', $data);
                if ($this->db->affected_rows() >= 1) {
                    $id = $this->db->insert_id();
                    $this->create_facility_repository($id);
                    $data_setup = [
                        'facility_id' => $id,
                        'is_complete' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                    ];
                    $this->add_facility_setup($data_setup);
                    $message['success'] = '1';
                    $message['facility_id'] = $id;
                    $message['message'] = "Facility created successfully.";
                } else {
                    $message['success'] = '0';
                    $message['message'] = "Error! facility creation failed.";
                }
            } else {
                $message['success'] = '2';
                $message['message'] = "The name provided already exist in our database!";
            }
        } else {
            $message['success'] = '0';
            $message['message'] = "System Error!";
        }
        return $message;
    }

    public function add_facility_setup($data)
    {
        $this->db->insert('strack_facilities_setup', $data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function update_facility_setup($data, $id)
    {
        if ($this->facility_setup_exist($id)) {

            $this->db->where('facility_id', $id);
            $this->db->update('strack_facilities_setup', $data);
            if ($this->db->affected_rows() >= 1) {
                $this->check_facility_setup_completenes($id);
                $this->create_facility_repository($id);
                return true;
            } else {
                return false;
            }
        } else {
            $mydata = [
                'created_at' => date('Y-m-d H:i:s'),
            ];
            $data = array_merge($data, $mydata);
            $this->add_facility_setup($data);
        }
    }

    public function facility_setup_exist($id)
    {
        $this->db->where('facility_id', $id);
        $query = $this->db->get('strack_facilities_setup');
        if ($query->num_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }


    private function check_facility_setup_completenes($id)
    {
        $this->db->where(array('facility_id' => $id, 'is_users' => 1, 'is_departments' => 1, 'is_theatres' => 1, 'is_wards' => 1));
        $query = $this->db->get('strack_facilities_setup');
        if ($query->num_rows() >= 1) {
            $data = [
                'is_complete' => 1,
                'completed_at' => date('Y-m-d H:i:s'),
            ];
            $this->update_facility_setup($data, $id);
        } else {
            return false;
        }

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

    public function facility_exist($facility_name)
    {
        $this->db->where('facility_name', $facility_name);
        $query = $this->db->get('strack_facilities');
        return $query->num_rows() > 0;
    }


    public function admin_user_insert($data, $password, $accountsfacility_id)
    {
        if (is_array($data) && !empty($data)) {
            $facility = $this->get_facility($accountsfacility_id);

            $facilityid = !empty($facility) ? $facility->facility_id : '';
            $facility_name = !empty($facility) ? $facility->facility_name : '';

            if ($this->user_exist($data['email'], $facilityid, $facility_name, $data['auth_level'])) {
                $message['success'] = '1';
                $message['message'] = "User has been successfully invited.";
            } else {
                $this->db->set($data)->insert('users');
                if ($this->db->affected_rows() >= 1) {
                    $this->add_facility_users($data['user_id'], $facilityid, $data['auth_level']);

                    if ($data['email']) {

                        $email= $data['email'];
                        if ($user_data = $this->authorization_model->get_recovery_data($email)) {
                            // Check if user is banned
                            if ($user_data->banned == '1') {
                                // Log an error if banned
                                $this->authentication->log_error($email);

                                // Show special message for banned user
                                // $view_data['banned'] = 1;
                            } else {
                                /**
                                 * Use the authentication libraries salt generator for a random string
                                 * that will be hashed and stored as the password recovery key.
                                 * Method is called 4 times for a 88 character string, and then
                                 * trimmed to 72 characters
                                 */
                                $recovery_code = substr($this->authentication->random_salt()
                                    . $this->authentication->random_salt()
                                    . $this->authentication->random_salt()
                                    . $this->authentication->random_salt(), 0, 72);

                                // Update user record with recovery code and time
                                $this->authorization_model->update_user_raw_data(
                                    $user_data->user_id,
                                    [
                                        'passwd_recovery_code' => $this->authentication->hash_passwd($recovery_code),
                                        'passwd_recovery_date' => date('Y-m-d H:i:s')
                                    ]
                                );

                                // Set the link protocol
                                $link_protocol = USE_SSL ? 'https' : NULL;

                                // Set URI of link
                                $link_uri = 'auth/set_password_verification/' . $user_data->user_id . '/' . $recovery_code;
                                $special_link = anchor(
                                    site_url($link_uri, $link_protocol),
                                    site_url($link_uri, $link_protocol),
                                    'target ="_blank"'
                                );

                            }
                        } // There was no match, log an error, and display a message
                        else {
                            // Log the error
                            $this->authentication->log_error($this->input->post('email', TRUE));

                            //  $view_data['no_match'] = 1;
                        }
                    }
                    // $this->send_invite_mail($password, $data['email'], $facility_name, '_userinvite');
                    $this->send_admininvite_mail($special_link, $email,$facility_name);

                    //$this->send_invite_mail($password, $data['email'], $facility_name, '_createinvite');
                    $message['success'] = '1';
                    $message['user_id'] = $data['user_id'];
                    $message['message'] = "User created and invited successfully.";
                } else {
                    $message['success'] = '0';
                    $message['message'] = "Error! user creation failed.";
                }
            }

        } else {
            $message['success'] = '0';
            $message['message'] = "System Error!";
        }
        return $message;
    }

    public function _user_insert($data, $password, $facilityid, $facility_name)
    {
        // Load resources
        //$this->load->model('Authorization/authorization_model');

        if ($this->user_exist($data['email'], $facilityid, $facility_name, $data['auth_level'])) {
            $message['success'] = '1';
            $message['message'] = "User has been successfully invited.";
        } else {
            $this->db->set($data)
                ->insert('users');
            if ($this->db->affected_rows() >= 1) {
                $this->add_facility_users($data['user_id'], $facilityid, $data['auth_level']);

                // If the form post looks good
                if ($data['email']) {

                    $email= $data['email'];
                    if ($user_data = $this->authorization_model->get_recovery_data($email)) {
                        // Check if user is banned
                        if ($user_data->banned == '1') {
                            // Log an error if banned
                            $this->authentication->log_error($email);

                            // Show special message for banned user
                            // $view_data['banned'] = 1;
                        } else {
                            /**
                             * Use the authentication libraries salt generator for a random string
                             * that will be hashed and stored as the password recovery key.
                             * Method is called 4 times for a 88 character string, and then
                             * trimmed to 72 characters
                             */
                            $recovery_code = substr($this->authentication->random_salt()
                                . $this->authentication->random_salt()
                                . $this->authentication->random_salt()
                                . $this->authentication->random_salt(), 0, 72);

                            // Update user record with recovery code and time
                            $this->authorization_model->update_user_raw_data(
                                $user_data->user_id,
                                [
                                    'passwd_recovery_code' => $this->authentication->hash_passwd($recovery_code),
                                    'passwd_recovery_date' => date('Y-m-d H:i:s')
                                ]
                            );

                            // Set the link protocol
                            $link_protocol = USE_SSL ? 'https' : NULL;

                            // Set URI of link
                            $link_uri = 'auth/set_password_verification/' . $user_data->user_id . '/' . $recovery_code;
                            $special_link = anchor(
                                site_url($link_uri, $link_protocol),
                                site_url($link_uri, $link_protocol),
                                'target ="_blank"'
                            );

                            //$view_data['special_link'] = $special_link;

                            //$this->send_password_creation_mail($special_link, $email,$user_data->username);
                            // $view_data['confirmation'] = 1;


                        }
                    } // There was no match, log an error, and display a message
                    else {
                        // Log the error
                        $this->authentication->log_error($this->input->post('email', TRUE));

                        //  $view_data['no_match'] = 1;
                    }
                }
               // $this->send_invite_mail($password, $data['email'], $facility_name, '_userinvite');
                $this->send_password_creation_mail($special_link, $email,$facility_name);
                $message['success'] = '1';
                $message['user_id'] = $data['user_id'];
                $message['message'] = "User created and invited successfully.";
            } else {
                $message['success'] = '0';
                $message['message'] = "Error! user creation failed.";
            }
        }


        return $message;
    }

    public function add_user_firm($data)
    {
        $this->db->insert('strack_department_firms_users', $data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function add_user_department($data)
    {
        $this->db->insert('strack_department_users', $data);
        return ($this->db->affected_rows() > 0) ? true : false;
    }

    public function user_exist($email, $facilityid, $facility_name, $auth_level)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $user_id = $query->row()->user_id;
            $this->add_facility_users($user_id, $facilityid, $auth_level);
            $this->send_invite_mail('', $email, $facility_name, 'invite');
            return true;
        } else {
            return false;
        }
    }

    private function add_facility_users($user_id, $facilityid, $auth_level)
    {
        $user_data = [
            'user_id' => $user_id,
            'facility_id' => $facilityid,
            'current_user' => '1',
            'auth_level' => $auth_level,
            'date_assigned' => date('Y-m-d'),
            'created_on' => date('Y-m-d H:i:s'),
        ];
        $this->db->set($user_data)
            ->insert('strack_facility_users');
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    public function send_invite_mail($passcode, $email, $facility_name, $mailtype = 'activate')
    {

        $user = $this->get_user($email);

        $info = array(
            'username' => $user->first_name . ' ' . $user->last_name,
            'site_name' => SYSTEM_NAME,
            'facilityname' => $facility_name,
            'email' => $user->email,
            'password' => $passcode,
        );
        $this->notificationmanager->sendMail($user->user_id, $mailtype, SYSTEM_NAME, $user->email, $info);
    }

    private function send_password_creation_mail($special_link, $email, $facility_name, $mailtype = 'set_password')
    {
      //  $this->load->library('notificationmanager');
        $user = $this->get_user($email);

        $info = array(
            'special_link' => $special_link,
            'username'=>$user->first_name . ' ' . $user->last_name,
            'site_name' => SYSTEM_NAME,
            'facilityname' => $facility_name,
            'email' => $user->email,
        );
        $this->notificationmanager->sendMail(0, $mailtype, SYSTEM_NAME.' Password Setup', $email, $info);

    }


    private function send_admininvite_mail($special_link, $email, $facility_name, $mailtype = '_createinvite')
    {
        //  $this->load->library('notificationmanager');
        $user = $this->get_user($email);

        $info = array(
            'special_link' => $special_link,
            'username'=>$user->first_name . ' ' . $user->last_name,
            'site_name' => SYSTEM_NAME,
            'facilityname' => $facility_name,
            'email' => $user->email,
        );
        $this->notificationmanager->sendMail(0, $mailtype, SYSTEM_NAME.' Account Invite', $email, $info);

    }

    public function get_user($user_string)
    {
        // Selected user table data
        $selected_columns = [
            'first_name',
            'email',
            'last_name',
            'user_id'
        ];

        // User table query
        $query = $this->db->select($selected_columns)
            ->from('users')
            ->where('email', strtolower($user_string))
            ->limit(1)
            ->get();
        return $query->row();

    }

    public function get_facility($user_string)
    {
        // Selected user table data
        $selected_columns = [
            'facility_name', 'facility_id',
        ];

        // User table query
        $query = $this->db->select($selected_columns)
            ->from('strack_facilities')
            ->where('accountsfacility_id', $user_string)
            ->limit(1)
            ->get();
        return $query->row();

    }

    public function create_facility_repository($facilityid){
        $codingfolderPath= OPCODING_REPOSITORY . $facilityid;
        if(FALSE !== ($path = $this->folder_exist($codingfolderPath)))
        {
            $log_action = 'OPCODING_REPOSITORY Exists';
            $log_info = $path;
            $this->writelog->writelog(0, $log_action, $log_info);
        }else{
            mkdir($codingfolderPath, 0777, true) || chmod($codingfolderPath, 0777);
        }


        $notesfolderPath= OPNOTES_REPOSITORY . $facilityid;
        if(FALSE !== ($notespath = $this->folder_exist($notesfolderPath)))
        {
            $log_action = 'OPNOTES_REPOSITORY Exists';
            $log_info = $notespath;
            $this->writelog->writelog(0, $log_action, $log_info);
        }else{
            mkdir($notesfolderPath, 0777, true) || chmod($notesfolderPath, 0777);
        }


    }



    public function folder_exist($folder)
    {
        // Get canonicalized absolute pathname
        $path = realpath($folder);

        // If it exist, check if it's a directory
        return ($path !== false AND is_dir($path)) ? $path : false;
    }


//strack_facility_users

}