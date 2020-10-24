<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Board</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-board','class="form-horizontal" id="addBoardform"'); ?>

        <!-- <div class="form-group">
            <label for="inputBoardcode" class="col-sm-4 control-label">Board Code</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputBoardcode" name="inputBoardcode">
            </div>
        </div> -->
        <div class="form-group">
            <label for="inputBoardname" class="col-sm-4 control-label">Board Name *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputBoardname" name="inputBoardname">
                <span id="name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBoarddesc" class="col-sm-4 control-label">Board Description *</label>
            <div class="col-sm-8">
                <textarea id="inputBoarddesc" name="inputBoarddesc" class="form-control" rows="3"></textarea>
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

      var inputBoardname = $("input[name='inputBoardname']").val();
      var inputBoarddesc = $("textarea[name='inputBoarddesc']").val();

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputBoardname:inputBoardname, inputBoarddesc:inputBoarddesc},

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
                window.location.href='manage-boards';
            }
          

          }

      });

  });


});

</script>