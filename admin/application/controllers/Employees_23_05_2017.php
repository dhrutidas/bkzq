<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    06.09.2016
 *
**/

class Employees extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('string');
        $this->load->helper('form');
        $this->load->library('pagination');
        $this->load->helper('url');
        $this->load->library('session');

        $this->load->model('employee_model');
        $this->load->model('role_model');
    }

    public function index(){

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Users";
        $Data['load_page'] = "employees/view_employees";

        //pagination start here
        $config['base_url'] = base_url('manage-users');
        $config['total_rows'] = $this->employee_model->getUserCount();
        $config['per_page'] = 10;
        $config["uri_segment"] = 2;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';   
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $Data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        //call the model function to get the data
        $Data['employeesArr'] = $this->employee_model->getAllUsers($config["per_page"], $Data['page']);
        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    public function addModal(){

        $Data['roleArr'] = $this->role_model->getAllActiveEmployeeRoles();

        $this->load->view("content/employees/add_employee_modal", $Data);
    }

    public function editModal($eID){

        $Data['roleArr'] = $this->role_model->getAllActiveEmployeeRoles();
        $Data['userDetail'] = $this->employee_model->getEmployeeDetails($eID);
        $this->load->view("content/employees/edit_employee_modal", $Data);
    }

    public function viewModal($eID){

        $Data['userDetail'] = $this->employee_model->getEmployeeDetails($eID);
        $this->load->view("content/employees/view_employee_modal", $Data);
    }

    public function addEmployee(){

        $status = 'Y';
        $this->form_validation->set_rules('inputFirstName', 'User First Name', 'required');
        $this->form_validation->set_rules('inputLastName', ' User Last Name', 'required');
        $this->form_validation->set_rules('inputEmail', 'User Email', 'required|trim');
        $this->form_validation->set_rules('inputContact', 'User Contact', 'required');
        $this->form_validation->set_rules('inputParentName', 'User\'s Parent Name', 'required');
        $this->form_validation->set_rules('inputAddress', 'User Address', 'required');
        $this->form_validation->set_rules('inputRole', 'User Role', 'required');
        $this->form_validation->set_rules('inputPassword', 'Password', 'trim|required|min_length[4]|max_length[25]');
        $this->form_validation->set_rules('inputConfirmPassword', 'Confirm Password', 'trim|required|min_length[4]|max_length[25]');

        if($this->input->post('inputPassword') != $this->input->post('inputConfirmPassword')){
            $this->session->set_flashdata('warning', 'Password and Confirm Password is not same.');
            $status = 'N';
        }
        if ( ($this->form_validation->run() == TRUE) && ($status == 'Y') ){
            if($this->employee_model->getEmployeeCountByEmailid($this->input->post('inputEmail')) > 0){
                $this->session->set_flashdata('warning', 'Email Id is already registered with us,try with another.');
            }else{
                $postArr['fName'] = $this->input->post('inputFirstName');
                $postArr['lName'] = $this->input->post('inputLastName');
                $postArr['contactNumber'] = $this->input->post('inputContact');
                $postArr['residenceAdd'] = $this->input->post('inputAddress');
                $postArr['emailID'] = $this->input->post('inputEmail');
                $postArr['password'] = $this->input->post('inputConfirmPassword');
                $postArr['roleID'] = $this->input->post('inputRole');
                $postArr['parentName'] = $this->input->post('inputParentName');
                $postArr['additionalInfo'] = $this->input->post('inputDesc');
                $postArr['status'] = "Y";
                $query = $this->employee_model->insertEmployee($postArr);
                $insertID = str_pad($query['insertID'], 8, '0', STR_PAD_LEFT);
                $postArr['userID'] = $insertID;
                $profile_pic_name = 'profile_pic_'.$insertID.'.jpg';

                if($query['status'])
                { 
                    if(!empty($_FILES['inputProfilePic']['name'])){

                        $config['upload_path']   = './assets/images/profile_pic/';
                        $config['allowed_types'] = 'jpeg|jpg|png'; 
                        $config['file_name']     = $profile_pic_name;
                        $config['overwrite']     = TRUE;
                        $config['max_size']      = 150; 
                        $config['max_width']     = 0; 
                        $config['max_height']    = 0;  
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( ! $this->upload->do_upload('inputProfilePic')) {
                            echo $error = array('error' => $this->upload->display_errors()); 
                            $postArr['profilPic'] = '';

                        }
                        else { 
                            $data = array('upload_data' => $this->upload->data());
                            $postArr['profilPic'] = $profile_pic_name;
                        }
                    }else{
                        $postArr['profilPic'] = '';
                    }

                    if($this->employee_model->updateEmployee($postArr))
                    {
                        $this->session->set_flashdata('message', 'Success! New User has been added successfully.');
                    }
                    else
                    {
                     $this->session->set_flashdata('warning', 'Success! New User has been added successfully But File has not been updaloaded.');
                 }
             }
             else
             {
                $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
            }
        }
    }
	else
	{
		$this->session->set_flashdata('warning', 'Mandatory field can not be left blank.');
	}

        redirect( base_url('manage-users') );
    }

    public function editEmployee(){

        $this->form_validation->set_rules('inputFirstName', 'User First Name', 'required');
        $this->form_validation->set_rules('inputLastName', ' User Last Name', 'required');
        $this->form_validation->set_rules('inputContact', 'User Contact', 'required');
        $this->form_validation->set_rules('inputParentName', 'User\'s Parent Name', 'required');
        $this->form_validation->set_rules('inputAddress', 'User Address', 'required');
        $this->form_validation->set_rules('inputRole', 'User Role', 'required');
        $this->form_validation->set_rules('inputUserStatus', 'User Status', 'required');        

        if ($this->form_validation->run() == TRUE ){

            $postArr['userID'] = $this->input->post('EID');
            $postArr['fName'] = $this->input->post('inputFirstName');
            $postArr['lName'] = $this->input->post('inputLastName');
            $postArr['contactNumber'] = $this->input->post('inputContact');
            $postArr['residenceAdd'] = $this->input->post('inputAddress');
            $postArr['roleID'] = $this->input->post('inputRole');
            $postArr['parentName'] = $this->input->post('inputParentName');
            $postArr['additionalInfo'] = $this->input->post('inputDesc');
            $postArr['status'] = $this->input->post('inputUserStatus');

            $profile_pic = $this->input->post('profile_pic');
            if(isset($profile_pic)){
                $picStatus = "Y";
            }else{
                $picStatus = "N";
            }

            if(!empty($_FILES['inputProfilePic']['name'])){
                $profile_pic_name = 'profile_pic_'.$postArr['userID'].'.jpg';
                $config['upload_path']   = './assets/images/profile_pic/';
                $config['allowed_types'] = 'jpeg|jpg|png'; 
                $config['file_name']     = $profile_pic_name;
                $config['overwrite']     = TRUE;
                $config['max_size']      = 150;
                $config['max_width']     = 0;
                $config['max_height']    = 0;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('inputProfilePic')) {
                    $error = array('error' => $this->upload->display_errors()); 
                    $postArr['profilPic'] = '';
                }
                else { 
                    $data = array('upload_data' => $this->upload->data());
                    $postArr['profilPic'] = $profile_pic_name;
                }
            }else if( $picStatus == "Y" ){
                $postArr['profilPic'] = $this->input->post('profile_pic');
            }else{
                $postArr['profilPic'] = '';
            }
            
            if($this->employee_model->updateEmployee($postArr))
            {
                
                $this->session->set_flashdata('message', 'Success! User Details has been updated successfully.');
            }
            else
            {
             $this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.');
         }
     }
    else
    {
        $this->upload->display_errors('<p>', '</p>');
        $this->session->set_flashdata('warning', 'Mandatory field can not be left blank.');
    }
    
    redirect( base_url('manage-users') );
    }

    public function getAlldetails(){

        $this->load->model('role_model');
        $this->load->model('branch_model');
        $this->load->model('department_model');

        $Data['roleArr'] = $this->role_model->getAllRoles();
        $Data['branchArr'] = $this->branch_model->getAllBranches();
        $Data['departmentArr'] = $this->department_model->getAllDepartments();

        return $Data;
    }
}