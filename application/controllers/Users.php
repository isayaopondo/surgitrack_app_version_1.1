<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Users extends MY_Controller
{

    private $pagescripts = "";
    private $table_tools = ' ';
    private $user_group = '';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array( 'form_validation', 'alerts'));
        $this->load->helper(array('url', 'language', 'form', 'string'));
        $this->load->library('notificationmanager');
        $this->load->model(array('user_model', 'settings_model','setup_model'));


        $this->pagescripts .= "<!-- Full Calendar -->
		<script src=\"" . base_url() . "assets/js/plugin/moment/moment.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/fullcalendar/jquery.fullcalendar.min.js\"></script>                    
		<script src=\"" . base_url() . "assets/js/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js\"></script>
                ";
        $this->pagescripts .= "<!-- PAGE RELATED PLUGIN(S) -->";
        $this->pagescripts .= "<script src=\"" . base_url() . "assets/js/plugin/datatables/jquery.dataTables.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.colVis.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.tableTools.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.bootstrap.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatable-responsive/datatables.responsive.min.js\"></script> 
                 <script src=\"" . base_url() . "assets/js/bootstrap/bootstrap-colorpicker.js\"></script>";
        $this->pagescripts .= '<!--AUTOCOMPLETE -->'
            . '<script src="' . base_url() . 'assets/js/autocomplete/jquery.easy-autocomplete.min.js"></script>';
        $this->table_tools = ''
            . ' <script src="' . base_url() . 'assets/js/pages/table_tools.js"></script> ';
        $this->general_tools = ''
            . ' <script src="' . base_url() . 'assets/js/plugin/select2/js/select2.js"></script>'
            . ' <script src="' . base_url() . 'assets/js/pages/general_tools.js"></script> ';

        $this->is_logged_in();
        if ($this->require_min_level(1)) {
            $this->data['usergroup'] = $this->auth_role;
            $this->user_id = $this->auth_user_id;
            $this->usergroup = $this->auth_role;

            $default_firm = $this->settings_model->get_myfirm($this->auth_user_id);
            if (!empty($default_firm)) {
                $this->data['default_firm'] = $default_firm ? $default_firm->firm_name : '';
                $this->data['default_firm_color'] = !empty($default_firm->firm_color) ? $default_firm->firm_color : '#000000';
            } else {
                $this->data['default_firm'] = 'DEFAULT';
                $this->data['default_firm_color'] = '#000000';
            }

            //CHECK IF FACILITY IS SETUP
            if (!$this->setup_model->is_setup_complete($this->auth_facilityid)) {

                if ($this->usergroup == 'admin') {
                    redirect('setup/my_setup', 'refresh');
                } elseif ($this->usergroup != 'admin') {
                    redirect('setup/setup_fail', 'refresh');
                }
            }
        }
    }

    public function index()
    {
        $this->data['roles'] = config_item('levels_and_roles');
        $id = $this->uri->segment(3);
        if ($id != "" && is_numeric($id)) {
            $this->data['user'] = $this->setup_model->get_User_by_id($id);
        }

        $this->data['users'] = $this->setup_model->get_users($this->auth_facilityid);
        //$this->data['usergroups'] = $this->user_model->get_user_groups();

        $this->data['departments'] = $this->settings_model->get_departments($this->auth_facilityid);
        $this->data['firms'] = $this->settings_model->get_firms_list($this->auth_facilityid);
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools.$this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/index', $this->data, true);

    }

    public function create_user()
    {
        $this->load->helper('auth');
        $this->load->model('Authorization/authorization_model');
        $this->load->model('Authorization/validation_callables');
        $this->load->library('form_validation');

        $admin = $this->input->post();
        $user_data = [
            'email' => $admin['email'],
            'auth_level' => $admin['auth_level'], // 9 if you want to login @ examples/index.
            'phone_number' => $admin['phone_number'],
            'first_name' => $admin['first_name'],
            'last_name' => $admin['last_name'],
        ];
        $this->form_validation->set_data($admin);

        $validation_rules = [
            [
                'field' => 'first_name',
                'label' => 'first_name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'First Name field is required.'
                ]

            ],
            [
                'field' => 'department',
                'label' => 'department',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Department field is required.'
                ]

            ],

            [
                'field' => 'last_name',
                'label' => 'last_name',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Last name field is required.'
                ]

            ],

            [
                'field' => 'username',
                'label' => 'username',
                'rules' => 'max_length[12]|is_unique[' . db_table('user_table') . '.username]',
                'errors' => [
                    'is_unique' => 'Username already in use.'
                ]
            ],

            [
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required|valid_email|is_unique[' . db_table('user_table') . '.email]',
                'errors' => [
                    'is_unique' => 'Email address already in use.'
                ]
            ],
            [
                'field' => 'auth_level',
                'label' => 'auth_level',
                'rules' => 'required|integer|in_list[1,6,9]'
            ]
        ];

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $password = get_random_password(8, 8, true, true);

            $user_data['token'] = random_string('alnum', 64);
            $user_data['username'] = NULL;
            $user_data['passwd'] = $this->authentication->hash_passwd($password);
            $user_data['user_id'] = $this->authorization_model->get_unused_id();
            $user_data['created_at'] = date('Y-m-d H:i:s');
            $stmt = $this->api_model->_user_insert($user_data, $password, $this->auth_facilityid, $this->auth_facilityname);
            if ($stmt['success'] == '1') {
                //Add to department and Firm

                if (!empty($this->input->post('department'))) {
                    $data_department = array(
                        'user_id' => $user_data['user_id'],
                        'department_id' => $this->input->post('department'),
                        'current_user' => '1',
                        'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_by' => $this->auth_user_id,
                    );
                    $this->api_model->add_user_department($data_department);


                }
                if (!empty($this->input->post('firm'))) {
                    $data_firm = array(
                        'user_id' => $user_data['user_id'],
                        'firm_id' => $this->input->post('firm'),
                        'current_user' => '1',
                        'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_by' => $this->auth_user_id,
                    );
                    $this->api_model->add_user_firm($data_firm);
                }
                $data_setup = [
                    'facility_id' => $this->auth_facilityid,
                    'is_users' => 1,
                    'modified_at' => date('Y-m-d H:i:s', strtotime('now'))
                ];
                $this->api_model->update_facility_setup($data_setup, $this->auth_facilityid);

                $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> ' . $stmt['message'] . '
                            </div> ');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> ' . $stmt['message'] . '
                            </div> ');
            }


        }


        $this->data['roles'] = config_item('levels_and_roles');
        $id = $this->uri->segment(3);
        if ($id != "" && is_numeric($id)) {
            $this->data['user'] = $this->setup_model->get_User_by_id($id);
        }

        $this->data['users'] = $this->setup_model->get_users($this->auth_facilityid);
        //$this->data['usergroups'] = $this->user_model->get_user_groups();

        $this->data['departments'] = $this->settings_model->get_departments($this->auth_facilityid);
        $this->data['firms'] = $this->settings_model->get_firms_list($this->auth_facilityid);
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/index', $this->data, true);

    }


    public function password_change()
    {
        $this->load->helper('auth');
        $this->load->model('Authorization/authorization_model');
        $this->load->model('Authorization/validation_callables');
        $this->load->library('form_validation');

        $admin = $this->input->post();


        $this->form_validation->set_data($admin);

        $validation_rules = [
            [
                'field' => 'old_password',
                'label' => 'old_password',
                'rules' => 'required|callback_oldpassword_check',
                'errors' => [
                    'required' => 'Current password field is required.'
                ]

            ],


            [
                'field' => 'new_confirm_password',
                'label' => 'Confirm password',
                'rules'   => 'required|matches[new_password]',
                'errors' => [
                    'required' => 'Password confirmation don\'t match.'
                ]

            ],
            [
                'field' => 'new_password',
                'label' => 'New Password',
                'rules' => [
                    'trim',
                    'required',
                    [
                        '_check_password_strength',
                        [$this->validation_callables, '_check_password_strength']
                    ]
                ],
                'errors' => [
                    'required' => 'The new password field is required.'
                ]
            ],


        ];

        $this->form_validation->set_rules($validation_rules);


        if ($this->form_validation->run()) {

            $password = $this->authentication->hash_passwd($admin['new_password']);

            $modified_at = date('Y-m-d H:i:s');

            //Update password
            $this->authorization_model->_reset_password($this->auth_user_id,$password);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> Password changed successfully
                            </div> ');
            }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa fa-fw  fa-check"></i>
                                    <strong>Error</strong> Password changed failed.
                            </div> ');
        }

        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;

        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/change_password', $this->data, true);

    }

    public function oldpassword_check($old_password){
        $this->load->helper('auth');
        $this->load->model('Authorization/authorization_model');
        $this->load->model('Authorization/validation_callables');
        $this->load->library('form_validation');

        $old_password_hash = $this->authentication->hash_passwd($old_password);
        $old_password_db_hash = $this->authorization_model->fetchPasswordHashFromDB($this->auth_user_id)->passwd;


        if($this->authentication->check_passwd($old_password_db_hash, $old_password_hash))
        {
            $this->form_validation->set_message('oldpassword_check', '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa fa-fw  fa-check"></i>
                                    <strong>Error</strong> Old password not match.
                            </div> ');
            return FALSE;
        }
        return TRUE;
    }

    // create a new user

    function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);
        return array($key => $value);
    }

    public function approve_department()
    {
        $userid = $this->input->post('userid');
        $department = $this->input->post('department');
        if ($this->user_model->approve_department($userid, $department)) {
            echo "Approved";
        } else {
            echo "Approval Failed";
        }
    }

    public function delink_department()
    {
        $userid = $this->input->post('userid');
        $department = $this->input->post('department');
        if ($this->user_model->delink_department($userid, $department)) {
            echo "De-Linked";
        } else {
            echo "De-link Failed";
        }
    }

    public function approve_firm()
    {
        $userid = $this->input->post('userid');
        $firm = $this->input->post('firm');
        if ($this->user_model->approve_firm($userid, $firm)) {
            echo "Approved";
        } else {
            echo "Approval Failed";
        }
    }

    public function delink_firm()
    {
        $userid = $this->input->post('userid');
        $firm = $this->input->post('firm');
        if ($this->user_model->delink_firm($userid, $firm)) {
            echo "De-Linked";
        } else {
            echo "De-link Failed";
        }
    }

    public function default_firm()
    {
        $userid = $this->input->post('userid');
        $firm = $this->input->post('firm');
        $department = $this->input->post('department');
        if ($this->user_model->default_firm($userid, $firm, $department)) {
            echo "Default firm set";
        } else {
            echo "Failed";
        }
    }

    function _valid_csrf_nonce()
    {
        if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function roles()
    {
        $this->data['pagescripts'] = $this->pagescripts;
        $this->data['title'] = "User Roles";
//        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->auth_user_id == $id))) {
//            redirect('auth', 'refresh');
//        }

        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/users_roles', $this->data, true);
    }

    public function user_groups()
    {
        $this->data['pagescripts'] = $this->pagescripts;
        $this->data['levels'] = $this->user_model->get_groups();
        $this->_smart_render('users/users_groups', $this->data, true);
    }

    function groups()
    {
        $this->data['title'] = "User Groups";
//        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->auth_user_id == $id))) {
//            redirect('auth', 'refresh');
//        }
        $this->data['levels'] = $this->user_model->get_groups();
        $this->data['pagescripts'] = $this->pagescripts;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/users_groups', $this->data, true);
    }

    //create user
    function create()
    {
        $data = $this->input->post('user');
        if ($this->input->post('userid') == 0) {

            $this->user_model->add($data);
        } else {
            $this->user_model->update_user($data, $this->input->post('userid'));
        }
        redirect("users");
    }

    function delete_user()
    {
        $id = $this->uri->segment(3);
        $this->user_model->delete_user($id);
        redirect("users");
    }

    function ajaxgetuser()
    {
        $id = $this->input->post('id');
        $levels = $this->input->post('idlevels');
        echo json_encode($this->user_model->get_user_by_id($id));
    }

    function ajaxgetuserunit()
    {
        $id = $this->input->post('id');
        //$levels = $this->input->post('idlevels');
        echo json_encode($this->user_model->get_user_by_id($id));
    }

    function ajaxget_edit()
    {
        $id = $this->input->post('id');
        echo json_encode($this->user_model->get_user_by_id($id));
    }

    public function assign_units($level, $user_id)
    {
        $this->data['pagescripts'] = $this->pagescripts;
        $this->load->library('form_validation');
        $this->data['title'] = "Assign subcounties";

        // $this->form_validation->set_rules('userid', 'User Id', 'trim|required');
        // $this->form_validation->set_rules('userlevel', 'User Level', 'trim|required');

        if ($level == 5) {
            //if ($this->form_validation->run() == true) {
            $data = array(
                'user_id' => $user_id,
                'unit_id' => $this->input->post('subcounty'),
                'user_level' => $level,
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'date_updated' => date('Y-m-d H:i:s', strtotime('now')),
                'assigned_by' => $this->auth_user_id,
            );
            $this->user_model->create_subcounty_user($data);
            redirect('users/usersmanage/' . $user_id);
            // }
        } elseif ($level == 4) {
            // if ($this->form_validation->run() == true) {
            $data = array(
                'user_id' => $user_id,
                'unit_id' => $this->input->post('facility'),
                'user_level' => $level,
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'date_updated' => date('Y-m-d H:i:s', strtotime('now')),
                'assigned_by' => $this->auth_user_id,
            );
            $this->user_model->create_facility_user($data);
            redirect('users/usersmanage/' . $user_id);
            //   }
        } elseif ($level == 6) {
            // if ($this->form_validation->run() == true) {
            $data = array(
                'user_id' => $user_id,
                'unit_id' => $this->input->post('chu'),
                'user_level' => $level,
                'assigned_by' => $this->auth_user_id,
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'date_updated' => date('Y-m-d H:i:s', strtotime('now')),
            );
            $this->user_model->create_chu_user($data);
            redirect('users/usersmanage/' . $user_id);
            //  }
        } elseif ($level == 7) {
            //   if ($this->form_validation->run() == true) {
            $data = array(
                'user_id' => $user_id,
                'unit_id' => $this->input->post('cluster'),
                'user_level' => $level,
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'date_updated' => date('Y-m-d H:i:s', strtotime('now')),
                'assigned_by' => $this->auth_user_id,
            );
            $this->user_model->create_cluster_user($data);
            redirect('users/usersmanage/' . $user_id);
            // }
        } else {
            redirect('users/usersmanage/' . $user_id);
        }
    }

    public function usersmanage()
    {
        $id = $this->uri->segment(3);
        $this->data['firms'] = $this->settings_model->get_firms_list($this->auth_facilityid);
        $this->data['facilities'] = $this->settings_model->get_facilities_list($this->auth_facilityid);
        $this->data['departments'] = $this->settings_model->get_departments_list($this->auth_facilityid);
        $this->data['user'] = $this->user_model->get_Users($this->auth_facilityid);
       $this->data['users'] = $this->user_model->get_user($id);
        $this->data['roles'] = config_item('levels_and_roles');
        $departments = $this->user_model->get_users_department($id);
        if (!empty($departments)) {
            $department_id = $departments->department_id;
            $this->data['myfirms'] = $this->settings_model->get_mydefault_firms($id, $department_id);
        } else {
            $this->data['myfirms'] = array();
        }
        $this->data['myfacilities'] = $this->settings_model->get_myfacilities_list($id);
        $this->data['mydepartments'] = $this->settings_model->get_mydepartments_list($id);

        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;

        $this->_smart_render('users/user_manage', $this->data, true);
    }

    public function user_unassign_unit()
    {
        $userid = $this->input->post('userid');
        $unit_id = $this->input->post('unit_id');
        $this->load->library('form_validation');
        $this->data['title'] = "Assign subcounties";

        $this->form_validation->set_rules('userid', 'User Id', 'trim|required');
        if ($this->form_validation->run() == true) {
            $this->user_model->unassign_unit($userid, $unit_id);
            redirect('users/usersmanage/' . $userid);
        } else {
            redirect('users/index');
        }
    }

    public function unassign_unit($userid, $unit_id)
    {

        $this->data['title'] = "Assign subcounties";

        if (isset($userid) && isset($unit_id)) {
            $this->user_model->unassign_unit($userid, $unit_id);
            redirect('users/usersmanage/' . $userid);
        } else {
            redirect('users/index');
        }
    }

    public function reassign_unit($userid, $unit_id)
    {

        $this->data['title'] = "Assign subcounties";

        if (isset($userid) && isset($unit_id)) {
            $this->user_model->reassign_unit($userid, $unit_id);
            redirect('users/usersmanage/' . $userid);
        } else {
            redirect('users/index');
        }
    }

    public function audit_trail_data()
    {
        $user_id = $this->input->post('userid');

        $json = $this->user_model->get_audit_trail($user_id);

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function audit_trail_data_all()
    {
        $json = $this->user_model->get_audit_trail_all();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }



    public function audit_trail()
    {
        $this->data['title'] = "Audit Trail";

        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;

        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/audit_trail', $this->data, true);
    }

    public function change_password()
    {
        //_get_csrf_nonce();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;

        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/change_password', $this->data, true);
    }

    public function profile()
    {

        $user_id = $this->auth_user_id;

        $department = $this->user_model->get_users_department($user_id);
        if (!empty($department)) {
            $this->data['my_departmentalfirms'] = $this->settings_model->get_mydefault_firms($user_id, $department->department_id);
        } else {
            $this->data['my_departmentalfirms'] = '';
        }
        //$this->data['participantdetails'] = $this->user_model->get_partcipant_by_user_id($user_id);
        $this->data['myprofile'] = $this->user_model->get_user_by_id($user_id);
        $this->data['departments'] = $this->settings_model->get_departments_list($this->auth_facilityid);
        $this->data['facilities'] = $this->settings_model->get_facilities_list($this->auth_facilityid);

        $this->data['mydepartments'] = $this->settings_model->get_mydepartments_filter_list($user_id);

        $this->data['mydepartment'] = $this->settings_model->get_mydepartment($user_id);

        $this->data['myfacilities'] = $this->settings_model->get_myfacilities_list($user_id);
        $this->data['firms'] = $this->settings_model->get_firms_list($this->auth_facilityid);
        $this->data['myfirms'] = $this->settings_model->get_myfirms_list($user_id);


        $this->data['pagescripts'] = $this->pagescripts . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('myaccount/profile', $this->data, true);

    }

    public function update_users()
    {
        $id = $this->auth_user_id;

        $this->form_validation->set_rules('first_name', 'First name', 'required');
        $this->form_validation->set_rules('last_name', 'Last name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');

        if ($this->form_validation->run() == true) {
            //$this->events_model->participants_update($data, $id);
            $data_user = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone_number' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'skype' => $this->input->post('skype'),
                'user_portfolio' => $this->input->post('user_portfolio'),
                'modified_at' => date('Y-m-d H:i:s', strtotime('now')),
                'modified_by' => $this->auth_user_id,
            );

            $this->user_model->update_user($data_user, $id);
            $this->alerts->set_error("You have succesifully updated '" . $this->input->post('first_name') . "' to Event");
            $this->session->set_flashdata('message', $this->alerts->messages());
        }

        redirect('users/profile');
    }

    public function create_user_facilities()
    {
        $id = $this->auth_user_id;

        $this->form_validation->set_rules('facility', 'facility', 'required');

        if ($this->form_validation->run() == true) {
            //$this->events_model->participants_update($data, $id);
            $data_user = array(
                'user_id' => $id,
                'facility_id' => $this->input->post('facility'),
                'current_user' => '1',
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            $this->user_model->add_user_facility($data_user);
            $this->alerts->set_error("You have successfully added a facility");
            $this->session->set_flashdata('message', $this->alerts->messages());
        }

        redirect('users/profile');
    }

    public function create_department_users()
    {
        $id = $this->auth_user_id;

        $this->form_validation->set_rules('department', 'department', 'required');

        if ($this->form_validation->run() == true) {
            $this->user_model->update_department(array('user_id' => $id, 'date_unassigned' => date('Y-m-d H:i:s', strtotime('now'))));

            $data_user = array(
                'user_id' => $id,
                'department_id' => $this->input->post('department'),
                'current_user' => '1',
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            $this->user_model->add_user_department($data_user);
            $this->alerts->set_error("You have succesifully updated '" . $this->input->post('first_name') . "' to Event");
            $this->session->set_flashdata('message', $this->alerts->messages());
        }

        redirect('users/profile');
    }

    public function create_department()
    {
        $id = $this->auth_user_id;
        $data = $this->input->post();
        if (!empty($data)) {
            unset($data['facility']);
            $remaining_options = $data;
            $data2 = array(
                'user_id' => $id,
                'current_user' => '1',
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );
            $arr = $remaining_options + $data2;
            if (isset($data['department_id']) && $data['department_id'] != '') {
                if ($this->user_model->add_user_department($arr)) {
                    echo $this->settings_model->get_department_firm_peruser($id, $data['department_id']);
                } else {
                    echo '<div  class="alert alert-danger">The department was not assigned correctly.</div>';
                }
            } else {
                echo '<div  class="alert alert-danger">Select a department to proceed!.</div>';
            }
        } else {
            echo '<div  class="alert alert-info">You din\'t select departments correcntly. </div>';
        }
    }


    public function check_user_department()
    {
        $id = $this->auth_user_id;
        $return = array('success' => $this->settings_model->check_user_has_department($id));
        echo json_encode($return);
    }

    public function remove_department()
    {
        $user_id = $this->input->post('user');
        $department = $this->input->post('department');

        $this->user_model->remove_department($user_id, $department);
    }

    public function create_firms_users()
    {
        $id = $this->auth_user_id;

        $this->form_validation->set_rules('firm', 'firm', 'required');

        if ($this->form_validation->run() == true) {
            //$this->events_model->participants_update($data, $id);
            $data_user = array(
                'user_id' => $id,
                'firm_id' => $this->input->post('firm'),
                'current_user' => '1',
                'date_assigned' => date('Y-m-d H:i:s', strtotime('now')),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            $this->user_model->add_user_firm($data_user);
            $this->alerts->set_error("You have succesifully updated '" . $this->input->post('first_name') . "' to Event");
            $this->session->set_flashdata('message', $this->alerts->messages());
        }

        redirect('users/profile');
    }

}
