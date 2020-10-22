<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Edit Branch Details</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-class','class="form-horizontal" id="editClassform"'); ?>

        <div class="form-group">
            <label for="inputClassName" class="col-sm-4 control-label">Class Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputClassName" name="inputClassName" value="<?php echo $classDetails["stdName"]; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputClassDesc" class="col-sm-4 control-label">Class Description</label>
            <div class="col-sm-8">
                <textarea id="inputClassDesc" name="inputClassDesc" class="form-control" rows="3"><?php echo $classDetails["stdDesc"]; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputClassstatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <select name="inputClassstatus" id="inputClassstatus" class="form-control">
                    <option value="Y" <?php if($classDetails["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($classDetails["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="inputBid" value="<?php echo $classDetails['stdID']; ?>" />
            </div>
        </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>
