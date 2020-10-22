<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    21.01.2017
 *
**/

class Testimonial extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('testimonial_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }
    public function index(){
        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "Manage Testimonial";
        $Data['load_page'] = "testimonial/view_testimonial";
        $Data['chaptersArr'] = $this->testimonial_model->getAllTestimonial();
        $this->load->view("kernel", $Data);
    }
    public function addModal(){
        $this->load->view("content/testimonial/add_testimonial_modal");
    }

    public function editModal($sID){
        $Data['testimonialDetails'] = $this->testimonial_model->getTestimonialDetails($sID);
        $this->load->view("content/testimonial/edit_testimonial_modal", $Data);
    }
    public function addTestimonial(){
        $this->form_validation->set_rules('inputTestimonialName', ' Name', 'required');
        $this->form_validation->set_rules('inputTestimonialMsg', ' Message', 'required');
        if ($this->form_validation->run() == TRUE ){
          $postArr['tName'] = $this->input->post('inputTestimonialName');
          $postArr['tMsg'] = $this->input->post('inputTestimonialMsg');

    			if( $this->testimonial_model->insertTestimonial($postArr))
    			{
    		        $this->session->set_flashdata('message', 'Success! New Testimonial has been added successfully.');
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
	   redirect( base_url('testimonial') );
    }

    public function editTestimonial(){
        $this->form_validation->set_rules('inputTestimonialName', 'Chapter Name', 'required');
        $this->form_validation->set_rules('inputTestimonialMsg', 'Chapter Description', 'required');
        $this->form_validation->set_rules('inputTID', 'Chapter ID', 'required');
        $this->form_validation->set_rules('inputTestimonialStatus', 'Chapter Status', 'required');
        if ($this->form_validation->run() == TRUE ){
            $postArr['tid'] = $this->input->post('inputTID');
            $postArr['tName'] = $this->input->post('inputTestimonialName');
            $postArr['tMsg'] = $this->input->post('inputTestimonialMsg');
            $postArr['tStatus'] = $this->input->post('inputTestimonialStatus');
            if($this->testimonial_model->updateTestimonial($postArr)){
        	        $this->session->set_flashdata('message', 'Success! Chapter Details has been updated successfully.');
        		}
        		else{
        			$this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.');
        		}

        }
    	else{
    		$this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
    	}
  	    redirect( base_url('testimonial') );
      }
     function allTestimonial(){
        $testimonialData = $this->testimonial_model->getAllActiveTestimonial();
        //print_r($subjectData);
        $return = json_encode($testimonialData, TRUE);
        echo ($return);
    }
}
