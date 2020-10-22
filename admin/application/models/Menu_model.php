<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class menu_model extends CI_Model{

    function __construct() { parent::__construct();
        $this->load->library('session');

    }
    function getAllApplication(){
        $sData = $this->session->userdata('user_details');

        $this->db->select('a.*,b.*');
        $this->db->from('applicationMaster a');
        $this->db->join('privilegeMaster b', 'a.app_id = b.app_id');
        $this->db->where( array('b.role_id' => $sData['role_id'],'a.app_status' => 'Y','b.app_access' => 'Y') );
        $this->db->order_by('a.group_order,a.app_order');        

        $result = $this->db->get();
        //echo $this->db->last_query();
        return $result->result_array();
    }

}
