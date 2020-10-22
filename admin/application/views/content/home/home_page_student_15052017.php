<script type="text/javascript" src="<?php echo base_url("assets/js/highcharts.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/exporting.js"); ?>"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/highchart_data.js"); ?>"></script>

<div class="row">

    <div class="col-md-12">

        <div class="panel panel-default">
            <div class="panel-heading text-left">Welcome, <b><?php echo $this->sData['user_first_name'] ." ".$this->sData['user_last_name'] ; ?></b>
            </div>

            <div class="panel-body">
              <div class="row">
                <div class="col-md-6">
                    <select id='inputSubject' class="form-control input-group-sm" onchange="graphReLoad();">
                        <?php foreach ($subject_drop AS $value) { ?>
                            <option value="<?php echo $value['subjectID']; ?>"><?php echo $value['subjectName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <select id='inputLevel' class="form-control input-group-sm" onchange="graphReLoad();">
                        <?php foreach ($level_drop AS $value) { ?>
                            <option value="<?php echo $value['levelID']; ?>"><?php echo $value['levelName']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php //print_r($level_drop); ?>
              </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading text-left">
                                <b>Subject wise - Level status</b>
                                <!-- <div class="pull-right">
                                    <select id='subject' class="form-control input-group-sm">
                                        <?php //foreach ($allsubject AS $value) { ?>
                                            <option value="<?php //echo $value['subjectID']; ?>"><?php //echo $value['subjectName']; ?></option>
                                        <?php //} ?>
                                    </select>
                                </div>
                                <div class="clearfix"></div> -->
                            </div>
                            <div class="panel-body">
                                <div id="level_status"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="panel panel-default">
                        <div class="panel-heading text-left">
                                <b> Level wise - performance</b>
                                <!--<div class="pull-right">
                                    <select id='level' class="form-control input-group-sm">
                                        <?php foreach ($allLevel AS $value) { ?>
                                            <option value="<?php echo $value['levelID']; ?>"><?php echo $value['levelName']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>-->
                                <!-- <div class="clearfix"></div> -->
                            </div>
                            <div class="panel-body">
                                <div id="performance_status"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--Tab Content-->
        </div>
    </div>
</div>
