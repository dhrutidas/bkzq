<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna
 * @date    16.08.2016
 *
**/

class Application extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('application_model');
        $this->load->model('role_model');

        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){
        $Data['groupArr'] = parent::menu();

	$app_count = $this->application_model->getallapplicationcount();
        $Data['page_title'] = "Manage Applications";
        $Data['load_page'] = "application/view_applications";
	
        $config['base_url'] = base_url('manage-applications');
        $config['total_rows'] = $app_count;
        $config['per_page'] = $app_count;
        $config["uri_segment"] = 2;
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
        $start=($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $this->pagination->initialize($config);
        $Data['applicationsArr'] = $this->application_model->getAllApplication($config['per_page'], $start);
        $Data['pagination'] = $this->pagination->create_links();
        $this->load->view("kernel", $Data);
    }
    
     public function addModal(){ $this->load->view("content/application/add_modal"); }
    
     public function submitApplication(){
        $this->form_validation->set_rules('inputAppName', 'App Name', 'required|trim');
        $this->form_validation->set_rules('inputAppPath', 'App Path', 'required|trim');
        $this->form_validation->set_rules('inputAppOrder', 'App Order', 'required|trim');

        if ($this->form_validation->run() == FALSE){

            //$errors = validation_errors();
            $array = array(
                'error'   => true,
                'app_error' => form_error('inputAppName'),
                'path_error' => form_error('inputAppPath'),
                'order_error' => form_error('inputAppOrder')
            );

            echo json_encode($array);

        }else{


            if ($this->form_validation->run() == TRUE ){
            
                $postArr['app_name'] = $this->input->post('inputAppName');
                $postArr['app_path'] = $this->input->post('inputAppPath');
                $postArr['app_order'] = $this->input->post('inputAppOrder');
    
                $this->session->set_flashdata('message', 'Success! New User has been added successfully.');
                echo json_encode(['success'=>'Form submitted successfully.']);
    
             
         }

        }
        
}

    public function editPrivilegeModal($rID){

        $Data['privilegeDetails'] = $this->application_model->getprivilegeDetails($rID);
        $Data['applicationDetails'] = $this->application_model->getApplicationDetails($rID);
        $Data['getAllRoles'] = $this->role_model->getAllRoles();
        $this->load->view("content/application/edit_privilege_modal", $Data);
    }

    public function editPrivilege(){
        
            $id1 = $this->input->post('id1');
            $rows = $this->input->post('rows');
            $roles = $this->input->post('roles');
            $allroles = $this->input->post('allroleids');
            $allroles = rtrim($allroles,'!~!');

            $allroleids = explode("!~!",$allroles);
            $roles = ltrim($roles , ',');
            $ex = explode(",",$roles);
            foreach ($allroleids as $key => $value)
            {

                if(in_array($value,$ex))
                {
                   $status = $this->application_model->updatePrivilege($id1,$value,'Y');
                }
                else
                {
                  $status = $this->application_model->updatePrivilege($id1,$value,'N');
                }
            }
     }
}