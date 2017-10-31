<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends MY_Controller
{

    private $pagescripts = "";
    private $table_tools = "";
    private $settings_tools = "";
    private $user_group = '';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('form_validation', 'alerts'));
        $this->load->helper(array('url', 'language'));

        $this->load->model(array('settings_model'));


        $this->pagescripts .= " <!-- Full Calendar -->
		<script src=\"" . base_url() . "assets/js/plugin/moment/moment.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/fullcalendar/jquery.fullcalendar.min.js\"></script>
                    
                ";
        $this->pagescripts .= "<!-- PAGE RELATED PLUGIN(S) -->";
        $this->pagescripts .= "<script src=\"" . base_url() . "assets/js/plugin/datatables/jquery.dataTables.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.colVis.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.tableTools.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.bootstrap.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatable-responsive/datatables.responsive.min.js\"></script> 
                <script src=\"" . base_url() . "assets/js/bootstrap/bootstrap-colorpicker.js\"></script>
                <script src=\"" . base_url() . "assets/js/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js\"></script>
               ";
        $this->settings_tools = ''
            . ' <script src="' . base_url() . 'assets/js/pages/table_tools.js"></script> ';
        $this->settings_tools = ''
            . ' <script src="' . base_url() . 'assets/js/pages/settings_tools.js"></script> ';


        $this->general_tools = '<script src="' . base_url() . 'assets/js/plugin/select2/js/select2.js"></script>'
            . '<script src="' . base_url() . 'assets/js/plugin/bootstrap-duallistbox/jquery.bootstrap-duallistbox.js"></script>	'
            . '<script src="' . base_url() . 'assets/js/pages/general_tools.js"></script>';
        $this->general_tools .= '<script src="' . base_url() . 'assets/js/pages/settings_general_tools.js"></script>';

        if (!$this->is_logged_in()) {
            redirect('auth', 'refresh');
        } else {
            if (!empty($this->auth_role)) {
                $this->data['usergroup'] = $this->auth_role;
                $this->user_id = $this->auth_user_id;
                $this->usergroup = $this->auth_role;
                // $default_firm = $this->settings_model->get_myfirm($user_id);
                //$this->data['default_firm'] = $default_firm->firm_name;
                // $default_department = $this->user_model->get_users_department($user_id);
            } else {
                redirect('auth', 'refresh');
            }
        }
    }

    public function index()
    {
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_page('settings/index', $this->data, true);

    }

    public function add_edit()
    {


        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/add_edit_theatre', $this->data, true);

    }

    public function procedures($id = "")
    {

        $this->data['category'] = $this->settings_model->get_category();
        $this->data['procedure_groups'] = $this->settings_model->get_procedure_groups();
        $this->data['procedure_subgroups'] = $this->settings_model->procedure_subgroups_list();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/procedures', $this->data, true);

    }

    public function procedure_data()
    {
        $group = $this->input->post('group');
        $sub_group = $this->input->post('sub_group');
        // die($sub_group);
        $json = $this->settings_model->get_procedure($group, $sub_group);

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_procedure()
    {
        $procedure_id = $this->input->post('procedure');
        $procedures = $this->settings_model->get_procedure_list($procedure_id);
        echo json_encode($procedures);
    }

    public function get_myprocedure()
    {
        $procedures = $this->settings_model->get_procedure();
        echo json_encode($procedures);
    }

    public function ajaxget_procedure()
    {
        $id = $this->input->post('procedure_id');
        echo json_encode($this->settings_model->get_procedure_by_id($id));
    }

    public function ajaxget_category_by_procedureid()
    {
        $id = $this->input->post('procedure');
        echo json_encode($this->settings_model->ajaxget_category_by_procedureid($id));
    }

    public function ajaxget_by_procedure_category()
    {
        $id = $this->input->post('category');
        echo json_encode($this->settings_model->ajaxget_by_procedure_category($id));
    }

    //Add_edit Christian Union
    public function create_procedure()
    {
        $this->data['title'] = "Create Procedures";
        $id = $this->input->post('procedure_id');
        // validate form input

        $this->form_validation->set_rules('procedure_name', 'Procedure name', 'required');
        $this->form_validation->set_rules('category', 'Category', 'required');
        $this->form_validation->set_rules('sub_group_id', 'Sub Group', 'required');
        $this->form_validation->set_rules('group_id', 'Group', 'required');
        $this->form_validation->set_rules('procedure_description', 'Procedure description', 'required', 'trim');


        if ($this->form_validation->run() == true) {

            $data = array(
                'procedure_name' => $this->input->post('procedure_name'),
                'procedure_fullname' => $this->input->post('procedure_fullname'),
                'category_id' => $this->input->post('category'),
                'rpl_code' => $this->input->post('rpl_code'),
                'group_id' => $this->input->post('group_id'),
                'subgroup_id' => $this->input->post('sub_group_id'),
                'service_fee' => $this->input->post('service_fee'),
                'procedure_description' => $this->input->post('procedure_description'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );
        }

        if ($id == 0) {
            if ($this->form_validation->run() == true && $this->settings_model->procedure_insert($data)) {

                $this->session->set_flashdata('message', "You have succesfully created a new Procedure");
            }
        } else {
            if ($this->form_validation->run() == true && $this->settings_model->procedure_update($data, $id)) {

                $this->session->set_flashdata('message', "you have succesfully Updated '" . $this->input->post('procedure_name') . "' details");
            }
        }
        redirect('settings/procedures');
    }

    //delete Procedures
    public function delete_procedure_o()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_procedure($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Procedure as it attached to cases");
        } else {
            $this->settings_model->delete_procedure($id);
        }
        redirect('settings/procedures');
    }

    public function delete_procedure()
    {
        $procedure_id = $this->input->post('procedure_id');
        if ($this->settings_model->delete_procedure($procedure_id)) {
            $return = array('procedure_id' => $procedure_id,
                'message' => 'You have succesfully deleted a  procedure',
                'success' => 1);
            echo json_encode($return);
        } else {
            $return = array('procedure_id' => $procedure_id,
                'message' => 'Procedure delete failed',
                'success' => 0);
            echo json_encode($return);
        }
    }

    public function assign_departmental_procedures()
    {
        // $id = $this->input->post();
        $this->form_validation->set_rules('department', 'Department name', 'required');
        // $this->form_validation->set_rules('procedure_dual', 'Procedures', 'required');
        $user_id = $this->auth_user_id;
        $i = 0;
        $j = 0;
        if ($this->form_validation->run() == true) {
            $procedure_dual = $this->input->post('procedure_dual');
            $department_id = $this->input->post('department');
            if (!empty($procedure_dual)) {
                $this->settings_model->delete_procedure_department($department_id, $user_id);

                foreach ($procedure_dual as $val) {
                    $data = array(
                        'department_id' => $department_id,
                        'procedure_id' => $val,
                        'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_by' => $user_id,
                    );
                    $this->settings_model->procedure_department_insert($data, $val, $department_id) ? $i++ : $j++;
                }
                $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Success!</strong> The procedure subsetting has successfully been created ' . $i . ' records added and ' . $j . ' records updated
                            </div');
            } else {

                $this->session->set_flashdata('message', '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Error!</strong> Failed, the procedure subsetting has failed: check if procedures are selected
                            </div');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Error!</strong> Failed, the procedure subsetting has failed
                            </div');
        }
        redirect('settings/procedures_subset');
    }

    //====================================
    //     Catergory
    //===================================

    public function category($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['category'] = $this->settings_model->get_category_by_id($id);
        }

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/category', $this->data, true);

    }

    public function category_data()
    {
        $json = $this->settings_model->get_category();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_category()
    {
        $category_id = $this->input->post('category');
        $category = $this->settings_model->get_category_list($category_id);
        echo json_encode($category);
    }

    public function ajaxget_category()
    {
        $id = $this->input->post('category_id');
        echo json_encode($this->settings_model->get_category_by_id($id));
    }

    //Add_edit Christian Union
    public function create_category()
    {
        $this->data['title'] = "Create Category";
        $id = $this->input->post('category_id');
        // validate form input

        $this->form_validation->set_rules('category_name', 'required');
        $this->form_validation->set_rules('category_description', 'required', 'trim');


        if ($this->form_validation->run() == true) {

            $data = array(
                'category_name' => $this->input->post('category_name'),
                'category_description' => $this->input->post('category_description'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );
        }

        if ($id == 0) {
            if ($this->form_validation->run() == true && $this->settings_model->category_insert($data)) {

                $this->session->set_flashdata('message', "You have succesfully created a new category");
            }
        } else {
            if ($this->form_validation->run() == true && $this->settings_model->category_update($data, $id)) {

                $this->session->set_flashdata('message', "you have succesfully Updated '" . $this->input->post('category_name') . "' details");
            }
        }
        redirect('settings/category');
    }

    //delete Procedures
    public function delete_category()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_category($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Procedure as it attached to cases");
        } else {
            $this->settings_model->delete_category($id);
        }
        redirect('settings/category');
    }

    //====================================
    //     Procedure Groups
    //===================================

    public function procedure_groups($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['procedure_group'] = $this->settings_model->procedure_groups_by_id($id);
        }

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/procedure_groups', $this->data, true);

    }

    public function procedure_groups_data()
    {
        $json = $this->settings_model->procedure_groups_list();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_procedure_groups()
    {
        $procedure_group_id = $this->input->post('procedure_group_id');
        $procedure_group = $this->settings_model->get_procedure_groups_list($procedure_group_id);
        echo json_encode($procedure_group);
    }

    public function ajaxget_procedure_groups()
    {
        $id = $this->input->post('group_id');
        echo json_encode($this->settings_model->get_procedure_groups_by_id($id));
    }

    //Add_edit Christian Union
    public function create_procedure_groups()
    {
        $this->data['title'] = "Create Procedure Group";
        $id = $this->input->post('group_id');
        // validate form input

        $this->form_validation->set_rules('group_name', 'Group Name', 'required');


        if ($this->form_validation->run() == true) {

            $data = array(
                'group_name' => $this->input->post('group_name'),
                'group_description' => $this->input->post('group_description'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );
        }

        if ($id == 0) {
            if ($this->form_validation->run() == true && $this->settings_model->procedure_groups_insert($data)) {

                $this->session->set_flashdata('message', "You have succesfully created a new procedure Group");
            }
        } else {
            if ($this->form_validation->run() == true && $this->settings_model->procedure_groups_update($data, $id)) {

                $this->session->set_flashdata('message', "you have succesfully Updated '" . $this->input->post('group_name') . "' details");
            }
        }
        redirect('settings/procedure_groups');
    }

    //delete Procedures
    public function delete_procedure_groups()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_procedure_groups($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Procedure group as it attached to cases");
        } else {
            $this->settings_model->delete_procedure_groups($id);
        }
        redirect('settings/procedure_groups');
    }

    //====================================
    //     PROCEDURE SubGroups
    //===================================

    public function procedure_subgroups($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['procedure_subgroup'] = $this->settings_model->procedure_subgroups_by_id($id);
        }

        $this->data['procedure_groups'] = $this->settings_model->get_procedure_groups();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/procedure_subgroups', $this->data, true);

    }

    public function procedure_subgroups_data()
    {
        $json = $this->settings_model->procedure_subgroups_list();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_procedure_subgroups()
    {
        $category_id = $this->input->post('group_id');
        $category = $this->settings_model->get_category_list($category_id);
        echo json_encode($category);
    }

    public function ajaxget_procedure_subgroups()
    {
        $id = $this->input->post('group_id');
        echo json_encode($this->settings_model->get_category_by_id($id));
    }

    //Add_edit Christian Union
    public function create_procedure_subgroups()
    {
        $this->data['title'] = "Create Sub Group";
        $id = $this->input->post('subgroup_id');
        // validate form input

        $this->form_validation->set_rules('subgroup_name', 'Sub Group Name', 'required');
        $this->form_validation->set_rules('group_id', 'Group', 'required|trim');


        if ($this->form_validation->run() == true) {

            $data = array(
                'subgroup_name' => $this->input->post('subgroup_name'),
                'group_id' => $this->input->post('group_id'),
                'subgroup_description' => $this->input->post('subgroup_description'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );
        }

        if ($id == 0) {
            if ($this->form_validation->run() == true && $this->settings_model->procedure_subgroups_insert($data)) {

                $this->session->set_flashdata('message', "You have succesfully created a new Sub Group");
            }
        } else {
            if ($this->form_validation->run() == true && $this->settings_model->procedure_subgroups_update($data, $id)) {

                $this->session->set_flashdata('message', "you have succesfully Updated '" . $this->input->post('category_name') . "' details");
            }
        }
        redirect('settings/procedure_subgroups');
    }

    //delete Procedures
    public function delete_procedure_subgroups()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_category($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Procedure as it attached to cases");
        } else {
            $this->settings_model->delete_category($id);
        }
        redirect('settings/procedure_subgroups');
    }

    //===================================
    //       FACILITIES
    //===================================

    public function facilities($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['facility'] = $this->settings_model->get_facilities_by_id($id);
        }

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/facilities', $this->data, true);

    }

    public function facilities_data()
    {
        $json = $this->settings_model->get_facilities();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_facilities()
    {
        $procedure_id = $this->input->post('facility');
        $procedures = $this->settings_model->get_facilities_list($procedure_id);
        echo json_encode($procedures);
    }

    public function ajaxget_facilities()
    {
        $id = $this->input->post('facility_id');
        echo json_encode($this->settings_model->get_facilities_by_id($id));
    }

    //Add_edit Christian Union
    public function create_facility()
    {
        $this->data['title'] = "Create Facility";
        $id = $this->input->post('facility_id');
        // validate form input

        $this->form_validation->set_rules('facility_name', 'Facility_name', 'required');


        if ($this->form_validation->run() == true) {

            $data = array(
                'facility_name' => $this->input->post('facility_name'),
                'facility_town' => $this->input->post('facility_town'),
                'facility_phone' => $this->input->post('facility_phone'),
                'facility_address' => $this->input->post('facility_address')
            );


            if ($id == 0) {
                if ($this->form_validation->run() == true && $this->settings_model->facilities_insert($data)) {

                    $this->session->set_flashdata('message', "You have succesfully created a new Facility");
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->facilities_update($data, $id)) {

                    $this->session->set_flashdata('message', "you have succesfully Updated '" . $this->input->post('facility_name') . "' details");
                }
            }
            redirect('settings/facilities');
        } else {
            $data = array(
                'facility_name' => $this->input->post('facility_name'),
                'facility_town' => $this->input->post('facility_town'),
                'facility_phone' => $this->input->post('facility_phone'),
                'facility_address' => $this->input->post('facility_address'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            $this->data['facility'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/facilities', $this->data, true);
        }
    }

    public function create_dropbox_facility_folder()
    {
        $id = $this->input->post('facility_id');
        $dropbox_folder = $this->settings_model->get_facilities_by_id($id)->facility_name;
        $this->load->library('dropbox');
        $this->dropbox->create_dropbox_folder(preg_replace('/\s+/', '', $dropbox_folder));
    }

    //delete Procedures
    public function delete_facilities()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_facilities($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Facility has theatres");
        } else {
            $this->settings_model->delete_facilities($id);
        }
        redirect('settings/facilities');
    }

    //===================================
    //       Theatres
    //===================================
    public function theatres($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['theatre'] = $this->settings_model->get_theatres_by_id($id);
        }
        $this->data['facilities'] = $this->settings_model->get_facilities_list();

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/theatres', $this->data, true);

    }

    public function theatres_data()
    {
        $json = $this->settings_model->get_theatres();

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
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->theatres_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('theatre_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('settings/theatres');
        } else {
            $data = array(
                'facility_id' => $this->input->post('facility'),
                'theatre_name' => $this->input->post('theatre_name'),
                'theatre_phone' => $this->input->post('theatre_phone'),
                'theatre_info' => $this->input->post('theatre_info')
            );
            $this->data['theatre'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/theatres', $this->data, true);
        }
    }

    //delete Procedures
    public function delete_theatres()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_theatres($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Theatre has cases");
        } else {
            $this->settings_model->delete_theatres($id);
        }
        redirect('settings/theatres');
    }

    //===================================
    //       WARDS
    //===================================
    public function wards($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['wardslocation'] = $this->settings_model->get_wards_by_id($id);
        }
        $this->data['facilities'] = $this->settings_model->get_facilities_list();

        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/wards', $this->data, true);

    }

    public function wards_data()
    {
        $json = $this->settings_model->get_wards();

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
                    $this->alerts->set_error("You have succesfully created a new theatre");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->wards_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('theatre_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('settings/wards');
        } else {
            $data = array(
                'facility_id' => $this->input->post('facility'),
                'ward_name' => $this->input->post('ward_name'),
                'ward_phone' => $this->input->post('ward_phone'),
                'ward_info' => $this->input->post('ward_info')
            );
            $this->data['theatre'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/wards', $this->data, true);
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
        redirect('settings/wards');
    }

    //===================================
    //       Time Slots
    //===================================
    public function timeslots($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['timeslot'] = $this->settings_model->get_timeslots_by_id($id);
        }

        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/timeslots', $this->data, true);

    }

    public function timeslots_data()
    {
        $json = $this->settings_model->get_timeslots();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_timeslots()
    {
        $procedure_id = $this->input->post('ward');
        $procedures = $this->settings_model->get_timeslots_list($procedure_id);
        echo json_encode($procedures);
    }

    public function ajaxget_timeslots()
    {
        $id = $this->input->post('facility_id');
        echo json_encode($this->settings_model->get_timeslots_by_id($id));
    }

    //Add_edit Christian Union
    public function create_timeslots()
    {
        $this->data['title'] = "Create Time slot";
        $id = $this->input->post('timeslot_id');
        // validate form input

        $this->form_validation->set_rules('slot_name', 'time slots Name', 'required|TRIM');
        $this->form_validation->set_rules('slot_value', 'time slots value', 'required|numeric');


        if ($this->form_validation->run() == true) {

            $data = array(
                'slot_name' => $this->input->post('slot_name'),
                'slot_value' => $this->input->post('slot_value'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            if ($id == 0) {
                if ($this->form_validation->run() == true && $this->settings_model->timeslots_insert($data)) {
                    $this->alerts->set_error("You have succesfully created a new time slot");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->timeslots_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('timeslot_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('settings/timeslots');
        } else {
            $data = array(
                'timeslot_name' => $this->input->post('timeslot_name')
            );
            $this->data['timeslot'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/timeslots', $this->data, true);
        }
    }

    //delete Procedures
    public function delete_timeslots()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_timeslots($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Ward/Location has cases");
        } else {
            $this->settings_model->delete_timeslots($id);
        }
        redirect('settings/timeslots');
    }

    //===================================
    //       Departments
    //===================================
    public function departments($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['department'] = $this->settings_model->get_department_by_id($id);
        }
        $this->data['facilities'] = $this->settings_model->get_facilities_list();

        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/departments', $this->data, true);

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
        $json = $this->settings_model->get_departments();

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

    //Add_edit Christian Union
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
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->departments_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('department_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('settings/departments');
        } else {
            $data = array(
                'facility_id' => $this->input->post('facility'),
                'department_name' => $this->input->post('department_name'),
                'department_phone' => $this->input->post('department_phone'),
                'department_info' => $this->input->post('department_info')
            );
            $this->data['department'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/departments', $this->data, true);
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
        redirect('settings/departments');
    }

    //===================================
    //       Firms
    //===================================
    public function firms($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['firm'] = $this->settings_model->get_firms_by_id($id);
        }
        $this->data['departments'] = $this->settings_model->get_departments_list();

        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/firms', $this->data, true);

    }

    public function firms_data()
    {
        $json = $this->settings_model->get_firms();

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
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->firms_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('firm_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('settings/firms');
        } else {
            $data = array(
                'department_id' => $this->input->post('department'),
                'firm_name' => $this->input->post('firm_name'),
                'firm_phone' => $this->input->post('firm_phone'),
                'firm_info' => $this->input->post('firm_info')
            );
            $this->data['theatre'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/firms', $this->data, true);
        }
    }

    //delete Procedures
    public function delete_firms()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_firms($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this firms has cases");
        } else {
            $this->settings_model->delete_firms($id);
        }
        redirect('settings/firms');
    }

    //===================================
    //       Insurance
    //===================================
    public function insurance_companies($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['insurance'] = $this->settings_model->get_insurance_companies_id($id);
        }

        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/insurance_companies', $this->data, true);

    }

    public function insurance_companies_data()
    {
        $json = $this->settings_model->get_insurance_companies();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_insurance_companies()
    {
        $insuranceco_id = $this->input->post('insurance');
        $insuranceco = $this->settings_model->insurance_companies_list($insuranceco_id);
        echo json_encode($procedures);
    }

    public function ajaxget_insurance_companies()
    {
        $id = $this->input->post('insuranceco__id');
        echo json_encode($this->settings_model->get_insurance_companies_by_id($id));
    }

    //Add_edit Christian Union
    public function create_insurance_companies()
    {
        $this->data['title'] = "Create Insurance Companies";
        $id = $this->input->post('insuranceco_id');
        // validate form input

        $this->form_validation->set_rules('insuranceco_name', 'insuranceco_name', 'required|TRIM');


        if ($this->form_validation->run() == true) {

            $data = array(
                'insuranceco_name' => $this->input->post('insuranceco_name'),
                'insuranceco_phone' => $this->input->post('insuranceco_phone'),
                'insuranceco_email' => $this->input->post('insuranceco_email'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            if ($id == 0) {
                if ($this->form_validation->run() == true && $this->settings_model->insurance_companies_insert($data)) {
                    $this->alerts->set_error("You have succesfully created a new Insurance");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->insurance_companies_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('insuranceco_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('settings/insurance_companies');
        } else {
            $data = array(
                'insuranceco_name' => $this->input->post('insuranceco_name'),
                'insuranceco__phone' => $this->input->post('insuranceco__phone'),
                'insuranceco__email' => $this->input->post('insuranceco__email')
            );
            $this->data['insurance'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/insurance_companies', $this->data, true);
        }
    }

    //delete Procedures
    public function delete_insurance_companies()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_insurance_companies($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this Theatre has cases");
        } else {
            $this->settings_model->delete_insurance_companies($id);
        }
        redirect('settings/insurance_companies');
    }

    //===================================
    //       Suburbs
    //===================================
    public function suburbs($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['suburb'] = $this->settings_model->get_suburb_by_id($id);
        }
        $this->data['city'] = $this->settings_model->get_cities_list();

        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/suburbs', $this->data, true);

    }

    public function suburbs_data()
    {
        $json = $this->settings_model->get_suburbs();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    function get_suburb()
    {
        $procedure_id = $this->input->post('city');
        $procedures = $this->settings_model->get_suburb_list($procedure_id);
        echo json_encode($procedures);
    }

    public function ajaxget_suburb()
    {
        $id = $this->input->post('facility_id');
        echo json_encode($this->settings_model->get_suburb_by_id($id));
    }

    //Add_edit Christian Union
    public function create_suburb()
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
                if ($this->form_validation->run() == true && $this->settings_model->suburb_insert($data)) {
                    $this->alerts->set_error("You have succesfully created a new department");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->suburb_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('department_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('settings/suburbs');
        } else {
            $data = array(
                'facility_id' => $this->input->post('facility'),
                'department_name' => $this->input->post('department_name'),
                'department_phone' => $this->input->post('department_phone'),
                'department_info' => $this->input->post('department_info')
            );
            $this->data['department'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/suburbs', $this->data, true);
        }
    }

    //delete Procedures
    public function delete_suburb()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_suburb($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this department has firms");
        } else {
            $this->settings_model->delete_suburb($id);
        }
        redirect('settings/suburbs');
    }

    public function ajaxget_suburb_by_postcode()
    {
        $id = $this->input->post('postal_code');
        echo json_encode($this->settings_model->ajaxget_suburb_by_postcode($id));
    }

    public function ajax_get_suburbs()
    {
        echo json_encode($this->settings_model->get_allsuburbs());
    }

    /**
     * Returns the application assets URL.
     *
     * @access    private
     * @return    string
     */
    function assets_url($path = '')
    {
        if (substr($path, 0) == '/') {
            return base_url() . "assets" . $path;
        } else {
            return base_url() . "assets/" . $path;
        }
    }

    public function calendar()
    {
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/calendar', $this->data, true);
    }

    public function nappi_consumables($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['nappi_consumable'] = $this->settings_model->get_nappi_consumables_by_id($id);
        }

        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/nappi_consumables', $this->data, true);

    }

    public function add_nappi_consumable()
    {
        $this->data['title'] = "Create Nappi Consumable";
        $id = $this->input->post('consumable_id');
        // validate form input

        $this->form_validation->set_rules('product_name', 'Product Name', 'required');
        $this->form_validation->set_rules('nappi_code', 'Nappi Code', 'required|TRIM');
        $this->form_validation->set_rules('pack', 'Pack', 'required|TRIM');


        if ($this->form_validation->run() == true) {

            $data = array(
                'product_name' => $this->input->post('product_name'),
                'nappi_code' => $this->input->post('nappi_code'),
                'product_description' => $this->input->post('product_description'),
                'pack' => $this->input->post('pack'),
                'price' => $this->input->post('price'),
                'mnf_code' => $this->input->post('mnf_code'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            if ($id == 0) {
                if ($this->form_validation->run() == true && $this->settings_model->nappi_consumables_insert($data)) {
                    $this->alerts->set_error("You have succesfully created a new nappi code");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            } else {
                if ($this->form_validation->run() == true && $this->settings_model->nappi_consumables_update($data, $id)) {
                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('product_name') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }
            redirect('settings/nappi_consumables');
        } else {
            $data = array(
                'product_name' => $this->input->post('product_name'),
                'nappi_code' => $this->input->post('nappi_code'),
                'product_description' => $this->input->post('product_description'),
                'pack' => $this->input->post('pack'),
                'price' => $this->input->post('price'),
                'mnf_code' => $this->input->post('mnf_code')
            );
            $this->data['nappi_consumable'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/nappi_consumables', $this->data, true);
        }
    }

    public function nappi_consumables_data()
    {
        $json = $this->settings_model->get_nappi_consumables();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function delete_nappi_consumables()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_nappi_consumables($id) == 1) {
            $this->session->set_flashdata('message', "You cannot delete this consumable, it has been used before");
        } else {
            $this->settings_model->delete_nappi_consumables($id);
        }
        redirect('settings/nappi_consumables');
    }

    public function rpl_procedures($id = "")
    {
        if ($id != "" && is_numeric($id)) {
            $this->data['rpl_procedures'] = $this->settings_model->get_rpl_procedurecodes_by_id($id);
        }

        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['category'] = $this->settings_model->get_category();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/rpl_procedures', $this->data, true);

    }

    public function add_rpl_procedurecodes()
    {
        $id = $this->input->post('rpl_id');
        //$data = $this->input->post();

        $this->data['title'] = "Create Nappi Consumable";

        // validate form input

        $this->form_validation->set_rules('procedure', 'Procedure Name', 'required');
        $this->form_validation->set_rules('rpl_code', 'Nappi Code', 'required|TRIM');


        if ($this->form_validation->run() == true) {

            $data = array(
                'procedure_id' => $this->input->post('procedure'),
                'rpl_code' => $this->input->post('rpl_code'),
                'service_fee' => $this->input->post('service_fee'),
                'rpl_decsription' => $this->input->post('rpl_description'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id,
            );

            if ($id == 0) {
                if ($this->form_validation->run() == true) {
                    $return = array('rpl_id' => $this->settings_model->rpl_procedurecodes_insert($data),
                        'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully  new RPL code.
                            </div> ',
                        'rpl_code' => $this->input->post('rpl_code'),
                        'success' => 1);


                    $this->alerts->set_error("You have succesfully created a new RPL code");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            } else {
                if ($this->form_validation->run() == true) {
                    if ($this->settings_model->rpl_procedurecodes_update($data, $id)) {
                        $return = array('rpl_id' => $id,
                            'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully updated  RPL code.
                            </div> ',
                            'rpl_code' => $this->input->post('rpl_code'),
                            'success' => 1);
                    }

                    $this->alerts->set_error("you have succesfully Updated '" . $this->input->post('rpl_code') . "' details");
                    $this->session->set_flashdata('message', $this->alerts->messages());
                }
            }

            echo json_encode($return);
        } else {
            $data = array(
                'procedure_id' => $this->input->post('procedure'),
                'rpl_code' => $this->input->post('rpl_code'),
                'service_fee' => $this->input->post('service_fee'),
                'rpl_decsription' => $this->input->post('rpl_description')
            );
            $this->data['rpl_procedures'] = $data;
            // set the flash data error message if there is one
            $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('settings/rpl_procedures', $this->data, true);
        }
    }

    public function rpl_procedurecodes_data()
    {
        $json = $this->settings_model->get_rpl_procedurecodes();

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function delete_rpl_procedure()
    {
        $id = $this->uri->segment(3);
        if ($this->settings_model->delete_rpl_procedurecodes($id) == 1) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Error!</strong> You cannot delete this RPL Procedure, it has been used before
                            </div');
        } else {
            $this->settings_model->delete_rpl_procedurecode($id);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Success!</strong> You\'ve  deleted this RPL code
                            </div');
        }
        redirect('settings/rpl_procedures');
    }

    public function rpl_nappi_consumables($rpl_id)
    {
        if ($rpl_id != "" && is_numeric($rpl_id)) {
            $this->data['rpl_procedures'] = $this->settings_model->get_rpl_procedurecodes_by_id($rpl_id);
        }

        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['category'] = $this->settings_model->get_category();
        $this->data['consumables'] = $this->settings_model->get_nappi_consumables();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/rpl_nappi', $this->data, true);

    }

    public function rpl_nappi_codes_data()
    {
        $rpl_id = $this->input->post('rpl_id');
        $json = $this->settings_model->get_rpl_nappi_consumables($rpl_id);

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function add_rpl_nappi_consumables()
    {
        $data = array(
            'consumable_id' => $this->input->post('consumable_id'),
            'procedure_id' => $this->input->post('rpl_id'),
            'created_on' => date('Y-m-d H:i:s', strtotime('now')),
            'created_by' => $this->auth_user_id,
        );

        if ($this->settings_model->rpl_nappi_consumables_insert($data, $this->input->post('consumable_id'), $this->input->post('rpl_id'))) {
            $return = array('consumable_id' => $this->input->post('consumable_id'),
                'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully added consumable to RPL code.
                            </div> ',
                'success' => 1);
            echo json_encode($return);
        } else {
            $return = array('consumable_id' => $this->input->post('consumable_id'),
                'message' => '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Error!</strong> Process failed.
                            </div>',
                'success' => 0);
            echo json_encode($return);
        }
    }

    public function remove_rpl_nappi_codes()
    {
        $rpl_nappi_id = $this->input->post('rpl_nappi_id');
        if ($this->settings_model->delete_rpl_nappi($rpl_nappi_id)) {
            $return = array('rpl_nappi_id' => $rpl_nappi_id,
                'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully deleted a  Nappi-RPL records.
                            </div> ',
                'success' => 1);

            $this->session->set_flashdata('message', "You have succesfully deleted Nappi-RPL records");
            $log_action = 'Nappi-RPL  Delete';
            $log_info = 'Nappi-RPL records has been deleted ' . date('Y-m-d H:i:s', strtotime('now')) . '  #' . serialize($return);
            $this->writelog->writelog($this->auth_user_id, 'Nappi-RPL records has been deleted :' . $rpl_nappi_id, "#" . serialize($return));

            echo json_encode($return);
        } else {
            $return = array('rpl_nappi_id' => $rpl_nappi_id,
                'message' => '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Error!</strong> Nappi-RPL records delete failed.
                            </div>',
                'success' => 0);

            $log_action = 'Nappi-RPL Delete failed';
            $log_info = 'Nappi-RPL records delete has failed ' . date('Y-m-d H:i:s', strtotime('now')) . '  #' . serialize($return);
            $this->writelog->writelog($this->auth_user_id, 'Nappi-RPL records delete has failed:' . $rpl_nappi_id, "#" . serialize($return));

            echo json_encode($return);
        }
    }

    public function procedures_subset()
    {

        $this->data['departments'] = $this->settings_model->get_departments_list();
        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['category'] = $this->settings_model->get_category();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('settings/procedures_subset', $this->data, true);

    }

}
