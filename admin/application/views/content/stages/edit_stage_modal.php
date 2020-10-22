<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Edit Stream</h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-stage','class="form-horizontal" id="editStreamform"'); ?>

        <div class="form-group">
            <label for="inputStagename" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputStagename" name="inputStagename" value="<?php echo $stageDetails['stageName']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputStagedesc" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <textarea id="inputStagedesc" name="inputStagedesc" class="form-control" rows="3"><?php echo $stageDetails['stageDesc']; ?></textarea>
            </div>
        </div>
         <div class="form-group">
            <label for="inputLevel" class="col-sm-4 control-label">Level</label>
            <div class="col-sm-8">
                <select name="inputLevel" id="inputLevel" class="form-control">
                    <option value="">----Select----</option>
                    <?php foreach ($levelDetails AS $value) { ?>
                        <option value="<?php echo $value['levelID']; ?>"<?php if($value['levelID'] == $stageDetails['levelID']) { echo "SELECTED"; } ?>><?php echo $value['levelName']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputMaxQuestion" class="col-sm-4 control-label">Max. Questions</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputMaxQuestion" name="inputMaxQuestion" value="<?php echo $stageDetails['maxQuestion']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputMaxQuesAllowed" class="col-sm-4 control-label">Max. Question Allowed</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputMaxQuesAllowed" name="inputMaxQuesAllowed" value="<?php echo $stageDetails['maxQuestionAllowed']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputMinPass" class="col-sm-4 control-label">Min. Passing</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputMinPass" name="inputMinPass" value="<?php echo $stageDetails['minPassingCriterea']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inpuStageOrder" class="col-sm-4 control-label">Stage Order</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inpuStageOrder" name="inpuStageOrder" value="<?php echo $stageDetails['orderBy']; ?>">
            </div>
        </div>

        <div class="form-group">
            <label for="inputStagestatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <select name="inputStagestatus" id="inputStagestatus" class="form-control">
                    <option value="Y" <?php if($stageDetails["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($stageDetails["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="inputSID" value="<?php echo $stageDetails["stageID"]; ?>" />
            </div>
        </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
