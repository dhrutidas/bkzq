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
        <strong>Manage Users</strong>
        <div class="pull-right">
            <a href="<?php echo base_url("open-add-user-modal"); ?>" data-toggle="modal" data-target="#viewModal">
                <span class="glyphicon glyphicon-plus-sign"></span> Add New User
            </a>
        </div>
    </div>
    <div class="panel panel-default">
<form class="form-inline" action="<?php echo base_url() . 'manage-users'; ?>" method="post">
        <select class="form-control" name="field" required>
            <option selected="selected" disabled="disabled" value="">Filter By</option>
            <?php foreach($usersFilter as $field => $name){ ?>
                <option value="<?php echo $field;?>" <?php if($fieldSearched === $field) {echo "SELECTED"; }?> > <?php echo $name;?> </option>
           <?php }?>
            
        </select>
        <input class="form-control" type="text" name="search" required value="<?php echo $textSearched; ?>" placeholder="Search...">
        <input class="btn btn-default" type="submit" name="filter" value="Go">
        <div class="panel-heading pull-right">
       <a  href="<?php echo base_url() . 'users-reset-filter'; ?>"> Reset filter</a>
       </div>
    </form>
    </div>

    <div class="panel-collapse">

    <?php echo form_open('', 'class=form-inline'); ?>

    <table class="table table-hover">
    <thead>
    <tr>
        <th class="bg-primary col-sm-1">#</th>
        <th class="bg-primary col-sm-3">Name</th>
        <th class="bg-primary col-sm-2">Email</th>
        <th class="bg-primary col-sm-1">Contact</th>
        <th class="bg-primary col-sm-2">Role</th>
        <th class="bg-primary col-sm-1">Status</th>
        <th class="bg-primary col-sm-1">Edit</th>
        <th class="bg-primary col-sm-1">Details</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($employeesArr) ):  $cnt = 1;

        foreach ($employeesArr as $values) { ?>

            <tr>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $values["fName"]." ".$values["lName"]; ?></td>
                <td><?php echo $values["emailID"]; ?></td>
                <td><?php echo $values["contactNumber"]; ?></td>
                <td><?php echo $values["roleName"]; ?></td>
                <td><?php echo ($values["status"]=='Y') ? 'Active' : 'Inactive'; ?></td>
                <td>
                    <a href="<?php echo base_url("open-edit-user-modal/" . $values['userID'] ); ?>" data-toggle="modal" data-target="#viewModal">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("open-view-user-modal/" . $values['userID'] ); ?>" data-toggle="modal" data-target="#viewModal">
                        <span class="glyphicon glyphicon-list"></span>
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
