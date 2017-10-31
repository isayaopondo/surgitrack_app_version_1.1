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
        $this->lang->load('auth');
        $this->load->model(array('user_model', 'settings_model'));


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
        }
    }

    public function index()
    {
        $id = $this->uri->segment(3);


        $this->data['facilities'] = $this->settings_model->get_facilities_list();
        $this->data['view'] = $this->user_model->get_user_by_id($id);
        $this->data['view_group'] = $this->user_model->get_user_group($id);
        $this->data['users'] = $this->user_model->get_users();
        $this->data['usergroups'] = $this->user_model->get_user_groups();
        $this->data['departments'] = $this->settings_model->get_departments();
        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/index', $this->data, true);

    }

    public function grouplist()
    {
        $this->data['pagescripts'] = $this->pagescripts;
        $this->data['usergroups'] = $this->user_model->get_groups();
        $this->data['levels'] = $this->user_model->get_groups();
        $this->_smart_render('users/index', $this->data, true);
    }

    function create_user()
    {
        $this->data['pagescripts'] = $this->pagescripts;
        $this->data['title'] = "Create User";


        if (empty($this->input->post('userid'))) {
            $tables = $this->config->item('tables', 'ion_auth');
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            // validate form input
            $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
            $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
            if ($identity_column !== 'email') {
                $this->form_validation->set_rules('identity', $this->lang->line('create_user_validation_identity_label'), 'required|is_unique[' . $tables['users'] . '.' . $identity_column . ']');
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
            } else {
                $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
            }
            $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
            // $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
            $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']');
            //  $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
            if ($this->form_validation->run() == true) {
                $email = strtolower($this->input->post('email'));
                $identity = ($identity_column === 'email') ? $email : $this->input->post('identity');
                $password = $this->input->post('password');
                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'user_group' => $this->input->post('user_group'),
                    'phone' => $this->input->post('phone'),
                );
                $group = array($this->input->post('user_group'));
            }
            if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data, $group)) {
                // check to see if we are creating the user
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("users/index", 'refresh');
            } else {
                // display the create user form
                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

                // $data['view']             = $this->user_model->get_user_by_id($id);
                $this->data['users'] = $this->user_model->get_users();
                $this->data['usergroups'] = $this->user_model->get_user_groups();
                $this->_smart_render('users/index', $this->data, true);
            }
        } else {
            $id = $this->input->post('userid');
            $user = $this->ion_auth->user($id)->row();
            $groups = $this->ion_auth->groups()->result_array();
            $currentGroups = $this->ion_auth->get_users_groups($id)->result();
            // validate form input
            $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
            $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
            $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
            //$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
            if (isset($_POST) && !empty($_POST)) {
                // do we have a valid request?
                //if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('userid')) {
                //    show_error($this->lang->line('error_csrf'));
                //}

                if ($this->form_validation->run() === TRUE) {
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'department_id' => $this->input->post('department'),
                        'phone' => $this->input->post('phone'),
                        'username' => $this->input->post('user_name'),
                        'facility_ids' => $this->input->post('facility'),
                    );

                    // Only allow updating groups if user is admin
                    if ($this->ion_auth->is_admin()) {
                        //Update the groups user belongs to
                        $groupData = array($this->input->post('user_group')); //$this->input->post('user_group');
                        if (isset($groupData) && !empty($groupData)) {
                            $this->ion_auth->remove_from_group('', $id);
                            foreach ($groupData as $grp) {
                                $this->ion_auth->add_to_group($grp, $id);
                            }
                        }
                    }
                    // check to see if we are updating the user
                    if ($this->ion_auth->update($user->user_id, $data)) {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        if ($this->ion_auth->is_admin()) {
                            redirect('auth', 'refresh');
                        } else {
                            redirect('users/index', 'refresh');
                        }
                    } else {
                        // redirect them back to the admin page if admin, or to the base url if non admin
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        if ($this->ion_auth->is_admin()) {
                            redirect('auth', 'refresh');
                        } else {
                            redirect('users/index', 'refresh');
                        }
                    }
                }
            }
            // display the edit user form
            $this->data['csrf'] = $this->_get_csrf_nonce();
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            // pass the user to the view
            $this->data['user'] = $user;
            $this->data['groups'] = $groups;
            $this->data['currentGroups'] = $currentGroups;


            $this->data['view'] = $this->user_model->get_user_by_id($id);
            $this->data['users'] = $this->user_model->get_users();
            $this->data['usergroups'] = $this->user_model->get_user_groups();
            $this->_smart_render('users/index', $this->data, true);
        }
    }

    // edit a user
    function edit_user($id)
    {
        $this->data['pagescripts'] = $this->pagescripts;
        $this->data['title'] = "Edit User";
//        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->auth_user_id == $id))) {
//            redirect('auth', 'refresh');
//        }
        $user = $this->ion_auth->user($id)->row();
        $groups = $this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();
        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');
        if (isset($_POST) && !empty($_POST)) {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id')) {
                show_error($this->lang->line('error_csrf'));
            }
            // update the password if it was posted
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }
            if ($this->form_validation->run() === TRUE) {
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'company' => $this->input->post('company'),
                    'phone' => $this->input->post('phone'),
                );
                // update the password if it was posted
                if ($this->input->post('password')) {
                    $data['password'] = $this->input->post('password');
                }
                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin()) {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');
                    if (isset($groupData) && !empty($groupData)) {
                        $this->ion_auth->remove_from_group('', $id);
                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }
                    }
                }
                // check to see if we are updating the user
                if ($this->ion_auth->update($user->id, $data)) {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages());
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                } else {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    if ($this->ion_auth->is_admin()) {
                        redirect('auth', 'refresh');
                    } else {
                        redirect('/', 'refresh');
                    }
                }
            }
        }
        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;
        $this->data['first_name'] = array(
            'name' => 'first_name',
            'id' => 'first_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('first_name', $user->first_name),
        );
        $this->data['last_name'] = array(
            'name' => 'last_name',
            'id' => 'last_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('last_name', $user->last_name),
        );
        $this->data['company'] = array(
            'name' => 'company',
            'id' => 'company',
            'type' => 'text',
            'value' => $this->form_validation->set_value('company', $user->company),
        );
        $this->data['phone'] = array(
            'name' => 'phone',
            'id' => 'phone',
            'type' => 'text',
            'value' => $this->form_validation->set_value('phone', $user->phone),
        );
        $this->data['password'] = array(
            'name' => 'password',
            'id' => 'password',
            'type' => 'password'
        );
        $this->data['password_confirm'] = array(
            'name' => 'password_confirm',
            'id' => 'password_confirm',
            'type' => 'password'
        );
        $data['view'] = $this->user_model->get_user_by_id($id);
        $this->data['users'] = $this->user_model->get_users();
        $this->data['usergroups'] = $this->user_model->get_user_groups();
        $this->_smart_render('users/index', $this->data, true);
    }

    // create a new group
    function create_group()
    {
        $this->data['pagescripts'] = $this->pagescripts;
        $this->data['title'] = $this->lang->line('create_group_title');
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('users/users_groups', 'refresh');
        }
        // validate form input
        $this->form_validation->set_rules('group_name', 'Group Name', 'required');
        if ($this->form_validation->run() == TRUE) {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if ($new_group_id) {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("users/groups", 'refresh');
            }
        } else {
            // display the create group form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $this->data['group_name'] = array(
                'name' => 'group_name',
                'id' => 'group_name',
                'type' => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name' => 'description',
                'id' => 'description',
                'type' => 'text',
                'value' => $this->form_validation->set_value('description'),
            );
            $this->_smart_render('users/groups', $this->data, true);
        }
    }

    // edit a group
    function edit_group($id)
    {
        // bail if no group id given
        if (!$id || empty($id)) {
            redirect('auth', 'refresh');
        }
        $this->data['title'] = $this->lang->line('edit_group_title');
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('users/groups', 'refresh');
        }
        $group = $this->ion_auth->group($id)->row();
        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');
        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);
                if ($group_update) {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("users/groups", 'refresh');
            }
        }
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
        // pass the user to the view
        $this->data['group'] = $group;
        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';
        $this->data['group_name'] = array(
            'name' => 'group_name',
            'id' => 'group_name',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name' => 'group_description',
            'id' => 'group_description',
            'type' => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );
        $this->_smart_render('users/edit_group', $this->data, true);
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
        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['facilities'] = $this->settings_model->get_facilities_list();
        $this->data['departments'] = $this->settings_model->get_departments_list();
        $this->data['assigned_unit'] = $this->user_model->get_user_units($id);
        $this->data['past_assigned_unit'] = $this->user_model->get_past_user_units($id);
        //$this->data['regions'] = $this->transu_model->get_regions();
        $this->data['usergroups'] = $this->user_model->get_groups();
        $this->data['user'] = $this->user_model->get_Users();
        $this->data['users'] = $this->user_model->get_user($id);

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

    public function permissions()
    {
        $this->data['title'] = "User Permissions";
        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->auth_user_id == $id))) {
            redirect('auth', 'refresh');
        }
        $this->data['levels'] = $this->user_model->get_groups();
        $this->data['pagescripts'] = $this->pagescripts;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/permissions', $this->data, true);
    }

    public function audit_trail()
    {
        $this->data['title'] = "Audit Trail";
        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->auth_user_id == $id))) {
            redirect('auth', 'refresh');
        }
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;

        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('users/audit_trail', $this->data, true);
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
        $this->data['departments'] = $this->settings_model->get_departments_list();
        $this->data['facilities'] = $this->settings_model->get_facilities_list();

        $this->data['mydepartments'] = $this->settings_model->get_mydepartments_filter_list($user_id);

        $this->data['mydepartment'] = $this->settings_model->get_mydepartment($user_id);

        $this->data['myfacilities'] = $this->settings_model->get_myfacilities_list($user_id);
        $this->data['firms'] = $this->settings_model->get_firms_list();
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
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'skype' => $this->input->post('skype'),
                'user_portfolio' => $this->input->post('user_portfolio'),
                'more_info' => $this->input->post('more_info'),
                'modified_on' => date('Y-m-d H:i:s', strtotime('now')),
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
