<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 03/10/2017
 * Time: 20:15
 */

class Patients extends MY_Controller
{
    private $pagescripts = '';
    private $case_list = '';
    private $table_tools = ' ';
    private $general_tools = '';
    private $usergroup = '';
    private $google_maps = '';
    private $user_id = '';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('writelog'));

        $this->lang->load('auth');
        $this->load->model(array('settings_model', 'booking_model', 'patients_model', 'user_model','setup_model'));
        $this->load->helper(array('url', 'form', 'language'));

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
		<script src=\"" . base_url() . "assets/js/plugin/datatable-responsive/datatables.responsive.min.js\"></script> "
            . " <script src=\"" . base_url() . "assets/js/bootstrap/bootstrap-colorpicker.js\"></script>";
        $this->pagescripts .= '<!--AUTOCOMPLETE -->'
            . '<script src="' . base_url() . 'assets/js/autocomplete/jquery.easy-autocomplete.min.js"></script>';


        $this->table_tools = ''
            . ' <script src="' . base_url() . 'assets/js/pages/patients_module_data.js"></script> ';
        $this->general_tools = ''
            . ' <script src="' . base_url() . 'assets/js/plugin/select2/js/select2.js"></script>'
            . ' <script src="' . base_url() . 'assets/js/pages/booking_tools.js"></script> '
            . ' <script src="' . base_url() . 'assets/js/pages/patients_module_tools.js"></script> 
                <script src="' . base_url() . 'assets/js/pages/booking_tools.js"></script> ';
    }

    public function lists()
    {
        if( in_array( $this->auth_role, ['admin','doctor','nurse'] ) ) {
            $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->case_list . $this->general_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('patients/lists', $this->data, true);
        }
    }

    public function add_patient($patient_id = '', $booking_id = '')
    {

        if( in_array( $this->auth_role, ['doctor'] ) ) {
            $user_id = $this->auth_user_id;
            $this->data['patient_id'] = $patient_id;
            if (isset($patient_id) && $patient_id != '') {
                $this->data['patient_details'] = $this->patients_model->get_patient_details($patient_id);
            }
            if (isset($booking_id) && $booking_id != '') {
                $this->data['booking_details'] = $this->booking_model->get_patient_booking_details($booking_id);
            }
            $this->data['myuserid'] = $user_id;

            $myfirm = $this->settings_model->get_myfirm($this->auth_user_id);
            if (!empty($myfirm)) {
                $this->data['myfirm'] = $myfirm->firm_id;
            }


            $department = $this->settings_model->get_mydepartment($this->auth_user_id);
            if (!empty($department)) {
                $this->data['bookedby'] = $this->settings_model->get_department_users($department->department_id);
                $this->data['firms'] = $this->settings_model->get_firms_list($department->department_id);
            }
            $this->data['procedures'] = $this->settings_model->get_procedure_department($department->department_id);
            $this->data['theatre'] = $this->settings_model->get_theatres();
            $this->data['insuranceco'] = $this->settings_model->get_insurance_companies();
            $this->data['priorities'] = $this->settings_model->get_priorities();
            $this->data['category'] = $this->settings_model->get_category();

            $this->data['wards'] = $this->settings_model->get_wards_list();
            $this->data['slots'] = $this->settings_model->get_timeslots();
            // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
            $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->case_list . $this->general_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('patients/add_patient', $this->data, true);
        }

    }

    public function patient_page($patient_id = '', $booking = '')
    {
        if( in_array( $this->auth_role, ['admin','doctor'] ) ) {
            $this->data['patient_id'] = $patient_id;
            if (isset($patient_id) && $patient_id != '') {
                $this->data['patient_details'] = $this->patients_model->get_patient_details($patient_id);
            }

            if (isset($booking) && $booking != '') {
                $this->data['booking_id'] = $booking;
            }

            $user_id = $this->auth_user_id;
            $department = $this->user_model->get_users_department($user_id);
            $this->data['myuserid'] = $user_id;

            (!empty($department))?$this->data['mydepartmentid'] = $department->department_id:$this->data['mydepartmentid']='';
            if (!empty($department)) {
                $this->data['my_departmentalfirms'] = $this->settings_model->get_mydefault_firms($user_id, $department->department_id);
                $this->data['leadsurgeon'] = $this->settings_model->get_department_users($department->department_id);
                $this->data['department_firms'] = $this->settings_model->get_all_firms_by_department($department->department_id);

            } else {
                $this->data['my_departmentalfirms'] = '';
            }


            $this->data['rplprocedures'] = $this->settings_model->get_rplprocedures();

            $this->data['procedures'] = $this->settings_model->get_procedure_department($department->department_id);
            $this->data['theatre'] = $this->settings_model->get_theatres();
            $this->data['insuranceco'] = $this->settings_model->get_insurance_companies();
            $this->data['priorities'] = $this->settings_model->get_priorities();
            $this->data['category'] = $this->settings_model->get_category();
            $this->data['firms'] = $this->settings_model->get_firms_list();
            $this->data['wards'] = $this->settings_model->get_wards_list();
            $this->data['slots'] = $this->settings_model->get_timeslots();
            // $this->data['submision'] = $this->dashboard_model->getsub_scounties();
            $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->case_list . $this->general_tools;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->_smart_render('patients/patient_page', $this->data, true, true);
        }
    }

    public function create_new_patient($id = '')
    {

        $this->form_validation->set_rules('folder_number', 'Folder Number', 'required');
        $this->form_validation->set_rules('surname', 'Surname', 'required');
        $this->form_validation->set_rules('other_names', 'Other Name', 'required');
        $this->form_validation->set_rules('dateofbirth', 'Date of Birth', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('postal_code', 'Post Code', 'required');

        $patient_id = $this->input->post('patient_id');

        if ($this->form_validation->run() == true) {

            $data = array(
                'folder_number' => $this->input->post('folder_number'),
                'surname' => $this->input->post('surname'),
                'other_names' => $this->input->post('other_names'),
                'gender' => $this->input->post('gender'),
                'dateofbirth' => $this->input->post('dateofbirth'),
                'email' => $this->input->post('email'),
                'phone' => $this->input->post('phone'),
                'phone2' => $this->input->post('phone2'),
                'phone3' => $this->input->post('phone3'),
                'postal_code' => $this->input->post('postal_code'),
                'suburb_id' => $this->input->post('suburb'),
                'facility_id' => $this->auth_facilityid,
                //'insuranceco_id' => $this->input->post('insurance'),
                //'insurance_number' => $this->input->post('insurance_number'),
                'additional_info' => $this->input->post('additional_info'),
                'created_on' => date('Y-m-d H:i:s', strtotime('now')),
                'created_by' => $this->auth_user_id
            );
        }


        if (!is_numeric($patient_id)) {
            if ($this->form_validation->run() == true) {
                $patientid = $this->patients_model->patient_insert($data);
                !empty($this->input->post('postal_code')) ? $this->calculate_distance($patient_id) : '';
                $log_action = 'Patient Registration';
                $log_info = 'Created new patient on ' . date('Y-m-d H:i:s', strtotime('now'));
                $this->writelog->patientlog($this->auth_user_id, $patientid, $log_action, $log_info);
                $this->writelog->writelog($this->auth_user_id, $log_info);
                $this->session->set_flashdata('message', "You have successfully created a new patient");
                redirect('patients/add_patient/' . $patientid);
            }
        } else {

            if ($this->form_validation->run() == true) {

                if ($this->patients_model->patient_update($data, $patient_id)) {

                    $log_action = 'Patient Details Edit';
                    $log_info = 'Edited patient details on ' . date('Y-m-d H:i:s', strtotime('now'));
                    $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
                    $this->writelog->writelog($this->auth_user_id, $log_info);
                    $this->session->set_flashdata('message', "You have successfully Updated Patient: '" . $this->input->post('surname') . "' details");
                    !empty($this->input->post('postal_code')) ? $this->calculate_distance($patient_id) : '';
                    redirect('patients/add_patient/' . $patient_id);
                }
            }
        }
        //redirect('patients/add_patient');
    }

    public function mypatient_list_data()
    {
        $json = $this->patients_model->get_patient_list_data();


        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }

    public function search_patient()
    {
        $search_phrase = $this->input->post('phrase');
        echo json_encode($this->patients_model->general_patients_by_search_phrase($search_phrase));
    }

    public function search_patients()
    {
        $search_phrase = $this->input->get('phrase');
        $firm = $this->input->get('firm');
        echo json_encode($this->patients_model->get_patients_by_search_phrase($search_phrase, $firm));
    }

    public function search_patients_details()
    {
        $patient_id = $this->input->post('patient_id');
        $patient_details = $this->booking_model->get_patient_details($patient_id);
        $return = '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			Patient Details
		</div>'
            . '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . '</td> <th>Phone:</th><td>' . $patient_details->phone . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th>DOB/Age:</th><td>' . $patient_details->dateofbirth . ' (' . $patient_details->age . ')</td> <th>Email:</th><td>' . $patient_details->email . '</td> <th>Alt Phone:</th><td>' . $patient_details->phone2 . '</td>'
            . '</tr>'
            . '</table>';
        echo $return;
    }

    public function search_patients_booking_details()
    {
        $booking_id = $this->input->post('booking_id');
        $patient_details = $this->booking_model->get_mycase_details($booking_id);
        $return = '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			Patient Booking Details
		</div>'
            . '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . '</td> <th>Phone:</th><td>' . $patient_details->phone . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th>Procedure:</th><td>' . $patient_details->procedure_name . '</td> <th>Booking Date:</th><td>' . $patient_details->bookingdate . '</td> <th>Lead Time:</th><td>' . $patient_details->leadtime . '</td>'
            . '</tr>'
            . '</table>';
        echo $return;
    }

    public function search_patients_admission_details()
    {
        $booking_id = $this->input->post('booking_id');
        $procedure_id = $this->booking_model->booking_procedure_id($booking_id);
        $mapts = $this->booking_model->get_mapt_by_procedure($procedure_id);

        $patient_details = $this->booking_model->get_mycase_details($booking_id);
        $return = '<input type="hidden" name="booking_id" id="booking_id" value="' . $booking_id . '" >';

        $return .= '<input type="hidden" name="procedure_id" id="procedure_id" value="' . $procedure_id . '" >';
        $return .= '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			Patient Admission Details
		</div>'
            . '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . '</td> <th>Phone:</th><td>' . $patient_details->phone . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th>Booked Procedure:</th><td>' . $patient_details->procedure_name . '</td> <th>Admission Date:</th><td>' . $patient_details->admission_date . '</td> <th>Lead Time(DAYS):</th><td>' . $patient_details->leadtime . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th>Theatre:</th><td>' . $patient_details->theatre_name . '</td> <th>Firm:</th><td>' . $patient_details->firm_name . '</td> <th>Duration:</th><td>' . $patient_details->slot_name . '</td>'
            . '</tr>'
            . '</table>';
        if (!empty($mapts)) {
            $mapt_id = $mapts->mapt_id;
            $maptcriteria = $this->booking_model->get_mapt_criteria_details($mapt_id);

            $return .= '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			MAPT CRITERIA
		</div>';
            $return .= '<div class="well padding-10">'
                . '<div class="  alert alert-warning semi-bold">';
            $return .= '<input type="hidden" name="mapt_id" id="mapt_id" value="' . $mapt_id . '" >';
            foreach ($maptcriteria as $criteria_details) {
                $return .= '<fieldset>
                <section>
                            <label class="label">' . $criteria_details->criteria_name . '</label>
                            <div class="inline-group">';
                $criteria = $this->booking_model->get_mapt_criteria_score($criteria_details->criteria_id);
                foreach ($criteria as $score) {
                    //$return .= '<b>' . $score->score_text . '</b> = ' . $score->score_value . ', ';
                    $return .= '<label class="radio">
                                <input type="radio" name="optmapt[' . $criteria_details->criteria_id . ']" value="' . $score->score_id . '" requiere>
                                <i></i>' . $score->score_text . '
                        </label>';
                }
                $return .= ' </div>
                    </section>
                    </fieldset>
                    ';
            }


            $return .= '</div>';
            $return .= '</div>';
            $return .= '';
            $return .= '';
        } else {
            $return .= '<input type="hidden" name="nonmapt" id="nonmapt" value="1" >
                     <br><div class="alert alert-danger no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			This procedure has no MAP Score
		</div>';
        }
        echo $return;
    }

    public function view_patient_mapt()
    {
        $booking_id = $this->input->post('booking_id');
        $procedure_id = $this->input->post('procedure_id');

        $patient_details = $this->booking_model->get_mycase_details($booking_id);
        $maptdate_scores = $this->booking_model->get_maptDateScores($booking_id);
        $return = '<form id="fill-mapt-form" method="POST" action="#" class="smart-form" novalidate="novalidate">';
        $return .= '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			Patient\'s Details
		</div>'
            . '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . '</td> <th>Phone:</th><td>' . $patient_details->phone . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th> Booked Procedure:</th><td>' . $patient_details->procedure_name . '</td> <th>Admission Date:</th><td>' . $patient_details->admission_date . '</td> <th>Lead Time(DAYS):</th><td>' . $patient_details->leadtime . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th>Theatre:</th><td>' . $patient_details->theatre_name . '</td> <th>Firm:</th><td>' . $patient_details->firm_name . '</td> <th>Duration:</th><td>' . $patient_details->slot_name . '</td>'
            . '</tr>'
            . '</table>';
        $return .= '</form>';

        $return .= '<div class="jarviswidget jarviswidget-color-blueDark" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-deletebutton="false"
                     data-widget-fullscreenbutton="false">
                    <header >
                        <span class="widget-icon"> <i class="fa fa-clock-o"></i> </span>
                        <h2>PATIENT\'S MAPT SCORE</h2>
                    </header>';
        $return .= ' <div class="row">'
            . '<div class="col-md-4">'
            . '<p class="alert alert-info no-margin">DATE SCORED</p>'
            . '<ul class="padding-10 list-group">';
        foreach ($maptdate_scores as $scores) {
            $totalpatientscore = $this->booking_model->get_total_mapt_patient_score($scores->mapt_score_id);
            $return .= '<li class="list-group-item" onclick="view_patient_scores(' . $scores->mapt_score_id . ',' . $procedure_id . ',\'' . $scores->scoredate . '\');"><i class="fa fa-calendar"></i>  ' . $scores->scoredate . '<span class="badge badge-danger pull-right">' . $totalpatientscore . '</span></li>';
        }
        $return .= '</ul>'
            . '</div>';

        $return .= '<div class="col-md-8">'
            . '<div id="patient_scores">'
            . '</div>'
            . '</div>';

        $return .= '</div></div>';

        echo $return;
    }

    public function view_patient_scores()
    {
        $mapt_score_id = $this->input->post('mapt_score_id');
        $scoreDate = $this->input->post('scoredate');

        $return = '<div class="alert alert-info no-margin fade in">
			PRIORITIZATION SCORE(s)
                        <span class="pull-right">Score Date:' . $scoreDate . '</span>
		</div>';
        $return .= '<hr>';
        $patientscore = $this->booking_model->get_mapt_patient_score($mapt_score_id);

        $return .= '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Criteria</th> <th>Weight</th> <th>Score Text</th><th>Score Value</th> <th style="text-align: right;">% Score</th>'
            . '</tr>';
        $totascore = 0;
        foreach ($patientscore as $key) {
            $percentage_score = ($key->criteria_weight / 100) * $key->score_value;
            $totascore = $totascore + $percentage_score;
            $return .= '<tr >'
                . '<td>' . $key->criteria_name . '</td> <td>' . $key->criteria_weight . '</td> <td>' . $key->score_text . '</td> <td>' . $key->score_value . '</td> <td style="text-align: right;">' . $percentage_score . '</td>'
                . '</tr>';
        }
        $return .= '<tr class="info">'
            . '<th>TOTAL</th> <th></th><th></th><th></th><th style="text-align: right;">' . $totascore . '</th>'
            . '</tr>';
        $return .= '</table>';


        echo $return;
    }

    public function patients_admission_details()
    {
        $booking_id = $this->input->post('booking_id');

        $patient_details = $this->booking_model->get_mycase_details($booking_id);
        $phone = $this->phone_number_format($patient_details->phone);
        $message = $this->booking_model->get_sms_notification('admission', $patient_details->language_id, $patient_details->surname, $patient_details->admission_date, $patient_details->surgerydate);
        $return = '<input type="hidden" name="booking_id" id="booking_id" value="' . $booking_id . '" >';
        $return .= '<input type="hidden" name="folder_number" id="folder_number" value="' . $patient_details->folder_number . '" >';
        $return .= '<input type="hidden" name="patient_id" id="patient_id" value="' . $patient_details->patient_id . '" >';

        $return .= '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			Patient Admission Details
		</div>'
            . '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . '</td> <th>Phone:</th><td>' . $phone . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th>Booked Procedure:</th><td>' . $patient_details->procedure_name . '</td> <th>Admission Date:</th><td>' . $patient_details->admission_date . '</td> <th>Lead Time(DAYS):</th><td>' . $patient_details->leadtime . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th>Theatre:</th><td>' . $patient_details->theatre_name . '</td> <th>Firm:</th><td>' . $patient_details->firm_name . '</td> <th>Duration:</th><td>' . $patient_details->slot_name . '</td>'
            . '</tr>'
            . '</table>';
        $return .= '<fieldset>
                    <section>
                        <label class="label">Phone Number</label>
                        <label class="input state-disabled">
                            <input type="text" name="phone"  class="input-sm" value="' . $phone . '" readonly="">
                        </label>
                    </section>
                    <section>
                        <label class="label">SMS Text</label>
                        <label class="textarea textarea-resizable textarea-expandable"> 										
                            <textarea name="message" maxlength="160" rows="4" class="summernote">' . $message . '</textarea> 
                        </label>
                        <div class="note">
                            <strong>Note:</strong> expands on focus.
                        </div>
                    </section>
                </fieldset>';

        echo $return;
    }

    public function patients_booking_summary()
    {
        $booking_id = $this->input->post('booking_id');
        $patient_details = $this->booking_model->get_mycase_details($booking_id);
        $return = '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . '</td> <th>Phone:</th><td>' . $patient_details->phone . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th>Booked Procedure:</th><td>' . $patient_details->procedure_name . '</td> <th>Admission Date:</th><td>' . $patient_details->admission_date . '</td> <th>Lead Time(DAYS):</th><td>' . $patient_details->leadtime . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th>Theatre:</th><td>' . $patient_details->theatre_name . '</td> <th>Firm:</th><td>' . $patient_details->firm_name . '</td> <th>Duration:</th><td>' . $patient_details->slot_name . '</td>'
            . '</tr>'
            . '</table>';

        echo $return;
    }

    public function patients_details_by_foldernumber()
    {
        $folder_number = $this->input->post('folder_number');


        $patient_details = $this->booking_model->get_patient_details_byfolder_number($folder_number);

        $phone = $this->phone_number_format($patient_details->phone);

        $return = '<input type="hidden" name="sms_folder_number" id="folder_number" value="' . $patient_details->folder_number . '" >';
        $return .= '<input type="hidden" name="sms_patient_id" id="patient_id" value="' . $patient_details->patient_id . '" >';

        $return .= '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			Patient Admission Details
		</div>'
            . '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . ' ' . $patient_details->other_names . '</td> <th>Phone:</th><td>' . $phone . '</td>'
            . '</tr>'
            . '</table>';
        $return .= '<fieldset>
                    <section>
                        <label class="label">Phone Number</label>
                        <label class="input state-disabled">
                            <input type="text" name="sms_phone"  class="input-sm" value="' . $phone . '" readonly="">
                        </label>
                    </section>
                </fieldset>';


        echo $return;
    }

    public function view_op_notes()
    {
        $this->load->library('tcpdf');
        $booking_id = $this->input->post('booking_id');
        $patient_details = $this->booking_model->get_mycase_details($booking_id);
        $return = '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . '</td> <th>Phone:</th><td>' . $patient_details->phone . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th>Booked Procedure:</th><td>' . $patient_details->procedure_name . '</td> <th>Admission Date:</th><td>' . $patient_details->admission_date . '</td> <th>Lead Time(DAYS):</th><td>' . $patient_details->leadtime . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th>Theatre:</th><td>' . $patient_details->theatre_name . '</td> <th>Firm:</th><td>' . $patient_details->firm_name . '</td> <th>Duration:</th><td>' . $patient_details->slot_name . '</td>'
            . '</tr>'
            . '</table>';

        /* $pdf = $this->pdf->load();
          $pdf->SetFooter($_SERVER['HTTP_HOST'] . '|{PAGENO}|' . date(DATE_RFC822)); // Add a footer for good measure ;)
          $stylesheet = file_get_contents('http://localhost/surgy_track/assets/css/bootstrap.min.css');
          $pdf->WriteHTML($stylesheet, 1);
          $pdf->WriteHTML($return, 2);
          $pdf->Output();

          $this->load->library('Pdf'); */

        $this->load->helper(array('dompdf', 'file'));
        // page info here, db calls, etc.
        //$html = $this->load->view('controller/viewfile', $data, true);
        pdf_create($return, 'filename');
    }

    function phone_number_format($number)
    {
        // Allow only Digits, remove all other characters.
        $number = preg_replace("/[^\d]/", "", $number);
        // get number length.
        // $length = strlen($number);
// if number = 10
        // if ($length == 10) {
        //    $number = preg_replace("/^1?(\d{3})(\d{3})(\d{4})$/", "$1-$2-$3", $number);
        // }
        $number = preg_replace('/^0/', '27', $number);

        return $number;
    }

    public function preview_op_notes_pdf()
    {

        $booking_id = $this->input->post('booking_id');
        $patient_details = $this->booking_model->get_mycase_details($booking_id);

        $primary_surgeon = $this->booking_model->get_user_surgeon_name($booking_id, 'primary');
        $assistant_surgeon = $this->booking_model->get_user_surgeon_name($booking_id, 'assistant');
        $supervisor_surgeon = $this->booking_model->get_user_surgeon_name($booking_id, 'supervisor');

        $return = '<table width="100%" class="table">'
            . '<tr class="success" >'
            . '<th width="20%"><u>Surname:</u></th> <td width="80%">' . $patient_details->surname . ' <b>' . $patient_details->other_names . '</b></td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Folder Number:</u></th> <td>' . $patient_details->folder_number . '</td> '
            . '</tr>'
            . '<tr class="danger">'
            . '<th><u>DOB/Age:</u></th><td>' . $patient_details->dateofbirth . ' (' . $patient_details->age . ')</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th><u>Sex:</u></th><td>' . $patient_details->gender . '</td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Ward:</u></th><td>' . $patient_details->ward_name . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Firm:</u></th><td>' . $patient_details->firm_name . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th></th><td></td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Date of Surgery:</u></th><td>' . date("d/m/Y", strtotime($patient_details->surgerydate)) . '</td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Theatre:</u></th><td>' . $patient_details->theatre_name . '</td> '
            . '</tr>'
            . '<tr class="danger">'
            . '<th><u>Procedure Booked:</u></th><td>' . $patient_details->procedure_name . '</td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Surgeon:</u></th><td>' . $primary_surgeon . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Surgeon Assistants:</u></th><td>' . $assistant_surgeon . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Surgeon Supervisor:</u></th><td>' . $supervisor_surgeon . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Anaethetist :</u></th><td></td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Indication:</u></th><td>' . $patient_details->surgery_indication . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th></th><td></td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Anaethetic Type:</u></th><td></td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th></th><td></td> '
            . '</tr>'
            . '<tr class="success">'
            . ' <th><u>Operation Done:</u></th><td>' . $patient_details->operation_done . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . ' <th><u>Operation Notes:</u></th><td>' . $patient_details->op_notes . '</td>'
            . '</tr>'
            . '</table>';

        $filename = preg_replace('/\s+/', '', $patient_details->surname . '_' . preg_replace('/[^a-zA-Z0-9\-\._]/', '', $patient_details->folder_number) . '_' . $patient_details->procedure_name . '_' . date('d_m_Y') . '.pdf');
        $this->preview_op_notes($booking_id, $filename, $patient_details->procedure_name, $return);
        $file_path = base_url() . 'folder/opnotes/' .$this->auth_facilityid.'/'. $filename;
        $iframe = '<iframe src="' . $file_path . '" id="iView" style="width:100%;min-height:500px;border:dotted 1px red" frameborder="0"></iframe>';
        $returns = array(
            'file_iframe' => $iframe,
            'file_path' => OPNOTES_REPOSITORY .$this->auth_facilityid.'/'. $filename
        );
        echo json_encode($returns);
    }

    public function preview_op_notes($booking_id, $filename, $procedure_name, $return)
    {
        $this->load->library('tcpdf');
        $this->load->helper('pdf_helper');
        $this->data['filename'] = $filename;
        $this->data['title'] = $procedure_name . ' OP Notes';
        $this->data['body'] = $return;
        $this->data['facility'] = $this->auth_facilityid;
        $folder_name = $this->booking_model->get_dropbox_folder_structure($booking_id);
        $data = array(
            'opnotes_file_name' => $filename,
            'opnotes_dropbox_folder' => $folder_name,
            'opnotes_file_created_on' => date('Y-m-d H:i:s', strtotime('now')),
            'opnotes_generated_by' => $this->auth_user_id
        );

        $this->booking_model->save_opnotes_name($booking_id, $data);
        $this->writelog->writelog($this->auth_user_id, 'Viewed OP Notes for BookingID:'.$booking_id.' on '.date('Y-m-d H:i:s', strtotime('now')));
        $this->load->view('booking/op_notes_print', $this->data);
    }

    public function preview_patients_coding_pdf()
    {

        $booking_id = $this->input->post('booking_id');
        $patient_details = $this->booking_model->get_mycase_details($booking_id);

        $return = '<table width="100%" class="table">'
            . '<tr class="success" >'
            . '<th width="20%"><u>Surname:</u></th> <td width="80%">' . $patient_details->surname . ' <b>' . $patient_details->other_names . '</b></td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Folder Number:</u></th> <td>' . $patient_details->folder_number . '</td> '
            . '</tr>'
            . '<tr class="danger">'
            . '<th><u>DOB/Age:</u></th><td>' . $patient_details->dateofbirth . ' (' . $patient_details->age . ')</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th><u>Sex:</u></th><td>' . $patient_details->gender . '</td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Ward:</u></th><td>' . $patient_details->ward_name . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Firm:</u></th><td>' . $patient_details->firm_name . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th></th><td></td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Date of Surgery:</u></th><td>' . date("d/m/Y", strtotime($patient_details->surgerydate)) . '</td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Theatre:</u></th><td>' . $patient_details->theatre_name . '</td> '
            . '</tr>'
            . '<tr class="danger">'
            . '<th><u>Procedure Booked:</u></th><td>' . $patient_details->procedure_name . '</td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Surgeon:</u></th><td>' . $patient_details->surgeon_name . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Anaethetist :</u></th><td></td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Indication:</u></th><td>' . $patient_details->surgery_indication . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th></th><td></td> '
            . '</tr>'
            . '<tr class="success">'
            . '<th><u>Anaethetic Type:</u></th><td></td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th></th><td></td> '
            . '</tr>'
            . '<tr class="success">'
            . ' <th><u>Operation Done:</u></th><td>' . $patient_details->operation_done . '</td>'
            . '</tr>'
            . '</table>'
            . '<br>';
        $return .= '<h3>Procedures Done</h3>'
            . '<hr>'
            . '<br>';
        $return .= $this->get_booking_procedures_data($booking_id);
        $return .= '<h3>Consumables Used</h3>'
            . '<hr>'
            . '<br>';
        $return .= $this->booking_model->get_booking_consumable($booking_id);

        $filename = preg_replace('/\s+/', '', $patient_details->surname . '_' . preg_replace('/[^a-zA-Z0-9\-\._]/', '', $patient_details->folder_number) . '_' . $patient_details->procedure_name . '_' . date('d_m_Y') . '.pdf');
        $this->preview_patient_coding($booking_id, $filename, $patient_details->folder_number, $return);
        $file_path = base_url() . 'folder/opcoding/' .$this->auth_facilityid.'/'. $filename;
        $iframe = '<iframe src="' . $file_path . '" id="iView" style="width:100%;min-height:500px;border:dotted 1px red" frameborder="0"></iframe>';
        $returns = array(
            'file_iframe' => $iframe,
            'file_path' => OPCODING_REPOSITORY . $this->auth_facilityid.'/'.$filename
        );
        echo json_encode($returns);
    }

    public function preview_patient_coding($booking_id, $filename, $foldernumber, $return)
    {
        $this->load->library('tcpdf');
        $this->load->helper('pdf_helper');
        $this->data['filename'] = $filename;
        $this->data['title'] = $foldernumber . '- ' . $booking_id . ' Coding';
        $this->data['body'] = $return;
        $this->data['facility'] = $this->auth_facilityid;
        $folder_name = $this->booking_model->get_dropbox_folder_structure($booking_id);
        $data = array(
            'opcoding_file_name' => $filename,
            'opcoding_dropbox_folder' => $folder_name,
            'opcoding_file_created_on' => date('Y-m-d H:i:s', strtotime('now')),
            'opcoding_generated_by' => $this->auth_user_id
        );

        $this->booking_model->save_opnotes_name($booking_id, $data);
        $this->load->view('booking/opcoding_print', $this->data);
    }

    public function get_booking_procedures_data($booking_id)
    {

        $result = $this->settings_model->get_booking_rplprocedures($booking_id);

        $return = '<table style="width:100%" cellspacing="0" cellpadding="1" border="1" >
                    <thead>
                        <tr>
                            <th style="width: 5%"><b>#</b></th>
                            <th style="width: 20%"><b>RPL Code</b></th>
                            <th style="width: 50%"><b>Procedure</b></th> 
                            <th style="width: 25%" align="right"><b>Service Fee</b></th> 
                            
                        </tr>
                    </thead>';
        $i = 0;
        $totals = 0;
        foreach ($result as $key) {
            $i++;
            $totals += $key->service_fee;
            $return .= '<tr>';
            $return .= '<td style="width: 5%">' . $i . '</td>';
            $return .= '<td style="width: 20%">' . $key->rpl_code . '</td>';
            $return .= '<td style="width: 50%">' . $key->procedure_name . '</td>';
            $return .= '<td style="width: 25%" align="right"> ' . number_format($key->service_fee, 2) . ' </td>';
            $return .= '</tr>';
        }
        $return .= '<tr>';
        $return .= '<td style="width:75%" colspan="3"><b>TOTALS</b></td>';
        $return .= '<td style="width:25%" align="right"><b>' . number_format($totals, 2) . '</b></td>';
        $return .= '</tr>';
        $return .= '</table>';
        return $return;
    }

    public function caselog_patients_details()
    {
        $booking_id = $this->input->post('booking_id');
        $procedure_id = $this->input->post('procedure_id');

        $patient_details = $this->booking_model->get_mycase_details($booking_id);
        //$mapt['primary_surgeon'] = $this->get_user_surgeon_name($res->booking_id,'primary');
        //    $mapt['assistant_surgeon'] = $this->get_user_surgeon_name($res->booking_id,'assistant');
        //     $mapt['supervisor_surgeon'] = $this->get_user_surgeon_name($res->booking_id,'supervisor');
        $header = '<input type="hidden" name="booking_id" id="booking_id" value="' . $booking_id . '" >';

        $header .= '<input type="hidden" name="procedure_id" id="procedure_id" value="' . $procedure_id . '" >';
        $header .= '<div class="alert alert-info no-margin fade in">
			<i class="fa-fw fa fa-info"></i>
			Patient Admission Details
		</div>'
            . '<table width="100%" class="table">'
            . '<tr class="success">'
            . '<th>Folder Number:</th> <td>' . $patient_details->folder_number . '</td> <th>Surname:</th> <td>' . $patient_details->surname . '</td> <th>Phone:</th><td>' . $patient_details->phone . '</td>'
            . '</tr>'
            . '<tr class="danger">'
            . '<th>Booked Procedure:</th><td>' . $patient_details->procedure_name . '</td> <th>Admission Date:</th><td>' . $patient_details->admission_date . '</td> <th>Lead Time(DAYS):</th><td>' . $patient_details->leadtime . '</td>'
            . '</tr>'
            . '<tr class="success">'
            . '<th>Theatre:</th><td>' . $patient_details->theatre_name . '</td> <th>Firm:</th><td>' . $patient_details->firm_name . '</td> <th>Duration:</th><td>' . $patient_details->slot_name . '</td>'
            . '</tr>'
            . '</table>';

        $return = array('header' => $header,
            'opnotes' => $patient_details->op_notes,
            'surgeon_name' => $patient_details->surgeon_name,
            'anethesia_start' => $patient_details->anethesia_start,
            'anethesia_end' => $patient_details->anethesia_end,
            'op_date_start' => $patient_details->op_date_start,
            'op_date_end' => $patient_details->op_date_end,
            'surgeon_uid' => $this->booking_model->get_user_surgeon_id($booking_id, 'primary'),
            'surgeon_supervisor' => $this->booking_model->get_user_surgeon_id($booking_id, 'supervisor'),
            'surgeon_assistant' => $this->booking_model->get_user_surgeon_id($booking_id, 'assistant'),
            'operation_done' => $patient_details->operation_done
        );
        echo json_encode($return);
    }

    public function remove_patients()
    {
        $patient_id = $this->input->post('patient_id');
        if ($this->patients_model->delete_patient($patient_id)) {
            $return = array('patient_id' => $patient_id,
                'message' => 'You have succesfully deleted a  patients records',
                'success' => 1);

            $this->session->set_flashdata('message', "You have succesfully deleted patients records");
            $log_action = 'Patient Delete';
            $log_info = 'Patients records has been deleted ' . date('Y-m-d H:i:s', strtotime('now')) . '  #' . serialize($return);
            $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
            $this->writelog->writelog($this->auth_user_id, 'Patients records has been deleted :' . $patient_id, "#" . serialize($return));

            echo json_encode($return);
        } else {
            $return = array('patient_id' => $patient_id,
                'message' => 'Patients records delete failed',
                'success' => 0);

            $log_action = 'Patient Delete failed';
            $log_info = 'Patients records delete has failed ' . date('Y-m-d H:i:s', strtotime('now')) . '  #' . serialize($return);
            $this->writelog->patientlog($this->auth_user_id, $patient_id, $log_action, $log_info);
            $this->writelog->writelog($this->auth_user_id, 'Patients records delete has failed:' . $patient_id, "#" . serialize($return));

            echo json_encode($return);
        }
    }

    public function delete_booking($patient_id, $booking_id)
    {
        $this->booking_model->delete_booking($booking_id);
        redirect('patients/lists/');
    }

    public function calculate_distance($patient_id, $my_destination = '')
    {
        require(APPPATH . 'libraries/Requests.php');
        $patient_surburb = $this->patients_model->get_patient_details($patient_id);
        $origins = $patient_surburb->latitude . ',' . $patient_surburb->longitude;
        $destination = !empty($my_destination) ? $my_destination : TYGERBERG_GEOCODES;
        $params = 'origins=' . $origins . '&destinations=' . $destination;

        Requests::register_autoloader();
        $response = Requests::get(GOOGLE_DISTANCE_API_URL . $params . '&key=' . GOOGLE_DISTANCE_API_KEY);
        $json = $response->body;
        $data = json_decode($json, true);
        $rows = $data['rows'];

        $mrows = $data['rows'][0]['elements']; //json_decode($rows, true);[0]['duration'][0]['text']
        $time_taken = !empty($mrows[0]['duration']['text']) ? $mrows[0]['duration']['text'] : '';
        $distance = !empty($mrows[0]['distance']['text']) ? $mrows[0]['distance']['text'] : '';

        $data = array(
            'distance_km' => $distance,
            'time_to_hospital' => $time_taken
        );
        if ($this->patients_model->patient_update($data, $patient_id)) {
            $this->session->set_flashdata('message', '<div class="alert alert-success fade in">
                                                            <button class="close" data-dismiss="alert">
                                                                    ×
                                                            </button>
                                                            <i class="fa-fw fa fa-check"></i>
                                                            <strong>Success</strong> Patients records updated
                                                    </div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger fade in">
                                                            <button class="close" data-dismiss="alert">
                                                                    ×
                                                            </button>
                                                            <i class="fa-fw fa fa-check"></i>
                                                            <strong>ERROR:</strong> Patients records update failed
                                                    </div>');
        }
    }

    public function spacial_mapping()
    {
        if (!$this->is_logged_in()) {
            redirect('auth', 'refresh');
        } else {
            $this->data['pagescripts'] = $this->pagescripts . $this->table_tools . $this->case_list . $this->general_tools . $this->google_maps;
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->_smart_render('patients/patients_mapping', $this->data, true);
        }
    }

}