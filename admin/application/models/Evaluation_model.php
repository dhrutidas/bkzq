<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 * 
 * @author  Krishna Gupta
 * @date    03.03.2017
 * 
**/

class Evaluation_model extends CI_Model{
    
    function __construct() { 
    	parent::__construct(); 
    	$this->load->library('session');
    }

    function getAllActiveChaptersSubjectwise($subjectID){

        $this->db->select("*");
        $this->db->from("chapterMaster");
        $this->db->where( "status = 'Y' AND subjectID = '$subjectID'");
        $this->db->order_by('chapterID');
        //echo $this->db->last_query();
        $result = $this->db->get(); return $result->result_array();
    }

  
  	function good_count($student,$subject,$chapter,$from_date, $to_date){

        $sql = "SELECT userID FROM userAnswerTagging WHERE userID = '$student' AND subjectID='$subject' AND chapterID='$chapter' AND ansStatus='Y' AND DATE(timeStamp) BETWEEN '$from_date' AND '$to_date'";
        $result = $this->db->query($sql);

        return $result->num_rows();

  	}

  	function very_good_count($student,$subject,$chapter,$from_date, $to_date){

        $sql = "SELECT DISTINCT stageID FROM userAnswerTagging WHERE userID = '$student' AND subjectID='$subject' AND chapterID='$chapter' AND ansStatus='Y' AND DATE(timeStamp) BETWEEN '$from_date' AND '$to_date'";
        $result = $this->db->query($sql);

        return $result->num_rows();
  	}

  	function best_count($student,$subject,$chapter,$from_date, $to_date){


        //$sql = "SELECT count( DISTINCT stageID ) AS chapter_cnt FROM userAnswerTagging WHERE userID = '$student' AND subjectID='$subject' AND playingStatus='Y' GROUP BY stageID HAVING chapter_cnt >= 5";
        $sql = "SELECT COUNT(DISTINCT levelID) AS chapter_cnt FROM `userAnswerTagging` WHERE `userID` = '$student' AND `subjectID` = '$subject' AND chapterID='$chapter' AND stageID=5";
        $result = $this->db->query($sql);
		return $result->result_array();
        //return $result->num_rows();
  	}

  	function excellent_count($student,$subject,$chapter,$from_date, $to_date){

        $sql = "SELECT COUNT(DISTINCT levelID) AS chapter_cnt FROM `userAnswerTagging` WHERE `userID` = '$student' AND `subjectID` = '$subject' AND chapterID='$chapter' AND stageID=10";
        $result = $this->db->query($sql);
        return $result->result_array();
        //return $result->num_rows();
  	}


  	function very_poor_count($student,$subject,$chapter,$from_date, $to_date){

        $sql = "SELECT userID FROM userAnswerTagging WHERE userID = '$student' AND subjectID='$subject' AND chapterID='$chapter' AND ansStatus='N' AND DATE(timeStamp) BETWEEN '$from_date' AND '$to_date'";
        $result = $this->db->query($sql);
        return $result->num_rows();
  	}

  	function poor_count($student,$subject,$chapter,$from_date, $to_date){

        $sql = "SELECT userID FROM userAnswerTagging WHERE userID = '$student' AND subjectID='$subject' AND chapterID='$chapter' AND ansStatus='S' AND DATE(timeStamp) BETWEEN '$from_date' AND '$to_date'";
        $result = $this->db->query($sql);

        return $result->num_rows();
  	}

  	function stage_count_check($student){
        $sql = "SELECT COUNT(DISTINCT levelID) AS chapter_cnt FROM `userAnswerTagging` WHERE `userID` = '$student' AND stageID=5";
        $result = $this->db->query($sql);
		return $result->result_array();

  	}

}
