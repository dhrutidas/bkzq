<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Privillage</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-application','class="form-horizontal" id="addLevelform"'); ?>

        <div class="form-group">
           <label for="inputAppName" class="col-sm-4 control-label">App Name *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputAppName" name="inputAppName">
                <span id="app_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputAppPath" class="col-sm-4 control-label">App Path *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputAppPath" name="inputAppPath">
                <span id="path_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputAppOrder" class="col-sm-4 control-label">App Order *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputAppOrder" name="inputAppOrder">
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

      var inputAppName = $("input[name='inputAppName']").val();
      var inputAppPath = $("input[name='inputAppPath']").val();
      var inputAppOrder = $("input[name='inputAppOrder']").val();

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputAppName:inputAppName, inputAppPath:inputAppPath, inputAppOrder:inputAppOrder},

          success: function(data) {
            if(data.error)
            {
                if(data.app_error != '')
                {
                    $('#app_error').html(data.app_error);
                }
                else
                {
                    $('#app_error').html('');
                }
                if(data.path_error != '')
                {
                    $('#path_error').html(data.path_error);
                }
                else
                {
                    $('#path_error').html('');
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