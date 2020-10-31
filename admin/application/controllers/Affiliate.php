<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Affiliate extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('affiliate_model');
        $this->load->model('affiliate_student_mapping_model');
        $this->load->library('pagination');
        $this->load->helper('url');
    }

    public function index()
    {
        $Data['groupArr'] = parent::menu();
        $searchDetails = $this->session->tempdata('affiliateId');

        if (isset($_POST['affiliateusr'])) {
            $Data['affiliateUsr'] = $_POST['affiliateusr'];
        } else if (isset($searchDetails)) {
            $Data['affiliateUsr'] = $searchDetails;
        } else {
            $Data['affiliateUsr'] = 0;
        }

        $Data['page_title'] = "Commission earned till date";
        $Data['load_page'] = "affiliate/commission";

        //pagination start here
        $config['base_url'] = base_url('commission-earned');
        $config['total_rows'] = $this->affiliate_model->getCommissionCount($Data['affiliateUsr']);
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

        $Data['allaffiliates'] = $this->affiliate_model->getAllActiveAffiliates();
        $this->pagination->initialize($config);
        $Data['page'] = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $Data['commissionTotal'] = $this->affiliate_model->getCommissionTotal($Data['affiliateUsr']);
        $Data['amountPaid'] = $this->affiliate_model->getPaymentDetailsByUser(($Data['affiliateUsr']))['amountPaid'];
        //call the model function to get the data
        $Data['commissionArr'] = $this->affiliate_model->getCommision($config["per_page"], $Data['page'], $Data['affiliateUsr']);

        $Data['pagination'] = $this->pagination->create_links();
        $this->session->set_tempdata('affiliateId', $Data['affiliateUsr']);
        $this->session->mark_as_temp('affiliateId', 60 * 60 * 24);
        $this->load->view("kernel", $Data);
    }

    public function studentsList(){

        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "My Students";
        $Data['load_page'] = "affiliate/students_list";
        $sData = $this->session->userdata('user_details');
        $Data['student_list']=$this->affiliate_student_mapping_model->getAllStudents($sData['user_id']);
        //print_r($Data);exit;
        $this->load->view("kernel", $Data);
    }
    public function affiliateTree()
    {
        $this->load->helper('form');
        if (isset($_POST['affiliateusr'])) {
            $Data['affiliateUsr'] = $_POST['affiliateusr'];
        } else {
            $Data['affiliateUsr'] = 0;
        }
        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "Affiliate Tree";
        $Data['load_page'] = "affiliate/affiliate_tree";
        $Data['allaffiliates'] = $this->affiliate_model->getAllActiveAffiliates();
        $this->load->view("kernel", $Data);
    }

    public function displayTree($id)
    {
        //print_r($id);
        $this->load->model('employee_model');
        echo $this->affiliate_model->affiliateTree($id);
    }

    public function withdrawal_request()
    {
        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Commission earned till date";
        $Data['load_page'] = "affiliate/withdrawal_request";
        $Data['commissionTotal'] = 100;//$this->affiliate_model->getCommissionTotal();
        $Data['withdrawalTotal'] = 100;//$this->affiliate_model->getPaidTotal();
        $Data['pendingRequests'] = $this->affiliate_model->checkPendingWithdrawalRequest();
        //pagination start here
        $config['base_url'] = base_url('withdrawal-request');
        $this->load->view("kernel", $Data);
    }

    public function withdrawal_process_request()
    {
        $post = $this->input->post();
        $sData = $this->session->userdata('user_details');
        $mailDetails = array();
        $mailDetails['fName'] = $sData['user_first_name'];
        $mailDetails['lName'] = $sData['user_last_name'];
        $mailDetails['id'] = intval($sData['user_id']);
        $mailDetails['amountRequested'] = $post['amount'];
        $mailDetails['message'] = $post['request_text'];
        $mailDetails['requestedDate'] = date('Y-m-d H:i:s');
        $this->affiliate_model->updateWithdrawalRequestLog($mailDetails);
        $this->sendMail($mailDetails);
    }


    public function sendMail($details)
    {
        $this->load->library('email');
        $from_email = "trisha.saple@gmail.com";
        //$to_email = '';
        $to_email = "trisha.saple@gmail.com";
        //$to_email .= "bigkzone9@gmail.com";
        $this->email->set_mailtype("html");
        $this->email->from($from_email, 'BKZ Admin');
        $this->email->to($to_email);
        $this->email->subject('Signup confirmation');
        $this->email->message('Dear Admin, <br/>' . $details['fName'] . ' ' . $details['lName'] . 'has requested to withdraw an amount of Rs ' . $details['amountRequested'] . '<br/> Affiliate id : ' . $details['id']);
        //Send mail
        if ($this->email->send()) {
            $this->session->set_flashdata('message', 'Success! Sign up process has been completed,Confirmation link sent on your registered email ID.');
            redirect(base_url('home'));
        } else {
            $this->session->set_flashdata('warning', 'Warning! Sign up process has been completed,Error in sending Email.');
        }
    }

    public function affiliate_payments()
    {

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Board";
        $Data['load_page'] = "affiliate/affiliate_payments";

        //pagination start here
        $config['base_url'] = base_url('affiliate-payments');
        $config['total_rows'] = $this->affiliate_model->getAffiliatesWithdrawalReqCount();
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
        $Data['boardsArr'] = $this->affiliate_model->getAffiliateRequests($config["per_page"], $Data['page']);

        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    public function editWithdrawl($id)
    {
        $Data['boardDetails'] = $this->affiliate_model->getPaymentDetailsById($id);
        $this->load->view("content/affiliate/edit_withdrawl_modal", $Data);
    }

    public function affiliate_payments_update()
    {
        //  print_r($this->input->post());
        //  exit;
        $this->form_validation->set_rules('amountPaid', 'Amount paid', 'required');
        $this->form_validation->set_rules('paymentDate', 'Payment date', 'required');
        $this->form_validation->set_rules('paymentMode', 'Payment mode', 'required');

        if ($this->form_validation->run() == TRUE) {
            $postArr['amountPaid'] = $this->input->post('amountPaid');
            $postArr['paymentDate'] = $this->input->post('paymentDate');
            $postArr['paymentMode'] = $this->input->post('paymentMode');
            $postArr['id'] = $this->input->post('id');

            if ($this->affiliate_model->updateWithdrawlMaster($postArr)) {
                $this->session->set_flashdata('message', 'Success! Payment Details has been updated successfully.');
            } else {
                $this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.');
            }
            redirect(base_url('affiliate-payments'));
        } else {
            $this->session->set_flashdata('warning', 'Mandatory field can not be left blank.');
            redirect(base_url('affiliate-payments'));
        }
    }

    public function manageAffiliate()
    {
        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Affiliate";
        $Data['load_page'] = "affiliate/view_affiliates";
        $Data['studentsFilter'] = array(
            'fname' => 'First name',
            'lname' => 'Last name',
            'emailID' => 'Email id',
            'contactNumber' => 'Contact number',
            'userPackageType' => 'Package'
        );
        $Data['packageFilter'] = array(
            'T' => 'Free Trail',
            'B' => 'Bronze',
            'S' => 'Silver',
            'G' => 'Gold'
        );
        $searchDetails = $this->session->tempdata('search_details');

        $filter = $this->input->post('filter');

        if ($this->input->post('field')) {
            $field = $this->input->post('field');
        } else if (isset($searchDetails['field'])) {
            $field = $searchDetails['field'];
        } else {
            $field = '';
        }

        if ($this->input->post('search')) {
            $search = $this->input->post('search');
        } else if (isset($searchDetails['text'])) {
            $search = $searchDetails['text'];
        } else {
            $search = '';
        }

        if (!empty($search)) {
            $students_count = $this->affiliate_model->getAffiliatesWhereLike($field, $search);
        } else {
            $students_count = $this->affiliate_model->getUserCount();
        }
        $searchDetais = array(
            'field' => $field,
            'text' => $search
        );
        $this->session->set_tempdata('search_details', $searchDetais);
        $this->session->mark_as_temp('search_details', 60 * 60 * 24);
        $Data['totalRows'] = $students_count;
        //pagination start here
        $config['base_url'] = base_url('manage-affiliates');
        $config['total_rows'] = $students_count;
        $config['per_page'] = 10;
        // print_r($config); die;
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
        if (!empty($search)) {
            $Data['employeesArr'] = $this->affiliate_model->getAllAffiliatesWhereLike($config["per_page"], $Data['page'], $field, $search);
        } else {
            $Data['employeesArr'] = $this->affiliate_model->getAllAffiliates($config["per_page"], $Data['page']);
        }
        $Data['pagination'] = $this->pagination->create_links();
        $Data['fieldSearched'] = $field;
        $Data['textSearched'] = $search;
        $this->load->view("kernel", $Data);
    }

    public function resetFilter()
    {
        $this->session->unset_tempdata('search_details');
        redirect(base_url('manage-affiliates'));
    }

    public function editModal($eID)
    {
        $this->load->model('student_model');
        $this->load->model('package_model');
        $Data['packageSubject'] = $this->package_model->getActivePackageSubject($eID);
        $Data['userDetail'] = $this->affiliate_model->getAffiliateDetails($eID);
        $this->load->view("content/affiliate/edit_affiliate_modal", $Data);
    }

    public function viewModal($eID)
    {
        $this->load->model('student_model');
        $this->load->model('package_model');
        $Data['notConfirmSubject'] = $this->student_model->getConfirmPackageDetail($eID);
        $Data['packageSubject'] = $this->package_model->getActivePackageSubject($eID);
        $Data['userDetail'] = $this->affiliate_model->getAffiliateDetails($eID);
        $this->load->view("content/affiliate/view_affiliate_modal", $Data);
    }

    public function editAffiliate()
    {
        $this->load->model('student_model');
        $this->load->model('package_model');
        $this->form_validation->set_rules('inputFirstName', 'User First Name', 'required');
        $this->form_validation->set_rules('inputLastName', ' User Last Name', 'required');
        $this->form_validation->set_rules('inputContact', 'User Contact', 'required');
        $this->form_validation->set_rules('inputUserStatus', 'User Status', 'required');
        $this->form_validation->set_rules('inputPackage', 'User Package', 'required');

        if ($this->form_validation->run() == TRUE) {

            $postArr['userID'] = $this->input->post('EID');
            $postArr['fName'] = $this->input->post('inputFirstName');
            $postArr['lName'] = $this->input->post('inputLastName');
            $postArr['contactNumber'] = $this->input->post('inputContact');
            $postArr['residenceAdd'] = $this->input->post('inputAddress');
            $postArr['roleID'] = 8;
            $postArr['additionalInfo'] = $this->input->post('inputDesc');
            $postArr['status'] = $this->input->post('inputUserStatus');
            $postArr['package'] = $this->input->post('inputPackage');


            $profile_pic = $this->input->post('profile_pic');
            if (isset($profile_pic)) {
                $picStatus = "Y";
            } else {
                $picStatus = "N";
            }

            if (!empty($_FILES['inputProfilePic']['name'])) {
                $profile_pic_name = 'profile_pic_' . $postArr['userID'] . '.jpg';
                $config['upload_path']   = './assets/images/profile_pic/';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['file_name']     = $profile_pic_name;
                $config['overwrite']     = TRUE;
                $config['max_size']      = 150;
                $config['max_width']     = 0;
                $config['max_height']    = 0;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('inputProfilePic')) {
                    $error = array('error' => $this->upload->display_errors());
                    $postArr['profilPic'] = '';
                    //echo "cond if : ".print_r($error);
                } else {
                    $data = array('upload_data' => $this->upload->data());
                    $postArr['profilPic'] = $profile_pic_name;
                    //echo "cond else";
                }
            } else if ($picStatus == "Y") {
                //echo "cond else if";
                $postArr['profilPic'] = $this->input->post('profile_pic');
            } else {
                //echo "cond else else";
                $postArr['profilPic'] = '';
            }
            //echo $picStatus;
            //print_r($config);
            //print_r($postArr);
            //exit;
            if ($this->student_model->updateEmployee($postArr)) {

                $this->session->set_flashdata('message', 'Success! User Details has been updated successfully.');
            }
        } else {
            $this->upload->display_errors('<p>', '</p>');
            $this->session->set_flashdata('warning', 'Mandatory field can not be left blank.');
        }

        redirect(base_url('manage-affiliates'));
    }

    public function registerStudent()
    {
        $this->load->model('board_model');
        $this->load->model('school_model');
        $this->load->model('class_model');
        $this->load->model('subject_model');
        $parentArr = $this->session->userdata('user_details');
        $Data['parentArr'] = $parentArr;
        $affiliate_details = $this->affiliate_model->getAffiliateDetails($parentArr['user_id']);
        $Data['affiliateStudentMapping'] = $affiliate_details['affiliateStudentMapping'];
        if ($affiliate_details['isAffiliateUser'] === 'Y' && !$affiliate_details['affiliateStudentMapping']) {
            $Data['boardArr'] = $this->board_model->getAllActiveBoards();
            $Data['schoolArr'] = $this->school_model->getAllActiveSchools();
            $Data['classArr'] = $this->class_model->getAllActiveClasses();
            $Data['subjectArr'] = $this->subject_model->getAllActiveSubjects();
        } else {
            $this->session->set_flashdata('warning', 'Student already registered');
        }

        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "Register student";
        $Data['load_page'] = "affiliate/register_student";
        $this->load->view("kernel", $Data);
    }
}
