<?php if (! defined('BASEPATH')){ exit('No direct script access allowed'); }

class Affiliate_student_mapping_model extends CI_Model{

    function __construct() { parent::__construct();
        $this->sData = $this->session->userdata('user_details'); 
    }

    function insertStudentAffiliate($details ){
        $now = date("Y-m-d H:i:s");
        $records = array(  
                            'affiliate_id ' => $details['affiliate_id'],
                            'student_id' => $details['student_id'],
                            'created' => $now
                        );

        $this->db->insert('affiliateStudentMappping', $records);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function getCode($userId){
        //echo $userId=str_pad($userId, 8, '0', STR_PAD_LEFT);exit;
        $userId = ltrim($userId, '0');
        $this->db->select("code");
        $this->db->from("affiliateCode");
        $this->db->where( array('affiliateId' => $userId,'status' => 1) );
        $result = $this->db->get(); 
        $data = $result->result_array();
        //print_r($data);exit;        
        return $data[0]['code'];
    }

    function getAllStudents(){
        $this->db->select("a.*");
		$this->db->from("userMaster a");
		$this->db->join('affiliateStudentMappping b', 'a.userID = b.student_id', 'inner');
		$this->db->order_by('created', 'desc');
		$result = $this->db->get();
		return $result->result_array();
    }
  
}