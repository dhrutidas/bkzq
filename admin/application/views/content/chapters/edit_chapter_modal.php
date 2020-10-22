<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Edit Stream</h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-chapter','class="form-horizontal" id="editStreamform"'); ?>

        <div class="form-group">
            <label for="inputChaptername" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputChaptername" name="inputChaptername" value="<?php echo $chapterDetails['chapterName']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputChapterdesc" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <textarea id="inputChapterdesc" name="inputChapterdesc" class="form-control" rows="3"><?php echo $chapterDetails['chapterDesc']; ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubject" class="col-sm-4 control-label">Select Subject</label>
            <div class="col-sm-8">
                <select class="form-control" id="inputSubject" name="inputSubject">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectDetails as $sValues ): ?>
                        <option value="<?php echo $sValues['subjectID']; ?>"<?php echo ($sValues['subjectID']==$chapterDetails['subjectID']) ? 'SELECTED' : ''; ?> ><?php echo $sValues['subjectName']; ?></option>
                    <?php endforeach; ?>
                </select>                
            </div>
        </div>

        <div class="form-group">
            <label for="inputChapterstatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <select name="inputChapterstatus" id="inputChapterstatus" class="form-control">
                    <option value="Y" <?php if($chapterDetails["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($chapterDetails["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="inputCID" value="<?php echo $chapterDetails["chapterID"]; ?>" />
            </div>
        </div>

    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
