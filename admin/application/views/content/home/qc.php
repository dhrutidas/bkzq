
<script type="text/javascript" src="<?php echo base_url("assets/js/qa.js"); ?>"></script>
<div class="row">
    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading text-left">Welcome, <b><?php echo $this->sData['user_first_name'] ." ".$this->sData['user_last_name'] ; ?></b>
            </div>

            <div class="panel-body">
              <div id='countBox' class='text-center'></div>
                <table class="form-group table table-hover">
                  <thead>
                    <tr>
                      <th class="bg-primary col-sm-1">#</th>
                      <th class="bg-primary col-sm-5">Question</th>
                      <th class="bg-primary col-sm-2">Added on</th>
                      <th class="bg-primary col-sm-1">Preview</th>
                    </tr>
                  </thead>
                <tbody id='loadQuestions'>
                  <td class='col-md-3' colspan="6"><center>No Record Found</center></td>
                </tbody>
                </table>
            </div>
            <!--Tab Content-->
        </div>
    </div>
</div>
