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
class Quiz extends MY_Controller {

    var $EARLY = 0;
    var $ON_TIME = 0;
    var $LATE = 0;

    public function __construct() {

        parent::__construct();
        $this->load->model('quiz_model');
        $this->load->helper('file');
    }

    public function index() {

        $Data['groupArr'] = parent::menu();

        // $this->load->model('options_model');
        // $this->load->model('complaint_type_db');
        // $this->load->model('category_model');
        // $this->load->model('channels_model');

        // $Data['addtnArr'] = $this->options_model->getComplaintForm();
        // $Data['complaint_data'] = $this->complaint_type_db->complaint_details();
        // $Data['categoryArr'] = $this->category_model->getAllCategory();
        // $Data['ChannelArr'] = $this->channels_model->getAllChannels();
        
        $Data['page_title'] = "Quiz";
        $Data['load_page'] = "quiz/quiz_start";
        $this->load->view("kernel", $Data);
    }

    public function exam(){

        $Data['groupArr'] = parent::menu();
        
        $this->session->unset_userdata('question_paper_details');
        $sArray = array('stage' => 2,
                        'level' => 3,
                        'totalQuestions' => 11,
                        'canSkip' => 3,
                        'minAttempt' => 8
                );
        $this->session->set_userdata('question_paper_details', $sArray);

        $Data['session_data'] = $this->session->userdata('user_details');
        $Data['question_paper_data'] = $this->session->userdata('question_paper_details');
        //print_r($Data['session_data']);
        //print_r($Data['question_paper_data']);

        $question_data = json_decode(file_get_contents(base_url()."assets/json_file/question.json"));
        //print_r($question_data);
        
        $first_key = key($question_data->questionDeatils);
        $Data['questionId'] = $question_data->questionDeatils[$first_key]->questionId;
        $Data['question'] = $question_data->questionDeatils[$first_key]->question;
        $Data['options'] = $question_data->questionDeatils[$first_key]->options;
        $Data['first_key'] = $first_key;

        $Data['page_title'] = "Online Quiz";
        $Data['load_page'] = "quiz/online_exam";
        $this->load->view("kernel", $Data);
    }

    public function nextQuestion(){
        
        $Data['question_paper_data'] = $this->session->userdata('question_paper_details');
        $questionId = $this->input->post('currentQuestionId');
        $indexId = $this->input->post('currentIndexId');
        $currentButtonID = $this->input->post('buttonID');

        $jsonFilePath = base_url()."assets/json_file/question.json";
        
        $question_data = json_decode(file_get_contents($jsonFilePath),true);
        
        $canSkip = $question_data['canSkip'];
        $skipCount = $question_data['skipedCount'];

        $minAttempt = $question_data['minAttempt'];
        $attemptedCount = $question_data['attemptedCount'];
        
        //echo "canSkip:".$canSkip." and "."skipCount:".$skipCount;
        $skipStatus = "Y";
        $maxStatus = "Y";
        if( ($currentButtonID == 'skip')  && ($canSkip >= $skipCount) ) {
            $skipCount = $skipCount+1;
            if($skipCount >= $canSkip){
                $skipStatus = "N";
            }
            // if($canSkip > $skipCount){
            //     $skipStatus = "Y";
            //     $skipCount = $skipCount+1; 
            // }else{
            //     $skipStatus = "N";
            // }
        }else if( ($currentButtonID == 'next') && ($minAttempt >= $attemptedCount)){
            $attemptedCount = $attemptedCount+1;
            if($minAttempt == $attemptedCount){
                $maxStatus = "N";
            }
        }else{
            $maxStatus = "N";
            $skipStatus = "N";
        }

        $updateData = array('skipedCount' => $skipCount,'attemptedCount' => $attemptedCount);
        foreach ( $updateData as $key => $val ) {
            foreach ( $question_data as $i => $oVal ) {
                if ( $i == $key ) {
                    $question_data[$i] = $val;
                }
            }
        }

        $json = json_encode($question_data) ;
        //var_dump($json);
        file_put_contents("assets/json_file/question.json", json_encode($question_data));
        //echo file_put_contents("assets/json_file/question.json","Hello World. Testing!");

        $first_key = $indexId+1;
        $Data['questionId'] = $question_data['questionDeatils'][$first_key]['questionId'];
        $Data['question'] = $question_data['questionDeatils'][$first_key]['question'];
        $Data['options'] = $question_data['questionDeatils'][$first_key]['options'];
        $Data['first_key'] = $first_key;
        $Data['skipStatus'] = $skipStatus;
        $Data['maxStatus'] = $maxStatus;

        $return = json_encode($Data);
        echo ($return);
    }

/*
    public function graph_data() {
        $region = $this->input->post('selected_region');
        $graph_report = $this->quiz_model->get_bargraph_details($region);
        $open = $closed = $resolved = $cancelled = $complaint_type = '';
        foreach ($graph_report as $key_val => $data_val) {
            $complaint_type.=$data_val['complaint_type_name'] . '~';
            $open.=$data_val['OPEN'] . '~';
            $closed.=$data_val['CLOSED'] . '~';
            $cancelled.=$data_val['CANCELLED'] . '~';
            $resolved.=$data_val['RESOLVED'] . '~';
        }
        $return = rtrim($complaint_type, "~") . '!~!' . rtrim($open, "~") . '!~!' . rtrim($closed, "~") . '!~!' . rtrim($cancelled, "~") . '!~!' . rtrim($resolved, "~");
        echo $return;
    }

    public function graph_channel() {
        $region = $this->input->post('selected_region');
        $graph_report = $this->quiz_model->get_bargraph_details($region);
        $open = $closed = $resolved = $cancelled = $complaint_type = '';
        foreach ($graph_report as $key_val => $data_val) {
            $complaint_type.=$data_val['complaint_type_name'] . '~';
            $open.=$data_val['OPEN'] . '~';
            $closed.=$data_val['CLOSED'] . '~';
            $cancelled.=$data_val['CANCELLED'] . '~';
            $resolved.=$data_val['RESOLVED'] . '~';
        }
        $return = rtrim($complaint_type, "~") . '!~!' . rtrim($open, "~") . '!~!' . rtrim($closed, "~") . '!~!' . rtrim($cancelled, "~") . '!~!' . rtrim($resolved, "~");
        echo $return;
    }

    public function sub_cat_graph_data() {
        $region = $this->input->post('selected_region');
        $cmp_status = $this->input->post('status');
        $graph_report = $this->quiz_model->get_bar_sub_cat_graph_details($region, $cmp_status);
        $open = $closed = $resolved = $cancelled = $complaint_type = '';
        foreach ($graph_report as $key_val => $data_val) {
            $complaint_type.=$data_val['sub_category_name'] . '~';
            $open.=$data_val['sum_category_codes'] . '~';
        }
        $return = rtrim($complaint_type, "~") . '!~!' . rtrim($open, "~");
        echo $return;
    }

    public function pie_chart_left_data() {
        $region = $this->input->post('selected_region');
        $cmp_type = $this->input->post('complaint_type');
        $graph_report = $this->quiz_model->get_leftpiegraph_details($region, $cmp_type);
        $category_code = $number_of_complaints = '';
        foreach ($graph_report as $key_val => $data_val) {
            $category_code.=$data_val['category_name'] . '~';
            $number_of_complaints.=$data_val['sum_category_codes'] . '~';
        }
        $return = rtrim($category_code, "~") . '!~!' . rtrim($number_of_complaints, "~");
        echo $return;
    }

    public function pie_chart_right_data() {
        $region = $this->input->post('selected_region');
        $category = $this->input->post('category');
        $graph_report = $this->quiz_model->get_rightpiegraph_details($region, $category);
        $category_code_2 = $number_of_complaints_2 = '';
        foreach ($graph_report as $key_val => $data_val) {
            $category_code_2.=$data_val['complaint_type_name'] . '~';
            $number_of_complaints_2.=$data_val['sum_complaint_type'] . '~';
        }
        $return = rtrim($category_code_2, "~") . '!~!' . rtrim($number_of_complaints_2, "~");
        echo $return;
    }

    public function bar_channel_cmp_type() {
        $graph_report = $this->quiz_model->get_all_channel_cmp_type();
        $count = $channel_codes = $channel_names = $cmp_type_codes = $cmp_type_names = '';
        foreach ($graph_report as $key_val => $data_val) {
            $count.=$data_val['COUNT_final'] . '~';
            $channel_codes.=$data_val['channel_code'] . '~';
            $cmp_type_codes.=$data_val['complaint_Code'] . '~';
            $channel_names.=$data_val['channel_name'] . '~';
//			$cmp_type_names.=$data_val['complaint_name'].'~';
        }
        $return = rtrim($count, "~") . '!~!' . rtrim($channel_codes, "~") . '!~!' . rtrim($channel_names, "~") . '!~!' . rtrim($cmp_type_codes, "~") . '!~!' . $data_val['complaint_name'];
        echo $return;
    }

    //@shrikant mavlankar #08092015
    public function complaintTypeTatAjax() {

        $this->load->model('complaint_model');

        $getRegion = $this->input->post("region_val");
        $getCompType = $this->input->post("comp_type_val");

        $sendArr = array("complaint_type" => $getCompType);

        if ($getRegion != "ALL") {
            $sendArr['region'] = $getRegion;
        }

        $compTransactionDetails = $this->complaint_model->getComplaintTransaction($sendArr);

        if (is_array($compTransactionDetails)):

            foreach ($compTransactionDetails as $key => $serializeArr) {

                $transArr = unserialize(base64_decode($serializeArr['complaint_transaction']));

                $this->returnTatCount($transArr);
            }

            $returnArr = array("early" => $this->EARLY, "on_time" => $this->ON_TIME, "late" => $this->LATE);

            echo json_encode($returnArr);

        else: $returnArr = array("early" => 'N');
            echo json_encode($returnArr);
        endif;
    }

    //@shrikant mavlankar #09092015
    public function productCategoryTatAjax() {

        $this->EARLY = 0;
        $this->ON_TIME = 0;
        $this->LATE = 0;

        $this->load->model('complaint_model');

        $getRegion = $this->input->post("region_val");
        $getProdCat = $this->input->post("prod_cat_val");

        $sendArr = array("category_code" => $getProdCat);

        if ($getRegion != "ALL") {
            $sendArr['region'] = $getRegion;
        }

        $compTransactionDetails = $this->complaint_model->getComplaintTransaction($sendArr);

        if (is_array($compTransactionDetails)):

            foreach ($compTransactionDetails as $key => $serializeArr) {

                $transArr = unserialize(base64_decode($serializeArr['complaint_transaction']));

                $this->returnTatCount($transArr);
            }

            $returnArr = array("early" => $this->EARLY, "on_time" => $this->ON_TIME, "late" => $this->LATE);

            echo json_encode($returnArr);

        else: $returnArr = array("early" => 'N');
            echo json_encode($returnArr);
        endif;
    }

    //@shrikant mavlankar #09092015
    public function productChannelTatAjax() {

        $this->EARLY = 0;
        $this->ON_TIME = 0;
        $this->LATE = 0;

        $this->load->model('complaint_model');

        $getRegion = $this->input->post("region_val");
        $getChannel = $this->input->post("channel_val");

        $sendArr = array("channel_code" => $getChannel);

        if ($getRegion != "ALL") {
            $sendArr['region'] = $getRegion;
        }

        $compTransactionDetails = $this->complaint_model->getComplaintTransaction($sendArr);

        if (is_array($compTransactionDetails)):

            foreach ($compTransactionDetails as $key => $serializeArr) {

                $transArr = unserialize(base64_decode($serializeArr['complaint_transaction']));

                $this->returnTatCount($transArr);
            }

            $returnArr = array("early" => $this->EARLY, "on_time" => $this->ON_TIME, "late" => $this->LATE);

            echo json_encode($returnArr);

        else: $returnArr = array("early" => 'N');
            echo json_encode($returnArr);
        endif;
    }

    //@shrikant mavlankar #08092015
    private function returnTatCount($getArr) {

        $previous_date = "";
        $cnt = 0;

        foreach ($getArr as $key => $history) {

            if ($cnt > 0) {

                $this->dateComparison($previous_date, date('Y-m-d', strtotime($history['Date'])), $history['Tat']);
            }

            $previous_date = date('Y-m-d', strtotime($history['Date']));
            $cnt++;
        }
    }

    //@shrikant mavlankar #08092015
    private function dateComparison($first_date, $second_date, $tat) {

        $first_ts = strtotime($first_date);
        $second_ts = strtotime($second_date);
        $dateAfterTat = strtotime("-" . $tat . " days", $second_ts);

        if ($first_ts > $dateAfterTat) {
            $this->EARLY++;
        } elseif ($first_ts == $dateAfterTat) {
            $this->ON_TIME++;
        } else {
            $this->LATE++;
        }
    }
*/
}
