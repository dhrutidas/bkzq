<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Edit Stream</h4>
</div>
<div class="modal-body bg-primary">
<?php //print_r($testimonialDetails); ?>
    <?php echo form_open('submit-edit-testimonial','class="form-horizontal" id="editStreamform"'); ?>

        <div class="form-group">
            <label for="inputChaptername" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="inputTestimonialName" name="inputTestimonialName" value="<?php echo $testimonialDetails[0]['name']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputChapterdesc" class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
                <textarea id="inputTestimonialMsg" name="inputTestimonialMsg" class="form-control" rows="3"><?php echo $testimonialDetails[0]['message']; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="inputChapterstatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8">
                <select name="inputTestimonialStatus" id="inputTestimonialStatus" class="form-control">
                    <option value="Y" <?php if($testimonialDetails[0]["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
                    <option value="N" <?php if($testimonialDetails[0]["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="inputTID" value="<?php echo $testimonialDetails[0]["id"]; ?>" />
            </div>
        </div>

    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory</p></div>
