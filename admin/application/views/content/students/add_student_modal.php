<script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New User</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open_multipart('submit-add-student','class="form-horizontal" id="addStudentform"'); ?>
        
    <div class="scrollable-body">

        <div class="form-group">
            <label for="inputFirstName" class="col-sm-4 control-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputFirstName" name="inputFirstName">
            </div>
        </div>
        <div class="form-group">
            <label for="inputLastName" class="col-sm-4 control-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputLastName" name="inputLastName">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputEmail" name="inputEmail">
            </div>
        </div>
        <div class="form-group">
            <label for="inputContact" class="col-sm-4 control-label">Contact</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputContact" name="inputContact">
            </div>
        </div>
        <div class="form-group">
            <label for="inputParentName" class="col-sm-4 control-label">Parent's Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputParentName" name="inputParentName">
            </div>
        </div>
        <div class="form-group">
            <label for="inputProfilePic" class="col-sm-4 control-label">Upload Profile Pic</label>
            <div class="col-sm-6">
                <input type="file" name="inputProfilePic" id="inputProfilePic" accept="image/*">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAddress" class="col-sm-4 control-label">Address</label>
            <div class="col-sm-6">
                <textarea id="inputAddress" name="inputAddress" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputDesc" class="col-sm-4 control-label">Additional Info</label>
            <div class="col-sm-6">
                <textarea id="inputDesc" name="inputDesc" class="form-control" rows="3"></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="inputBoard" class="col-sm-4 control-label">Select Board</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputBoard" name="inputBoard">
                    <option value="">----Select----</option>
                    <?php foreach( $boardArr as $bValues ): ?>
                        <option value="<?php echo $bValues['boardID']; ?>"><?php echo $bValues['boardName']; ?></option>
                    <?php endforeach; ?>
                </select> 
            </div>
        </div>
        <div class="form-group">
            <label for="inputSchool" class="col-sm-4 control-label">Select School</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSchool" name="inputSchool">
                    <option value="">----Select----</option>
                    <?php foreach( $schoolArr as $dValues ): ?>
                        <option value="<?php echo $dValues['schoolID']; ?>"><?php echo $dValues['schoolName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        <div class="form-group">
            <label for="inputClass" class="col-sm-4 control-label">Select Statndard</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputClass" name="inputClass">
                    <option value="">----Select----</option>
                    <?php foreach( $classArr as $dValues ): ?>
                        <option value="<?php echo $dValues['stdID']; ?>"><?php echo $dValues['stdName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        <div class="form-group">
            <label for="inputPackage" class="col-sm-4 control-label">Select Package</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputPackage" name="inputPackage">
                    <option value="T" selected="selected">Free Trial</option>
                    <option value="B">Bronze</option>
                    <option value="S">Silver</option>
                    <option value="G">Gold</option>
                </select>                 
            </div>
        </div>

        <div id="bronze" style="display: none;">
            <div class="form-group">
                <label for="inputSubject1" class="col-sm-4 control-label">Select Subject 1</label>
                <div class="col-sm-6">
                    <select class="form-control" id="inputSubject1" name="inputSubject1">
                        <option value="">----Select----</option>
                        <?php foreach( $subjectArr as $dValues ): ?>
                            <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
                        <?php endforeach; ?>
                    </select>                 
                </div>
            </div>
        </div>

        <div id="silver" style="display: none;">
        <div class="form-group">
            <label for="inputSubject2" class="col-sm-4 control-label">Select Subject 2</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSubject2" name="inputSubject2">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectArr as $dValues ): ?>
                        <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubject3" class="col-sm-4 control-label">Select Subject 3</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSubject3" name="inputSubject3">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectArr as $dValues ): ?>
                        <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        </div>

        <div id="gold" style="display: none;">
        <div class="form-group">
            <label for="inputSubject4" class="col-sm-4 control-label">Select Subject 4</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSubject4" name="inputSubject4">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectArr as $dValues ): ?>
                        <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubject5" class="col-sm-4 control-label">Select Subject 5</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSubject5" name="inputSubject5">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectArr as $dValues ): ?>
                        <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubject6" class="col-sm-4 control-label">Select Subject 6</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSubject6" name="inputSubject6">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectArr as $dValues ): ?>
                        <option value="<?php echo $dValues['subjectID']; ?>"><?php echo $dValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        </div>

    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-default">Submit</button>&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </div>
    </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>
