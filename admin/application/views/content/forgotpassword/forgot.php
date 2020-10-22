<div class="row" style="padding-top:8%;">
<div class="col-sm-6 col-md-4 col-md-offset-4">
    <div class="panel panel-default">

    <div class="panel-heading">
        <h4 class="text-center">Forgot password</h4>
    </div>
    <div class="panel-body">
<?php 
    if(isset($err)){ 
        echo '<center><div class="form-group has-error has-feedback"><label class="control-label" for="inputError2">Login ID is incorrect. </div></center>'; 
    }elseif (isset($db_err)) {
      echo '<center><div class="form-group has-error has-feedback"><label class="control-label" for="inputError2">Connection Error, Please try again !</div></center>'; 
    }elseif (isset($email_success)) {
      echo '<center><div class="form-group has-error has-feedback"><label class="control-label" for="inputError2">Password has been reset and has been sent to registered email id.</div></center>'; 
    }elseif (isset($email_fail)) {
      echo '<center><div class="form-group has-error has-feedback"><label class="control-label" for="inputError2">Technical problem ! Email has not sent to you, Please try again !</div></center>'; 
    } 
    ?>
<?php echo form_open('forgot-password','class="form-horizontal" id="forgotPassword"'); ?>
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
                        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Reset">
                    </div>
                </div>
            </div>
        </fieldset>
    </form>

    </div>
        <div class="panel-footer">
            <h4 class="text-center"><small><a href="<?php echo base_url(''); ?>">Sign in to continue</a></small></h4>
        </div>
        <div class="panel-footer">
            <h4 class="text-center"><small><a href="<?php echo base_url('signup'); ?>">Sign up</a></small></h4>
        </div>
    </div>
</div>
</div>