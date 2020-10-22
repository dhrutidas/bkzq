<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 * 
 * @author  Krishna Gupta
 * @date    03.09.2016
 * 
**/

class Home_model extends CI_Model{
    
    function __construct() { 
    	parent::__construct(); 
    	$this->load->library('session');
    }

    function getAllCount(){

        $this->db->select("count(userID) AS cnt,createdAt");
        $this->db->from("userMaster");
        $this->db->where("MONTH(createdAt)=MONTH(CURRENT_DATE()) AND YEAR(createdAt)=YEAR(CURRENT_DATE())");
        $this->db->group_by('DATE(createdAt)');
        $this->db->order_by('DATE(createdAt)');
        $result = $this->db->get(); 
        return $result->result_array();
    }

    function dayWiseQuestionCount(){
    	$Data['session_data'] = $this->session->userdata('user_details');
    	$userID = $Data['session_data']['user_id'];
        $this->db->select("count(qbID) AS cnt,addedOn");
        $this->db->from("questionbank");
        $this->db->where("MONTH(addedOn)=MONTH(CURRENT_DATE()) AND YEAR(addedOn)=YEAR(CURRENT_DATE()) AND addedBy='$userID'");
        $this->db->group_by('DATE(addedOn)');
        $this->db->order_by('DATE(addedOn)');
        $result = $this->db->get(); 
        //echo $this->db->last_query();
        return $result->result_array();
    }
}
