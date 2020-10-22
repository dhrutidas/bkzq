<?php if (! defined('BASEPATH')){ exit('No direct script access allowed'); }

class Affiliate_code_model extends CI_Model{

    function __construct() { parent::__construct();
        $this->sData = $this->session->userdata('user_details'); 
    }

    function insertAffiliate($details ){
        $now = date("Y-m-d H:i:s");
        $records = array(  
                            'affiliateId ' => $details['affiliateId'],
                            'code' => $details['code'],
                            'status' => 1,
                            'createdAt' => $now,
                            'updatedAt' => $now
                        );

        $this->db->insert('affiliateCode', $records);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function getCode($userId){
        //echo $userId=str_pad($userId, 8, '0', STR_PAD_LEFT);exit;
        $userId = ltrim($userId, '0');
        $this->db->select("code");
        $this->db->from("affiliateCode");
        $this->db->where( array('affiliateId' => $userId,'status' => 1) );
        $result = $this->db->get(); 
        $data = $result->result_array();
        //print_r($data);exit;        
        return $data[0]['code'];
    }

    function getAffiliate($code){
        
        $this->db->select("*");
        $this->db->from("affiliateCode");
        $this->db->where( array('code' => $code,'status' => 1) );
        $result = $this->db->get(); 
		return $result->result_array();;
    }

    function getCodeCount($code){
        $this->db->where(array('code=' => $code));
		$num_rows = $this->db->count_all_results('affiliateCode');
		return $num_rows;
    }
}