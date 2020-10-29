<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Signup extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');
        $this->load->library('session');
        $this->load->helper('captcha');
        $this->load->library('email');
        $this->load->library('encryption');
        $this->load->model('student_model');
        $this->load->model('employee_model');
        $this->load->model('role_model');
        $this->load->model('board_model');
        $this->load->model('school_model');
        $this->load->model('class_model');
        $this->load->model('subject_model');
        $this->load->model('package_model');
        $this->load->model('affiliate_code_model');
        $this->load->model('affiliate_student_mapping_model');
    }

    function index($affiliate_parent = '')
    {
        $sData = $this->session->userdata('user_details');

        if ($sData == TRUE) :
            redirect(base_url('home'));
        else :
            $this->signupForm($affiliate_parent);
        endif;
    }

    function signupForm()
    {
       
        $Data['boardArr'] = $this->board_model->getAllActiveBoards();
        $Data['schoolArr'] = $this->school_model->getAllActiveSchools();
        $Data['classArr'] = $this->class_model->getAllActiveClasses();
        $Data['subjectArr'] = $this->subject_model->getAllActiveSubjects();
        $vals = array(
           // 'word'          => 'Random word',
            'img_path'      => './assets/images/captcha_images/',
            'img_url'       => base_url() .'assets/images/captcha_images/',
            'font_path'     => 'system/fonts/texb.ttf',
            'img_width'     => '160',
            'img_height'    => 50,
            'word_length'   => 4,
            // 'font_size'     => 18
        );
       
        $cap = create_captcha($vals);
        $Data['captchaImg'] = $cap['image'];
        //$this->session->set_userdata(array('captcha' => $captcha, 'image' => $cap['time'] . '.jpg'));
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $cap['word']);
        $Data['page_title'] = "Sign Up";
        $Data['load_page'] = "signup/index";
        $this->load->view("kernel", $Data);
    }

    function activateUser($link)
    {

        $Data['status'] = 'Y';
        $Data['loginCount'] = 2;
        $Data['confirmation_value'] = $link;
        $confirmStatus = $this->student_model->activateUser($Data);
        if ($confirmStatus) {
            $this->session->set_flashdata('message', 'Success! Now you can login using your email id and password.');
        } else {
            $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
        }
        redirect(base_url(''));
    }


    function paynow($userID)
    {
       
        $Data['student'] = $this->student_model->getStudentDetails($userID);
      
        $Data['fees'] = 1;
        //"T"=>Free Trial,"B"=>Bronze,"S"=>Silver,"G"=>Gold
        switch ($Data['student']['userPackageType']) {
            case 'T':
                $Data['fees'] = 0;
                $Data['userPackageType'] = 'TRIAL';
                break;
            case 'B':
                $Data['fees'] = 1000;
                $Data['userPackageType'] = 'BRONZE';
                break;
            case 'S':
                $Data['fees'] = 2000;
                $Data['userPackageType'] = 'SILVER';
                break;
            case 'G':
                $Data['fees'] = 3000;
                $Data['userPackageType'] = 'GOLD';
                break;
            default:
                $Data['fees'] = 0;
                break;
        }
        $Data['page_title'] = "Payment";
        $Data['load_page'] = "signup/paynow";
        $this->load->view("kernel", $Data);
    }


    function paysuccess($userID){
        $confirmStatus = $this->student_model->payment_update($userID);
        if ($confirmStatus) {
            $this->session->set_flashdata('message', 'Success! Now you can login using your email id and password.');
            redirect(base_url('student-login'));
        } else {
            $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
            redirect(base_url('student-login'));
        }
    }

    function paymentfail($userID){
          $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
         redirect(base_url('student-login'));
       
    }
    
    function info(){
        $Data['page_title'] = "Welcome";
        $Data['load_page'] = "signup/info";
        $this->load->view("kernel", $Data);
    }


    function paylater($userID)
    {
        $student = $this->student_model->getStudentDetails($userID);
        $Data['page_title'] = "Paylater";
        $Data['load_page'] = "signup/paylater";
        $from_email = "info@bkzquiz.com";
        $to_email = $student['emailID'];
        $this->email->set_mailtype("html");
        $this->email->from($from_email, 'BKZ Admin');
        $this->email->to($to_email);
        $this->email->subject('Offline Payment');
        $this->email->message('Dear ' . $student['fName'] . ', Offline bank details. You can NEFT.');
        //Send mail
        if ($this->email->send()) {
            $this->session->set_flashdata('message', 'Success! Offline payment details are sent on your registered email ID.');
        } else {
            $this->session->set_flashdata('warning', 'Error in sending Email.');
        }
        $this->load->view("kernel", $Data);
    }

    public function captchaRefresh()
    {
        $vals = array(
            // 'word'          => 'Random word',
            'img_path'      => './assets/images/captcha_images/',
            'img_url'       => base_url() .'assets/images/captcha_images/',
             'font_path'     => 'system/fonts/texb.ttf',
             'img_width'     => '160',
             'img_height'    => 50,
             'word_length'   => 4,
             // 'font_size'     => 18
         );
        $captcha = create_captcha($vals);
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode', $captcha['word']);
        echo $captcha['image'];
    }
    function processUserSignup()
    {

        $this->form_validation->set_rules('inputFirstName', 'User First Name', 'required');
        $this->form_validation->set_rules('inputLastName', ' User Last Name', 'required');
        //$this->form_validation->set_rules('inputEmail', 'User Email', 'trim|required');
        $this->form_validation->set_rules('inputEmail', 'User Email', 'trim|required|valid_email|callback_email_check');
        $this->form_validation->set_rules('inputContact', 'User Mobile Number ', 'required|regex_match[/^[0-9]{10}$/]|callback_phone_number_check');
        $this->form_validation->set_rules('inputBoard', 'User Board', 'required');
        $this->form_validation->set_rules('inputSchool', 'User School', 'required');
        $this->form_validation->set_rules('inputClass', 'User Standard', 'required');
        $this->form_validation->set_rules('inputPackage', 'User Package', 'required');
        $this->form_validation->set_rules('captcha', 'Captcha', 'required');
        $this->form_validation->set_rules('inputPassword', 'Password', 'trim|required|min_length[4]|max_length[25]');
        $this->form_validation->set_rules('inputConfirmPassword', 'Confirm Password', 'trim|required|min_length[4]|max_length[25]');
        if($this->input->post('affiliateCode'))
            $this->form_validation->set_rules('affiliateCode', 'Affiliate Code', 'trim|callback_affiliate_code_check');

         $inputCaptcha = $this->input->post('captcha');
         $sessCaptcha = $this->session->userdata('captchaCode');
        
        

        if ($this->form_validation->run() == FALSE) {
           
            //$errors = validation_errors();
            $array = array(
                'error'   => true,
                'first_name_error' => form_error('inputFirstName'),
                'last_name_error' => form_error('inputLastName'),
                'email_error' => form_error('inputEmail'),
                'contact_error' => form_error('inputContact'),
                'board_error' => form_error('inputBoard'),
                'school_error' => form_error('inputSchool'),
                'class_error' => form_error('inputClass'),
                'pacckage_error' => form_error('inputPackage'),
                'password_error' => form_error('inputPassword'),
                'confirm_password_error' => form_error('inputConfirmPassword'),
                'affiliate_code_error' => form_error('affiliateCode'),
                'captcha_error' => form_error('captcha'),
            );

            echo json_encode($array);
        } else {
            if($inputCaptcha !== $sessCaptcha){
                $array = array(
                    'error'   => true,
                    'captcha_error' => 'Captcha not matched',
                );
                
                echo json_encode($array);
                return;
            }
            
            if ($this->input->post('inputPassword') != $this->input->post('inputConfirmPassword')) {
                $this->session->set_flashdata('warning', 'Password and Confirm Password is not same.');
                $array = array(
                    'error'   => true,
                    'confirm_password_error' => 'Password and Confirm Password is not same.'
                );
                $status = 'N';
                echo json_encode($array);
            } else {
                $postArr['fName'] = $this->input->post('inputFirstName');
                $postArr['lName'] = $this->input->post('inputLastName');
                $postArr['contactNumber'] = $this->input->post('inputContact');
                $postArr['residenceAdd'] = "";
                $postArr['emailID'] = $this->input->post('inputEmail');
                $postArr['password'] = $this->input->post('inputPassword');
                $postArr['roleID'] = 3;
                $postArr['schoolID'] = $this->input->post('inputSchool');
                $postArr['boardID'] = $this->input->post('inputBoard');
                $postArr['stdID'] = $this->input->post('inputClass');
                $postArr['parentName'] = "";
                $postArr['additionalInfo'] = "";
                $postArr['status'] = "N";
                $postArr['package'] = $this->input->post('inputPackage');
                $postArr['affiliateID'] = "";
                $postArr['profilPic'] = '';
               
                $query = $this->student_model->insertEmployee($postArr);
                $insertID = str_pad($query['insertID'], 8, '0', STR_PAD_LEFT);
                $postArr['confirmation_value'] = md5($insertID);
                $postArr['userID'] = $insertID;
                $postArr['selectedSubject'] = $this->input->post('inputSubject');
                //$profile_pic_name = 'profile_pic_'.$insertID.'.jpg';
                if($this->input->post('affiliateCode')){
                    $affData = $this->getAffiliate($this->input->post('affiliateCode'));
                    $affPostData = [];
                    $affPostData['student_id'] =  $insertID;
                    $affPostData['affiliate_id'] =  $affData[0]['affiliateId'];
                    $this->affiliate_student_mapping_model->insertStudentAffiliate($affPostData);
                }

                if ($this->input->post('inputSubject')) {
                    $arr['selectedSubject'] = $this->input->post('inputSubject');
                    $arr['userID'] = $insertID;
                    $query_package = $this->package_model->insertPackageSubjectNew($arr);
                }
               
                $confirmStatus = $this->student_model->upgradePackage($postArr);

                if ($query['status']) {
                    $from_email = "info@bkzquiz.com";
                    $to_email = $this->input->post('inputEmail');
                    $this->email->set_mailtype("html");
                    $this->email->from($from_email, 'BKZ Admin');
                    $this->email->to($to_email);
                    $this->email->subject('Signup confirmation');
                    $this->email->message('Dear ' . $this->input->post('inputFirstName') . ', Kindly click to activate your account <a href="' . base_url('activation-link/' . $postArr['confirmation_value']) . '">Click here</a>.');
                    $this->session->set_flashdata('message', 'Success! Sign up process has been completed,Confirmation link sent on your registered email ID.');
                    //redirect( base_url('signup-paynow/'.$insertID) );
                    $success_arr = array(
                        "success" => true,
                        "message" => "Success! Sign up process has been completed,Confirmation link sent on your registered email ID.",
                        "name" =>  $postArr['fName']." ". $postArr['lName'],
                        "email" => $postArr['emailID'],
                        "userId" => $insertID,
                        "packageType" => $postArr['package']
                    );
                    echo json_encode($success_arr);
                } else {
                    $success_arr = array(
                        "success" => false,
                        "message" => "oops Something went wrong please try again."
                    );
                    echo json_encode($success_arr);
                }
            }
        }
       
    }

    public function email_check($str)
    {
        if ($this->employee_model->getEmployeeCountByEmailid($str) > 0) {
            $this->form_validation->set_message('email_check', 'Email Id is already registered with us,try with another.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function phone_number_check($str)
    {
        if($str !== "")
        {
            if ($this->employee_model->getEmployeeCountByPhone($str) > 0) {
                $this->form_validation->set_message('phone_number_check', 'Contact numbber is already registered with us,try with another.');
                return FALSE;
            } else {
                return TRUE;
            }
        }
        
    }

    public function affiliate_code_check($str)
    {
        if ($this->affiliate_code_model->getCodeCount($str) > 0) {
            return TRUE;
        } else {
            $this->form_validation->set_message('affiliate_code_check', 'Code is not valid.');
            return FALSE;
        }
    }

    public function getAffiliate($str)
    {
       return $this->affiliate_code_model->getAffiliate($str);
    }
   
    function processAffiliateUserSignup()
    {

        $post = $this->input->post();
        if (isset($post)) {
            $this->form_validation->set_rules('inputAffFirstName', 'User First Name', 'required');
            $this->form_validation->set_rules('inputAffLastName', ' User Last Name', 'required');
            $this->form_validation->set_rules('inputDateofbirth', ' Date of birth', 'required');
            $this->form_validation->set_rules('inputAffEmail', 'User Email', 'trim|required|valid_email|callback_email_check');
            $this->form_validation->set_rules('inputAffContact', 'User Contact', 'required|regex_match[/^[0-9]{10}$/]');
            $this->form_validation->set_rules('inputAffPassword', 'Password', 'trim|required|min_length[4]|max_length[25]');
            $this->form_validation->set_rules('inputAffConfirmPassword', 'Confirm Password', 'trim|required|min_length[4]|max_length[25]');
            $this->form_validation->set_rules('captcha', 'Captcha', 'required');

            $inputCaptcha = $this->input->post('captcha');
            $sessCaptcha = $this->session->userdata('captchaCode');
            $calcAge = $this->calculateAge($this->input->post('inputDateofbirth'));
            if ($this->form_validation->run() == FALSE) {
                $array = array(
                    'error'   => true,
                    'first_name_error' => form_error('inputAffFirstName'),
                    'last_name_error' => form_error('inputAffLastName'),
                    'email_error' => form_error('inputAffEmail'),
                    'contact_error' => form_error('inputAffContact'),
                    'date_of_birth_error' => form_error('inputDateofbirth'),
                    'password_error' => form_error('inputAffPassword'),
                    'confirm_password_error' => form_error('inputAffConfirmPassword'),
                    'captcha_error' => form_error('captcha')
                );

                echo json_encode($array);
            } else {
                if($inputCaptcha !== $sessCaptcha){
                    $array = array(
                        'error'   => true,
                        'captcha_error' => 'Captcha not matched',
                    );
                    
                    echo json_encode($array);
                    return;
                }
                if ($this->employee_model->getEmployeeCountByEmailid($this->input->post('inputEmail')) > 0 || $this->employee_model->getEmployeeCountByEmailid($this->input->post('inputAffEmail')) > 0) {
                    $array = array(
                        'error'   => true,
                        'email_error' => 'Email Id is already registered with us,try with another.'
                    );
                    echo json_encode($array);
                } elseif ($calcAge < 18) {
                    $array = array(
                        'error'   => true,
                        'date_of_birth_error' => 'Age is not 18 years. You cannot register as affiliate.'
                    );
                    echo json_encode($array);
                } else {
                    $password = random_string('alnum', 8);
                    $postArr['fName'] = $this->input->post('inputAffFirstName');
                    $postArr['lName'] = $this->input->post('inputAffLastName');
                    $postArr['birthDate'] = $this->input->post('inputDateofbirth');
                    $postArr['emailID'] = $this->input->post('inputAffEmail');
                    $postArr['contactNumber'] = $this->input->post('inputAffContact');
                    $postArr['isAffiliateUser'] = 'Y';
                    $postArr['inputAffPassword'] =  $this->input->post('inputAffPassword');;
                    $postArr['status'] = "N";
                    $postArr['roleID'] = 7;
                    $postArr['parentID'] = $this->input->post('parentID');
                    $postArr['package'] = "";
                    $postArr['residenceAdd'] = "";
                    $postArr['additionalInfo'] = "";
                    $postArr['profilPic'] = '';
                    $query = $this->student_model->insertAffiliate($postArr);

                    $insertID = str_pad($query['insertID'], 8, '0', STR_PAD_LEFT);
                    $postArr['confirmation_value'] = md5($insertID);
                    $postArr['userID'] = $insertID;
                    $affiliateArr['affiliateId'] = $insertID;
                    $affiliateArr['code'] = random_string('alnum', 6);;
                    $affiliateQuery = $this->affiliate_code_model->insertAffiliate($affiliateArr);
                    //  $profile_pic_name = 'profile_pic_'.$insertID.'.jpg';
                    // $confirmStatus = $this->student_model->upgradePackage($postArr,true);

                    // if(isset($studentArr) && $studentArr['userID'] != ''){
                    //     $postArr['affiliateStudentMapping'] = $studentArr['userID'];
                    // }
                    // $this->calculateCommission($insertID);

                    if ($query['status']) {

                        $extra_params['redirect'] = true;
                        $extra_params['sendSMS'] = true;
                        $this->sendMail($postArr, $extra_params);
                       // $this->session->set_flashdata('message', 'Success! Sign up process has been completed.');
                        $success_arr = array(
                            "success" => true,
                            "message" => "Success! Sign up process has been completed."
                        );
                        echo json_encode($success_arr);
                    } else {
                        $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
                        $success_arr = array(
                            "success" => false,
                            "message" => "oops Something went wrong please try again."
                        );
                        echo json_encode($success_arr);
                    }
                }
            }
        }
    }

    function processAffiliateUserSignupOld()
    {
        $warning = 'All fields are mandatory.';
        // echo '<pre>';print_r($this->input->post());echo '</pre>';
        $post = $this->input->post();
        if (isset($post)) {
            $this->form_validation->set_rules('inputAffFirstName', 'User First Name', 'required');
            $this->form_validation->set_rules('inputAffLastName', ' User Last Name', 'required');
            $this->form_validation->set_rules('inputDateofbirth', ' User Last Name', 'required');
            $this->form_validation->set_rules('inputAffEmail', 'User Email', 'required|valid_email');
            $this->form_validation->set_rules('inputAffContact', 'User Contact', 'required|numeric|min_length[10]|max_length[10]');
            //$this->form_validation->set_rules('inputAddress', 'User Address', 'required');
            $registerStudent = $this->input->post('inputRegisterStudent');
            if (isset($registerStudent) &&  $registerStudent == true) {
                $this->form_validation->set_rules('inputFirstName', 'User First Name', 'required');
                $this->form_validation->set_rules('inputEmail', 'User Email', 'required|valid_email|differs[inputAffEmail]');
                $this->form_validation->set_rules('inputBoard', 'User Board', 'required');
                $this->form_validation->set_rules('inputSchool', 'User School', 'required');
                $this->form_validation->set_rules('inputClass', 'User Standard', 'required');

                $warning .= '</br>Email shall be unique';
            }
            $calcAge = $this->calculateAge($this->input->post('inputDateofbirth'));
            // echo 'age ='.$calcAge;
            // echo 'VAlidation ='.($this->form_validation->run() === TRUE);
            // exit;
            if ($this->form_validation->run() === TRUE) {
                if ($this->employee_model->getEmployeeCountByEmailid($this->input->post('inputEmail')) > 0 || $this->employee_model->getEmployeeCountByEmailid($this->input->post('inputAffEmail')) > 0) {
                    $this->session->set_flashdata('warning', 'Email Id is already registered with us,try with another.');
                } elseif ($calcAge < 18) {
                    $this->session->set_flashdata('warning', 'Age is not 18 years. You cannot register as affiliate.');
                } else {
                    $password = random_string('alnum', 8);
                    $postArr['fName'] = $this->input->post('inputAffFirstName');
                    $postArr['lName'] = $this->input->post('inputAffLastName');
                    $postArr['birthDate'] = $this->input->post('inputDateofbirth');
                    $postArr['emailID'] = $this->input->post('inputAffEmail');
                    $postArr['contactNumber'] = $this->input->post('inputAffContact');
                    $postArr['isAffiliateUser'] = 'Y';
                    $postArr['password'] = $password;
                    $postArr['status'] = "N";
                    $postArr['roleID'] = 8;
                    $postArr['parentID'] = $this->input->post('parentID');
                    $postArr['package'] = $this->input->post('inputPackageAffiliate');
                    $postArr['residenceAdd'] = $this->input->post('inputAddress');
                    $postArr['additionalInfo'] = $this->input->post('inputDesc');

                    $query = $this->student_model->insertAffiliate($postArr);

                    $insertID = str_pad($query['insertID'], 8, '0', STR_PAD_LEFT);
                    $postArr['confirmation_value'] = md5($insertID);
                    $postArr['userID'] = $insertID;
                    $profile_pic_name = 'profile_pic_' . $insertID . '.jpg';
                    $confirmStatus = $this->student_model->upgradePackage($postArr, true);

                    if ($this->input->post('inputRegisterStudent')) {
                        $password = random_string('alnum', 8);
                        $studentArr['fName'] = $this->input->post('inputFirstName');
                        $studentArr['lName'] = $this->input->post('inputLastName') ? $this->input->post('inputLastName') :  $this->input->post('inputAffLastName');
                        $studentArr['contactNumber'] = $this->input->post('inputContact') ? $this->input->post('inputContact') : $this->input->post('inputAffContact');
                        $studentArr['emailID'] = $this->input->post('inputEmail');
                        $studentArr['password'] = $password;
                        $studentArr['roleID'] = 3;
                        $studentArr['schoolID'] = $this->input->post('inputSchool');
                        $studentArr['boardID'] = $this->input->post('inputBoard');
                        $studentArr['stdID'] = $this->input->post('inputClass');
                        $studentArr['parentName'] = Null;
                        $studentArr['status'] = "N";
                        $studentArr['package'] = $this->input->post('inputPackageAffiliate');
                        $studentArr['residenceAdd'] = Null;
                        $studentArr['additionalInfo'] = Null;
                        $studentArr['profilPic'] = Null;
                        $studentArr['affiliateID'] = $insertID;

                        $studentquery = $this->student_model->insertEmployee($studentArr);
                        $insertID_student = str_pad($studentquery['insertID'], 8, '0', STR_PAD_LEFT);
                        $studentArr['confirmation_value'] = md5($insertID_student);
                        $studentArr['userID'] = $insertID_student;
                        $studentArr['selectedSubject'] = "";
                        //insert user Package type
                        if ($studentArr['package'] == 'B') {
                            $studentArr['selectedSubject'] = $this->input->post('inputSubjectAfflt1');
                            $query_package = $this->package_model->insertPackageSubject($studentArr);
                        } elseif ($studentArr['package'] == 'S') {
                            $studentArr['selectedSubject'] = $this->input->post('inputSubjectAfflt1') . '#' . $this->input->post('inputSubjectAfflt2') . '#' . $this->input->post('inputSubjectAfflt3');
                            $query_package = $this->package_model->insertPackageSubject($studentArr);
                        } elseif ($studentArr['package'] == 'G') {
                            $studentArr['selectedSubject'] = $this->input->post('inputSubjectAfflt1') . '#' . $this->input->post('inputSubjectAfflt2') . '#' . $this->input->post('inputSubjectAfflt3') . '#' . $this->input->post('inputSubjectAfflt4') . '#' . $this->input->post('inputSubjectAfflt5') . '#' . $this->input->post('inputSubjectAfflt6');
                            $query_package = $this->package_model->insertPackageSubject($studentArr);
                        }
                        $confirmStatus_student = $this->student_model->upgradePackage($studentArr);

                        $confirmStatus_affiliate = $this->student_model->upgradePackage($postArr, true);

                        if ($studentquery['status']) {
                            $this->student_model->updateEmployee($studentArr);
                            $extra_params['redirect'] = false;
                            $extra_params['sendSMS'] = true;
                            $this->sendMail($studentArr, $extra_params);
                        }
                    }
                    if (isset($studentArr) && $studentArr['userID'] != '') {
                        $postArr['affiliateStudentMapping'] = $studentArr['userID'];
                    }
                    $this->calculateCommission($insertID);

                    if ($query['status']) {
                        if (!empty($_FILES['inputProfilePic']['name'])) {

                            $config['upload_path']   = './assets/images/profile_pic/';
                            $config['allowed_types'] = 'jpeg|jpg|png';
                            $config['file_name']     = $profile_pic_name;
                            $config['overwrite']     = TRUE;
                            $config['max_size']      = 250;
                            $config['max_width']     = 0;
                            $config['max_height']    = 0;
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('inputProfilePic')) {
                                $error = array('error' => $this->upload->display_errors());
                                $postArr['profilPic'] = '';
                            } else {
                                $data = array('upload_data' => $this->upload->data());
                                $postArr['profilPic'] = $profile_pic_name;
                            }
                        } else {
                            $postArr['profilPic'] = '';
                        }

                        if ($this->student_model->updateAffiliate($postArr)) {
                            $extra_params['redirect'] = true;
                            $extra_params['sendSMS'] = true;
                            $this->sendMail($postArr, $extra_params);
                        } else {

                            //$this->session->set_flashdata('warning', 'Success! Sign up process has been completed But File has not been updaloaded.');
                        }
                    } else {
                        $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
                    }
                }
            } else {
                $this->session->set_flashdata('warning', $warning);
            }
        }
        if ($this->input->post('parentID') > 0) {
            $enc_username = $this->encryption->encode($this->input->post('parentID'));
            $enc_username = str_replace(array('+', '/', '='), array('-', '_', '~'), $enc_username);
            redirect(base_url('signup/' . $enc_username));
        } else {
            redirect(base_url('signup'));
        }
    }

    public function calculateAge($dateOfBirth)
    {
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        return $diff->format('%y');
    }

    public function sendMail($details, $extra_params)
    {
        $from_email = "info@bkzquiz.com";
        //$to_email = '';
        $to_email = $details['emailID'];
        //$to_email .= "bigkzone9@gmail.com";
        $this->email->set_mailtype("html");
        $this->email->from($from_email, 'BKZ Admin');
        $this->email->to($to_email);
        $this->email->subject('Signup confirmation');
        $this->email->message('Dear ' . $details['fName'] . ',Kindly click to activate your account <a href="' . base_url('activation-link/' . $details['confirmation_value']) . '">Click here</a>. After login please change your password.');
        //Send mail
        if ($this->email->send()) {
            $this->session->set_flashdata('message', 'Success! Sign up process has been completed,Confirmation link sent on your registered email ID.');

            //SMS API
            // if ($extra_params['sendSMS']) {
            //     $smsMsg = "Thank you for registering on bkzquiz.com. User : " . $details['emailID'] . " Pass :" . $details['password'] . " After login please change your password.";
            //     $smsAPI = 'https://control.msg91.com/api/sendhttp.php?authkey=168023AOu8BcGU6598167db&mobiles=' . $details['contactNumber'] . '&message=' . urlencode($smsMsg) . '&sender=BKZQUZ&route=4&country=91';
            //     $test = file_get_contents($smsAPI);
            // }

            // if ($extra_params['redirect']) {
            //     redirect(base_url('signup-paynow/' . $details['userID']));
            // }
        } else {
            $this->session->set_flashdata('warning', 'Warning! Sign up process has been completed,Error in sending Email.');
        }
    }

    public function getsubjectbystds()
    {
        if ($_POST) {
            $param['stdid'] = $_POST['stdid'];
            $res = $this->subject_model->getsubjectsbystd($param);
            if (is_array($res)) {
                $data['error'] = FALSE;
                $data['msg'] = 'Data found';
                $data['data'] = $res;
            } else {
                $data['error'] = TRUE;
                $data['msg'] = 'No data found';
                $data['data'] = FALSE;
            }
        } else {
            $data['error'] = TRUE;
            $data['msg'] = 'No parameter received';
            $data['data'] = FALSE;
        }
        echo json_encode($data);
    }

    public function getParentID($affiliateLink)
    {
        $userLink = str_replace(array('-', '_', '~'), array('+', '/', '='), $affiliateLink);
        $parentID = $this->encryption->decrypt($userLink);
        return $parentID;
    }

    public function calculateCommission($affiliateID)
    {
        $this->student_model->insertCommision($affiliateID);
    }

    function processStudentRegister()
    {
        $this->load->model('affiliate_model');
        $this->form_validation->set_rules('inputFirstName', 'User First Name', 'required');
        $this->form_validation->set_rules('inputLastName', ' User Last Name', 'required');
        $this->form_validation->set_rules('inputEmail', 'User Email', 'trim|required');
        //print_r($this->input->post());exit;
        $this->form_validation->set_rules('inputContact', 'User Contact', 'required|numeric|min_length[10]|max_length[10]');
        // $this->form_validation->set_rules('inputParentName', 'User\'s Parent Name', 'required');
        //  $this->form_validation->set_rules('inputAddress', 'User Address', 'required');
        $this->form_validation->set_rules('inputBoard', 'User Board', 'required');
        $this->form_validation->set_rules('inputSchool', 'User School', 'required');
        $this->form_validation->set_rules('inputClass', 'User Standard', 'required');
        $this->form_validation->set_rules('inputPackage', 'User Package', 'required');

        if ($this->form_validation->run() === TRUE) {

            if ($this->employee_model->getEmployeeCountByEmailid($this->input->post('inputEmail')) > 0) {
                $this->session->set_flashdata('warning', 'Email Id is already registered with us,try with another.');
            } else {
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
                $postArr['affiliateID'] = $this->input->post('aff_student_mapping');
                $postArr['status'] = "Y";
                $postArr['package'] = $this->input->post('inputPackage');
                $query = $this->student_model->insertEmployee($postArr);
                $insertID = str_pad($query['insertID'], 8, '0', STR_PAD_LEFT);
                $postArr['confirmation_value'] = md5($insertID);
                $postArr['userID'] = $insertID;
                $profile_pic_name = 'profile_pic_' . $insertID . '.jpg';

                $postArr['selectedSubject'] = "";
                //insert user Package type
                if ($postArr['package'] == 'B') {
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1');
                    $query_package = $this->package_model->insertStudentSubject($postArr);
                } elseif ($postArr['package'] == 'S') {
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1') . '#' . $this->input->post('inputSubject2') . '#' . $this->input->post('inputSubject3');
                    $query_package = $this->package_model->insertStudentSubject($postArr);
                } elseif ($postArr['package'] == 'G') {
                    $postArr['selectedSubject'] = $this->input->post('inputSubject1') . '#' . $this->input->post('inputSubject2') . '#' . $this->input->post('inputSubject3') . '#' . $this->input->post('inputSubject4') . '#' . $this->input->post('inputSubject5') . '#' . $this->input->post('inputSubject6');
                    $query_package = $this->package_model->insertStudentSubject($postArr);
                }
                //print_r($postArr);exit;
                $confirmStatus = $this->student_model->upgradePackage($postArr);
                if ($insertID) {
                    $this->affiliate_model->mappStudent(array('userID' => $this->input->post('aff_student_mapping'), 'affiliateStudentMapping' => $insertID));
                }
                if ($query['status']) {
                    $postArr['profilPic'] = '';
                    if ($this->student_model->updateEmployee($postArr)) {
                        $from_email = "info@bkzquiz.com";
                        //$to_email = '';
                        $to_email = $this->input->post('inputEmail');
                        //$to_email .= "bigkzone9@gmail.com";
                        $this->email->set_mailtype("html");
                        $this->email->from($from_email, 'BKZ Admin');
                        $this->email->to($to_email);
                        $this->email->subject('Signup confirmation');
                        $this->email->message('Dear ' . $this->input->post('inputFirstName') . ',<br/>Your password is :' . $password . '<br/> Kindly click to activate your account <a href="' . base_url('activation-link/' . $postArr['confirmation_value']) . '">Click here</a>.');

                        //Send mail
                        if ($this->email->send()) {
                            $this->session->set_flashdata('message', 'Success! Sign up process has been completed,Confirmation link sent on your registered email ID.');

                            //SMS API
                            $smsMsg = "Thank you for registering on bkzquiz.com. User : " . $postArr['emailID'] . " Pass : $password";
                            $smsAPI = 'https://control.msg91.com/api/sendhttp.php?authkey=168023AOu8BcGU6598167db&mobiles=' . $postArr['contactNumber'] . '&message=' . urlencode($smsMsg) . '&sender=BKZQUZ&route=4&country=91';
                            $test = file_get_contents($smsAPI);

                            redirect(base_url('register-student'));
                        } else {
                            $this->session->set_flashdata('warning', 'Warning! Sign up process has been completed,Error in sending Email.');
                        }
                    } else {

                        //$this->session->set_flashdata('warning', 'Success! Sign up process has been completed But File has not been updaloaded.');
                    }
                } else {
                    $this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
                }
            }
        } else {
            $this->session->set_flashdata('warning', 'All fields are mandetory.');
        }
        //echo 'test';exit;       
        redirect(base_url('register-student'));
    }
}
