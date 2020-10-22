<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span class="glyphicon glyphicon-remove-sign"></span></button>
    <h4 class="modal-title text-primary"><b>View User Details</b></h4>
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
            <?php if($userDetail['affiliateName']) {?>
                        <div class="form-group">
                        <div class="col-sm-4 text-right">Affiliate Name</div>
                        <div class="col-sm-8"><b><?php echo $userDetail['affiliateName']; ?></b></div>
                    </div>
                        <?php  }?>  
            <div class="form-group">
                <div class="col-sm-4 text-right">Parent Name</div>
                <div class="col-sm-8"><b><?php echo $userDetail['parentName']; ?></b></div>
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
                <div class="col-sm-4 text-right">Schoole</div>
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

                $total_subject = "";
                if(($userDetail['userPackageType'] == 'B') || ($userDetail['userPackageType'] == 'S') || ($userDetail['userPackageType'] == 'G')){

                    if( ($userDetail['confirmation_value'] != "") || ($userDetail['status'] == "N") ){
                        $notConfirmSubject = explode('#',$notConfirmSubject['subject_code']);
                        if(count($notConfirmSubject) > 0){
                            $package_sub_name = "";
                            foreach( $subjectArr as $dValues ){
                                $package_sub_loop = "";
                                    foreach($notConfirmSubject as $subject){
                                          if($dValues['subjectID'] == $subject){
                                                $package_sub_name .= $dValues['subjectName'].', '; 
                                            }
                                        }
                                    }
                            $total_subject = rtrim($package_sub_name, ', ');   
                        }
                    }else{
                        $package_sub_name = "";
                        foreach( $subjectArr as $dValues ){
                            $package_sub_loop = "";
                            for ($i = 0; $i <= $package_subject; $i++) {
                                if($dValues['subjectID'] == $packageSubject[$i]['subjectID']){
                                     $package_sub_name .= $dValues['subjectName'].', '; 
                                }
                            }
                        }
                        $total_subject = rtrim($package_sub_name, ', ');
                    }
                }else{
                    $total_subject = "All Subject";
                }

                ?>

            <div class="form-group">
                <div class="col-sm-4 text-right">Package type</div>
                <div class="col-sm-8"><b><?php echo $package; ?></b></div>
            </div>

            <div class="form-group">
                <div class="col-sm-4 text-right">Subjects</div>
                <div class="col-sm-8"><b><?php echo $total_subject; ?></b></div>
            </div>

        </div>
    </form>
</div>