<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>View Details</b></h4>
</div>
<div class="modal-body bg-primary">
    <form method="post" class="form-horizontal" >
        <div class="scrollable-body">

            <div class="form-group">
                <div class="col-sm-4 text-right">Profile Pic</div>
                <div class="col-sm-5">
                    <img class="img-responsive img-thumbnail" src="<?php echo base_url().'assets/images/profile_pic/'.$userDetail['profilPic'].'?ver='.date('dmyhsi'); ?>" alt="Profile Picture">
                </div>
            </div>
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
            <div class="form-group">
                <div class="col-sm-4 text-right">Date of birth</div>
                <div class="col-sm-8"><b><?php echo empty($userDetail['birthDate']) ? '-' : $userDetail['birthDate']; ?></b></div>
            </div>
           
           
            <?php 
                $package_subject = 0;
                if($userDetail['userPackageType'] == 'T'){
                    $package = "Trial";
                }elseif ($userDetail['userPackageType'] == 'B') {
                    $package = "Bronze";
                    $package_subject = 0;
                }elseif ($userDetail['userPackageType'] == 'S') {
                    $package = "Silver";
                    $package_subject = 2;
                }elseif ($userDetail['userPackageType'] == 'G') {
                    $package = "Gold";
                    $package_subject = 5;
                }else{
                    $package = "-";
                } 

                ?>

            <div class="form-group">
                <div class="col-sm-4 text-right">Package type</div>
                <div class="col-sm-8"><b><?php echo $package; ?></b></div>
            </div>           
            <div>
            <div class="col-sm-4 text-right">Student registered</div>
                <div class="col-sm-8"><b><?php echo $userDetail['studentName']; ?></b></div>
            </div>    
        </div>
    </form>
</div>