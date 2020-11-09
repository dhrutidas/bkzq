<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }

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
    
    function studentLogin(){
        
        $sData = $this->session->userdata('user_details');

        if( $sData == TRUE ):
            redirect( base_url('home') );
        else:
            $this->processUserAuthenticationStudent(3);
        endif; 
    }

    function affiliateLogin(){
        
        $sData = $this->session->userdata('user_details');

        if( $sData == TRUE ):
            redirect( base_url('home') );
        else:
            $this->processUserAuthenticationStudent(7);
        endif; 
    }

    function superAdminLogin(){
       
        $sData = $this->session->userdata('user_details');

        if( $sData == TRUE ):
            redirect( base_url('home') );
        else:
            $this->processUserAuthenticationStudent(1);
        endif; 
    }
    
    function processUserAuthenticationStudent($roleId){

        $this->form_validation->set_rules('txt_username', 'Username', 'required|trim|xss_clean');
        $this->form_validation->set_rules('txt_password', 'Password', 'required');

        if( $this->form_validation->run() === TRUE ){

            $this->content['post_username'] = $this->input->post('txt_username');
            $this->content['post_pass'] = $this->input->post('txt_password');

            $return_val = $this->login_model->account_check_role($roleId);

            if( $return_val !== FALSE ){

                $this->login_model->updateLoginDetails($return_val['userID']);
                if($return_val['roleID']==3){
                  if($return_val['userPackageType'] == 'T'){
                    $expiryDate = date("Y-m-d",strtotime(date("Y-m-d", strtotime($return_val['createdAt'])) . " +3 day"));
                  }else {
                    $rawDataPackage= $this->login_model->account_package_activation($return_val['userID']);
                    $expiryDate = date("Y-m-d",strtotime(date("Y-m-d", strtotime($rawDataPackage['activatedOn'])) . " +1 year"));
                  }
                }
                else{
                  $expiryDate = date("Y-m-d",strtotime(date("Y-m-d") . " +1 year"));
                }
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
                                'expiryDate' => $expiryDate,
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
    
   function processUserAuthentication(){

        $roleIds = [4,5,8];
        $this->form_validation->set_rules('txt_username', 'Username', 'required|trim|xss_clean');
        $this->form_validation->set_rules('txt_password', 'Password', 'required');

        if( $this->form_validation->run() === TRUE ){

            $this->content['post_username'] = $this->input->post('txt_username');
            $this->content['post_pass'] = $this->input->post('txt_password');

            $return_val = $this->login_model->account_check_admin_manager($roleIds);

            if( $return_val !== FALSE ){

                $this->login_model->updateLoginDetails($return_val['userID']);
                if($return_val['roleID']==3){
                  if($return_val['userPackageType'] == 'T'){
                    $expiryDate = date("Y-m-d",strtotime(date("Y-m-d", strtotime($return_val['createdAt'])) . " +3 day"));
                  }else {
                    $rawDataPackage= $this->login_model->account_package_activation($return_val['userID']);
                    $expiryDate = date("Y-m-d",strtotime(date("Y-m-d", strtotime($rawDataPackage['activatedOn'])) . " +1 year"));
                  }
                }
                else{
                  $expiryDate = date("Y-m-d",strtotime(date("Y-m-d") . " +1 year"));
                }
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
                                'expiryDate' => $expiryDate,
                                'logged_in' => true );

                $this->session->set_userdata('user_details', $sArray);
                if($return_val['roleID'] == 1){
                    redirect( base_url('home') );
                }
                else if($return_val['roleID'] == 4){
                    redirect(base_url('qm') );
                }
                else if($return_val['roleID'] == 5){
                    redirect(base_url('qc') );
                }
                else{
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

        $sData = $this->session->userdata('user_details');
        $role_id = $sData['role_id'];
        $this->session->unset_userdata('user_details');
        $this->session->sess_destroy();
        if($role_id == 1)
        {
            redirect( base_url('admin-login'));
        }
            
        elseif($role_id == 3)
        {
            redirect( base_url('student-login'));
        }
           
        elseif($role_id == 7)
        {
           
            redirect( base_url('affiliate-login'));
        }
          
        elseif($role_id == 2 || $role_id == 8)
        {
            redirect( base_url());
        }
            
        else
        {
            redirect( base_url()); 
        }
    }
}
