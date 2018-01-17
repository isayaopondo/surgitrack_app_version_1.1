<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends MY_Controller
{

    private $pagescripts = '';
    private $case_list = '';
    private $table_tools = ' ';
    private $general_tools = '';
    private $usergroup = '';
    private $user_id = '';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('form_validation', 'writelog', 'BulkSMS'));
        $this->load->helper(array('url', 'language', 'form'));
        //$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        //$this->lang->load('auth');
        $this->load->model(array('settings_model', 'booking_model', 'patients_model', 'user_model', 'setup_model'));

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
                    <script src=\"" . base_url() . "assets/js/plugin/datatables/dataTables.buttons.min.js\"></script>
                    
		<script src=\"" . base_url() . "assets/js/plugin/datatable-responsive/datatables.responsive.min.js\"></script> 
                 <script src=\"" . base_url() . "assets/js/bootstrap/bootstrap-colorpicker.js\"></script>";
        $this->pagescripts .= "<!--AUTOCOMPLETE -->
                <script src=\"" . base_url() . "assets/js/autocomplete/jquery.easy-autocomplete.min.js\"></script>
               ";
        $this->table_tools = '
                 <script src="' . base_url() . 'assets/js/pages/booking_data.js"></script>
                <script src="' . base_url() . 'assets/js/pages/filters.js"></script> ';
        $this->general_tools = '<!-- JQUERY SELECT2 INPUT -->
                    <script src="' . base_url() . 'assets/js/plugin/select2/js/select2.js"></script>'
            .'<script src="' . base_url() . 'assets/js/pages/general_tools.js"></script>'
            . '<script src="' . base_url() . 'assets/js/pages/booking_tools.js"></script> ';


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
    /*public function create_ticket(){
        $this->freshdesk->create_ticket();
    }

    public function get_tickets(){
        $this->freshdesk->get_tickets();
    }*/

    public function index()
    {

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_render_page('support/index', $this->data, true);

    }

    public function back_to_waiting()
    {
        $booking_id = $this->input->post('booking_id');
        if ($this->booking_model->return_to_waiting($booking_id)) {
            $patient_id = $this->booking_model->get_patient_id_by($booking_id)->patient_id;
            $log_action = 'Patient Moved back to Waiting List';
            $log_info = 'Patient Moved back to waiting list on ' . date('Y-m-d H:i:s', strtotime('now'));
            $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
            $this->writelog->writelog($this->auth_user_id, 'Moved Patient\'s bookingID:' . $booking_id. ' back to Waiting list');

            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                                            <button class="close" data-dismiss="alert">
                                                                    ×
                                                            </button>
                                                            <i class="fa-fw fa fa-check"></i>
                                                            <strong>Success</strong> You have succesfully moved patient back to waiting list
                                                    </div>');

        }
    }

    public function back_to_admission()
    {
        $booking_id = $this->input->post('booking_id');
        if ($this->booking_model->back_to_admission($booking_id)) {
            $patient_id = $this->booking_model->get_patient_id_by($booking_id)->patient_id;
            $log_action = 'Patient Moved back to Admission List';
            $log_info = 'Patient Moved back to Admission list on ' . date('Y-m-d H:i:s', strtotime('now'));
            $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
            $this->writelog->writelog($this->auth_user_id, 'Moved Patient\'s booking:' . $booking_id. ' back to admission list');

            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                                                <button class="close" data-dismiss="alert">
                                                                        ×
                                                                </button>
                                                                <i class="fa-fw fa fa-check"></i>
                                                                <strong>Success</strong> You have succesfully moved patient back to Admission list
                                                        </div> ');
        }
    }

    public function remove_booking()
    {
        $booking_id = $this->input->post('booking_id');
        if ($this->booking_model->remove_booking($booking_id)) {
            $patient_id = $this->booking_model->get_patient_id_by($booking_id)->patient_id;
            $log_action = 'Patient\'s booking removed';
            $log_info = 'Patient\'s booking removed from lists on ' . date('Y-m-d H:i:s', strtotime('now'));
            $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
            $this->writelog->writelog($this->auth_user_id, 'Removed Patient\'s booking:' . $booking_id);

            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                                            <button class="close" data-dismiss="alert">
                                                                    ×
                                                            </button>
                                                            <i class="fa-fw fa fa-check"></i>
                                                            <strong>Success</strong> You have succesfully removed the patient
                                                    </div> ');

        }
    }

    public function lists()
    {

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['pagescripts'] = $this->pagescripts . $this->case_list . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/index', $this->data, true);

    }

    public function waiting_list()
    {

        $department = $this->settings_model->get_mydepartment($this->auth_user_id);
        if (!empty($department)) {

            $this->data['department_firms'] = $this->settings_model->get_all_firms_by_department($department->department_id);
        } else {
            $this->data['department_firms'] = '';
        }

        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['category'] = $this->settings_model->get_category();
        $this->data['theatre'] = $this->settings_model->get_theatres();
        $this->data['insuranceco'] = $this->settings_model->get_insurance_companies();
        $this->data['priorities'] = $this->settings_model->get_priorities();

        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['wards'] = $this->settings_model->get_wards_list();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/waiting_list', $this->data, true, true);

    }

    public function admission_list()
    {

        $department = $this->settings_model->get_mydepartment($this->auth_user_id);
        if (!empty($department)) {
            $this->data['my_departmentalfirms'] = $this->settings_model->get_mydefault_firms($this->auth_user_id, $department->department_id);
            $this->data['department_firms'] = $this->settings_model->get_all_firms_by_department($department->department_id);
        } else {
            $this->data['my_departmentalfirms'] = '';
        }


        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['theatre'] = $this->settings_model->get_theatres();
        $this->data['insuranceco'] = $this->settings_model->get_insurance_companies();
        $this->data['priorities'] = $this->settings_model->get_priorities();
        $this->data['category'] = $this->settings_model->get_category();
        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['wards'] = $this->settings_model->get_wards_list();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/admission_list', $this->data, true, true);

    }

    //Add_edit Christian Union
    public function create_booking()
    {
        $this->data['title'] = "Create Booking";
        $patient_id = $this->input->post('patient_id');
        $id = $this->input->post('booking_id');
        // validate form input
        $data2 = array();
        $data = array();

        $this->form_validation->set_rules('procedure', 'procedure', 'required', 'trim');
        $this->form_validation->set_rules('theatre', 'theatre', 'required');
        $this->form_validation->set_rules('booking_date', 'Booking Date', 'required');
        $this->form_validation->set_rules('surgery_indication', 'Surgery Indication', 'required');
        $this->form_validation->set_rules('duration', 'Estimated Duration of Surgery', 'required');


        if ($this->form_validation->run() == true) {
            $bookingstatus = $this->input->post('booking_status');
            $data1 = array(
                'patient_id' => $patient_id,
                'procedure_id' => $this->input->post('procedure'),
                'laterality' => $this->input->post('laterality'),
                'category_id' => $this->input->post('category'),
                'booking_date' => $this->input->post('booking_date'),
                'theatre_id' => $this->input->post('theatre'),

                'slot_id' => $this->input->post('duration'),
                'firm_id' => $this->input->post('firm'),
                'anesthesia' => $this->input->post('anesthesia'),

                'postopbed' => $this->input->post('postopbed'),
                'booked_by' => $this->auth_user_id,
                'surgery_indication' => $this->input->post('surgery_indication'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );

            if (isset($bookingstatus) && $bookingstatus != '0') {
                if ($bookingstatus == '1') {
                    $data2 = array(
                        'ward_id' => $this->input->post('ward'),
                        'admission_date' => $this->input->post('admission_date'),
                        'booking_status' => $this->input->post('booking_status'),
                        'admitted_by' => $this->auth_user_id,
                    );
                } else {
                    $data2 = array(
                        'ward_id' => $this->input->post('ward'),
                        'admission_date' => $this->input->post('admission_date'),
                        'surgerydate' => $this->input->post('surgery_date'),
                        'booking_status' => $this->input->post('booking_status'),
                    );
                }
            } else {
                $data2 = array(
                    'booking_status' => '0',
                );
            }
            $data = array_merge($data1, $data2);
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
            if ($this->form_validation->run() == true) {
                $procedure = $this->input->post('procedure');
                $booking_id = $this->booking_model->booking_insert($data);
                if (is_numeric($booking_id)) {
                    $log_action = 'Waiting List';
                    $log_info = 'Added to waiting list on ' . date('Y-m-d H:i:s', strtotime('now') . ' BOOKINGID:' . $booking_id);
                    $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
                    $this->writelog->writelog($this->auth_user_id, 'Added Patient\'s booking:' . $booking_id.' to waiting  list');

                    $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully Added booking details
                            </div> ');
                } else {
                    $this->writelog->writelog($this->auth_user_id, 'Failed to add Patient\'s booking to waiting  list');

                    $this->session->set_flashdata('message', '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Error</strong> Adding booking details has failed.
                            </div> ');
                }

                redirect('patients/patient_page/' . $patient_id . "/" . $booking_id);
            }
        } else {
            if ($this->form_validation->run() == true && $this->booking_model->booking_update($data, $id)) {
                $log_action = 'Waiting List';
                $log_info = 'Editted to waiting list on ' . date('Y-m-d H:i:s', strtotime('now'));
                $this->writelog->patientlog($this->auth_user_id, $id, $log_action, $log_info);
                $this->writelog->writelog($this->auth_user_id, 'Updated Patient\'s booking details bookingID:' . $booking_id.' on waiting  list');

                $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully Updated booking details
                            </div> ');
            }
            redirect('patients/patient_page/' . $patient_id);
        }
        redirect('patients/add_patient/' . $patient_id);
    }

    public function check_if_patient_has_open_booking()
    {
        $procedure_id = $this->input->post('procedure_id');
        $patient_id = $this->input->post('patient_id');
        $procedeure = $this->settings_model->get_procedure_by_id($procedure_id);
        if ($this->booking_model->check_if_patient_has_open_booking($procedure_id, $patient_id)) {
            $return = array('procedure_id' => $procedure_id,
                'message' => 'This patient has an existing booking for <b> ' . $procedeure->procedure_name . '</b><br>
                                        Please go to the patient\'s page to view or edit existing booking.',
                'success' => '0');
            echo json_encode($return);
        } else {
            $return = array('procedure_id' => $procedure_id,
                'message' => 'No booking found for this patient with the same procedure!',
                'success' => '1');
            echo json_encode($return);
        }
    }

    public function delete_booking($patient_id, $booking_id)
    {
        $this->booking_model->delete_booking($booking_id);
        $this->writelog->writelog($this->auth_user_id, 'Deleted patient\'s booking, bookingID:' . $booking_id.' ');

        redirect('patients/patient_page/' . $patient_id);
    }

    public function add_surgeon_assistants()
    {
        $data = $this->input->post();

        if ($data['booking_id'] !== 0 || !is_null($data['booking_id'])) {
            if (!empty($data)) {
                $booking_id = $data['booking_id'];
                unset($data['booking_id']);
                $patient_id = $this->booking_model->get_patient_id_by($booking_id)->patient_id;

                if ($this->booking_model->booking_update($data, $booking_id)) {
                    $log_action = 'Added Surgeon Assistants';
                    $log_info = 'Added Surgeon Assistants ' . date('Y-m-d H:i:s', strtotime('now'));
                    $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
                    $this->writelog->writelog($this->auth_user_id, 'Added surgeon assistants:' . $booking_id.' ');

                    $this->session->set_flashdata('message', "You have succesfully Added Surgeon Assistants '" . serialize($data) . "' details");
                    $return = array('booking_id' => $booking_id,
                        'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully Added Surgeon Assistants
                            </div> ',
                        'success' => 1);
                    echo json_encode($return);
                } else {
                    $this->writelog->writelog($this->auth_user_id, 'Failed to add surgeon assistants: BookingID:' . $booking_id.' ');
                    $return = array('booking_id' => $booking_id,
                        'message' => '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Error!</strong> Adding Surgeon Assistants Failed
                            </div',
                        'success' => 0);
                    echo json_encode($return);
                }
            }
        }
    }

    public function mybooking_data()
    {

        if (!$this->verify_role('admin')) {

            $department = $this->settings_model->get_mydepartment($this->auth_user_id);

            if (!empty($department)) {
                $json = $this->booking_model->get_mybooking_data($department->department_id);
            } else {
                $json = '';
            }

        } else {
            $json = $this->booking_model->get_mybooking_data();
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function mypatients_booking_list_data($patient_id = '')
    {
        //$this->output->enable_profiler(TRUE);
        //Waiting=0
        if (in_array($this->auth_role, ['doctor', 'nurse'])) {
            $json = $this->booking_model->get_booking_list_data('', $patient_id);

        } else {
            $json = $this->booking_model->get_booking_list_data('', $patient_id);
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function mywaiting_list_data($patient_id = '')
    {
        //Waiting=0
        $firm = $this->input->post('firm_id');
        $firm_id = isset($firm) && $firm !== '' ? $firm : '';
        $patient_id = $this->input->post('patient_id');

        if ($this->is_role('doctor') || $this->is_role('nurse')) {
            $user_id = $this->auth_user_id;
            $department = $this->user_model->get_users_department($user_id);
            $firm = $this->settings_model->get_myfirm($user_id);
            $department_id = $department ? $department->department_id : '';
            $firm_id = $firm ? $firm->firm_id : '';
            $json = $this->booking_model->get_booking_list_data($department_id, $patient_id, '0', $firm_id);
        } else {
            $json = $this->booking_model->get_booking_list_data('', $patient_id, '0', $firm_id);
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function myadmission_list_data($patient_id = '')
    {
        //Admission=1
        $firm = $this->input->post('firm_id');
        $patient_id = $this->input->post('patient_id');
        $firm_id = isset($firm) && $firm !== '' ? $firm : '';
        if ($this->is_role('doctor') || $this->is_role('nurse')) {
            $user_id = $this->auth_user_id;
            $department = $this->user_model->get_users_department($user_id);
            $firm = $this->settings_model->get_myfirm($user_id);
            $department_id = $department ? $department->department_id : '';
            $firm_id = $firm ? $firm->firm_id : '';
            $json = $this->booking_model->get_booking_list_data($department_id, $patient_id, '1', $firm_id);
        } else {
            $json = $this->booking_model->get_booking_list_data('', $patient_id, '1');
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function mytheatre_list_data($patient_id = '')
    {
        $firm = $this->input->post('firm_id');
        $firm_id = isset($firm) && $firm !== '' ? $firm : '';
        //Admission=1
        $patient_id = $this->input->post('patient_id');

        if ($this->is_role('doctor') || $this->is_role('nurse')) {
            $user_id = $this->auth_user_id;
            $department = $this->user_model->get_users_department($user_id);
            $firm = $this->settings_model->get_myfirm($user_id);
            $department_id = $department ? $department->department_id : '';
            $firm_id = $firm ? $firm->firm_id : '';
            $json = $this->booking_model->get_booking_list_data($department_id, $patient_id, '2', $firm_id);
        } else {
            $json = $this->booking_model->get_booking_list_data('', $patient_id, '2');
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function mycaselog_list_data($patient_id = '')
    {
        $firm = $this->input->post('firm_id');
        $firm_id = isset($firm) && $firm !== '' ? $firm : '';

        $patient_id = $this->input->post('patient_id');

        if (!$this->verify_role('doctor,nurse')) {
            $user_id = $this->auth_user_id;
            $department = $this->user_model->get_users_department($user_id);
            $firm = $this->settings_model->get_myfirm($user_id);
            $department_id = $department ? $department->department_id : '';
            $firm_id = $firm ? $firm->firm_id : '';
            $json = $this->booking_model->get_caselog_list_data($department_id, $patient_id, '3', $firm_id);
        } else {
            $json = $this->booking_model->get_caselog_list_data('', $patient_id, '3');
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function mylogbook_data()
    {

        $user_id = $this->auth_user_id;
        $json = $this->booking_model->get_log_book_data($user_id);


        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function add_post_op()
    {
        $this->data['title'] = "Create Admission";
        $id = $this->input->post('booking_id');
        // validate form input

        $patient_id = $this->booking_model->get_patient_id_by($id)->patient_id;

        $this->form_validation->set_rules('op_date_start', 'Operation Date', 'required');
        $this->form_validation->set_rules('operation_done', 'Operation Done', 'required');
        if ($this->form_validation->run() == true) {
//'op_procedure' => $this->input->post('procedure'),
            $data = array(
                'op_date_start' => $this->input->post('op_date_start'),
                'booking_status' => '3',
                'op_date_end' => $this->input->post('op_date_end'),
                'operation_done' => $this->input->post('operation_done'),
                'anethesia_start' => $this->input->post('anethesia_start'),
                'anethesia_end' => $this->input->post('anethesia_end'),
                'op_notes' => $this->input->post('op_notes'),
                'op_recorded_on' => date('Y-m-d H:i:s', strtotime('now')),
                'op_recorded_by' => $this->auth_user_id
            );

            $data_surgeons = array(
                'op_role' => 'primary',
                'op_user_id' => $this->input->post('surgeon_uid'),
                'booking_id' => $id,
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );
            $this->booking_model->surgeon_insert($data_surgeons);
            $data_surgeonssupervisor = array(
                'op_role' => 'supervisor',
                'op_user_id' => $this->input->post('surgeon_supervisor'),
                'booking_id' => $id,
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );
            $this->booking_model->surgeon_insert($data_surgeonssupervisor);

            $assistants = $this->input->post('surgeon_assistant');
            if (is_array($assistants)) {
                foreach ($assistants as $assistant) {
                    $data_assistant = array(
                        'op_role' => 'assistant',
                        'op_user_id' => $assistant,
                        'booking_id' => $id,
                        'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_by' => $this->auth_user_id
                    );
                    $this->booking_model->surgeon_insert($data_assistant);
                }
            }

            if ($this->booking_model->booking_update($data, $id)) {
                $log_action = 'PostOP';
                $log_info = 'Added PostOP details on ' . date('Y-m-d H:i:s', strtotime('now'));
                $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
                $this->writelog->writelog($this->auth_user_id, 'Added PostOP details on for BookingID:' . $id.' ');
                $this->session->set_flashdata('message', "you have succesifully Updated '" . $this->input->post('procedure_name') . "' details");
                redirect('patients/patient_page/' . $patient_id);
            }
        }
    }

    public function edit_post_op()
    {
        $this->data['title'] = "Edit Post Ops";
        $id = $this->input->post('booking_id');
        // validate form input

        $patient_id = $this->booking_model->get_patient_id_by($id)->patient_id;

        $this->form_validation->set_rules('op_date_start', 'Operation Date', 'required');
        $this->form_validation->set_rules('operation_done', 'Operation Done', 'required');
        if ($this->form_validation->run() == true) {

            $data = array(
                'op_date_start' => $this->input->post('op_date_start'),
                'booking_status' => '3',
                'op_date_end' => $this->input->post('op_date_end'),
                'operation_done' => $this->input->post('operation_done'),
                'anethesia_start' => $this->input->post('anethesia_start'),
                'anethesia_end' => $this->input->post('anethesia_end'),
                'surgeon_uid' => $this->input->post('surgeon_uid'),
                'op_notes' => $this->input->post('op_notes'),
                'op_recorded_on' => date('Y-m-d H:i:s', strtotime('now')),
                'op_recorded_by' => $this->auth_user_id
            );
            //Clear all existing Surgeons
            $this->booking_model->delete_existing_booking_surgeon($id);

            $data_surgeons = array(
                'op_role' => 'primary',
                'op_user_id' => $this->input->post('surgeon_uid'),
                'booking_id' => $id,
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );
            if (!$this->booking_model->check_ifsurgeon_booking_exist($id, $this->input->post('surgeon_uid'))) {
                $this->booking_model->surgeon_insert($data_surgeons);
            }
            $data_surgeonssupervisor = array(
                'op_role' => 'supervisor',
                'op_user_id' => $this->input->post('surgeon_supervisor'),
                'booking_id' => $id,
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );
            if (!$this->booking_model->check_ifsurgeon_booking_exist($id, $this->input->post('surgeon_supervisor'))) {
                $this->booking_model->surgeon_insert($data_surgeonssupervisor);
            }

            $assistants = $this->input->post('surgeon_assistant');
            if (is_array($assistants)) {
                foreach ($assistants as $assistant) {
                    $data_assistant = array(
                        'op_role' => 'assistant',
                        'op_user_id' => $assistant,
                        'booking_id' => $id,
                        'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_by' => $this->auth_user_id
                    );
                    if (!$this->booking_model->check_ifsurgeon_booking_exist($id, $assistant)) {
                        $this->booking_model->surgeon_insert($data_assistant);
                    }
                }
            }


            if ($this->booking_model->booking_update($data, $id)) {
                $log_action = 'PostOP';
                $log_info = 'Editted Op Notes on ' . date('Y-m-d H:i:s', strtotime('now'));
                $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
                $this->writelog->writelog($this->auth_user_id, 'Editted PostOP notes for BookingID:' . $id.' ');
                $this->session->set_flashdata('message', "you have successfully Eddited Op Notes '" . $this->input->post('procedure_name') . "' details");
                redirect('patients/patient_page/' . $patient_id);
            }
        }
    }

    public function add_admission()
    {
        $this->data['title'] = "Create Admission";
        $id = $this->input->post('booking_id');
        // validate form input

        $patient_id = $this->booking_model->get_patient_id_by($id)->patient_id;

        $this->form_validation->set_rules('admission_date', 'Admision Date', 'required');
        $this->form_validation->set_rules('ward', 'Ward/Location', 'required');
        if ($this->form_validation->run() == true) {

            $data = array(
                'admission_date' => $this->input->post('admission_date'),
                'booking_status' => '1',
                'ward_id' => $this->input->post('ward'),
                'admission_notes' => $this->input->post('admission_notes'),
                'admitted_by' => $this->auth_user_id,
                'last_modified_on' => date('Y-m-d H:i:s', strtotime('now')),
                'last_modified_by' => $this->auth_user_id
            );
        }


        if ($this->form_validation->run() == true && $this->booking_model->booking_update($data, $id)) {


            $log_action = 'Admission';
            $log_info = 'Added Patient Admission details on ' . date('Y-m-d H:i:s', strtotime('now'));
            $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
            $this->writelog->writelog($this->auth_user_id, $log_info);
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully added patent to Admission List.
                            </div> ');

            $return = array('message' => 'You have succesfully added a comment',
                'bookingID' => $id,
                'success' => 1);

            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully added a comment.
                            </div> ');
            $this->writelog->writelog($this->auth_user_id, 'Added a comment for bookingID:' . $id, "#" . serialize($return));

            $log_action = 'Comments';
            $log_info = '<b>COMMENT:</b> ' . $this->input->post('admission_notes') . ' <b>TIME</b>: ' . date('Y-m-d H:i:s', strtotime('now')) . ' BookingID: ' . $id;
            $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info, 'user_comment');

        }
        redirect('patients/patient_page/' . $patient_id);
    }

    public function add_theatre_list()
    {
        $this->data['title'] = "Create Theatre List";
        $id = $this->input->post('booking_id');
        // validate form input

        $patient_id = $this->booking_model->get_patient_id_by($id)->patient_id;

        $this->form_validation->set_rules('surgery_date', 'Surgery Date', 'required');
        if ($this->form_validation->run() == true) {

            $data = array(
                'surgerydate' => $this->input->post('surgery_date'),
                'booking_status' => '2',
                'surgery_notes' => $this->input->post('sugery_notes'),
                'last_modified_on' => date('Y-m-d H:i:s', strtotime('now')),
                'last_modified_by' => $this->auth_user_id
            );
        }


        if ($this->form_validation->run() == true && $this->booking_model->booking_update($data, $id)) {
            $log_action = 'Moved to Theatre List';
            $log_info = 'Added Patient on Theatre List  on ' . date('Y-m-d H:i:s', strtotime('now'));
            $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
            $this->writelog->writelog($this->auth_user_id, $log_info);

            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully moved the patient to theatre list
                            </div> ');
        }
        redirect('patients/patient_page/' . $patient_id);
    }

    public function add_edit()
    {

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/add_edit_theatre', $this->data, true);

    }

    public function theatrelists()
    {

        $department = $this->settings_model->get_mydepartment($this->auth_user_id);
        if (!empty($department)) {
            $this->data['department_firms'] = $this->settings_model->get_all_firms_by_department($department->department_id);
            $this->data['leadsurgeon'] = $this->settings_model->get_department_users($department->department_id);
        } else {
            $this->data['department_firms'] = '';
        }
        $this->data['myuserid'] = $this->auth_user_id;
        $this->data['theatre'] = $this->settings_model->get_theatres();
        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/theatre_list', $this->data, true, true);

    }

    public function patient_log($patient_id)
    {

        $this->data['logs'] = $this->booking_model->get_patient_log($patient_id);
        $this->data['patient_details'] = $this->patients_model->get_patient_details($patient_id);
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/patient_log', $this->data, true);

    }

    public function procedure_summary_data()
    {
        $json = '';
        if ($this->verify_role('doctor,nurse')) {
            $default_firm = $this->settings_model->get_myfirm($this->auth_user_id);

            $myfirm_id = $default_firm ? $default_firm->firm_id : '';
            $frm = $this->input->post('firm_id');
            // $getfirm_id = $this->user_model->get_users_firm($user_id)->firm_id;

            $firm_id = isset($frm) && $frm !== '' ? $frm : $myfirm_id;
            $json = $this->booking_model->get_procedure_summaries($firm_id);
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }


    public function facility_procedure_summary_data()
    {
        $json = $this->booking_model->get_facility_procedures_summaries();
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }


    public function save_booking_mapt()
    {
        $id = $this->input->post('booking_id');
        $data = $this->input->post();

        if ($data['booking_id'] !== 0 || !is_null($data['booking_id'])) {
            if (!empty($data)) {

                $options = $data['optmapt'];
                unset($data['optmapt']);
                $remaining_options = $data;
                $data2 = array(
                    'scoredate' => date('Y-m-d H:i:s', strtotime('now')),
                    'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                    'created_by' => $this->auth_user_id
                );
                $arr = $remaining_options + $data2;
                $patient_id =$this->booking_model->get_patient_id_by($this->input->post('booking_id'))->patient_id;

                $return = array('scoredate_id' => $this->booking_model->mapt_formfill_insert($arr),
                    'message' => 'You have succesifully created a new criteria',
                    'bookingID' => $this->input->post('booking_id'),
                    'patient_id' => $patient_id,
                    'success' => 1);
                $qid = $return['scoredate_id'];
                $this->booking_model->mapt_formfill_scores_insert($options, $qid);
                echo json_encode($return);
                $this->session->set_flashdata('message', "You have succesfully Score this patient");
                $log_action = 'MAPT Score added';
                $log_info = 'Created MAPT Criteria score  for bookingID:' . $this->input->post('booking_id').' on ' . date('Y-m-d H:i:s', strtotime('now')) ;
                $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
                $this->writelog->writelog($this->auth_user_id, 'Created MAPT Criteria score  for bookingID:' . $this->input->post('booking_id'), "#" . serialize($return));
            }
        }
    }

    public function delete_mapt()
    {
        $mapt_id = $this->input->post('mapt_id');
        if ($this->booking_model->delete_mapt($mapt_id)) {
            $return = array('mapt_id' => $mapt_id,
                'message' => 'You have succesifully deleted a  MAPT',
                'success' => 1);
            echo json_encode($return);
        } else {
            $return = array('mapt_id' => $mapt_id,
                'message' => 'MAPT delete failed',
                'success' => 0);
            echo json_encode($return);
        }
    }

    public function opt_notes_templates()
    {

        // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/opt_notes_templates', $this->data, true);

    }

    public function case_logs()
    {
        $department = $this->settings_model->get_mydepartment($this->auth_user_id);
        if (!empty($department)) {
            $this->data['leadsurgeon'] = $this->settings_model->get_department_users($department->department_id);
        } else {
            $this->data['leadsurgeon'] = '';
        }
        $this->data['myuserid'] = $this->auth_user_id;


        $this->data['theatre'] = $this->settings_model->get_theatres();
        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/case_logs', $this->data, true, true);

    }

    public function my_logbook()
    {

        $department = $this->settings_model->get_mydepartment($this->auth_user_id);
        if (!empty($department)) {
            $this->data['leadsurgeon'] = $this->settings_model->get_department_users($department->department_id);
        } else {
            $this->data['leadsurgeon'] = '';
        }
        $this->data['myuserid'] = $this->auth_user_id;
        $this->data['theatre'] = $this->settings_model->get_theatres();
        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/my_logbook', $this->data, true, true);

    }

    public function print_theatre_list($opt, $opt_val, $surgdate)
    {
        $this->load->helper('pdf_helper');
        $this->data['theatrelist'] = $this->booking_model->get_theatre_list($opt, $opt_val, $surgdate);
        $this->load->view('booking/print_theatre_list', $this->data);
    }

    public function print_full_theatre_list()
    {
        $this->load->helper('pdf_helper');
        $this->data['theatrelist'] = $this->booking_model->get_full_theatre_list();
        $this->load->view('booking/print_theatre_list', $this->data);
    }

    function pdf()
    {
        $this->load->helper('pdf_helper');
        /*
          ---- ---- ---- ----
          your code here
          ---- ---- ---- ----
         */
        $this->data['theatrelist'] = $this->booking_model->get_theatre_list();
        $this->load->view('booking/print_theatre_list', $this->data);
    }

    public function print_waiting_list($opt = '', $opt_val = '')
    {
        $this->load->helper('pdf_helper');
        $this->data['theatrelist'] = $this->booking_model->get_waiting_list($opt, $opt_val);
        $this->load->view('booking/print_waiting_list', $this->data);
    }

    public function print_admission_list($opt = '', $opt_val = '', $opt_val2 = '', $opt_val3 = '')
    {
        $this->load->helper('pdf_helper');
        $this->data['theatrelist'] = $this->booking_model->get_admission_list($opt, $opt_val, $opt_val3, $opt_val2);
        $this->load->view('booking/print_admission_list', $this->data);
    }

    public function print_caselog_list($opt, $opt_val)
    {
        $this->load->helper('pdf_helper');
        $this->data['theatrelist'] = $this->booking_model->get_case_log_list($opt, $opt_val);
        $this->load->view('booking/print_caselog_list', $this->data);
    }

    public function send_admission_sms()
    {
        $data = $this->input->post();

        $patient_id = $data['patient_id'];
        $message = $data['message'];
        $phone = $data['phone'];
        $folder_number = $data['folder_number'];

        $smsout = $this->send_sms(strip_tags($message), $phone);
        $return = array('Phone' => $phone,
            'message' => 'Your SMS has successfully been sent, thank you.',
            'success' => 1);
        $this->session->set_flashdata('message', "You have succesfully Sent Admission SMS notification");
        $log_action = 'Admission Notification SMS';
        $log_info = 'Sent Admission Notification SMS [' . $message . '] on ' . date('Y-m-d H:i:s', strtotime('now')) . '  #' . serialize($return);
        $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
        $this->writelog->writelog($this->auth_user_id, 'Sent Admission Notification SMS to :' . $patient_id . '(' . $folder_number . ')', "#" . serialize($return));

        echo json_encode($return);
    }

    public function send_general_sms()
    {
        $data = $this->input->post();

        $patient_id = $data['sms_patient_id'];
        $message = $data['sms_message'];
        $phone = $data['sms_phone'];
        $folder_number = $data['sms_folder_number'];

        $smsout = $this->send_sms(strip_tags($message), $phone);
        $return = array('Phone' => $phone,
            'message' => 'Your SMS has successfully been sent, thank you.',
            'success' => 1);
        $this->session->set_flashdata('message', "You have succesfully Sent SMS ");
        $log_action = 'Sent SMS SMS';
        $log_info = 'Sent general message(SMS)[' . $message . '] on ' . date('Y-m-d H:i:s', strtotime('now')) . '  #' . serialize($return);
        $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
        $this->writelog->writelog($this->auth_user_id, 'Sent message to :' . $patient_id . '(' . $folder_number . ')', "#" . serialize($return));

        echo json_encode($return);
    }

    // Define function to test
    function curl_installed()
    {
        //$smsout = $this->bulksms->testCurl();
        $host = 'sun.ac.za';
        $ports = array(21, 25, 80, 81, 110, 443, 3306);

        foreach ($ports as $port) {
            $connection = @fsockopen($host, $port);

            if (is_resource($connection)) {
                echo '<h2>' . $host . ':' . $port . ' ' . '(' . getservbyport($port, 'tcp') . ') is open.</h2>' . "\n";

                fclose($connection);
            } else {
                echo '<h2>' . $host . ':' . $port . ' is not responding.</h2>' . "\n";
            }
        }
    }

    public function send_sms($message, $phone)
    {
        require(APPPATH . 'libraries/Requests.php');
        $smsout = $this->bulksms->seven_bit_sms(BULK_SMS_USER, BULK_SMS_PASS, $message, $phone);

        Requests::register_autoloader();
        $response = Requests::get(EAPI_URL . '?' . $smsout);
        return $response;
    }

    public function send_opnotes_dropbox()
    {
        $booking_id = $this->input->post('booking_id');

        $filename = $this->booking_model->get_opnotesfile_name($booking_id);
        $this->load->library('dropbox');
        $this->dropbox->upload_file_dropbox($filename->opnotes_dropbox_folder, $filename->opnotes_file_name);
    }

    public function save_comments()
    {
        $id = $this->input->post('booking_id');
        $data = $this->input->post();
        $patient_id = $this->booking_model->get_patient_id_by($id)->patient_id;
        if ($data['booking_id'] !== 0 || !is_null($data['booking_id'])) {
            if (!empty($data)) {

                $comment = $data['comment'];
                $booking_id = $data['booking_id'];


                $return = array('message' => 'You have succesfully added a comment',
                    'bookingID' => $booking_id,
                    'success' => 1);

                $this->session->set_flashdata('message', "You have succesfully added a comment");
                $this->writelog->writelog($this->auth_user_id, 'Added a comment for bookingID:' . $booking_id, "#" . serialize($return));

                $log_action = 'Comments';
                $log_info = '<b>COMMENT:</b> ' . $comment . ' <b>TIME</b>: ' . date('Y-m-d H:i:s', strtotime('now')) . ' BookingID: ' . $booking_id;
                $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info, 'user_comment');
                echo json_encode($return);
            }
        }
    }

    public function utilizations()
    {
        redirect('/', 'refresh');

    }

    public function op_coding()
    {

        $department = $this->settings_model->get_mydepartment($this->auth_user_id);
        if (!empty($department)) {
            $this->data['leadsurgeon'] = $this->settings_model->get_department_users($department->department_id);
        } else {
            $this->data['leadsurgeon'] = '';
        }
        $this->data['myuserid'] = $this->auth_user_id;
        $this->data['theatre'] = $this->settings_model->get_theatres();
        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/op_coding', $this->data, true, true);

    }

    public function patient_coding($booking_id = '')
    {

        if (isset($booking_id) && $booking_id != '') {
            $patient_details = $this->patients_model->get_patient_details_by_booking($booking_id);
            $this->data['patient_details'] = $patient_details;
            $this->data['patient_booking_details'] = $this->booking_model->patients_opnotes_summary($booking_id);
            $this->data['procedure_consumable_form'] = $this->booking_model->get_rpl_procedure_consumable($booking_id);
            $this->data['consumables'] = $this->settings_model->get_nappi_consumables();
            $this->data['booking_id'] = $booking_id;
        }

        $department = $this->settings_model->get_mydepartment($this->auth_user_id);
        if (!empty($department)) {
            $this->data['leadsurgeon'] = $this->settings_model->get_department_users($department->department_id);
        } else {
            $this->data['leadsurgeon'] = '';
        }
        $this->data['myuserid'] = $this->auth_user_id;
        $this->data['theatre'] = $this->settings_model->get_theatres();
        $this->data['firms'] = $this->settings_model->get_firms_list();
        $this->data['procedures'] = $this->settings_model->get_procedure();
        $this->data['rplprocedures'] = $this->settings_model->get_rplprocedures();

        $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('booking/patient_coding', $this->data, true, true);

    }

    public function coding_booking_procedure()
    {
        $data = $this->input->post();

        if ($data['booking_id'] !== 0 || !is_null($data['booking_id'])) {
            if (!empty($data)) {

                $procedures = $data['procedures'];
                $booking_id = $data['booking_id'];

                foreach ($procedures as $procedure) {
                    $data2 = array(
                        'booking_id' => $booking_id,
                        'procedure_id' => $procedure,
                        'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_by' => $this->auth_user_id
                    );
                    $this->booking_model->coding_booking_procedure_insert($data2);
                }
                $return = array('message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully added a Procedure
                            </div> ',
                    'bookingID' => $booking_id,
                    'procedure_id' => json_encode($procedures),
                    'success' => 1);
                $this->writelog->writelog($this->auth_user_id, 'Added a procedure for bookingID:' . $booking_id, "#" . serialize($return));
                echo json_encode($return);
            }
        }
    }

    public function booking_procedures_data()
    {
        $booking_id = $this->input->post('booking_id');

        $json = $this->settings_model->get_booking_rplprocedures($booking_id);

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function remove_booking_procedure()
    {
        $procedure_id = $this->input->post('procedure_id');
        $booking_id = $this->input->post('booking_id');

        if ($this->booking_model->delete_booking_procedure($procedure_id, $booking_id)) {
            $return = array('procedure_id' => $procedure_id,
                'booking_id' => $booking_id,
                'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully removed the Procedure
                            </div> ',
                'success' => 1);
            echo json_encode($return);
        } else {
            $return = array('procedure_id' => $procedure_id,
                'booking_id' => $booking_id,
                'message' => '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Error!</strong> Procedure removal failed
                            </div',
                'success' => 0);
            echo json_encode($return);
        }
    }

    public function add_procedure_consumables()
    {
        $procedure_id = $this->input->post('procedure_id');
        $booking_id = $this->input->post('booking_id');
        $consumables = $this->booking_model->get_procedure_consumables($procedure_id);
        $i = 0;
        $j = 0;
        foreach ($consumables as $consumable) {
            $data2 = array(
                'booking_id' => $booking_id,
                'consumable_id' => $consumable->consumable_id,
                'price' => $consumable->price,
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );
            if ($this->booking_model->checkif_booking_has_thisconsumables($booking_id, $consumable->consumable_id)) {
                $j++;
            } else {
                if ($this->booking_model->add_procedure_consumables($data2)) {
                    $i++;
                }
            }
        }
        $consumables = $this->booking_model->get_rpl_procedure_consumable($booking_id);
        $return = array('booking_id' => $booking_id,
            'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> ' . $i . ' Consumables has been successfully added
                            </div> ',
            'consumables' => $consumables,
            'success' => 0);
        echo json_encode($return);
    }

    public function add_other_consumables()
    {
        $data = $this->input->post();

        if ($data['booking_id'] !== 0 || !is_null($data['booking_id'])) {
            if (!empty($data)) {

                $consumables = $data['consumables'];
                $booking_id = $data['booking_id'];
                $i = 0;
                $j = 0;
                foreach ($consumables as $consumable) {
                    $consumable_details = $this->settings_model->get_consumables_details($consumable);
                    $data2 = array(
                        'booking_id' => $booking_id,
                        'consumable_id' => $consumable,
                        'price' => $consumable_details->price,
                        'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                        'created_by' => $this->auth_user_id
                    );
                    if ($this->booking_model->checkif_booking_has_thisconsumables($booking_id, $consumable)) {
                        $j++;
                    } else {
                        if ($this->booking_model->add_procedure_consumables($data2)) {
                            $i++;
                        }
                    }
                }
                $consumables = $this->booking_model->get_rpl_procedure_consumable($booking_id);
                $return = array('booking_id' => $booking_id,
                    'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> ' . $i . ' Consumables has been successfully added
                            </div> ',
                    'consumables' => $consumables,
                    'success' => 1);


                $return2 = array('message' => $i . ' Consumables has been successfully added',
                    'bookingID' => $booking_id,
                    'success' => 1);
                $this->writelog->writelog($this->auth_user_id, 'Added a consumable for bookingID:' . $booking_id, "#" . serialize($return2));
                echo json_encode($return);
            }
        }
    }

    public function remove_unused_consumable()
    {
        $booking_consumable_id = $this->input->post('booking_consumable_id');
        $booking_id = $this->input->post('booking_id');

        if ($this->booking_model->remove_unused_consumable($booking_consumable_id)) {
            $consumables = $this->booking_model->get_rpl_procedure_consumable($booking_id);
            $return = array('booking_consumable_id' => $booking_consumable_id,
                'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> You have succesfully removed the consumable.
                            </div> ',
                'consumables' => $consumables,
                'success' => 1);
            echo json_encode($return);
        } else {
            $consumables = $this->booking_model->get_rpl_procedure_consumable($booking_id);
            $return = array('booking_consumable_id' => $booking_consumable_id,
                'message' => '<div class="alert alert-danger fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-times"></i>
                                    <strong>Error!</strong> Removal failed
                            </div',
                'consumables' => $consumables,
                'success' => 0);
            echo json_encode($return);
        }
    }

    public function save_booking_consumables()
    {
        $data = $this->input->post();
        if ($data['booking_id'] !== 0 || !is_null($data['booking_id'])) {
            $booking_id = $data['booking_id'];
            if (!empty($data)) {

                $options = $data['options'];
                $j = 0;
                foreach ($options as $option) {
                    $data2 = array(
                        'price' => $option['price'],
                        'quantity' => $option['quantity'],
                        'modified_on' => date('Y-m-d H:i:s', strtotime('now')),
                        'modified_by' => $this->auth_user_id
                    );

                    if ($this->booking_model->update_booking_consumables($data2, $booking_id, $option['booking_consumable_id'])) {
                        $j++;
                    }
                }
                $return = array('booking_id' => $booking_id,
                    'message' => '<div class="alert alert-success fade in">
                                    <button class="close" data-dismiss="alert">
                                            ×
                                    </button>
                                    <i class="fa-fw fa fa-check"></i>
                                    <strong>Success</strong> ' . $j . ' Consumables has been successfully updated
                            </div> ',
                    'success' => 1);

                $return2 = array('message' => $j . ' Consumables has been successfully updated',
                    'bookingID' => $booking_id,
                    'success' => 1);
                $this->writelog->writelog($this->auth_user_id, 'Updated a consumable for bookingID:' . $booking_id, "#" . serialize($return2));
                echo json_encode($return);
            }
        }
    }

}
