<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Stages extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('stage_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){
        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Stages";
        $Data['load_page'] = "stages/view_stages";


        
        //pagination start here
        $stage_count = $this->stage_model->getStageCount();
        $config['base_url'] = base_url('manage-stages');
        $config['total_rows'] = $stage_count;
        $config['per_page'] = $stage_count;
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
        $Data['stagesArr'] = $this->stage_model->getAllStages($config["per_page"], $Data['page']);

        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    public function addModal(){ 

        $this->load->model('level_model');
        $Data['levelDetails'] = $this->level_model->getAllActiveLevel();
        $this->load->view("content/stages/add_stage_modal", $Data); 
    }

    public function ajaxStage(){ 
        $level = $this->input->post('level');
        $Data['stageDetails'] = $this->stage_model->getAllActiveStages($level);
        $option_data = "<option value=''>----Select----</option>";
        foreach ($Data['stageDetails'] as $key_val => $data_val) {
            $stageID = $data_val['stageID'];
            $stageName = $data_val['stageName'];
            $option_data .= '<option value="'.$stageID.'">'.$stageName.'</option>';
        }
        echo $option_data;
    }

    public function editModal($sID){

        $this->load->model('level_model');
        $Data['levelDetails'] = $this->level_model->getAllActiveLevel();
        $Data['stageDetails'] = $this->stage_model->getStageDetails($sID);

        $this->load->view("content/stages/edit_stage_modal", $Data);
    }

    public function addStage(){

        $this->form_validation->set_rules('inputStagename', 'Stage Name', 'required');
        $this->form_validation->set_rules('inputStagedesc', 'Stage Description', 'required');
        $this->form_validation->set_rules('inputLevel', 'Level Name', 'required');
        $this->form_validation->set_rules('inputMaxQuestion', 'Max. Question', 'required');
        $this->form_validation->set_rules('inputMaxQuesAllowed', 'Max. Question Allowed', 'required');
        $this->form_validation->set_rules('inputMinPass', 'Min. Passing Marks', 'required');
        $this->form_validation->set_rules('inpuStageOrder', 'Stage Order', 'required|trim');

        if ($this->form_validation->run() == TRUE ){

            $postArr['sname'] = $this->input->post('inputStagename');
            $postArr['sdescription'] = $this->input->post('inputStagedesc');
            $postArr['slevel'] = $this->input->post('inputLevel');
            $postArr['smax'] = $this->input->post('inputMaxQuestion');
            $postArr['smaxallow'] = $this->input->post('inputMaxQuesAllowed');
            $postArr['sminpass'] = $this->input->post('inputMinPass');
            $postArr['sorder'] = $this->input->post('inpuStageOrder');
            
			if( $this->stage_model->insertStage($postArr))
			{
		            $this->session->set_flashdata('message', 'Success! New Stage has been added successfully.');
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
	redirect( base_url('manage-stages') );
    }

    public function editStage(){

        $this->form_validation->set_rules('inputStagename', 'Stage Name', 'required');
        $this->form_validation->set_rules('inputStagedesc', 'Stage Description', 'required');
        $this->form_validation->set_rules('inputLevel', 'Level Name', 'required');
        $this->form_validation->set_rules('inputMaxQuestion', 'Max. Question', 'required');
        $this->form_validation->set_rules('inputMaxQuesAllowed', 'Max. Question Allowed', 'required');
        $this->form_validation->set_rules('inputMinPass', 'Min. Passing Marks', 'required');
        $this->form_validation->set_rules('inputStagestatus', 'Stage Status', 'required');
        $this->form_validation->set_rules('inputSID', 'Stage ID', 'required');
        $this->form_validation->set_rules('inpuStageOrder', 'Stage Order', 'required|trim');

        if ($this->form_validation->run() == TRUE ){

            $postArr['sid'] = $this->input->post('inputSID');
            $postArr['sname'] = $this->input->post('inputStagename');
            $postArr['sdescription'] = $this->input->post('inputStagedesc');
            $postArr['slevel'] = $this->input->post('inputLevel');
            $postArr['smax'] = $this->input->post('inputMaxQuestion');
            $postArr['smaxallow'] = $this->input->post('inputMaxQuesAllowed');
            $postArr['sminpass'] = $this->input->post('inputMinPass');
            $postArr['sorder'] = $this->input->post('inpuStageOrder');
            $postArr['sstatus'] = $this->input->post('inputStagestatus');
            
            if($this->stage_model->updateStage($postArr))
    		{
    	        $this->session->set_flashdata('message', 'Success! Stage Details has been updated successfully.');
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
	redirect( base_url('manage-stages') );
    }
}