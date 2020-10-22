<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Edit Board</h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-board','class="form-horizontal" id="editBoardform"'); ?>

       <!--  <div class="form-group">
            <label for="inputBoardcode" class="col-sm-4 control-label">Board Code</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputBoardcode" name="inputBoardcode" 
                       value="<?php //echo $boardDetails["board_code"]; ?>" disabled>
            </div>
        </div> -->
        <div class="form-group">
            <label for="inputBoardname" class="col-sm-4 control-label">Board Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputBoardname" name="inputBoardname" 
                       value="<?php echo $boardDetails["boardName"]; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputBoarddesc" class="col-sm-4 control-label">Board Description</label>
            <div class="col-sm-8">
                <textarea id="inputBoarddesc" name="inputBoarddesc" class="form-control" rows="3"><?php echo $boardDetails["boardDesc"]; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBoardstatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <select name="inputBoardstatus" id="inputBoardstatus" class="form-control">
                    <option value="Y" <?php if($boardDetails["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($boardDetails["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="inputDID" value="<?php echo $boardDetails["boardID"]; ?>" />
            </div>
        </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>
