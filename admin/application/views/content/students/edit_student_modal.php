<script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Edit User Details</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open_multipart('submit-edit-student','class="form-horizontal" id="editStudentform"'); ?>
    <!-- <form method="post" action="submit-edit-user" enctype="multipart/form-data" class="form-horizontal" id="editEmployeeform" > -->

    <div class="scrollable-body">

        <div class="form-group">
            <label for="inputContact" class="col-sm-4 control-label center">Profile Pic</label>
            <div class="col-sm-5">
                  <img class="img-responsive img-thumbnail" src="<?php echo base_url().'assets/images/profile_pic/'.$userDetail['profilPic'].'?ver='.date('dmyhsi'); ?>" alt="Profile Picture">
            </div>
        </div>
        <div class="form-group">
            <label for="inputFirstName" class="col-sm-4 control-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" value="<?php echo $userDetail['fName']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputLastName" class="col-sm-4 control-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputLastName" name="inputLastName" value="<?php echo $userDetail['lName']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" disabled id="inputEmail" name="inputEmail" value="<?php echo $userDetail['emailID']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputContact" class="col-sm-4 control-label">Contact</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputContact" name="inputContact" value="<?php echo $userDetail['contactNumber']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputParentName" class="col-sm-4 control-label">Parent's Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputParentName" name="inputParentName" value="<?php echo $userDetail['parentName']; ?>">
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
                <textarea id="inputAddress" name="inputAddress" class="form-control" rows="3"><?php echo $userDetail['residenceAdd']; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputDesc" class="col-sm-4 control-label">Additional Info</label>
            <div class="col-sm-6">
                <textarea id="inputDesc" name="inputDesc" class="form-control" rows="3"><?php echo $userDetail['additionalInfo']; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="inputBoard" class="col-sm-4 control-label">Select Board</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputBoard" name="inputBoard">
                    <option value="">----Select----</option>
                    <?php foreach( $boardArr as $bValues ): ?>
                        <option value="<?php echo $bValues['boardID']; ?>" <?php if($bValues['boardID'] == $userDetail['boardID']){ echo "SELECTED"; } ?>><?php echo $bValues['boardName']; ?></option>
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
                        <option value="<?php echo $dValues['schoolID']; ?>" <?php if($dValues['schoolID'] == $userDetail['schoolID']){ echo "SELECTED"; } ?>><?php echo $dValues['schoolName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        <div class="form-group">
            <label for="inputClass" class="col-sm-4 control-label">Select Class</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputClass" name="inputClass">
                    <option value="">----Select----</option>
                    <?php foreach( $classArr as $dValues ): ?>
                        <option value="<?php echo $dValues['stdID']; ?>" <?php if($dValues['stdID'] == $userDetail['stdID']){ echo "SELECTED"; } ?>><?php echo $dValues['stdName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        <div class="form-group">
            <label for="inputPackage" class="col-sm-4 control-label">Select Package</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputPackage" name="inputPackage">
                    <option value="T" <?php echo ($userDetail['userPackageType'] == 'T') ? 'SELECTED' : ''; ?>>Free Trial</option>
                    <option value="B" <?php echo ($userDetail['userPackageType'] == 'B') ? 'SELECTED' : ''; ?>>Bronze</option>
                    <option value="S" <?php echo ($userDetail['userPackageType'] == 'S') ? 'SELECTED' : ''; ?>>Silver</option>
                    <option value="G" <?php echo ($userDetail['userPackageType'] == 'G') ? 'SELECTED' : ''; ?>>Gold</option>
                </select>                 
            </div>
        </div>

        <div id="bronze"<?php if($userDetail['userPackageType'] != 'B' && $userDetail['userPackageType'] != 'S' && $userDetail['userPackageType'] != 'G'){ echo 'style="display:none;"'; } ?>>
        <div class="form-group">
            <label for="inputSubject1" class="col-sm-4 control-label">Select Subject 1</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSubject1" name="inputSubject1">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectArr as $dValues ): ?>
                        <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[0]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[0]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        </div>

        <div id="silver"<?php if($userDetail['userPackageType'] != 'S' && $userDetail['userPackageType'] != 'G'){ echo 'style="display:none;"'; } ?>>
        <div class="form-group">
            <label for="inputSubject2" class="col-sm-4 control-label">Select Subject 2</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSubject2" name="inputSubject2">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectArr as $dValues ): ?>
                        <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[1]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[1]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
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
                        <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[2]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[2]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        </div>

        <div id="silver"<?php if($userDetail['userPackageType'] != 'G'){ echo 'style="display:none;"'; } ?>>
        <div class="form-group">
            <label for="inputSubject4" class="col-sm-4 control-label">Select Subject 4</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSubject4" name="inputSubject4">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectArr as $dValues ): ?>
                        <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[3]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[3]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
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
                        <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[4]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[4]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
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
                        <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[5]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[5]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                 
            </div>
        </div>
        </div>

        <div class="form-group">
            <label for="inputRolestatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-6">
                <select name="inputUserStatus" id="inputUserStatus" class="form-control">
                    <option value="Y" <?php if($userDetail["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($userDetail["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
            </div>
        </div>

    </div>
        
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-default">Submit</button>&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <input type="hidden" name="EID" value="<?php echo $userDetail['userID']; ?>" />
            <input type="hidden" name="profile_pic" value="<?php echo $userDetail['profilPic']; ?>" />
        </div>
    </div>

    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>
