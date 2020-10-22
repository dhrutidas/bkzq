<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 * 
 * @author  Surya Tiwari
 * @date    10.04.2014
 * 
**/

class Home_model extends CI_Model{
    
    function __construct() { parent::__construct(); }
    
    function get_graph_table_details($region='ALL')
	{
		if($region=='ALL')
		{}
		else
		{
			$this->db->where("region='".$region."'");
		}
		$this->db->select("SUM(CASE WHEN a.complaint_status = 'O' and b.next_approval='RESOLVED' THEN 1 ELSE 0 END) AS 'RESOLVED',
SUM(CASE WHEN a.complaint_status = 'O' and b.next_approval='CANCELLED' THEN 1 ELSE 0 END) AS 'CANCELLED',
SUM(CASE WHEN a.complaint_status = 'O' and (b.next_approval!='RESOLVED' and b.next_approval!='CANCELLED') THEN 1 ELSE 0 END) AS 'OPEN',SUM(CASE WHEN a.complaint_status = 'C' THEN 1 ELSE 0 END) AS 'CLOSED'");
        $this->db->from('complaint_master a');
        $this->db->join('complaint_transaction b', 'a.cmpID = b.cmpId');
		
		$result = $this->db->get(); 
		return $result->row_array();
	}
	function get_bargraph_details($region)
	{
		if($region!='ALL')
		{
			$this->db->where("region='".$region."'");
		}
		$this->db->select("a.complaint_type,complaint_type_name,
		SUM(CASE WHEN a.complaint_status = 'O' and b.next_approval='RESOLVED' THEN 1 ELSE 0 END) AS 'RESOLVED',
		SUM(CASE WHEN a.complaint_status = 'O' and b.next_approval='CANCELLED' THEN 1 ELSE 0 END) AS 'CANCELLED',
		SUM(CASE WHEN a.complaint_status = 'O' and (b.next_approval!='RESOLVED' and b.next_approval!='CANCELLED') THEN 1 ELSE 0 END) AS 'OPEN',
		SUM(CASE WHEN a.complaint_status = 'C' THEN 1 ELSE 0 END) AS 'CLOSED'");
		$this->db->from('complaint_master a');
		$this->db->join('complaint_transaction b', 'a.cmpID = b.cmpId');
		$this->db->join('complaint_type_master c', 'a.complaint_type = c.complaint_type_code');
		$this->db->group_by('a.complaint_type');
		$result = $this->db->get(); 
		return $result->result_array();
	}
	function get_all_channel_cmp_type()
	{
	$result = $this->db->query("SELECT DATA_TABLE.channel_code ,DATA_TABLE.channel_name,GROUP_CONCAT(DISTINCT DATA_TABLE.complaint_type_code order by DATA_TABLE.complaint_type_code) AS complaint_Code,
GROUP_CONCAT(DISTINCT DATA_TABLE.complaint_type_name order by DATA_TABLE.complaint_type_name) AS complaint_name,
GROUP_CONCAT(count) AS COUNT_final
from( SELECT data.complaint_type_code, data.channel_code,data.complaint_type_name, data.channel_name,count( d.complaint_code ) AS COUNT
FROM `cmp_complaint_master` d
RIGHT JOIN (SELECT b.complaint_type_code,a.channel_code,a.channel_name,b.complaint_type_name
FROM cmp_channel_master a
JOIN cmp_complaint_type_master b ) as data on (d.complaint_type=data.complaint_type_code and d.channel_code=data.channel_code)
GROUP BY data.complaint_type_code, data.channel_code) AS DATA_TABLE
GROUP BY DATA_TABLE.channel_code");
		return $result->result_array();
	}

	function get_leftpiegraph_details($region,$cmp)
	{
		if($region=='ALL')
		{
			$this->db->where("complaint_type='".$cmp."'");
		}
		else
		{
			$this->db->where("region='".$region."' and complaint_type='".$cmp."'");
		}
		$this->db->select("count('category_code') as sum_category_codes,a.category_code,c.category_name");
        $this->db->from('complaint_master a');
        $this->db->join('complaint_transaction b', 'a.cmpID = b.cmpId');
        $this->db->join('category_master c', 'a.category_code = c.category_code');
        $this->db->group_by('a.category_code');
		$result = $this->db->get();
		return $result->result_array();
	}

function get_rightpiegraph_details($region,$cat)
	{
		if($region=='ALL')
		{
			$this->db->where("category_code='".$cat."'");
		}
		else
		{
			$this->db->where("region='".$region."' and category_code='".$cat."'");
		}
		$this->db->select("count('complaint_type') as sum_complaint_type,complaint_type,c.complaint_type_name");
        $this->db->from('complaint_master a');
        $this->db->join('complaint_transaction b', 'a.cmpID = b.cmpId');
        $this->db->join('complaint_type_master c', 'a.complaint_type = c.complaint_type_code');
        $this->db->group_by('a.complaint_type');
		$result = $this->db->get(); 
		return $result->result_array();
	}
	
	/*
	SELECT count('sub_category_code') as sum_category_codes,a.sub_category_code,a.category_code,c.sub_category_name,complaint_type
FROM `cmp_complaint_master` a join cmp_complaint_transaction b join cmp_sub_category_master c
where a.cmpID = b.cmpId and a.sub_category_code = c.sub_category_code
group by a.sub_category_code
	*/
	function get_bar_sub_cat_graph_details($region,$status)
	{
	if($status=='OPEN'){$condition=" a.complaint_status='O' and (b.next_approval!='RESOLVED' and b.next_approval!='CANCELLED')";}
	elseif($status=='CLOSED'){$condition=" a.complaint_status='C'"; }
	elseif($status=='RESOLVED'){$condition=" a.complaint_status='O' and b.next_approval='RESOLVED'"; }
	elseif($status=='CANCELLED'){$condition=" a.complaint_status='O' and b.next_approval='CANCELLED'"; }

		if($region=='ALL')
		{
                        $this->db->where($condition);
		}
		else
		{
			$this->db->where("region='".$region."' and ".$condition);
		}
	$this->db->select("count('sub_category_code') as sum_category_codes,a.sub_category_code,a.category_code,c.sub_category_name,complaint_type");
        $this->db->from('complaint_master a');
        $this->db->join('complaint_transaction b', 'a.cmpID = b.cmpId');
        $this->db->join('sub_category_master c', 'a.sub_category_code = c.sub_category_code');
        $this->db->group_by('sub_category_code');
        //$this->db->group_by('complaint_type');
        $result = $this->db->get(); 
		return $result->result_array();
	}

}
