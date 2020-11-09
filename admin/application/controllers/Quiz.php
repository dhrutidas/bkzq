<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * @author  Krishna Gupta
 * @date    03.09.2016
 *
 * */
class Quiz extends MY_Controller
{

    var $EARLY = 0;
    var $ON_TIME = 0;
    var $LATE = 0;

    public function __construct()
    {

        parent::__construct();
        $this->load->library('session');
        $this->load->model('quiz_model');
        $this->load->model('stage_model');
        $this->load->helper('file');
    }

    public function index()
    {
        //print_r($this->session->userdata('user_details')); die;
        $Data['groupArr'] = parent::menu();

        $this->load->model('level_model');
        $this->load->model('board_model');
        $this->load->model('subject_model');
        $this->load->model('class_model');

        $Data['allLevel'] = $this->level_model->getAllActiveLevel();
        $Data['allBoard'] = $this->board_model->getAllActiveBoards();
        $Data['allsubject'] = $this->subject_model->getAllActiveSubjectsForQuiz();
        $Data['allStd'] = $this->class_model->getAllActiveClass();
        $Data['page_title'] = "Quiz";
        $Data['load_page'] = "quiz/quiz_start";
        $this->load->view("kernel", $Data);
    }

    public function subjectStageLevel()
    {

        //below code will fetch the  level and stage 
        $subjectID = $this->input->post('subjectID');
        $chapterID = $this->input->post('chapterID');
        $getLevelAndStage = $this->quiz_model->getLevelAndStage($subjectID, $chapterID);
        //print_r($getLevelAndStage);
        $levelID = empty($getLevelAndStage[0]['currentLevel']) ? 0 : $getLevelAndStage[0]['currentLevel'];
        $stageID = empty($getLevelAndStage[0]['currentStage']) ? 0 : $getLevelAndStage[0]['currentStage'];

        $getLevelAndStage1 = $this->quiz_model->getNextStage($levelID, $stageID);
        $return = json_encode($getLevelAndStage1, TRUE);
        echo ($return);
    }

    public function exam()
    {
        $Data['groupArr'] = parent::menu();
        $this->session->unset_userdata('question_paper_details');
        $Data['session_data'] = $this->session->userdata('user_details');

        $this->form_validation->set_rules('inputLevel', 'Level', 'required');
        $this->form_validation->set_rules('inputStage', 'Stage', 'required');
        $this->form_validation->set_rules('inputSubject', 'Subject', 'required');
        $this->form_validation->set_rules('inputChapter', 'Chapter', 'required'); //this is chapter

        if ($this->form_validation->run() == TRUE) {

            $postArr['inputLevel'] = $this->input->post('inputLevel');
            $postArr['inputStage'] = $this->input->post('inputStage');
            $postArr['inputSubject'] = $this->input->post('inputSubject');
            $postArr['inputChapter'] = $this->input->post('inputChapter');

            $postArr['inputBoard'] = $Data['session_data']['board_id'];
            $postArr['inputStandard'] = $Data['session_data']['std_id'];
            $fileName = $Data['session_data']['user_id'] . "_" . $postArr['inputLevel'] . "_" . $postArr['inputStage'] . "_" . $postArr['inputChapter'] . ".json";

            $Data['stageDetails'] = $this->stage_model->getStageDetails($postArr['inputStage']);
            $maxQuestion = $Data['stageDetails']['maxQuestion'];
            $maxQuestionAllowed = $Data['stageDetails']['maxQuestionAllowed'];
            $canSkip = $maxQuestion - $maxQuestionAllowed;
            $postArr['maxQuestion'] = $maxQuestion;
            $minPassingCriterea = $Data['stageDetails']['minPassingCriterea'];
            $perStageMark = $Data['stageDetails']['orderBy'];
            //print_r($postArr);
            $answerData = $this->quiz_model->getAllQuizData($postArr);
            // echo "<pre>";         
            //  print_r($answerData);exit;
            if (!empty($answerData)) {

                if (count($answerData) == $maxQuestion) {
                    $questionDeatils = [];
                    foreach ($answerData as $row) {
                        $arrayJson = [];
                        $arrayJson['questionId'] = $row['qbID'];
                        $arrayJson['question'] = $row['questionText'];
                        $arrayJson['questionimage'] = $row['questionImg'];
                        $arrayJson['systemCorrectOptionID'] = $row['correctAnsID'];
                        $arrayJson['correctOptionID'] = "NA"; //$row['qbID'];
                        $optionDetails = explode('#!~!#', $row['optionDetails']);
                        $optionArray = [];
                        foreach ($optionDetails as $options) {
                            $singleOption = explode('~!~', $options);
                            $optionArray[$singleOption[0]] = $singleOption[1]; //.'#image#'.$singleOption[2];
                        }
                        //print_r($arrayJson);exit;
                        $arrayJson['options'] = $optionArray;
                        array_push($questionDeatils, $arrayJson);
                        unset($arrayJson);
                    }
                    $sArrayQuestion = json_encode(
                        array(
                            'level' => $postArr['inputLevel'],
                            'stage' => $postArr['inputStage'],
                            'subject' => $postArr['inputSubject'],
                            'chapter' => $postArr['inputChapter'],
                            'totalQuestions' => $maxQuestion,
                            'canSkip' => $canSkip,
                            'minAttempt' => $maxQuestionAllowed,
                            'minPassingCriterea' => $minPassingCriterea,
                            'perStageMark' => $perStageMark,
                            'skipedCount' => 0,
                            'attemptedCount' => 0,
                            'questionDetails' => $questionDeatils
                        )
                    );
                    $filePath = "./assets/json_file/" . $fileName;
                    $fp = fopen($filePath, 'w');
                    fwrite($fp, $sArrayQuestion);
                    //fclose($fp);
                    $sArrayQuestionSession = array('fileName' => $fileName);
                    //print_r($sArrayQuestionSession);
                    $this->session->set_userdata('question_paper_details', $sArrayQuestionSession);

                    $Data['question_paper_data'] = $this->session->userdata('question_paper_details');

                    $question_data = json_decode(file_get_contents(base_url() . "assets/json_file/" . $fileName), TRUE);
                    //print_r($question_data);
                    $qCount = count($question_data['questionDetails']);
                    $first_key = key($question_data['questionDetails']);
                    $Data['questionId'] = $question_data['questionDetails'][$first_key]['questionId'];
                    $Data['question'] = $question_data['questionDetails'][$first_key]['question'];
                    $Data['options'] = $question_data['questionDetails'][$first_key]['options'];
                    //$Data['questionimage'] = $question_data['questionDetails'][$first_key]['questionimage'];

                    $Data['first_key'] = $first_key;

                    $canSkip = $question_data['canSkip'];
                    $skipCount = $question_data['skipedCount'];

                    $minAttempt = $question_data['minAttempt'];
                    $attemptedCount = $question_data['attemptedCount'];

                    $skipStatus = $maxStatus =  "Y";
                    if ($skipCount >= $canSkip) {
                        $skipStatus = "N";
                    }

                    if ($minAttempt <= $attemptedCount) {
                        $skipStatus = "N";
                    }

                    if ($qCount <= 1) {
                        $maxStatus =  "N";
                    }

                    $Data['skipStatus'] = $skipStatus;
                    $Data['maxStatus'] = $maxStatus;
                    $Data['canSkip'] = $canSkip;
                    //print_r($Data);
                    $Data['page_title'] = "Online Quiz";
                    $Data['load_page'] = "quiz/online_exam";
                    $this->load->view("kernel", $Data);
                } else {
                    $this->session->set_flashdata('warning', 'Sorry! Ask admin to add more question for this stage.');
                    redirect(base_url('start-quiz'));
                }
            } else {
                $this->session->set_flashdata('warning', 'Sorry! No Question found for this Stage.');
                redirect(base_url('start-quiz'));
            }
        } else {
            $this->session->set_flashdata('warning', 'Mandatory field can not be left blank.');
            redirect(base_url('start-quiz'));
        }
    }

    public function nextQuestion()
    {
        $Data = array();
        $Data['question_paper_data'] = $this->session->userdata('question_paper_details');
        $questionId = $this->input->post('currentQuestionId');
        $indexId = $this->input->post('currentIndexId');
        $currentButtonID = $this->input->post('buttonID');
        $correctOption = $this->input->post('correctOption');

        $jsonFilePath = base_url() . "assets/json_file/" . $Data['question_paper_data']['fileName'];
        $question_data = json_decode(file_get_contents($jsonFilePath), true);

        $canSkip = $question_data['canSkip'];
        $skipCount = $question_data['skipedCount'];

        $minAttempt = $question_data['minAttempt'];
        $attemptedCount = $question_data['attemptedCount'];

        $skipStatus = $maxStatus =  "Y";

        //if( ($currentButtonID == 'skip')  && ($minAttempt >= $attemptedCount) ) {
        if (($currentButtonID == 'skip')) {
            $question_data['questionDetails'][$indexId]['correctOptionID'] = 0;
            $skipCount = $skipCount + 1;
            if ($skipCount >= $canSkip) {
                $skipStatus = "N";
            }
            if ($minAttempt <= $attemptedCount) {
                $maxStatus = "N";
            }
        }

        //if( ($currentButtonID == 'next') && ($minAttempt >= $attemptedCount)){
        if (($currentButtonID == 'next')) {
            $question_data['questionDetails'][$indexId]['correctOptionID'] = $correctOption;
            $attemptedCount = $attemptedCount + 1;
            if ($minAttempt <= $attemptedCount) {
                $maxStatus = "N";
                $skipStatus = "N";
            }
        }

        $updateData = array('skipedCount' => $skipCount, 'attemptedCount' => $attemptedCount);
        foreach ($updateData as $key => $val) {
            foreach ($question_data as $i => $oVal) {
                if ($i == $key) {
                    $question_data[$i] = $val;
                }
            }
        }

        $json = json_encode($question_data);
        //var_dump($json);
        file_put_contents("assets/json_file/" . $Data['question_paper_data']['fileName'], json_encode($question_data));


        $first_key = $indexId + 1;
        $Data['questionId'] = $question_data['questionDetails'][$first_key]['questionId'];
        $Data['question'] = $question_data['questionDetails'][$first_key]['question'];
        $Data['systemCrctAnsID'] = $question_data['questionDetails'][$indexId]['systemCorrectOptionID'];
        $Data['options'] = $question_data['questionDetails'][$first_key]['options'];
        $Data['questionimage'] = $question_data['questionDetails'][$first_key]['questionimage'];
        $Data['imagePath'] = base_url("assets/images/question_images") . '/';

        $Data['canSkip'] = $canSkip;
        $Data['skipedCount'] = $skipCount;
        $Data['first_key'] = $first_key;
        $Data['skipStatus'] = $skipStatus;
        $Data['maxStatus'] = $maxStatus;

        $return = json_encode($Data);
        echo ($return);
    }

    public function submitExam()
    {

        $Data['question_paper_data'] = $this->session->userdata('question_paper_details');
        $sData = $this->session->userdata('user_details');
        $user_id = $sData['user_id'];

        $indexId = $this->input->post('indexId');
        $correctOption = $this->input->post('optradio');

        $jsonFilePath = base_url() . "assets/json_file/" . $Data['question_paper_data']['fileName'];

        $question_data1 = json_decode(file_get_contents($jsonFilePath), true);
        $question_data1['questionDetails'][$indexId]['correctOptionID'] = $correctOption;
        $systemCrctAnsID = $question_data1['questionDetails'][$indexId]['systemCorrectOptionID'];


        //echo $userCorrectAns;
        //echo 'systemCrctAnsID :'.$systemCrctAnsID . ' AND correctOption : '.$correctOption;
        //exit;
        $json = json_encode($question_data1);
        file_put_contents("assets/json_file/" . $Data['question_paper_data']['fileName'], json_encode($question_data1));

        $question_data = json_decode(file_get_contents($jsonFilePath), TRUE);

        $level = $question_data['level'];
        $stage = $question_data['stage'];
        $subject = $question_data['subject'];
        $chapter = $question_data['chapter'];
        $perStageMark = $question_data['perStageMark'];
        $minPassingCriterea = $question_data['minPassingCriterea'] * $perStageMark;
        $options = $question_data['questionDetails'];
        $totalMarks = 0;
        $questionId = "'#'";
        foreach ($options as $key => $value) {
            $questionId = $questionId . ",'" . $value['questionId'] . "'";
        }
        $answerData = $this->quiz_model->getQuestionsDetails($questionId);

        $user_ip = $_SERVER['REMOTE_ADDR'];
        $allData = array();
        foreach ($options as $detailKey => $detailValue) {
            $ansStatus = "";
            $inData = array();
            $questionId = $detailValue['questionId'];
            $correctOptionID = 0;
            $userOptionID = $detailValue['correctOptionID'];
            foreach ($answerData as $ansKey => $ansValue) {

                if ($questionId == $ansValue['qbID']) {
                    $correctOptionID = ltrim($ansValue['ansID'], 0);
                }
            }

            if ($userOptionID == $correctOptionID) {
                $ansStatus = "Y";
                $totalMarks = $totalMarks + $perStageMark;
            } else if ($userOptionID == '0') {
                $ansStatus = "S";
            } else if ($userOptionID == 'NA') {
                $ansStatus = "NA";
            } else {
                $ansStatus = "N";
            }

            //echo 'user:'.$userOptionID." & system :".$correctOptionID." $ Status :".$ansStatus. '<br/>';exit;
            $inData['userID'] = $user_id;
            $inData['questionID'] = $questionId;
            $inData['correctOptionID'] = $correctOptionID;
            $inData['userOptionID'] = $userOptionID;
            $inData['levelID'] = $level;
            $inData['stageID'] = $stage;
            $inData['subjectID'] = $subject;
            $inData['chapterID'] = $chapter;
            $inData['ansStatus'] = $ansStatus;
            $inData['playingStatus'] = 'Y';
            $inData['userIP'] = $user_ip;
            array_push($allData, $inData);
        }

        if ($this->quiz_model->insertQuestionDetails($allData)) {
            //if( $this->quiz_model->updatelevelStageTaggingStatus() ){
            if ($totalMarks >= $minPassingCriterea) {
                $this->session->set_flashdata('message', 'Success! You have successfully completed this Stage.');
            } else {
                $this->quiz_model->resetQuizNew($chapter, $user_id, $level);
                $this->session->set_flashdata('warning', 'Sorry! You have failed in this stage & quiz set you back to the first stage of level you were playing.<br/>');
            }
            unlink("assets/json_file/" . $Data['question_paper_data']['fileName']);
            $this->session->unset_userdata('question_paper_details');
            $this->session->unset_userdata('subject_level_stage');

            // }else{
            //     $this->session->set_flashdata('warning', 'Quiz has not been submitted.Please try again !!!');   
            // }

        } else {
            $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
        }
        if (isset($correctOption)) {
            if ($systemCrctAnsID == $correctOption) {
                // echo  "<script type='text/javascript'>
                //             alert('You have given the correct answer.');
                //             window.location.replace('start-quiz');
                //         </script>";
                redirect(base_url('quiz-result/complete'));
            } else {
                redirect(base_url('start-quiz/fail'));
            }
        } else {
            redirect(base_url('start-quiz'));
        }
        //redirect( base_url('start-quiz') );

    }

    public function onRadioButtonValidation()
    {
        $Data['question_paper_data'] = $this->session->userdata('question_paper_details');

        $jsonFilePath = base_url() . "assets/json_file/" . $Data['question_paper_data']['fileName'];
        $question_data = json_decode(file_get_contents($jsonFilePath), true);

        $canSkip = $question_data['canSkip'];
        $skipCount = $question_data['skipedCount'];

        $minAttempt = $question_data['minAttempt'];
        $attemptedCount = $question_data['attemptedCount'];

        $skipStatus = $maxStatus =  "Y";
        $attemptedCount = $attemptedCount + 1;
        if ($minAttempt <= $attemptedCount) {
            $maxStatus = "N";
            //$skipStatus = "N";
        }
        $Data['skipStatus'] = $skipStatus;
        $Data['maxStatus'] = $maxStatus;

        $return = json_encode($Data);
        echo ($return);
    }

    public function result($res){
        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "Quiz";
        $Data['load_page'] = "quiz/quiz_result";
        $Data['result'] = $res;
        $this->load->view("kernel", $Data);
    }
}
