<script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New User</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open_multipart('submit-add-student','class="form-horizontal" id="addStudentform"'); ?>
        
    <div class="scrollable-body">

        <div class="form-group">
            <label for="inputFirstName" class="col-sm-4 control-label">First Name *</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputFirstName" name="inputFirstName">
                <span id="fname_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLastName" class="col-sm-4 control-label">Last Name *</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputLastName" name="inputLastName">
                <span id="lname_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-4 control-label">Email *</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputEmail" name="inputEmail">
                <span id="email_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputContact" class="col-sm-4 control-label">Contact *</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputContact" name="inputContact">
                <span id="contact_error" class="text-danger"></span>
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
            <label for="inputBoard" class="col-sm-4 control-label">Select Board *</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputBoard" name="inputBoard">
                    <option value="">----Select----</option>
                    <?php foreach( $boardArr as $bValues ): ?>
                        <option value="<?php echo $bValues['boardID']; ?>"><?php echo $bValues['boardName']; ?></option>
                    <?php endforeach; ?>
                </select> 
                <span id="board_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSchool" class="col-sm-4 control-label">Select School *</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputSchool" name="inputSchool">
                    <option value="">----Select----</option>
                    <?php foreach( $schoolArr as $dValues ): ?>
                        <option value="<?php echo $dValues['schoolID']; ?>"><?php echo $dValues['schoolName']; ?></option>
                    <?php endforeach; ?>
                </select>       
                <span id="school_error" class="text-danger"></span>          
            </div>
        </div>
        <div class="form-group">
            <label for="inputClass" class="col-sm-4 control-label">Select Statndard *</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputClass" name="inputClass">
                    <option value="">----Select----</option>
                    <?php foreach( $classArr as $dValues ): ?>
                        <option value="<?php echo $dValues['stdID']; ?>"><?php echo $dValues['stdName']; ?></option>
                    <?php endforeach; ?>
                </select>        
                <span id="class_error" class="text-danger"></span>         
            </div>
        </div>
        <div class="form-group">
            <label for="inputPackage" class="col-sm-4 control-label">Select Package *</label>
            <div class="col-sm-6">
                <select class="form-control" id="inputPackage" name="inputPackage">
                    <option value="">----Select----</option>
                    <option value="T">Free Trial</option>
                    <option value="B">Bronze</option>
                    <option value="S">Silver</option>
                    <option value="G">Gold</option>
                </select>   
                <span id="package_error" class="text-danger"></span>              
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
      var inputBoard = $("select[name='inputBoard']").val();
      var inputSchool = $("select[name='inputSchool']").val();
      var inputClass = $("select[name='inputClass']").val();
      var inputPackage = $("select[name='inputPackage']").val();

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputFirstName:inputFirstName, inputLastName:inputLastName, inputEmail:inputEmail, inputContact:inputContact, inputBoard:inputBoard, inputSchool:inputSchool, inputClass:inputClass, inputPackage:inputPackage},

          success: function(data) {
            if(data.error)
            {

                if(data.fname_error != '')
                {
                    $('#fname_error').html(data.fname_error);
                }
                else
                {
                    $('#fname_error').html('');
                }
                if(data.lname_error != '')
                {
                    $('#lname_error').html(data.lname_error);
                }
                else
                {
                    $('#lname_error').html('');
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
                if(data.board_error != '')
                {
                    $('#board_error').html(data.board_error);
                }
                else
                {
                    $('#board_error').html('');
                }
                if(data.school_error != '')
                {
                    $('#school_error').html(data.school_error);
                }
                else
                {
                    $('#school_error').html('');
                }
                if(data.class_error != '')
                {
                    $('#class_error').html(data.class_error);
                }
                else
                {
                    $('#class_error').html('');
                }
                if(data.package_error != '')
                {
                    $('#package_error').html(data.package_error);
                }
                else
                {
                    $('#package_error').html('');
                }
                
            }
            if(data.success)
            {
                $('#fname_error').html(data.success);
                $('#lname_error').html('');
                $('#email_error').html('');
                $('#contact_error').html('');
                $('#board_error').html('');
                $('#school_error').html('');
                $('#class_error').html('');
                $('#package_error').html('');
                window.location.href='manage-students';
            }
          

          }

      });

  });


});

</script>