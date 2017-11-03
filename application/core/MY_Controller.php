<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Community Auth - MY Controller
 *
 * Community Auth is an open source authentication application for CodeIgniter 3
 *
 * @package     Community Auth
 * @author      Robert B Gottier
 * @copyright   Copyright (c) 2011 - 2017, Robert B Gottier. (http://brianswebdesign.com/)
 * @license     BSD - http://www.opensource.org/licenses/BSD-3-Clause
 * @link        http://community-auth.com
 */

require_once APPPATH . 'core/Auth_Controller.php';

class MY_Controller extends Auth_Controller
{
	/**
	 * Class constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

    public function _smart_render($view, $data = null, $returnhtml = false,$booking=false) {
        $this->viewdata = (empty($data)) ? $this->data : $data;
        if ($returnhtml) {
            $html= $this->load->view('_templates/_header', '', true);
            $html.= $this->load->view('_templates/_page_head', '', true);
            $html.= $this->load->view('_templates/_navigation', $this->viewdata, true);
            $html.= $this->load->view('_templates/_content_header', '', true);
            $html.= $this->load->view($view, $this->viewdata, $returnhtml);
            if($booking){
                $html.= $this->load->view('booking/booking_form', '', true);
            }
            $html.= $this->load->view('_templates/_content_footer', '', true);
            $html.= $this->load->view('_templates/_footer', '', true);
            $html.= $this->load->view('_templates/_footer_links', '', true);

            echo $html;
        }
        else {
            echo $this->load->view($view, $this->viewdata, true);
        }
    }

    function _render_page($view, $data = null, $returnhtml = false) {//I think this makes more sense
        $this->viewdata = (empty($data)) ? $data : $data;

        $html= $this->load->view('_templates/login_header', '', true);
        $html.= $this->load->view($view, $this->viewdata, true);
        $html.= $this->load->view('_templates/login_footer', '', true);
        echo $html;

        if ($returnhtml)
            echo $this->load->view($view, $this->viewdata, true); //This will return html on 3rd argument being true
    }

    function _render_setup($view, $data = null, $returnhtml = false) {//I think this makes more sense
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $html= $this->load->view('_templates/_header', '', true);
        $html.= $this->load->view('_templates/_page_head', '', true);
        $html.= $this->load->view('setup/_head_nav', $this->viewdata, true);
        $html.= $this->load->view($view, $this->viewdata, true);
        $html.= $this->load->view('setup/_footer', '', true);
        $html.= $this->load->view('_templates/_content_footer', '', true);
        $html.= $this->load->view('_templates/_footer', '', true);
        $html.= $this->load->view('_templates/_footer_links', '', true);
        echo $html;


    }

    function _render_setupfail($view, $data = null, $returnhtml = false) {//I think this makes more sense
        $this->viewdata = (empty($data)) ? $this->data : $data;

        $html= $this->load->view('_templates/_header', '', true);
        $html.= $this->load->view('_templates/_page_head', '', true);
        $html.= $this->load->view($view, $this->viewdata, true);
        $html.= $this->load->view('setup/_footer', '', true);
        $html.= $this->load->view('_templates/_content_footer', '', true);
        $html.= $this->load->view('_templates/_footer', '', true);
        $html.= $this->load->view('_templates/_footer_links', '', true);
        echo $html;


    }




}

/* End of file MY_Controller.php */
/* Location: /community_auth/core/MY_Controller.php */