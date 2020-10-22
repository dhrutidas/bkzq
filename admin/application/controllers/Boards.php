<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Boards extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('board_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Category";
        $Data['load_page'] = "boards/view_boards";

        //pagination start here
        $config['base_url'] = base_url('manage-boards');
        $config['total_rows'] = $this->board_model->getBoardCount();
        $config['per_page'] = 10;
        $config["uri_segment"] = 2;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);

        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = TRUE;
        $config['last_link'] = TRUE;
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
        $Data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        //call the model function to get the data
        $Data['boardsArr'] = $this->board_model->getAllBoards($config["per_page"], $Data['page']);

        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    public function addModal(){ $this->load->view("content/boards/add_board_modal"); }

    public function editModal($dID){

        $Data['boardDetails'] = $this->board_model->getBoardDetails($dID);

        $this->load->view("content/boards/edit_board_modal", $Data);
    }

    public function addBoard(){

        $this->form_validation->set_rules('inputBoardname', 'Board Name', 'required');
        $this->form_validation->set_rules('inputBoarddesc', 'Board Description', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['dname'] = $this->input->post('inputBoardname');
            $postArr['ddescription'] = $this->input->post('inputBoarddesc');

			if($this->board_model->insertBoard($postArr))
			{
		            $this->session->set_flashdata('message', 'Success! New Board has been added successfully.');
			}
			else
			{
				$this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
			}
        }
    	else
    	{
    		$this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
    	}
    	redirect( base_url('manage-boards') );
    }

    public function editBoard(){

        $this->form_validation->set_rules('inputBoardname', 'Board Name', 'required');
        $this->form_validation->set_rules('inputBoarddesc', 'Board Description', 'required');
        $this->form_validation->set_rules('inputBoardstatus', 'Board Status', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['did'] = $this->input->post('inputDID');
            $postArr['dname'] = $this->input->post('inputBoardname');
            $postArr['ddescription'] = $this->input->post('inputBoarddesc');
            $postArr['dstatus'] = $this->input->post('inputBoardstatus');

            if($this->board_model->updateBoard($postArr))
            {
             $this->session->set_flashdata('message', 'Success! Board Details has been updated successfully.');
         }
         else
         {
             $this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.');
         }
         redirect( base_url('manage-boards') );
     }
     else
     {
      $this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
      redirect( base_url('manage-boards') );
    }
}
}
