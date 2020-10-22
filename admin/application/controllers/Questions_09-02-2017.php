<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * @author  Krishna Gupta
 * @date    03.09.2016
 *
 **/

class Questions extends MY_Controller {

    var $EARLY = 0;
    var $ON_TIME = 0;
    var $LATE = 0;

    public function __construct() {

        parent::__construct();
        $this->load->library('session');
        $this->load->model('question_model');
        $this->load->helper('file');
    }

    public function index() {

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Quetion";
        $Data['load_page'] = "Question/add_question";
		
		$this->load->model('level_model');
        $this->load->model('board_model');
        $this->load->model('subject_model');
        $this->load->model('class_model');

        $Data['allLevel'] = $this->level_model->getAllActiveLevelForTag();
        $Data['allBoard'] = $this->board_model->getAllActiveBoards();
        $Data['allsubject'] = $this->subject_model->getAllActiveSubjectsForTags();
        $Data['allStd'] = $this->class_model->getAllActiveClass();
		
        $this->load->view("kernel", $Data);
    }

    public function getdata(){
        
        $Data['question_paper_data'] = $this->session->userdata('question_paper_details');

        $action = $this->input->post('action');

        if ($action === 'getdata')
        {
            $postArr['str'] = $this->input->post('value');
            $Data['resultArr'] = $this->question_model->getSearchQuestionsDetails($postArr);
            // if (mysqli_num_rows($query))
            // {
                foreach ($Data['resultArr'] AS $key => $value) {
                $optionDetails = explode('#!~!#',$value['optionDetails']);
                $counterChar = 'A';
                $optionForm = '';
                foreach($optionDetails as $row){
                    $option=explode('~!~',$row);
                    $bold=($option[3]=="Y")?'<b>':'';
                    $closebold=($option[3]=="Y")?'</b>':'';
                    if(sizeof($option)>1)
                        $optionForm =$optionForm.$bold.'<div class=".col-md-6"><div class=".col-md-6">'.$counterChar++.'. '.$option[1].'</div></div>'.$closebold;
                }
                echo '<br/><div class="btn btn-info" data-toggle="collapse" data-target="#'.$value['qbID'].'">'.$value['questionText'].'</div>
                <br/><div id='.$value['qbID'].' class="collapse">';
                echo $optionForm;
                echo '</div>';
                unset($optionForm);
            }
        //}
    }
    else if ($action === 'getansmenu')
    {
        ?>
        <form ID="QnAsubmit" enctype="multipart/form-data">
            <div class="row" id="formMe">
                <div  class="col-md-12" style="padding-bottom:10px;">
                    <div class="col-md-4"><strong>Option Name</strong></div>
                    <div class="col-md-6"><strong>Choose Image</strong></div>
                    <div class="col-md-2"><strong>Correct</strong></div>
                </div>
                <div  class="col-md-12" style="padding-bottom:10px;">
                    <div class="col-md-4"><input type="text" name="txtans" class="txtans"></div>
                    <div class="col-md-6"><input type="file" name="ansimg" class="ansimg"></div>
                    <div class="col-md-2"><input type="checkbox" class="anschk" name="newans"></div>
                </div>
            </div>
        </form>
        <div class="col-md-12" style="padding-bottom:10px;">
            <button type="button" id="adbtn" class="btn btn-md btn-Default">+Add more</button>
        </div>
        <?php
    }
    else if($action === 'QnAPost')
    {
        $postArr['questionText'] = $this->input->post('questionText');
        $postArr['ansValues'] = $this->input->post('ansValues');
        $postArr['ansCorrection'] = $this->input->post('ansCorrection');
		
		$postArr['levelID'] = $this->input->post('level');
		$postArr['board'] = $this->input->post('board');
		$postArr['subject'] = $this->input->post('subject');
		$postArr['standard'] = $this->input->post('standard');

        $Data['resultArr'] = $this->question_model->insertQuestionAns($postArr);
        print_r($Data['resultArr']);
        
		// if( $this->role_model->insertRole($postArr))
        // {
        //     $this->session->set_flashdata('message', 'Success! New Role has been added successfully.');
        // }
        // else
        // {
        //     $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
        // }
        /*$insert="INSERT INTO `questionbank`(`questionText`, `addedBy`) VALUES ('".$_REQUEST['questionText']."','52');";
        $query = mysqli_query($db, $insert);
        $questionID = mysqli_insert_id($db);
        if($questionID > 0) {
            $img='';$counterValue=1;
            $option='INSERT INTO `answerbank`(`qbID`, `optionValue`, `optionImg`, `isCorrect`, `qsort`, `status`) VALUES ';
            foreach($_REQUEST['ansValues'] as $optionText){
                $option.="(".$questionID.",'".$optionText."','".$img."','".$_REQUEST['ansCorrection'][($counterValue-1)]."','".$counterValue++."','Y') ,";
            }
            $optionQuery = rtrim($option, ",");
            $query = mysqli_query($db, $optionQuery);
            if($query){
                $status='Successfull Inserted !';
            }
            else
                $status='Fail ! Option Not Inserted';
        }
        else {
            $status='Fail ! Question Not Inserted';
        }
        echo $status;
    }
    else
    {
        echo 'no data received';
    }
    */
}

}
}
