<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 29/10/2017
 * Time: 00:16
 */


require_once(APPPATH . 'libraries/REST_Controller.php');

class Users extends REST_Controller
{

    function __construct($config = 'rest')
    {
        parent::__construct($config);

        $this->load->database();
        $this->config->load('authentication');
        $this->load->library([
            'session', 'tokens', 'authentication'
        ])->helper([
            'serialization', 'cookie'
        ])->model('Auth_model');
        if (config_item('declared_auth_model') != 'Auth_model')
            $this->load->model(config_item('declared_auth_model'));
        $this->load->model(array('api_model'));
        $this->load->model('Authorization/authorization_model');
        $this->load->model('Authorization/validation_callables');
        $this->load->library('notificationmanager');
        header('Access-Control-Allow-Origin: *');
    }

    public function create_post()
    {

        $admin = $this->post();

        $user_data =[
            'passwd'     => 'Passw0rd',
            'email'      => $admin['email'],
            'auth_level' => '9', // 9 if you want to login @ examples/index.
            'phone_number' => $admin['phone_number'],
            'first_name' => $admin['first_name'],
            'last_name' => $admin['last_name'],
            'token' => $admin['token'],
            'accountsadmin_id' => $admin['id'],
        ];
        $user_data['username'] = NULL;
        $user_data['passwd'] = $this->authentication->hash_passwd($user_data['passwd']);
        $user_data['user_id'] = $this->authorization_model->get_unused_id();
        $user_data['created_at'] = date('Y-m-d H:i:s');


        $stmt = $this->api_model->admin_user_insert($user_data, $admin['facility_id']);

        if ($stmt) {
            $this->response($stmt, 200);
        } else {
            $this->response(array('error' => 'Admin User creation failed'), 404);
        }
    }

}