<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    21.08.2016
 *
**/

class Change_password extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->library('session');
        $this->load->helper('security');

        // $config = Array(
        // 'protocol' => 'smtp',
        // 'smtp_host' => 'ssl://smtp.gmail.com',
        // 'smtp_port' => '465',
        // 'smtp_user' => 'krishna.gupta.kkg@gmail.com',
        // 'smtp_pass' => 'cilcc@3103'
        // );
        // $this->load->library('email', $config);

        $this->load->library('email');
        $this->load->model('change_password_model');
    }

    public function index(){

        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "Change password";
        $Data['load_page'] = "change_passwords/change_password";
        $this->load->view("kernel", $Data);
    }

    public function processUserAuthentication(){

        $sData = $this->session->userdata('user_details');

        $this->form_validation->set_rules('inputOldPassword', 'Old Password', 'trim|required|trim|xss_clean');
        $this->form_validation->set_rules('inputNewPassword', 'New Password', 'trim|required|trim|xss_clean|min_length[6]|max_length[32]');
        $this->form_validation->set_rules('inputNewConfirmPassword', 'Confirm Password', 'trim|required|trim|xss_clean|min_length[6]|max_length[32]');

        if ($this->form_validation->run() == TRUE ){

            $postArr['oldPassword'] = $this->input->post('inputOldPassword');
            $postArr['newPassword'] = $this->input->post('inputNewPassword');
            $postArr['confirmPassword'] = $this->input->post('inputNewConfirmPassword');

            if($postArr['newPassword'] != $postArr['oldPassword']){

                if($postArr['newPassword'] == $postArr['confirmPassword']){
                    
                    if( $this->change_password_model->account_check($postArr) == TRUE)
                    {
                        if( $this->change_password_model->updatePassword($postArr) == TRUE)
                        {   
                            $this->session->set_flashdata('message', 'Success! password has been changed successfully.');
                            
                            $this->email->from('cantreply@youdomain.com', 'Your name');
                            $this->email->to($sData['email_id']);     
                            $this->email->subject('Password reset');
                            $this->email->message('Your password has been changed successfully.'); 

                            $this->email->send();

                        }else{
                            $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
                        }
                    }else{
                        $this->session->set_flashdata('warning', 'Old password has not match with existing password.');
                    }
                }else{
                    $this->session->set_flashdata('warning', 'New password and Confirm password must be same.');
                }
            }else{
                $this->session->set_flashdata('warning', 'Old password and New password should not be same.');
            }    
        }else{
		    $this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
	    }

	   redirect( base_url('change-password') );
    }

}
