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
                            <img class="img-responsive img-thumbnail" src="<?php echo base_url().'assets/images/profile_pic/'.$userDetail['profilPic'].'?ver='.date('dmyhsi'); ?>" alt="Profile Picture" width='150' height="150">
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

                    <div class="form-group">
                        <div class="col-sm-4 text-right">Total marks</div>
                        <div class="col-sm-8"><b><?php echo $totalmarks; ?></b></div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-sm-4 text-right">Rank</div>
                        <div class="col-sm-8"><b><?php echo $rank; ?></b></div>
                    </div>
                    <div class="form-group">
                        <label for="inputPackage" class="col-sm-4 control-label">Select Package</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="inputPackage" name="inputPackage">
                                <option value="T" <?php echo ($userDetail['userPackageType'] == 'T') ? 'SELECTED' : ''; ?>>Free Trial</option>
                                <option value="B" <?php echo ($userDetail['userPackageType'] == 'B') ? 'SELECTED' : ''; ?>>Bronze</option>
                                <option value="S" <?php echo ($userDetail['userPackageType'] == 'S') ? 'SELECTED' : ''; ?>>Silver</option>
                                <option value="G" <?php echo ($userDetail['userPackageType'] == 'G') ? 'SELECTED' : ''; ?>>Gold</option>
                            </select>
                        </div>
                    </div>

                    <div id="bronze"<?php if($userDetail['userPackageType'] != 'B' && $userDetail['userPackageType'] != 'S' && $userDetail['userPackageType'] != 'G'){ echo 'style="display:none;"'; } ?>>
                    <div class="form-group">
                        <label for="inputSubject1" class="col-sm-4 control-label">Select Subject 1</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="inputSubject1" name="inputSubject1">
                                <option value="">----Select----</option>
                                <?php foreach( $subjectArr as $dValues ): ?>
                                    <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[0]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[0]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    </div>

                    <div id="silver"<?php if($userDetail['userPackageType'] != 'S' && $userDetail['userPackageType'] != 'G'){ echo 'style="display:none;"'; } ?>>
                    <div class="form-group">
                        <label for="inputSubject2" class="col-sm-4 control-label">Select Subject 2</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="inputSubject2" name="inputSubject2">
                                <option value="">----Select----</option>
                                <?php foreach( $subjectArr as $dValues ): ?>
                                    <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[1]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[1]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSubject3" class="col-sm-4 control-label">Select Subject 3</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="inputSubject3" name="inputSubject3">
                                <option value="">----Select----</option>
                                <?php foreach( $subjectArr as $dValues ): ?>
                                    <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[2]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[2]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    </div>

                    <div id="silver"<?php if($userDetail['userPackageType'] != 'G'){ echo 'style="display:none;"'; } ?>>
                    <div class="form-group">
                        <label for="inputSubject4" class="col-sm-4 control-label">Select Subject 4</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="inputSubject4" name="inputSubject4">
                                <option value="">----Select----</option>
                                <?php foreach( $subjectArr as $dValues ): ?>
                                    <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[3]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[3]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSubject5" class="col-sm-4 control-label">Select Subject 5</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="inputSubject5" name="inputSubject5">
                                <option value="">----Select----</option>
                                <?php foreach( $subjectArr as $dValues ): ?>
                                    <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[4]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[4]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSubject6" class="col-sm-4 control-label">Select Subject 6</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="inputSubject6" name="inputSubject6">
                                <option value="">----Select----</option>
                                <?php foreach( $subjectArr as $dValues ): ?>
                                    <option value="<?php echo $dValues['subjectID']; ?>"<?php if(isset($packageSubject[5]['subjectID'])) { if($dValues['subjectID'] == $packageSubject[5]['subjectID']) { echo 'SELECTED'; } } ?>><?php echo $dValues['subjectName']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-success">Submit</button>&nbsp;
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
