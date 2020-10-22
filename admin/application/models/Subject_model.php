<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Subject_model extends CI_Model{

    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    function getSubjectCount(){
        return $this->db->count_all('subjectMaster');
    }

    function getAllSubjects($limit, $start){

        $this->db->select("*");
        $this->db->from("subjectMaster");
        $this->db->order_by('subjectID', 'ASC');
        $this->db->limit($limit, $start);

        $result = $this->db->get(); return $result->result_array();
    }

    function getSubjectDetails($subject_code){

        $this->db->select('*');
        $this->db->from('subjectMaster');
        $this->db->where( array('subjectID' => $subject_code) );
        $this->db->limit(1);

        $result = $this->db->get(); return $result->row_array();
    }

    function getAllActiveSubjects(){

        $this->db->select("*");
        $this->db->from("subjectMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('subjectID');

        $result = $this->db->get(); return $result->result_array();
    }

    function getAllActiveSubjectsForQuiz(){
        $Data['session_data'] = $this->session->userdata('user_details');
        //print_r($Data['session_data']); die;
        $userID = $Data['session_data']['user_id'];
        $userType = $Data['session_data']['user_type'];
        $sessoinstdid=$this->putprefixzerostostdids($Data['session_data']['std_id']);
        //echo $sessoinstdid; die;
        $resultSubjectID = "";
        if($userType == '' || $userType == 'T'){
            $resultSubjectID = $this->db->query("SELECT * FROM subjectMaster WHERE status='Y'");
        }else{
          // $resultSubjectID = $this->db->query("SELECT a.* FROM subjectMaster a INNER JOIN userPackageTagging b ON a.subjectID=b.subjectID WHERE a.status = 'Y' AND b.status = 'Y' AND b.userID = $userID AND FIND_IN_SET('".$sessoinstdid."', a.stdID) order By a.subjectID ASC");
            //echo "SELECT s.* FROM subjectMaster s LEFT JOIN questionbankboardmapping qbbm ON s.subjectID=qbbm.subjectID LEFT JOIN userPackageTagging upt ON s.subjectID=upt.subjectID WHERE s.status='Y', AND upt.status='Y' AND upt.userID=".$userID." AND qbbm.stdID=".$sessoinstdid.""; die;
            $resultSubjectID=$this->db->query("SELECT s.* FROM subjectMaster s LEFT JOIN questionbankboardmapping qbbm ON s.subjectID=qbbm.subjectID LEFT JOIN userPackageTagging upt ON s.subjectID=upt.subjectID WHERE s.status='Y' AND upt.status='Y' AND upt.userID=".$userID." AND qbbm.stdID=".$sessoinstdid." GROUP BY s.subjectID");
        }
        return $resultSubjectID->result_array();
    }

    function getAllActiveSubjectsForTags(){
       return $this->db->query("SELECT subject.*,GROUP_CONCAT(chapter.chapterID SEPARATOR '|~|') AS catChapterID,GROUP_CONCAT(chapter.chapterName SEPARATOR '|~|') AS catChapterName FROM chapterMaster chapter JOIN subjectMaster subject ON chapter.subjectID = subject.subjectID GROUP BY subject.subjectID")->result_array();
    }

    function insertSubject( $sDetails ){

        $sRecords = array(  'subjectName' => $sDetails['sname'],
                            'subjectDesc' => $sDetails['sdescription'],
                            'stdID'=>$sDetails['standards']
                        );

        $this->db->insert('subjectMaster', $sRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateSubject( $sDetails ){

        $sRecords = array(  'subjectName' => $sDetails['sname'],
                            'subjectDesc' => $sDetails['sdescription'],
                            'status' => $sDetails['sstatus'],
                            'stdID'=>$sDetails['standards']
                        );

        $this->db->where('subjectID', $sDetails['sid'] );
        $this->db->update('subjectMaster', $sRecords);
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
    function subjectForUser(){
      $Data['session_data'] = $this->session->userdata('user_details');
      $userID = $Data['session_data']['user_id'];
      return $this->db->query("SELECT DISTINCT sub.* FROM `userPackageTagging` pack JOIN subjectMaster sub ON pack.subjectID=sub.subjectID WHERE pack.userID=$userID")->result_array();
    }

    public function putprefixzerostostdids($int){
        $strtoreturn='';
        for($i=0; $i<8-strlen($int); $i++){
            $strtoreturn.='0';
        }
        return $strtoreturn.$int;
    }

    public function getsubjectsbystd($param){
        $select="SELECT sm.subjectID, sm.subjectName FROM subjectMaster sm LEFT JOIN questionbankboardmapping qbbm ON sm.subjectID=qbbm.subjectID LEFT JOIN questionbank qb ON qb.qbID=qbbm.qbID WHERE qbbm.stdID=".$param['stdid']." AND qb.qbID IS NOT NULL GROUP BY sm.subjectID";
        $res=$this->db->query($select);
        return $res->result_array();
    }
}
