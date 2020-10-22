<div class="row">
<div class="col-md-12">

	<?php if( $this->session->flashdata('message')): ?>

	<div class="alert alert-success fade in">
	    <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
	    <?php echo $this->session->flashdata('message'); ?></strong>
	</div>
	<?php endif; ?>
	<?php if( $this->session->flashdata('warning')): ?>
			<div class="alert alert-danger fade in">
			    <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
			    <?php echo $this->session->flashdata('warning'); ?></strong>
			</div>
	<?php endif; ?>

    <div class="panel panel-default">
    <div class="panel-heading text-left">
        <strong>Manage Package Activate</strong>
    </div>

    <div class="panel-collapse">

    <?php //echo form_open_multipart('confirm-upgrade-package','class="form-horizontal" id="confirmPackage"'); ?>
    <?php echo form_open('', 'class=form-inline'); ?>
    <table class="table table-hover" id="pack">
    <thead>
    <tr>
        <th class="bg-primary col-sm-1">#</th>
        <th class="bg-primary col-sm-3 text-center">Name</th>
        <th class="bg-primary col-sm-2 text-center">Package</th>
        <th class="bg-primary col-sm-1 text-center">Amount</th>
        <th class="bg-primary col-sm-2 text-center">Transaction</th>
        <th class="bg-primary col-sm-2 text-center">Payment Status</th>
        <th class="bg-primary col-sm-1 text-center">Activate</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($packageArr) ):  $cnt = 1;

        foreach ($packageArr as $values) { 

            $packageType = "";
            if( $values["packageType"] == "T" ){
                $packageType = "Trial";
            }elseif( $values["packageType"] == "B" ){
                $packageType = "Bronze";
            }elseif( $values["packageType"] == "S" ){
                $packageType = "Silver";
            }elseif( $values["packageType"] == "G" ){
                $packageType = "Gold";
            }else{
                $packageType = "Trial";
            }
            ?>

            <tr>
                <td><?php echo $cnt++; ?></td>
                <td class="text-center"><?php echo $values["fName"]." ".$values["lName"]; ?></td>
                <td class="text-center"><?php  echo $packageType; ?></td>
                <td class="text-center"><?php  echo empty($values['amount']) ? 0 : $values['amount']; ?></td>
                <td class="text-center"><?php  echo empty($values['txnid']) ? '-' : $values['txnid']; ?></td>
                <td class="text-center"><?php  echo empty($values['paymentStatus']) ? '-' : $values['paymentStatus']; ?></td>
                <td class="text-center">
                    <a href="<?php echo base_url("confirm-upgrade-package/" . $values['user_code'] ); ?>">activate
                    </a>
                </td>
            </tr> <?php
        }

    else: ?>

        <tr><td colspan="9" class="text-center">Records not found</td></tr> <?php

    endif; ?>

    </tbody>
    </table>

    </form>
    </div>
    
    </div>

    <div id="viewModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
    </div>

</div>
</div>

<script>
    $(document).ready(function() {
    $('#pack').DataTable();
} );
</script>