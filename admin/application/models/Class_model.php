<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Class_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getClassCount(){
        return $this->db->count_all('classMaster');
    }

    function getAllClasses($limit, $start){

        $this->db->select("*");
        $this->db->from("classMaster");
        $this->db->order_by('stdID', 'ASC');
        $this->db->limit($limit, $start);
        $result = $this->db->get(); return $result->result_array();
    }

    function getAllActiveClasses(){

        $this->db->select("*");
        $this->db->from("classMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('stdID', 'ASC');
        $result = $this->db->get(); return $result->result_array();
    }

    function getClassDetails($bID){
        $this->db->select('*');
        $this->db->from('classMaster');
        $this->db->where( array('stdID' => $bID) );
        $this->db->limit(1);
        $result = $this->db->get(); return $result->row_array();
    }

    function getAllActiveClass(){

        $this->db->select("*");
        $this->db->from("classMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('stdID');
    
        $result = $this->db->get(); return $result->result_array();
    }

    function insertClass( $bDetails ){

        $bRecords = array(  'stdName' => $bDetails['bname'],
                            'stdDesc' => $bDetails['bdesc']
                        );

        $this->db->insert('classMaster', $bRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateClass( $bDetails ){

        $bRecords = array( 'stdName' => $bDetails['bname'],
                           'stdDesc' => $bDetails['bdesc'],
                           'status' => $bDetails['bstatus']
                    );

        $this->db->where('stdID', $bDetails['bid'] );
        $this->db->update('classMaster', $bRecords);
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}
