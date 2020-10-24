<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $page_title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo base_url("assets/bootstrap/css/bootstrap.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/jquery-ui/jquery-ui.css"); ?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/core.css"); ?>">
    <link rel="stylesheet" href="<?php //echo base_url("assets/css/core1.css"); ?>">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <!-- <link rel="stylesheet" type="text/css" href="<?php //echo base_url('assets/datatables/datatables.min.css'); ?>"/> -->
    <script type="text/javascript" src="<?php echo base_url("assets/js/jquery.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/jquery-ui/jquery-ui.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/bootstrap/js/bootstrap.js"); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url("assets/datatables/datatables.min.js"); ?>"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    <script type="text/javascript">

        var BASE_URL = "<?php echo base_url();?>";

        $(document).ready(function () {
            $(".datepicker_class").datepicker({
                changeMonth: true,
                changeYear: true,
                dateFormat: 'yy-mm-dd'
            });

            $('[data-toggle="tooltip"]').tooltip();
            $('#myTooltip').tooltip({placement: "auto"});

            $('body').on('hidden.bs.modal', '.modal', function () {
                $(this).removeData('bs.modal');
            });
        });
    </script>
</head>
<body>

    <div class="container">
        <?php //if($load_page == 'signup/paynow') { $this->load->view('content/signup/paynow'); exit; } ?>
        <?php if ( isset( $this->sData )): ?>

            <div class="row">
                <div class="col-md-12">
                    <?php $this->load->view('templates/header'); ?>
                </div>
            </div>

        <?php $this->load->view('content/' . $load_page); ?>
        <?php elseif($this->uri->segment(1) == 'signup-paynow') : $this->load->view('content/signup/paynow'); ?>
        <?php elseif($this->uri->segment(1) == 'forgot-password'): $this->load->view('content/forgotpassword/forgot'); ?>
        <?php elseif($this->uri->segment(1) == 'signup'): $this->load->view('content/signup/index'); ?>
        <?php elseif($this->uri->segment(1) == 'info'): $this->load->view('content/signup/info'); ?>
        <?php else: $this->load->view('content/login/sign_in'); ?>

        <?php endif; ?>


        <div class="row">
            <div class="col-md-12">
                <?php $this->load->view('templates/footer'); ?>
            </div>
        </div>

    </div>
</body>
</html>
