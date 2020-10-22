<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New Subject</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-subject','class="form-horizontal" id="addSubjectform"'); ?>

        <div class="form-group">
            <label for="inputSubjectname" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputSubjectname" name="inputSubjectname">
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubjectdesc" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <textarea id="inputSubjectdesc" name="inputSubjectdesc" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSubjectdesc" class="col-sm-4 control-label">Select Standard</label>
            <div class="col-sm-8">
                <select id="standards" name="standards[]" class="form-control" multiple>
                    <option value="">Select Standard</option>
                    <?php foreach($allstandards as $standardskey=>$standardsval){ ?>
                        <option value="<?php echo $standardsval['stdID']; ?>"><?php echo $standardsval['stdName']; ?></option>
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

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
