<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 *
 * @author  Krishna Gupta and Surya
 * @date    03.09.2016
 *
 **/

class Questions extends MY_Controller {

    var $EARLY = 0;
    var $ON_TIME = 0;
    var $LATE = 0;

    public function __construct() {

        parent::__construct();
        $this->load->library('session');
        $this->load->model('question_model');
        $this->load->helper('file');
    }

    public function index() {

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Question";
        $Data['load_page'] = "Question/add_question";

		$this->load->model('level_model');
        $this->load->model('board_model');
        $this->load->model('subject_model');
        $this->load->model('class_model');

        $Data['allLevel'] = $this->level_model->getAllActiveLevelForTag();
        $Data['allBoard'] = $this->board_model->getAllActiveBoards();
        $Data['allsubject'] = $this->subject_model->getAllActiveSubjectsForTags();
        $Data['allStd'] = $this->class_model->getAllActiveClass();

        $this->load->view("kernel", $Data);
    }

    public function createQuestion() {

        $Data['groupArr'] = parent::menu();

        $Data['page_title'] = "Question";
        $Data['load_page'] = "Question/add_question_new";

		
        $this->load->model('level_model');
        $this->load->model('board_model');
        $this->load->model('subject_model');
        $this->load->model('class_model');
        $this->load->model('chapter_model');
        
        $Data['levels'] = $this->level_model->getAllActiveLevelForQuestion();
        $Data['allLevel'] = $this->level_model->getAllActiveLevelForTagSorted();
        $Data['allBoard'] = $this->board_model->getAllActiveBoards();
        $Data['allsubjects'] = $this->subject_model->getAllActiveSubjects();
	    $Data['allChapter'] = $this->chapter_model->getAllActiveChapterNamesIdMapping();
        $Data['allStd'] = $this->class_model->getAllActiveClass();

        // echo "<pre>";
        // print_r($Data['allsubject']);exit;
        $this->load->view("kernel", $Data);
    }
    public  function saveQuestion(){
        $post = $this->input->post();
        if (isset($post)) {
            
            //  echo "<pre>";
            //  print_r($post);
            $data = array();
            $stage = array();
            $lstatus = false;
            $ststatus = false;
            $sstatus = false;
            if(isset($post['input_level']) && isset($post['input_stage'])){
                foreach($post['input_level'] as $l=>$v){
                    if($post['input_stage']){
                         foreach($post['input_stage'] as $key=>$values){
                             if(isset($values[$v]))
                                 $stage[$v][]= $values[$v];
                         }
                     }
                }
                $lstatus = true;
            }else{
                $data['error']="true";
                $data['error_level']="Please select level & stage";
            }
            $subject=array();
            if(isset($post['input_subject']) && isset($post['input_chapter'])){
                foreach($post['input_subject'] as $sub=>$chap){
                    if(isset($post['input_chapter'])){
                        foreach($post['input_chapter'] as $x=>$y){
                            if(isset($y[$chap]))
                                $subject[$chap][]= $y[$chap];
                        }
                    }
                }
                $sstatus = true;
            }else{
                $data['error']="true";
                $data['error_subject']="Please select subject & chapter";
            }
            if(isset($post['input_standard'])){
                $ststatus = true;
            }else{
                $data['error']="true";
                $data['error_standard']="Please select standard";
            }
            // echo "<pre>";
            // print_r($post);exit;
            $resultArr = $this->question_model->insertQuestionNew($post);
            if($lstatus && $sstatus && $ststatus)
            {
                $this->question_model->questionLevelMapping($stage,$resultArr['questionId'],$subject,$post['input_standard']);
                $data['error']=false;
                $data['success']=true;
                $this->session->set_flashdata('message', 'Success! Question added.');
                echo json_encode($data);
            }else{
                echo json_encode($data);
            }
           
        }
    }
    public function createQuestionValidate(){
        $validation = true;
        $post = $this->input->post();
        if (isset($post)) {
           // print_r($post);exit;
            $this->form_validation->set_rules('question_text', 'Question Text', 'required');
            $option_error  = "";
            $optionData = $this->input->post('options');
            if(isset($optionData)){
                //print_r($optionData);exit;
                for($i =0;$i<count($optionData);$i++){
                    //echo "hi";exit;
                    if($optionData[$i] == "")
                    {
                        $option_error = "<p>The Options field is required.</p>";
                        $validation = false;
                    }

                }
                ///$option_error = "";
            }else{
                $option_error = "<p>The Options field is required.</p>";
                $validation = false;
            }
            // if(count($optionData) <= 1){
            //     $validation = false;
            // }
            $answer = $this->input->post('answer');
            if(isset($answer)){
                $answer_error = "";
            }else{
                $answer_error = "<p>The Answer field is required.</p>";
                $validation = false;
            }
            if ($this->form_validation->run() == FALSE || $validation == FALSE) {
                $array = array(
                    'error'   => true,
                    'question_text_error' => form_error('question_text'),
                    'options_error' => $option_error,
                    'answer_error' => $answer_error,
                );

                echo json_encode($array);
            }else{
                $array = array(
                    'error'   => false,
                    'success' => true
                );
                echo json_encode($array);
            }
        }
    }
    public function getLevelStage(){
       // print_r($this->input->post('levelID'));exit;
        if(!$this->input->post('levelID')){
            $array['error'] = true;
            echo json_encode( $array);
        }else{
            $this->load->model('stage_model');
            $this->load->model('level_model');
            $levelIds=$this->input->post('levelID');
            $parentHtml = "";
            foreach($levelIds as $id){
                $levelDetails = $this->level_model->getLevelDetails($id);
                $html = '<div class="form-group toogleStageSec" id="level_stage_1">
                <div class="">
                    <label for="Level 1">'.$levelDetails['levelName'].'</label>
                    <select id="dates-field2" class="multiselect-ui form-control " multiple="multiple" name="input_stage[]['.$id.']">';
                  
                $stages = $this->stage_model->getAllActiveStagesByLevel($id);
                $stageOptions = "";
                foreach($stages as $stage){
                    $stageOptions = $stageOptions.'<option value="'.$stage['stageID'].'">'.$stage['stageName'].'</option>';
                }
                $html=$html.$stageOptions.'</select></div></div>';
                $parentHtml= $parentHtml.$html;
            }
            
           
            $array['error'] = false;
            $array['success'] = true;
            $array['html'] = $parentHtml;
            echo json_encode($array);
        }
       
    }

    public function getChapterBySubject(){
         if(!$this->input->post('subjectID')){
            $array['error'] = true;
            echo json_encode( $array);
         }else{
             $this->load->model('subject_model');
             $this->load->model('chapter_model');
             $subjectIds=$this->input->post('subjectID');
             $parentHtml = "";
             foreach($subjectIds as $id){
                 $subjectDetails = $this->subject_model->getSubjectDetails($id);
                 $html = '<div class="form-group toogleStageSec" id="level_stage_1">
                 <div class="">
                     <label for="'.$subjectDetails['subjectName'].'">'.$subjectDetails['subjectName'].'</label>
                     <select id="chapter_select_'.$subjectDetails['subjectID'].'" class="multiselect-ui form-control " name="input_chapter[]['.$id.']" multiple="multiple">';
                         
                     '</select></div></div>';
                 $chapters = $this->chapter_model->getAllActiveChaptersBySubject($id);
                //  print_r( $chapters);exit;
                 $chapterOptions = "";
                 foreach($chapters as $chapter){
                    //   print_r($chapter);exit;
                     $chapterOptions = $chapterOptions.'<option value="'.$chapter['chapterID'].'">'.$chapter['chapterName'].'</option>';
                 }
                 $html=$html.$chapterOptions.'</select></div></div>';
                 $parentHtml= $parentHtml.$html;
             }
            
             $array['error'] = false;
            $array['success'] = true;
            $array['html'] = $parentHtml;
            echo json_encode($array);
         }
        
     }
 
	public function tag_html() {

		$this->load->model('level_model');
        $this->load->model('board_model');
        $this->load->model('subject_model');
        $this->load->model('class_model');
	    $this->load->model('chapter_model');
        $allLevel = $this->level_model->getAllActiveLevelForTagSorted();
        $allBoard = $this->board_model->getAllActiveBoards();
        $allsubject = $this->subject_model->getAllActiveSubjectsForTags();
	    $allChapter = $this->chapter_model->getAllActiveChapterNamesIdMapping();
        $allStd = $this->class_model->getAllActiveClass();
		?>
					<select class="selectpicker" name="inputBoard" id="inputBoard">
						  <optgroup label="Boards">
						  <?php foreach ($allBoard AS $value) { ?>
								<option value="<?php echo $value['boardID']; ?>"><?php echo $value['boardName']; ?></option>
						  <?php } ?>
						  </optgroup>
						</select>
						<select class="selectpicker" name="inputLevel" id="inputLevel" multiple>
						<?php foreach ($allLevel AS $value) {
								echo '<optgroup label="'.$value['levelName'].'">';
									$stageIDData=explode(',',$value['catStageID']);
									$stageNameData=explode(',',$value['catStageName']);
									$counter=0;
									foreach ($stageIDData AS $stageID) {
										echo '<option value="'.$value['levelID'].'-'.$stageID.'">'.$stageNameData[$counter++].'</option>';
									}
								echo '</optgroup>';
								}
						?>
						</select>

						<select class="selectpicker" name="inputSubject" id="inputSubject" multiple>
						<?php foreach ($allsubject AS $value) {
								echo '<optgroup label="'.$value['subjectName'].'">';
									$chapIDData=explode('|~|',$value['catChapterID']);
									//$chapNameData=explode('|~|',$value['catChapterName']);
									$counter=0;
									foreach ($chapIDData AS $chapID) {
										echo '<option value="'.$value['subjectID'].'-'.$chapID.'">'.$allChapter[$chapID].'</option>';
									}
								echo '</optgroup>';
								}
						?>
						</select>

						<select class="selectpicker" name="inputStandard" id="inputStandard" multiple>
						  <optgroup label="Standard">
						  <?php foreach ($allStd AS $value) { ?>
								<option value="<?php echo $value['stdID']; ?>"><?php echo $value['stdName']; ?></option>
						  <?php } ?>
						  </optgroup>
						</select>
		<?php

    }

    public function getdata(){

        $Data['question_paper_data'] = $this->session->userdata('question_paper_details');

        $action = $this->input->post('action');

        if ($action === 'getdata')
        {
            $postArr['str'] = $this->input->post('value');
            $Data['resultArr'] = $this->question_model->getSearchQuestionsDetails($postArr);
            foreach ($Data['resultArr'] AS $key => $value) {
                $optionDetails = explode('#!~!#',$value['optionDetails']);
                $counterChar = 'A';
                $optionForm = '';
                foreach($optionDetails as $row){
                    $option=explode('~!~',$row);
                    $bold=($option[3]=="Y")?'<b>':'';
                    $closebold=($option[3]=="Y")?'</b>':'';
                    if(sizeof($option)>1)
                        $optionForm =$optionForm.$bold.'<div class=".col-md-6"><div class=".col-md-6">'.$counterChar++.'. '.$option[1].'</div></div>'.$closebold;
                }
                echo '<br/><div class="btn btn-info" data-toggle="collapse" data-target="#'.$value['qbID'].'">'.$value['questionText'].'</div>
                <br/><div id='.$value['qbID'].' class="collapse">';
                echo $optionForm;
                echo '</div>';
                unset($optionForm);
            }
		}
    else if ($action === 'getansmenu')
    {
        ?>
        <form ID="QnAsubmit" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-12" style="padding-bottom: 10px;">
                    <div class="col-md-2"><strong>Question : </strong></div>
					<div class="col-md-6" id="quesText"></div>
                    <div class="col-md-4"><input type="text" name="quesImage" id="quesImage" class="quesImage" onclick="openTab(this);"></div>
                    <!--<div class="col-md-4"><input type="text" name="quesImageDesc" class="quesImageDesc"></div>-->
                </div>
            </div>
            <div class="row" id="formMe">
                <div  class="col-md-12" style="padding-bottom:10px;">
                    <div class="col-md-3"><strong>Option Name</strong></div>
                    <div class="col-md-4"><strong>Choose Image</strong></div>
                    <div class="col-md-1"><strong>Correct</strong></div>
                </div>
                <div  class="col-md-12" style="padding-bottom:10px;">
                    <div class="col-md-3"><input type="text" name="txtans" class="txtans"></div>
                    <div class="col-md-4"><input type="text" name="ansimg" id="ansimg0" class="ansimg" onclick="openTab(this);"></div>
                    <div class="col-md-1"><input type="checkbox" class="anschk" name="newans" id="newans"></div>
                </div>
            </div>
        </form>
        <div class="col-md-12" style="padding-bottom:10px;">
            <button type="button" id="adbtn" class="btn btn-md btn-success">+Add more</button>
        </div>
        <?php
    }
    else if($action === 'QnAPost')
    {
        $postArr['questionText'] = $this->input->post('questionText');
        $postArr['questionImage'] = $this->input->post('questionImage');
        $postArr['ansValues'] = $this->input->post('ansValues');
		    $postArr['imagePath'] = $this->input->post('imagePath');
        $postArr['ansCorrection'] = $this->input->post('ansCorrection');

    		$postArr['levelID'] = $this->input->post('level');
    		$postArr['board'] = $this->input->post('board');
    		$postArr['subject'] = $this->input->post('subject');
    		$postArr['standard'] = $this->input->post('standard');
    		//print_r($postArr);
        $resultArr = $this->question_model->insertQuestionAns($postArr);
        $return = json_encode($resultArr, TRUE);
        echo ($return);
    }
    else if($action === 'getsearchdata')
    {  
        $postArr['str'] = $this->input->post('value');
        $postArr['match'] = $this->input->post('match');
        $Data['resultArr'] = $this->question_model->getSearchExactQuestionsAndDetails($postArr);     
        
        $questionCnt = count($Data['resultArr']);
        if($questionCnt > 0){
            echo '<div class="panel-heading text-left">';
            echo 'Total questions found: <b>'.$questionCnt.'</b>';
            echo '</div>';
            foreach ($Data['resultArr'] AS $key => $value) {
                $optionDetails = explode('#!~!#',$value['optionDetails']);
                $counterChar = 'A';
                $optionForm = '';
                foreach($optionDetails as $row){
                    $option=explode('~!~',$row);
                    $bold=($option[3]=="Y")?'<b>':'';
                    $closebold=($option[3]=="Y")?'</b>':'';
                    if(sizeof($option)>1)
                        $optionForm =$optionForm.$bold.'<div class=".col-md-6"><div class=".col-md-6">'.$counterChar++.'. '.$option[1].'</div></div>'.$closebold;
                }
                echo '<br/><div class="btn btn-info" data-toggle="collapse" data-target="#'.$value['qbID'].'">'.intval($value['qbID']).'-'.$value['questionText'].'</div>
                <br/><div id='.$value['qbID'].' class="collapse">';
                echo $optionForm;
                echo '</div>';
                unset($optionForm);
            }	
        }else{
            echo '<div class="panel-heading text-left">';
            echo 'No results found';
            echo '</div>';
        }
           	
    }

	}//End of Funcation

  function preview($questionID) {

      $Data['groupArr'] = parent::menu();

      $Data['page_title'] = "Question Preview";
      $Data['load_page'] = "Question/preview_question";

      $this->load->model('question_model');

      $Data['question'] = $this->question_model->getAllDetail($questionID);
      $Data['tags'] = $this->question_model->getTaggingDetailsByQuestionID($questionID);
      $this->load->view("kernel", $Data);
  }
  function userQuestion() {
    $userId=$this->input->post('userID');
    //echo "Question ID" . $qid;exit;
      $this->load->model('question_model');
      $question['resultSet'] = $this->question_model->getAllQuestionUser($userId);
      $question['count']=sizeof($question['resultSet']);
      $return = json_encode($question, TRUE);
      echo ($return);
  }
  function makeItLive() {
      $data['questionID']=$this->input->post('questionId');
      $data['status']=$this->input->post('status');
      if($data['status']=='Executive')
      $data['msg']=$this->input->post('msg');

      $this->load->model('question_model');
      $msg = $this->question_model->makeItLive($data);
      $return = json_encode($msg, TRUE);
      echo ($return);
  }

  public function getdataquery(){
     $postArr['str'] = $_GET['value'];
    print_r($this->question_model->getSearchQuestionsDetailsQuery($postArr));
  }

  public function searchquestion() {

    $Data['groupArr'] = parent::menu();
    //echo '<pre>'; print_r($Data);echo '</pre>';
    $Data['page_title'] = "Question Search";
    $Data['load_page'] = "Question/search_question";

    $this->load->model('level_model');
    $this->load->model('board_model');
    $this->load->model('subject_model');
    $this->load->model('class_model');

    $Data['allLevel'] = $this->level_model->getAllActiveLevelForTag();
    $Data['allBoard'] = $this->board_model->getAllActiveBoards();
    $Data['allsubject'] = $this->subject_model->getAllActiveSubjectsForTags();
    $Data['allStd'] = $this->class_model->getAllActiveClass();

    $this->load->view("kernel", $Data);
}

    public function getQuestionsCount(){
        $postArr['str'] = $this->input->post('value');
        $postArr['match'] = $this->input->post('match');
        $Data['resultArr'] = $this->question_model->getSearchExactQuestionsAndDetails($postArr);     
        
        echo $questionCnt = count($Data['resultArr']);
    }

    public function editQuestion(){
        $this->load->model('subject_model');
    $this->load->model('class_model');
    $this->load->model('level_model');
    $this->load->model('board_model');

    $Data['allLevel'] = $this->level_model->getAllActiveLevelForTagSorted();
    $Data['allBoard'] = $this->board_model->getAllActiveBoards();
        $Data['groupArr'] = parent::menu();
        $Data['page_title'] = "Add standards to question";
        $Data['load_page'] = "Question/edit_question";
        //$question['questionid'] = 41;
        $question['boardid'] = intval($this->input->post('inputBoard'));
        $level_stage = explode('-', $this->input->post('inputLevel'));
        $question['levelid'] = (isset($level_stage[0])) ? intval($level_stage[0]) : '';
        $question['stageid'] = (isset($level_stage[1])) ? intval($level_stage[1]) : '';
        $question['questiontext'] = $this->input->post('questiontext');
        if(count($this->input->post()) > 0 ){
            $Data['questionDetails'] = $this->question_model->getTaggingDetailsByQuestionDetails($question);
            $Data['allsubject'] = $this->subject_model->getAllActiveSubjectsForTags();
            $Data['allStd'] = $this->class_model->getAllActiveClass();
        }
        $Data['question'] = $this->input->post();
        $this->load->view("kernel", $Data);
    }

    public function updateQuestion(){
             if( $this->question_model->updateQuestion($this->input->post()))
			{
		            $this->session->set_flashdata('message', 'Question edited successfully.');
			}
			else
			{
				$this->session->set_flashdata('warning', 'oops Something went wrong please try again.');
			}
            redirect( base_url('edit-question') );

    }
}//End of Class
