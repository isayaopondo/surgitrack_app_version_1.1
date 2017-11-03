<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 02/11/2017
 * Time: 12:18
 */


defined('BASEPATH') OR exit('No direct script access allowed');

class Setup extends MY_Controller
{
    private $pagescripts = "";
    private $table_tools = "";
    private $setup_tools = "";
    private $usergroup = '';
    private $sstats = '';


    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('form_validation', 'alerts'));
        $this->load->helper(array('url', 'language', 'password', 'form', 'string'));
        $this->load->model(array('settings_model', 'setup_model', 'user_model', 'api_model'));
        $this->load->library('notificationmanager');

        $this->pagescripts .= " ";
        $this->pagescripts .= "<!-- PAGE RELATED PLUGIN(S) -->";
        $this->pagescripts .= "<script src=\"" . base_url() . "assets/js/plugin/datatables/jquery.dataTables.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.colVis.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.tableTools.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.bootstrap.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatable-responsive/datatables.responsive.min.js\"></script> 
                <script src=\"" . base_url() . "assets/js/bootstrap/bootstrap-colorpicker.js\"></script>
                <script src=\"" . base_url() . "assets/js/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js\"></script>
               ";
        $this->setup_tools = ''
            . ' <script src="' . base_url() . 'assets/js/pages/table_tools.js"></script> ';
        $this->setup_tools = ''
            . ' <script src="' . base_url() . 'assets/js/pages/setup_tools.js"></script> ';


        $this->general_tools = '<script src="' . base_url() . 'assets/js/plugin/select2/js/select2.js"></script>'
            . '<script src="' . base_url() . 'assets/js/plugin/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js"></script>	'
            . '<script src="' . base_url() . 'assets/js/pages/general_tools.js"></script>';
        $this->general_tools .= '<script src="' . base_url() . 'assets/js/pages/settings_general_tools.js"></script>';


        if (!$this->is_logged_in()) {
            redirect('auth', 'refresh');
        } else {
            if (!empty($this->auth_role)) {
                $this->data['usergroup'] = $this->auth_role;
                $this->data['sstats'] = $this->setup_model->get_setup_stats($this->auth_facilityid);
                $this->sstats = $this->setup_model->get_setup_stats($this->auth_facilityid);
                $this->user_id = $this->auth_user_id;
                $this->usergroup = $this->auth_role;

            } else {
                redirect('auth', 'refresh');
            }
        }
    }

    public function my_setup()
    {

        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_setup('setup/index', $this->data, true);
    }

//View
    public function users()
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
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_setup('setup/users', $this->data, true);


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
        $this->_render_setup('setup/users', $this->data, true);

        /* [
             'field' => 'username',
             'label' => 'username',
             'rules' => 'max_length[12]|is_unique[' . db_table('user_table') . '.username]',
             'errors' => [
                 'is_unique' => 'Username already in use.'
             ]
         ],*/
    }


    public function procedures()
    {
        $this->data['departments'] = $this->settings_model->get_departments_list();
        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['category'] = $this->settings_model->get_category();
        $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->_render_setup('setup/procedures', $this->data, true);
    }



    //Ops
    //===================================
    //       Theatres
    //===================================
    public function theatres($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['theatre'] = $this->settings_model->get_theatres_by_id($id);
        }
        $this->data['facilities'] = $this->settings_model->get_facilities_list($this->auth_facilityid);

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_setup('setup/theatres', $this->data, true);

    }

    public function theatres_data()
    {
        $json = $this->settings_model->get_theatres($this->auth_facilityid);

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_theatres()
    {
        $procedure_id = $this->input->post('theatre');
        $procedures = $this->settings_model->get_theatres_list($procedure_id);
        echo json_encode($procedures);
    }

    public function ajaxget_theatres()
    {
        $id = $this->input->post('facility_id');
        echo json_encode($this->settings_model->get_theatres_by_id($id));
    }

    //Add_edit Christian Union
    public function create_theatres()
    {
        $this->data['title'] = "Create Theatre";
        $id = $this->input->post('theatre_id');
        // validate form input

        $this->form_validation->set_rules('facility', 'Facility', 'required');
        $this->form_validation->set_rules('theatre_name', 'theatre_name', 'required|TRIM');


        if ($this->form_validation->run() == true) {

            $data = array(
                'facility_id' => $this->input->post('facility'),
                'theatre_name' => $this->input->post('theatre_name'),
                'theatre_phone' => $this->input->post('theatre_phone'),
                'theatre_info' => $this->input->post('theatre_info'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            if ($id == 0) {
                if ($this->form_validation->run() == true && $this->settings_model->theatres_insert($data)) {
                    $this->alerts->set_error("You have succesfully created a new theatre");
                    $this->session->set_flashdata('message', $this->alerts->messages());

                    $data_setup = [
                        'facility_id' => $this->auth_facilityid,
                        'is_theatres' => 1,
                        'modified_at' => date('Y-m-d H:i:s', strtotime('now'))
                    ];
                    $this->api_model->update_facility_setup($data_setup, $this->auth_facilityid);
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->theatres_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('theatre_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('setup/theatres');
        } else {
            $data = array(
                'facility_id' => $this->input->post('facility'),
                'theatre_name' => $this->input->post('theatre_name'),
                'theatre_phone' => $this->input->post('theatre_phone'),
                'theatre_info' => $this->input->post('theatre_info')
            );
            $this->data['theatre'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_setup('setup/theatres', $this->data, true);
        }
    }

    //delete theatres
    public function delete_theatres()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_theatres($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Theatre has cases");
        } else {
            $this->settings_model->delete_theatres($id);
        }
        redirect('setup/theatres');
    }

    //===================================
    //       WARDS
    //===================================
    public function wards($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['wardslocation'] = $this->settings_model->get_wards_by_id($id);
        }

        $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_setup('setup/wards', $this->data, true);

    }

    public function wards_data()
    {
        $json = $this->settings_model->get_wards($this->auth_facilityid);

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_wards()
    {
        $procedure_id = $this->input->post('ward');
        $procedures = $this->settings_model->get_wards_list($procedure_id);
        echo json_encode($procedures);
    }

    public function ajaxget_wards()
    {
        $id = $this->input->post('facility_id');
        echo json_encode($this->settings_model->get_wards_by_id($id));
    }

    //Add_edit Christian Union
    public function create_wards()
    {
        $this->data['title'] = "Create Ward";
        $id = $this->input->post('ward_id');
        // validate form input

        $this->form_validation->set_rules('facility', 'Facility', 'required');
        $this->form_validation->set_rules('ward_name', 'Ward/Location Name', 'required|TRIM');


        if ($this->form_validation->run() == true) {

            $data = array(
                'facility_id' => $this->input->post('facility'),
                'ward_name' => $this->input->post('ward_name'),
                'ward_phone' => $this->input->post('ward_phone'),
                'ward_info' => $this->input->post('ward_info'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            if ($id == 0) {
                if ($this->form_validation->run() == true && $this->settings_model->wards_insert($data)) {

                    $data_setup = [
                        'facility_id' => $this->auth_facilityid,
                        'is_wards' => 1,
                        'modified_at' => date('Y-m-d H:i:s', strtotime('now'))
                    ];

                    $this->api_model->update_facility_setup($data_setup, $this->auth_facilityid);

                    $this->alerts->set_error("You have succesfully created a new theatre");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->wards_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('theatre_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('setup/wards');
        } else {
            $data = array(
                'facility_id' => $this->input->post('facility'),
                'ward_name' => $this->input->post('ward_name'),
                'ward_phone' => $this->input->post('ward_phone'),
                'ward_info' => $this->input->post('ward_info')
            );
            $this->data['theatre'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_setup('setup/wards', $this->data, true);
        }
    }

    //delete Procedures
    public function delete_wards()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_wards($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Ward/Location has cases");
        } else {
            $this->settings_model->delete_wards($id);
        }
        redirect('setup/wards');
    }


    //===================================
    //       Departments
    //===================================
    public function departments($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['department'] = $this->settings_model->get_departments_by_id($id);
        }

        $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_setup('setup/departments', $this->data, true);

    }

    public function create_dropbox_department_folder()
    {
        $id = $this->input->post('department_id');
        $department = $this->settings_model->get_department_facility($id);
        $dropbox_folder = '/' . $department->facility_name . '/' . $department->department_name;
        $this->load->library('dropbox');
        $this->dropbox->create_dropbox_folder(preg_replace('/\s+/', '', $dropbox_folder));
    }

    public function departments_data()
    {
        $json = $this->settings_model->get_departments($this->auth_facilityid);

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_departments()
    {
        $procedure_id = $this->input->post('theatre');
        $procedures = $this->settings_model->get_departments_list($procedure_id);
        echo json_encode($procedures);
    }

    public function ajaxget_departments()
    {
        $id = $this->input->post('facility_id');
        echo json_encode($this->settings_model->get_departments_by_id($id));
    }

    public function ajaxget_departments_facility()
    {
        $user_id = $this->auth_user_id;
        $id = $this->input->post('facility_id');
        echo json_encode($this->settings_model->ajaxget_departments_facility($id, $user_id));
    }

    //Add_ departments
    public function create_departments()
    {
        $this->data['title'] = "Create Theatre";
        $id = $this->input->post('theatre_id');
        // validate form input

        $this->form_validation->set_rules('facility', 'Facility', 'required');
        $this->form_validation->set_rules('department_name', 'department_name', 'required|TRIM');


        if ($this->form_validation->run() == true) {

            $data = array(
                'facility_id' => $this->input->post('facility'),
                'department_name' => $this->input->post('department_name'),
                'department_phone' => $this->input->post('department_phone'),
                'department_info' => $this->input->post('department_info'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            if ($id == 0) {
                if ($this->form_validation->run() == true && $this->settings_model->departments_insert($data)) {
                    $this->alerts->set_error("You have succesfully created a new department");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                    $data_setup = [
                        'facility_id' => $this->auth_facilityid,
                        'is_departments' => 1,
                        'modified_at' => date('Y-m-d H:i:s', strtotime('now'))
                    ];
                    $this->api_model->update_facility_setup($data_setup, $this->auth_facilityid);
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->departments_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('department_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('setup/departments');
        } else {
            $data = array(
                'facility_id' => $this->input->post('facility'),
                'department_name' => $this->input->post('department_name'),
                'department_phone' => $this->input->post('department_phone'),
                'department_info' => $this->input->post('department_info')
            );
            $this->data['department'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_setup('setup/departments', $this->data, true);
        }
    }

    //delete Procedures
    public function delete_departments()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_departments($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this department has firms");
        } else {
            $this->settings_model->delete_departments($id);
        }
        redirect('setup/departments');
    }

    //===================================
    //       Firms
    //===================================
    public function firms($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['firm'] = $this->settings_model->get_firms_by_id($id);
        }
        $this->data['departments'] = $this->settings_model->get_departments_list($this->auth_facilityid);

        $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_setup('setup/firms', $this->data, true);

    }

    public function firms_data()
    {
        $json = $this->settings_model->get_firms($this->auth_facilityid);

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_firms()
    {
        $procedure_id = $this->input->post('theatre');
        $procedures = $this->settings_model->get_firms_list($procedure_id);
        echo json_encode($procedures);
    }

    public function ajaxget_firms()
    {
        $id = $this->input->post('facility_id');
        echo json_encode($this->settings_model->get_firms_by_id($id));
    }

    public function ajaxget_department_firms()
    {
        $user_id = $this->auth_user_id;
        $id = $this->input->post('department_id');
        echo json_encode($this->settings_model->get_firms_by_department($id, $user_id));
    }

    public function ajaxget_department_firms_surgeon()
    {
        $firm_id = $this->input->post('firm_id');
        echo json_encode($this->settings_model->get_firms_users($firm_id));
    }

    public function create_dropbox_firm_folder()
    {
        $id = $this->input->post('firm_id');
        $dropbox_folder = $this->settings_model->get_dropbox_folder_structure($id);
        $this->load->library('dropbox');
        $this->dropbox->create_dropbox_folder(preg_replace('/\s+/', '', $dropbox_folder));
    }

    //Add_edit Christian Union
    public function create_firms()
    {
        $this->data['title'] = "Create Theatre";
        $id = $this->input->post('firm_id');
        // validate form input

        $this->form_validation->set_rules('department', 'Department', 'required');
        $this->form_validation->set_rules('firm_name', 'Firm Name', 'required|TRIM');

        $this->data['departments'] = $this->settings_model->get_departments_list();
        if ($this->form_validation->run() == true) {

            $data = array(
                'department_id' => $this->input->post('department'),
                'firm_name' => $this->input->post('firm_name'),
                'firm_phone' => $this->input->post('firm_phone'),
                'firm_color' => $this->input->post('firm_color'),
                'firm_info' => $this->input->post('firm_info'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            if ($id == 0) {
                if ($this->form_validation->run() == true && $this->settings_model->firms_insert($data)) {
                    $this->alerts->set_error("You have succesfully created a new firm");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                    $data_setup = [
                        'facility_id' => $this->auth_facilityid,
                        'is_firms' => 1,
                        'modified_at' => date('Y-m-d H:i:s', strtotime('now'))
                    ];
                    $this->api_model->update_facility_setup($data_setup, $this->auth_facilityid);
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->firms_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('firm_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('setup/firms');
        } else {
            $data = array(
                'department_id' => $this->input->post('department'),
                'firm_name' => $this->input->post('firm_name'),
                'firm_phone' => $this->input->post('firm_phone'),
                'firm_info' => $this->input->post('firm_info')
            );
            $this->data['theatre'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->setup_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_render_setup('setup/firms', $this->data, true);
        }
    }

    //delete firms
    public function delete_firms()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_firms($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this firms has cases");
        } else {
            $this->settings_model->delete_firms($id);
        }
        redirect('setup/firms');
    }

    public function procedures_subset()
    {

        $this->data['departments'] = $this->settings_model->get_departments_list();
        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['category'] = $this->settings_model->get_category();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_setup('settings/procedures_subset', $this->data, true);

    }

    public function setup_fail()
    {
        $this->data['error_message'] = '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-exclamation-triangle"></i>
                                    <strong>Error:</strong> The facility has not been fully setup! Kindly contact your administrator!.
                            </div> ';
        $this->data['pagescripts'] = $this->general_tools;
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->session->flashdata('message')));
        $this->_render_setupfail('dashboard/no_setup', $this->data, false);
    }


}
