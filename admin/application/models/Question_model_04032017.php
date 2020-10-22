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
        $Data['session_data'] = $this->session->userdata('user_details');
    	$status = "";
		$counterArr =0;
        $insert = "INSERT INTO `questionbank`(`questionText`, `addedBy`) VALUES ('".$data['questionText']."','".$Data['session_data']['user_id']."');";
        $questionQuery = $this->db->query($insert);
        $questionID = $this->db->insert_id();
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
        if($questionID > 0) {
            $img = '';$counterValue = 1;
            $option = 'INSERT INTO `answerbank`(`qbID`, `optionValue`, `optionImg`, `isCorrect`, `qsort`, `status`) VALUES ';
            foreach($data['ansValues'] as $optionText){
                $option.="(".$questionID.",'".$optionText."','".$img."','".$data['ansCorrection'][($counterValue-1)]."','".$counterValue++."','Y') ,";
            }
            $optionQuery = rtrim($option, ",");
            $query = $this->db->query($optionQuery);			
            if($query){
				$taggingResult = $this->db->query($taggingQuery);
				if($taggingResult)
					$status = 'Successfull Inserted !';
				else
					$status = 'Only Tagging Failed !';
            }
            else {
                $status = 'Fail ! Option Not Inserted';
            }
        }
        else {
            $status = 'Fail ! Question Not Inserted';
        }
        return $status;
    }

}
