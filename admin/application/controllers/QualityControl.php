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
class QualityControl extends MY_Controller
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
        // $Data['usersFilter'] = array(
        //     'fname' => 'First name',
        //     'lname' => 'Last name',
        //     'emailID' => 'Email id',
        //     'contactNumber' => 'Contact number'
        // );
        $this->load->model('question_model');
        $this->load->model('employee_model');
        $Data['qm_list']=$this->employee_model->getAllQm();
        $Data['qStatus']=array(
            'Draft' => 'Draft',
            'Approved' => 'Approved',
            'Rejected' => 'Rejected'
        );
        // echo "<pre>";
        // print_r($Data['qm_list']);exit;
        $Data['page_title'] = "Question List";
        $Data['load_page'] = "control/questions_list";
        $this->load->view("kernel", $Data);
    }

    public function questionList()
    { 
        $sData = $this->session->userdata('user_details');
        $qData = $this->question_model->getRows($_POST);
        $i = $_POST['start'];
        $data = array();
        
        foreach ($qData as $question) {
            $editUrl = base_url('open-edit-user-modal/' . $question->qbID);
            if($question->status == 'Draft')
                $editButton = "<a href='" . $editUrl . "'><span class='glyphicon glyphicon-edit'></span></a>";
            else
                $editButton = "<a href='#' disabled class='not-active'><span class='glyphicon glyphicon-edit'></span></a>";
                      

            $i++;
                        
            $data[] = array($i, $question->questionText, $question->fName." ".$question->lName,date("d/m/Y",strtotime($question->addedOn)),$editButton);
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->question_model->countAll($sData['user_id']),
            "recordsFiltered" => $this->question_model->countFiltered($_POST),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function openPreview(){
        
    }
}
