<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    16.08.2016
 *
**/

class Role_model extends CI_Model{

    function __construct() { 
        parent::__construct();
        $this->load->library('session');
    }

    function getRoleCount(){
        return $this->db->count_all('roleMaster');
    }

    // function getAllRoles(){

    //     $this->db->select("*");
    //     $this->db->from("roleMaster");
    //     $this->db->order_by('roleID', 'ASC');
    //     $result = $this->db->get(); 
    //     //echo $this->db->last_query();
    //     return $result->result_array();

    // }

    function getAllRoles($limit=null, $start=null){

        $this->db->select("*");
        $this->db->from("roleMaster");
        $this->db->order_by('roleID', 'ASC');
        $this->db->limit($limit, $start);
        $result = $this->db->get(); 
        //echo $this->db->last_query();
        return $result->result_array();

    }

    function getAllActiveRoles(){

        $this->db->select("*");
        $this->db->from("roleMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('roleID', 'ASC');
        $result = $this->db->get(); 
        return $result->result_array();

    }

    function getAllActiveEmployeeRoles(){

        $this->db->select("*");
        $this->db->from("roleMaster");
        $this->db->where( array('status' => 'Y','roleID <>' => '3') );
        $this->db->order_by('roleID', 'ASC');
        $result = $this->db->get(); 
        return $result->result_array();

    }

    function getRoleDetails($rID){

        $this->db->select('*');
        $this->db->from('roleMaster');
        $this->db->where( array('roleID' => $rID) );
        $this->db->limit(1);

        $result = $this->db->get(); return $result->row_array();
    }

    function insertRole( $rDetails ){
        
        $sData = $this->session->userdata('user_details');
        $now = date('Y-m-d H:i:s');

        $rRecords = array(  'roleName' => $rDetails['rname'],
                            'roleDescription' => $rDetails['rdescription'],
                            'createdAt' => $now,
                            'updatedAt' => $now,
                            'createdBy' => $sData['user_id'],
                            'lastUpdatedBy' => $sData['user_id']
                        );

        $this->db->insert('roleMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateRole( $rDetails ){
        $sData = $this->session->userdata('user_details');
        $now = date('Y-m-d H:i:s');

        $rRecords = array( 'roleName' => $rDetails['rname'],
                            'roleDescription' => $rDetails['rdescription'],
                            'updatedAt' => $now,
                            'lastUpdatedBy' => $sData['user_id'],
                            'status' => $rDetails['rstatus']
                        );

        $this->db->where('roleID', $rDetails['rid'] );
        $this->db->update('roleMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}
