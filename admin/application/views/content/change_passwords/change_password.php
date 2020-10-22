<div class="row">
    <div class="col-sm-12 col-md-offset-0">
        
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

        
        <div class="panel panel-default">
            <div class="panel-heading text-left">
                <strong>Change Password</strong>
            </div>

            <div class="panel-collapse">

                <?php echo form_open('submit-change-password','class="form-horizontal" id="changePassword"'); ?>

                <div class="row">
                    <div class="center-block">
                        <img class="profile-img img-responsive" src="<?php //echo base_url("assets/images/osmos.png"); ?>" alt="">
                    </div>
                </div>

                <div class="form-group">
                    <label for="inputOldPassword" class="col-sm-4 control-label">Enter old password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="inputOldPassword" name="inputOldPassword">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputNewPassword" class="col-sm-4 control-label">Enter new password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="inputNewPassword" name="inputNewPassword">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputNewConfirmPassword" class="col-sm-4 control-label">Confirm New password</label>
                    <div class="col-sm-4">
                        <input type="password" class="form-control" id="inputNewConfirmPassword" name="inputNewConfirmPassword">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                        <button type="submit" class="btn btn-primary">Change Password</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        
    </div>
</div>
