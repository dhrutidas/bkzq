<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/


class Menu
{
    private $CI;
    function Menu()
    {
        $this->CI = &get_instance();
    }
    function index()
    {
        //print_r($sData);
        $sData = $this->CI->session->userdata('user_details');
        $this->CI->load->model('menu_model');
        if ( empty($sData) )  // If no session found redirect to login page.
        {
            redirect( base_url() );
        }else{
            $Data['groupArr'] = $this->CI->menu_model->getAllApplication();
            $this->CI->load->view("templates/header", $Data);
        }

    }
}