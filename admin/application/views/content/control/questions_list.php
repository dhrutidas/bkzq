<div class="row">
    <div class="col-md-12">

        <?php if ($this->session->flashdata('message')) : ?>

            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('message'); ?></strong>
            </div>
        <?php endif; ?>
        <?php if ($this->session->flashdata('warning')) : ?>
            <div class="alert alert-danger fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a>
                <?php echo $this->session->flashdata('warning'); ?></strong>
            </div>
        <?php endif; ?>

        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Quality Control questions</strong>
                <!-- <div class="pull-right">
                    <a href="<?php echo base_url("add-question-new"); ?>">
                        <span class="glyphicon glyphicon-plus-sign"></span> Add New Question
                    </a>
                </div> -->
            </div>
            <div class="panel-collapse customTable">

                <table class="table table-hover table-striped" id="user-table">
                    <thead>
                        <tr>
                            <th class="bg-primary">No:</th>
                            <th class="bg-primary">Question</th>
                            <th class="bg-primary">
                                <select class="form-control" id="select-manager" name="inputRole">
                                    <option value="">Select manager</option>
                                    <?php foreach ($qm_list as $rValues) : ?>
                                        <?php //print_r($rValues);exit;
                                        ?>
                                        <option value="<?php echo $rValues['userID']; ?>"><?php echo $rValues['fName'] . " " . $rValues['lName']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </th>
                        
                            <th class="bg-primary">Created On</th>
                            <th class="bg-primary">Action</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>


            </div>
        </div>

        <div id="viewModal" class="modal fade">
            <div class="modal-dialog" style="width:950px;">
                <div class="modal-content"></div>
            </div>
        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        $('#user-table').DataTable({
            // Processing indicator
            "processing": true,
            // DataTables server-side processing mode
            "serverSide": true,
            // Initial no order.
            "order": [],
            // Load data from an Ajax source
            "ajax": {
                "url": "<?php echo base_url('questions-list-control'); ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties
            "columnDefs": [{
                "targets": [2, 4],
                "orderable": false
            }]
        });
        $('#select-manager').change(function() {
            if ($.fn.DataTable.isDataTable("#user-table")) {
                $('#user-table').DataTable().clear().destroy();
            }
            var userID = $(this).val();
            $('#user-table').DataTable({
                // Processing indicator
                "processing": true,
                // DataTables server-side processing mode
                "serverSide": true,
                // Initial no order.
                "order": [],
                // Load data from an Ajax source
                "ajax": {
                    "url": "<?php echo base_url('questions-list-control'); ?>",
                    "type": "POST",
                    'data': {
                        user_id: userID,
                    },
                },
                //Set column definition initialisation properties
                "columnDefs": [{
                    "targets": [2],
                    "orderable": false
                }]
            });
        });
        $('#select-status').change(function() {
            if ($.fn.DataTable.isDataTable("#user-table")) {
                $('#user-table').DataTable().clear().destroy();
            }
            var status = $(this).val();
            $('#user-table').DataTable({
                // Processing indicator
                "processing": true,
                // DataTables server-side processing mode
                "serverSide": true,
                // Initial no order.
                "order": [],
                // Load data from an Ajax source
                "ajax": {
                    "url": "<?php echo base_url('questions-list-control'); ?>",
                    "type": "POST",
                    'data': {
                        status:status
                    },
                },
                //Set column definition initialisation properties
                "columnDefs": [{
                    "targets": [2],
                    "orderable": false
                }]
            });
        });
    });
</script>