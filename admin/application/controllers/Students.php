<?php if ( ! defined('BASEPATH')){ exit('No direct script access allowed'); }

class Students extends MY_Controller {

    public function __construct() {

        parent::__construct();
        $this->load->helper('string');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->library('email');

        $this->load->model('api_model');
        $this->load->model('student_model');
        $this->load->model('employee_model');
        $this->load->model('role_model');
        $this->load->model('board_model');
        $this->load->model('school_model');
        $this->load->model('class_model');
        $this->load->model('subject_model');
        $this->load->model('package_model');
    }

    public function index(){
        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Students";
        $Data['load_page'] = "students/view_students";
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
        
        if($this->input->post('field')){
            $field = $this->input->post('field');
        } else if(isset($searchDetails['field'])){
            $field = $searchDetails['field'];
        }else{
            $field = '';
        }  

        if($this->input->post('search')){
            $search = $this->input->post('search');
        } else if(isset($searchDetails['text'])){
            $search = $searchDetails['text'];
        }else{
            $search = '';
        }       

        if (!empty($search)) {
            $students_count = $this->student_model->getStudentsWhereLike($field, $search);
        } else {
            $students_count = $this->student_model->getUserCount();
        }
        $searchDetais = array(
            'field'=>$field,
            'text'=>$search
        );
        $this->session->set_tempdata('search_details', $searchDetais);
        $this->session->mark_as_temp('search_details', 60*60*24);
        $Data['totalRows']=$students_count;
       // echo json_encode($Data);die;
        //pagination start here
        $config['base_url'] = base_url('manage-students');
        $config['total_rows'] = $students_count;
        $config['per_page'] = $students_count;
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
            $Data['employeesArr'] = $this->student_model->getAllStudentsWhereLike($config["per_page"], $Data['page'],$field, $search);
        } else {
            $Data['employeesArr'] = $this->student_model->getAllStudents($config["per_page"], $Data['page']);
        }
        $Data['pagination'] = $this->pagination->create_links();
        $Data['fieldSearched'] = $field;
        $Data['textSearched'] = $search;
        $this->load->view("kernel", $Data);
    }

    public function addModal(){

        $Data['boardArr'] = $this->board_model->getAllActiveBoards();
        $Data['schoolArr'] = $this->school_model->getAllActiveSchools();
        $Data['classArr'] = $this->class_model->getAllActiveClasses();
        $Data['subjectArr'] = $this->subject_model->getAllActiveSubjects();

        $this->load->view("content/students/add_student_modal", $Data);
    }

    public function editModal($eID){

        $Data['boardArr'] = $this->board_model->getAllActiveBoards();
        $Data['schoolArr'] = $this->school_model->getAllActiveSchools();
        $Data['classArr'] = $this->class_model->getAllActiveClasses();
        $Data['subjectArr'] = $this->subject_model->getAllActiveSubjects();

        $Data['packageSubject'] = $this->package_model->getActivePackageSubject($eID);
        $Data['userDetail'] = $this->student_model->getStudentDetails($eID);
        $this->load->view("content/students/edit_student_modal", $Data);
    }

    public function viewModal($eID){

        $Data['notConfirmSubject'] = $this->student_model->getConfirmPackageDetail($eID);
        $Data['subjectArr'] = $this->subject_model->getAllActiveSubjects();
        $Data['packageSubject'] = $this->package_model->getActivePackageSubject($eID);
        $Data['userDetail'] = $this->student_model->getStudentDetails($eID);
        $this->load->view("content/students/view_student_modal", $Data);
    }

    public function viewProfile(){
        $Data['groupArr'] = parent::menu();

        $Data['session_data'] = $this->session->userdata('user_details');
        $userID = $Data['session_data']['user_id'];
        $Data['subjectArr'] = $this->subject_model->getAllActiveSubjects();

        $Data['packageSubject'] = $this->package_model->getActivePackageSubject($userID);
        $Data['userDetail'] = $this->student_model->getStudentDetails($userID);
        $resuleData = $this->api_model->getStudentMarks($userID);
        //print_r($resuleData);
        // $total = 0;
        // foreach ($resuleData AS $value) {
        //     $total = $total + $value['Marks'];
        // }
        // $Data['totalmarks'] = $total;
        // $Data['page_title'] = "Profile";
        // $Data['load_page'] = "students/view_profile";

        // $this->load->view("kernel", $Data);

        foreach ($resuleData AS $value) {
            $user_sum[$value['userID']][] =  $value['Marks'];
        }
        if(!empty($user_sum)){
            foreach ($user_sum as $key => $value) {
                $total = 0;
                foreach ($value as $v_key => $v_value) {
                    $total += $v_value;
                }
                $user_total[$key] = $total;
            }
        }
        arsort($user_total);
        $rank = 1;
        $total = 0;
        $u_rank = 0;
        foreach ($user_total as $u_key => $u_value) {
           if($userID == $u_key){
            $total = $u_value;
            $u_rank = $rank;
           }
           $rank++;
        }
        $Data['totalmarks'] = $total;
        $Data['rank'] = $u_rank;
        $Data['page_title'] = "Profile";
        $Data['load_page'] = "students/view_profile";

        $this->load->view("kernel", $Data);
    }

    public function addStudent(){

        $this->form_validation->set_rules('inputFirstName', 'User First Name', 'required');
        $this->form_validation->set_rules('inputLastName', ' User Last Name', 'required');
        $this->form_validation->set_rules('inputEmail', 'User Email', 'required|trim');
        $this->form_validation->set_rules('inputContact', 'User Contact', 'required');
       // $this->form_validation->set_rules('inputParentName', 'User\'s Parent Name', 'required');
       // $this->form_validation->set_rules('inputAddress', 'User Address', 'required');
        $this->form_validation->set_rules('inputBoard', 'User Board', 'required');
        $this->form_validation->set_rules('inputSchool', 'User School', 'required');
        $this->form_validation->set_rules('inputClass', 'User Standard', 'required');
        $this->form_validation->set_rules('inputPackage', 'User Package', 'required');

        if ($this->form_validation->run() == TRUE ){

            if($this->employee_model->getEmployeeCountByEmailid($this->input->post('inputEmail')) > 0){
                $this->session->set_flashdata('warning', 'Email Id is already registered with us,try with another.');
            }else{
                $password = random_string('alnum', 8);

                $postArr['fName'] = $this->input->post('inputFirstName');
                $postArr['lName'] = $this->input->post('inputLastName');
                $postArr['contactNumber'] = $this->input->post('inputContact');
                $postArr['residenceAdd'] = $this->input->post('inputAddress');
                $postArr['emailID'] = $this->input->post('inputEmail');
                $postArr['password'] = $password;
                $postArr['roleID'] = 3;
                $postArr['schoolID'] = $this->input->post('inputSchool');
                $postArr['boardID'] = $this->input->post('inputBoard');
                $postArr['stdID'] = $this->input->post('inputClass');
                $postArr['parentName'] = $this->input->post('inputParentName');
                $postArr['additionalInfo'] = $this->input->post('inputDesc');
                $postArr['status'] = "N";
                $postArr['package'] = $this->input->post('inputPackage');
                $query = $this->student_model->insertEmployee($postArr);
                $insertID = str_pad($query['insertID'], 8, '0', STR_PAD_LEFT);
                $postArr['confirmation_value'] = md5($insertID);
                $postArr['userID'] = $insertID;
                $profile_pic_name = 'profile_pic_'.$insertID.'.jpg';

                //insert user Package type
                if($postArr['package'] == 'B'){
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1');
                    $query_package = $this->package_model->insertPackageSubject($postArr);
                }elseif($postArr['package'] == 'S'){
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1').'#'.$this->input->post('inputSubject2').'#'.$this->input->post('inputSubject3');
                    $query_package = $this->package_model->insertPackageSubject($postArr);
                }elseif($postArr['package'] == 'G'){
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1').'#'.$this->input->post('inputSubject2').'#'.$this->input->post('inputSubject3').'#'.$this->input->post('inputSubject4').'#'.$this->input->post('inputSubject5').'#'.$this->input->post('inputSubject6');
                    $query_package = $this->package_model->insertPackageSubject($postArr);
                }

                if($query['status'])
                {
                    if(!empty($_FILES['inputProfilePic']['name'])){

                        $config['upload_path']   = './assets/images/profile_pic/';
                        $config['allowed_types'] = 'jpeg|jpg|png';
                        $config['file_name']     = $profile_pic_name;
                        $config['overwrite']     = TRUE;
                        $config['max_size']      = 150;
                        $config['max_width']     = 0;
                        $config['max_height']    = 0;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if ( ! $this->upload->do_upload('inputProfilePic')) {
                            $error = array('error' => $this->upload->display_errors());
                            $postArr['profilPic'] = '';

                        }
                        else {
                            $data = array('upload_data' => $this->upload->data());
                            $postArr['profilPic'] = $profile_pic_name;
                        }
                    }else{
                        $postArr['profilPic'] = '';
                    }

                    if($this->student_model->updateEmployee($postArr))
                    {
                        $from_email = "amittendernews@gmail.com";
                        $to_email = $this->input->post('inputEmail');
                        $this->email->set_mailtype("html");
                        $this->email->from($from_email, 'BKZ Admin');
                        $this->email->to($to_email);
                        $this->email->subject('Signup confirmation');
                        $this->email->message('Dear '.$this->input->post('inputFirstName').',<br/>Your password is :'.$password.'<br/> Kindly click to activate your account <a href="'.base_url('activation-link/'.$postArr['confirmation_value']).'">Click here</a>.');

                        //Send mail
                        if($this->email->send()) {
                            $this->session->set_flashdata('message', 'Success! Sign up process has been completed,Confirmation link sent on your registered email ID.');
                        }else {
                            $this->session->set_flashdata('warning', 'Warning! Sign up process has been completed,Error in sending Email.');
                        }
                    }
                    else
                    {
                       $this->session->set_flashdata('warning', 'Success! New User has been added successfully But File has not been updaloaded.');
                   }
               }
               else
               {
                $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
            }
        }
    }
    else
    {
      $this->session->set_flashdata('warning', 'Mandatory field can not be left blank.');
  }

  redirect( base_url('manage-students') );
}

    public function editStudent(){

        $this->form_validation->set_rules('inputFirstName', 'User First Name', 'required');
        $this->form_validation->set_rules('inputLastName', ' User Last Name', 'required');
        $this->form_validation->set_rules('inputContact', 'User Contact', 'required');
        //$this->form_validation->set_rules('inputParentName', 'User\'s Parent Name', 'required');
       // $this->form_validation->set_rules('inputAddress', 'User Address', 'required');
        $this->form_validation->set_rules('inputBoard', 'User Board', 'required');
        $this->form_validation->set_rules('inputSchool', 'User School', 'required');
        $this->form_validation->set_rules('inputClass', 'User Standard', 'required');
        $this->form_validation->set_rules('inputUserStatus', 'User Status', 'required');
        $this->form_validation->set_rules('inputPackage', 'User Package', 'required');

        if ($this->form_validation->run() == TRUE ){

            $postArr['userID'] = $this->input->post('EID');
            $postArr['fName'] = $this->input->post('inputFirstName');
            $postArr['lName'] = $this->input->post('inputLastName');
            $postArr['contactNumber'] = $this->input->post('inputContact');
            $postArr['residenceAdd'] = $this->input->post('inputAddress');
            $postArr['roleID'] = 3;
            $postArr['schoolID'] = $this->input->post('inputSchool');
            $postArr['boardID'] = $this->input->post('inputBoard');
            $postArr['stdID'] = $this->input->post('inputClass');
            $postArr['parentName'] = $this->input->post('inputParentName');
            $postArr['additionalInfo'] = $this->input->post('inputDesc');
            $postArr['status'] = $this->input->post('inputUserStatus');
            $postArr['package'] = $this->input->post('inputPackage');

            $postArr['selectedSubject'] = "";
            //insert user Package type
                if($postArr['package'] == 'B'){
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1');
                    $query_package = $this->package_model->updatePackageSubject($postArr);
                }elseif($postArr['package'] == 'S'){
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1').'#'.$this->input->post('inputSubject2').'#'.$this->input->post('inputSubject3');
                    $query_package = $this->package_model->updatePackageSubject($postArr);
                }elseif($postArr['package'] == 'G'){
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1').'#'.$this->input->post('inputSubject2').'#'.$this->input->post('inputSubject3').'#'.$this->input->post('inputSubject4').'#'.$this->input->post('inputSubject5').'#'.$this->input->post('inputSubject6');
                    $query_package = $this->package_model->updatePackageSubject($postArr);
                }elseif($postArr['package'] == 'T'){
                    $postArr['selectedSubject'] = '0';
                    $query_package = $this->package_model->updatePackageSubject($postArr);
                }

            $profile_pic = $this->input->post('profile_pic');
            if(isset($profile_pic)){
                $picStatus = "Y";
            }else{
                $picStatus = "N";
            }

            if(!empty($_FILES['inputProfilePic']['name'])){
                $profile_pic_name = 'profile_pic_'.$postArr['userID'].'.jpg';
                $config['upload_path']   = './assets/images/profile_pic/';
                $config['allowed_types'] = 'jpeg|jpg|png';
                $config['file_name']     = $profile_pic_name;
                $config['overwrite']     = TRUE;
                $config['max_size']      = 150;
                $config['max_width']     = 0;
                $config['max_height']    = 0;

                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ( ! $this->upload->do_upload('inputProfilePic')) {
                    $error = array('error' => $this->upload->display_errors());
                    $postArr['profilPic'] = '';
					//echo "cond if : ".print_r($error);
                }
                else {
                    $data = array('upload_data' => $this->upload->data());
                    $postArr['profilPic'] = $profile_pic_name;
					//echo "cond else";
                }
            }else if( $picStatus == "Y" ){
				//echo "cond else if";
                $postArr['profilPic'] = $this->input->post('profile_pic');
            }else{
				//echo "cond else else";
                $postArr['profilPic'] = '';
            }
			//echo $picStatus;
            //print_r($config);
			//print_r($postArr);
			//exit;
            if($this->student_model->updateEmployee($postArr))
            {

                $this->session->set_flashdata('message', 'Success! User Details has been updated successfully.');
            }
            else
            {
              if($query_package)
              {
                  $this->session->set_flashdata('message', 'Success! User Details has been updated successfully.');
              }
              else{
                  $this->session->set_flashdata('warning', 'OOPS Something went wrong please try again.');
              }

         }
     }
    else
    {
        $this->upload->display_errors('<p>', '</p>');
        $this->session->set_flashdata('warning', 'Mandatory field can not be left blank.');
    }

    redirect( base_url('manage-students') );
    }

    public function getAlldetails(){

        $this->load->model('role_model');
        $this->load->model('branch_model');
        $this->load->model('department_model');

        $Data['roleArr'] = $this->role_model->getAllRoles();
        $Data['branchArr'] = $this->branch_model->getAllBranches();
        $Data['departmentArr'] = $this->department_model->getAllDepartments();

        return $Data;
    }


//manage package modeul started here

    public function packageConfirm(){

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Manage Package";
        $Data['load_page'] = "students/view_confirm";

        //pagination start here
        $pack_count = $this->student_model->getPackageCount();
        $config['base_url'] = base_url('manage-package');
        $config['total_rows'] = $pack_count;
        $config['per_page'] = $pack_count;
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
        $Data['packageArr'] = $this->student_model->getAllConfirmPackage($config["per_page"], $Data['page']);
        $Data['pagination'] = $this->pagination->create_links();

        $this->load->view("kernel", $Data);
    }

    public function packageUpgarade(){

        $session_data = $this->session->userdata('user_details');
        $userID = $session_data['user_id'];
        $userDetail = $this->student_model->getStudentDetails($userID);

        $Data['package'] = $this->input->post('inputPackage');
        if($userDetail['userPackageType'] != $Data['package']){

            $Data['userID'] = $userID;
            $Data['selectedSubject'] = "";
            //insert user Package type
            if($Data['package'] == 'B'){
                $Data['selectedSubject'] = $this->input->post('inputSubject1');
            }elseif($Data['package'] == 'S'){
                $Data['selectedSubject'] = $this->input->post('inputSubject1').'#'.$this->input->post('inputSubject2').'#'.$this->input->post('inputSubject3');
            }elseif($Data['package'] == 'G'){
                $Data['selectedSubject'] = $this->input->post('inputSubject1').'#'.$this->input->post('inputSubject2').'#'.$this->input->post('inputSubject3').'#'.$this->input->post('inputSubject4').'#'.$this->input->post('inputSubject5').'#'.$this->input->post('inputSubject6');
            }elseif($Data['package'] == 'T'){
                    $Data['selectedSubject'] = 0;
                }

            $confirmStatus = $this->student_model->upgradePackage($Data);
            if($confirmStatus){
                $this->session->set_flashdata('message', 'Success! Request for package upgradation sent successfully.');
            }else{
                $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
            }
        }
        redirect( base_url('signup-paynow/'.$userID) );
        //redirect( base_url('profile') );
    }

    public function confirmPackageUpgarade($eID){
        $dataArr = array();
        $packageDetail = $this->student_model->getConfirmPackageDetail($eID);
            $dataArr['userID'] = $eID;
            $dataArr['package'] = $packageDetail['packageType'];
            $dataArr['selectedSubject'] = $packageDetail['subject_code'];

            $updatePackageSubject = $this->package_model->getActivePackageSubject($eID);

            if(count($updatePackageSubject) > 0){
                $this->package_model->updatePackageSubject($dataArr);
            }else{
                $this->package_model->insertPackageSubject($dataArr);
            }

            $userPachageUpdated = $this->student_model->confirmUpgradePackage($dataArr);
            if($userPachageUpdated){
                $this->session->set_flashdata('message', 'Success! Student package activated successfully.');
            }else{
                $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
            }
        redirect( base_url('manage-package') );
    }
    
    public function resetStudentsFilter(){
        $this->session->unset_tempdata('search_details');
        redirect( base_url('manage-students') );
    }

}
