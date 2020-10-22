<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>View Branch Details</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-view-branch','class="form-horizontal" id="viewBranchform"'); ?>
        
        <div class="scrollable-body">
        <div class="form-group">
            <label for="inputBranchCode" class="col-sm-4 control-label">Branch Code</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputBranchCode" name="inputBranchCode"
                       value="<?php echo $branchDetails['branch_code']; ?>" disabled />
            </div>
        </div>
        <div class="form-group">
            <label for="inputBranchName" class="col-sm-4 control-label">Branch Name</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBranchName" name="inputBranchName"
                       value="<?php echo $branchDetails['branch_name']; ?>" disabled/>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBranchAddress" class="col-sm-4 control-label">Branch Address</label>
            <div class="col-sm-8">
                <textarea id="inputBranchAddress" name="inputBranchAddress" class="form-control" rows="3"  disabled ><?php echo $branchDetails['branch_address'];?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="inputBranchContact" class="col-sm-4 control-label">Branch Contact</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBranchContact" name="inputBranchContact"
                       value="<?php echo $branchDetails['branch_contact']; ?>"  disabled />
            </div>
        </div>
        <div class="form-group">
            <label for="inputBranchEmail" class="col-sm-4 control-label">Branch Email</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBranchEmail" name="inputBranchEmail"
                       value="<?php echo $branchDetails['branch_email']; ?>"  disabled />
            </div>
        </div>
        <div class="form-group">
            <label for="inputBranchRegion" class="col-sm-4 control-label">Branch Region</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBranchRegion" name="inputBranchRegion"
                       value="<?php echo $branchDetails['branch_region']; ?>"  disabled />
            </div>
        </div>
        <div class="form-group">
            <label for="inputBranchLocation" class="col-sm-4 control-label">Branch Location</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBranchLocation" name="inputBranchLocation"
                       value="<?php echo $branchDetails['branch_location']; ?>"  disabled />
            </div>
        </div>
        <div class="form-group">
            <label for="inputBranchIp" class="col-sm-4 control-label">Branch IP</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBranchIp" name="inputBranchIp" 
                       value="00.00.00.00" readonly />
            </div>
        </div>
        <div class="form-group">
            <label for="inputBranchGps" class="col-sm-4 control-label">Branch GPS</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="inputBranchGps" name="inputBranchGps"
                       value="00.00.00.00" readonly />
            </div>
        </div>
        </div>
    </form>
</div>

<!--<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>-->
