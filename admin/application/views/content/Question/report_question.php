<script type="text/javascript" src="<?php echo base_url("assets/js/question_report.js"); ?>"></script>
<!-- Include the plugin's CSS and JS: -->
<script type="text/javascript" src="<?php echo base_url("assets/dist/js/bootstrap-multiselect.js"); ?>" ></script>
<link rel="stylesheet" href="<?php echo base_url("assets/dist/css/bootstrap-multiselect.css"); ?>" type="text/css"/>
<div class="row">
<div class="col-md-12">
    <div class="panel panel-default">
    <div class="text-left bg-primary list-group-item active">
        <strong>Search Question</strong>
    </div>

    <div class="panel-collapse">
      <div class='well'>
      <div id='question_tag' class='form-group col-md-offset-3'></div>
      <div id='userList' class='form-group col-md-offset-4'>
      <label>  Added By :</label> <select name='user' id='user'></select>
      <label>  Status :</label> <select name='inputStatus' id='inputStatus'><option value='Y'> Live </option><option value='N'> Rejected </option><option value='QA'> IN QA </option><option value='Executive'> Returned from QA </option></select>
      </div>
      <button class='btn btn-primary btn-md col-md-offset-5' onclick="findQuestions()">Search</button>
    </div>
    <div id='countBox' class='text-center'></div>
    <table class="form-group table table-hover">
      <thead>
        <tr>
          <th class="bg-primary col-sm-1">#</th>
          <th class="bg-primary col-sm-2">Question No</th>
          <th class="bg-primary col-sm-5">Question</th>
          <th class="bg-primary col-sm-1">Image</th>
          <th class="bg-primary col-sm-2">Added on</th>
          <th class="bg-primary col-sm-1">Preview</th>
        </tr>
      </thead>
    <tbody id='question-list'>
      <tr><td class='col-md-3' colspan="6"><center>No Record Found</center></td></tr>
    </tbody>
    </table>
    </div>
    <div class="col-md-12 text-right">
        <?php //echo $pagination; ?>
    </div>

</div>

</div>
</div>
