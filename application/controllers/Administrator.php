<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends MY_Controller {

    private $pagescripts = '';
    private $case_list = '';
    private $table_tools = ' ';
    private $general_tools = '';
    private $user_group = '';

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library(array( 'form_validation', 'writelog'));
        $this->load->helper(array('url', 'language'));

        $this->load->model(array('settings_model', 'booking_model', 'patients_model', 'user_model', 'administrator_model','setup_model'));
        $this->pagescripts .= "<!-- Full Calendar -->
		<script src=\"" . base_url() . "assets/js/plugin/moment/moment.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/fullcalendar/jquery.fullcalendar.min.js\"></script> 
                <script src=\"" . base_url() . "assets/js/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js\"></script>
               
		";
        //

        $this->pagescripts .= "<!-- PAGE RELATED PLUGIN(S) -->";
        $this->pagescripts .= "<script src=\"" . base_url() . "assets/js/plugin/datatables/jquery.dataTables.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.colVis.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.tableTools.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.bootstrap.min.js\"></script>
		<script src=\"" . base_url() . "assets/js/plugin/datatable-responsive/datatables.responsive.min.js\"></script> 
                 <script src=\"" . base_url() . "assets/js/bootstrap/bootstrap-colorpicker.js\"></script>";
        $this->case_list = '
                 <script src="' . base_url() . 'assets/js/pages/case_list.js"></script>';
        $this->table_tools = '<script src="' . base_url() . 'assets/js/pages/settings_tools.js"></script>
                 <script src="' . base_url() . 'assets/js/pages/table_tools.js"></script>
                <script src="' . base_url() . 'assets/js/pages/filters.js"></script> ';
        
        $this->dual_list = '<script src=\""' . base_url() . '"assets/plugins/bootstrap-duallistbox/dist/jquery.bootstrap-duallistbox.min.js\"></script>';
        $this->dual_list_css = '<link rel="stylesheet" type="text/css" href=\"' . base_url() . 'assets/plugins/bootstrap-duallistbox/src/bootstrap-duallistbox.css">';

        $this->calendar = ' <script src="' . base_url() . 'assets/js/pages/calendar_settings.js"></script> ';
        $this->general_tools = ' <script src="' . base_url() . 'assets/js/plugin/select2/js/select2.js"></script>'
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

    public function index() {

            // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
            //$this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            //$this->_render_page('support/index', $this->data, true);

            redirect('/', 'refresh');

    }

    public function mapt() {
       
            $user_id = $this->auth_user_id;
            $department_id = $this->user_model->get_users_department($user_id)->department_id;
            $this->data['departments'] = $this->settings_model->get_departments_list();
            $this->data['procedures'] = $this->settings_model->get_procedure();
            $this->data['category'] = $this->settings_model->get_category();
            $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('administrator/mapt-form', $this->data, true);
       
    }

    public function create_mapt() {
        $id = $this->input->post('mapt_id');
        $data = $this->input->post();

        if ($data['mapt_id'] == 0 || is_null($data['mapt_id'])) {
            if (!empty($data)) {

                //$options = $data['options'];
                //unset($data['options']);
                //unset($data['bank_path']);
                //unset($data['bank_item_id']);
                $remaining_options = $data;
                $data2 = array(
                    'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                    'created_by' => $this->auth_user_id
                );
                $arr = $remaining_options + $data2;

                $return = array('mapt_id' => $this->booking_model->mapt_insert($arr),
                    'message' => 'You have succesifully created a new MAPT',
                    'mapt' => $this->input->post('mapt_name'),
                    'success' => 1);
                $qid = $return['mapt_id'];
                //$this->bank_model->item_choices_insert($options, $qid);

                echo json_encode($return);
                $this->session->set_flashdata('message', "You have succesifully created a new MAPT");
                $this->writelog->writelog($this->auth_user_id, 'Created New MAPT  ' . $this->input->post('mapt_name'), "#" . serialize($return));
            }
        }
    }

    public function create_mapt_criteria() {
        $id = $this->input->post('criteria_id');
        $data = $this->input->post();
        if ($data['criteria_id'] == 0 || is_null($data['criteria_id'])) {
            if (!empty($data)) {

                $options = $data['options'];
                unset($data['options']);
                $remaining_options = $data;
                $data2 = array(
                    'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                    'created_by' => $this->auth_user_id
                );
                $arr = $remaining_options + $data2;

                $return = array('criteria_id' => $this->booking_model->mapt_criteria_insert($arr),
                    'message' => 'You have succesifully created a new criteria',
                    'mapt' => $this->input->post('mapt_name'),
                    'success' => 1);
                $qid = $return['criteria_id'];
                $this->booking_model->mapt_scores_insert($options, $qid);
                echo json_encode($return);
                $this->session->set_flashdata('message', "You have succesifully created a new Criteria");
                $this->writelog->writelog($this->auth_user_id, 'Created MAPT Criteria  ' . $this->input->post('mapt_name'), "#" . serialize($return));
            }
        }
    }

    public function mapt_list_data() {
       
            $json = $this->booking_model->mapt_list_data();
       
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function search_mapt_details() {
        $mapt_id = $this->input->post('mapt_id');
        $mapt_details = $this->booking_model->get_mapt_details($mapt_id);
        $return = '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			MAPT DETAILS
		</div>'
                . '<table width="100%" class="table">'
                . '<tr class="success">'
                . '<th>MAPT Name:</th> <td>' . $mapt_details->mapt_name . '</td> <th>Department:</th> <td>' . $mapt_details->procedure_name . '</td> '
                . '</tr>'
                . '<tr class="danger">'
                . '<th>Procedure:</th><td>' . $mapt_details->procedure_name . '</td> <th>Category</th><td>' . $mapt_details->category_name . '</td> '
                . '</tr>'
                . '</table>';
        echo $return;
    }

    public function view_mapt_criteria() {

        $mapt_id = $this->input->post('mapt_id');
        $mapt_details = $this->booking_model->get_mapt_details($mapt_id);
        $return = '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			MAPT DETAILS
               </div>'
                . '<table width="100%" class="table">'
                . '<tr class="success">'
                . '<th>MAPT Name:</th> <td>' . $mapt_details->mapt_name . '</td> <th>Department:</th> <td>' . $mapt_details->department_name . '</td> '
                . '</tr>'
                . '<tr class="danger">'
                . '<th>Procedure:</th><td>' . $mapt_details->procedure_name . '</td> <th>Category</th><td>' . $mapt_details->category_name . '</td> '
                . '</tr>'
                . '</table>';

        $maptcriteria = $this->booking_model->get_mapt_criteria_details($mapt_id);
        $return .= '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			CRITERIA
		</div>';
        $return .= '<div class="well padding-10">'
                . '<div class="  alert alert-warning semi-bold">';
        foreach ($maptcriteria as $criteria_details) {
            $return .= '<div  class="row">';
            $return .= '<div class="col-sm-12 col-md-12 col-lg-4">'
                    . ''
                    . '<b>Criteria Name:</b> ' . $criteria_details->criteria_name . '<br> <b>Weight:</b> ' . $criteria_details->criteria_weight . '<br>  <b>Description:</b> ' . $criteria_details->additional_info . '';
            $criteria = $this->booking_model->get_mapt_criteria_score($criteria_details->criteria_id);

            $return .= '</div>';

            $return .= '<div class="col-sm-12 col-md-12 col-lg-8">';
            $return .= '<ul class="no-padding list-unstyled">'
                    . '<li class="alert alert-success semi-bold">';
            foreach ($criteria as $score) {
                $return .= '<b>' . $score->score_text . '</b> = ' . $score->score_value . ', ';
            }
            $return .= '</li></ul>';
            $return .= '</div>';

            $return .= '</div>';
            $return .= '<hr>';
        }
        $return .= '</div>';
        $return .= '</div>';
        echo $return;
    }

    public function mapt_entry_form() {

        $mapt_id = $this->input->post('mapt_id');
        $mapt_details = $this->booking_model->get_mapt_details($mapt_id);
        $return = '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			MAPT DETAILS
               </div>'
                . '<table width="100%" class="table">'
                . '<tr class="success">'
                . '<th>MAPT Name:</th> <td>' . $mapt_details->mapt_name . '</td> <th>Department:</th> <td>' . $mapt_details->department_name . '</td> '
                . '</tr>'
                . '<tr class="danger">'
                . '<th>Procedure:</th><td>' . $mapt_details->procedure_name . '</td> <th>Category</th><td>' . $mapt_details->category_name . '</td> '
                . '</tr>'
                . '</table>';

        $maptcriteria = $this->booking_model->get_mapt_criteria_details($mapt_id);
        $return .= '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			CRITERIA
		</div>';
        $return .= '<div class="well padding-10">'
                . '<div class="  alert alert-warning semi-bold">'
                . '<form class="smart-form">';
        foreach ($maptcriteria as $criteria_details) {
            $return .= '<fieldset>
                <section>
                            <label class="label">' . $criteria_details->criteria_name . '</label>
                            <div class="inline-group">';
            $criteria = $this->booking_model->get_mapt_criteria_score($criteria_details->criteria_id);
            foreach ($criteria as $score) {
                //$return .= '<b>' . $score->score_text . '</b> = ' . $score->score_value . ', ';
                $return .= '<label class="radio">
                                <input type="radio" name="mapt-' . $criteria_details->criteria_id . '">
                                <i></i>' . $score->score_text . '
                        </label>';
            }
            $return .= ' </div>
                    </section>
                    </fieldset>
                    ';
        }
        $return .= '</form>'
                . '</div>';
        $return .= '</div>';
        echo $return;
    }

    public function calendar_management() {
        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        } elseif ($this->ion_auth->locked()) {
            redirect('auth/page_lock', 'refresh');
        } else {
            $user_id = $this->auth_user_id;
            $this->data['pagescripts'] = $this->pagescripts . $this->calendar . $this->general_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('administrator/calendar_management', $this->data, true);
        }
    }

    public function calendar_blocking_data() {
        //Get all dates that are blocked
        $json = $this->administrator_model->get_blocked_surgery_slots();
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function block_calendar_date() {
        $id = $this->input->post('block_id');
        $this->form_validation->set_rules('blocked_reason', 'Reason for Blocking', 'required');
        $this->form_validation->set_rules('blocked_date', 'Starting Date/Time', 'required');
        $this->form_validation->set_rules('blocked_enddate', 'Ending Date/Time', 'required');
        $this->form_validation->set_rules('blocked_type', 'Type of Blocking', 'required');
        if ($this->form_validation->run() == true) {

            $data = array(
                'blocked_reason' => $this->input->post('blocked_reason'),
                'blocked_reason_details' => $this->input->post('blocked_reason_details'),
                'blocked_date' => $this->input->post('blocked_date'),
                'blocked_enddate' => $this->input->post('blocked_enddate'),
                'blocked_type' => $this->input->post('blocked_type'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Error</strong> Fill the form completely.
                            </div> ');
        }
        if ($id == 0) {
            if ($this->form_validation->run() == true && $this->administrator_model->blocked_date_insert($data)) {
                $log_action = 'Blocked Dates';
                $log_info = 'Added  ' . $this->input->post('blocked_date') . ' to Blocked Dates on ' . date('Y-m-d H:i:s', strtotime('now'));
                $this->writelog->writelog($this->auth_user_id, $log_action, $log_info);

                $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully added ' . $this->input->post('blocked_date') . ' to Blocked Dates.
                            </div> ');
                redirect('administrator/calendar_management');
            }
        } else {
            if ($this->form_validation->run() == true && $this->administrator_model->blocked_date_update($data, $id)) {
                $log_action = 'Blocked Dates';
                $log_info = 'Editted to Blocked Dates on ' . date('Y-m-d H:i:s', strtotime('now'));
                $this->writelog->writelog($this->auth_user_id, $log_action, $log_info);
                $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully Updated ' . $this->input->post('blocked_date') . ' on Blocked Dates 
                            </div> ');
            }
            redirect('administrator/calendar_management');
        }
        redirect('administrator/calendar_management');
    }

}
