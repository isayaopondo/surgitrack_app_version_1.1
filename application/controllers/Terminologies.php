<?php
/**
 * Surgitrack - Terminologies Controller
 *
 *
 * @package     Surgitrack Auth
 * @author      Isaya Opondo
 * @copyright   Copyright (c) 2017, Isaya Opondo.
 * @license
 * @link        http://surgitrack.co.za
 */

class Terminologies extends MY_Controller
{

    private $pagescripts = "";
    private $settings_tools = "";
    private $user_group = '';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array( 'form_validation', 'alerts'));
        $this->load->helper(array('url', 'language'));

        $this->load->model(array('settings_model', 'terminologies_model','setup_model'));

        $this->pagescripts .= "<!-- PAGE RELATED PLUGIN(S) -->";
        $this->pagescripts .= "<script src=\"" . base_url()  . "assets/js/plugin/datatables/jquery.dataTables.min.js\"></script>
		<script src=\"" . base_url()  . "assets/js/plugin/datatables/dataTables.colVis.min.js\"></script>
		<script src=\"" . base_url()  . "assets/js/plugin/datatables/dataTables.tableTools.min.js\"></script>
		<script src=\"" . base_url()  . "assets/js/plugin/datatables/dataTables.bootstrap.min.js\"></script>
		<script src=\"" . base_url()  . "assets/js/plugin/datatable-responsive/datatables.responsive.min.js\"></script> 
                <script src=\"" . base_url()  . "assets/js/bootstrap/bootstrap-colorpicker.js\"></script>
                <script src=\"" . base_url()  . "assets/js/plugin/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js\"></script>
               ";
        $this->jree = '
                    <script src="' . base_url()  . 'assets/js/plugins/jtree/jstree.js"></script> ';
        $this->settings_tools = ''
            . ' <script src="' . base_url()  . 'assets/js/pages/table_tools.js"></script> ';
        $this->settings_tools = '<script src="' . base_url()  . 'assets/js/pages/filters.js"></script>'
            . ' <script src="' . base_url()  . 'assets/js/pages/settings_tools.js"></script> ';


        $this->general_tools = '
                 <script src="' . base_url()  . 'assets/js/pages/general_tools.js"></script> '
            . '<script src="' . base_url()  . 'assets/js/plugin/bootstrap-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>	';

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
        redirect('/', 'refresh');
    }

    public function icdten()
    {
        redirect('/', 'refresh');
    }

    public function nappi()
    {
        redirect('/', 'refresh');
    }

    public function rpl()
    {

        $this->data['grouptree'] = $this->terminologies_model->get_procedure_tree();
        $this->data['category'] = $this->settings_model->get_category();
        $this->data['procedure_groups'] = $this->settings_model->get_procedure_groups();
        $this->data['procedure_subgroups'] = $this->settings_model->procedure_subgroups_list();
        $this->data['pagescripts'] = $this->pagescripts . $this->settings_tools . $this->general_tools;
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
        $this->_smart_render('terminologies/rpl_codes', $this->data, true);

    }
}