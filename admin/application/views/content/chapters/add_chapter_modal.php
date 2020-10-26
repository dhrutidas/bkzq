<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Chapter</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-chapter','class="form-horizontal" id="addSubjectform"'); ?>

        <div class="form-group">
            <label for="inputChaptername" class="col-sm-4 control-label">Name *</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputChaptername" name="inputChaptername">
                <span id="name_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputChapterdesc" class="col-sm-4 control-label">Description *</label>
            <div class="col-sm-8">
                <textarea id="inputChapterdesc" name="inputChapterdesc" class="form-control" rows="3"></textarea>
                <span id="desc_error" class="text-danger"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubject" class="col-sm-4 control-label">Select Subject *</label>
            <div class="col-sm-8">
                <select class="form-control" id="inputSubject" name="inputSubject">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectDetails as $sValues ): ?>
                        <option value="<?php echo $sValues['subjectID']; ?>"><?php echo $sValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>       
                <span id="sub_error" class="text-danger"></span>         
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

      var inputChaptername = $("input[name='inputChaptername']").val();
      var inputChapterdesc = $("textarea[name='inputChapterdesc']").val();
      var inputSubject = $("select[name='inputSubject']").val();

      $.ajax({

          url: $(this).closest('form').attr('action'),

          type:$(this).closest('form').attr('method'),

          dataType: "json",

          data: {inputChaptername:inputChaptername, inputChapterdesc:inputChapterdesc, inputSubject:inputSubject},

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
                if(data.sub_error != '')
                {
                    $('#sub_error').html(data.sub_error);
                }
                else
                {
                    $('#sub_error').html('');
                }
                
            }
            if(data.success)
            {
                $('#name_error').html(data.success);
                $('#desc_error').html('');
                $('#sub_error').html('');
                window.location.href='manage-chapters';
            }
          

          }

      });

  });


});

</script>