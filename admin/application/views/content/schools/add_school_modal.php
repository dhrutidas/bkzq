<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Add New School</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-add-school','class="form-horizontal" id="addSchoolform"'); ?>

        <div class="form-group">
            <label for="inputSchoolname" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputSchoolname" name="inputSchoolname">
            </div>
        </div>
        <div class="form-group">
            <label for="inputSchoolPhone" class="col-sm-4 control-label">Contact No.</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputSchoolPhone" name="inputSchoolPhone">
            </div>
        </div>
        <div class="form-group">
            <label for="inputSchoolAdd" class="col-sm-4 control-label">Address</label>
            <div class="col-sm-8">
                <textarea id="inputSchoolAdd" name="inputSchoolAdd" class="form-control" rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputSchoolEmail" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputSchoolEmail" name="inputSchoolEmail">
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
