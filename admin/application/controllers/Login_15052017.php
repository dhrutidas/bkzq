<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Login extends CI_Controller{

    function __construct() { 
        parent::__construct(); 
        $this->load->model('login_model'); 
        $this->load->helper('security');
    }

    function index(){

        $sData = $this->session->userdata('user_details');

        if( $sData == TRUE ):
            redirect( base_url('home') );
        else:
            $this->processUserAuthentication();
        endif;
    }

    function processUserAuthentication(){

        $this->form_validation->set_rules('txt_username', 'Username', 'required|trim|xss_clean');
        $this->form_validation->set_rules('txt_password', 'Password', 'required');

        if( $this->form_validation->run() === TRUE ){

            $this->content['post_username'] = $this->input->post('txt_username');
            $this->content['post_pass'] = $this->input->post('txt_password');

            $return_val = $this->login_model->account_check();

            if( $return_val !== FALSE ){

                $this->login_model->updateLoginDetails($return_val['userID']);

                $sArray = array('user_id' => $return_val['userID'],
                                'role_id' => $return_val['roleID'],
                                'school_id' => $return_val['schoolID'],
                                'board_id' => $return_val['boardID'],
                                'std_id' => $return_val['stdID'],
                                'email_id' => $return_val['emailID'],
                                'user_type' => $return_val['userPackageType'],
                                'profile_pic' => $return_val['profilPic'],
                                'user_first_name' => ucwords($return_val['fName']),
                                'user_last_name' => ucwords($return_val['lName']),
                                'user_login_ip' => $return_val['lastLoginIp'],
                                'user_login_time' => $return_val['lastLoginTime'],
                                'logged_in' => true );

                $this->session->set_userdata('user_details', $sArray);
                if($return_val['roleID'] == 1){
                    redirect( base_url('home') );
                }else{
                    redirect( base_url('home') );
                }
            }
            else{
       		$Data['err'] = "User Not found";
            }
        }

        $Data['page_title'] = "Login";
        $Data['load_page'] = "login/sign_in";
        $this->load->view("kernel", $Data);
    }

    function logout(){

        $this->session->unset_userdata('user_details');
        $this->session->sess_destroy();
        redirect( base_url() );
    }
}
