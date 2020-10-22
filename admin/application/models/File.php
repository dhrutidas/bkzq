<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class File extends CI_Model{

	public function getRows($id = '', $start, $limit){
		$this->db->select('id,file_name,created');
		$this->db->from('files');
		if($id){
			$this->db->where('id',$id);
			$query = $this->db->get();
			$this->db->limit($limit,$start);
			$result = $query->row_array();
		}else{
			$this->db->order_by('created','desc');
			$this->db->limit($limit,$start);
			$query = $this->db->get();
			$result = $query->result_array();
		}
		//echo $this->db->last_query(); die;
		return !empty($result)?$result:false;
	}
	
	public function insert($data = array()){
		$insert = $this->db->insert_batch('files',$data);
		return $insert?true:false;
	}
	
	public function record_count() { 
	    $select="SELECT * FROM files WHERE description LIKE '".$searchData['imgdesc']."%'";
        $res=$this->db->query($select);
        return count($res->result_array());
	}
	
	function getSearchImage($searchData = array()){
    	/*preg_match_all('/#(\\w+)/', $searchData['imgdesc'], $matches);
    	//print_r($matches); die;
        $hashtagsArray = array_filter($matches[0]);
        //print_r($hashtagsArray); die;
        $querystate = '';

        $querystate.= "SELECT * FROM `files` WHERE " . (empty($hashtagsArray) ? " description LIKE ''" : "");
        for ($i = 0; $i < count($hashtagsArray); $i++)
        {
            $querystate.= " description LIKE '%" . str_replace('#', '', $hashtagsArray[$i]) . "%' " . (($i == count($hashtagsArray) - 1) ? '' : 'OR ');
        }
        $query = $this->db->query($querystate);
        return $query->result_array();*/
        $select="SELECT * FROM files WHERE description LIKE '".$searchData['imgdesc']."%'";
        $res=$this->db->query($select);
        return $res->result_array();
    }

    public function getfilecount(){
    	$this->db->select('id');
		$this->db->from('files');
		if($id){
			$this->db->where('id',$id);
			$query = $this->db->get();
			$result = $query->row_array();
		}else{
			$this->db->order_by('created','desc');
			$query = $this->db->get();
			$result = $query->result_array();
		}
		return !empty($result)? count($result):0;
    }
	
}
