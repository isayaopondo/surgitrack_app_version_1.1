<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 29/10/2017
 * Time: 00:16
 */


require_once(APPPATH . 'libraries/REST_Controller.php');

class Facilities extends REST_Controller
{
    function __construct($config = 'rest') {
        parent::__construct($config);

        $this->load->database();
        $this->load->model(array('api_model'));
        $this->load->library('notificationmanager');
        $this->load->library(array('writelog'));
        header('Access-Control-Allow-Origin: *');
    }

    public function create_post() {

        $data=$this->post();


        $stmt = $this->api_model->facilities_insert( $data);
        if ($stmt) {
            $this->response($stmt, 200);
        } else {
            $this->response(array('error' => 'Facility creation failed'), 404);
        }
    }

}