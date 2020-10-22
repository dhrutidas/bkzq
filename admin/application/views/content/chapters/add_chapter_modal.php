<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Chapter</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-chapter','class="form-horizontal" id="addSubjectform"'); ?>

        <div class="form-group">
            <label for="inputChaptername" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputChaptername" name="inputChaptername">
            </div>
        </div>
        <div class="form-group">
            <label for="inputChapterdesc" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <textarea id="inputChapterdesc" name="inputChapterdesc" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubject" class="col-sm-4 control-label">Select Subject</label>
            <div class="col-sm-8">
                <select class="form-control" id="inputSubject" name="inputSubject">
                    <option value="">----Select----</option>
                    <?php foreach( $subjectDetails as $sValues ): ?>
                        <option value="<?php echo $sValues['subjectID']; ?>"><?php echo $sValues['subjectName']; ?></option>
                    <?php endforeach; ?>
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

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
