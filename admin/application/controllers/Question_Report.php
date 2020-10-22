<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    21.01.2017
 *
**/

class Question_Report extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('chapter_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){

      $Data['groupArr'] = parent::menu();

      $Data['page_title'] = "Question Report";
      $Data['load_page'] = "Question/report_question";

      $this->load->model('level_model');
      $this->load->model('board_model');
      $this->load->model('subject_model');
      $this->load->model('class_model');

      $Data['allLevel'] = $this->level_model->getAllActiveLevelForTag();
      $Data['allBoard'] = $this->board_model->getAllActiveBoards();
      $Data['allSubject'] = $this->subject_model->getAllActiveSubjectsForTags();
      $Data['allStd'] = $this->class_model->getAllActiveClass();
      $this->load->view("kernel", $Data);
    }
    function ajax_get_users(){
      $this->load->model('employee_model');
      $user_list=$this->employee_model->getAllUsersRestrictedRoleWise();
      $return = json_encode($user_list, TRUE);
      echo ($return);
    }
    function userQuestionSearch(){
      $postArr['userID'] = $this->input->post('userID');
      $postArr['level'] = $this->input->post('level');
      $postArr['board'] = $this->input->post('board');
      $postArr['subject'] = $this->input->post('subject');
      $postArr['standard'] = $this->input->post('standard');
      $postArr['status'] = $this->input->post('status');

      $this->load->model('Question_model');
      $questionList=$this->Question_model->searchQuestion($postArr);
      $return = json_encode($questionList, TRUE);
      echo ($return);
    }
}
