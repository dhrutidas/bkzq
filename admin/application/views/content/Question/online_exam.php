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
<script type="text/javascript" src="<?php echo base_url("assets/js/exam.js"); ?>"></script>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Online exam</strong>
            </div>

            <!-- <div class="panel-collapse"> -->
            <?php echo form_open('submit-quiz','class="form-horizontal" id="onlineQuiz" name="onlineQuiz"'); ?>

               <!-- <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-7">
                    <div class="col-sm-1 block"><p class="circle">1</p></div>
                    <div class="col-sm-1 block"><p class="circle">2</p></div>
                    <div class="col-sm-1 block"><p class="circle">3</p></div>
                    <div class="col-sm-1 block"><p class="circle">4</p></div>
                    <div class="col-sm-1 block"><p class="circle">5</p></div>
                    <div class="col-sm-1 block"><p class="circle">6</p></div>
                    <div class="col-sm-1 block"><p class="circle">7</p></div>
                    <div class="col-sm-1 block"><p class="circle">8</p></div>
                    <div class="col-sm-1 block"><p class="circle">9</p></div>
                    <div class="col-sm-1 block"><p class="circle">10</p></div>
                    <div class="col-sm-1 block"><p class="circle">11</p></div>
                    <div class="col-sm-1 block"><p class="circle">12</p></div>
                </div> -->

                <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-8">
                    <div class="well" id="question"><?php  echo $question; ?></div>
                    <input type="hidden" name="questionId" id="questionId" value="<?php  echo $questionId; ?>">
                    <input type="hidden" name="indexId" id="indexId" value="<?php echo $first_key; ?>">
                </div>
                <?php 
                $i = 0;
                foreach($options AS $key => $value) {
                    $i++;
                    
                    ${"option" . $i} = '<div class="col-sm-6">
                                            <label class="radio-inline" id="label'.$i.'">
                                              <input type="radio" name="optradio" id="option'.$i.'" value="'.$key.'"><div id="label'.$i.'">'.$value.'</div>
                                            </label>
                                        </div>';

                }
                ?>
                <div class="col-sm-offset-2 col-sm-8">
                    <?php echo $option1. $option2;?>
                </div>

                <div class="form-group"></div>

                <div class="col-sm-offset-2 col-sm-8">
                    <?php echo $option3. $option4;?>
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
                                <button type="button" class="btn btn-primary" id="next">Next >></button>
                            <?php } elseif ($maxStatus == 'N') {
                                echo '<button type="submit" class="btn btn-primary" id="submit">Submit</button>';
                            } ?>    
                        </div>    
                    </div>
                </div>
            </form>
            <!-- </div> -->
        </div>
        
        <div id="viewModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>

    </div>
</div>