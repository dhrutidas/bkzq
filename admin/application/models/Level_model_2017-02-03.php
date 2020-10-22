<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Level_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getLevelCount(){
        return $this->db->count_all('levelMaster');
    }

    function getAllLevel($limit, $start){

        $this->db->select("*");
        $this->db->from("levelMaster");
        $this->db->order_by('orderBy');
        $this->db->limit($limit, $start);

        $result = $this->db->get(); return $result->result_array();
    }

    function getAllActiveLevel(){

        $this->db->select("*");
        $this->db->from("levelMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('orderBy');
    
        $result = $this->db->get(); return $result->result_array();
    }

    function getLevelDetails($rID){

        $this->db->select('*');
        $this->db->from('levelMaster');
        $this->db->where( array('levelID' => $rID) );
        $this->db->limit(1);

        $result = $this->db->get(); 
        return $result->row_array();
    }

    function insertLevel( $rDetails ){

        $rRecords = array(  'levelName' => $rDetails['level_name'],
                            'levelDesc' => $rDetails['level_desc'],
                            'orderBy' => $rDetails['level_order']
                        );

        $this->db->insert('levelMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateLevel( $rDetails ){

        $rRecords = array(  'levelName' => $rDetails['level_name'],
                            'levelDesc' => $rDetails['level_desc'],
                            'orderBy' => $rDetails['level_order'],
                            'status' => $rDetails['level_status']
                        );

        $this->db->where('levelID', $rDetails['levelID'] );
        $this->db->update('levelMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}
