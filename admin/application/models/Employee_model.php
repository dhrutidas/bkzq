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
		$this->table = 'userMaster';
		$this->load->library('session');
		 // Set orderable column fields
		 $this->column_order = array(null, 'fName','lName','emailID','contactNumber','status');
		 // Set searchable column fields
		 $this->column_search = array( 'fName','lName','emailID','contactNumber');
		 // Set default order
		 $this->order = array('createdAt' => 'desc');
	}

	public function getRows($postData){
        $this->_get_datatables_query($postData);
        if($postData['length'] != -1){
            $this->db->limit($postData['length'], $postData['start']);
		}
		
		$query = $this->db->get();
        return $query->result();
    }
	/*
	* Count all records
	*/
	public function countAll(){
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}
	  /*
     * Count records based on the filter params
     * @param $_POST filter data based on the posted parameters
     */
    public function countFiltered($postData){
        $this->_get_datatables_query($postData);
        $query = $this->db->get();
		return $query->num_rows();
		
    }
	/*
     * Perform the SQL queries needed for an server-side processing requested
     * @param $_POST filter data based on the posted parameters
     */
    private function _get_datatables_query($postData){
         
       // $this->db->from($this->table);
		$roles = array(3,8);
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where_not_in('a.roleID', $roles);
        $i = 0;
        // loop searchable columns 
        foreach($this->column_search as $item){
            // if datatable send POST for search
            if($postData['search']['value']){
                // first loop
                if($i===0){
                    // open bracket
                    $this->db->group_start();
                    $this->db->like($item, $postData['search']['value']);
                }else{
                    $this->db->or_like($item, $postData['search']['value']);
                }
                
                // last loop
                if(count($this->column_search) - 1 == $i){
                    // close bracket
                    $this->db->group_end();
                }
            }
            $i++;
        }
         
        if(isset($postData['order'])){
            $this->db->order_by($this->column_order[$postData['order']['0']['column']], $postData['order']['0']['dir']);
        }else if(isset($this->order)){
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	function getUserCount(){
		$roles = array(3,8);
        $this->db->where_not_in('roleID', $roles);
		$num_rows = $this->db->count_all_results('userMaster');
		return $num_rows;
    }

    function getEmployeeCountByEmailid($emailID){
        $this->db->where(array('emailID=' => $emailID));
		$num_rows = $this->db->count_all_results('userMaster');
		return $num_rows;
    }

	function getEmployeeCountByPhone($phone){
        $this->db->where(array('contactNumber=' => $phone));
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
		$roles = array(3,8);
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where_not_in('a.roleID', $roles);
		$this->db->order_by('userID', 'ASC');
		$this->db->limit($limit, $start);
		$result = $this->db->get();
		return $result->result_array();
	}

	function getAllUsersRestrictedRoleWise($limit=null, $start=null)
	{
		$roles = array(3,8);
		$sData = $this->session->userdata('user_details');
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where_not_in('a.roleID', $roles);
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
				// echo $this->db->last_query();exit;
		return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
	}

	function updateProfile( $eDetails )
	{
		$eRecords = array(  'fName' => $eDetails['fName'],
							'lName' => $eDetails['lName'],
							'residenceAdd' => $eDetails['residenceAdd'],
							'additionalInfo' => $eDetails['inputDesc'],
							
			    );

		$this->db->where('userID', $eDetails['userID'] );
		$this->db->update('userMaster', $eRecords);
				// echo $this->db->last_query();exit;
		return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
	}

		function updateEmployeeDisplayPic( $eDetails )
		{
			$query = $this->db->query("UPDATE userMaster SET profilPic='".$eDetails['profilPic']."' WHERE userID='".$eDetails['userID']."'");
			return ( $query ) ? TRUE : FALSE;
		}

		function getUsersWhereLike($field, $search)
    {
			$roles = array(3,8);
		$this->db->where_not_in('roleID', $roles);
		$this->db->like($field, $search);
		$num_rows = $this->db->count_all_results('userMaster');			
		return $num_rows;
	}
	
	function getAllUsersWhereLike($limit=null, $start=null,$field, $search)
	{
		if(isset($field) && isset($search)){
			$like = $this->db->like($field, $search);
		}else{
			$like ='';
		}
		$roles = array(3,8);
		$this->db->select("a.*,b.roleName");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->where_not_in('a.roleID', $roles);
		$like;
		$this->db->order_by('userID', 'ASC');		
		$this->db->limit($limit, $start);
		$result = $this->db->get();
		return $result->result_array();
	}
}
