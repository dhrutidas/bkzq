<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author  Krishna Gupta
 * @date    7.02.2017
 *
**/
class Upload_Files extends MY_Controller
{
	public function  __construct() {
		parent::__construct();
		$this->load->model('file');
	}
	
	function index(){

		$data = array();
		if($this->input->post('fileSubmit') && !empty($_FILES['userFiles']['name'])){
			$filesCount = count($_FILES['userFiles']['name']);
			for($i = 0; $i < $filesCount; $i++){
				$_FILES['userFile']['name'] = $_FILES['userFiles']['name'][$i];
				$_FILES['userFile']['type'] = $_FILES['userFiles']['type'][$i];
				$_FILES['userFile']['tmp_name'] = $_FILES['userFiles']['tmp_name'][$i];
				$_FILES['userFile']['error'] = $_FILES['userFiles']['error'][$i];
				$_FILES['userFile']['size'] = $_FILES['userFiles']['size'][$i];

				$uploadPath = 'uploads/files/';
				$config['upload_path'] = $uploadPath;
				$config['allowed_types'] = 'gif|jpg|png';
				//$config['max_size']	= '100';
				//$config['max_width'] = '1024';
				//$config['max_height'] = '768';
				
				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if($this->upload->do_upload('userFile')){
					$fileData = $this->upload->data();
					$uploadData[$i]['file_name'] = $fileData['file_name'];
					$uploadData[$i]['created'] = date("Y-m-d H:i:s");
					$uploadData[$i]['modified'] = date("Y-m-d H:i:s");
				}
			}
			if(!empty($uploadData)){
				//Insert files data into the database
				$insert = $this->file->insert($uploadData);
				$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
				$this->session->set_flashdata('statusMsg',$statusMsg);
			}
		}
		$data['groupArr'] = parent::menu();
		$data['page_title'] = "Manage Images";
		//get files data from database
        $data['files'] = $this->file->getRows();
		//pass the files data to view
		$data['load_page'] = "upload_files/index";
		$this->load->view("kernel", $data);
		//$this->load->view('content/upload_files/index', $data);
	}

}