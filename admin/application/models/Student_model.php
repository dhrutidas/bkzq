<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Student_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}

	function getUserCount()
	{

		$this->db->where('roleID', '3');
		//$this->db->where('status'=>'Y');
		//$this->db->where('userPackageType !=','T');
		$num_rows = $this->db->count_all_results('userMaster');
		//echo $this->db->last_query(); die;
		return $num_rows;
	}

	function getUserCountLoggedInToday()
	{

		$dayStart = date("Y-m-d") . " 00:00:00";
		$dayEnd = date("Y-m-d") . " 23:59:59";
		$num_rows = $this->db->query("SELECT COUNT(*) AS `numrows` FROM `userMaster` WHERE `roleID` = '3' AND `status` = 'Y' AND `userPackageType` != 'T' AND `lastLoginTime`  BETWEEN '$dayStart' AND '$dayEnd' ")->result_array();
		return $num_rows[0]['numrows'];
	}

	function getUserCountAddedDate($roleId)
	{
		$this->db->select("count(userID),createdAt");
		$this->db->from("userMaster");
		$this->db->group_by('userID');
		$this->db->where(array('status' => 'Y', 'roleID' => $roleId));
		$this->db->order_by('createdAt', 'desc');
		$this->db->limit(30);
		$result = $this->db->get();
		return $result->result_array();
	}

	function getAllStudents($limit = null, $start = null)
	{
		$this->db->select("a.*,b.roleName,c.activatedOn");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->join('userPackageTagging c', 'c.userID=a.userID', 'left');
		$this->db->where(array('a.roleID=' => '3'));
		$this->db->group_by('a.userID');
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
		$this->db->where(array('a.status' => 'Y'));
		$this->db->order_by('userID', 'ASC');
		$result = $this->db->get();
		return $result->result_array();
	}


	function getStudentDetails($uID)
	{
		$this->db->select("a.*,b.roleName,c.boardName,d.schoolName,e.stdName");
		$this->db->select("CONCAT(a2.fName, ' ', a2.lName) as affiliateName", false);
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->join('boardMaster c', 'a.boardID = c.boardID', 'inner');
		$this->db->join('schoolMaster d', 'a.schoolID = d.schoolID', 'inner');
		$this->db->join('classMaster e', 'a.stdID = e.stdID', 'inner');
		$this->db->join('userMaster a2', 'a.affiliateStudentMapping = a2.userID', 'left');
		$this->db->where(array('a.userID' => $uID));
		$this->db->limit(1);
		$result = $this->db->get();
		//echo $this->db->last_query();
		return $result->row_array();
	}

	function insertEmployee($eDetails)
	{
		$sData = $this->session->userdata('user_details');
		$now = date('Y-m-d H:i:s');
		$eRecords = array(
			'fName' => $eDetails['fName'],
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
			'affiliateStudentMapping' => $eDetails['affiliateID'] ? $eDetails['affiliateID'] : Null,
			'loginCount' => 0
		);

		$this->db->insert('userMaster', $eRecords);

		$status = ($this->db->affected_rows() === 1) ? TRUE : FALSE;
		return array(
			'insertID' => $this->db->insert_id(),
			'status' => $status
		);

		//return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
	}

	function insertAffiliate($eDetails)
	{
		$sData = $this->session->userdata('user_details');
		$now = date('Y-m-d H:i:s');
		$eRecords = array(
			'fName' => $eDetails['fName'],
			'lName' => $eDetails['lName'],
			'contactNumber' => $eDetails['contactNumber'],
			'residenceAdd' => $eDetails['residenceAdd'],
			'emailID' => $eDetails['emailID'],
			'password' => md5($eDetails['inputAffPassword']),
			'roleID' => $eDetails['roleID'],
			'additionalInfo' => $eDetails['additionalInfo'],
			'createdAt' => $now,
			'userPackageType' => "",
			//'birthDate' => $eDetails['birthDate'],
			//'parentID' => $eDetails['parentID'],
			//'isAffiliateUser' => $eDetails['isAffiliateUser'],
			'loginCount' => 0
		);

		$this->db->insert('userMaster', $eRecords);

		$status = ($this->db->affected_rows() === 1) ? TRUE : FALSE;
		return array(
			'insertID' => $this->db->insert_id(),
			'status' => $status
		);
	}

	function updateEmployee($eDetails)
	{
		$eRecords = array(
			'fName' => $eDetails['fName'],
			'lName' => $eDetails['lName'],
			'contactNumber' => $eDetails['contactNumber'],
			'residenceAdd' => $eDetails['residenceAdd'],
			'roleID' => $eDetails['roleID'],
			'schoolID' => $eDetails['schoolID'],
			'boardID' => $eDetails['boardID'],
			'stdID' => $eDetails['stdID'],
			'parentName' => $eDetails['parentName'],
			'additionalInfo' => $eDetails['additionalInfo'],
			'userPackageType' => $eDetails['package'],
			'status' => $eDetails['status'],
			'profilPic' => $eDetails['profilPic']
		);

		$this->db->where('userID', $eDetails['userID']);
		$this->db->update('userMaster', $eRecords);
		//	echo $this->db->last_query();exit;

		return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
	}

	function updateAffiliate($eDetails)
	{
		$eRecords = array(
			'fName' => $eDetails['fName'],
			'lName' => $eDetails['lName'],
			'contactNumber' => $eDetails['contactNumber'],
			'residenceAdd' => $eDetails['residenceAdd'],
			'roleID' => $eDetails['roleID'],
			'additionalInfo' => $eDetails['additionalInfo'],
			'userPackageType' => $eDetails['package'],
			'status' => $eDetails['status'],
			'profilPic' => $eDetails['profilPic'],
			'affiliateStudentMapping' => $eDetails['affiliateStudentMapping']
		);

		$this->db->where('userID', $eDetails['userID']);
		$this->db->update('userMaster', $eRecords);

		return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
	}

	function activateUser($eDetails)
	{
		$eRecords = array(
			'status' => $eDetails['status'],
			'loginCount' => $eDetails['loginCount'],
			'confirmation_value' => ''
		);

		$this->db->where('confirmation_value', $eDetails['confirmation_value']);
		$this->db->update('userMaster', $eRecords);

		return ($this->db->affected_rows() === 1) ? TRUE : FALSE;
	}

	//this module for confirmation

	function getPackageCount()
	{
		$this->db->where(array('a.status=' => 'N'));
		$this->db->join('userMaster b', 'a.user_code = b.userID', 'inner');
		$this->db->join('payment_transaction c', 'a.user_code = c.userID', 'left');
		$num_rows = $this->db->count_all_results('userConfirmationMaster a');
		//echo $this->db->last_query(); die;
		return $num_rows;
	}

	function getAllConfirmPackage($limit = null, $start = null)
	{
		$this->db->select("a.*,fName,lName,paymentStatus,amount,txnid");
		$this->db->from("userConfirmationMaster a");
		$this->db->join('userMaster b', 'a.user_code = b.userID', 'inner');
		$this->db->join('payment_transaction c', 'a.user_code = c.userID', 'left');
		$this->db->where(array('a.status' => 'N'));
		$this->db->order_by('createdOn', 'desc');
		$this->db->limit($limit, $start);
		$result = $this->db->get();
		return $result->result_array();
	}

	function getConfirmPackageDetail($eID)
	{
		$this->db->select("*");
		$this->db->from("userConfirmationMaster");
		$this->db->where(array('user_code=' => $eID));
		$this->db->where(array('status' => 'N'));
		$this->db->limit(1);
		$result = $this->db->get();
		return $result->row_array();
	}

	function upgradePackage($eDetails, $affiliate = false)
	{

		if (!$affiliate) {
			$eRecords = array(
				'user_code' => $eDetails['userID'],
				'packageType' => $eDetails['package'],
				'status' => 'N',
				'subject_code' => $eDetails['selectedSubject']
			);

			$this->db->insert('userConfirmationMaster', $eRecords);
			$status = ($this->db->affected_rows() === 1) ? TRUE : FALSE;
		} else {
			$status = TRUE;
		}

		$userMasterUpdate = "UPDATE userMaster SET userPackageType = '" . $eDetails['package'] . "',updatedAt='now()', status='N' WHERE userID = '" . $eDetails['userID'] . "'";
		$query = $this->db->query($userMasterUpdate);

		return $status;
	}

	function confirmUpgradePackage($eDetails)
	{

		$userMasterUpdate = "UPDATE userMaster SET userPackageType = '" . $eDetails['package'] . "',updatedAt='now()', status='Y' WHERE userID = '" . $eDetails['userID'] . "'";
		$query = $this->db->query($userMasterUpdate);

		$confrimMasterUpdate = "UPDATE userConfirmationMaster SET status = 'Y', updatedOn = 'now()' WHERE user_code = '" . $eDetails['userID'] . "'";

		$query1 = $this->db->query($confrimMasterUpdate);

		if (isset($query) && isset($query1)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	function getStudentsWhereLike($field, $search)
	{
		$this->db->where('roleID', '3');
		$this->db->like($field, $search);
		$num_rows = $this->db->count_all_results('userMaster');
		return $num_rows;
	}

	function getAllStudentsWhereLike($limit = null, $start = null, $field, $search)
	{
		if (isset($field) && isset($search)) {
			$like = $this->db->like($field, $search);
		} else {
			$like = '';
		}

		$this->db->select("a.*,b.roleName,c.activatedOn");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->join('userPackageTagging c', 'c.userID=a.userID', 'left');
		$this->db->where(array('a.roleID=' => '3'));
		$like;
		$this->db->group_by('a.userID');
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('createdAt', 'DESC');
		$this->db->limit($limit, $start);
		$result = $this->db->get();
		return $result->result_array();
	}

	function isAffiliateUser($userID)
	{
		$this->db->select("a.isAffiliateUser");
		$this->db->from("userMaster a");
		$this->db->where(array('a.userID=' => $userID));
		$result = $this->db->get();
		return $result->result_array();
	}

	function getAffiliateDetails($uID)
	{
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where(array('a.userID' => $uID));
		$this->db->limit(1);
		$result = $this->db->get();
		//echo $this->db->last_query();
		return $result->row_array();
	}
	//create level tree
	function getAffiliateLevelsHierarchy($affiliateID)
	{
		for ($i = 0; $i < 6; $i++) {
			$this->db->select("userID,userPackageType,parentID");
			$this->db->from("userMaster a");
			$this->db->where(array('userID' => $affiliateID));
			$result = $this->db->get();
			//echo $this->db->last_query();
			$levelArr[$i] = $result->row_array();
			if ($levelArr[$i]['parentID'] > 0) {
				$affiliateID = $levelArr[$i]['parentID'];
			} else {
				break;
			}
		}
		return $levelArr;
	}

	function insertCommision($affiliateID)
	{
		$levelArr = $this->getAffiliateLevelsHierarchy($affiliateID);
		$commissionArr['B'] = array(300, 100, 50, 50, 50);
		$commissionArr['S'] = array(500, 200, 100, 100, 100);
		$commissionArr['G'] = array(1000, 300, 200, 100, 100);

		//find out the commission tree applicable
		$commission = $commissionArr[$levelArr[0]['userPackageType']];

		//apply commission based on the levels and the plans
		for ($j = 0; $j < 5; $j++) {
			$x = $j + 1;
			$userPackage = '';
			if (array_key_exists($x, $levelArr)) {
				$userPackage = $levelArr[$x]['userPackageType'];
			}

			if (($userPackage === 'B' && $x == 1) || ($userPackage === 'S' && $x <= 3)  || ($userPackage === 'G' && $x <= 5)) {
				$eRecords = array(
					'userID' => $levelArr[$x]['userID'],
					'amount' => $commission[$j],
					'affiliateID' => $levelArr[0]['userID'],
					'level' => $x,
					'createdDate' => date('Y-m-d H:i:s')
				);
			} else {
				$eRecords = array(
					'userID' => '14',
					'amount' => $commission[$j],
					'affiliateID' => $levelArr[0]['userID'],
					'level' => $x,
					'createdDate' => date('Y-m-d H:i:s')
				);
			}
			$this->db->insert('commissionMaster', $eRecords);
		}
	}

	public function getTopper($monthYear)
	{
		$monthSelected = explode('/', $monthYear);
		$sql = "SELECT (count(questionID) * orderBy) AS Marks,a.userID, CONCAT(c.fName, ' ', c.lName) AS user_name,c.profilPic as photo,DATE_FORMAT(timeStamp, '%Y-%m') as answerdate FROM userAnswerTagging a INNER JOIN stagesMaster b ON a.stageID = b.stageID
                INNER JOIN userMaster c ON a.userID = c.userID
                WHERE  ansStatus = 'Y' "; //and a.timestamp between DATE_FORMAT(NOW() ,'%Y-%m-01') AND NOW()
		if (!empty($monthYear)) {
			$sql .= ' and DATE_FORMAT(timeStamp, "%m/%Y") = "' . $monthYear . '"';
		} else {
			$sql .= ' and DATE_FORMAT(timeStamp, "%m/%Y") = "' . date('m', time()) . '/' . date('Y', time()) . '"';
		}
		$sql .= " GROUP BY a.userID  order by Marks desc limit 0 , 49";
		return $this->db->query($sql)->result_array();
	}

	function getStudentsDetails($uID)
	{
		$this->db->select("a.*,b.roleName,c.boardName,d.schoolName,e.stdName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->join('boardMaster c', 'a.boardID = c.boardID', 'inner');
		$this->db->join('schoolMaster d', 'a.schoolID = d.schoolID', 'inner');
		$this->db->join('classMaster e', 'a.stdID = e.stdID', 'inner');
		$this->db->where_in('a.userID', $uID);
		//$this->db->limit(1);
		$result = $this->db->get();
		//echo $this->db->last_query();
		return $result->result_array();
	}
}
