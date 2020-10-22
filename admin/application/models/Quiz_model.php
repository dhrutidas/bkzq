<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 * 
 * @author  Krishna Gupta
 * @date    03.09.2016
 * 
**/

class Quiz_model extends CI_Model{
    
    function __construct() { 
        parent::__construct();
        $this->load->library('session');
    }

    function getQuestionsDetails($qID){
    	return $this->db->query("SELECT * FROM `answerbank` WHERE isCorrect = 'Y' AND qbID IN($qID)")->result_array();
    }

    function insertQuestionDetails($data)
    {
    	//print_r($data);
    	$this->db->insert_batch('userAnswerTagging', $data);
        return ($this->db->affected_rows() ) ? TRUE : FALSE;
    }

    function insertOrderTagging($data,$subjectID)
    {
        $Data['session_data'] = $this->session->userdata('user_details');
        $user_id = $Data['session_data']['user_id'];

        $now = date("Y-m-d H:i:s");
        $sRecords = array(  'userID' => $user_id,
                            'stageOrderID' => $data['orderBy'],
                            'quizStatus' => 'P',
                            'subjectID' => $subjectID,
                            'createdAt' => $now
                        );
        $this->db->insert('levelStageValidation', $sRecords);

        return ($this->db->affected_rows() ) ? TRUE : FALSE;
    }

    function updatelevelStageTaggingStatus(){
        $sessionOrderID = $this->session->userdata('subject_level_stage');
        $orderID = $sessionOrderID['orderID'];
        $sRecords = array(  'quizStatus' => 'Y'
                        );

        $this->db->where('orderID', $orderID );
        $this->db->update('levelStageValidation', $sRecords);
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;

    }

    function getOrderTagging($subjectCode,$quizStatus = NULL){
        $Data['session_data'] = $this->session->userdata('user_details');
        $user_id = $Data['session_data']['user_id'];

        $this->db->select('*');
        $this->db->from('levelStageValidation a');
        $this->db->join('stagesMaster b', 'a.stageOrderID = b.orderBy');
        $this->db->join('levelMaster c', 'b.levelID = c.levelID');
        if($quizStatus != NULL){
            $this->db->where( array('a.userID' => $user_id, 'a.subjectID' => $subjectCode, 'a.quizStatus' => 'P' ) );
        }else{
            $this->db->where( array('a.userID' => $user_id, 'a.subjectID' => $subjectCode ) );
        }
        $this->db->order_by('stageOrderID', 'DESC');
        $this->db->limit(1);

        $result = $this->db->get();
        return ($result->num_rows() > 0 ) ? $result->row_array() : FALSE;
    }

	function getAllData($postData){
        
		$sql="SELECT t.*, (SELECT GROUP_CONCAT(CONCAT(s.ansID,'~!~',s.optionValue,'~!~',optionImg) SEPARATOR '#!~!#')
		FROM answerbank s WHERE s.qbID = t.qbID) As optionDetails, 
        (SELECT a.ansID FROM answerbank a WHERE a.qbID = t.qbID AND a.isCorrect = 'Y') As correctAnsID 
        FROM questionbank t JOIN questionbankboardmapping q ON q.qbID = t.qbID 
        WHERE t.status ='Y' AND levelID =".$postData['inputLevel']." AND stageID =".$postData['inputStage']." AND boardID= ".$postData['inputBoard']." AND subjectID=".$postData['inputSubject']." AND chapterID=".$postData['inputChapter']." AND stdID =".$postData['inputStandard']." ORDER BY rand() LIMIT ".$postData['maxQuestion'];
        $result = $this->db->query($sql);

        return ( $result->num_rows() > 0 ) ? $result->result_array() : FALSE;
    }


    //Get Current level and stage on basis of user,sub,chapter
function getLevelAndStage($subjectID,$chapterID){
        $Data['session_data'] = $this->session->userdata('user_details');
        $userID = $Data['session_data']['user_id'];
        $max_levelID = $this->db->query("SELECT max(levelID) AS currentLevel FROM `userAnswerTagging` WHERE userID=$userID AND subjectID=$subjectID AND chapterID=$chapterID AND playingStatus='Y' ")->result_array();
        if( $max_levelID[0]['currentLevel'] > 0){
            $maxresult_stageID = $this->db->query("SELECT `userAnswerTagging`.stageID AS currentStage FROM `userAnswerTagging` left join stagesMaster on userAnswerTagging.stageID = stagesMaster.stageID where userID=$userID and subjectID = $subjectID and chapterID =$chapterID and userAnswerTagging.levelID = ".$max_levelID[0]['currentLevel']." order by orderBY desc limit 0,1");
            $max_stageID = $maxresult_stageID->result_array();
            $currentLevelStage[0]['currentLevel'] = $max_levelID[0]['currentLevel'];
            $currentLevelStage[0]['currentStage'] = $max_stageID[0]['currentStage'];
        }else{
            $currentLevelStage[0]['currentLevel'] = null;
            $currentLevelStage[0]['currentStage'] = null;
        }

        return $currentLevelStage;
        //return $this->db->query("SELECT max(levelID) AS currentLevel,max(stageID) AS currentStage FROM `userAnswerTagging` WHERE userID=$userID AND subjectID=$subjectID AND chapterID=$chapterID AND playingStatus='Y' AND subjectID = $subjectID")->result_array();
        }

    //Fetch next stage if exist else next level will call &  if next level don't exist than an empty array will return. From the getNextLevel

    function getNextStage($level,$stage){
        $Data['session_data'] = $this->session->userdata('user_details');
        $userID = $Data['session_data']['user_id'];
        $userType = $Data['session_data']['user_type'];

        $CurrOrder = 0;
        if($stage > 0){
            if( ($userType == 'S') || ($userType == 'B') || ($userType == '') ){
                $currentOrder = $this->db->query("SELECT orderBy FROM stagesMaster WHERE stageID=$stage")->result_array();
                $CurrOrder = $currentOrder[0]['orderBy'];   
            }else{
                $CurrOrder = 0;    
            }
        }else{
            $CurrOrder = 0;
        }
        
        //$resultSet= $this->db->query("SELECT * FROM stagesMaster WHERE orderBy=($CurrOrder+1) AND levelID=$level");
        $resultSet= $this->db->query("SELECT a.stageID AS stageID,a.stageName AS stageName,b.levelID AS levelID,b.levelName AS levelName FROM stagesMaster a INNER JOIN levelMaster b ON a.levelID=b.levelID WHERE a.orderBy=($CurrOrder+1) AND a.levelID=$level order By a.orderBy limit 1");
        if ($resultSet->num_rows() > 0) {
            return $resultSet->result_array();
        } else {
            return $this->getNextLevel($level);
        }
    }

    function getNextLevel($level){
        $resultLevel = $this->db->query("SELECT a.stageID AS stageID,a.stageName AS stageName,b.levelID AS levelID,b.levelName AS levelName FROM stagesMaster a INNER JOIN levelMaster b ON a.levelID=b.levelID WHERE a.levelID=($level+1) order By a.orderBy limit 1");
        if ($resultLevel->num_rows() > 0) {
            return $resultLevel->result_array();
        } else {
            return array();
        }
    }

    function resetQuiz( $chapter,$user_id ){

        $sRecords = array(  
                            'playingStatus' => 'N'
                        );

        $this->db->where( array('userID' => $user_id, 'chapterID' => $chapter) );
        $this->db->update('userAnswerTagging', $sRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function resetQuizNew( $chapter,$user_id,$level ){
        $this->db->where( array('userID' => $user_id, 'chapterID' => $chapter, 'levelID'=> $level) );
        $this->db->delete('userAnswerTagging');
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }	


}
