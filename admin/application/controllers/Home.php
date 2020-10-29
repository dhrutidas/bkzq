<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * @author  Krishna Gupta
 * @date    03.09.2016
 **/
class Home extends MY_Controller {

    var $EARLY = 0;
    var $ON_TIME = 0;
    var $LATE = 0;

    public function __construct() {

        parent::__construct();
        $this->load->model('home_model');
    }

    public function index() {

        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "Welcome";

        $sData = $this->session->userdata('user_details');
        $role_id = $sData['role_id'];
        $this->load->model('student_model');

        if($role_id == 1): //this is for Admin
         $this->load->model('student_model');
         $this->load->model('employee_model');
        // $Data['allLevel'] = $this->level_model->getAllActiveLevel();
        // $Data['allsubject'] = $this->subject_model->getAllActiveSubjects();
        $Data['allUser'] = $this->home_model->getAllCount();
        $Data['allStudent'] = $this->student_model->getUserCount();
        $Data['allStudentLoggedIn'] = $this->student_model->getUserCountLoggedInToday();
        $Data['allExecutive'] = $this->employee_model->getUserCount();
        $Data['load_page'] = "home/home_page";

        elseif($role_id == 2): //this is for Executive
            $this->load->model('question_model');
            $Data['withImageQuestion'] = $this->question_model->getImageQuestionCount();
            $Data['allQuestionCount'] = $this->question_model->getQuestionCount();
            $Data['dayWiseQuestionCount'] = $this->home_model->dayWiseQuestionCount();
            $Data['load_page'] = "home/home_page_executive";

        elseif($role_id == 3): //This is for Students
            $this->load->model('subject_model');
            $this->load->model('level_model');
            $Data['subject_drop']=$this->subject_model->getAllActiveSubjectsForQuiz();
            $Data['level_drop']=$this->level_model->levelForUser();
            $Data['load_page'] = "home/home_page_student";

        elseif($role_id == 4): //This is for QA
          $Data['groupArr'] = parent::menu();
          $Data['page_title'] = "QA";
          $this->load->model('employee_model');
          $Data['user_list']=$this->employee_model->getAllEmployees();
          $Data['load_page'] = "home/qa";
    
        elseif($role_id == 5): //This is for QA
          $Data['groupArr'] = parent::menu();
          $Data['page_title'] = "QA";
          $this->load->model('employee_model');
          $Data['user_list']=$this->employee_model->getAllEmployees();
          $Data['load_page'] = "home/qa";

        elseif($role_id == 7): //This is for Affiliate	
          $this->load->model('affiliate_code_model');	
          $this->load->library('encryption');		
          $Data['groupArr'] = parent::menu();		
          $Data['page_title'] = "Affiliate User";
          $Data['code'] = $this->affiliate_code_model->getCode($sData['user_id']);	
          $this->load->model('employee_model');		
          $Data['user_list']=$this->employee_model->getAllEmployees();		
          $Data['load_page'] = "home/home_affiliate";		
              
        endif;

        $this->load->view("kernel", $Data);
    }
    function graphData(){
      $this->load->model('level_model');
      $lDetails['subjectID']=$this->input->post('subjectID');
      $lDetails['levelID']=$this->input->post('levelID');
      $DataGraph=$this->level_model->LoadGraphData($lDetails);
      $return = json_encode($DataGraph, TRUE);
      echo ($return);
    }
    function qa(){
      $Data['groupArr'] = parent::menu();
      $Data['page_title'] = "QA";
      $this->load->model('employee_model');
      $Data['user_list']=$this->employee_model->getAllUsers();
      $Data['load_page'] = "home/qa";
      $this->load->view("kernel", $Data);
    }
    function ajaxAdminReportGraph(){
      $dateMonth=$this->input->post('datemonth');
      $this->load->model('home_model');
      $user_list  = $this->home_model->getAllCountAdminReportGraph($dateMonth);
      //print_r($user_list);die();
      $tableRow='';
        for($i = 1; $i<= date("t", strtotime('01/'.$dateMonth)); $i++ ) {
          $userCount = 0;
          foreach ($user_list as $value) {
            if( $value['createdDay'] == $i ){
              $userCount = $value['cnt'];
            }
          }
          $tableRow.= '<tr><th>'.$i.'</th><td>'.$userCount.'</td></tr>';
        }
        echo $tableRow;
    }

}
