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

        $this->_load_dependencies();



        header('Access-Control-Allow-Origin: *');
    }

    /**
     * Load dependencies
     */
    private function _load_dependencies()
    {
        $this->load->database();
        $this->load->add_package_path(APPPATH . 'third_party/community_auth/');
        $this->load->database();
        $this->config->load('db_tables');
        $this->config->load('authentication');
        $this->load->library([
            'session', 'tokens', 'authentication'
        ])->helper([
            'serialization', 'cookie'
        ])->model('auth_model');
        if (config_item('declared_auth_model') != 'auth_model')
            $this->load->model(config_item('declared_auth_model'));

        $this->load->model(array('api_model'));
        $this->load->model('Authorization/authorization_model');
        $this->load->model('Authorization/validation_callables');
        $this->load->library(array('writelog','notificationmanager'));
        $this->load->helper('password');
    }

    public function create_post()
    {
        $admin = $this->post();
        $password=get_random_password(8,8,true,true);
        $user_data =[
            'email'      => $admin['email'],
            'auth_level' => '9', // 9 if you want to login @ examples/index.
            'phone_number' => $admin['phone_number'],
            'first_name' => $admin['first_name'],
            'last_name' => $admin['last_name'],
            'token' => $admin['token'],
            'accountsadmin_id' => $admin['id'],
        ];
        $user_data['username'] = NULL;
        $user_data['passwd'] = $this->authentication->hash_passwd($password);
        $user_data['user_id'] = $this->authorization_model->get_unused_id();
        $user_data['created_at'] = date('Y-m-d H:i:s', strtotime('now'));


        $stmt = $this->api_model->admin_user_insert($user_data,$password, $admin['facility_id']);

        if ($stmt) {
            $this->writelog->writelog(0, 'Admin User '.$admin['email'].' details was created:' . date('Y-m-d H:i:s', strtotime('now')),'Admin user account creation successfull');
            $this->response($stmt, 200);
        } else {
            $this->writelog->writelog(0, 'Admin User '.$admin['email'].' details creation failed:' . date('Y-m-d H:i:s', strtotime('now')),'Admin User creation failed');
            $this->response(array('error' => 'Admin User creation failed'), 404);
        }
    }

}