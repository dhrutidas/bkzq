<div class="row" style="padding-top:1%%;">
    <div class="col-sm-6 col-md-8 col-md-offset-2">
        <?php if( $this->session->flashdata('message')): ?>

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
    </div>
</div>
<div class="row" style="padding-top:8%;">
<div class="col-sm-6 col-md-4 col-md-offset-4">
    <div class="panel panel-default">

    <div class="panel-heading">
        <h4 class="text-center">Login to continue</h4>
    </div>
    <div class="panel-body">
<?php if(isset($err)){ echo '<center><div class="form-group has-error has-feedback">
  <label class="control-label" for="inputError2">Login ID or Password is incorrect   </div></div></center>'; } ?>
    <form role="form" method="POST">
        <fieldset>
            <div class="row">
                <div class="center-block">
                    <img class="profile-img img-responsive" src="<?php //echo base_url("assets/images/osmos.png"); ?>" alt="">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-user"></i>
                            </span>
                        <input class="form-control" autofocus type="text" name="txt_username" placeholder="Username" autocomplete="off" />                            
                        </div>
                        <div class="form_error"><?php echo form_error('txt_username'); ?></div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-lock"></i>
                            </span>
                            <input class="form-control" type="password" name="txt_password" placeholder="Password" autocomplete="off" />                    
                        </div>
                        <div class="form_error"><?php echo form_error('txt_password'); ?></div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Login">
                    </div>
                </div>
            </div>
        </fieldset>
    </form>
    </div>
        <div class="panel-footer">
            <h4 class="text-center"><small><a href="<?php echo base_url('forgot-password'); ?>">Forgot your password?</a></small></h4>
        </div>
        <div class="panel-footer">
            <h4 class="text-center"><small><a href="<?php echo base_url('signup'); ?>">Sign up</a></small></h4>
        </div>
    </div>
</div>
</div>

<?php /*
<div class="col100">
    <div class="center-screen col40">
        <div class="box-shadow bg-white box-radius">
            <div class="top padding15"><h3>Login to your account</h3></div>

            <div class="bborder-dark"></div>

            <?php echo form_open('login'); ?>

            <div class="padding10">
                <div class="col100 padding05">
                    <input type="text" name="txt_email" placeholder="Your Email Address" class="default-text95" />
                    <div class="form_error"><?php echo form_error('txt_email'); ?></div>
                </div>
                <div class="col100 padding05">
                    <input type="password" name="txt_password" placeholder="Password" class="default-text95" />
                    <div class="form_error"><?php echo form_error('txt_password'); ?></div>
                </div>
                <div class="col100 padding05">
                    <input type="submit" class="pull-right" value="Log In">
                </div>
            </div>
            <div class="bborder-dark"></div>

            <?php echo form_close(); ?>

            <div class="bottom padding10">
                <div class="col100 padding05">
                    <p><a href="<?php echo base_url(); ?>">Forgot your password?</a></p>
                </div>
                <div class="col100 padding05">
                    <p>Don't have an account yet? <a href="<?php echo base_url(); ?>register"> Create an account</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
*/ ?>
