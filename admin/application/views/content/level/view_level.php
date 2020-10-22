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
        <strong>Manage Levels</strong>
        <div class="pull-right">
            <a href="<?php echo base_url("open-add-level-modal"); ?>" data-toggle="modal" data-target="#viewModal">
                <span class="glyphicon glyphicon-plus-sign"></span> Add New Level
            </a>
        </div>
    </div>

    <div class="panel-collapse">

    <?php echo form_open('', 'class=form-inline'); ?>

    <table class="table table-hover" id="levels">
    <thead>
    <tr>
        <th class="bg-primary col-sm-1">#</th>
        <th class="bg-primary col-sm-3">Level Name</th>
        <th class="bg-primary col-sm-3">Level Description</th>
        <th class="bg-primary col-sm-2">Status</th>
        <th class="bg-primary col-sm-2">Added on</th>
        <th class="bg-primary col-sm-1">Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($levelArr) ):  $cnt = 1;

        foreach ($levelArr as $values) { ?>

            <tr>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $values["levelName"]; ?></td>
                <td><?php echo $values["levelDesc"]; ?></td>
                <td><?php echo ($values["status"]=='Y') ? 'Active' : 'Inactive'; ?></td>
                <td><?php echo date('d-M-Y H:i:s', strtotime($values["updatedAt"])); ?></td>
                <td>
                    <a href="<?php echo base_url("open-edit-level-modal/" . $values['levelID'] ); ?>" data-toggle="modal" data-target="#viewModal">
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
    $('#levels').DataTable();
} );
</script>