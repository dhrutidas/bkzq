<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Level</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-level','class="form-horizontal" id="addLevelform"'); ?>

        <div class="form-group">
            <label for="inputLevelName" class="col-sm-4 control-label">Level Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputLevelName" name="inputLevelName">
            </div>
        </div>
        <div class="form-group">
            <label for="inputLevelDesc" class="col-sm-4 control-label">Level Description</label>
            <div class="col-sm-8">
                <textarea id="inputLevelDesc" name="inputLevelDesc" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLevelOrder" class="col-sm-4 control-label">Level Order</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputLevelOrder" name="inputLevelOrder">
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
