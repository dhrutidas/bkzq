<script type="text/javascript" src="<?php echo base_url("assets/dist/js/bootstrap-multiselect.js"); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url("assets/dist/css/bootstrap-multiselect.css"); ?>" type="text/css" />
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Preview Question</b></h4>
</div>
<div class="modal-body">
    <div class="scrollable-body">
        <?php
        $options = explode(",", $answers['optionDetails']);
        ?>
        <p class="qstion">Question:<?php echo $qdetails['questionText']; ?></p>
        <ul class="answr">
            <?php foreach ($options as $val) : ?>

                <li class="<?php echo $answers['correctAns'] == $val ? "correct-answer" : ""; ?>"><?php echo $val; ?></li>
            <?php endforeach; ?>
        </ul>
        
        <div id="step2" data-id="step2">
            <!-- Add Level start -->
            <section class="dropdownAreaSec">
                <div class="form-group">
                    <label for="">Level</label>
                    <select id="level-select" class="multiselect-ui mainStageDropDown form-control" multiple="multiple" name="input_level[]">
                        <?php foreach ($levels as $key => $level) : ?>
                            <option value="<?php echo  $key; ?>"><?php echo $level; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <span id="error_level" class="text-danger"></span>
                </div>

                <div class="stageWrap">

                    <?php foreach ($stages as $k => $stageVal) : ?>
                        <div class="form-group toogleStageSec" id="level_stage_1">
                            <div class="">
                                <label for="Level 1"><?php echo $k; ?></label>
                                <select id="dates-field2" class="multiselect-ui form-control " multiple="multiple" name="">
                                    <?php foreach ($stageVal as $st => $al) : ?>
                                        <option value="<?php echo $st; ?>"><?php echo $al; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>
            </section>
            <!-- Add Level end -->

            <!-- Add Subject start -->
            <section class="dropdownAreaSec">
                <div class="form-group">
                    <label for="">Subject</label>
                    <select id="select-subject" class="multiselect-ui mainStageDropDown form-control" multiple="multiple" name="input_subject[]">
                        <?php foreach ($subjects as $sub => $name) : ?>
                            <option value="<?php echo $sub; ?>"><?php echo $name; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="stageWrap" id="chapter-level">
                    <?php foreach ($chapters as $chk => $chVal) : ?>
                        <div class="form-group toogleStageSec" id="level_stage_1">
                            <div class="">
                                <label for="Level 1"><?php echo $chk; ?></label>
                                <select id="dates-field2" class="multiselect-ui form-control " multiple="multiple" name="">
                                    <?php foreach ($chVal as $c => $e) : ?>
                                        <option value="<?php echo $c; ?>"><?php echo $e; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <!-- Add Subject end -->

            <!-- Add Standard start -->
            <section class="dropdownAreaSec">
                <div class="form-group">
                    <label for="">Standard</label>
                    <select id="dates-field2" class="multiselect-ui mainStageDropDown form-control" name="input_standard[]" multiple="multiple">
                        <?php foreach ($allStd as $std) : ?>
                            <option value="<?php echo $std['stdID']; ?>"><?php echo $std['stdName']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </section>
            <!-- Add Standard end -->
        </div>
    </div>
    <div class="">
        <div class="form-group">
                <input type="hidden" id="qidhidden" value="<?php echo $qdetails['qbID']; ?>">
            <label for="inputRejectReason" class="control-label">Please add your rejection reason</label>
            <div class="">
                <textarea class="form-control textarea inputRejectReason" id="question_text" name="inputRejectReason" id="" cols="30" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="apprRejectArea">
                <button class="btn btn-success btn-md" style="cursor:pointer" onclick="makeItLive('Y');">Approve</button>
                <button class="btn btn-danger btn-md" style="cursor:pointer" data-toggle="modal" data-target="#auth">Reject </button>
                <!-- <button type="submit" class="btn btn-default btn-submit">Approve</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Reject</button> -->
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(function() {
        $('.multiselect-ui').multiselect({
            includeSelectAllOption: true
        });
    });
    $(".multiselect-ui").multiselect('selectAll', false);
    $(".multiselect-ui").multiselect('updateButtonText');

    function makeItLive(auth) {
        qid = $("#qidhidden").val();

        if (!(auth == 'Y' || auth == 'QA')) {
            reason = $("#rejectionReason").val();
            if (reason.trim() == "") {
                alert("Rejection reason is required.");
                var callStatus = 'N';
            } else {
                var callStatus = 'Y';
                dataValue = {
                    questionId: qid,
                    status: 'Executive',
                    msg: reason
                }
            }
        } else {
            var callStatus = 'Y';
            dataValue = {
                questionId: qid,
                status: auth
            }
        }

        if (callStatus == 'Y') {
            $.ajax({
                url: 'change-question-status',
                data: dataValue,
                type: 'POST',
                success: function(data) {
                    result = JSON.parse(data);
                    if (result == true) {
                        alert("Successfully Updated !!!!");
                    }
                    location.reload();
                    //Commented out as we don't need to reload the previous page
                    // window.opener.location.reload();
                }
            });
        }
    }
</script>