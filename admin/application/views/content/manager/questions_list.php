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
                <strong>Manage questions</strong>
                <div class="pull-right">
                    <a href="<?php echo base_url("open-add-user-modal"); ?>" data-toggle="modal" data-target="#viewModal">
                        <span class="glyphicon glyphicon-plus-sign"></span> Add New Question
                    </a>
                </div>
            </div>
            <div class="panel-collapse customTable">

                <table class="table table-hover table-striped" id="user-table">
                    <thead>
                        <tr>
                            <th class="bg-primary">No:</th>
                            <th class="bg-primary">Question</th>
                            <th class="bg-primary">Options</th>
                            <th class="bg-primary">Answer</th>
                            <!-- <th class="bg-primary">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>


            </div>
        </div>

        <div id="viewModal" class="modal fade">
            <div class="modal-dialog">
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
                "url": "<?php echo base_url('questions-list-manager'); ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties
            "columnDefs": [{
                "targets": [0],
                "orderable": false
            }]
        });
    });
</script>