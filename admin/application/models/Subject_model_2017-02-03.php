<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Subject_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getSubjectCount(){
        return $this->db->count_all('subjectMaster');
    }

    function getAllSubjects($limit, $start){

        $this->db->select("*");
        $this->db->from("subjectMaster");
        $this->db->order_by('subjectID', 'ASC');
        $this->db->limit($limit, $start);

        $result = $this->db->get(); return $result->result_array();
    }

    function getSubjectDetails($subject_code){

        $this->db->select('*');
        $this->db->from('subjectMaster');
        $this->db->where( array('subjectID' => $subject_code) );
        $this->db->limit(1);

        $result = $this->db->get(); return $result->row_array();
    }

    function getAllActiveSubjects(){

        $this->db->select("*");
        $this->db->from("subjectMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('subjectID');
    
        $result = $this->db->get(); return $result->result_array();
    }

    function insertSubject( $sDetails ){

        $sRecords = array(  'subjectName' => $sDetails['sname'],
                            'subjectDesc' => $sDetails['sdescription']
                        );

        $this->db->insert('subjectMaster', $sRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateSubject( $sDetails ){

        $sRecords = array(  'subjectName' => $sDetails['sname'],
                            'subjectDesc' => $sDetails['sdescription'],
                            'status' => $sDetails['sstatus']
                        );

        $this->db->where('subjectID', $sDetails['sid'] );
        $this->db->update('subjectMaster', $sRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}
