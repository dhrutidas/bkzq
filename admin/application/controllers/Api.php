<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    19.03.2017
 *
**/

class Api extends CI_Controller{

    function __construct() { 
        parent::__construct(); 
        $this->load->helper('string');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('email');
        $this->load->library('session');
        $this->load->model('api_model');

        // $this->load->model('student_model');
        // $this->load->model('employee_model');
        // $this->load->model('role_model');
        // $this->load->model('board_model');
        $this->load->model('school_model');
        // $this->load->model('class_model');
        // $this->load->model('subject_model');
        // $this->load->model('package_model');
    }

    function bkzToppers(){
        $data = $this->api_model->getBkzTopper();
        // echo $this->db->last_query();die;
        //print_r($data);
        //predefine array
        $main_arr = array();
        $data_summ = array();
        foreach ( $data as $list ) {

            $marks = $list['Marks'];
            $user_id = $list['userID'];
            $user_pic = $list['photo'];
            $user_name = $list['user_name'].'~#~'.$user_pic.'~#~'.$list['answerdate'];
            $data_summ[ $user_name ] = @$data_summ[ $user_name ] + $list['Marks'];
        }
        //$data_summ[ 'kk' ] = 7;
        //print_r($data_summ);
        arsort($data_summ);
        //array_push($main_arr, $data_summ);
        echo json_encode($data_summ);
    }

    function studentMarks(){
        $user_data = $this->session->userdata('user_details');
        $userID = $user_data['user_id'];

        $data = $this->api_model->getStudentMarks($userID);
        //predefine array
        $data_summ = array();
        foreach ( $data as $list ) {

            $marks = $list['Marks'];
            $user_id = $list['userID'];
            $data_summ[ $user_id ] = $marks + $list['Marks'];
        }
        arsort($data_summ);
        return $data_summ;
        //echo json_encode($data_summ);
    }

    function schoolToppers($school){
        $data = $this->api_model->getSchoolTopper($school);
        //predefine array
        $main_arr = array();
        $data_summ = array();
        foreach ( $data as $list ) {

            $marks = $list['Marks'];
            $user_id = $list['userID'];
            $user_pic = $list['photo'];
            $user_name = $list['user_name'].'~#~'.$user_pic.'~#~'.$list['answerdate'];
            $data_summ[ $user_name ] = @$data_summ[ $user_name ] + $list['Marks'];
        }
        arsort($data_summ);
        //array_push($main_arr, $data_summ);
        echo json_encode($data_summ);
    }

    function schoolList(){
        $data = $this->school_model->getAllActiveSchools();

        echo json_encode($data);
    }
}
