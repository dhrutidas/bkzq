<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    16.08.2016
 *
**/

class Roles extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('role_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){
        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Roles";
        $Data['load_page'] = "roles/view_roles";

        //pagination start here
        $config['base_url'] = base_url('manage-roles');
        $config['total_rows'] = $this->role_model->getRoleCount();
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
        $Data['rolesArr'] = $this->role_model->getAllRoles($config["per_page"], $Data['page']);

        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    public function addModal(){ $this->load->view("content/roles/add_role_modal"); }

    public function editModal($rID){

        $Data['roleDetails'] = $this->role_model->getRoleDetails($rID);

        $this->load->view("content/roles/edit_role_modal", $Data);
    }

    public function addRole(){

        $this->form_validation->set_rules('inputRolename', 'Role Name', 'required');
        $this->form_validation->set_rules('inputRoledesc', 'Role Description', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['rname'] = $this->input->post('inputRolename');
            $postArr['rdescription'] = $this->input->post('inputRoledesc');

			if( $this->role_model->insertRole($postArr))
			{
		            $this->session->set_flashdata('message', 'Success! New Role has been added successfully.');
			}
			else
			{
				$this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
			}
		
        }
	else
	{
		$this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
	}
	redirect( base_url('manage-roles') );
    }

    public function editRole(){

        $this->form_validation->set_rules('inputRolename', 'Role Name', 'required');
        $this->form_validation->set_rules('inputRoledesc', 'Role Description', 'required');
        $this->form_validation->set_rules('inputRolestatus', 'Role Status', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['rid'] = $this->input->post('inputRID');
            $postArr['rname'] = $this->input->post('inputRolename');
            $postArr['rdescription'] = $this->input->post('inputRoledesc');
            $postArr['rstatus'] = $this->input->post('inputRolestatus');

            if($this->role_model->updateRole($postArr))
    		{
    	            $this->session->set_flashdata('message', 'Success! Role Details has been updated successfully.');
    		}
    		else
    		{
    			$this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.');
    		}

        }
	else
	{
		$this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
	}
	redirect( base_url('manage-roles') );
    }
}
