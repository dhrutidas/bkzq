<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New User</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open_multipart('submit-add-user','class="form-horizontal" id="addEmployeeform"'); ?>
        
    <div class="scrollable-body">

        <div class="form-group">
            <label for="inputFirstName" class="col-sm-4 control-label">First Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputFirstName" name="inputFirstName">
                <span id="first_name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLastName" class="col-sm-4 control-label">Last Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputLastName" name="inputLastName">
                <span id="last_name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputEmail" name="inputEmail">
                <span id="email_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputContact" class="col-sm-4 control-label">Contact</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputContact" name="inputContact">
                <span id="contact_error" class="text-danger"></span>
            </div>
        </div>
        <!-- <div class="form-group">
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
        </div> -->

        <div class="form-group">
            <label for="inputRole" class="col-sm-4 control-label">Select Role</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputRole" name="inputRole">
                    <option value="">----Select----</option>
                    <?php foreach( $roleArr as $rValues ): ?>
                        <option value="<?php echo $rValues['roleID']; ?>"><?php echo $rValues['roleName']; ?></option>
                    <?php endforeach; ?>
                </select>    
                <span id="role_error" class="text-danger"></span>            
            </div>
        </div>   
        <div class="form-group">
            <label for="inputPassword" class="col-sm-4 control-label">Password</label>
            <div class="col-sm-6 passwordWrap">
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" value="">
                <i class="far fa-eye" id="togglePassword"></i>
                <span id="password_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputConfirmPassword" class="col-sm-4 control-label">Confirm Password</label>
            <div class="col-sm-6">
                <input type="password" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" value="">
                <span id="confirm_password_error" class="text-danger"></span>
            </div>
        </div>             
        
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-default btn-submit">Submit</button>&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputFirstName:inputFirstName, inputLastName:inputLastName, inputEmail:inputEmail, inputContact:inputContact, inputRole:inputRole, inputPassword:inputPassword, inputConfirmPassword:inputConfirmPassword},

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
                $('#addEmployeeform')[0].reset();
                window.location.href='manage-users';
            }
            //   if($.isEmptyObject(data.error)){

            //     $(".alert-danger").css('display','none');

            //     alert(data.success);

            //   }else{

            //     $(".alert-danger").css('display','block');

            //     $(".alert-danger").html(data.error);

            //   }

          }

      });

  }); 
  const togglePassword = document.querySelector('#togglePassword');
  const password = document.querySelector('#inputPassword');

  togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
  });
});

</script>
