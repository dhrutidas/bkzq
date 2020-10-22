
 <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css" rel="stylesheet"/> 


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
<form class="form-inline" action="<?php echo base_url() . 'toppers'; ?>" method="post">
        <?php 
        $monthPicker = $monthPicker ? $monthPicker : date('m', strtotime('-1 month', time())).'/'.date('Y', time());        
        ?>
        <input type="text" class="form-control"  id="monthPicker" name="monthPicker" required="true"  autocomplete="off" value="<?php echo $monthPicker; ?>"/>
        
        <input class="btn btn-default" type="submit" name="filter" value="Go">
        
    </form>
    </div>
    <div class="panel-collapse">

<?php  echo form_open('prizeDeclare', 'class=form-inline'); ?>
<?php  if($prize_money > MIN_AMOUNT && $monthPicker == date('m', strtotime('-1 month', time())).'/'.date('Y', time()) ) { ?>
<button type="submit" class="btn btn-primary" style="margin:10px" id="givePrize" >Give Prize</button>
<?php }?> 
<table class="table table-hover">
<thead>
<tr>
    <th class="bg-primary col-sm-1">#</th>
    <?php  if($prize_money > MIN_AMOUNT && $monthPicker == date('m', strtotime('-1 month', time())).'/'.date('Y', time()) && count($prizeList) < 1) { ?>
        <th class="bg-primary col-sm-3">Select</th>
    <?php }?>
    
    <th class="bg-primary col-sm-3">Name</th>
    <th class="bg-primary col-sm-3">Marks</th>
    
</tr>
</thead>
<tbody>
<?php  
if( !empty($students_list) ):  $cnt = 1; 
    foreach ($students_list as $values) {  ?>
        <tr>
            <td><?php echo $cnt; ?></td>
            <?php  if($prize_money > MIN_AMOUNT && $monthPicker == date('m', strtotime('-1 month', time())).'/'.date('Y', time()) && count($prizeList) < 1) { ?>
            <td>
                <input type="checkbox" studid="<?php echo $cnt; ?>" id="selectID<?php echo $values['userID']; ?>" value= "<?php echo $values['userID']; ?>" class="selectStudent" name="students[]" />
            </td> 
            <?php }?>
            <td><?php echo $values["user_name"]; ?></td>
            <td><?php echo $values["Marks"]; ?></td>           
             
           
        </tr> <?php
   $cnt++; }

else: ?>

    <tr><td colspan="7" class="text-center">Records not found</td></tr> <?php

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
$(document).ready(function () {
    let selectedStudent = 0;
    $('#monthPicker').datepicker({
    autoclose: true,
    minViewMode: 1,
    format: 'mm/yyyy',
    endDate: new Date()
 });

 $("[id^='selectID']").click(function(){ 
    const total = $("input:checkbox:checked");
    if(total.length > 3){
        alert('More than 3 not allowed');
             return false;
    }
     if(this.checked){
     const id = this.getAttribute('studid');
         if($('input:checkbox[studid='+(parseInt(id)+1)+']').length > 0 && $('input:checkbox[studid='+(parseInt(id)+2)+']').length){
            $('input:checkbox[studid='+(parseInt(id)+1)+']')[0].checked = true;
            $('input:checkbox[studid='+(parseInt(id)+2)+']')[0].checked = true;
            
            const notselected = $("input[type='checkbox']:not(:checked)");
            for(let i=0; i < notselected.length; i++){
                notselected[i].disabled =true;
            }
         }else{
             alert('Consequtive 3 students are required');
             return false;
         }
     }else{
        const notselected = $("input[type='checkbox']:not(:checked)");
            for(let i=0; i < notselected.length; i++){
                notselected[i].disabled =false;
            }
        const selected = $("input:checkbox:checked");
            for(let i=0; i < selected.length; i++){
                selected[i].checked =false;
            }
     }    
 });

 $('#givePrize').click(function(){
    const selected = $("input:checkbox:checked");
    if(selected.length <= 0){
        alert('Please select students');
        return false;
    }
 });

});
</script>