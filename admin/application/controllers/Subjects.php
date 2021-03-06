<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Subjects extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('subject_model');
        $this->load->model('class_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){
        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Subjects";
        $Data['load_page'] = "subjects/view_subjects";

        //pagination start here
        $subject_count=  $this->subject_model->getSubjectCount();
        $config['base_url'] = base_url('manage-subjects');
        $config['total_rows'] = $subject_count;
        $config['per_page'] = $subject_count;
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
        $Data['subjectsArr'] = $this->subject_model->getAllSubjects($config["per_page"], $Data['page']);

        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    public function addModal(){ 
        $Data['allstandards']=$this->class_model->getAllActiveClasses();
        $this->load->view("content/subjects/add_subject_modal", $Data); 
    }

    public function editModal($sID){
        $Data['allstandards']=$this->class_model->getAllActiveClasses();
        $Data['subjectDetails'] = $this->subject_model->getSubjectDetails($sID);
        $this->load->view("content/subjects/edit_subject_modal", $Data);
    }

    public function addSubject(){
        $this->form_validation->set_rules('inputSubjectname', 'Subject Name', 'required');
        $this->form_validation->set_rules('inputSubjectdesc', 'Subject Description', 'required');
        $this->form_validation->set_rules('standards[]', 'Standards', 'required');
        if ($this->form_validation->run() == FALSE){
            
            //$errors = validation_errors();
            $array = array(
                'error'   => true,
                'name_error' => form_error('inputSubjectname'),
                'desc_error' => form_error('inputSubjectdesc'),
                'standards_error' => form_error('standards[]')
            );

            echo json_encode($array);

        }else{
            if ($this->form_validation->run() == TRUE ){

                $postArr['sname'] = $this->input->post('inputSubjectname');
                $postArr['sdescription'] = $this->input->post('inputSubjectdesc');
                $postArr['standards']=implode(',', $this->input->post('standards'));
    
                if( $this->subject_model->insertSubject($postArr))
                {
                        $this->session->set_flashdata('message', 'Success! New Subject has been added successfully.');
                }
                
            }
        }
        
    }

    public function editSubject(){

        $this->form_validation->set_rules('inputSubjectname', 'Subject Name', 'required');
        $this->form_validation->set_rules('inputSubjectdesc', 'Subject Description', 'required');
        $this->form_validation->set_rules('inputSID', 'Subject ID', 'required');
        $this->form_validation->set_rules('standards[]', 'Standard', 'required');
        $this->form_validation->set_rules('inputSubjectstatus', 'Subject Status', 'required');

        if ($this->form_validation->run() == TRUE ){
            $postArr['sid'] = $this->input->post('inputSID');
            $postArr['sname'] = $this->input->post('inputSubjectname');
            $postArr['sdescription'] = $this->input->post('inputSubjectdesc');
            $postArr['sstatus'] = $this->input->post('inputSubjectstatus');
            $postArr['standards'] =implode(',',$this->input->post('standards'));
            
            if($this->subject_model->updateSubject($postArr))
    		{
    	        $this->session->set_flashdata('message', 'Success! Subject Details has been updated successfully.');
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
	redirect( base_url('manage-subjects') );
    }
}