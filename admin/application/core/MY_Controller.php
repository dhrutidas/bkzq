<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 * 
 * @author  Krishna Gupta
 * @date    02.09.2015
 * 
 * Edited by Shrikant Mavlankar on 22.09.2015
**/

class MY_Controller extends CI_Controller {

    function __construct() { 
        
        parent::__construct(); 
        
        $this->load->model('menu_model'); 
        $this->sData = $this->session->userdata('user_details');
    }
    
    public function menu(){ return $this->menu_model->getAllApplication(); }
    
}