<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    19.03.2017
 *
**/

class Api_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getBkzTopper(){
        $sql = "SELECT (count(questionID) * orderBy) AS Marks,a.userID, CONCAT(c.fName, ' ', c.lName) AS user_name,c.profilPic as photo,DATE_FORMAT(timeStamp, '%Y-%m') as answerdate FROM userAnswerTagging a INNER JOIN stagesMaster b ON a.stageID = b.stageID
                INNER JOIN userMaster c ON a.userID = c.userID
                WHERE ansStatus = 'Y' AND c.schoolID=2";
        if(!empty($_GET['from_date'])){
            $sql .= ' and DATE_FORMAT(timeStamp, "%Y-%m") >= "'.$_GET['from_date'].'"'; 
        }
        if(!empty($_GET['to_date'])){
            $sql .= ' and DATE_FORMAT(timeStamp, "%Y-%m") <= "'.$_GET['to_date'].'"'; 
        }
        $sql .= " GROUP BY a.stageID,a.userID ,DATE_FORMAT(timeStamp, '%Y-%m') order by answerdate desc";
        return $this->db->query($sql)->result_array();
    }

    function getSchoolTopper($school){
      $where_school=($school>0) ? "c.schoolID = '$school'" : " c.schoolID<>2 ";
        /*$sql = "SELECT (count(questionID) * orderBy) AS Marks,a.userID, CONCAT(c.fName, ' ', c.lName) AS user_name,c.profilPic as photo FROM userAnswerTagging a INNER JOIN stagesMaster b ON a.stageID = b.stageID
                INNER JOIN userMaster c ON a.userID = c.userID
                WHERE $where_school AND ansStatus = 'Y' GROUP BY a.stageID,a.userID";*/
        $sql = "SELECT (count(questionID) * orderBy) AS Marks,a.userID, CONCAT(c.fName, ' ', c.lName) AS user_name,c.profilPic as photo,DATE_FORMAT(timeStamp, '%Y-%m') as answerdate FROM userAnswerTagging a INNER JOIN stagesMaster b ON a.stageID = b.stageID
                INNER JOIN userMaster c ON a.userID = c.userID
                WHERE $where_school AND ansStatus = 'Y' ";
        if(!empty($_GET['from_date'])){
            $sql .= ' and DATE_FORMAT(timeStamp, "%Y-%m") >= "'.$_GET['from_date'].'"'; 
        }
        if(!empty($_GET['to_date'])){
            $sql .= ' and DATE_FORMAT(timeStamp, "%Y-%m") <= "'.$_GET['to_date'].'"'; 
        }       
        $sql .= " GROUP BY a.stageID,a.userID ,DATE_FORMAT(timeStamp, '%Y-%m') order by answerdate desc";
        return $this->db->query($sql)->result_array();
    }

    function getStudentMarks($userID){

        /*$sql = "SELECT (count(questionID) * orderBy) AS Marks,a.userID, CONCAT(c.fName, ' ', c.lName) AS user_name,c.profilPic as photo FROM userAnswerTagging a INNER JOIN stagesMaster b ON a.stageID = b.stageID
                INNER JOIN userMaster c ON a.userID = c.userID
                WHERE ansStatus = 'Y' AND a.userID = $userID GROUP BY a.stageID,a.userID";*/
        $sql = "SELECT (count(questionID) * orderBy) AS Marks,a.userID, CONCAT(c.fName, ' ', c.lName) AS user_name,c.profilPic as photo FROM userAnswerTagging a INNER JOIN stagesMaster b ON a.stageID = b.stageID
                INNER JOIN userMaster c ON a.userID = c.userID
                WHERE ansStatus = 'Y'";
                // print_r($_GET['from']);die;
        if(!empty($_GET['from']) && !empty($_GET['to'])){
            /*echo $_GET['from'].'+++'.$_GET['to']; die;
            $from = date('Y-m',strtotime($_GET['from']));
            $to = date('Y-m',strtotime($_GET['to']));
            //echo 'from--'.$from;
            //echo 'to--'.$to; die;*/
            $fromexp=explode('-', $_GET['from']);
            $toexp=explode('-', $_GET['to']);
            $frommonth=$fromexp[0];
            $fromyear=$fromexp[1];
            $tomonth=$toexp[0];
            $toyear=$toexp[1];

            //$sql .= " AND timeStamp >= '".$from."' and timeStamp <= '".$to."'";
            $sql .= " AND MONTH(timeStamp) >= '".$frommonth."' and YEAR(timeStamp) >= '".$fromyear."' AND MONTH(timeStamp) <='".$tomonth."' AND YEAR(timeStamp) <='".$toyear."'";
        }
        $sql .= "GROUP BY a.stageID,a.userID";
        // echo $sql;die;
        return $this->db->query($sql)->result_array();
    }
}
