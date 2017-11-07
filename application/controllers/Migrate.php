<?php
/**
 * Created by PhpStorm.
 * User: isayaopondo
 * Date: 03/11/2017
 * Time: 17:05
 */

<<<<<<< HEAD
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

=======
class Migrate
{

>>>>>>> 61a13af29154140f5c2d70eb52c1bff72436144b
}