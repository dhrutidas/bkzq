<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    21.01.2017
 *
**/

class Chapter_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getChapterCount(){
        return $this->db->count_all('chapterMaster');
    }

    function getAllChapters($limit, $start){

        $this->db->select("a.*,b.SubjectName");
        $this->db->from("chapterMaster a");
        $this->db->join("subjectMaster b", "a.subjectID = b.subjectID");
        $this->db->order_by('chapterID', 'ASC');
        $this->db->limit($limit, $start);

        $result = $this->db->get(); return $result->result_array();
    }

    function getChapterDetails($chapter_code){

        $this->db->select('*');
        $this->db->from('chapterMaster');
        $this->db->where( array('chapterID' => $chapter_code) );
        $this->db->limit(1);

        $result = $this->db->get(); return $result->row_array();
    }

    function getAllActiveChaptersBySubject($subjectID){
      
         $this->db->select("*");
         $this->db->from("chapterMaster");
         $this->db->where(array('subjectID' => $subjectID,'status' => 'Y'));
         $this->db->order_by('chapterID');
         $result = $this->db->get(); 
         return $result->result_array();
     }
    function getAllActiveChaptersSubjectwise($subjectID){
       $Data['session_data'] = $this->session->userdata('user_details');
      // print_r($Data['session_data']); die;
        $user_id = $Data['session_data']['user_id'];
        $std_id=$Data['session_data']['std_id'];

       /* $this->db->select("*");
        $this->db->from("chapterMaster");
        $this->db->where( "status = 'Y' AND subjectID = '$subjectID' AND chapterID NOT IN (SELECT DISTINCT subjectID FROM levelStageValidation WHERE quizStatus ='Y' AND userID='$user_id')");
        $this->db->order_by('chapterID');*/
        //echo $this->db->last_query();
        $select="SELECT cm.chapterID, cm.chapterName FROM chapterMaster cm LEFT JOIN questionbankboardmapping qbbm ON cm.chapterID=qbbm.chapterID LEFT JOIN questionbank qb ON qbbm.qbID=qb.qbID WHERE cm.status='Y' AND qbbm.subjectID=".$subjectID." AND cm.chapterID NOT IN (SELECT DISTINCT subjectID FROM levelStageValidation WHERE quizStatus ='Y' AND userID='$user_id') AND qbbm.stdID=".$std_id." AND qb.qbID IS NOT NULL GROUP BY cm.chapterID";

        //echo $select; die;
        //$result = $this->db->get(); 
        $result=$this->db->query($select);
        return $result->result_array();
    }

    function getAllActiveChapters(){

        $this->db->select("*");
        $this->db->from("chapterMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('chapterName');
    
        $result = $this->db->get(); return $result->result_array();
    }

    function insertChapter( $sDetails ){

        $sRecords = array(  'chapterName' => $sDetails['cname'],
                            'chapterDesc' => $sDetails['cdescription'],
                            'subjectID'   => $sDetails['csubjectid']
                        );

        $this->db->insert('chapterMaster', $sRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateChapter( $sDetails ){

        $sRecords = array(  'chapterName' => $sDetails['cname'],
                            'chapterDesc' => $sDetails['cdescription'],
                            'status'      => $sDetails['cstatus'],
                            'subjectID'   => $sDetails['csubjectid']
                        );

        $this->db->where('chapterID', $sDetails['cid'] );
        $this->db->update('chapterMaster', $sRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function getChaptersWhereLike($field, $search)
    {		
		$this->db->like($field, $search);
		$num_rows = $this->db->count_all_results('chapterMaster');			
		return $num_rows;
	}
	
	function getAllChaptersWhereLike($limit=null, $start=null,$field, $search)
	{
		if(isset($field) && isset($search)){
			$like = $this->db->like('a.'.$field, $search);
		}else{
			$like ='';
		}
        $this->db->select("a.*,b.SubjectName");
        $this->db->from("chapterMaster a");
        $this->db->join("subjectMaster b", "a.subjectID = b.subjectID");
        $like;
        $this->db->order_by('chapterID', 'ASC');
        $this->db->limit($limit, $start);		
		$result = $this->db->get();
		return $result->result_array();
    }
    
    function getAllChapterQuestions($chapterid){      
        $this->db->select("distinct(qbm.qbID), qb.questionText");        
        $this->db->from("questionbankboardmapping qbm");
        $this->db->join("chapterMaster cm", "qbm.chapterID=cm.chapterID");
        $this->db->join('questionbank qb',"qbm.qbID=qb.qbID");
        $this->db->where('cm.chapterID',$chapterid);
        $this->db->order_by('qb.questionText');        
        $result = $this->db->get();       
		return $result->result_array();
    }

    function getAnwsers($question){
        $this->db->select("*");        
        $this->db->from("answerbank");
        $this->db->where('qbID',$question);
        $result = $this->db->get();       
		return $result->result_array();
    }

   function getAllActiveChapterNamesIdMapping(){
        $this->db->select("*");
        $this->db->from("chapterMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('chapterName');
    
        $result = $this->db->get(); 
        $chapter = $result->result_array();
        $chapterIDNames = array();
        for($i=0; $i<count($chapter);$i++){
            $chapterIDNames[$chapter[$i]['chapterID']] = $chapter[$i]['chapterName'];
        }
        return $chapterIDNames;
    }
}
