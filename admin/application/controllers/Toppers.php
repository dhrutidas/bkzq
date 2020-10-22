<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }

class Toppers extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('student_model');
        $this->load->model('affiliate_model');
        $this->load->model('prize_model');        
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('email');
        define('MIN_AMOUNT',10);
    }

    public function index(){

        $Data['groupArr'] = parent::menu();        
        $sData = $this->session->userdata('user_details');
        $affiliateID =  intval($sData['user_id']);
        $Data['monthPicker'] = $this->input->post('monthPicker') ? $this->input->post('monthPicker') : date('m', strtotime('-1 month', time())).'/'.date('Y', time());
        $Data['page_title'] = "Toppers";
        $Data['students_list'] = $this->student_model->getTopper($Data['monthPicker']);
        $Data['prize_money'] = $this->affiliate_model->getPrizeMoney()['commission'] *.10;
        $Data['prize_money'] = $Data['prize_money'] - $this->prize_model->prizesGiven($affiliateID)['Amount'];        
        $Data['prizeList'] = $this->prize_model->getPrizeFlag();
        if(count($Data['prizeList']) > 0){
            $this->session->set_flashdata('message', 'You have declared prize for last month');
        }
        $Data['load_page'] = "toppers/index";
        $this->load->view("kernel", $Data);
    }

    public function prizeModal(){
        $Data['groupArr'] = parent::menu();        
        $sData = $this->session->userdata('user_details');
        $affiliateID =  intval($sData['user_id']);
        $Data['page_title'] = "Toppers";
        $Data['affiliate_prize_money'] = $this->affiliate_model->getPrizeMoney()['commission']*.10;
        $Data['affiliate_prize_money'] = $Data['affiliate_prize_money'] - $this->prize_model->prizesGiven($affiliateID)['Amount'];
        $Data['studentID'] = $this->input->post('students');
        $students = $this->student_model->getStudentsDetails($Data['studentID']);
        foreach($students as $student){
            $studentDetails[$student['userID']] = $student;
        }          
        if(count($Data['studentID']) < 4){
            $Data['studentDetails'] = $studentDetails;
            $Data['prizeDetails'] = $this->prize_model->getPrizeDetails($Data['studentID'], true);
            $Data['load_page'] = "toppers/prize_modal";      
            $this->load->view("kernel", $Data);     
        }       else{
            $this->index();
        }
       
       
    }

    public function submit(){        
        $period = date('m', time()).'/'.date('Y', time());
        $sData = $this->session->userdata('user_details');
        $affiliateID =  intval($sData['user_id']);
        $dt['affiliateID'] = $affiliateID;  
        $dt['period'] = $period;
        foreach($this->input->post('prize_money') as $data=>$val){
            $dt['amount'] = $val;
            $dt['studentID'] = $data;    
            $this->prize_model->insertPrize($dt);               
        }
        $this->session->set_flashdata('message', 'Prize declaration request sent to Admin successfully');
        redirect( base_url('studentsPrizeList') );
    }

    public function prizeList(){
        $Data['groupArr'] = parent::menu();        
        $Data['page_title'] = "Prize requests sent for students";
        $sData = $this->session->userdata('user_details');
        $Data['role_id'] = intval($sData['role_id']);
        $affiliateID =  intval($sData['user_id']);
        if($sData['role_id'] == 1){
            $Data['students_list'] = $this->prize_model->getPrizeDetails();
        }else{            
            $Data['students_list'] = $this->prize_model->getPrizeDetails([],false,$affiliateID);  
        }  
        $Data['load_page'] = "toppers/student_prize_list";
        $this->load->view("kernel", $Data);
    }

    public function editPrizeMasterModal($id){
        $Data['details'] = $this->prize_model->getPrizeDetailsById($id);           
        $this->load->view("content/toppers/edit_prizemaster_modal", $Data);
    }

    public function editPrizeMaster(){
        $this->form_validation->set_rules('inputUserStatus', 'Satus', 'required');
        if ($this->form_validation->run() == TRUE ){
            $postArr['id'] = $this->input->post('id');
            $postArr['status'] = $this->input->post('inputUserStatus');
            $postArr['comments'] = $this->input->post('statusComment');
            
            if($this->prize_model->updateData($postArr))
            {
                $from_email = "info@bkzquiz.com";                
                $to_email = $this->input->post('affiliateEmail');
                $this->email->set_mailtype("html");
                $this->email->from($from_email, 'BKZ Admin');
                $this->email->to($to_email);
                ($postArr['status'] === 'approved') ?  $this->email->subject('Prize approved') : $this->email->subject('Prize rejected');
                $status = ($postArr['status'] === 'approved') ? 'Approved' : 'Rejected';                
                $this->email->message('Dear '.$this->input->post('affiliateName').',<br/>Your prize for student :'.$this->input->post('studentName').' of Rs '.$this->input->post('amount').' for the period '.$this->input->post('period').' is '.$status);               
                
                //Send mail
                if($this->email->send() && $status === 'Approved'){                  
                $from_email = "info@bkzquiz.com";                
                $to_email = $this->input->post('studentEmail');
                $this->email->set_mailtype("html");
                $this->email->from($from_email, 'BKZ Admin');
                $this->email->to($to_email);    
                $this->email->subject('Congratulations!!!! for winning prize .......');
                $this->email->message('Dear '.$this->input->post('studentName').',<br/>You have won prize of Rs'.$this->input->post('amount').' for the period '.$this->input->post('period').' </br> This prize is given to you by '.$this->input->post('affiliateName'));               
                $this->session->set_flashdata('message', 'Success! Prize Details has been updated successfully.');
                }
            }
            else
            {              
                  $this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.'); 
            }
        }
        else
        {
            $this->upload->display_errors('<p>', '</p>');
            $this->session->set_flashdata('warning', 'Mandatory field can not be left blank.');
        }
        redirect( base_url('studentsPrizeList') );       
    }
   
}