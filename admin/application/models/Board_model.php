<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Board_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getBoardCount(){
        return $this->db->count_all('boardMaster');
    }

    function getAllBoards($limit, $start){
        $this->db->select("*");
        $this->db->from("boardMaster");
        $this->db->order_by('boardID', 'ASC');
        $this->db->limit($limit, $start);
        $result = $this->db->get(); return $result->result_array();
    }

    function getAllActiveBoards(){

        $this->db->select("*");
        $this->db->from("boardMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('boardID');
    
        $result = $this->db->get(); return $result->result_array();
    }

    function getBoardDetails($dID){
        $this->db->select('*');
        $this->db->from('boardMaster');
        $this->db->where( array('boardID' => $dID));
        $this->db->limit(1);
        $result = $this->db->get();
	    return $result->row_array();
    }

    function insertBoard( $dDetails ){

        $dRecords = array( 'boardName' => $dDetails['dname'],
                            'boardDesc' => $dDetails['ddescription']
                        );

        $this->db->insert('boardMaster', $dRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateBoard( $dDetails ){

        $rRecords = array(  'boardName' => $dDetails['dname'],
                            'status' => $dDetails['dstatus'],
                            'boardDesc' => $dDetails['ddescription'] );

        $this->db->where('boardID', $dDetails['did'] );
        $this->db->update('boardMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}
