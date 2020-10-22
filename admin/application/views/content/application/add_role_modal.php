<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Role</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-role','class="form-horizontal" id="addRoleform"'); ?>

        <div class="form-group">
            <label for="inputRolecode" class="col-sm-3 control-label">Role Code</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputRolecode" name="inputRolecode">
            </div>
        </div>
        <div class="form-group">
            <label for="inputRolename" class="col-sm-3 control-label">Role Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputRolename" name="inputRolename">
            </div>
        </div>
        <div class="form-group">
            <label for="inputRoledesc" class="col-sm-3 control-label">Role Description</label>
            <div class="col-sm-8">
                <textarea id="inputRoledesc" name="inputRoledesc" class="form-control" rows="3"></textarea>
            </div>
        </div>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
