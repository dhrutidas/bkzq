<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }

class Prize_model extends CI_Model{
    function __construct() { parent::__construct(); }

    function getPrizeDetails($studentID='', $period = false, $affiliateId = ''){
        $this->db->select("pm.*");
        $this->db->select("CONCAT(u1.fName, ' ', u1.lName) as affiliateName", false);
        $this->db->select("CONCAT(u2.fName, ' ', u2.lName) as studentName", false);
        $this->db->from("prizeMaster pm");
        $this->db->join('userMaster u1','pm.affiliateId=u1.userID','left');
        $this->db->join('userMaster u2','pm.studentId=u2.userID','left');
        if($studentID){
            $this->db->where_in("studentID", $studentID);
        }        
        if($affiliateId){
            $this->db->where("affiliateID", $affiliateId);
        }
        if($period){
            $this->db->where("period", date('m', time()).'/'.date('Y', time()));
        }       
        $result = $this->db->get();
        return $result->result_array();
    }

    function getPrizeFlag(){
        $this->sData = $this->session->userdata('user_details'); 
        $this->db->select("pm.*");
        $this->db->from("prizeMaster pm");        
        $this->db->where("period", date('m', time()).'/'.date('Y', time()));
        $this->db->where('affiliateID',intval($this->sData['user_id']));
        $result = $this->db->get();
        return $result->result_array();
    }

    function insertPrize($data){
        $this->db->insert('prizeMaster', $data);
    }
    
    function getPrizeDetailsById($id){
        $this->db->select("pm.*");
        $this->db->select("CONCAT(u1.fName, ' ', u1.lName) as affiliateName, u1.emailID as affiliateEmail", false);
        $this->db->select("CONCAT(u2.fName, ' ', u2.lName) as studentName, u2.emailID as studentEmail", false);
        $this->db->from("prizeMaster pm");
        $this->db->join('userMaster u1','pm.affiliateId=u1.userID','left');
        $this->db->join('userMaster u2','pm.studentId=u2.userID','left');        
        $this->db->where("id", $id);
        $result = $this->db->get();
        return $result->row_array();
    }

    function updateData($eDetails){
        $eRecords = array(  'status' => $eDetails['status'],
							'comments' => $eDetails['comments']							
			    );
		$this->db->where('id', $eDetails['id'] );
		$this->db->update('prizeMaster', $eRecords);
		return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function prizesGiven($affiliateId){
        $this->db->select("sum(amount) as Amount");      
        $this->db->from("prizeMaster");       
        $this->db->where("affiliateID", $affiliateId);
        $this->db->where_in("status", array('approved','pending') );
        $result = $this->db->get();
        return $result->row_array();
    }
}