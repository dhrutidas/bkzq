<script type="text/javascript" src="<?php echo base_url("assets/js/highcharts.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/module_data.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/exporting.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/highchart_data_admin.js"); ?>"></script>

<link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('assets/jquery-ui/MonthPicker.min.css'); ?>" rel="stylesheet" type="text/css" />
<script src="https://cdn.rawgit.com/digitalBush/jquery.maskedinput/1.4.1/dist/jquery.maskedinput.min.js"></script>
<script src="<?php echo base_url('assets/jquery-ui/MonthPicker.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/jquery-ui/examples.js'); ?>"></script>
<script>
function loadDatabyMonth(){
  valuedateMonth=document.getElementById('NoIconDemo').value;
  $.post("home-graph-data-ajax",
        { datemonth: valuedateMonth },
        function(data){
            document.getElementById('tableBodyID').innerHTML = data;
            loadHighChart();
        });
}
</script>
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
                                  <h3><?php echo $allStudentLoggedIn; ?></h3>
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
                          <div class="panel-heading">
                              <div class="text-left">
                                  <b>Added Users - Day wise</b>
                              </div>
                              <div class="text-right">
                                  <?php $date=date('m/Y'); ?>
                                  <input type='text' id="NoIconDemo" class='Default' value='<?php echo $date; ?>'>
                                  <input type='button' onclick='loadDatabyMonth()' value='Load Graph' class='btn btn-success'>
                              </div>
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
    <tbody id='tableBodyID'>
    <?php
      for($i = 1; $i<= date('t'); $i++ ) {
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
