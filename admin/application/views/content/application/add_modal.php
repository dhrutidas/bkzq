<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Privillage</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-application','class="form-horizontal" id="addLevelform"'); ?>

        <div class="form-group">
            <label for="inputAppName" class="col-sm-4 control-label">App Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputAppName" name="inputAppName">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAppPath" class="col-sm-4 control-label">App Path</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputAppPath" name="inputAppPath">
            </div>
        </div>
        <div class="form-group">
            <label for="inputAppOrder" class="col-sm-4 control-label">App Order</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputAppOrder" name="inputAppOrder">
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
