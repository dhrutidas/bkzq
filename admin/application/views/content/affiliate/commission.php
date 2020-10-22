<?php $userDetails = $this->session->userdata('user_details');

if($userDetails['role_id'] == 1){
    ?>
    <div>
    <?php echo form_open('commission-earned'); ?>        
    <select id="affiliateusr" name="affiliateusr" > 
        <option value=''>Company</option>
        <?php foreach($allaffiliates as $user ) { ?>
<option value="<?php echo $user['userID']; ?>" <?php echo ($affiliateUsr == $user['userID'])? 'selected': ''; ?>><?php echo $user['fName']; ?></option>
         <?php   }?>
    </select>

    <button type="submit" id="generateTree">Show commission</button>
        <?php echo form_close(); ?>
        </div>
    <?php
}
?>
<div class="row">
<div class="col-md-12">
    
    <div class="panel panel-default">
    <div class="panel-heading text-left noborder">
        <strong>Total commission earned : <span style="color:green">Rs <?php echo $commissionTotal['commission'] ? $commissionTotal['commission']: '0'; ?></span></strong>      
    </div>
    <div class="panel-heading text-left noborder">        
        <strong>Total amount paid : <span style="color:green">Rs <?php echo $amountPaid ? $amountPaid: '0'; ?></span></strong>
    </div>
    <div class="panel-heading text-left noborder">       
        <strong>Balance amount: <span style="color:green">Rs <?php echo $commissionTotal['commission'] - $amountPaid; ?></span></strong>
    </div>
    <div class="panel-collapse">
  
    <?php echo form_open('', 'class=form-inline'); ?>

    <table class="table table-hover">
    <thead>
    <tr>
        <th class="bg-primary col-sm-1">#</th>        
        <th class="bg-primary col-sm-3">Amount</th>
        <th class="bg-primary col-sm-2">Affiliate user</th>        
        <th class="bg-primary col-sm-2">Date</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($commissionArr) ):  $cnt = 1;

        foreach ($commissionArr as $values) { ?>

            <tr>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $values["amount"]; ?></td>
                <td><?php echo $values["fname"]; ?></td>                
                <td><?php echo date('d-M-Y', strtotime($values["createdDate"])); ?></td>                
            </tr> <?php
        }

    else: ?>

        <tr><td colspan="6" class="text-center">Records not found</td></tr> <?php

    endif; ?>

    </tbody>
    </table>

    </form>
    </div>
        <div class="col-md-12 text-right">
        <?php echo $pagination; ?>
    </div>
    </div>
    
    <div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
    </div>
    
</div>
</div>
