<script type="text/javascript" src="<?php echo base_url("assets/js/highcharts.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/module_data.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/exporting.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/highchart_data_executive.js"); ?>"></script>

<div class="row">

    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading text-left">Welcome, <b><?php echo $this->sData['user_first_name'] ." ".$this->sData['user_last_name'] ; ?></b>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <div class="col-sm-6">
                                  <h3><?php echo $allQuestionCount; ?></h3>
                                  <p>Questions added</p>
                              </div>
                              <div class="col-sm-6">
                                  <h3><?php echo $withImageQuestion; ?></h3>
                                  <p>Questions added with images</p>
                              </div>
                          </div>

                      </div>
                  </div>
              </div>
          </div>

            <div class="panel-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-heading text-left">
                                <b>Questions Added - Day wise</b>
                            </div>
                            <div class="panel-body">
                                <div id="executive_status"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--Tab Content-->

        </div>
    </div>
</div>

<table id="datatable" style="display: none;">
    <thead>
        <tr>
            <th></th>
            <th>Days</th>
        </tr>
    </thead>
    <tbody>
    <?php  
    //print_r($dayWiseQuestionCount);
    for($i = 1; $i<= date('j'); $i++) {
      $userCount = 0;
      foreach ($dayWiseQuestionCount as $value) {
        if( date('Y-m-j', strtotime($value['addedOn'])) == date("Y-m-".$i."") ){
          $userCount = $value['cnt'];
        }
      }
      ?>
        <tr>
            <th><?php echo $i; ?></th>
            <td><?php echo $userCount; ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
