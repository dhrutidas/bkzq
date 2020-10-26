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
        <div class="pull-right">
            <a href="<?php echo base_url("open-add-chapter-modal"); ?>" data-toggle="modal" data-target="#viewModal">
                <span class="glyphicon glyphicon-plus-sign"></span> Add New Chapter
            </a>
        </div>
    
    
</div>
    <div class="panel-collapse customTable">

    <?php echo form_open('', 'class=form-inline'); ?>

    <table class="table table-hover table-striped" id="chap">
    <thead>
    <tr>
        <th class="bg-primary">#</th>
        <th class="bg-primary">Chapter Name</th>
        <th class="bg-primary">Chapter Description</th>
        <th class="bg-primary">Subject Name</th>
        <th class="bg-primary">Status</th>
        <th class="bg-primary">Added on</th>
        <th class="bg-primary">Edit</th>
    </tr>
    </thead>
    <tbody>
    <?php

    if( !empty($chaptersArr) ):  $cnt = 1;

        foreach ($chaptersArr as $values) { ?>

            <tr>
                <td><?php echo $cnt++; ?></td>
                <td><?php echo $values["chapterName"]; ?></td>
                <td><?php echo $values["chapterDesc"]; ?></td>
                <td><?php echo $values["SubjectName"]; ?></td>
                <td><?php echo ($values["status"]=="Y") ? '<span class="badge badge-pill badge-success">Active</span>' : '<span class="badge badge-pill badge-danger">Inactive</span>'; ?></td>
                <td><?php echo date('d-M-Y H:i:s', strtotime($values["updatedAt"])); ?></td>
                <td>
                    <a href="<?php echo base_url("open-edit-chapter-modal/" . $values['chapterID'] ); ?>" data-toggle="modal" data-target="#viewModal">
                        <span class="glyphicon glyphicon-edit"></span>
                    </a>
                </td>
            </tr> <?php
        }

    else: ?>

        <tr><td colspan="7" class="text-center">Records not found</td></tr> <?php

    endif; ?>

    </tbody>
    </table>

    </form>
    </div>

   
    
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
    if('<?php echo $fieldSearched; ?>' === 'subjectID'){
        showSubject();
    }else{
        hideSubject();
    }
 $("#chapterField").change(function(){  
    let field =  $('#chapterField option:selected').val();   
    <?php echo $textSearched = '';?>
    if(field === 'subjectID'){
        showSubject();

    }else{
        hideSubject();
    }
 });

});
function showSubject(){
    $('#chapterSubject').show();
    $('#searchField').hide();
    $('input[name=search]').val('');
}
function hideSubject(){
    $('#chapterSubject').hide();
    $('#searchField').show();
    $('select[name=search]').val('');
}
</script>

<script>
   $(document).ready(function() {
    $('#chap').DataTable();
} ); 
</script>