<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Surgitrack - Dashboard Controller
 *
 *
 * @package     Surgitrack Auth
 * @author      Isaya Opondo
 * @copyright   Copyright (c) 2017, Isaya Opondo.
 * @license
 * @link        http://surgitrack.co.za
 */
class Dashboard extends MY_Controller
{
    private $pagescripts = '';
    private $dashboard = '';
    private $calendar = '';
    private $usergroup = '';
    private $user_id = '';

    public function __construct()
    {
        parent::__construct();


        // Force SSL
        //$this->force_ssl();

        // Form and URL helpers always loaded (just for convenience)
        $this->load->helper(array('url', 'form'));
        $this->load->model(array('settings_model', 'booking_model', 'user_model', 'dashboard_model','setup_model'));

        /*  if (!$this->is_logged_in()) {
              redirect('auth', 'refresh');
          } else {
              if (!empty($this->auth_role)) {
                  $this->data['usergroup'] = $this->auth_role;
                  $user_id = $this->auth_user_id;

              } else {
                  redirect('auth', 'refresh');
              }
          }*/

        $this->is_logged_in();
        if ($this->require_min_level(1)) {
            $this->data['usergroup'] = $this->auth_role;
            $this->user_id = $this->auth_user_id;
            $this->usergroup = $this->auth_role;

            if (config_item('add_facility_check')) {
                if ($this->multi_facl == '1' && (empty($this->auth_facilityid) || $this->auth_facilityid=='none')){
                    redirect('auth/facility_toggle', 'refresh');
                }
                elseif($this->auth_facilityid=='none'){
                    redirect('auth/no_facility', 'refresh');
                }
            }

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

        } else {
            redirect('auth', 'refresh');
        }

        $this->pagescripts .= "
                <!-- Full Calendar -->
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

        $this->calendar = '<script src="' . base_url() . 'assets/js/pages/filters.js"></script> '
            . ' ';

        $this->general_tools = ''
            . ' <script src="' . base_url() . 'assets/js/plugin/select2/js/select2.js"></script>';
        $this->dashboard = '<script src="' . base_url() . 'assets/js/pages/dashboard_data.js"></script> '
            . ' <script src="' . base_url() . 'assets/js/pages/dashboard_tools.js"></script> ';
    }

    /**
     * A basic page that shows verification that the user is logged in or not.
     * If the user is logged in, a link to "Logout" will be in the menu.
     * If they are not logged in, a link to "Login" will be in the menu.
     */


    public function index($caseid = '')
    {
        $user_id = $this->auth_user_id;
        $this->data['myuserid'] = $user_id;


        if (in_array($this->auth_role, ['doctor', 'nurse'])) {
            $default_firm = $this->settings_model->get_myfirm($this->auth_user_id);

            $myfirm_id = $default_firm ? $default_firm->firm_id : '';

            $this->data['myfirm'] = $myfirm_id;
            $this->data['dashstats'] = $this->dashboard_model->dashstats($myfirm_id);

            $department = $this->user_model->get_users_department($this->auth_user_id);

            $department_id = $department ? $department->department_id : '';

            $this->data['default_firm'] = $default_firm ? $default_firm->firm_name : '';
            $this->data['default_firm_color'] = !empty($default_firm->firm_color) ? $default_firm->firm_color : '#000000';

            $this->data['department_firms'] = $this->settings_model->get_all_firms_by_department($department_id);
            $this->data['bookedby'] = $this->settings_model->get_department_users($department_id);
            $this->data['firms'] = $this->settings_model->get_firms_list($department_id);
            $this->data['procedures'] = $this->settings_model->get_facility_procedure();
            $this->data['theatre'] = $this->settings_model->get_facility_theatres();
            $this->data['insuranceco'] = $this->settings_model->get_insurance_companies();
            $this->data['priorities'] = $this->settings_model->get_priorities();
            $this->data['category'] = $this->settings_model->get_category();

            $this->data['wards'] = $this->settings_model->get_wards_list();
            $this->data['slots'] = $this->settings_model->get_timeslots();
            // $this->data['casedetails'] = $this->booking_model->get_mycase_details($caseid);
            $this->data['pagescripts'] = $this->pagescripts . $this->calendar . $this->dashboard . $this->general_tools;

            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->_smart_render('dashboard/calendar', $this->data, true, true);

        } else {
            $this->data['department_firms'] = $this->settings_model->get_all_firms_by_department();
            $this->data['dashstats'] = $this->dashboard_model->dashstats();
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['pagescripts'] = $this->pagescripts . $this->calendar . $this->dashboard . $this->general_tools;
            $this->_smart_render('dashboard/admin_calendar', $this->data, true);
        }

    }

    public function case_calendar_data()
    {
        if ($this->auth_role == 'admin') {
            //Get all the current Instance Cases to display on the Calendar
            $json = $this->booking_model->get_mycase_calendar_data();
        } else {
            $user_id = $this->auth_user_id;
            $department = $this->user_model->get_users_department($user_id);
            $firm = $this->settings_model->get_myfirm($user_id);
            $department_id = $department ? $department->department_id : '';
            $firm_id = $firm ? $firm->firm_id : '';

            //Get all the current Department Cases to display on the Calendar
            $json = $this->booking_model->get_mycase_calendar_data($firm_id, $department_id);
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output(json_encode($json));
    }

    public function facility_procedure_summary_data()
    {
        if (in_array($this->auth_role, [ 'doctor', 'nurse'])) {
            $json = $this->booking_model->get_procedure_summaries($default_firm->firm_id);
        } else {
            $json = $this->booking_model->get_procedure_summaries();
        }

        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }


}