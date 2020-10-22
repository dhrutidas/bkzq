<script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>Edit Details</b></h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open_multipart('submit-edit-prizemaster','class="form-horizontal" id="editprizemasterform"'); ?>
    <div class="scrollable-body">

        <div class="form-group">
            <label for="inputContact" class="col-sm-4 control-label center">Affiliate name</label>
            <div class="col-sm-5">                  
                  <label><?php echo $details['affiliateName'];?></label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputFirstName" class="col-sm-4 control-label">Student name</label>
            <div class="col-sm-6">
            <label><?php echo $details['studentName'];?></label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputLastName" class="col-sm-4 control-label">Amount</label>
            <div class="col-sm-6">
            <label><?php echo 'Rs '.$details['amount'];?></label>
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-6">
            <label><?php echo $details['period'];?></label>
            </div>
        </div>        
        <div class="form-group">
            <label for="inputRolestatus" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-6">
                <select name="inputUserStatus" id="inputUserStatus" class="form-control" required>
                <option value="" >Select</option>
                    <option value="approved" >Approve</option>
                    <option value="rejected">Reject</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="inputParentName" class="col-sm-4 control-label">Comment</label>
            <div class="col-sm-6">
                <textarea class="form-control" id="statusComment" name="statusComment"></textarea>
            </div>
        </div>   
    
        
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <button type="submit" class="btn btn-default">Submit</button>&nbsp;
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <input type="hidden" name="id" value="<?php echo $details['id']; ?>" />
            <input type="hidden" name="affiliateEmail" value="<?php echo $details['affiliateEmail']; ?>" />
            <input type="hidden" name="studentEmail" value="<?php echo $details['studentEmail']; ?>" />
            <input type="hidden" name="affiliateName" value="<?php echo $details['affiliateName']; ?>" />
            <input type="hidden" name="studentName" value="<?php echo $details['studentName']; ?>" />
            <input type="hidden" name="amount" value="<?php echo $details['amount']; ?>" />
            <input type="hidden" name="period" value="<?php echo $details['period']; ?>" />
        </div>
    </div>

    </form>
</div>


