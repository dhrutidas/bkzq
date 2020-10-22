<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Edit Level</h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-level','class="form-horizontal" id="editLevelform"'); ?>

        <div class="form-group">
            <label for="inputLevelName" class="col-sm-4 control-label">Level Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputLevelName" name="inputLevelName" value='<?php echo $levelDetails['levelName'];?>'>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLevelDesc" class="col-sm-4 control-label">Class Description</label>
            <div class="col-sm-8">
                <textarea id="inputLevelDesc" name="inputLevelDesc" class="form-control" rows="3"><?php echo $levelDetails["levelDesc"]; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLevelOrder" class="col-sm-4 control-label">Level Order</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputLevelOrder" name="inputLevelOrder" value='<?php echo $levelDetails['orderBy'];?>'>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label" for="inputLevelStatus">Status</label>
            <div class="col-sm-8">
              <select name="inputLevelStatus" id="inputLevelStatus" class="form-control">
                    <option value="Y" <?php if($levelDetails["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($levelDetails["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
          </div>
        </div>  
        
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input  type="hidden" name="ID" id="ID" value="<?php echo $levelDetails['levelID']; ?>" />
            </div>
        </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">* All Fields are mandatory.</p></div>