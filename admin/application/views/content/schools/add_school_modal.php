<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New School</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-school','class="form-horizontal" id="addSchoolform"'); ?>

        <div class="form-group">
            <label for="inputSchoolname" class="col-sm-4 control-label">Name *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputSchoolname" name="inputSchoolname">
                <span id="name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSchoolPhone" class="col-sm-4 control-label">Contact No. *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputSchoolPhone" name="inputSchoolPhone">
                <span id="phone_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSchoolAdd" class="col-sm-4 control-label">Address *</label>
            <div class="col-sm-8">
                <textarea id="inputSchoolAdd" name="inputSchoolAdd" class="form-control" rows="3"></textarea>
                <span id="add_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSchoolEmail" class="col-sm-4 control-label">Email *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputSchoolEmail" name="inputSchoolEmail">
                <span id="email_error" class="text-danger"></span>
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

      var inputSchoolname = $("input[name='inputSchoolname']").val();
      var inputSchoolPhone = $("input[name='inputSchoolPhone']").val();
      var inputSchoolAdd = $("textarea[name='inputSchoolAdd']").val();
      var inputSchoolEmail = $("input[name='inputSchoolEmail']").val();

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputSchoolname:inputSchoolname, inputSchoolPhone:inputSchoolPhone, inputSchoolAdd:inputSchoolAdd, inputSchoolEmail:inputSchoolEmail},

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
                if(data.phone_error != '')
                {
                    $('#phone_error').html(data.phone_error);
                }
                else
                {
                    $('#phone_error').html('');
                }
                if(data.add_error != '')
                {
                    $('#add_error').html(data.add_error);
                }
                else
                {
                    $('#add_error').html('');
                }
                if(data.email_error != '')
                {
                    $('#email_error').html(data.email_error);
                }
                else
                {
                    $('#email_error').html('');
                }
                
            }
            if(data.success)
            {
                $('#app_error').html(data.success);
                $('#path_error').html('');
                $('#order_error').html('');
                window.location.href='manage-applications';
            }
          

          }

      });

  });


});

</script>