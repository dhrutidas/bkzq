<style type="text/css">

.block{
    text-align: center;
    vertical-align: middle;
}
.circle{
    background: #ddd;
    border-radius: 30px;
    color: white;
    height: 30px;
    width: 30px;
}
.modal {
   width: 200px;
   height: 200px;
   position: absolute;
   left: 50%;
   top: 50%;
   margin-left: -150px;
   margin-top: -150px;
   background-color:rgba(0,0,0,0.4);
}

/* When the body has the loading class, we turn
   the scrollbar off with overflow:hidden */
body.loading {
    overflow: hidden;
}

/* Anytime the body has the loading class, our modal element will be visible */
body.loading .modal {
    display: block;
}

</style>
<?php $imagePath = base_url("assets/images/question_images").'/'; ?>
<script type="text/javascript" src="<?php echo base_url("assets/js/exam.js"); ?>"></script>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left" style="padding-right: 20px;"><strong class="text-left">Online exam</strong></div>
                <div class="pull-right" style="padding-right: 20px;">Each question marks : <strong id="questionMarks"><?php echo $stageDetails['orderBy']; ?></strong></div>

                <?php if(!empty($canSkip)){ ?><div class="pull-right" style="padding-right: 20px;">Max Skip : <strong id="skip"><?php echo $canSkip; ?></strong></div> <?php } ?>

                <div class="pull-right" style="padding-right: 20px;">Passing marks : <strong id="passingMark"><?php echo $stageDetails['minPassingCriterea']; ?></strong></div>

                <div class="clearfix"></div>
            </div>
            <?php echo form_open('submit-quiz','class="form-horizontal" id="onlineQuiz" name="onlineQuiz"'); ?>

                <div class="form-group"></div>
                <div class="pull-right" style="padding-right: 20px;" id='timerQuizStatus'></div>
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="well" id="question">Q1: <?php  echo empty($questionimage) ? '' : ' <a href="#" class="pop"><img src="'.$questionimage .'" class="img-rounded" alt="Question Image" width="80" height="80"></a> ';  echo $question; ?></div>

                    <input type="hidden" name="questionId" id="questionId" value="<?php echo $questionId; ?>">
                    <input type="hidden" name="indexId" id="indexId" value="<?php echo $first_key; ?>">
                </div>
                <?php
                $i = 0;
                foreach($options AS $key => $value) {
                    $i++;
                    $optionData = explode('#image#', $value);
                    $imgData = empty($optionData[1]) ? '' : ' <a href="#" class="pop"><img src="'.$optionData[1].'" class="img-rounded" alt="Option Image" width="80" height="80"></a>';

                    ${"option" . $i} = '<div class="col-sm-12">
                                            <label class="radio-inline" id="label'.$i.'">
                                              <input type="radio" name="optradio" id="option'.$i.'" value="'.$key.'"><div id="label'.$i.'">'.$imgData.' '.$optionData[0].'</div>
                                            </label>
                                        </div>';
                }
                ?>
                <div class="col-sm-offset-2 col-sm-8">
                    <?php echo $option1; ?>
                </div>
                <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-8">
                    <?php echo $option2; ?>
                </div>
                <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-8">
                    <?php if(isset($option3)) echo $option3; ?>
                </div>
                <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-8">
                    <?php if(isset($option4)) echo $option4; ?>
                </div>
                <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-8">
                    <?php if(isset($option5)) echo $option5; ?>
                </div>

                <div id="resultValueIconRight" class="modal">
                  <img src='<?php echo base_url("assets/images/Correct-icon.png"); ?>' hight='200' width='200'>
                </div>
                <div id="resultValueIconWrong" class="modal">
                  <img src='<?php echo base_url("assets/images/Incorrect-icon.png"); ?>' hight='200' width='200'>
                </div>

                <div class="form-group"></div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <div class="col-sm-10" id="skipDiv">
                            <?php if($skipStatus == "Y"): ?>
                                <button type="button" class="btn btn-primary" id="skip">&nbsp;&nbsp;Skip&nbsp;&nbsp;</button>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-2" id="nextDiv">
                            <?php if($maxStatus == 'Y') { ?>
                                <button type="button" class="btn btn-primary" id="next" >Next >></button>
                            <?php } elseif ($maxStatus == 'N') {
                                echo '<button type="button" class="btn btn-primary" id="submit">Submit</button>';
                            } ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!--<div class="modal"></div>-->
