<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    03.09.2016
 *
**/

class Question_model extends CI_Model{

    function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    function getQuestionCount(){
        $Data['session_data'] = $this->session->userdata('user_details');
        $this->db->where(array('addedBy'=>$Data['session_data']['user_id']));
        $num_rows = $this->db->count_all_results('questionbank');
        return $num_rows;
    }
    function getImageQuestionCount(){
        $Data['session_data'] = $this->session->userdata('user_details');
        $this->db->where(array('addedBy=' => $Data['session_data']['user_id'],'questionImg<>' => ''));
        $num_rows = $this->db->count_all_results('questionbank');
        return $num_rows;
    }

    function getSearchQuestionsDetails($searchData){
    	preg_match_all('/#(\\w+)/', $searchData['str'], $matches);
        $hashtagsArray = array_filter($matches[0]);
        $querystate = '';

        $querystate.= "SELECT t.*, (SELECT GROUP_CONCAT(CONCAT(s.ansID,'~!~',s.optionValue,'~!~',optionImg,'~!~',isCorrect) SEPARATOR '#!~!#') FROM answerbank s WHERE s.qbID = t.qbID) As optionDetails FROM questionbank t WHERE " . (empty($hashtagsArray) ? " t.questionText LIKE ''" : "");
        for ($i = 0; $i < count($hashtagsArray); $i++)
        {
            $querystate.= " t.questionText LIKE '%" . str_replace('#', '', $hashtagsArray[$i]) . "%' " . (($i == count($hashtagsArray) - 1) ? '' : 'OR ');
        }
        $query = $this->db->query($querystate);
        return $query->result_array();
    }

    function insertQuestionAns($data)
    {
      if(sizeof($data['board'])>0 AND $data['levelID'][0][0] != null AND $data['subject'][0][0] != null AND  $data['standard'][0][0] != null)
      {
            $Data['session_data'] = $this->session->userdata('user_details');
            $status = "";
            $counterArr =0;
            $insert = "INSERT INTO `questionbank`(`questionText`,`questionImg`, `addedBy`) VALUES ('".$data['questionText']."','".$data['questionImage']."','".$Data['session_data']['user_id']."');";
            //$questionQuery = $this->db->query($insert);
            if($this->db->query($insert)){
                $questionID = $this->db->insert_id();
            }
            else{
              $status['msg'] = 'Fail ! There is some issue.';
              $status['status'] = true;
              return $status;
            }

            $tagging = 'INSERT INTO `questionbankboardmapping`(`qbID`, `levelID`, `stageID`, `boardID`, `subjectID`,`chapterID`, `stdID`) VALUES ';
        		foreach($data['board'] as $board){
        		foreach($data['levelID'][$counterArr] as $level){
        			$levStage=explode('-',$level);
        				foreach($data['subject'][$counterArr] as $subject){
        					$subChap=explode('-',$subject);
        					foreach($data['standard'][$counterArr] as $standard){
        						$tagging.="(".$questionID.",'".$levStage[0]."','".$levStage[1]."','".$board."','".$subChap[0]."','".$subChap[1]."','".$standard."') ,";
        					}
        				}
        			}
        		$counterArr++;
      		}
            $taggingQuery = rtrim($tagging, ",");
            if($questionID > 0){
              $counterValue = 1;
              $option = 'INSERT INTO `answerbank`(`qbID`, `optionValue`, `optionImg`, `isCorrect`, `qsort`, `status`) VALUES ';
              foreach($data['ansValues'] as $optionText){
                  $option.="(".$questionID.",'".$optionText."','".$data['imagePath'][($counterValue-1)]."','".$data['ansCorrection'][($counterValue-1)]."','".$counterValue++."','Y') ,";
              }
              $optionQuery = rtrim($option, ",");
              $query = $this->db->query($optionQuery);
              if($query){
                $taggingResult = $this->db->query($taggingQuery);
                if($taggingResult){
                  $status['msg'] = 'Successfull Inserted !';
                  $status['Qid']=$questionID;
                  $status['status'] = true;
                  return $status;
                }
                else
                $status['msg'] = 'Only Tagging Failed !';
                $status['status'] = false;
              }
              else {
                $status['msg'] = 'Fail ! Option Not Inserted ';
                $status['status'] = false;
              }
            }
            else {
              $status['msg'] = 'Fail ! Question Not Inserted ';
              $status['status'] = false;
            }
        }
          $status['msg'] = 'Fail ! There is no Tagging .';
          $status['status'] = false;
         return $status;
      }
      function getAllDetail($Qid){

        return $this->db->query("SELECT DISTINCT t.*,
        (SELECT GROUP_CONCAT(CONCAT(s.ansID,'~!~',s.optionValue,'~!~',optionImg,'~!~',isCorrect) SEPARATOR '#!~!#') FROM answerbank s WHERE s.qbID = t.qbID) AS optionDetails,
        (SELECT a.ansID FROM answerbank a WHERE a.qbID = t.qbID AND a.isCorrect = 'Y') AS correctAnsID
        FROM questionbank t JOIN questionbankboardmapping q ON q.qbID = t.qbID WHERE t.qbID=$Qid")->result_array();
      }

      function getTaggingDetailsByQuestionID($Qid)
      {
        return $this->db->query("SELECT subjectName,chapterName,boardName,stdName,levelName,stageName FROM questionbank t
        JOIN `questionbankboardmapping` tag ON t.qbID=tag.qbID
        JOIN `levelMaster` lev ON lev.levelID=tag.levelID
        JOIN `stagesMaster` stg ON stg.stageID=tag.stageID
        JOIN `boardMaster` brd ON brd.boardID=tag.boardID
        JOIN `classMaster` cls ON cls.stdID=tag.stdID
        JOIN `subjectMaster` sub ON sub.subjectID=tag.subjectID
        JOIN `chapterMaster` chp ON chp.chapterID=tag.chapterID
        WHERE t.qbID=$Qid")->result_array();
      }
      
      function getAllQuestionUser($userid){
        return $this->db->query("SELECT * FROM `questionbank` WHERE addedBy=$userid and status='QA' ORDER BY addedOn")->result_array();
      }
      function makeItLive($data){
        $reason=(isset($data['msg']))?$data['msg']:"";
        $session_data=$this->session->userdata('user_details');
        $this->db->query("UPDATE `questionbank` SET status='".$data['status']."' WHERE qbID='".$data['questionID']."';");
        $status_rs= ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
        if($status_rs){
          $this->db->query("INSERT INTO `questionRejection` (`qid`, `reason`, `addedBy`) VALUES ('".$data['questionID']."', '".$reason."', '".$session_data['user_id']."'); ");
          return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
        }
      }
      function searchQuestion($data){
          $whereTagging='';
            foreach($data['level'] as $level){
              $levStage=explode('-',$level);
                foreach($data['subject'] as $subject){
                  $subChap=explode('-',$subject);
                  foreach($data['standard'] as $standard){
                    $whereTagging.="(tag.stageID='".$levStage[1]."' AND tag.boardID='".$data['board']."' AND tag.chapterID='".$subChap[1]."' AND tag.stdID='".$standard."') OR ";
                  }
                }
          }
          $whereTaggingQuery = $whereTaggingQuery ? "(".rtrim($whereTagging, " OR ").") AND " : '';
          $sqlQuery="SELECT * FROM questionbank q JOIN `questionbankboardmapping` tag ON q.qbID=tag.qbID WHERE ".$whereTaggingQuery."  q.status='".$data['status']."' AND q.addedBy='".$data['userID']."' GROUP BY q.qbID ORDER BY q.addedOn";
          $countAllQuery="SELECT count(DISTINCT q.qbID) AS allQuestion FROM questionbank q JOIN `questionbankboardmapping` tag ON q.qbID=tag.qbID WHERE ".$whereTaggingQuery."  q.status='".$data['status']."'";
          $rs=$this->db->query($sqlQuery);
          $varCountData=$this->db->query($countAllQuery)->result_array();
          $data['rsCountAll']=$varCountData[0]['allQuestion'];
          $data['resultSet']=$rs->result_array();
          $data['count']=$rs->num_rows();
          return $data;
      }   

      function getSearchQuestionsDetailsQuery($searchData){
        preg_match_all('/(\\w+)/', $searchData['str'], $matches);
          $hashtagsArray = array_filter($matches[0]);
          $querystate = '';
  
          $querystate.= "SELECT t.*, (SELECT GROUP_CONCAT(CONCAT(s.ansID,'~!~',s.optionValue,'~!~',optionImg,'~!~',isCorrect) SEPARATOR '#!~!#') FROM answerbank s WHERE s.qbID = t.qbID) As optionDetails FROM questionbank t WHERE " . (empty($hashtagsArray) ? " t.questionText LIKE ''" : "");
          for ($i = 0; $i < count($hashtagsArray); $i++)
          {
              $querystate.= " t.questionText LIKE '%" . str_replace('#', '', $hashtagsArray[$i]) . "%' " . (($i == count($hashtagsArray) - 1) ? '' : 'OR ');
          }
        //  $query = $this->db->query($querystate);
          return $matches;
      }

      function getSearchExactQuestionsAndDetails($searchData){        
          $this->db->select("t.* , (SELECT GROUP_CONCAT(CONCAT(s.ansID,'~!~',s.optionValue,'~!~',optionImg,'~!~',isCorrect) SEPARATOR '#!~!#') FROM answerbank s WHERE s.qbID = t.qbID) As optionDetails");
          $this->db->from("questionbank t");
          $this->db->like('t.questionText', $searchData['str'], $searchData['match']); 
         
          $result = $this->db->get(); 
          return $result->result_array();         
      }

      function getTaggingDetailsByQuestionDetails($question)
      {
        return $this->db->query("SELECT tag.qbID,subjectName,chapterName,boardName,stdName,levelName,stageName,sub.subjectID,cls.stdID,chp.chapterID,lev.levelID,stg.stageID FROM questionbank t
        JOIN `questionbankboardmapping` tag ON t.qbID=tag.qbID
        JOIN `levelMaster` lev ON lev.levelID=tag.levelID
        JOIN `stagesMaster` stg ON stg.stageID=tag.stageID
        JOIN `boardMaster` brd ON brd.boardID=tag.boardID
        JOIN `classMaster` cls ON cls.stdID=tag.stdID
        JOIN `subjectMaster` sub ON sub.subjectID=tag.subjectID
        JOIN `chapterMaster` chp ON chp.chapterID=tag.chapterID
        WHERE t.status = 'Y' AND 
        t.questionText like '".$question["questiontext"]."' AND
        tag.boardID= ".$question["boardid"]." AND 
        tag.levelID= ".$question["levelid"]." AND 
        tag.stageID= ".$question["stageid"])->result_array();
      }

      // function getTaggingDetailsByQuestionDetails($question)
      // {
      //   return $this->db->query("SELECT subjectName,chapterName,boardName,stdName,levelName,stageName,sub.subjectID,cls.stdID,chp.chapterID FROM questionbank t
      //   JOIN `questionbankboardmapping` tag ON t.qbID=tag.qbID
      //   JOIN `levelMaster` lev ON lev.levelID=tag.levelID
      //   JOIN `stagesMaster` stg ON stg.stageID=tag.stageID
      //   JOIN `boardMaster` brd ON brd.boardID=tag.boardID
      //   JOIN `classMaster` cls ON cls.stdID=tag.stdID
      //   JOIN `subjectMaster` sub ON sub.subjectID=tag.subjectID
      //   JOIN `chapterMaster` chp ON chp.chapterID=tag.chapterID
      //   WHERE t.qbID=". $question['questionid']. " AND 
      //   tag.boardID= ".$question["boardid"]." AND 
      //   tag.levelID= ".$question["levelid"]." AND 
      //   tag.stageID= ".$question["stageid"])->result_array();
      // }

      function updateQuestion($data){

        $data['inputStandard'] = explode(",", $data['inputStandard']);
        $data['inputSubject'] = explode(",", $data['inputSubject']);

        if(!empty($data['updateLevel'])){
            $dt = explode('-',$data['updateLevel']);
            $data['levelid'] = $dt[0];
            $data['stageid'] = $dt[1];
        }
          
          if(isset($data['inputSubject'])){
            foreach($data['inputSubject'] as $val){
              $temp = explode('-', $val);
              $subjectid = intval($temp[0]);
              $chapterid = intval($temp[1]);
              foreach($data['inputStandard'] as $std){
                $this->db->query("Insert into `questionbankboardmapping`(`qbID`, `levelID`, `stageID`, `boardID`, `subjectID`,`chapterID`, `stdID`) VALUES 
                (".$data['qbid'].", ".$data['levelid'].", ".$data['stageid'].", ".$data['boardid'].", ".$subjectid.", ".$chapterid.",".intval($std).")");  
              }
  
            }
        }
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;

      }

}
