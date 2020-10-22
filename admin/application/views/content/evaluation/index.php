<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/data.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="<?php echo base_url("assets/js/evaluation_graph_data.js"); ?>"></script>

<?php $Data['session_data'] = $this->session->userdata('user_details');  ?>

<div class="row">
    <div class="col-md-12">

        <?php ;if( $this->session->flashdata('message')): ?>

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

    <?php if($stage_status == 'Y') { ?>

        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Evaluation</strong>
            </div>

            <div class="panel-collapse">
            <?php echo form_open('evaluation','class="form-horizontal" id="evaluationSubmit"'); ?>
            <br/>

            <div class="form-group">
                <label for="inputStudent" class="col-sm-4 control-label">Select Student</label>
                <div class="col-sm-4">
                    <select name="inputStudent" id="inputStudent" class="form-control">
                    <?php foreach ($allstudents AS $value) { ?>
                        <option value="<?php echo $value['userID']; ?>" <?php  if(isset($_POST['inputStudent'])) { if($_POST['inputStudent']==$value['userID']) { echo 'SELECTED'; } } ?>><?php echo $value['fName']. ' ' .$value['lName']; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>

            <div class="form-group">
                <label for="inputSubject" class="col-sm-4 control-label">Select Subject</label>
                <div class="col-sm-4">
                    <select name="inputSubject" id="inputSubject" class="form-control" onchange="this.form.submit()">
                    <option value="">----Select----</option>
                    <?php foreach ($allsubject AS $value) { ?>
                        <option value="<?php echo $value['subjectID']; ?>" <?php  if(isset($_POST['inputSubject'])) { if($_POST['inputSubject']==$value['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $value['subjectName']; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label for="inputChapter" class="col-sm-4 control-label">Select Chapter</label>
                <div class="col-sm-4">
                    <select name="inputChapter" id="inputChapter" class="form-control">
                    <option value="">----Select----</option>
                    <?php foreach ($allChapter AS $value) { ?>
                        <option value="<?php echo $value['chapterID']; ?>" <?php  if(isset($_POST['inputChapter'])) { if($_POST['inputChapter']==$value['chapterID']) { echo 'SELECTED'; } } ?>><?php echo $value['chapterName']; ?></option>
                    <?php } ?>
                </select>
                </div>
            </div>

              <div class="form-group">
                <label for="inputStudent" class="col-sm-4 control-label">Select from date</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control datepicker_class" name="from_date" value="<?php echo isset($_POST['from_date']) ? $_POST['from_date'] : ''; ?>" />
                </div>
              </div>

              <div class="form-group">
                <label for="inputStudent" class="col-sm-4 control-label">Select to date</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control datepicker_class" name="to_date" value="<?php echo isset($_POST['to_date']) ? $_POST['to_date'] : ''; ?>" />
                </div>
              </div>

              <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                  <button type="submit" name="btn_evaluation" class="btn btn-primary" onclick="return validation();">Evaluation</button>
                </div>
              </div>

            </form>
            </div>
        </div>

    <?php } ?>

    </div>
</div>
<?php
  if(isset($_POST['btn_evaluation'])):
?>

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading text-left"><strong>Chart</strong></div>
        <div class="panel-body" id="container"></div>
    </div>
  </div>
</div>

<div class="panel panel-default">
  <div class="panel-heading text-left"><strong>Statistics</strong></div>
    <div class="panel-body">
  <div class="row">
    <div class="col-md-offset-4 col-md-4">

        <table id="datatable" style="display: block;" class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Obtain</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Very poor</th>
                    <td><?php echo $very_poor_value; ?></td>
                    <td><?php echo $very_poor_per; ?></td>
                </tr>
                <tr>
                    <th>Poor</th>
                    <td><?php echo $poor_value; ?></td>
                    <td><?php echo $poor_per; ?></td>
                </tr>
                <tr>
                    <th>Satisfaction</th>
                    <td><?php echo $satisfaction_value; ?></td>
                    <td><?php echo $satisfaction_per; ?></td>
                </tr>
                <tr>
                    <th>Good</th>
                    <td><?php echo $good_value; ?></td>
                    <td><?php echo $good_per; ?></td>
                </tr>
                <tr>
                    <th>Very good</th>
                    <td><?php echo $very_good_value; ?></td>
                    <td><?php echo $very_good_per; ?></td>
                </tr>
                <tr>
                    <th>Best</th>
                    <td><?php echo $best_value; ?></td>
                    <td><?php echo $best_per; ?></td>
                </tr>
                <tr>
                    <th>Excellent</th>
                    <td><?php echo $excellent_value; ?></td>
                    <td><?php echo $excellent_per; ?></td>
                </tr>
            </tbody>
        </table>
        </div>
    </div>
  </div>
</div>
<?php endif; ?>
