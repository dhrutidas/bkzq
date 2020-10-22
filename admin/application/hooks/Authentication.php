<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * 
 * @author  Shrikant Mavlankar
 * @date    14.05.2015
 * 
**/

class Authentication {
    
    public function is_loogedIn(){
        
//        $CI = &get_instance();   
//        $this->load->library('session');
        
        $sData = $this->session->userdata('user_details');

        if( $sData == TRUE ):
            redirect( base_url('home') );
        else: 
            //Nothing
        endif;
    }
}