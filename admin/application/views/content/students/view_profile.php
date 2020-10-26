<script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script>
<div class="row">
    <div class="col-md-12">
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
                <strong>Profile</strong>
            </div>

            <div class="panel-collapse">

            <?php echo form_open_multipart('submit-edit-user-display-pic','class="form-horizontal" '); ?>
                <div class="scrollable-body">
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Profile Pic</div>
                        <div class="col-sm-2">
                            <?php if($userDetail['profilPic']):?>
                                <img class="img-responsive img-thumbnail" src="<?php echo base_url().'assets/images/profile_pic/'.$userDetail['profilPic'].'?ver='.date('dmyhsi'); ?>" alt="Profile Picture" width='150' height="150">
                            <?php else:?>
                                <img  class="img-responsive img-thumbnail" src='<?php echo base_url("assets/images/default_profile.png"); ?>' hight='200' width='200'>
                            <?php endif;?>
                        </div>
                        <div class="col-sm-4 text-left">
                            <input type='file' name='inputProfilePic' style='display: inline;'>
                            <input type='submit' value='Change' class='btn btn-success'>
                        </div>
                    </div>
                  </div>
                </form>


            <?php echo form_open_multipart('upgrade-package','class="form-horizontal" id="updatePackage"'); ?>

                <div class="scrollable-body">
                    <div class="form-group">
                        <div class="col-sm-4 text-right">First Name</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['fName']; ?></b></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Last Name</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['lName']; ?></b></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Email</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['emailID']; ?></b></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Contact</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['contactNumber']; ?></b></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Address</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['residenceAdd']; ?></b></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Additional Info</div>
                        <div class="col-sm-8"><b><?php echo empty($userDetail['additionalInfo']) ? '-' : $userDetail['additionalInfo']; ?></b></div>
                    </div>
                    <?php if($userDetail['roleID'] == 3):?>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">School</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['schoolName']; ?></b></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Board</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['boardName']; ?></b></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Standard</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['stdName']; ?></b></div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-4 text-right">Total marks</div>
                        <div class="col-sm-8"><b><?php echo $totalmarks; ?></b></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Rank</div>
                        <div class="col-sm-1"><b><?php echo $rank; ?></b></div>
                        <form action="/profile" method="get" id="get_rank">
                            <div class="col-md-2 mr-top ">
                                    <div class='input-group' id='datetimepicker1' >
                                        <input type='text' class="form-control from_date" placeholder="From Date" name="from_date" value="<?= @$_GET['from_date']?>" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-2 mr-top mr-bottom">
                                   <div class='input-group' id='datetimepicker2'>
                                        <input type='text' class="form-control to_date" name="to_date" placeholder="To Date" value="<?= @$_GET['to_date']?>"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <div class="col-sm-2">
                                            <button type="button" onclick="get_rank()" class="btn btn-success">Get Rank</button>&nbsp;
                                        </div>
                                    </div>
                                </div>
                                
                            <?php endif; ?>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-8">
                                    <a href="<?php echo base_url('open-edit-profile-modal'); ?>" data-toggle="modal" data-target="#profileModal">Edit Profile</a>
                                </div>
                            </div>
                        </form>
                        
                        </div>

                   
            </form>
        </div>
        
    </div>
</div>
</div>

<div id="profileModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content"></div>
    </div>
</div>
