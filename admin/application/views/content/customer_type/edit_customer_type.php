<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class='modal-title text-primary'><b>Update Customer Details</b></h4>
</div>
 
<div class="modal-body bg-primary" >
  <?php echo form_open('submit-edit-customer-type','class="form-horizontal" id="addcustomertypeform"'); ?>
  
  <div class="form-group">
    <label for="inputcustomertypename" class="col-sm-4 control-label">Type Name</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="inputcustomertypename" name="inputcustomertypename" value="<?php echo $customer_data['custTypeName']; ?>">
    </div>
  </div>
  <div class="form-group">
    <label for="inputcustomertypedesc" class="col-sm-4 control-label">Type Description</label>
    <div class="col-sm-8">
      <textarea id="inputcustomertypedesc" name="inputcustomertypedesc" class="form-control" rows="3"><?php echo $customer_data['custTypeDesc']; ?></textarea>
    </div>
  </div>
  <div class="form-group">
    <label for="inputlevel" class="col-sm-4 control-label">Level</label>
    <div class="col-sm-8">
      <select name="inputlevel" id="inputlevel" class="form-control">
        <option value="">----Select----</option>
        <?php foreach ($levelDetails AS $value) { ?>
        <option value="<?php echo $value['levelID']; ?>"<?php if($customer_data['levelAccess'] == $value['levelID']) { echo "SELECTED"; } ?>><?php echo $value['levelName']; ?></option>
        <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group">
    <label for="inputstatus" class="col-sm-4 control-label">Status</label>
    <div class="col-sm-8">
      <select name="inputstatus" id="inputstatus" class="form-control">
        <option value="Y" <?php if($customer_data["status"] == "Y"){ echo "SELECTED"; }?>>Active</option>
        <option value="N" <?php if($customer_data["status"] == "N"){ echo "SELECTED"; }?>>Inactive</option>
      </select>
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-4 control-label" for="formGroupInputSmall"></label>
    <div class="col-sm-8">
      <button type="submit" class="btn btn-default">Submit</button>&nbsp;
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
      <input type="hidden" name="cID" value='<?php echo $customer_data['custTypeID'];?>'>
    </div>
  </div>
</form>
</div>
<div class="modal-footer text-right"><p class="text-danger">All fields are mandatory</p></div>