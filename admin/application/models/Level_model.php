<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Level_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getLevelCount(){
        return $this->db->count_all('levelMaster');
    }

    function getAllLevel($limit, $start){

        $this->db->select("*");
        $this->db->from("levelMaster");
        $this->db->order_by('orderBy');
        $this->db->limit($limit, $start);

        $result = $this->db->get(); return $result->result_array();
    }

    function getAllActiveLevel(){

        $this->db->select("*");
        $this->db->from("levelMaster");
        $this->db->where( array('status' => 'Y') );
        $this->db->order_by('orderBy');

        $result = $this->db->get(); return $result->result_array();
    }

	function getAllActiveLevelForTag(){
	return $this->db->query("SELECT level.*,GROUP_CONCAT(stage.stageID SEPARATOR '|~|') AS catStageID,GROUP_CONCAT(stage.stageName SEPARATOR '|~|') AS catStageName FROM stagesMaster stage JOIN levelMaster level ON stage.levelID = level.levelID GROUP BY level.levelID")->result_array();
    }

    function getAllActiveLevelForTagSorted(){
        return $this->db->query("SELECT level.*,GROUP_CONCAT(stage.stageID ORDER BY stage.orderBy) AS catStageID,GROUP_CONCAT(stage.stageName ORDER BY stage.orderBy) AS catStageName FROM stagesMaster stage JOIN levelMaster level ON stage.levelID = level.levelID GROUP BY level.levelID")->result_array();
    }

    function getLevelDetails($rID){

        $this->db->select('*');
        $this->db->from('levelMaster');
        $this->db->where( array('levelID' => $rID) );
        $this->db->limit(1);

        $result = $this->db->get();
        return $result->row_array();
    }

    function insertLevel( $rDetails ){

        $rRecords = array(  'levelName' => $rDetails['level_name'],
                            'levelDesc' => $rDetails['level_desc'],
                            'orderBy' => $rDetails['level_order']
                        );

        $this->db->insert('levelMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    function updateLevel( $rDetails ){

        $rRecords = array(  'levelName' => $rDetails['level_name'],
                            'levelDesc' => $rDetails['level_desc'],
                            'orderBy' => $rDetails['level_order'],
                            'status' => $rDetails['level_status']
                        );

        $this->db->where('levelID', $rDetails['levelID'] );
        $this->db->update('levelMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
    function levelForUser(){
      $Data['session_data'] = $this->session->userdata('user_details');
      $userID = $Data['session_data']['user_id'];
      return $this->db->query("SELECT DISTINCT lev.* FROM `userAnswerTagging` tag JOIN levelMaster lev ON tag.levelID=lev.levelID WHERE tag.userID=$userID ")->result_array();
    }
    function LoadGraphData($lDetails){
      $Data['session_data'] = $this->session->userdata('user_details');
      $userID = $Data['session_data']['user_id'];
      $levelID=$lDetails['levelID'];
      $subjectID=$lDetails['subjectID'];
      /*echo "SELECT max(tag.stageID) AS stageID,tag.chapterID,stage.stageName,chap.chapterName
      FROM `userAnswerTagging` tag
      LEFT JOIN stagesMaster stage ON stage.stageID=tag.stageID
      LEFT JOIN chapterMaster chap ON chap.chapterID=tag.chapterID
      WHERE tag.userID=$userID AND tag.levelID=$levelID AND tag.subjectID=$subjectID AND tag.playingStatus='Y' ";
      exit;*/
      return $this->db->query("SELECT max(tag.stageID) AS stageID,tag.chapterID,stage.stageName,chap.chapterName
      FROM `userAnswerTagging` tag
      LEFT JOIN stagesMaster stage ON stage.stageID=tag.stageID
      LEFT JOIN chapterMaster chap ON chap.chapterID=tag.chapterID
      WHERE tag.userID=$userID AND tag.levelID=$levelID AND tag.subjectID=$subjectID AND tag.playingStatus='Y' ")->result_array();
    }
}
