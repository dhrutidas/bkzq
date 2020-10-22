<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
  * @author  Krishna Gupta
 * @date    21.08.2016
 *
**/

class Change_password_model extends CI_Model{

    function __construct() { 
        parent::__construct();
        $this->load->library('session');
    }

    function account_check($rDetails){
        $sData = $this->session->userdata('user_details');

        $whrArr = array('emailID' => $sData['email_id'], 'password' => MD5($rDetails['oldPassword']), 'status' => 'Y');
        $this->db->select('*');
        $this->db->from('userMaster');
        $this->db->where($whrArr);
        
        $result = $this->db->get();
        return ( $result->num_rows() > 0 ) ? TRUE : FALSE;        
    }

    function updatePassword( $rDetails ){

        $sData = $this->session->userdata('user_details');

        $this->db->where('emailID', $sData['email_id']);
        $this->db->update('userMaster', array('password' => MD5($rDetails['newPassword'])));
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}
