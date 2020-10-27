<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Class</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-class','class="form-horizontal" id="addClassform"'); ?>

        <div class="form-group">
            <label for="inputClassName" class="col-sm-4 control-label">Class Name *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputClassName" name="inputClassName">
                <span id="name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputClassDesc" class="col-sm-4 control-label">Class Description *</label>
            <div class="col-sm-8">
                <textarea id="inputClassDesc" name="inputClassDesc" class="form-control" rows="3"></textarea>
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

<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>

<script type="text/javascript">

$(document).ready(function() {

  $(".btn-submit").click(function(e){

      e.preventDefault();

      var inputClassName = $("input[name='inputClassName']").val();
      var inputClassDesc = $("textarea[name='inputClassDesc']").val();

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputClassName:inputClassName, inputClassDesc:inputClassDesc},

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
                window.location.href='manage-classes';
            }
          

          }

      });

  });


});

</script>