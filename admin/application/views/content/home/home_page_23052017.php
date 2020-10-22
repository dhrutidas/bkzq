<script type="text/javascript" src="<?php echo base_url("assets/js/highcharts.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/module_data.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/exporting.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/highchart_data_admin.js"); ?>"></script>

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
                                <div class="col-sm-4">
                                  <h3>13</h3>
                                  <p>Web Users</p>
                              </div>
                              <div class="col-sm-4">
                                  <h3><?php echo $allStudent; ?></h3>
                                  <p>Paid Users</p>
                              </div>
                              <div class="col-sm-4">
                                  <h3><?php echo $allExecutive; ?></h3> 
                                  <p>Total Executive</p>
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
                                <b>Added Users - Day wise</b>
                            </div>
                            <div class="panel-body">
                                <div id="admin_status"></div>
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
    
    for($i = 1; $i<= date('j'); $i++ ) {
      $userCount = 0;
      foreach ($allUser as $value) {
          if( date('Y-m-j', strtotime($value['createdAt'])) == date("Y-m-".$i."") ){
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