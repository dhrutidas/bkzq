<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 * 
 * @author  Krishna Gupta
 * @date    13.08.2016
 * 
**/

class Login_model extends CI_Model{
    
    function __construct() { parent::__construct(); }

    function register_user(){
        
        $insArr = array('name' => $this->content['post_name'],
                        'email' => $this->content['post_email'], 
                        'contact' => $this->content['post_contact'], 
                        'activation_key' => $this->content['activation_key']);
        
        $this->db->insert('registrations', $insArr);
        
        return ( $this->db->affected_rows() === 1 ) ? $this->db->insert_id() : FALSE;
    }
    
    function registration_check(){
        
        $whrArr = array('rID' => $this->content['get_token'], 
                        'activation_key' => $this->content['get_key'], 
                        'status' => 'N');
        
        $this->db->select('*');
        $this->db->from('registrations');
        $this->db->where($whrArr);
        
        $result = $this->db->get();
        
        return ( $result->num_rows() > 0 ) ? $result->row_array() : FALSE;
    }
    
    function activate_user(){
        
        $insArr = array('user_role' => '1',
                        'user_name' => $this->content['db_name'],
                        'user_email' => $this->content['db_email'],
                        'user_pass' => md5( $this->content['db_pass']),
                        'user_contact' => $this->content['db_contact']);
        
        $this->db->insert('users', $insArr);
        
        if( $this->db->affected_rows() === 1 ){
            
            $this->db->where('rID', $this->content['db_rID']);
            $this->db->update('registrations',array('status' => 'Y'));
            
            return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
        }
        else{ return FALSE; }        
    }
    
    function account_check(){
        
        $whrArr = array('emailID' => $this->content['post_username'], 
                        'password' => md5($this->content['post_pass']), 
                        'status' => 'Y');
        
        $this->db->select('*');
        $this->db->from('userMaster');
        $this->db->where($whrArr);
        
        $result = $this->db->get();
        
        return ( $result->num_rows() > 0 ) ? $result->row_array() : FALSE;        
    }
        
    function updateLoginDetails($dID){
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $now = date('Y-m-d H:i:s');
                
        $this->db->set('loginCount', 'loginCount + 1', FALSE);
        $this->db->where('userID', $dID);
        $this->db->update('userMaster', array('lastLoginIp' => $ip, 'lastLoginTime' => $now));
        
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
}