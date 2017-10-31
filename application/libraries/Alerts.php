<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Alerts {

    protected $CI;

    /**
     * account status ('not_activated', etc ...)
     *
     * @var string
     * */
    protected $status;
    protected $response = NULL;

    /**
     * message (uses lang file)
     *
     * @var string
     * */
    protected $messages;

    /**
     * error message (uses lang file)
     *
     * @var string
     * */
    protected $errors;

    /**
     * error start delimiter
     *
     * @var string
     * */
    protected $error_start_delimiter;

    /**
     * error end delimiter
     *
     * @var string
     * */
    protected $error_end_delimiter;

    public function __construct() {
        $this->CI = & get_instance();
        $this->CI->load->config('ion_auth', TRUE);
        $this->CI->load->helper('cookie');
        $this->CI->load->helper('date');
        $this->CI->load->library('filemanager');
        // initialize db tables data
        $this->tables = $this->CI->config->item('tables', 'ion_auth');
        //initialize data
        $this->identity_column = $this->CI->config->item('identity', 'ion_auth');
        $this->store_salt = $this->CI->config->item('store_salt', 'ion_auth');
        $this->salt_length = $this->CI->config->item('salt_length', 'ion_auth');
        $this->join = $this->CI->config->item('join', 'ion_auth');
        // initialize hash method options (Bcrypt)
        $this->hash_method = $this->CI->config->item('hash_method', 'ion_auth');
        $this->default_rounds = $this->CI->config->item('default_rounds', 'ion_auth');
        $this->random_rounds = $this->CI->config->item('random_rounds', 'ion_auth');
        $this->min_rounds = $this->CI->config->item('min_rounds', 'ion_auth');
        $this->max_rounds = $this->CI->config->item('max_rounds', 'ion_auth');
        // initialize messages and error
        $this->messages = array();
        $this->errors = array();
        $delimiters_source = $this->CI->config->item('delimiters_source', 'ion_auth');
        // load the error delimeters either from the config file or use what's been supplied to form validation
        if ($delimiters_source === 'form_validation') {
            // load in delimiters from form_validation
            // to keep this simple we'll load the value using reflection since these properties are protected
            $this->load->library('form_validation');
            $form_validation_class = new ReflectionClass("CI_Form_validation");
            $error_prefix = $form_validation_class->getProperty("_error_prefix");
            $error_prefix->setAccessible(TRUE);
            $this->error_start_delimiter = $error_prefix->getValue($this->form_validation);
            $this->message_start_delimiter = $this->error_start_delimiter;
            $error_suffix = $form_validation_class->getProperty("_error_suffix");
            $error_suffix->setAccessible(TRUE);
            $this->error_end_delimiter = $error_suffix->getValue($this->form_validation);
            $this->message_end_delimiter = $this->error_end_delimiter;
        } else {
            // use delimiters from config
            $this->message_start_delimiter = $this->CI->config->item('message_start_delimiter', 'ion_auth');
            $this->message_end_delimiter = $this->CI->config->item('message_end_delimiter', 'ion_auth');
            $this->error_start_delimiter = $this->CI->config->item('error_start_delimiter', 'ion_auth');
            $this->error_end_delimiter = $this->CI->config->item('error_end_delimiter', 'ion_auth');
        }
       // $this->trigger_events('model_constructor');
    }

    /**
     * set_message_delimiters
     *
     * Set the message delimiters
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function set_message_delimiters($start_delimiter, $end_delimiter) {
        $this->message_start_delimiter = $start_delimiter;
        $this->message_end_delimiter = $end_delimiter;
        return TRUE;
    }

    /**
     * set_error_delimiters
     *
     * Set the error delimiters
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function set_error_delimiters($start_delimiter, $end_delimiter) {
        $this->error_start_delimiter = $start_delimiter;
        $this->error_end_delimiter = $end_delimiter;
        return TRUE;
    }

    /**
     * set_message
     *
     * Set a message
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function set_message($message) {
        $this->messages[] = $message;
        return $message;
    }

    /**
     * messages
     *
     * Get the messages
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function messages() {
        $_output = '';
        foreach ($this->messages as $message) {
            $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##'
                    . $message . '##';
            $_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
        }
        return $_output;
    }

    /**
     * messages as array
     *
     * Get the messages as an array
     *
     * @return array
     * @author Raul Baldner Junior
     * */
    public function messages_array($langify = TRUE) {
        if ($langify) {
            $_output = array();
            foreach ($this->messages as $message) {
                $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' .
                        $message . '##';
                $_output[] = $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
            }
            return $_output;
        } else {
            return $this->messages;
        }
    }

    /**
     * clear_messages
     *
     * Clear messages
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function clear_messages() {
        $this->messages = array(
        );
        return TRUE;
    }

    /**
     * set_error
     *
     * Set an error message
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function set_error($error
    ) {
        $this->errors[] = $error;
        return $error;
    }

    /**
     * errors
     *
     * Get the error message
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function errors() {
        $_output = '';
        foreach ($this->errors as $error) {
            $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##'
                    . $error . '##';
            $_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
        }
        return $_output;
    }

    /**
     * errors as array
     *
     * Get the error messages as an array
     *
     * @return array
     * @a
      uthor Raul Baldner Junior
     * */
    public function errors_array($langify = TRUE) {
        if ($langify) {
            $_output = array();
            foreach ($this->errors as $error) {
                $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' .
                        $error . '##';
                $_output[] = $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
            }
            return $_output;
        } else {
            return $this->errors;
        }
    }

    /**
     * clear_errors
     *
     * Clear Errors
     *
     * @return void
     * @author Ben Edmunds
     * */
    public function clear_errors() {
        $this->errors = array(
        );
        return TRUE;
    }

    protected function _filter_data($table, $data) {
        $filtered_data = array();


        $columns = $this->db->list_fields($table);
        if (is_array($data)) {
            foreach ($columns as $column) {
                if (array_key_exists($column, $data))
                    $filtered_data[$column] = $data[$column];
            }
        }
        return $filtered_data;
    }

    protected function _prepare_ip($ip_address) {
// just return the string IP address now for better compatibility
        return $ip_address;
    }

}
