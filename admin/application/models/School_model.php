<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    16.08.2016
 *
**/

class School_model extends CI_Model{

    function __construct() { 
        parent::__construct();
        $this->load->library('session');
    }

    function getSchoolCount(){
        return $this->db->count_all('schoolMaster');
    }

    function getAllSchools($limit, $start){

        $this->db->select("*");
        $this->db->from("schoolMaster");
        $this->db->order_by('schoolID', 'ASC');
        $this->db->limit($limit, $start);

        $result = $this->db->get(); return $result->result_array();
    }
    function getAllActiveSchools(){

        $this->db->select("*");
        $this->db->from("schoolMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('schoolID', 'ASC');

        $result = $this->db->get(); return $result->result_array();
    }

    function getSchoolDetails($rID){

        $this->db->select('*');
        $this->db->from('schoolMaster');
        $this->db->where( array('schoolID' => $rID) );
        $this->db->limit(1);

        $result = $this->db->get(); return $result->row_array();
    }

    function insertSchool( $rDetails ){
        
        $sData = $this->session->userdata('user_details');
        $now = date('Y-m-d H:i:s');

        $rRecords = array(  'schoolName' => $rDetails['sname'],
                            'schoolContactNumber' => $rDetails['sphone'],
                            'schoolAdd' => $rDetails['sadd'],
                            'emailID' => $rDetails['semail'],
                            'createdAt' => $now,
                            'updatedAt' => $now,
                            'createdBy' => $sData['user_id'],
                            'lastUpdatedBy' => $sData['user_id']
                        );

        $this->db->insert('schoolMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateSchool( $rDetails ){
        $sData = $this->session->userdata('user_details');
        $now = date('Y-m-d H:i:s');

        $rRecords = array( 'schoolName' => $rDetails['sname'],
                            'schoolContactNumber' => $rDetails['sphone'],
                            'schoolAdd' => $rDetails['sadd'],
                            'emailID' => $rDetails['semail'],
                            'updatedAt' => $now,
                            'lastUpdatedBy' => $sData['user_id'],
                            'status' => $rDetails['sstatus']
                        );

        $this->db->where('schoolID', $rDetails['sid'] );
        $this->db->update('schoolMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function getSchoolsWhereLike($field, $search)
    {		
		$this->db->like($field, $search);
		$num_rows = $this->db->count_all_results('schoolMaster');			
		return $num_rows;
    }
    
    function getAllSchoolsWhereLike($limit=null, $start=null,$field, $search)
	{
		if(isset($field) && isset($search)){
			$like = $this->db->like($field, $search);
		}else{
			$like ='';
		}
        $this->db->select("*");
        $this->db->from("schoolMaster");
        $like;
        $this->db->order_by('schoolID', 'ASC');
        $this->db->limit($limit, $start);
		$result = $this->db->get();
		return $result->result_array();
	}
}
