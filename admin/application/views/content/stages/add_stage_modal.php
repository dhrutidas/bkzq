<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Stage</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-stage','class="form-horizontal" id="addStageform"'); ?>

        <div class="form-group">
            <label for="inputStagename" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputStagename" name="inputStagename">
            </div>
        </div>
        <div class="form-group">
            <label for="inputStagedesc" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <textarea id="inputStagedesc" name="inputStagedesc" class="form-control" rows="3"></textarea>
            </div>
        </div>
         <div class="form-group">
            <label for="inputLevel" class="col-sm-4 control-label">Level</label>
            <div class="col-sm-8">
                <select name="inputLevel" id="inputLevel" class="form-control">
                    <option value="">----Select----</option>
                    <?php foreach ($levelDetails AS $value) { ?>
                        <option value="<?php echo $value['levelID']; ?>"><?php echo $value['levelName']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputMaxQuestion" class="col-sm-4 control-label">Max. Questions</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputMaxQuestion" name="inputMaxQuestion">
            </div>
        </div>
        <div class="form-group">
            <label for="inputMaxQuesAllowed" class="col-sm-4 control-label">Max. Question Allowed</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputMaxQuesAllowed" name="inputMaxQuesAllowed">
            </div>
        </div>
        <div class="form-group">
            <label for="inputMinPass" class="col-sm-4 control-label">Min. Passing</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputMinPass" name="inputMinPass">
            </div>
        </div>
        <div class="form-group">
            <label for="inpuStageOrder" class="col-sm-4 control-label">Stage Order</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inpuStageOrder" name="inpuStageOrder">
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

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
