<script type="text/javascript" src="<?php echo base_url("assets/js/quiz.js"); ?>"></script>
<?php $Data['session_data'] = $this->session->userdata('user_details'); 
//print_r($Data['session_data']);
?>
<div class="row">
    <div class="col-md-12">

        <?php ;if( $this->session->flashdata('message')): ?>

            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('message'); ?><i class="fa fa-star"></i></strong>
            </div>
        <?php endif; ?>
        <?php if( $this->session->flashdata('warning')): ?>
            <div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('warning'); ?><i class="fa fa-star"></i></strong>
            </div>
        <?php endif; ?> 


        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Start Quiz</strong>
            </div>

            <div class="panel-collapse">
            <?php echo form_open('online-quiz','class="form-horizontal" id="startQuiz"'); ?>
            <br/>

            <div class="form-group">
                <label for="inputRolename" class="col-sm-4 control-label">Select Standard</label>
                <div class="col-sm-4">
                    <select name="inputStandard" id="inputStandard" class="form-control" disabled>
                    <option value="">----Select----</option>
                    <?php foreach ($allStd AS $value) { ?>
                        <option value="<?php echo $value['stdID']; ?>"<?php if($Data['session_data']['std_id'] == $value['stdID']) { echo "SELECTED"; } ?>><?php echo $value['stdName']; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputSubject" class="col-sm-4 control-label">Select Subject</label>
                <div class="col-sm-4">
                    <select name="inputSubject" id="inputSubject" class="form-control">
                    <option value="">----Select----</option>
                    <?php foreach ($allsubject AS $value) { ?>
                        <option value="<?php echo $value['subjectID']; ?>"><?php echo $value['subjectName']; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputChapter" class="col-sm-4 control-label">Select Chapter</label>
                <div class="col-sm-4">
                    <select name="inputChapter" id="inputChapter" class="form-control">
                    <option value="">----Select----</option>
                </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputRolename" class="col-sm-4 control-label">Select Level</label>
                <div class="col-sm-4">
                    <select name="inputLevel" id="inputLevel" class="form-control" readonly>
                        <option value="">----Select----</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputRolename" class="col-sm-4 control-label">Select Stage</label>
                <div class="col-sm-4">
                    <select name="inputStage" id="inputStage" class="form-control" readonly>
                        <option value="">----Select----</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputRolename" class="col-sm-4 control-label">Select Board</label>
                <div class="col-sm-4">
                    <select name="inputBoard" id="inputBoard" class="form-control" disabled="disabled">
                    <option value="">----Select----</option>
                    <?php foreach ($allBoard AS $value) { ?>
                        <option value="<?php echo $value['boardID']; ?>"<?php if($Data['session_data']['board_id'] == $value['boardID']) { echo "SELECTED"; } ?>><?php echo $value['boardName']; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            
            <!--<div class="form-group">
                <label for="inputRolename" class="col-sm-4 control-label">Select Standard</label>
                <div class="col-sm-4">
                    <select name="inputStandard" id="inputStandard" class="form-control" disabled="disabled">
                    <option value="">----Select----</option>
                    <?php foreach ($allStd AS $value) { ?>
                        <option value="<?php echo $value['stdID']; ?>"<?php if($Data['session_data']['std_id'] == $value['stdID']) { echo "SELECTED"; } ?>><?php echo $value['stdName']; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>-->

            <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-primary">Generate Questions</button>
            </div>
        </div>
            </form>
            </div>
        </div>
        
        <div id="viewModal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content"></div>
            </div>
        </div>

    </div>
</div>