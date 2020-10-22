<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 * @author  Krishna Gupta
 * @date    7.02.2017
 *
**/
class Upload_Files extends MY_Controller
{
	public function  __construct(){
		parent::__construct();
		$this->load->library('pagination');
		$this->load->library('form_validation');
		$this->load->helper('form');
        $this->load->helper('url');
		$this->load->model('file');
	}

	function index($fetchArray){
		$data = array();
		if($this->input->post('fileSubmit') && !empty($_FILES['userFiles']['name'])){
			$this->form_validation->set_rules('description', 'Description', 'required');
			if($this->form_validation->run()==0){
				$this->session->set_flashdata('warning',validation_errors());
			}else{
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
					$config['max_size']	= '2048';
					$config['max_width'] = '800';
					$config['min_width']= '300';
					$config['max_height'] = '600';
					$config['min_height']='300';

					$this->load->library('upload', $config);
					$this->upload->initialize($config);

					if($this->upload->do_upload('userFile')){
						$fileData = $this->upload->data();
						$uploadData[$i]['file_name'] = $fileData['file_name'];
						$uploadData[$i]['description']=$this->input->post('description');
						$uploadData[$i]['created'] = date("Y-m-d H:i:s");
						$uploadData[$i]['modified'] = date("Y-m-d H:i:s");
					}
					else{
						$error = $this->upload->display_errors();
						$this->session->set_flashdata('warning',$error);
					}
				}
				if(!empty($uploadData)){
					$insert = $this->file->insert($uploadData);
					$statusMsg = $insert?'Files uploaded successfully.':'Some problem occurred, please try again.';
					$this->session->set_flashdata('statusMsg',$statusMsg);
				}
			}
		}

		$config['base_url'] = base_url('upload-images/'.$fetchArray);
        $config['total_rows'] = $this->file->getfilecount();
        $config['per_page'] = 10;
        $config["uri_segment"] = 3;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);

		$data['groupArr'] = parent::menu();
		$data['page_title'] = "Manage Images";
		$start=($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
    	$data['files'] = $this->file->getRows(false, $start, $config['per_page']);
    	$data['pagination']=$this->pagination->create_links();
    	//echo $data['pagination']; die;
		$data['divName'] = $fetchArray;
		$data['load_page'] = "upload_files/index";
		$this->load->view("kernel", $data);
	}

	function searchImage()
	{
		$searchValue['imgdesc']=$this->input->post('search');
		$dataImage=$this->file->getSearchImage($searchValue);
		
		?>
		<ul class="gallery">
		<?php if(!empty($dataImage)): foreach($dataImage as $file): ?>
			<li class="item">
				<img src="<?php echo base_url('uploads/files/'.$file['file_name']); ?>" alt="<?php echo base_url('uploads/files/'.$file['file_name']); ?>" onclick="saveImagePath('<?php echo base_url('uploads/files/'.$file['file_name']); ?>');">
				<p>Uploaded On <?php echo date("j M Y",strtotime($file['created'])); ?></p>
			</li>
			<?php endforeach; else: ?>
			<p>File(s) not found.....</p>
			<?php endif; ?>
		</ul>
		<script>
			jQuery('#paginationid').hide();
		</script>
		<?php
	}

}
?>