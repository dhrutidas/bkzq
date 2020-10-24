<!-- <script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script> -->

<div class="row">
    <div class="col-md-12">
        <div class="row" style="padding-top:1%;">
            <div class="col-sm-6 col-md-8 col-md-offset-2">
                <div class="alert alert-success fade in" id="flash-msg" style="display:none;">

                </div>
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
            </div>
        </div>

        <div class="row" style="padding-top:1%;">
            <div class="col-sm-8 col-md-10 col-md-offset-1">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <h4 class="text-center">Welcome Information</h4>
                    </div>

                    <div class="form-group" style="background-color:#ffffff; padding-top:5px;" id="affiliateUserQuestion">
                        <span>Your Account is on review. We will notify you further. For any Query, Please mail to admin@bkzquiz.com</span>
                    </div>

                    <div class="panel-footer">
                        <h4 class="text-center"><small><a href="<?php echo base_url(''); ?>">Sign in to continue</a></small></h4><br>
                    </div>
                </div>

            </div>
        </div>
        
       
    </div>
</div>
