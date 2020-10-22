<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    21.01.2017
 *
**/

class Chapters extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('chapter_model');
        $this->load->model('subject_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Chapters";
        $Data['load_page'] = "chapters/view_chapters";

        $Data['captersFilter'] = array(
            'chapterName' => 'Name',
            'chapterDesc' => 'Desc',
            'subjectID' => 'Subject'     
        );

        $Data['allSubjects'] = $this->subject_model->getAllSubjects(100,0);        

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
            $chapters_count = $this->chapter_model->getChaptersWhereLike($field, $search);
        } else {
            $chapters_count = $this->chapter_model->getChapterCount();
        }
        $searchDetais = array(
            'field'=>$field,
            'text'=>$search
        );
        
        $this->session->set_tempdata('search_details', $searchDetais);
        $this->session->mark_as_temp('search_details', 60*60*24);
        $Data['totalRows']=$chapters_count;

        //pagination start here
        $config['base_url'] = base_url('manage-chapters');
        $config['total_rows'] = $chapters_count;
        $config['per_page'] =  $chapters_count;
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
            $Data['chaptersArr'] = $this->chapter_model->getAllChaptersWhereLike($config["per_page"], $Data['page'],$field, $search);
        } else {
            $Data['chaptersArr'] = $this->chapter_model->getAllChapters($config["per_page"], $Data['page']);
        }        

        $Data['pagination'] = $this->pagination->create_links();

        $Data['fieldSearched'] = $field;
        $Data['textSearched'] = $search;
        $this->load->view("kernel", $Data);
    }

    public function addModal(){ 
        $this->load->model('subject_model');
        $Data['subjectDetails'] = $this->subject_model->getAllActiveSubjects();

        $this->load->view("content/chapters/add_chapter_modal",$Data); 
    }

    public function editModal($sID){
        $this->load->model('subject_model');
        $Data['subjectDetails'] = $this->subject_model->getAllActiveSubjects();

        $Data['chapterDetails'] = $this->chapter_model->getChapterDetails($sID);
        $this->load->view("content/chapters/edit_chapter_modal", $Data);
    }

    public function addChapter(){

        $this->form_validation->set_rules('inputChaptername', 'Chapter Name', 'required');
        $this->form_validation->set_rules('inputChapterdesc', 'Chapter Description', 'required');
        $this->form_validation->set_rules('inputSubject', 'Subject Name', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['cname'] = $this->input->post('inputChaptername');
            $postArr['cdescription'] = $this->input->post('inputChapterdesc');
            $postArr['csubjectid'] = $this->input->post('inputSubject');

			if( $this->chapter_model->insertChapter($postArr))
			{
		        $this->session->set_flashdata('message', 'Success! New Chapter has been added successfully.');
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
	redirect( base_url('manage-chapters') );
    }

    public function editChapter(){

        $this->form_validation->set_rules('inputChaptername', 'Chapter Name', 'required');
        $this->form_validation->set_rules('inputChapterdesc', 'Chapter Description', 'required');
        $this->form_validation->set_rules('inputCID', 'Chapter ID', 'required');
        $this->form_validation->set_rules('inputChapterstatus', 'Chapter Status', 'required');
        $this->form_validation->set_rules('inputSubject', 'Subject Name', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['cid'] = $this->input->post('inputCID');
            $postArr['cname'] = $this->input->post('inputChaptername');
            $postArr['cdescription'] = $this->input->post('inputChapterdesc');
            $postArr['cstatus'] = $this->input->post('inputChapterstatus');
            $postArr['csubjectid'] = $this->input->post('inputSubject');
            
            if($this->chapter_model->updateChapter($postArr))
    		{
    	        $this->session->set_flashdata('message', 'Success! Chapter Details has been updated successfully.');
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
	redirect( base_url('manage-chapters') );
    }

    public function ajax_get_chapter_subject(){
        $inputMainSubject = $this->input->post('subjectid');
        //echo $inputMainSubject; die;
        $subjectData = $this->chapter_model->getAllActiveChaptersSubjectwise($inputMainSubject);
        //print_r($subjectData);
        $return = json_encode($subjectData, TRUE);
        echo ($return);
    }

    public function resetChaptersFilter(){
        $this->session->unset_tempdata('search_details');
        redirect( base_url('manage-chapters') );
    }

    public function viewChapterQuestions(){
        $this->load->helper('text');
        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "Manage Chapters";
        $Data['load_page'] = "chapters/view_chapters_questions";
        $Data['allChapters'] = $this->chapter_model->getAllActiveChapters();
        $chapterid = $this->input->post('chapterID');       
        if($chapterid >0){
            $Data['questionsData'] = $this->chapter_model->getAllChapterQuestions($chapterid);            
        }        
        $Data['chapterID'] = $chapterid;
        $this->load->view("kernel", $Data);    
    }

    public function ajax_get_answer(){
        $question = $this->input->post('questionID');
        $answerData = $this->chapter_model->getAnwsers($question); 
        echo json_encode($answerData);
    }
}