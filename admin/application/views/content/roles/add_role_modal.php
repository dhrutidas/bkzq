<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Role</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-role','class="form-horizontal" id="addRoleform"'); ?>
        <div class="form-group">
            <label for="inputRolename" class="col-sm-4 control-label">Name *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputRolename" name="inputRolename">
                <span id="name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputRoledesc" class="col-sm-4 control-label">Description *</label>
            <div class="col-sm-8">
                <textarea id="inputRoledesc" name="inputRoledesc" class="form-control" rows="3"></textarea>
                <span id="desc_error" class="text-danger"></span>
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

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>

<script type="text/javascript">

$(document).ready(function() {

  $(".btn-submit").click(function(e){

      e.preventDefault();

      var inputRolename = $("input[name='inputRolename']").val();
      var inputRoledesc = $("textarea[name='inputRoledesc']").val();
      
      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputRolename:inputRolename, inputRoledesc:inputRoledesc},

          success: function(data) {
            if(data.error)
            {
                if(data.name_error != '')
                {
                    $('#name_error').html(data.name_error);
                }
                else
                {
                    $('#name_error').html('');
                }
                if(data.desc_error != '')
                {
                    $('#desc_error').html(data.desc_error);
                }
                else
                {
                    $('#desc_error').html('');
                }
               
            }
            if(data.success)
            {
                $('#name_error').html(data.success);
                $('#desc_error').html('');
                window.location.href='manage-roles';
            }
          

          }

      });

  });


});

</script>