<script type="text/javascript" src="<?php echo base_url("assets/js/question.js"); ?>"></script>
<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="<?php echo base_url("assets/dist/js/bootstrap-multiselect.js"); ?>" ></script>
<link rel="stylesheet" href="<?php echo base_url("assets/dist/css/bootstrap-multiselect.css"); ?>" type="text/css"/>
<script>
$(document).on('click', '.pop', function (event) {
    event.preventDefault();
    $('.imagepreview').empty();
    $('.imagepreview').attr('src', $(this).find('img').attr('src'));
    $('#imagemodal').modal('show');
});
</script>
<style>
#imagemodal {
   left: 50%;
   top: 50%;
   margin-left: -150px;
   margin-top: -150px;
}
</style>
<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="text-left bg-primary list-group-item active col-md-6"><strong>Question</strong></div>
      <div class="text-right bg-primary list-group-item active col-md-6"><strong onclick="window.close();" style="cursor:pointer">Close [X]</strong></div>
      <div class="panel-body">
        <?php
        $sData = $this->session->userdata('user_details');
        $role_id = $sData['role_id'];
        if(($role_id==5 || $role_id==1) AND $question[0]['status']=='QA'){
        ?>
          <input type="hidden" id="qidhidden" value="<?php echo $question[0]['qbID']; ?>">
          <div class="text-right" style='padding-top:5%;padding-right:5%'>
              <button class="btn btn-success btn-md" style="cursor:pointer" onclick="makeItLive('Y');">Approve</button>
              <button class="btn btn-danger btn-md" style="cursor:pointer" data-toggle="modal" data-target="#auth">Reject </button>
          </div>
        <?php
      }
      if(($role_id==2 || $role_id==1) AND $question[0]['status']=='Draft'){
      ?>
        <input type="hidden" id="qidhidden" value="<?php echo $question[0]['qbID']; ?>">
        <div class="text-right" style='padding-top:5%;padding-right:5%'>
            <button class="btn btn-success btn-md" style="cursor:pointer" onclick="makeItLive('QA');">Push to QA</button>
        </div>
        <?php
      } ?>
      <div class='row' style='padding-top:5%'>
        <div class='col-md-offset-1 col-md-10'>
      <?php
        $imgQuestion=(!empty($question[0]['questionImg']))?"<a href='#' class='pop'><img src='".$question[0]['questionImg']."' height=100 width=100/></a>":"";
          echo "<strong>Q.".$question[0]['qbID'].". </strong> ".$question[0]['questionText'].$imgQuestion."<br/><br/>";
        ?>
        <?php
            $optionDetails = explode('#!~!#',$question[0]['optionDetails']);
            //print_r($question[0]['optionDetails']);exit;
            $counterChar = 'A';
            $optionForm = '';
            foreach($optionDetails as $row){
                $option=explode('~!~',$row);
                $bold=($option[3]=="Y")?'<b>':'';
                $closebold=($option[3]=="Y")?'</b>':'';
                $imgOption=(!empty($option[2]))?" <a href='#' class='pop'><img src='".$option[2]."' height=100 width=100/> </a>":"";
                if(sizeof($option)>1)
                    $optionForm .=$bold.'<div class="col-md-offset-1 .col-md-6">'.$counterChar++.'. '.$option[1].$imgOption.'</div>'.$closebold;
            }
            echo $optionForm."<br/><br/>";
         ?>
        <table class="table table-striped">
            <thead>
              <tr>
                <th class='col-md-1'>Level</th>
                <th class='col-md-1'>Stage</th>
                <th class='col-md-2'>Board</th>
                <th class='col-md-2'>Standard</th>
                <th class='col-md-3'>Subject</th>
                <th class='col-md-3'>Chapter</th>
              </tr>
            </thead>
            <tbody>
               <?php foreach ($tags as $key => $value) {
                   echo '<tr>';
                   echo '<td>'.$value['levelName'].'</td>';
                   echo '<td>'.$value['stageName'].'</td>';
                   echo '<td>'.$value['boardName'].'</td>';
                   echo '<td>'.$value['stdName'].'</td>';
                   echo '<td>'.$value['subjectName'].'</td>';
                   echo '<td>'.$value['chapterName'].'</td>';
                   echo '</tr>';
                 } ?>
           </tbody>
         </table>
       </div>
        </div>
      </div>

      <div id="auth" class="modal fade" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Rejection Reason</h4>
            </div>
            <div class="modal-body">
              <p><center><textarea name='rejectionReason' id='rejectionReason' rows=3 cols="70" required></textarea></center></p>
            </div>
            <div class="modal-footer">
              <button type="submit" onclick="makeItLive('N');" class="btn btn-success btn-md" data-dismiss="auth">Save</button>
            </div>
          </div>

        </div>
      </div>

    <div id="imagemodal" class="modal fade">
      <img class='imagepreview' hitght="300" width="300"></img>
    </div>

    </div>
  </div>
</div>
