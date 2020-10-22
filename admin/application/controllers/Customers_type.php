<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Customers_type extends MY_Controller {

    function __construct() {

        parent::__construct();
        $this->load->model('customer_type_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    function index() {

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "View Customer Type Details";
        $Data['load_page'] = "customer_type/view_all_customers_type";

        //pagination start here
        $config['base_url'] = base_url('manage-customers-type');
        $config['total_rows'] = $this->customer_type_model->getCustomerCount();
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
        $Data['customer_data'] = $this->customer_type_model->customer_type_details($config["per_page"], $Data['page']);

        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    function editModal($ctypeID) {
        $this->load->model('level_model');
        $Data['levelDetails'] = $this->level_model->getAllActiveLevel();
        $Data['customer_data'] = $this->customer_type_model->customer_detail_signle_record($ctypeID);
        $this->load->view("content/customer_type/edit_customer_type", $Data);
    }

    function editCustomer_type() {

        $this->form_validation->set_rules('inputlevel', 'Customer Level Access', 'required');
        $this->form_validation->set_rules('inputcustomertypename', 'Customer Type Name', 'required');
        $this->form_validation->set_rules('inputcustomertypedesc', 'Customer Type Description', 'required');
        $this->form_validation->set_rules('inputstatus', 'Customer Status', 'required');
        
        if ($this->form_validation->run() == TRUE) {
            
            $postArr['custlevel'] = $this->input->post('inputlevel');
            $postArr['custtypename'] = $this->input->post('inputcustomertypename');
            $postArr['custtypedescription'] = $this->input->post('inputcustomertypedesc');
            $postArr['status'] = $this->input->post('inputstatus');
            $postArr['custtypeID'] = $this->input->post('cID');

            if ($this->customer_type_model->updatecType($postArr)) {
                $this->session->set_flashdata('message', 'Success! Customer Type has been updated successfully.');
            } else {
                $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
            }
        }else{
            $this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
        }
        redirect(base_url('manage-customers-type'));
    }

    function addModal() {
        $this->load->model('level_model');
        $Data['levelDetails'] = $this->level_model->getAllActiveLevel();
        $this->load->view("content/customer_type/add_customer_type", $Data);
    }

    function addCustomer_type() {

        $this->form_validation->set_rules('inputlevel', 'Customer Level Access', 'required');
        $this->form_validation->set_rules('inputcustomertypename', 'Customer Type Name', 'required');
        $this->form_validation->set_rules('inputcustomertypedesc', 'Customer Type Description', 'required');

        if ($this->form_validation->run() == TRUE) {

            $postArr['custlevel'] = $this->input->post('inputlevel');
            $postArr['custtypename'] = $this->input->post('inputcustomertypename');
            $postArr['custtypedescription'] = $this->input->post('inputcustomertypedesc');

            if ($this->customer_type_model->insertcType($postArr) == TRUE) {
                $this->session->set_flashdata('message', 'Success! Customer Type has been updated successfully.');
            } else {
                $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
            }
        }else{
            $this->session->set_flashdata('warning', 'Mendatory field can not be left blank.');
        }
        redirect(base_url('manage-customers-type'));
    }

}
