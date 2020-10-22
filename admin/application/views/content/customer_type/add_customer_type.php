<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Customer Type</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-customer-type','class="form-horizontal" id="addClassform"'); ?>

        <div class="form-group">
            <label for="inputcustomertypename" class="col-sm-4 control-label">Type Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputcustomertypename" name="inputcustomertypename">
            </div>
        </div>
        <div class="form-group">
            <label for="inputcustomertypedesc" class="col-sm-4 control-label">Type Description</label>
            <div class="col-sm-8">
                <textarea id="inputcustomertypedesc" name="inputcustomertypedesc" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputlevel" class="col-sm-4 control-label">Level</label>
            <div class="col-sm-8">
                <select name="inputlevel" id="inputlevel" class="form-control">
                    <option value="">----Select----</option>
                    <?php foreach ($levelDetails AS $value) { ?>
                        <option value="<?php echo $value['levelID']; ?>"><?php echo $value['levelName']; ?></option>
                    <?php } ?>
                </select>
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
