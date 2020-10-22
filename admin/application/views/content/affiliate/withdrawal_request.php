
<div class="col-sm-8 col-md-10 col-md-offset-1">
<h3>Total commission earned = Rs <?php echo $commissionTotal['commission']? $commissionTotal['commission'] : '0'; ?> </h3>

<h3>Commission paid out to you = Rs <?php echo ($withdrawalTotal['amountPaid']?$withdrawalTotal['amountPaid']: '0'); ?></h3>

<h3>Commission you are eligible to withdraw  (70%) = Rs <?php echo (($commissionTotal['commission'] * .70) - $withdrawalTotal['amountPaid']); ?></h3>

<?php 
if(count($pendingRequests) <= 0 && (($commissionTotal['commission'] * .70) - $withdrawalTotal['amountPaid']) > 0){ ?>


    <div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="text-center">Submit request</h4>
    </div>
    
    <div class="panel-body" style="background-color:#dcdef9">
<?php echo form_open('Affiliate/withdrawal_process_request'); ?>    
<div class="form-group">
<label for="request_text" class="col-sm-4 control-label"> Description: </label>
<div class="col-sm-7"><textarea name="request_text" rows=6 cols=50  maxLength=100 ></textarea>
    </div>
</div>    
<div class="form-group">
<label for="amount" class="col-sm-4 control-label"> Amount: </label>
<div class="col-sm-7">
<input type="text" readOnly name="amount" value= "<?php echo ($commissionTotal['commission'] * .70) - $withdrawalTotal['amountPaid'];?>"/>
  </div></div>    
  <div class="form-group">
  <div class="col-sm-offset-4 col-sm-8">
      <button type="submit" class="btn btn-default" id="generateTree" />Submit request</button>
      </div>
      
          <?php echo form_close(); ?>
          </div>
    </div>
    </div>
    </div>
    </div>

          <?php
} elseif(($commissionTotal['commission'] * .70) - $withdrawalTotal['amountPaid'] <= 0) { ?>
    <h3>Nothing to withdraw</h3>
<?php }
else{?>
<h3>Your request id no <b><?php echo $pendingRequests['id']; ?></b> is already in queue please wait for admin to reply</h3>
<?php }
?>


