<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    06.09.2016
 *
**/

class Student_model extends CI_Model{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

	function getUserCount(){
        $this->db->where(array('roleID=' => '3'));
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

	function getAllStudents($limit=null, $start=null)
	{
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where(array('a.roleID=' => '3'));
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('createdAt', 'DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get();
		return $result->result_array();
	}

	function getAllActiveStudents()
	{
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where(array('a.roleID=' => '3'));
		$this->db->where( array('a.status' => 'Y') );
		$this->db->order_by('userID', 'ASC');
		$result = $this->db->get();
		return $result->result_array();
	}


	function getStudentDetails($uID)
	{
		$this->db->select("a.*,b.roleName,c.boardName,d.schoolName,e.stdName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->join('boardMaster c', 'a.boardID = c.boardID', 'inner');
		$this->db->join('schoolMaster d', 'a.schoolID = d.schoolID', 'inner');
		$this->db->join('classMaster e', 'a.stdID = e.stdID', 'inner');
		$this->db->where( array('a.userID' => $uID) );
		$this->db->limit(1);
		$result = $this->db->get();
		//echo $this->db->last_query();
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
							'schoolID' => $eDetails['schoolID'],
							'boardID' => $eDetails['boardID'],
							'stdID' => $eDetails['stdID'],
							'parentName' => $eDetails['parentName'],
							'additionalInfo' => $eDetails['additionalInfo'],
							'createdAt' => $now,
							'userPackageType' => $eDetails['package'],
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
							'schoolID' => $eDetails['schoolID'],
							'boardID' => $eDetails['boardID'],
							'stdID' => $eDetails['stdID'],
							'parentName' => $eDetails['parentName'],
							'additionalInfo' => $eDetails['additionalInfo'],
							//'confirmation_value' => $eDetails['confirmation_value'],
							'userPackageType' => $eDetails['package'],
							'status' => $eDetails['status'],
							'profilPic' => $eDetails['profilPic']
			    );

		$this->db->where('userID', $eDetails['userID'] );
		$this->db->update('userMaster', $eRecords);

		return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
	}

	function activateUser( $eDetails )
	{
		$eRecords = array(
							'status' => $eDetails['status'],
							'loginCount' => $eDetails['loginCount'],
							'confirmation_value' => ''
			    );

		$this->db->where('confirmation_value', $eDetails['confirmation_value'] );
		$this->db->update('userMaster', $eRecords);

		return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
	}

//this module for confirmation

	function getPackageCount(){
    $this->db->where(array('status=' => 'N'));
		$num_rows = $this->db->count_all_results('userConfirmationMaster');
		return $num_rows;
    }

	function getAllConfirmPackage()
	{
		$this->db->select("a.*,fName,lName,paymentStatus,amount,txnid");
		$this->db->from("userConfirmationMaster a");
		$this->db->join('userMaster b', 'a.user_code = b.userID', 'inner');
		$this->db->join('payment_transaction c', 'a.user_code = c.userID', 'left');
		$this->db->where( array('a.status' => 'N') );
		$this->db->order_by('createdOn', 'desc');
		$result = $this->db->get();
		//echo $this->db->last_query();
		return $result->result_array();
	}

	function getConfirmPackageDetail($eID)
	{
		$this->db->select("*");
		$this->db->from("userConfirmationMaster");
		$this->db->where(array('user_code=' => $eID));
		$this->db->where( array('status' => 'N') );
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->row_array();
	}

	function upgradePackage( $eDetails ){

		$eRecords = array(  'user_code' => $eDetails['userID'],
							'packageType' => $eDetails['package'],
							'status' => 'N',
							'subject_code' => $eDetails['selectedSubject']
						);

		$this->db->insert('userConfirmationMaster', $eRecords);

		$status = ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
		return $status;

	}

	function confirmUpgradePackage( $eDetails ){

		$userMasterUpdate = "UPDATE userMaster SET userPackageType = '".$eDetails['package']."',updatedAt='now()' WHERE userID = '".$eDetails['userID']."'";
		$query = $this->db->query($userMasterUpdate);

		$confrimMasterUpdate = "UPDATE userConfirmationMaster SET status = 'Y', updatedOn = 'now()' WHERE user_code = '".$eDetails['userID']."'";

		$query1 = $this->db->query($confrimMasterUpdate);

		if ( isset($query) && isset($query1) ){
			return TRUE;
		}else{
			return FALSE;
		}

	}


}
