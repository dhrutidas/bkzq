<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }
/**
 *
 * @author  Krishna Gupta
 * @date    13.08.2016
 *
**/

class Level extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->model('level_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index(){

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Level";
        $Data['load_page'] = "level/view_level";


        //pagination start here
        $level_count = $this->level_model->getLevelCount();
        $config['base_url'] = base_url('manage-level');
        $config['total_rows'] = $level_count;
        $config['per_page'] = $level_count;
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
        $Data['levelArr'] = $this->level_model->getAllLevel($config["per_page"], $Data['page']);

        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    public function addModal(){ $this->load->view("content/level/add_level_modal"); }

    public function editModal($rID){
        $Data['levelDetails'] = $this->level_model->getLevelDetails($rID);
        $this->load->view("content/level/edit_level_modal", $Data);
    }

    public function addLevel(){

        $this->form_validation->set_rules('inputLevelName', 'Level Name', 'required|trim');
        $this->form_validation->set_rules('inputLevelDesc', 'Level Description', 'required|trim');
        $this->form_validation->set_rules('inputLevelOrder', 'Level Order', 'required|trim');


        if ($this->form_validation->run() == FALSE){

            //$errors = validation_errors();
            $array = array(
                'error'   => true,
                'name_error' => form_error('inputLevelName'),
                'desc_error' => form_error('inputLevelDesc'),
                'order_error' => form_error('inputLevelOrder')
            );

            echo json_encode($array);

        }else{
            if ($this->form_validation->run() == TRUE ){
            
                $postArr['level_name'] = $this->input->post('inputLevelName');
                $postArr['level_desc'] = $this->input->post('inputLevelDesc');
                $postArr['level_order'] = $this->input->post('inputLevelOrder');
    
                if($this->level_model->insertLevel($postArr))
                {
                    $this->session->set_flashdata('message', 'Success! New Level has been added successfully.');
                }
               
            }
        }

        
    }

    public function editLevel(){

        $this->form_validation->set_rules('inputLevelName', ' Level Name', 'required');
        $this->form_validation->set_rules('inputLevelDesc', 'Level Description', 'required');
        $this->form_validation->set_rules('inputLevelOrder', 'Level Order', 'required|trim');
        $this->form_validation->set_rules('inputLevelStatus', 'Level Status', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['levelID'] = $this->input->post('ID');
            $postArr['level_name'] = $this->input->post('inputLevelName');
            $postArr['level_desc'] = $this->input->post('inputLevelDesc');
            $postArr['level_order'] = $this->input->post('inputLevelOrder');
            $postArr['level_status'] = $this->input->post('inputLevelStatus');

            if($this->level_model->updateLevel($postArr))
            {
                $this->session->set_flashdata('message', 'Success! Level Details has been updated successfully.');
            }
            else
            {
                $this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.');
            }

            redirect( base_url('manage-level') );
        }else{
            $this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
            redirect( base_url('manage-level') );
        }
    }
}
