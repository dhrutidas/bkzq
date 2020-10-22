<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.03.2017
 *
**/

class Package_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getActivePackageSubject($uID){
        $this->db->select("*");
        $this->db->from("userPackageTagging");
        $this->db->where( array('status' => 'Y','userID' => $uID) );
        $this->db->order_by('activatedOn', 'DESC');
        $result = $this->db->get();
        //echo $this->db->last_query();
        return $result->result_array();
    }
    function insertPackageSubjectNew($data)
    {

		$tagging = 'INSERT INTO `userPackageTagging`(`userID`, `subjectID`, `activatedOn`, `status`) VALUES ';

			$packageSubject = explode(',',$data['selectedSubject']);
            foreach($packageSubject as $subject){
                  $tagging .= "(".$data['userID'].",'".$subject."',now(),'Y') ,";
                }
		$taggingQuery = rtrim($tagging, ",");
        $query = $this->db->query($taggingQuery);

    }
    function insertPackageSubject($data)
    {

		$tagging = 'INSERT INTO `userPackageTagging`(`userID`, `subjectID`, `activatedOn`, `status`) VALUES ';

			$packageSubject = explode('#',$data['selectedSubject']);
            foreach($packageSubject as $subject){
                  $tagging .= "(".$data['userID'].",'".$subject."',now(),'Y') ,";
                }
		$taggingQuery = rtrim($tagging, ",");
        $query = $this->db->query($taggingQuery);

    }

    function updatePackageSubject($data)
    {
        $data1 = array('deactivatedOn'=>date('Y-m-d H:i:s'),'status'=>'N');
        $this->db->where( array('status' => 'Y','userID' => $data['userID']) );
        $desctivation_query = $this->db->update('userPackageTagging',$data1);
        if($desctivation_query){
            $tagging = 'INSERT INTO `userPackageTagging`(`userID`, `subjectID`, `activatedOn`, `status`) VALUES ';
            $packageSubject = explode('#',$data['selectedSubject']);
            foreach($packageSubject as $subject){
                  $tagging .= "(".$data['userID'].",'".$subject."',now(),'Y') ,";
                }
            $taggingQuery = rtrim($tagging, ",");
            $query = $this->db->query($taggingQuery);
            return $query;
        }

    }

  function insertStudentSubject($data)
    {

		$tagging = 'INSERT INTO `userPackageTagging`(`userID`, `subjectID`, `activatedOn`,`deactivatedOn`, `status`) VALUES ';

			$packageSubject = explode('#',$data['selectedSubject']);
            foreach($packageSubject as $subject){
                  $tagging .= "(".$data['userID'].",'".$subject."',now(), DATE_ADD(curdate(), INTERVAL 1 YEAR),'Y') ,";
                }
		$taggingQuery = rtrim($tagging, ",");
        $query = $this->db->query($taggingQuery);

    }	
}
