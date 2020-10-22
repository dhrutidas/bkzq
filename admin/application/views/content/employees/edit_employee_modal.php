<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Edit User Details</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open_multipart('submit-edit-user','class="form-horizontal" id="editEmployeeform"'); ?>
    <!-- <form method="post" action="submit-edit-user" enctype="multipart/form-data" class="form-horizontal" id="editEmployeeform" > -->

    <div class="scrollable-body">

        <!-- <div class="form-group">
            <label for="inputContact" class="col-sm-4 control-label center">Profile Pic</label>
            <div class="col-sm-5">
                  <img class="img-responsive img-thumbnail" src="<?php echo base_url().'assets/images/profile_pic/'.$userDetail['profilPic'].'?ver='.date('dmyhsi'); ?>" alt="Profile Picture">
            </div>
        </div> -->
        <div class="form-group">
            <label for="inputFirstName" class="col-sm-4 control-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" value="<?php echo $userDetail['fName']; ?>">
                <span id="first_name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLastName" class="col-sm-4 control-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputLastName" name="inputLastName" value="<?php echo $userDetail['lName']; ?>">
                <span id="last_name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" disabled id="inputEmail" name="inputEmail" value="<?php echo $userDetail['emailID']; ?>">
                <span id="email_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputContact" class="col-sm-4 control-label">Contact</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputContact" name="inputContact" value="<?php echo $userDetail['contactNumber']; ?>">
                <span id="contact_error" class="text-danger"></span>
            </div>
        </div>
        <!-- <div class="form-group">
            <label for="inputParentName" class="col-sm-4 control-label">Parent's Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputParentName" name="inputParentName" value="<?php echo $userDetail['parentName']; ?>">
            </div>
        </div> -->
        <!-- <div class="form-group">
            <label for="inputProfilePic" class="col-sm-4 control-label">Upload Profile Pic</label>
            <div class="col-sm-6">
                <input type="file" name="inputProfilePic" id="inputProfilePic" accept="image/*">
            </div>
        </div> -->
        <!-- <div class="form-group">
            <label for="inputAddress" class="col-sm-4 control-label">Address</label>
            <div class="col-sm-6">
                <textarea id="inputAddress" name="inputAddress" class="form-control" rows="3"><?php echo $userDetail['residenceAdd']; ?></textarea>
            </div>
        </div> -->
        <!-- <div class="form-group">
            <label for="inputDesc" class="col-sm-4 control-label">Additional Info</label>
            <div class="col-sm-6">
                <textarea id="inputDesc" name="inputDesc" class="form-control" rows="3"><?php echo $userDetail['additionalInfo']; ?></textarea>
            </div>
        </div> -->

        <div class="form-group">
            <label for="inputRole" class="col-sm-4 control-label">Select Role</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputRole" name="inputRole">
                    <option value="">----Select----</option>
                    <?php foreach( $roleArr as $rValues ): ?>
                        <option value="<?php echo $rValues['roleID']; ?>" <?php if($rValues['roleID'] == $userDetail['roleID']){ echo "SELECTED"; } ?>><?php echo $rValues['roleName']; ?></option>
                    <?php endforeach; ?>
                </select>
                <span id="role_error" class="text-danger"></span>              
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
            <button type="submit" class="btn btn-default btn-submit">Submit</button>&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <input type="hidden" name="EID" value="<?php echo $userDetail['userID']; ?>" />
            <input type="hidden" name="profile_pic" value="<?php echo $userDetail['profilPic']; ?>" />
        </div>
    </div>

    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>
<script type="text/javascript">

$(document).ready(function() {

  $(".btn-submit").click(function(e){

      e.preventDefault();

      var inputFirstName = $("input[name='inputFirstName']").val();
      var inputLastName = $("input[name='inputLastName']").val();
      var inputEmail = $("input[name='inputEmail']").val();
      var inputContact = $("input[name='inputContact']").val();
      var inputRole = $('#inputRole').val();
      var inputPassword = $("input[name='inputPassword']").val();
      var inputConfirmPassword = $("input[name='inputConfirmPassword']").val();
      var userID = $("input[name='EID']").val();
      var status = $('#inputUserStatus').val();

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {userID:userID, status:status, inputFirstName:inputFirstName, inputLastName:inputLastName, inputEmail:inputEmail, inputContact:inputContact, inputRole:inputRole, inputPassword:inputPassword, inputConfirmPassword:inputConfirmPassword},

          success: function(data) {
            if(data.error)
            {
                if(data.first_name_error != '')
                {
                    $('#first_name_error').html(data.first_name_error);
                }
                else
                {
                    $('#first_name_error').html('');
                }
                if(data.last_name_error != '')
                {
                    $('#last_name_error').html(data.last_name_error);
                }
                else
                {
                    $('#last_name_error').html('');
                }
                if(data.email_error != '')
                {
                    $('#email_error').html(data.email_error);
                }
                else
                {
                    $('#email_error').html('');
                }
                if(data.contact_error != '')
                {
                    $('#contact_error').html(data.contact_error);
                }
                else
                {
                    $('#contact_error').html('');
                }
                if(data.role_error != '')
                {
                    $('#role_error').html(data.role_error);
                }
                else
                {
                    $('#role_error').html('');
                }
                if(data.password_error != '')
                {
                    $('#password_error').html(data.password_error);
                }
                else
                {
                    $('#password_error').html('');
                }
                if(data.confirm_password_error != '')
                {
                    $('#confirm_password_error').html(data.confirm_password_error);
                }
                else
                {
                    $('#confirm_password_error').html('');
                }
            }
            if(data.success)
            {
                $('#first_name_error').html(data.success);
                $('#last_name_error').html('');
                $('#contact_error').html('');
                $('#role_error').html('');
                $('#password_error').html('');
                $('#confirm_password_error').html('');
                $('#editEmployeeform')[0].reset();
                window.location.href='manage-users';
            }
           
          }

      });

  }); 

});

</script>
