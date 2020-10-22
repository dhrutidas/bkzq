<div class="row" style="padding-top:1%;">
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
    <div class="col-sm-8 col-md-10 col-md-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="text-center">We are sending you offline payment Details. Please mail to admin@bkzquiz.com for anyquery.</h4>
            </div>
        </div>
    </div>
</div>
  