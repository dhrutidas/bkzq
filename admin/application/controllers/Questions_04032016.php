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

        $Data['page_title'] = "Quetion";
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
	
	public function tag_html() {
		
		$this->load->model('level_model');
        $this->load->model('board_model');
        $this->load->model('subject_model');
        $this->load->model('class_model');
        $allLevel = $this->level_model->getAllActiveLevelForTag();
        $allBoard = $this->board_model->getAllActiveBoards();
        $allsubject = $this->subject_model->getAllActiveSubjectsForTags();
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
									$stageIDData=explode('|~|',$value['catStageID']);
									$stageNameData=explode('|~|',$value['catStageName']);
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
									$chapNameData=explode('|~|',$value['catChapterName']);
									$counter=0;
									foreach ($chapIDData AS $chapID) {
										echo '<option value="'.$value['subjectID'].'-'.$chapID.'">'.$chapNameData[$counter++].'</option>';
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
                    <div class="col-md-3" id="quesText"></div>
                    <div class="col-md-4"><input type="file" name="quesImage" class="quesImage"></div>
                    <div class="col-md-4"><input type="text" name="quesImageDesc" class="quesImageDesc"></div>
                </div>
            </div>
            <div class="row" id="formMe">
                <div  class="col-md-12" style="padding-bottom:10px;">
                    <div class="col-md-3"><strong>Option Name</strong></div>
                    <div class="col-md-4"><strong>Choose Image</strong></div>
                    <div class="col-md-4"><strong>Image Desc</strong></div>
                    <div class="col-md-1"><strong>Correct</strong></div>
                </div>
                <div  class="col-md-12" style="padding-bottom:10px;">
                    <div class="col-md-3"><input type="text" name="txtans" class="txtans"></div>
                    <div class="col-md-4"><input type="file" name="ansimg" class="ansimg"></div>
                    <div class="col-md-4"><input type="text" name="ansimgdesc" class="ansimgdesc"></div>
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
        $postArr['ansValues'] = $this->input->post('ansValues');
        $postArr['ansCorrection'] = $this->input->post('ansCorrection');
		
		$postArr['levelID'] = $this->input->post('level');
		$postArr['board'] = $this->input->post('board');
		$postArr['subject'] = $this->input->post('subject');
		$postArr['standard'] = $this->input->post('standard');
		//print_r($postArr);
        $Data['resultArr'] = $this->question_model->insertQuestionAns($postArr);
        print_r($Data['resultArr']);
	}

	}//End of Funcation
}//End of Class