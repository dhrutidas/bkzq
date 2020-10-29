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
class QuestionManager extends MY_Controller
{

    var $EARLY = 0;
    var $ON_TIME = 0;
    var $LATE = 0;

    public function __construct()
    {

        parent::__construct();
        $this->load->library('session');
        $this->load->model('question_model');
    }

    public function index()
    {
        $Data['groupArr'] = parent::menu();
        $Data['usersFilter'] = array(
            'fname' => 'First name',
            'lname' => 'Last name',
            'emailID' => 'Email id',
            'contactNumber' => 'Contact number'
        );
        $this->load->model('question_model');

        $Data['page_title'] = "Question List";
        $Data['load_page'] = "manager/questions_list";
        $this->load->view("kernel", $Data);
    }

    public function questionListManager()
    { 
        $sData = $this->session->userdata('user_details');
        $userId =  $sData['user_id'];
        $_POST['user_id'] =  $userId;
        // Fetch member's records
        $qData = $this->question_model->getRows($_POST);
        //print_r($qData);exit;
        $i = $_POST['start'];
        foreach ($qData as $question) {

            // $editUrl = base_url('open-edit-user-modal/' . $member->userID);
            // $viewUrl = base_url('open-view-user-modal/' . $member->userID);

            // $editButton = "<a href='" . $editUrl . "' data-toggle='modal' data-target='#viewModal'><span class='glyphicon glyphicon-edit'></span></a>";
            // $viewButton = "<a href='" . $viewUrl . "' data-toggle='modal' data-target='#viewModal'><span class='glyphicon glyphicon-list'></span></a>";
            //$editButton = "<button class='btn btn-sm btn-info updateUser' data-id='".$member->userID."' data-toggle='modal' data-target='#updateModal' >Edit</button>";
            // Delete Button
            //$deleteButton = "<button class='btn btn-sm btn-danger deleteUser' data-id='".$member->userID."'>Delete</button>";

            $i++;
            //$created = date('jS M Y', strtotime($member->createdAt));
            //$status = ($member->status == 'Y') ? 'Active' : 'Inactive';
            //$action = $editButton . " " . $viewButton;
            $answers = $this->question_model->getAnswerDetail($question->qbID);
            //print_r($answers);exit;
            $data[] = array($i, $question->questionText, $answers[0]['optionDetails'], $answers[0]['correctAns']);
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->question_model->countAll($userId),
            "recordsFiltered" => $this->question_model->countFiltered($_POST),
            "data" => $data,
        );

        // Output to JSON format
        echo json_encode($output);

        // $sData = $this->session->userdata('user_details');
        // $userId =  $sData['user_id'];
        // $qData = $this->question_model->getAllQuestionsManager($userId);
        // $count =sizeof( $qData);
        // $data = [];
        // for($i= 0;$i< $count; $i++){
        //     $answers = $this->question_model->getAnswerDetail($qData[$i]['qbID']);
        //     $data[] = [
        //         'qtext' => $qData[$i]['questionText'],
        //         'answers' => $answers
        //     ];
        // }
        // print_r($data);exit;
        // $question['resultSet'] = $this->question_model->getAllQuestionsManager($userId);
        // $question['count'] = sizeof($question['resultSet']);
        // $return = json_encode($question, TRUE);
        // echo ($return);
    }
}
