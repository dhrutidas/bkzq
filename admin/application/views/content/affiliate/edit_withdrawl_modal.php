<style>   
    .clsDatePicker {
    z-index: 100000;
}
</style>
<script>
     $('#paymentDate').datepicker({
     dateFormat: 'yy-mm-dd',
     maxDate: 0,
     changeMonth: true,
     changeYear: true
 });
    </script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Update payments</h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-withdrawl','class="form-horizontal" id="editBoardform"'); ?>

       <!--  <div class="form-group">
            <label for="inputBoardcode" class="col-sm-4 control-label">Board Code</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" id="inputBoardcode" name="inputBoardcode" 
                       value="<?php //echo $boardDetails["board_code"]; ?>" disabled>
            </div>
        </div> -->
        <div class="form-group">
            <label for="inputBoardname" class="col-sm-4 control-label">Amount Paid</label>
            <div class="col-sm-8">
                <input type="number" class="form-control" id="amountPaid" name="amountPaid" 
                       value="<?php echo $boardDetails["amountPaid"]; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="inputBoarddesc" class="col-sm-4 control-label">Payment date</label>
            <div class="col-sm-8">                
                <!-- <input type="date" id="paymentDate" name="paymentDate" style="color:black" value="<?php echo $boardDetails['paymentDate']; ?>"/> -->
                <!-- <input type="text" class="form-control datepicker_class" id="paymentDate" name="paymentDate"/> -->
                <input type="text" name="paymentDate" id="paymentDate" readonly="readonly" class="form-control clsDatePicker" value="<?php echo $boardDetails['paymentDate']; ?>" />
                          
            </div>
        </div>
        <div class="form-group">
            <label for="paymentMode" class="col-sm-4 control-label">Payment mode</label>
            <div class="col-sm-8">
                <select name="paymentMode" id="paymentMode" class="form-control">
                    <option value="Cash" <?php if($boardDetails["paymentMode"] == "Cash"){ echo "SELECTED"; }?>>Cash</option>
                    <option value="Cheque" <?php if($boardDetails["paymentMode"] == "Cheque"){ echo "SELECTED"; }?>>Cheque</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-4 control-label">Description</label>
            <div class="col-sm-8">
               <?php echo $boardDetails["message"]; ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-8">
                <button type="submit" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="id" value="<?php echo $boardDetails["id"]; ?>" />
            </div>
        </div>
        
    </form>
</div>

<div class="modal-footer"><p class="text-danger">*All fields are mandatory.</p></div>
