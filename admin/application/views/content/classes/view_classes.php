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
        <strong>Manage Classes</strong>
        <div class="pull-right">
            <a href="<?php echo base_url("open-add-class-modal"); ?>" data-toggle="modal" data-target="#viewModal">
                <span class="glyphicon glyphicon-plus-sign"></span> Add New Class
            </a>
        </div>
    </div>

    <div class="panel-collapse customTable">

    <?php echo form_open('', 'class=form-inline'); ?>

    <table class="table table-hover table-striped" id="classes">
    <thead>
    <tr>
        <th class="bg-primary">#</th>
        <th class="bg-primary">Class Name</th>
        <th class="bg-primary">Class Description</th>
        <th class="bg-primary">Status</th>
        <th class="bg-primary">Added on</th>
        <th class="bg-primary">Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($classesArr) ):  $cnt = 1;

        foreach ($classesArr as $values) { ?>

            <tr>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $values["stdName"]; ?></td>
                <td><?php echo $values["stdDesc"]; ?></td>
                <td><?php echo ($values["status"]=='Y') ? '<span class="badge badge-pill badge-success">Active</span>' : '<span class="badge badge-pill badge-danger">Inactive</span>'; ?></td>
                <td><?php echo date('d-M-Y', strtotime($values["updatedAt"])); ?></td>
                <td>
                    <a href="<?php echo base_url("open-edit-class-modal/" . $values['stdID'] ); ?>" data-toggle="modal" data-target="#viewModal">
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
    $('#classes').DataTable();
} );
</script>