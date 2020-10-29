<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login/index';
$route['student-login'] = 'login/studentlogin';
$route['affiliate-login'] = 'login/affiliatelogin';
$route['admin-login'] = 'login/superadminlogin';
//$route['login'] = 'login/index';
$route['home'] = 'home/index';
$route['qa'] = 'home/qa';
$route['signup'] = 'signup/signupform';
$route['captcha-refresh'] = 'signup/captchaRefresh';
$route['signup-paynow/(:any)'] = 'signup/paynow/$1';
$route['signup-paynow'] = 'signup/paynow';
$route['paynow-success/(:any)'] = 'signup/paysuccess/$1';
$route['paynow-fail/(:any)'] = 'signup/paymentfail/$1';
$route['signup-paylater/(:any)'] = 'signup/paylater/$1';
$route['signup-payout'] = 'signup/payout';
$route['submit-signup'] = 'signup/processUserSignup';
$route['submit-signup-affiliate'] = 'signup/processAffiliateUserSignup';
$route['paynow-modal'] = 'signup/paynowModal';
$route['info'] = 'signup/info';
$route['activation-link/(:any)'] = 'signup/activateUser/$1';
$route['evaluation'] = 'evaluation/index';
$route['ajax-subject-chapter'] = 'evaluation/ajax_get_chapter_subject';
//Question Manager
$route['qm'] = 'questionManager/index';
$route['questions-list-manager'] = 'questionManager/questionListManager';
//end

$route['home-graph-data'] = 'home/graph_data';
$route['home-graph-data-ajax'] = 'home/ajaxAdminReportGraph';
$route['home-bar-sub-cat-graph-data'] = 'home/sub_cat_graph_data';
$route['home-pie-chart-left-data'] = 'home/pie_chart_left_data';
$route['home-pie-chart-right-data'] = 'home/pie_chart_right_data';
$route['home-bar-channel-cmp-type-data'] = 'home/bar_channel_cmp_type';
$route['logout'] = 'login/logout';

$route['affiliate-students-list'] = 'affiliate/studentsList';
$route['commission-earned'] = 'affiliate/index';
$route['commission-earned/(:any)'] = 'affiliate/index/$i';
$route['affiliate-tree'] = 'affiliate/affiliateTree';
$route['withdrawal-request'] = 'affiliate/withdrawal_request';
$route['affiliate-payments'] = 'affiliate/affiliate_payments';
$route['open-edit-affiliate-withdrawl-modal/(:any)'] = 'affiliate/editWithdrawl/$1';
$route['submit-edit-withdrawl'] = 'affiliate/affiliate_payments_update';
$route['register-student'] = 'affiliate/registerStudent';
$route['process-register-student'] = 'signup/processStudentRegister';


$route['school-toppers/(:any)'] = 'api/schoolToppers/$1';
$route['overall-toppers'] = 'api/bkzToppers';
$route['schools-list'] = 'api/schoolList';
$route['schools-list'] = 'api/schoolList';
$route['student-marks'] = 'api/studentMarks';
$route['profile'] = 'students/viewProfile';
//Package upgradation @krishna Gupta #02042017
$route['manage-package'] = 'students/packageConfirm';
$route['manage-package/(:any)'] = 'students/packageConfirm/$i';
$route['upgrade-package'] = 'students/packageUpgarade';
$route['confirm-upgrade-package/(:any)'] = 'students/confirmPackageUpgarade/$1';
//~~~~~~~~~~-------------------------------Krishna----------------------------------~~~~~~~~~~~~~~//

//Roles @Krishna Gupta #13082016
$route['manage-roles'] = 'roles/index';
$route['manage-roles/(:any)'] = 'roles/index/$1';
$route['open-add-role-modal'] = 'roles/addModal';
$route['open-edit-role-modal/(:any)'] = 'roles/editModal/$1';
$route['submit-add-role'] = 'roles/addRole';
$route['submit-edit-role'] = 'roles/editRole';

//Boards @Krishna Gupta #13082016
$route['manage-boards'] = 'boards/index';
$route['manage-boards/(:any)'] = 'boards/index/$1';
$route['open-add-board-modal'] = 'boards/addModal';
$route['open-edit-board-modal/(:any)'] = 'boards/editModal/$1';
$route['submit-add-board'] = 'boards/addBoard';
$route['submit-edit-board'] = 'boards/editBoard';

//Classes @Krishna Gupta #13082016
$route['manage-classes'] = 'classes/index';
$route['manage-classes/(:any)'] = 'classes/index/$1';
$route['open-add-class-modal'] = 'classes/addModal';
$route['open-edit-class-modal/(:any)'] = 'classes/editModal/$1';
$route['open-view-class-modal/(:any)'] = 'classes/viewModal/$1';
$route['submit-add-class'] = 'classes/addClass';
$route['submit-edit-class'] = 'classes/editClass';

//Level @krishna gupta #13082016
$route['manage-level'] = 'level/index';
$route['manage-level/(:any)'] = 'level/index/$1';
$route['open-add-level-modal'] = 'level/addModal';
$route['open-edit-level-modal/(:any)'] = 'level/editModal/$1';
$route['submit-add-level'] = 'level/addLevel';
$route['submit-edit-level'] = 'level/editLevel';

//Stage @krishna gupta #13082016
$route['manage-stages'] = 'stages/index';
$route['manage-stages/(:any)'] = 'stages/index/$1';
$route['open-add-stage-modal'] = 'stages/addModal';
$route['open-edit-stage-modal/(:any)'] = 'stages/editModal/$1';
$route['submit-add-stage'] = 'stages/addStage';
$route['submit-edit-stage'] = 'stages/editStage';
$route['ajax-get-stage'] = 'stages/ajaxStage';

//Subject @krishna gupta #13082016
$route['manage-subjects'] = 'subjects/index';
$route['manage-subjects/(:any)'] = 'subjects/index/$1';
$route['open-add-subject-modal'] = 'subjects/addModal';
$route['open-edit-subject-modal/(:any)'] = 'subjects/editModal/$1';
$route['submit-add-subject'] = 'subjects/addSubject';
$route['submit-edit-subject'] = 'subjects/editSubject';

//Subject @krishna gupta #21012017
$route['manage-chapters'] = 'chapters/index';
$route['manage-chapters/(:any)'] = 'chapters/index/$1';
$route['open-add-chapter-modal'] = 'chapters/addModal';
$route['open-edit-chapter-modal/(:any)'] = 'chapters/editModal/$1';
$route['submit-add-chapter'] = 'chapters/addChapter';
$route['submit-edit-chapter'] = 'chapters/editChapter';
$route['chapters-reset-filter'] = 'chapters/resetChaptersFilter';
$route['chapter-questions'] = 'chapters/viewChapterQuestions';
$route['ajax-get-answer'] = 'chapters/ajax_get_answer';

//Customer_type @krishna gupta #13082016
$route['manage-customers-type'] = 'customers_type/index';
$route['manage-customers-type/(:any)'] = 'customers_type/index/$1';
$route['open-add-customer-type-modal'] = 'customers_type/addModal';
$route['open-edit-customer-type-modal/(:any)'] = 'customers_type/editModal/$1';
$route['submit-add-customer-type'] = 'customers_type/addCustomer_type';
$route['submit-edit-customer-type'] = 'customers_type/editCustomer_type';

//Roles @Krishna Gupta #16082016
$route['manage-schools'] = 'schools/index';
$route['manage-schools/(:any)'] = 'schools/index/$1';
$route['open-add-school-modal'] = 'schools/addModal';
$route['open-edit-school-modal/(:any)'] = 'schools/editModal/$1';
$route['submit-add-school'] = 'schools/addSchool';
$route['submit-edit-school'] = 'schools/editSchool';
$route['schools-reset-filter'] = 'schools/resetSchoolsFilter';

//Employees @Krishna Gupta #13082016
$route['manage-users'] = 'employees/index';
$route['manage-users-list'] = 'employees/getlists';
$route['manage-users/(:any)'] = 'employees/index/$1';
$route['open-add-user-modal'] = 'employees/addModal';
$route['open-edit-user-modal/(:any)'] = 'employees/editModal/$1';
$route['open-view-user-modal/(:any)'] = 'employees/viewModal/$1';
$route['submit-add-user'] = 'employees/addEmployee';
$route['submit-edit-user'] = 'employees/editEmployee';
$route['submit-edit-user-display-pic'] = 'employees/editEmployeeDisplayPic';
$route['update-profile'] = 'employees/updateProfile';
$route['open-edit-profile-modal'] = 'employees/editProfileModal';
$route['users-reset-filter'] = 'employees/resetUsersFilter';


//Students @Krishna Gupta #19022017
$route['manage-students'] = 'students/index';
$route['manage-students/(:any)'] = 'students/index/$1';
$route['open-add-student-modal'] = 'students/addModal';
$route['open-edit-student-modal/(:any)'] = 'students/editModal/$1';
$route['open-view-student-modal/(:any)'] = 'students/viewModal/$1';
$route['submit-add-student'] = 'students/addStudent';
$route['submit-edit-student'] = 'students/editStudent';
$route['students-reset-filter'] = 'students/resetStudentsFilter';

$route['manage-affiliates'] = 'affiliate/manageAffiliate';
$route['manage-affiliates/(:any)'] = 'affiliate/manageAffiliate/$1';
$route['affiliates-reset-filter'] = 'affiliate/resetFilter';
$route['open-edit-affiliate-modal/(:any)'] = 'affiliate/editModal/$1';
$route['open-view-affiliate-modal/(:any)'] = 'affiliate/viewModal/$1';
$route['submit-edit-affiliate'] = 'affiliate/editAffiliate';


//Application Manager @Krishna Gupta #16082016
$route['manage-applications'] = 'application/index';
$route['manage-applications/(:any)'] = 'application/index/$1';
$route['open-edit-privilege-modal/(:any)'] = 'application/editPrivilegeModal/$1';
$route['submit-edit-privilege']['post'] = 'application/editPrivilege';
$route['add-application-modal'] = 'application/addModal';
$route['submit-application'] = 'application/submitApplication';

//Forgot @Krishna Gupta #20082016
$route['forgot-password'] = 'forgotpassword/index';

//Forgot @Krishna Gupta #20082016
$route['change-password'] = 'change_password/index';
$route['submit-change-password'] = 'change_password/processUserAuthentication';

//Quize @Krishna Gupta #03092016
$route['start-quiz'] = 'quiz/index';
$route['online-quiz'] = 'quiz/exam';
$route['submit-quiz'] = 'quiz/submitExam';
$route['reset-quiz'] = 'quiz/resetExam';
$route['next-question-data'] = 'quiz/nextQuestion';
$route['radio-button-validation'] = 'quiz/onRadioButtonValidation';
$route['ajax-get-subject-stage-level'] = 'quiz/subjectStageLevel';
$route['ajax-get-chapter'] = 'chapters/ajax_get_chapter_subject';

//Quize @Krishna Gupta #05092016
$route['add-question'] = 'questions/index';
$route['search-question'] = 'questions/searchquestion';
$route['ajax-question-count'] = 'questions/getQuestionsCount';
$route['ajax-getdata'] = 'questions/getdata';
$route['ajax-getdataquery'] = 'questions/getdataquery';
$route['ajax-getdata-tag'] = 'questions/tag_html';
$route['edit-question'] = 'questions/editQuestion';
$route['update-question'] = 'questions/updateQuestion';

//Quize @Krishna Gupta #07022017
$route['upload-images/(:any)/searchImage'] = 'Upload_files/searchImage';
//$route['upload-images/(:any)/searchImage/(:any)'] = 'Upload_files/searchImage/$1';
$route['upload-images/(:any)'] = 'Upload_files/index/$1';
$route['upload-images/(:any)/(:any)'] = 'Upload_files/index/$1/$2';

$route['Question-preview/(:any)'] = 'Questions/preview/$1';

$route['testimonial-all'] = 'testimonial/allTestimonial';
$route['testimonial'] = 'testimonial/index';
$route['open-add-testimonial-modal'] = 'testimonial/addModal';
$route['open-edit-testimonial-modal/(:any)'] = 'testimonial/editModal/$1';
$route['submit-add-testimonial'] = 'testimonial/addTestimonial';
$route['submit-edit-testimonial'] = 'testimonial/editTestimonial';

$route['toppers'] = 'Toppers/index';
$route['prizeDeclare'] = 'Toppers/prizeModal';
$route['studentsPrizeList'] = 'Toppers/prizeList';
$route['submit-prize-declaration'] = 'Toppers/submit';
$route['open-edit-prizemaster-modal/(:any)'] = 'Toppers/editPrizeMasterModal/$1';
$route['submit-edit-prizemaster'] = 'Toppers/editPrizeMaster';

$route['question'] = 'question_Report/index';
$route['ajax-get-users'] = 'question_Report/ajax_get_users';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
