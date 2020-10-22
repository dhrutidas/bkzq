<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Customer_type_model extends CI_Model{
    
function __construct() { parent::__construct(); }

function getCustomerCount(){
        return $this->db->count_all('customerTypeMaster');
    }

function customer_type_details($limit, $start){
        
        $this->db->select('*');
        $this->db->from('customerTypeMaster');
        $this->db->order_by('custTypeID', 'ASC');
        $this->db->limit($limit, $start);
        $result = $this->db->get(); return $result->result_array();
    }
    
    function customer_detail_signle_record($ctypeID){
        
        $this->db->select('*');
        $this->db->from('customerTypeMaster');
        $this->db->where( array('custTypeID' => $ctypeID) );
        $this->db->limit(1);

        $result = $this->db->get(); return $result->row_array();
    }
    function insertcType($ctypedata){
        
         $cTypeRecords = array( 'levelAccess' => $ctypedata['custlevel'],
                                'custTypeName' => $ctypedata['custtypename'],
                                'custTypeDesc' => $ctypedata['custtypedescription']
                             );
        $this->db->insert('customerTypeMaster', $cTypeRecords);
        
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE; 
        
    }
    
    function updatecType($ctypedata){
        
         $cTypeRecords = array( 'levelAccess' => $ctypedata['custlevel'],
                                'custTypeName' => $ctypedata['custtypename'],
                                'custTypeDesc' => $ctypedata['custtypedescription'],
                                'status' => $ctypedata['status']
                            );
        $this->db->where('custTypeID', $ctypedata['custtypeID']);
        $this->db->update('customerTypeMaster', $cTypeRecords);
        
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE; 
        
    }
}