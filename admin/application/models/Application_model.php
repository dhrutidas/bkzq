<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna
 * @date    16.08.2016
 *
**/

class Application_model extends CI_Model{

    function __construct() { parent::__construct(); }

    function getAllApplication($limit=null, $start=null){
        $this->db->select("*");
        $this->db->from("applicationMaster");
        $this->db->order_by('app_id', 'ASC');
        $this->db->limit($limit, $start);
        $result = $this->db->get(); return $result->result_array();
    }

    public function getallapplicationcount(){
        return $this->db->count_all_results('applicationMaster');
    }


    function getprivilegeDetails($rID){

        $this->db->select('role_id');
        $this->db->from('privilegeMaster');
        $this->db->where( array('app_id' => $rID,'app_access' => 'Y') );

        $result = $this->db->get(); return $result->result_array();
    }

    function getApplicationDetails($rID){

        $this->db->select('*');
        $this->db->from('applicationMaster');
        $this->db->where( array('app_id' => $rID) );
        $this->db->limit(1);

        $result = $this->db->get(); return $result->row_array();
    }

      function insertApp( $rDetails ){

        $rRecords = array(  'app_name' => $rDetails['app_name'],
                            'app_path' => $rDetails['app_path'],
                            'group_app_name' => $rDetails['app_name'],
                            'group_order' => $rDetails['app_order'],
                            'app_order' => $rDetails['app_order'],
                            'app_status' => 'Y'
                        );

        $this->db->insert('applicationMaster', $rRecords);

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
    function updatePrivilege( $appID,$roleID,$status ){

        //$this->db->select('*');
        //$this->db->from('privilegeMaster');
        //$this->db->where( array('app_id' => $appID,'role_id' => $roleID) );
        //echo "SELECT * FROM cmp_privilegeMaster WHERE 'app_id' = $appID AND 'role_id' = '$roleID'";
        $query = $this->db->query("SELECT * FROM privilegeMaster WHERE app_id = $appID AND role_id = '$roleID'");
        //echo $query->num_rows(); 
        //echo 'Role ID= '.$roleID.' AND status='.$status;
        if($status == 'Y') {
        if( $query->num_rows() > 0 ) :
            $rRecords = array( 'app_access' => 'Y' );

            $this->db->where( array('app_id' => $appID,'role_id' => $roleID));
            $this->db->update('privilegeMaster', $rRecords);
        else:
            $rRecords = array('app_id' => $appID,
                            'role_id' => $roleID,
                            'app_access' => 'Y'
                        );
            $this->db->insert('privilegeMaster', $rRecords);
        endif;   

        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }
    elseif($status == 'N'){
            $rRecords = array( 'app_access' => 'N' );
            $this->db->where( array('app_id' => $appID,'role_id' => $roleID));
            $this->db->update('privilegeMaster', $rRecords);
            
        return ( $this->db->affected_rows() === 1 ) ? TRUE : FALSE;
    }

    }
}
