<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Update Profile Details</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open_multipart('update-profile','class="form-horizontal" id="updateEmployeeform"'); ?>
   

    <div class="scrollable-body">

      
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
    var inputAddress = $("#inputAddress").val();
    var inputDesc = $("#inputDesc").val();
    
    $.ajax({

        url: $(this).closest('form').attr('action'),

        type:$(this).closest('form').attr('method'),

        dataType: "json",

        data: {inputFirstName:inputFirstName, inputLastName:inputLastName, inputAddress:inputAddress, inputDesc:inputDesc},

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
              $('#first_name_error').html('');
              $('#last_name_error').html('');
              
              $('#updateEmployeeform')[0].reset();
              window.location.href='profile';
          }
         

        }

    });

}); 

});

</script>
