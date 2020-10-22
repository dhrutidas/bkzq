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
            <label for="inputBoardname" class="col-sm-4 control-label">Board Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputBoardname" name="inputBoardname">
            </div>
        </div>
        <div class="form-group">
            <label for="inputBoarddesc" class="col-sm-4 control-label">Board Description</label>
            <div class="col-sm-8">
                <textarea id="inputBoarddesc" name="inputBoarddesc" class="form-control" rows="3"></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>
