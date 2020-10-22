<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    20.08.2016
 *
**/

class Forgotpassword extends CI_Controller{

    function __construct() {
        parent::__construct(); 
        $this->load->model('forgotpassword_model'); 
        $this->load->helper('url');
        $this->load->helper('string');
        $this->load->helper('form');
        $this->load->helper('security');

        $this->load->library('email');
    }

    function index(){

        $sData = $this->session->userdata('user_details');
        if( $sData == TRUE ):
            redirect( base_url('home') );
            //redirect( base_url('forgot-password') );
        else:
            $this->processUserAuthentication();
        endif;
    }

    function processUserAuthentication(){

        $this->form_validation->set_rules('txt_username', 'Username', 'required|trim|xss_clean');

        if( $this->form_validation->run() === TRUE ){

            $this->content['post_username'] = $this->input->post('txt_username');

            $return_val = $this->forgotpassword_model->account_check();

            if( $return_val !== FALSE ){

                date_default_timezone_set('GMT');
                $password = random_string('alnum', 8);    
                if($this->forgotpassword_model->updateLoginDetails($return_val['emailID'],$password)){

                    $from_email = "info@bkzquiz.com"; 
                    $to_email = $return_val['emailID'];
                    $this->email->set_mailtype("html");
                    $this->email->from($from_email, 'BKZ Admin'); 
                    $this->email->to($to_email);
                    $this->email->subject('Forgot Password'); 
                    $this->email->message('Dear '.$return_val['fName'].',<br/>You have requested the new password, Here is your new password:'. $password.'<br/>');
               
                    //Send mail 
                    if($this->email->send()) {
                        $Data['email_success'] = 'Success! Your Password has been sent on your registered email ID.';
                    }else {
                        $Data['email_fail'] = 'Warning! Error in sending Email.';
                    }
                }else{
                    $Data['db_err'] = "Connection Error, Please try again !";
                }
            }
            else{
       		    $Data['err'] = "User Not found";
            }
        }

        $Data['page_title'] = "Forgot Password";
        $Data['load_page'] = "forgotpassword/index";
        $this->load->view("kernel", $Data);
    }
}
