<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Stage_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getStageCount(){
        return $this->db->count_all('stagesMaster');
    }

    function getAllStages($limit, $start){

        $this->db->select("*");
        $this->db->from("stagesMaster");
        $this->db->order_by('orderBy', 'ASC');
        $this->db->limit($limit, $start);

        $result = $this->db->get(); return $result->result_array();
    }

    function getAllActiveStages($stage_code){

        $this->db->select('*');
        $this->db->from('stagesMaster');
        $this->db->where( array('stageID' => $stage_code,'status' => 'Y') );
        $this->db->order_by('orderBy', 'ASC');
        
        $result = $this->db->get(); return $result->result_array();
    }

    function getAllActiveStagesByLevel($level_code = NULL){

        $this->db->select('*');
        $this->db->from('stagesMaster');
        $this->db->where( array('status' => 'Y') );
        if($level_code != NULL)
        $this->db->where_in('levelID', $level_code);

        $this->db->order_by('orderBy', 'ASC');
        
        $result = $this->db->get(); return $result->result_array();
    }

    function getActiveStagesByLevel($level_code = NULL,$lastOrderBy){

        $this->db->select('*');
        $this->db->from('stagesMaster');
        $this->db->where( array('status' => 'Y', 'orderBy >' => $lastOrderBy) );
        if($level_code != NULL)
        $this->db->where_in('levelID', $level_code);

        $this->db->order_by('orderBy', 'ASC');
        $this->db->limit(1);
        $result = $this->db->get(); return $result->row_array();
    }

    function getStageDetails($stage_code){

        $this->db->select('*');
        $this->db->from('stagesMaster');
        $this->db->where( array('stageID' => $stage_code) );
        $this->db->limit(1);

        $result = $this->db->get(); return $result->row_array();
    }

    function insertStage( $sDetails ){

        $now = date("Y-m-d H:i:s");
        $sRecords = array(  'stageName' => $sDetails['sname'],
                            'stageDesc' => $sDetails['sdescription'],
                            'levelID' => $sDetails['slevel'],
                            'maxQuestion' => $sDetails['smax'],
                            'maxQuestionAllowed' => $sDetails['smaxallow'],
                            'minPassingCriterea' => $sDetails['sminpass'],
                            'orderBy' => $sDetails['sorder'],
                            'createdAt' => $now
                        );
        $this->db->insert('stagesMaster', $sRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateStage( $sDetails ){

        $sRecords = array(  'stageName' => $sDetails['sname'],
                            'stageDesc' => $sDetails['sdescription'],
                            'levelID' => $sDetails['slevel'],
                            'maxQuestion' => $sDetails['smax'],
                            'maxQuestionAllowed' => $sDetails['smaxallow'],
                            'minPassingCriterea' => $sDetails['sminpass'],
                            'orderBy' => $sDetails['sorder'],
                            'status' => $sDetails['sstatus']
                        );

        $this->db->where('stageID', $sDetails['sid'] );
        $this->db->update('stagesMaster', $sRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}
