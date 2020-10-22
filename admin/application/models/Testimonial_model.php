<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Surya Tiwari
 * @date    22.03.2017
 *
**/
class Testimonial_model extends CI_Model{
    function __construct() { parent::__construct(); }
    function getAllActiveTestimonial(){
        $this->db->select("*");
        $this->db->from("testimonial");
        $this->db->where('status', 'Y');
        $this->db->order_by('createdAt', 'ASC');
        $result = $this->db->get();
        return $result->result_array();
    }function getAllTestimonial(){
        $this->db->select("*");
        $this->db->from("testimonial");
        $this->db->order_by('createdAt', 'ASC');
        $result = $this->db->get();
        return $result->result_array();
    }
    function getTestimonialDetails($id){
        $this->db->select("*");
        $this->db->from("testimonial");
        $this->db->where('id', $id);
        $result = $this->db->get();
        return $result->result_array();
    }
    function insertTestimonial( $sDetails ){
        $sRecords = array(  'name' => $sDetails['tName'],'message' => $sDetails['tMsg']);
        $this->db->insert('testimonial', $sRecords);
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
    function updateTestimonial( $sDetails ){
        $sRecords = array( 'name' => $sDetails['tName'],'message' => $sDetails['tMsg'],'status'=> $sDetails['tStatus']);
        $this->db->where('id', $sDetails['tid'] );
        $this->db->update('testimonial', $sRecords);
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}
