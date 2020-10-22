<script>

$('form').submit(function(e) {
        e.preventDefault();

        var value1="";
        var id=document.getElementById('app_id').value;
        var trows=document.getElementById('total').value;
        var roleids=document.getElementById('roleids').value;
        var count_check=0;
        for(var j=1;j<=trows;j++)
        {
            var s = document.getElementsByName("check_list"+j);
            var s1 = s.length;

            var s2 = s1-1;

            for (var i = 0; i < s2; i++) {

              var shirtColor = s[i];
              if (shirtColor.checked) {

                var s4 = shirtColor.value;
                //alert(s4);
                value1 = value1+","+s4;
                count_check++;
            }
        }
    }


        $.ajax({
            type: "POST",
            url:"<?php echo base_url('submit-edit-privilege');?>",
            data: {id1:id,roles:value1,rows:trows,allroleids:roleids},
           error: function() {
              alert('Something is wrong');
           },
           success: function(data) {
               alert('Application privileges has been updated successfully');
               window.location.href='manage-applications';
           }
        });

    });
</script>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary">Edit Application Privileges</h4>
</div>
<div class="modal-body bg-primary">

    <?php echo form_open('submit-edit-privilege','class="form-horizontal" id="editPrivilegeform"'); ?>

        <div class="form-group">
            <label for="inputRolename" class="col-sm-6 control-label">Application Name</label>
            <div class="col-sm-6"><?php echo $applicationDetails['app_name']; ?></div>
        </div>
       
        <table class="table table-hover">
            <thead>
                <tr>
                    <th width="7.5%" class="bg-primary">#</th>
                    <th width="25%" class="bg-primary">Role Name</th>
                    <th width="25%" class="bg-primary">Active</th>
                    <th width="7.5%" class="bg-primary">InActive</th>
                </tr>
            </thead>

            <?php
            $ex1 = '';$str_tp = '';
            foreach ($privilegeDetails as $pri) {
                $ex1 .= $pri['role_id'].",";
            }
            $ex = explode(",",$ex1);
            
            if( !empty($getAllRoles) ):  $cnt = 0;
            $str_tp='';
            foreach ($getAllRoles as $values) { 
                    $cnt++;
                    $str_tp .= ltrim($values["roleID"],'0').'!~!';
                ?>
            <tr>
                <td><?php echo $cnt; ?></td>
                <td><?php echo $values["roleName"]; ?></td>
            <?php 

            if(in_array($values['roleID'], $ex)) :

            ?>
                <td>
                    <input type="radio" name="check_list<?php echo$cnt;?>" id="check_list<?php echo $cnt; ?>" checked  value="<?php echo ltrim($values['roleID'],'0');?>">
                </td>
                <td>
                    <input type="radio" name="check_list<?php echo$cnt;?>" id="check_list<?php echo $cnt; ?>" value="<?php echo ltrim($values['roleID'],'0');?>">
                </td>
            <?php else : ?>
                <td>
                    <input type="radio" name="check_list<?php echo $cnt; ?>" id="check_list<?php echo $cnt; ?>" value="<?php echo ltrim($values['roleID'],'0');?>">
                </td>
                <td>
                    <input type="radio" name="check_list<?php echo $cnt; ?>" id="check_list<?php echo $cnt; ?>" checked value="<?php echo ltrim($values['roleID'],'0');?>">
                </td>
            <?php endif; ?>
            </tr>
            <?php
        }

        else: ?>
        <tr><td colspan="4" class="text-center">Records not found</td></tr> 
    <?php endif; ?>

        </table>
        
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <button type="botton" id="button" class="btn btn-default">Submit</button>&nbsp;
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <input type="hidden" name="total" id="total" value="<?php echo $cnt; ?>" />
                <input type="hidden" name="app_id" id="app_id" value="<?php echo $applicationDetails["app_id"]; ?>" />
                <input type="hidden" name="roleids" id="roleids" value="<?php echo $str_tp; ?>" />
            </div>
        </div>
    </form>
</div>