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

</style>
<?php $imagePath = base_url("assets/images/question_images").'/'; ?>
<script type="text/javascript" src="<?php echo base_url("assets/js/exam.js"); ?>"></script>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Online exam</strong>
            </div>

            <?php echo form_open('submit-quiz','class="form-horizontal" id="onlineQuiz" name="onlineQuiz"'); ?>

                <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-8">
                    <div class="well" id="question"><?php  echo $question; echo empty($questionimage) ? '' : ' <a href="#" class="pop"><img src="'. $imagePath.$questionimage .'" class="img-rounded" alt="Question Image" width="40" height="30"></a>';?></div>

                    <input type="hidden" name="questionId" id="questionId" value="<?php echo $questionId; ?>">
                    <input type="hidden" name="indexId" id="indexId" value="<?php echo $first_key; ?>">
                </div>
                <?php 
                $i = 0;
                foreach($options AS $key => $value) {
                    $i++;
                    $optionData = explode('#image#', $value);
                    $imgData = empty($optionData[1]) ? '' : ' <a href="#" class="pop"><img src="'.$imagePath.$optionData[1].'" class="img-rounded" alt="Option Image" width="40" height="30"></a>';

                    ${"option" . $i} = '<div class="col-sm-6">
                                            <label class="radio-inline" id="label'.$i.'">
                                              <input type="radio" name="optradio" id="option'.$i.'" value="'.$key.'"><div id="label'.$i.'">'.$optionData[0].' '.$imgData.'</div>
                                            </label>
                                        </div>';
                }
                ?>
                <div class="col-sm-offset-2 col-sm-8">
                    <?php echo $option1. $option2; ?>
                </div>

                <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-8">
                    <?php if(isset($option3)) echo $option3. $option4; ?>
                </div>
                <?php if(isset($option5)) {  ?>
                <div class="form-group"></div>
                <div class="col-sm-offset-2 col-sm-8">
                    <?php echo $option5; 
                    if(isset($option6)) {
                        echo $option6;
                    }
                    ?>
                </div>

                <?php } ?>
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
                                <button type="button" class="btn btn-primary" id="next">Next >></button>
                            <?php } elseif ($maxStatus == 'N') {
                                echo '<button type="submit" class="btn btn-primary" id="submit">Submit</button>';
                            } ?>    
                        </div>    
                    </div>
                </div>
            </form>
        </div>
        
        <div id="viewModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content" id="modal_data"></div>
            </div>
        </div>

    </div>
</div>

<!-- Modal for image view -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">              
      <div class="modal-body">
        <button type="button" class="close " data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <img src="" class="imagepreview" >
      </div>
    </div>
  </div>
</div>