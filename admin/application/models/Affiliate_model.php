<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }

class Affiliate_model extends CI_Model{

    function __construct() { parent::__construct();
        $this->sData = $this->session->userdata('user_details'); 
    }

    function getCommision($limit, $start, $id = 0){        
        if($id == 0){
            $sData = $this->sData; 
            $user= intval($sData['user_id']);		
        }else{
            $user= intval($id);	
        }	
        $this->db->select("cm.*,um.fname");
        $this->db->from("commissionMaster cm");
        $this->db->join('userMaster um', 'cm.affiliateID = um.userID');
        $this->db->where(array('cm.userID' => $user, 'um.status' => 'Y'));
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $result = $this->db->get();        
         return $result->result_array();
    }

    function getCommissionCount($id = 0){
        if($id == 0){
            $sData = $this->sData; 
            $user= intval($sData['user_id']);		
        }else{
            $user= intval($id);	
        }		
        $this->db->select("cm.id");
        $this->db->join('userMaster um', 'cm.affiliateID = um.userID');
        $this->db->where(array('cm.userID' => $user, 'um.status' => 'Y'));
        return $this->db->count_all_results('commissionMaster cm');
    }

    function getCommissionTotal($id = 0){
        if($id == 0){
            $sData = $this->sData; 
            $user= intval($sData['user_id']);		
        }else{
            $user= intval($id);	
        }

        $this->db->select("sum(cm.amount) as commission");
        $this->db->from('commissionMaster cm');
        $this->db->join('userMaster um', 'cm.affiliateID = um.userID');
        $this->db->where(array('cm.userID' => $user,'um.status'=>'Y'));
        $result = $this->db->get();        
        return $result->row_array();
    }

    function affiliateTree($id){
        if($id > 0){
            $userDetails = $this->employee_model->getEmployeeDetails($id);
            $user= intval($userDetails['userID']);		
            $parent[0]['id']=$user;
      $parent[0]['name']=$userDetails['fName'];
      $parent[0]['lname']=$userDetails['lName'];
      $parent[0]['pic']= $userDetails['profilPic'] ? base_url().'assets/images/profile_pic/'.$userDetails['profilPic'] : '';
            $parent[0]['parentId']=null;
        }else{
            $sData = $this->session->userdata('user_details'); 
            $user= intval($sData['user_id']);		
            $parent[0]['id']=$user;
      $parent[0]['name']=$sData['user_first_name'];
      $parent[0]['lname']=$sData['user_last_name'];
      $parent[0]['pic']= $sData['profile_pic'] ? base_url().'assets/images/profile_pic/'.$sData['profile_pic'] : '';
            $parent[0]['parentId']=null;
        }			
        
        $hierarchyObject = array_merge($this->getAllChildrens($user), $parent );
        
              for($i=1;$i< 20; $i++){		
                  foreach($hierarchyObject as $val){
                      $users[]=$val['id'];
                  }
        $childrens = $this->getAllChildrens(array_unique($users));      
        if(count($childrens) > 0){
          array_push($hierarchyObject, ...$childrens);
        }			
              }
              $no_duplicates = array_intersect_key( $hierarchyObject , array_unique( array_map('serialize' , $hierarchyObject ) ) );
              $no_duplicates = array_values($no_duplicates);
              return json_encode($no_duplicates);
      }	
  
      function getAllChildrens($users){		
                  $this->db->select("CAST(userID AS UNSIGNED) as id,parentId, fName as name,lName as lName, profilPic as pic ");
                  $this->db->from("userMaster a");
                  if(is_array($users)){
                      $this->db->where_in('parentID', $users);
                  }else{
                      $this->db->where(array('parentID'=>$users));
                  }			
                  $this->db->where('status', 'Y');	
                  $result = $this->db->get();
              
                  $levelArr=$result->result_array();	
                  for($y=0;$y < count($levelArr);$y++){
                      if($levelArr[$y]['pic']){						
                          $levelArr[$y]['pic'] = base_url().'assets/images/profile_pic/'.$levelArr[$y]['pic'];
                      }
                  }
          
          return $levelArr;		
      }
     
      function getAllActiveAffiliates(){
        $this->db->select("um.*");
        $this->db->from('userMaster um');
        $this->db->where('um.isAffiliateUser','Y');
        $this->db->where('um.status','Y');
        $result = $this->db->get();
        return $result->result_array();        
      }

      function getPaidTotal(){
        $sData = $this->sData; 
        $user= intval($sData['user_id']);		
        $this->db->select("sum(wm.amountPaid) as amountPaid");
        $this->db->from('withdrawalMaster wm');
        $this->db->join('userMaster um', 'wm.affiliateID = um.userID');
        $this->db->where('wm.affiliateID',$user);
        $result = $this->db->get();        
        return $result->row_array();
    }

    function updateWithdrawalRequestLog($userDetails){
        $insArr = array('affiliateID' => $userDetails['id'],
        'amountRequested' => $userDetails['amountRequested'],
        'message' => $userDetails['message'],
        'requestedDate' => $userDetails['requestedDate']);

$this->db->insert('withdrawalMaster', $insArr);

return ( $this->db->affected_rows() === 1 ) ? $this->db->insert_id() : FALSE;
    }

    function checkPendingWithdrawalRequest(){
        $sData = $this->sData; 
        $user= intval($sData['user_id']);		
        $this->db->select("id");
        $this->db->from('withdrawalMaster wm');
        $this->db->join('userMaster um', 'wm.affiliateID = um.userID');
        $this->db->where('wm.affiliateID',$user);
        $this->db->where('wm.amountPaid = 0');
        $result = $this->db->get();        
        //echo $this->db->last_query();
        return $result->row_array();
    }

    function getAffiliatesWithdrawalReqCount(){
        return $this->db->count_all('withdrawalMaster');
    }

    function getAffiliateRequests($limit, $start){
        $this->db->select("wm.*,um.fName,um.lName");
        $this->db->from("withdrawalMaster wm");
        $this->db->join('userMaster um', 'wm.affiliateID = um.userID');
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit, $start);
        $result = $this->db->get(); return $result->result_array();
    }

    function getPaymentDetailsById($dID){
        $this->db->select('*');
        $this->db->from('withdrawalMaster');
        $this->db->where( array('id' => $dID));
        $this->db->limit(1);
        $result = $this->db->get();
	    return $result->row_array();
    }
    function getPaymentDetailsByUser($dID){
        $this->db->select('sum(amountPaid) as amountPaid');
        $this->db->from('withdrawalMaster');
        $this->db->where( array('affiliateID' => $dID));
        $result = $this->db->get();
        //return $this->db->last_query();
	    return $result->row_array();
    }

    function updateWithdrawlMaster( $dDetails ){

        $rRecords = array(  'amountPaid' => $dDetails['amountPaid'],
                            'paymentDate' => $dDetails['paymentDate'],
                            'paymentMode' => $dDetails['paymentMode'] );

        $this->db->where('id', $dDetails['id'] );
        $this->db->update('withdrawalMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function getAffiliatesWhereLike($field, $search)
    {
		$this->db->where('roleID','8');
        $this->db->like($field, $search);
        $this->db->order_by('userID', 'desc');
		$num_rows = $this->db->count_all_results('userMaster');			
		return $num_rows;
    }
    
    function getUserCount(){

		$this->db->where('roleID','8');
		//$this->db->where('status'=>'Y');
		//$this->db->where('userPackageType !=','T');
		$num_rows = $this->db->count_all_results('userMaster');
		//echo $this->db->last_query(); die;
		return $num_rows;
    }

    function getAllAffiliatesWhereLike($limit=null, $start=null,$field, $search)
	{
		if(isset($field) && isset($search)){
			$like = $this->db->like($field, $search);
		}else{
			$like ='';
		}

		$this->db->select("a.*,b.roleName,c.activatedOn");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->join('userPackageTagging c', 'c.userID=a.userID', 'left');
		$this->db->where(array('a.roleID=' => '8'));
		$like;
		$this->db->group_by('a.userID');
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('createdAt', 'DESC');
		$this->db->limit($limit, $start);
        $result = $this->db->get();

		return $result->result_array();
    }
    
    function getAllAffiliates($limit=null, $start=null)
	{
		$this->db->select("a.*,b.roleName,c.activatedOn");
		$this->db->from("userMaster a");
		$this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
		$this->db->join('userPackageTagging c', 'c.userID=a.userID', 'left');
		$this->db->where(array('a.roleID=' => '8'));
		$this->db->group_by('a.userID');
		$this->db->order_by('status', 'DESC');
		$this->db->order_by('createdAt', 'DESC');
		$this->db->limit($limit, $start);
        $result = $this->db->get();
		return $result->result_array();
    }

    function getAffiliateDetails($uID)
	{
		$this->db->select("a.*,b.roleName, CONCAT(c.fName,' ',c.lName) as studentName", FALSE);
		$this->db->from("userMaster a");
        $this->db->join('roleMaster b', 'a.roleID = b.roleID', 'inner');
        $this->db->join('userMaster c', 'a.userID = c.affiliateStudentMapping', 'left');
		$this->db->where( array('a.userID' => $uID) );
		$this->db->limit(1);
		$result = $this->db->get();
		//echo $this->db->last_query();
		return $result->row_array();
    }
    
    function mappStudent($arr){
        $this->db->where('userID', $arr['userID']);
        $this->db->update('userMaster',array('affiliateStudentMapping' => $arr['affiliateStudentMapping']));        
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function getPrizeMoney(){
        return $temp = $this->getCommissionTotal();

    }
}