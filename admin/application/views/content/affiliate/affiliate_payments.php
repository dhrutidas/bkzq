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
        <strong>Affiliate payment requests</strong>        
    </div>

    <div class="panel-collapse">

    <?php echo form_open('', 'class=form-inline'); ?>

    <table class="table table-hover">
    <thead>
    <tr>
        <th class="bg-primary col-sm-1">#</th>
        <th class="bg-primary col-sm-1">Request id</th>
        <th class="bg-primary col-sm-1">Affiliate id</th>
        <th class="bg-primary col-sm-2">Affiliate user name</th>
        <th class="bg-primary col-sm-1">Amount requested</th>
        <th class="bg-primary col-sm-2">Requested date</th>
        <th class="bg-primary col-sm-1">Amount paid</th>
        <th class="bg-primary col-sm-2">Payment date</th>
        <th class="bg-primary col-sm-1">Payment mode</th>
        <th class="bg-primary col-sm-1">Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($boardsArr) ):  $cnt = 1;

        foreach ($boardsArr as $values) { ?>

            <tr>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $values["id"]; ?></td>
                <td><?php echo $values["affiliateID"]; ?></td>
                <td><?php echo $values["fName"]; ?></td>
                <td><?php echo $values["amountRequested"]; ?></td>
                <td><?php echo date('d-M-Y', strtotime($values["requestedDate"])); ?></td>
                <td><?php echo $values["amountPaid"]; ?></td>
                <td><?php echo $values["paymentDate"] != '0000-00-00 00:00:00' ? date('d-M-Y', strtotime($values["paymentDate"])) : ''; ?></td>
                <td><?php echo $values["paymentMode"]; ?></td>
                <td>
                    <a  href="<?php echo base_url("open-edit-affiliate-withdrawl-modal/" . $values['id'] ); ?>" data-toggle="modal" data-target="#viewModal">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
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
