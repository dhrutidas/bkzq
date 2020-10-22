<script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Edit Details</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open_multipart('submit-edit-affiliate','class="form-horizontal" id="editStudentform"'); ?>
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
