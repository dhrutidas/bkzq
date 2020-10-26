<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Level</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-level','class="form-horizontal" id="addLevelform"'); ?>

        <div class="form-group">
            <label for="inputLevelName" class="col-sm-4 control-label">Level Name *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputLevelName" name="inputLevelName">
                <span id="name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLevelDesc" class="col-sm-4 control-label">Level Description *</label>
            <div class="col-sm-8">
                <textarea id="inputLevelDesc" name="inputLevelDesc" class="form-control" rows="3"></textarea>
                <span id="desc_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLevelOrder" class="col-sm-4 control-label">Level Order *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputLevelOrder" name="inputLevelOrder">
                <span id="order_error" class="text-danger"></span>
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

      var inputLevelName = $("input[name='inputLevelName']").val();
      var inputLevelDesc = $("textarea[name='inputLevelDesc']").val();
      var inputLevelOrder = $("input[name='inputLevelOrder']").val();

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputLevelName:inputLevelName, inputLevelDesc:inputLevelDesc, inputLevelOrder:inputLevelOrder},

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
                if(data.order_error != '')
                {
                    $('#order_error').html(data.order_error);
                }
                else
                {
                    $('#order_error').html('');
                }
                
            }
            if(data.success)
            {
                $('#name_error').html(data.success);
                $('#desc_error').html('');
                $('#order_error').html('');
                window.location.href='manage-level';
            }
          

          }

      });

  });


});

</script>