<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
  * @author  Krishna Gupta
 * @date    16.08.2016
 *
**/

class Schools extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('school_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Schools";
        $Data['load_page'] = "schools/view_schools";

        //pagination start here
        $config['base_url'] = base_url('manage-schools');

        $Data['schoolFilter'] = array(
            'schoolName' => 'Name',
            'schoolContactNumber' => 'Contact number',
            'schoolAdd' => 'Address',
            'emailID' => 'Email id'      
        );

        $searchDetails = $this->session->tempdata('search_details');
        
        $filter = $this->input->post('filter');
        
        if($this->input->post('field')){
            $field = $this->input->post('field');
        } else if(isset($searchDetails['field'])){
            $field = $searchDetails['field'];
        }else{
            $field = '';
        }  

        if($this->input->post('search')){
            $search = $this->input->post('search');
        } else if(isset($searchDetails['text'])){
            $search = $searchDetails['text'];
        }else{
            $search = '';
        }       

        if (!empty($search)) {
            $schools_count = $this->school_model->getSchoolsWhereLike($field, $search);
        } else {
            $schools_count = $this->school_model->getSchoolCount();
        }
        $searchDetais = array(
            'field'=>$field,
            'text'=>$search
        );
        $this->session->set_tempdata('search_details', $searchDetais);
        $this->session->mark_as_temp('search_details', 60*60*24);
        $Data['totalRows']=$schools_count;
        $config['total_rows'] = $schools_count;
        $config['per_page'] = $schools_count;
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
        if (!empty($search)) {
            $Data['schoolsArr'] = $this->school_model->getAllSchoolsWhereLike($config["per_page"], $Data['page'],$field, $search);
        } else {
            $Data['schoolsArr'] = $this->school_model->getAllSchools($config["per_page"], $Data['page']);
        }        

        $Data['pagination'] = $this->pagination->create_links();
        $Data['fieldSearched'] = $field;
        $Data['textSearched'] = $search;

        $this->load->view("kernel", $Data);
    }

    public function addModal(){ $this->load->view("content/schools/add_school_modal"); }

    public function editModal($rID){

        $Data['schoolDetails'] = $this->school_model->getSchoolDetails($rID);

        $this->load->view("content/schools/edit_school_modal", $Data);
    }

    public function addSchool(){

        $this->form_validation->set_rules('inputSchoolname', 'School Name', 'required');
        $this->form_validation->set_rules('inputSchoolPhone', 'School Phone', 'required');
        $this->form_validation->set_rules('inputSchoolAdd', 'School Phone', 'required');
        $this->form_validation->set_rules('inputSchoolEmail', 'School Phone', 'required');

        if ($this->form_validation->run() == FALSE){

            //$errors = validation_errors();
            $array = array(
                'error'   => true,
                'name_error' => form_error('inputSchoolname'),
                'phone_error' => form_error('inputSchoolPhone'),
                'add_error' => form_error('inputSchoolAdd'),
                'email_error' => form_error('inputSchoolEmail')
            );

            echo json_encode($array);

        }else{
            if ($this->form_validation->run() == TRUE ){

                $postArr['sname'] = $this->input->post('inputSchoolname');
                $postArr['sphone'] = $this->input->post('inputSchoolPhone');
                $postArr['sadd'] = $this->input->post('inputSchoolAdd');
                $postArr['semail'] = $this->input->post('inputSchoolEmail');
    
                if( $this->school_model->insertSchool($postArr))
                {
                    $this->session->set_flashdata('message', 'Success! New School has been added successfully.');
                }
            
            }
        }


        
    }

    public function editSchool(){

        $this->form_validation->set_rules('inputSchoolname', 'School Name', 'required');
        $this->form_validation->set_rules('inputSchoolPhone', 'School Phone', 'required');
        $this->form_validation->set_rules('inputSchoolAdd', 'School Phone', 'required');
        $this->form_validation->set_rules('inputSchoolEmail', 'School Phone', 'required');
        $this->form_validation->set_rules('inputSchoolstatus', 'School Status', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['sname'] = $this->input->post('inputSchoolname');
            $postArr['sphone'] = $this->input->post('inputSchoolPhone');
            $postArr['sadd'] = $this->input->post('inputSchoolAdd');
            $postArr['semail'] = $this->input->post('inputSchoolEmail');
            $postArr['sstatus'] = $this->input->post('inputSchoolstatus');
            $postArr['sid'] = $this->input->post('inputSID');

            if($this->school_model->updateSchool($postArr))
		{
	            $this->session->set_flashdata('message', 'Success! School Details has been updated successfully.');
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
	redirect( base_url('manage-schools') );
    }

    public function resetSchoolsFilter(){
        $this->session->unset_tempdata('search_details');
        redirect( base_url('manage-schools') );
    }
}
