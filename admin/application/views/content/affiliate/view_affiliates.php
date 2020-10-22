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
<div class="panel panel-default">
<form class="form-inline" action="<?php echo base_url() . 'manage-affiliates'; ?>" method="post">
        <select class="form-control" name="field" id="studentField" required>
            <option selected="selected" disabled="disabled" value="">Filter By</option>
            <?php foreach($studentsFilter as $field => $name){ ?>
                <option value="<?php echo $field;?>" <?php if($fieldSearched === $field) {echo "SELECTED"; }?> > <?php echo $name;?> </option>
           <?php }?>
            
        </select>
        <input class="form-control" type="text" name="search" id="searchField" value="<?php echo $textSearched; ?>" placeholder="Search...">

<select class="form-control" id="inputPackage" name="search" >
<option selected="selected" disabled="disabled" value="">Filter By</option>
            <?php foreach($packageFilter as $field => $name){ ?>
                <option value="<?php echo $field;?>" <?php if($textSearched === $field) {echo "SELECTED"; }?> > <?php echo $name;?> </option>
           <?php }?>
                </select> 

        <input class="btn btn-default" type="submit" name="filter" value="Go">
        <div class="panel-heading pull-right">
       <a  href="<?php echo base_url() . 'affiliates-reset-filter'; ?>"> Reset filter</a>
       </div>
    </form>
    </div>
</div>
    <div class="panel-collapse">

    <?php echo form_open('', 'class=form-inline'); ?>

    <table class="table table-hover">
    <thead>
    <tr>
        <th class="bg-primary col-sm-1">#</th>
        <th class="bg-primary col-sm-2">Name</th>
        <th class="bg-primary col-sm-2">Email</th>
        <th class="bg-primary col-sm-1">Contact</th>
        <th class="bg-primary col-sm-1">Package</th>
        <th class="bg-primary col-sm-1">Created at</th>        
        <th class="bg-primary col-sm-1">Status</th>
        <th class="bg-primary col-sm-1">Edit</th>
        <th class="bg-primary col-sm-1">Details</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($employeesArr) ):  $cnt = 1;
        foreach ($employeesArr as $values) {
					//print_r($values);exit;
            $packageType = "";
            if( $values["userPackageType"] == "T" ){
                $packageType = "Trial";
								$register_date=date('d-m-Y',strtotime($values['createdAt']));//'20-01-2015';
								$expire_date=date("d-m-Y",strtotime(date("d-m-Y", strtotime($values['createdAt'])) . " +3 day"));
            }elseif( $values["userPackageType"] == "B" ){
                $packageType = "Bronze";
								$register_date=date('d-m-Y',strtotime($values['activatedOn']));//'20-01-2015';
								$expire_date=date("d-m-Y",strtotime(date("d-m-Y", strtotime($values['activatedOn'])) . " +1 year"));

            }elseif( $values["userPackageType"] == "S" ){
                $packageType = "Silver";
								$register_date=date('d-m-Y',strtotime($values['activatedOn']));//'20-01-2015';
								$expire_date=date("d-m-Y",strtotime(date("d-m-Y", strtotime($values['activatedOn'])) . " +1 year"));
            }elseif( $values["userPackageType"] == "G" ){
                $packageType = "Gold";
								$register_date=date('d-m-Y',strtotime($values['activatedOn']));//'20-01-2015';
								$expire_date=date("d-m-Y",strtotime(date("d-m-Y", strtotime($values['activatedOn'])) . " +1 year"));
            }else{
                $packageType = "Trial";
								$register_date=date('d-m-Y',strtotime($values['createdAt']));//'20-01-2015';
								$expire_date=date("d-m-Y",strtotime(date("d-m-Y", strtotime($values['createdAt'])) . " +3 day"));
            }

            $table_style = "";
            if(!empty($values["confirmation_value"]) && ($values["status"] == 'N')){
                $table_style = "class='danger'";
            }
            ?>

            <tr <?php echo $table_style; ?>>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $values["fName"]." ".$values["lName"]; ?></td>
                <td><?php echo $values["emailID"]; ?></td>
                <td><?php echo $values["contactNumber"]; ?></td>
                <td><?php  echo $packageType; ?></td>
                <td><?php  echo ($values["status"]=='Y') ? date_format(date_create($values['createdAt']), 'd-m-Y'): '-'; ?></td>                
                <td><?php echo ($values["status"]=='Y') ? 'Active' : 'Inactive'; ?></td>
                <td>
                    <a href="<?php echo base_url("open-edit-affiliate-modal/" . $values['userID'] ); ?>" data-toggle="modal" data-target="#viewModal">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
                <td>
                    <a href="<?php echo base_url("open-view-affiliate-modal/" . $values['userID'] ); ?>" data-toggle="modal" data-target="#viewModal">
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
<script>
$(document).ready(function () {
    if('<?php echo $fieldSearched; ?>' === 'userPackageType'){
        showPackage();
    }else{
        hidePackage();
    }
 $("#studentField").change(function(){  
    let field =  $('#studentField option:selected').val();   
    <?php echo $textSearched = '';?>
    if(field === 'userPackageType'){
        showPackage();

    }else{
        hidePackage();
    }
 });

});
function showPackage(){
    $('#inputPackage').show();
    $('#searchField').hide();
    $('input[name=search]').val('');
}
function hidePackage(){
    $('#inputPackage').hide();
    $('#searchField').show();
    $('select[name=search]').val('');
}
</script>