


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
        <strong><?php echo $page_title; ?></strong>        
    </div>
    <div>
    
    <div class="panel-collapse">

<table class="table table-hover">
<thead>
<tr>
    <th class="bg-primary col-sm-1">#</th> 
    <th class="bg-primary col-sm-3">Affiliate</th>    
    <th class="bg-primary col-sm-3">Student</th>
    <th class="bg-primary col-sm-3">Amount</th>
    <th class="bg-primary col-sm-3">Period</th>
    <th class="bg-primary col-sm-3">Status</th> 
    <?php if($role_id === 1) { ?>   
    <th class="bg-primary col-sm-3">Edit</th> 
    <?php }?>  
</tr>
</thead>
<tbody>
<?php  
if( !empty($students_list) ):  $cnt = 1;
    foreach ($students_list as $values) { 
        $class=$values["status"] === 'pending' ? '#ddf9dd':'' ;
        ?>
        <tr style="background-color:<?php echo $class;?>">
            <td><?php echo $cnt; ?></td>           
            <td><?php echo $values["affiliateName"]; ?></td>
            <td><?php echo $values["studentName"]; ?></td>           
            <td><?php echo $values["amount"]; ?></td>      
            <td><?php echo $values["period"]; ?></td>   
            <td><?php echo $values["status"]; ?></td>     
            <?php if($role_id === 1 && $values["status"] === "pending") { ?>
                <td><a href="<?php echo base_url("open-edit-prizemaster-modal/" . $values['id'] ); ?>" data-toggle="modal" data-target="#viewModal">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a></td>   
    <?php }?>   
        </tr> <?php
   $cnt++; }

else: ?>

    <tr><td colspan="7" class="text-center">Records not found</td></tr> <?php

endif; ?>

</tbody>
</table>


</div>

</div>

<div id="viewModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content"></div>
</div>
</div>
</div>
</div>
