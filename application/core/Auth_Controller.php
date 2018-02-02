<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - Auth Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */
class Auth_Controller extends CI_Controller
{

    /**
     * The logged-in user's user ID
     *
     * @var string
     * @access public
     */
    public $auth_user_id;

    /**
     * The logged-in user's username
     *
     * @var string
     * @access public
     */
    public $auth_username;

    /**
     * The logged-in user's authentication account type by number
     *
     * @var string
     * @access public
     */
    public $auth_level;

    /**
     * The logged-in user's authentication account type by name
     *
     * @var string
     * @access public
     */
    public $auth_role;

    /**
     * The logged-in user's email
     *
     * @var string
     * @access public
     */
    public $auth_email;

    /**
     * The logged-in user's authentication data,
     * which is their user table record, but could
     * be whatever you want it to be if you modify
     * the queries in the auth model.
     *
     * @var object
     * @access protected
     */
    protected $auth_data;

    /**
     * The logged-in user's ACL permissions after login,
     * or after login status check.
     *
     * If query for ACL performed, this variable becomes an array.
     *
     * @var mixed
     * @access public
     */
    public $acl = NULL;


    public $multi_facl = NULL;
    public $auth_facilityid;
    public $auth_facilityname;
    public $auth_departmentname;
    public $auth_departmentid;

    public $facility_data = [];

    public $faclid;
    /**
     * Either 'https' or 'http' depending on the current environment
     *
     * @var string
     * @access public
     */
    public $protocol = 'http';

    // --------------------------------------------------------------

    public function __construct()
    {
        parent::__construct();

        /**
         * Loading of dependencies done here, as opposed to autoloading
         * through config/autoload.php, because sometimes you will want to not
         * have all things autoloaded.
         */
        $this->_load_dependencies();


        /**
         * Set no-cache headers so pages are never cached by the browser.
         * This is necessary because if the browser caches a page, the
         * login or logout link and user specific data may not change when
         * the logged in status changes.
         */
        header('Expires: Wed, 13 Dec 1972 18:37:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        /**
         * Set the request protocol
         */
        if (is_https())
            $this->protocol = 'https';

        /**
         * If the http user cookie is set, make user data available in views
         */
        if (get_cookie(config_item('http_user_cookie_name'))) {
            $http_user_data = unserialize_data(get_cookie(config_item('http_user_cookie_name')));

            $this->load->vars($http_user_data);
        }

        //$this->output->enable_profiler();
    }

    // --------------------------------------------------------------

    /**
     * Load dependencies
     */
    private function _load_dependencies()
    {
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
    }

    // -----------------------------------------------------------------------

    /**
     * Require a login by user of account type specified numerically.
     * User assumes your priveledges are linear in relationship to account types.
     *
     * @param   int    the minimum level of user required
     * @return  mixed  either returns TRUE or doesn't return
     */
    protected function require_min_level($level)
    {
        if (!is_null($this->auth_facilityid))
            $facility_id = $this->auth_facilityid;
        else
            $facility_id = '';
        // Has user already been authenticated?
        if (!is_null($this->auth_level) && $this->auth_level >= $level) {
            return TRUE;
        }

        // Check if logged in or if login attempt
        $this->auth_data = $this->authentication->user_status($level, $facility_id);

        // Set user variables if successful login or user is logged in

        if ($this->auth_data)
            $this->_set_user_variables();

        // Call the post auth hook
        $this->post_auth_hook();


        // Successful login or user is logged in
        if ($this->auth_data) {
            return TRUE;
        } // Else check if we need to redirect to the login page
        else if ($this->uri->uri_string() != LOGIN_PAGE) {
            $this->_redirect_to_login_page();
        }

        // Else this is a failed login attempt or the login page was loaded
        return FALSE;
    }

    // --------------------------------------------------------------

    /**
     * Require a login by role in a specific group
     * or groups, specified by group name(s).
     *
     * @param  string  a group name or names as a comma separated string.
     */
    protected function require_group($group_names)
    {
        // Get all groups from config
        $groups = config_item('groups');

        // Get group(s) allowed to login
        $group_array = explode(',', $group_names);

        // Trim off any space chars
        $group_array = array_map('trim', $group_array);

        // Initialize array of roles allowed to login
        $roles = [];

        // Add group members to roles array
        foreach ($group_array as $group) {
            // Turn group members into an array
            $temp_arr = explode(',', $groups[$group]);

            // Merge array of group members with roles array
            $roles = array_merge($roles, $temp_arr);
        }

        // Turn the array of roles into a comma seperated string
        $roles_string = implode(',', $roles);

        // Try to login via require_role method
        return $this->require_role($roles_string);
    }

    // --------------------------------------------------------------

    /**
     * Require a login by user of a specific account type, specified by name(s).
     *
     * @param   string  a comma seperated string of account types that are allowed.
     * @return  mixed  either returns TRUE or doesn't return
     */
    protected function require_role($roles)
    {
        if (!is_null($this->auth_facilityid))
            $facility_id = $this->auth_facilityid;
        else
            $facility_id = '';

        // Turn the roles string into an array or roles
        $role_array = explode(',', $roles);

        // Trim off any space chars
        $role_array = array_map('trim', $role_array);

        // Has user already been authenticated?
        if (!is_null($this->auth_role) && in_array($this->auth_role, $role_array)) {
            return TRUE;
        }

        // Check if logged in or if login attempt
        $this->auth_data = $this->authentication->user_status($role_array, $facility_id);

        // Set user variables if successful login or user is logged in
        if ($this->auth_data)
            $this->_set_user_variables();

        $this->post_auth_hook();

        // Successful login or user is logged in
        if ($this->auth_data) {
            return TRUE;
        } // Else check if we need to redirect to the login page
        else if ($this->uri->uri_string() != LOGIN_PAGE) {
            $this->_redirect_to_login_page();
        }

        // Else this is a failed login attempt or the login page was loaded
        return FALSE;
    }

    // --------------------------------------------------------------

    /**
     * Redirect to the login page
     */
    private function _redirect_to_login_page()
    {
        // Determine the login redirect
        $redirect = $this->input->get(AUTH_REDIRECT_PARAM)
            ? urlencode($this->input->get(AUTH_REDIRECT_PARAM))
            : urlencode($this->uri->uri_string());

        // Set the redirect protocol
        $redirect_protocol = USE_SSL ? 'https' : NULL;

        // Load URL helper for the site_url function
        $this->load->helper('url');

        // Redirect to the login form
        header(
            'Location: ' . site_url(LOGIN_PAGE . '?' . AUTH_REDIRECT_PARAM . '=' . $redirect, $redirect_protocol),
            TRUE,
            302
        );
    }

    // -----------------------------------------------------------------------

    /**
     * Function used for allowing a login that isn't required. An example would be
     * a optional login during checkout in an eCommerce application. Login isn't
     * mandatory, but useful because a user's account can be accessed.
     *
     * @return  bool  TRUE if logged in
     */
    protected function optional_login()
    {
        // Has user already been authenticated?
        if ($this->auth_data)
            return TRUE;

        $this->auth_data = $this->authentication->user_status(0);

        // Set user variables if successful login or user is logged in
        if ($this->auth_data)
            $this->_set_user_variables();

        // Call the post auth hook
        $this->post_auth_hook();

        if ($this->auth_data)
            return TRUE;

        return FALSE;
    }

    // --------------------------------------------------------------

    /**
     * Function is an alias of verify_min_level, but with no arguments.
     */
    protected function is_logged_in()
    {
        return $this->verify_min_level(1);
    }

    protected function is_logged()
    {
        if ($this->auth_level >= '1') {
            return TRUE;
        } else {
            return FALSE;
        }

    }

    // --------------------------------------------------------------

    /**
     * Verify if user logged in by account type specified numerically.
     * This is for use when login is not required, but beneficial.
     *
     * @param   int    the minimum level of user to be verified.
     * @return  bool  TRUE if logged in
     */
    protected function verify_min_level($level)
    {

        if (!is_null($this->auth_facilityid))
            $facility_id = $this->auth_facilityid;
        else
            $facility_id = '';

        // Has user already been authenticated?
        if (!is_null($this->auth_level) && $this->auth_level >= $level) {
            return TRUE;
        }

        $this->auth_data = $this->authentication->check_login($level, $facility_id);

        // Set user variables if user is logged in
        if ($this->auth_data)
            $this->_set_user_variables();

        // Call the post auth hook
        $this->post_auth_hook();


        if ($this->auth_data)
            return TRUE;

        return FALSE;
    }

    // --------------------------------------------------------------

    /**
     * Verify if user logged in by account type specified by name(s).
     * This is for use when login is not required, but beneficial.
     *
     * @param   string  comma seperated string of account types that to be verified.
     * @return  bool  TRUE if logged in
     */
    protected function verify_role($roles)
    {
        if (!is_null($this->auth_facilityid))
            $facility_id = $this->auth_facilityid;
        else
            $facility_id = '';


        $role_array = explode(',', $roles);

        // Trim off any space chars
        $role_array = array_map('trim', $role_array);

        // Has user already been authenticated?
        if (!is_null($this->auth_role) && in_array($this->auth_role, $role_array)) {
            return TRUE;
        }

        $this->auth_data = $this->authentication->check_login($role_array, $facility_id);

        // Set user variables if user is logged in
        if ($this->auth_data)
            $this->_set_user_variables();


        // Call the post auth hook
        $this->post_auth_hook();

        if ($this->auth_data)
            return TRUE;

        return FALSE;
    }


    protected function check_facility($facility_id = '')
    {


        // Has user already been authenticated?
        if (!is_null($this->auth_facilityid) && $this->auth_facilityid == $facility_id) {
            return TRUE;
        }

        $this->auth_data = $this->authentication->check_facilities('1', $facility_id);


        // Set user variables if user is logged in
        if ($this->auth_data)
            $this->_set_user_variables();

        // Call the post auth hook
        $this->post_auth_hook();


        if ($this->auth_data)
            return TRUE;

        return FALSE;


    }

    protected function check_facilities($facilities, $facility_id = '')
    {
        if (isset($this->auth_facilityid) && $this->auth_facilityid != '0') {
            return TRUE;
        } else {

            $facl = $this->arrayCastRecursive($facilities);

            if (!is_null($facility_id) && $facility_id != '') {
                $this->faclid = $facility_id;

                $found = current(array_filter($facl, function ($facility) {
                    return isset($facility['facility_id']) && $facility['facility_id'] == $this->faclid;
                }));

                $facility_data = (array)$found;

                $this->_set_user_variables($facility_data);

            } else {

                $j = count($facl);
                if ($j == 1) {
                    $this->facility_data = (OBJECT)$facl;
                    $this->_set_user_variables($this->facility_data);
                    //$this->load_default_facilities();
                } else
                    return false;

            }
        }

        return false;
    }


    // --------------------------------------------------------------

    /**
     * Set variables related to authentication, for use in views / controllers.
     */
    protected function _set_user_variables()
    {
        // Set user specific variables to be available in controllers
        $this->auth_user_id = $this->auth_data->user_id;
        $this->auth_username = $this->auth_data->username;
        $this->auth_name = $this->auth_data->first_name .' '.$this->auth_data->last_name;
        //$this->auth_level = $this->auth_data->auth_level;
        $this->auth_role = $this->authentication->roles[$this->auth_data->auth_level];
        $this->auth_email = $this->auth_data->email;


        // Set user specific variables to be available in all views
        $data = [
            'auth_user_id' => $this->auth_user_id,
            'auth_name' => $this->auth_name,
            'auth_username' => $this->auth_username,
            'auth_role' => $this->auth_role,
            'auth_email' => $this->auth_email
        ];

        // Set user specific variables to be available as config items
        $this->config->set_item('auth_user_id', $this->auth_user_id);
        $this->config->set_item('auth_name', $this->auth_name);
        $this->config->set_item('auth_username', $this->auth_username);

        $this->config->set_item('auth_role', $this->auth_role);
        $this->config->set_item('auth_email', $this->auth_email);

        // Add ACL permissions if ACL query turned on
        if (config_item('add_acl_query_to_auth_functions')) {
            $this->acl = $this->auth_data->acl;
            $data['acl'] = $this->acl;
            $this->config->set_item('acl', $this->acl);
        }


        if (config_item('add_facility_check') ) {//add_facility_check


            if(isset($this->auth_data->auth_level) && $this->auth_data->auth_level=='99'){
                $data['auth_level']=$this->auth_data->auth_level ;
                $this->config->set_item('auth_level', $this->auth_data->auth_level);

                $this->auth_level = $this->auth_data->auth_level;
                $this->auth_facilityid = '0';
                $this->auth_facilityname = 'SUPERADMIN';


                $data['auth_facilityid'] = '0';
                $data['auth_facilityname'] = 'SUPERADMIN';

                $this->config->set_item('auth_facilityid', '0');
                $this->config->set_item('auth_facilityname', 'SUPERADMIN');

                $data['auth_departmentname'] = 'none';
                $data['auth_departmentid'] = '0';
                $this->config->set_item('auth_departmentname', 'none');
                $this->config->set_item('auth_departmentid', '0');


            }else{
                $this->facl = $this->auth_data->facl;
                $data['facl'] = $this->facl;
                $this->config->set_item('facl', $this->facl);
                $this->multi_facl = $this->auth_data->multi_facl;

                $data['multi_facl'] = $this->multi_facl;
                $this->config->set_item('multi_facl', $this->multi_facl);

                $this->auth_facilityid = $this->facl->facility_id;
                $this->auth_facilityname = $this->facl->facility_name;
                $this->auth_level = $this->facl->auth_level;


                $data['auth_facilityid'] = $this->facl->facility_id;
                $data['auth_facilityname'] = $this->facl->facility_name;
                $data['auth_level'] = $this->facl->auth_level;

                $this->config->set_item('auth_facilityid', $this->facl->facility_id);
                $this->config->set_item('auth_facilityname', $this->facl->facility_name);
                $this->config->set_item('auth_level', $this->facl->auth_level);

                if(!empty($this->facl->department_id)){
                    $this->auth_departmentname =$this->facl->department_name;
                    $this->auth_departmentid=$this->facl->department_id;
                    $data['auth_departmentname'] = $this->facl->department_name;
                    $data['auth_departmentid'] = $this->facl->department_id;
                    $this->config->set_item('auth_departmentname', $this->facl->department_name);
                    $this->config->set_item('auth_departmentid', $this->facl->department_id);

                }else{
                    $data['auth_departmentname'] = 'none';
                    $data['auth_departmentid'] = '0';
                    $this->config->set_item('auth_departmentname', 'none');
                    $this->config->set_item('auth_departmentid', '0');
                }
            }

        }

        // Load vars
        $this->load->vars($data);
    }


    // --------------------------------------------------------------

    /**
     * Show any login error message.
     *
     * @param  bool  if login is optional or required
     */
    protected function setup_login_form($optional_login = FALSE)
    {

        $this->tokens->name = 'login_token';

        /**
         * Check if IP, username, or email address on hold.
         *
         * If a malicious form post set the on_hold authentication class
         * member to TRUE, there'd be no reason to continue. Keep in mind that
         * since an IP address may legitimately change, we shouldn't do anything
         * drastic unless this happens more than an acceptable amount of times.
         * See the 'deny_access_at' config setting in config/authentication.php
         */
        if ($this->authentication->on_hold === TRUE) {
            $view_data['on_hold_message'] = 1;
        } // This check for on hold is for normal login attempts
        else if ($on_hold = $this->authentication->current_hold_status()) {
            $view_data['on_hold_message'] = 1;
        }

        // Display a login error message if there was a form post
        if ($this->authentication->login_error === TRUE) {
            // Display a failed login attempt message
            $view_data['login_error_mesg'] = 1;
        }

        // Redirect to specified page
        $redirect = $this->input->get(AUTH_REDIRECT_PARAM)
            ? '?' . AUTH_REDIRECT_PARAM . '=' . $this->input->get(AUTH_REDIRECT_PARAM)
            : '?' . AUTH_REDIRECT_PARAM . '=' . config_item('default_login_redirect');

        // If optional login, redirect to optional login's page
        if ($optional_login) {
            $redirect = '?' . AUTH_REDIRECT_PARAM . '=' . urlencode($this->uri->uri_string());

            $view_data['optional_login'] = TRUE;
        }

        // Set the link protocol
        $link_protocol = USE_SSL ? 'https' : NULL;

        // Load URL helper for site_url function
        $this->load->helper('url');

        // Set the login URL
        $view_data['login_url'] = site_url(LOGIN_PAGE . $redirect, $link_protocol);

        $this->load->vars($view_data);
    }

    // --------------------------------------------------------------

    /**
     * Checks if logged in user is of a specific account type
     *
     * @param   string  a comma seperated string of account types to check.
     * @return  bool
     */
    protected function is_role($role = '')
    {
        $auth_model = $this->authentication->auth_model;

        return $this->$auth_model->is_role($role);
    }





    // --------------------------------------------------------------

    /**
     * Check if ACL permits user to take action.
     *
     * @param  string  the concatenation of ACL category
     *                 and action, joined by a period.
     * @return bool
     */
    public function acl_permits($str)
    {
        $auth_model = $this->authentication->auth_model;

        // Bool indicates permission
        $bool = $this->$auth_model->acl_permits($str);

        // Update the controller's ACL property
        if (is_null($this->acl))
            $this->acl = $this->$auth_model->acl;

        return $bool;
    }

    // -----------------------------------------------------------------------

    /**
     * Force the request to be redirected to HTTPS, or optionally show 404.
     * A strong security policy does not allow for redirection.
     */
    protected function force_ssl()
    {
        // Force SSL if available
        if (USE_SSL !== 0 && $this->protocol == 'http') {
            // Allow redirect to the HTTPS page
            if (config_item('redirect_to_https') !== 0) {
                // Load URL helper for the site_url function
                $this->load->helper('url');

                // Set link protocol
                $link_protocol = USE_SSL ? 'https' : NULL;

                // 301 Redirect to the secure page
                header("Location: " . site_url(trim($this->uri->uri_string(), '/'), $link_protocol), TRUE, 301);
            } // Show a 404 error
            else {
                show_404();
            }

            exit;
        }
    }


    function arrayCastRecursive($array)
    {
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = $this->arrayCastRecursive($value);
                }
                if ($value instanceof stdClass) {
                    $array[$key] = $this->arrayCastRecursive((array)$value);
                }
            }
        }
        if ($array instanceof stdClass) {
            return $this->arrayCastRecursive((array)$array);
        }
        return $array;
    }



    // --------------------------------------------------------------

    /**
     * The post auth hook allows you to do something on every request
     * that may involve knowing if the user is logged in or not.
     * Notice that this method is called after user variables are set,
     * giving you an opportunity to do something with them.
     *
     * If the request is for a page that doesn't call any authentication
     * methods, you'll need to call this method manually.
     *
     * By default, this method doesn't do anything, but you may
     * override this method in your MY_Controller.
     */


    protected function post_auth_hook()
    {
        return;
    }

    public function set_session($users)
    {
        $session_data = array(
            'identity' => $user->email,
            'email' => $user->email,
            'user_id' => $user->user_id, //
            'fullname' => $user->first_name . ' ' . $user->last_name,
            'lastname' => $user->last_name,
            'old_last_login' => $user->last_login,
            'locked' => '0'
        );
        $this->session->set_userdata($session_data);
    }

// -----------------------------------------------------------------------

}

/* End of file Auth_Controller.php */
/* Location: /community_auth/core/Auth_Controller.php */