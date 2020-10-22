<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * @author  Krishna Gupta
 * @date    03.03.2017
 *
 * */
class Evaluation extends MY_Controller {

    var $EARLY = 0;
    var $ON_TIME = 0;
    var $LATE = 0;

    public function __construct() {

        parent::__construct();
        $this->load->library('session');
        $this->load->model('evaluation_model');

        $this->load->model('student_model');
        $this->load->model('subject_model');
        $this->load->model('level_model');
        $this->load->model('chapter_model');
    }

    public function index() {

        $Data['groupArr'] = parent::menu();

        $sData = $this->session->userdata('user_details');
        $userID = $sData['user_id'];
        $roleID = $sData['role_id'];
        $stages_check = FALSE;
        if ($roleID == 3) {
            $userArr = array();
            array_push($userArr, $this->student_model->getStudentDetails($userID));
            $Data['allstudents'] = $userArr;
            $Data['allsubject'] = $this->subject_model->getAllActiveSubjectsForQuiz();
            $stage_count_check = $this->evaluation_model->stage_count_check($userID);
            if( $stage_count_check[0]['chapter_cnt'] >=1 ){
                $stages_check = TRUE;
            }
        }else{
            $Data['allstudents'] = $this->student_model->getAllStudents();
            $Data['allsubject'] = $this->subject_model->getAllActiveSubjects();
            $stages_check = TRUE;
        }
        $subject = $this->input->post('inputSubject');
        if(isset($subject)){
            $Data['allChapter'] = $this->evaluation_model->getAllActiveChaptersSubjectwise($subject);
        }
        if($stages_check === TRUE){

            $Data['stage_status'] = 'Y';
            //$Data['allChapter'] = $this->chapter_model->getAllActiveChapters();
            $Data['allLevel'] = $this->level_model->getAllActiveLevel();

            $this->form_validation->set_rules('inputStudent', 'Student', 'required|trim');
            $this->form_validation->set_rules('inputSubject', 'Supbect', 'required|trim');
            $this->form_validation->set_rules('inputChapter', 'Chapter', 'required|trim');
            $this->form_validation->set_rules('from_date', 'From Date', 'required|trim');
            $this->form_validation->set_rules('to_date', 'To Date', 'required|trim');

            if( $this->form_validation->run() === TRUE ){

                $student = $this->input->post('inputStudent');
                $subject = $this->input->post('inputSubject');
                $chapter = $this->input->post('inputChapter');
                $from_date = $this->input->post('from_date');
                $to_date = $this->input->post('to_date');

                $very_poor = 20;
                $very_poor_value = $this->evaluation_model->very_poor_count($student,$subject,$chapter,$from_date, $to_date);
                $very_poor_per = $very_poor_value*$very_poor/100;
                $Data['very_poor_value']  = $very_poor_value;
                $Data['very_poor_per']  = round($very_poor_per,2);

                $poor = 30;
                $poor_value = $this->evaluation_model->poor_count($student,$subject,$chapter,$from_date, $to_date);
                $poor_per = $poor_value*$poor/100;
                $Data['poor_value']  = $poor_value;
                $Data['poor_per']  = round($poor_per,2);

                $good = 20;
                $good_value = $this->evaluation_model->good_count($student,$subject,$chapter,$from_date, $to_date);
                $good_per = $good_value*$good/100;
                $Data['good_value']  = $good_value;
                $Data['good_per']  = round($good_per,2);

                $satisfaction = 5;
                $satisfaction_value = $very_poor_value + $good_value;
                $satisfaction_per = $satisfaction_value*$satisfaction/100;
                $Data['satisfaction_value']  = $satisfaction_value;
                $Data['satisfaction_per']  = round($satisfaction_per,2);

                $very_good = 5;
                $very_good_value = $this->evaluation_model->very_good_count($student,$subject,$chapter,$from_date, $to_date);
                $very_good_per = $very_good_value*$very_good/100;
                $Data['very_good_value']  = $very_good_value;
                $Data['very_good_per']  = round($very_good_per,2);

                $excellent = 10;
                $excellent_value = $this->evaluation_model->excellent_count($student,$subject,$chapter,$from_date, $to_date);
                $excellent_value = $excellent_value[0]['chapter_cnt'];
                $excellent_per = $excellent_value*$excellent/100;
                $Data['excellent_value']  = $excellent_value;
                $Data['excellent_per']  = round($excellent_per,2);

                $best = 10;
                $best_value = $this->evaluation_model->best_count($student,$subject,$chapter,$from_date, $to_date);
                $best_value = $best_value[0]['chapter_cnt'] + $excellent_value;
                $best_per = $best_value*$best/100;
                $Data['best_value']  = $best_value;
                $Data['best_per']  = round($best_per,2);

            }
        }else{
            $this->session->set_flashdata('warning', 'It seems you are not yet clear stage five. Please play Quiz.');
            $Data['stage_status'] = 'N';
        }

        $Data['page_title'] = "Evaluation";
        $Data['load_page'] = "evaluation/index";
        $this->load->view("kernel", $Data);
    }

    public function ajax_get_chapter_subject(){
        $inputMainSubject = $this->input->post('subjectid');
        $subjectData = $this->evaluation_model->getAllActiveChaptersSubjectwise($inputMainSubject);
        $return = json_encode($subjectData, TRUE);
        echo ($return);
    }

}
