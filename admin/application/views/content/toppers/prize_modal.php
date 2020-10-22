

<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
    <div class="panel-heading text-left">
        <strong><?php echo $page_title; ?></strong>        
    </div>
    <div>
    <?php echo form_open('submit-prize-declaration','class="form-horizontal" id="editStreamform"'); ?>
    <table class="table table-hover">
<thead>
<th class="bg-primary col-sm-1">Rank</th>
<th class="bg-primary col-sm-1">Student</th>
<th class="bg-primary col-sm-1">Prize amount</th>
</thead>
    <?php  $i=1; foreach ($studentID as $values) { ?>
        <tr>
            <td><?php echo $i;?></td>
            <td><?php echo $studentDetails[$values]['fName'].' '.$studentDetails[$values]['lName'];?></td>
            <td><input type='number'  max="<?php echo $affiliate_prize_money; ?>" min="1" name="prize_money[<?php echo $values;?>]" id="studRank<?php echo $i; ?>"/></td>
        </tr>   
    <?php $i=$i +1; } ?>    
    </table>
    <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="submit" class="btn btn-primary">Submit</button>&nbsp;
                <input type="hidden" name="maxAmount" id="maxAmount" value="30"/>
                <button type="button" class="btn btn-default" data-dismiss="modal"  onclick="javascript:window.location = document.referrer;">Cancel</button>
                
            </div>
        </div>
    </form>
</div>
</div>

<script>
$(document).ready(function () {
    const maxAmount = Number($('#maxAmount').val());
   const maxAmount2 = <?php echo $affiliate_prize_money; ?>

    $("[id^='studRank']").change(function(){ 
        let studRank1 = Number($('#studRank1').val());let studRank2 = Number($('#studRank2').val());let studRank3 = Number($('#studRank3').val());
       if(Number(this.value) > maxAmount || Number(this.value) > maxAmount2){
           this.value = 0;
           alert('Amount exceeds max amount');
           return false;
       }
       switch(this.id){
           case 'studRank1':
        if(studRank1 < studRank2 ||  studRank1 < studRank3){
            this.value = 0;
           alert('Amount exceeds max amount');
           return false;
        }
        break;
        case 'studRank2':
        if(studRank2 < studRank3 ||  studRank2 > studRank1){
            this.value = 0;
           alert('Amount exceeds max amount');
           return false;
        }
        break;
        case 'studRank3':
        if(studRank3 > studRank2 ||  studRank3 > studRank1){
            this.value = 0;
           alert('Amount exceeds max amount');
           return false;
        }
        break;
       }
    });
});
</script>