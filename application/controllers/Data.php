<?php
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

class Data extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Force SSL
        //$this->force_ssl();

        // Form and URL helpers always loaded (just for convenience)
        $this->load->helper(array('url', 'form'));
        $this->load->model(array('settings_model', 'booking_model', 'user_model', 'dashboard_model'));
    }

    public function facility_procedure_summary_data()
    {
        $json = $this->booking_model->get_procedure_summaries();
        $this->output->set_header("Pragma: no-cache");
        $this->output->set_header("Cache-Control: no-store, no-cache");
        $this->output->set_content_type('application/json')->set_output("{\"data\":" . json_encode($json) . "}");
    }
}