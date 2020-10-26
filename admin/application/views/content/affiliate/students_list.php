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
        <strong>Manage Students</strong>
    </div>
    
    <div class="panel-collapse customTable">

    <?php echo form_open('', 'class=form-inline'); ?>

    <table class="table table-hover table-striped" id="aff">
    <thead>
    <tr>
        <th class="bg-primary">#</th>
        <th class="bg-primary">Name</th>
        <th class="bg-primary">Email</th>
        <th class="bg-primary">Contact</th>
        <th class="bg-primary">Status</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($student_list) ):  $cnt = 1;

        foreach ($student_list as $values) { ?>

            <tr>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $values["fName"]." ".$values["lName"]; ?></td>
                <td><?php echo $values["emailID"]; ?></td>
                <td><?php echo $values["contactNumber"]; ?></td>
                <td><?php echo ($values["status"]=='Y') ? 'Active' : 'Inactive'; ?></td>
               
            </tr> <?php
        }

    else: ?>

        <tr><td colspan="9" class="text-center">Records not found</td></tr> <?php

    endif; ?>

    </tbody>
    </table>

    </form>
    </div>
    <!-- <div class="col-md-12 text-right">
        <?php //echo $pagination; ?>
    </div> -->
    </div>

</div>
</div>

<script>
    $(document).ready(function() {
    $('#aff').DataTable();
} );
</script>
