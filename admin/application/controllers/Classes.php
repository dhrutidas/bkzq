<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 * 
 * @author  Krishna Gupta
 * @date    13.08.2016
 * 
**/

class Classes extends MY_Controller {

    public function __construct() { 
        
        parent::__construct(); 
        $this->load->model('class_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }
    
    public function index(){
        
        $Data['groupArr'] = parent::menu();
        
        $Data['page_title'] = "Manage Classes";
        $Data['load_page'] = "classes/view_classes";

        //pagination start here
        $class_count = $this->class_model->getClassCount();
        $config['base_url'] = base_url('manage-classes');
        $config['total_rows'] = $class_count;
        $config['per_page'] = $class_count;
        $config["uri_segment"] = 2;
        $choice = $config["total_rows"] / $class_count ;
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
        $Data['classesArr'] = $this->class_model->getAllClasses($config["per_page"], $Data['page']);

        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }
    
    public function addModal(){ $this->load->view("content/classes/add_class_modal"); }
    
    public function editModal($bID){
        $Data['classDetails'] = $this->class_model->getClassDetails($bID);
        $this->load->view("content/classes/edit_class_modal", $Data);         
    }
    
    public function viewModal($bID){
        $Data['classDetails'] = $this->class_model->getClassDetails($bID);
        $this->load->view("content/classes/view_class_modal", $Data);         
    }
    
    public function addClass(){ 
                
        $this->form_validation->set_rules('inputClassName', 'Class Name', 'required');
        $this->form_validation->set_rules('inputClassDesc', 'Class Description', 'required');

        if ($this->form_validation->run() == TRUE ){
            
            $postArr['bname'] = $this->input->post('inputClassName');
            $postArr['bdesc'] = $this->input->post('inputClassDesc');

			if($this->class_model->insertClass($postArr))
			{
				$this->session->set_flashdata('message', 'Success! New Class has been added successfully.');
			}
			else
			{
				$this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
			}
		  
		  redirect( base_url('manage-classes') );
        }
	else
	{
		$this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
		redirect( base_url('manage-classes') );
	}
}
    
    public function editClass(){ 

            $this->form_validation->set_rules('inputClassName', 'Class Name', 'required');
            $this->form_validation->set_rules('inputClassDesc', 'Class Description', 'required');
            $this->form_validation->set_rules('inputClassstatus', 'Class Stauts', 'required');        

            if ($this->form_validation->run() == TRUE ){
                
                $postArr['bid'] = $this->input->post('inputBid');
                $postArr['bname'] = $this->input->post('inputClassName');
                $postArr['bdesc'] = $this->input->post('inputClassDesc');
                $postArr['bstatus'] = $this->input->post('inputClassstatus');

    		if($this->class_model->updateClass($postArr))
    		{
    			$this->session->set_flashdata('message', 'Success! Class Details has been updated successfully.');
    		}
    		else
    		{
    			$this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.');
    		}
    	    
    	    redirect( base_url('manage-classes') );
    	}
    	else
    	{
    		$this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
    		redirect( base_url('manage-classes') );
    	}
    }
}
