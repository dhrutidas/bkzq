<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Edit Stream</h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-subject','class="form-horizontal" id="editStreamform"'); ?>

        <div class="form-group">
            <label for="inputSubjectname" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputSubjectname" name="inputSubjectname" value="<?php echo $subjectDetails['subjectName']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubjectdesc" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <textarea id="inputSubjectdesc" name="inputSubjectdesc" class="form-control" rows="3"><?php echo $subjectDetails['subjectDesc']; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubjectdesc" class="col-sm-4 control-label">Select Standard</label>
            <div class="col-sm-8">
                <select id="standards" name="standards[]" class="form-control" multiple>
                    <option value="">Select Standard</option>
                    <?php 
                    $mappedstandards=explode(',',$subjectDetails['stdID']);
                    foreach($allstandards as $standardskey=>$standardsval){ 
                            foreach($mappedstandards as $mappedstandardskey=>$mappedstandardsval){
                                if($standardsval['stdID']==$mappedstandardsval){
                                    $selected='selected';
                                    break;
                                }else{
                                    $selected='';
                                }
                            }
                        ?>
                        <option value="<?php echo $standardsval['stdID']; ?>" <?php echo $selected; ?>><?php echo $standardsval['stdName']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubjectstatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <select name="inputSubjectstatus" id="inputSubjectstatus" class="form-control">
                    <option value="Y" <?php if($subjectDetails["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($subjectDetails["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="inputSID" value="<?php echo $subjectDetails["subjectID"]; ?>" />
            </div>
        </div>
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
