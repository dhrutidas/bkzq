<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    09.09.2016
 *
**/

class Employee_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

	function getUserCount(){
        $this->db->where(array('roleID<>' => '3'));
		$num_rows = $this->db->count_all_results('userMaster');
		return $num_rows;
    }

    function getEmployeeCountByEmailid($emailID){
        $this->db->where(array('emailID=' => $emailID));
		$num_rows = $this->db->count_all_results('userMaster');
		return $num_rows;
    }

    function getUserCountByRole($roleId){
    	$this->db->where(array('status' => 'Y','roleID' => $roleId));
		$num_rows = $this->db->count_all_results('userMaster');
		return $num_rows;
    }

    function getUserCountAddedDate($roleId){
    	$this->db->select("count(userID),createdAt");
    	$this->db->from("userMaster");
    	$this->db->group_by('userID');
    	$this->db->where(array('status' => 'Y','roleID' => $roleId));
    	$this->db->order_by('createdAt', 'desc');
    	$this->db->limit(30);
		$result = $this->db->get();
		return $result->result_array();
    }

	function getAllEmployees($limit=null, $start=null)
	{
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->order_by('userID', 'ASC');
		$this->db->limit($limit, $start);
		$result = $this->db->get();
		return $result->result_array();
	}

	function getAllUsers($limit=null, $start=null)
	{
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where(array('a.roleID<>' => '3'));
		$this->db->order_by('userID', 'ASC');
		$this->db->limit($limit, $start);
		$result = $this->db->get();
		return $result->result_array();
	}


		function getAllUsersRestrictedRoleWise($limit=null, $start=null)
		{
			$sData = $this->session->userdata('user_details');
			$this->db->select("a.*,b.roleName");
			$this->db->from("userMaster a");
			$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
			$this->db->where(array('a.roleID<>' => '3'));
			if($sData['role_id'] != 1)
			$this->db->where(array('a.userID = ' =>$sData['user_id']));

			$this->db->order_by('userID', 'ASC');
			$this->db->limit($limit, $start);
			$result = $this->db->get();
			return $result->result_array();
		}

	function getAllActiveEmployees()
	{
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where( array('status' => 'Y') );
		$this->db->order_by('userID', 'ASC');
		$result = $this->db->get();
		return $result->result_array();
	}


	function getEmployeeDetails($uID)
	{
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where( array('a.userId' => $uID) );
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->row_array();
	}

	function insertEmployee( $eDetails )
	{
		$sData = $this->session->userdata('user_details');
        $now = date('Y-m-d H:i:s');
		$eRecords = array(  'fName' => $eDetails['fName'],
							'lName' => $eDetails['lName'],
							'contactNumber' => $eDetails['contactNumber'],
							'residenceAdd' => $eDetails['residenceAdd'],
							'emailID' => $eDetails['emailID'],
							'password' => md5($eDetails['password']),
							'roleID' => $eDetails['roleID'],
							'schoolID' => 1,
							'boardID' => 1,
							'stdID' => 1,
							'parentName' => $eDetails['parentName'],
							'additionalInfo' => $eDetails['additionalInfo'],
							'createdAt' => $now,
							'loginCount' => 0
						);

		$this->db->insert('userMaster', $eRecords);

		$status = ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
		return array(
			'insertID' => $this->db->insert_id(),
			'status' => $status
			);

		//return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
	}

	function updateEmployee( $eDetails )
	{
		$eRecords = array(  'fName' => $eDetails['fName'],
							'lName' => $eDetails['lName'],
							'contactNumber' => $eDetails['contactNumber'],
							'residenceAdd' => $eDetails['residenceAdd'],
							'roleID' => $eDetails['roleID'],
							'parentName' => $eDetails['parentName'],
							'additionalInfo' => $eDetails['additionalInfo'],
							'status' => $eDetails['status'],
							'profilPic' => $eDetails['profilPic']
			    );

		$this->db->where('userID', $eDetails['userID'] );
		$this->db->update('userMaster', $eRecords);

		return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
	}
}
