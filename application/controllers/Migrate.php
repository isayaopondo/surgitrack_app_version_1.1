<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 03/11/2017
 * Time: 17:05
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends MY_Controller
{

    public function index()
    {
        $this->load->library('migration');

        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        }
    }

}