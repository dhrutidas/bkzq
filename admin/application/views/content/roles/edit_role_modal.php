<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Edit Role</h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-role','class="form-horizontal" id="editRoleform"'); ?>

        <!-- <div class="form-group">
            <label for="inputRolecode" class="col-sm-3 control-label">Role Code</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputRolecode" name="inputRolecode" 
                       value="<?php //echo $roleDetails["role_code"]; ?>" disabled>
            </div>
        </div> -->
        <div class="form-group">
            <label for="inputRolename" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputRolename" name="inputRolename" 
                       value="<?php echo $roleDetails["roleName"]; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputRoledesc" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <textarea id="inputRoledesc" name="inputRoledesc" class="form-control" rows="3"><?php echo $roleDetails["roleDescription"]; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputRolestatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <select name="inputRolestatus" id="inputRolestatus" class="form-control">
                    <option value="Y" <?php if($roleDetails["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($roleDetails["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="inputRID" value="<?php echo $roleDetails["roleID"]; ?>" />
            </div>
        </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
