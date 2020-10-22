<script type="text/javascript" src="<?php echo base_url("assets/js/question.js"); ?>"></script>
<div class="row">
    <div class="col-md-12">

        <?php if( $this->session->flashdata('message')): ?>

            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('message'); ?></strong>
            </div>
        <?php endif; ?>
        <?php if( $this->session->flashdata('warning')): ?>
            <div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('warning'); ?></strong>
            </div>
        <?php endif; ?> 


        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Add Question</strong>
            </div>

            <div class="panel-collapse">
                <br/>
                <div class="row">
                  <div class="col-sm-offset-2 col-sm-7">
                    <div class="input-group">
                      <input type="text" class="form-control SearchBar"  name="QueTxt" id="QueTxt" placeholder="Search for question ...">
                      <span class="input-group-btn">
                        <button type="button"  id="addques" class="btn btn-primary btn-md">Skip Search/ Add Question</button>
                    </span>
                    </div>
                  </div>
                </div>
                <br/>
                <div class="col-sm-offset-2 col-sm-7" id="results"></div>
            </div>
        
        <!-- Modal -->
        <div id="AnsModal" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
                        <h4 class="modal-title text-primary">Add Options</h4>
                    </div>
                    <div id="mbobomb" class="modal-body"></div>
                    <div class="modal-footer">
						Tag Question :	
						<select class="selectpicker" name="inputLevel" id="inputLevel" multiple>
						  <optgroup label="Levels">
						  <?php foreach ($allLevel AS $value) { ?>
								<option value="<?php echo $value['levelID']; ?>"><?php echo $value['levelName']; ?></option>
						  <?php } ?>
						  </optgroup>
						</select>
						<!--<select class="selectpicker" name="inputBoard" id="inputBoard" multiple>
						  <optgroup label="Stages"></optgroup>
						</select>-->
						
						<select class="selectpicker" name="inputBoard" id="inputBoard" multiple>
						  <optgroup label="Boards">
						  <?php foreach ($allBoard AS $value) { ?>
								<option value="<?php echo $value['boardID']; ?>"><?php echo $value['boardName']; ?></option>
						  <?php } ?>
						  </optgroup>
						</select>
						
						<select class="selectpicker" name="inputSubject" id="inputSubject" multiple>
						  <optgroup label="Subjects">
						  <?php foreach ($allsubject AS $value) { ?>
								<option value="<?php echo $value['subjectID']; ?>"><?php echo $value['subjectName']; ?></option>
						  <?php } ?>
						  </optgroup>
						</select>
						
						<select class="selectpicker" name="inputStandard" id="inputStandard" multiple>
						  <optgroup label="Standard">
						  <?php foreach ($allStd AS $value) { ?>
								<option value="<?php echo $value['stdID']; ?>"><?php echo $value['stdName']; ?></option>
						  <?php } ?>
						  </optgroup>
						</select>
						
                        <input type="button" id="QnAsubmit" class="btn btn-primary btn-md" value='Submit Q&A' >
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>