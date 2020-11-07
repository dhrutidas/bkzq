<!-- <script type="text/javascript" src="<?php echo base_url("assets/js/student.js"); ?>"></script> -->
<script type="text/javascript">
    function packageChange() {
        var package = $("#inputPackage").val();
        switch (package) {
            case "T":
                $("#input_package_info").html("Free Trial: Select All Subject");
                break;
            case "B":
                $("#input_package_info").html("Bronze: Select One Subject")
                break;
            case "S":
                $("#input_package_info").html("Silver: Select Three Subject")
                break;
            case "G":
                $("#input_package_info").html("Gold: Select Six Subject")
                break;
            default:
                break;
        }
        $('input[name="subject[]"][type=checkbox]').each(function(o) {
            $(this).prop("disabled", false);
            $(this).prop('checked', false);
        });
    }


    function mobile_validation() {

        var value = document.getElementById('inputContact').value;
        var NumberRegex = /^[0-9]*$/;
        if (value.length == 10 && NumberRegex.test(value)) {
            return true;
        } else {
            alert('Please enter correct mobile number. ');
            return false;
        }
    }
</script>
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

        <div class="" style="padding-top:1%;">
            <div class="">
                <div class="panel panel-default">

                    <div class="panel-heading" style="display: inline-block; width: 100%;">
                        <h4 class="text-center pull-left">Sign up to continues</h4>

                        <a href="<?php echo base_url(''); ?>" class="btn btn-default pull-right">Sign In</a>
                    </div>

                    <div class="form-group affiliateUserQuestion" id="affiliateUserQuestion">
                        <label for="affiliateOptIn" class="control-label">
                            <input type="checkbox" id="affiliateOptIn" name="affiliateOptIn" <?php echo isset($affiliateOptIn) ? 'checked' : ''; ?> />
                            Do you want to register as an Affiliate ?
                        </label>
                    </div>

                    <div class="panel-body" id="nonAffiliateUser" style="display:block">

                        <?php echo form_open_multipart('submit-signup', ' id="addSignupform"'); ?>

                        <div class="scrollable-body">

                            <div class="form-group col-sm-6">
                                <label for="inputFirstName" class="control-label mandatory">First Name </label>
                                <div class="">
                                    <input type="text" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="First Name">
                                    <span id="first_name_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputLastName" class="control-label mandatory">Last Name</label>
                                <div class="">
                                    <input type="text" class="form-control" id="inputLastName" name="inputLastName" placeholder="Last Name">
                                    <span id="last_name_error" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputEmail" class="control-label mandatory">Email</label>
                                <div class="">
                                    <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="inputEmail">
                                    <span id="email_error" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputContact" class="control-label mandatory">Mobile Number</label>
                                <div class="">
                                    <input type="tel" class="form-control" id="inputContact" placeholder="Mobile Number" name="inputContact">
                                    <span id="mobile_number_error" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputBoard" class="control-label mandatory">Select Board</label>
                                <div class="">
                                    <select class="form-control" id="inputBoard" name="inputBoard">
                                        <option value="">----Select----</option>
                                        <?php foreach ($boardArr as $bValues) : ?>
                                            <option value="<?php echo $bValues['boardID']; ?>"><?php echo $bValues['boardName']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="input_board_error" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputSchool" class="control-label mandatory">Select School</label>
                                <div class="">
                                    <select class="form-control" id="inputSchool" name="inputSchool">
                                        <option value="">----Select----</option>
                                        <?php foreach ($schoolArr as $dValues) : ?>
                                            <option value="<?php echo $dValues['schoolID']; ?>"><?php echo $dValues['schoolName']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="input_school_error" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputClass" class="control-label mandatory">Select Statndard</label>
                                <div class="">
                                    <select class="form-control" id="inputClass" name="inputClass">
                                        <option value="">----Select----</option>
                                        <?php foreach ($classArr as $dValues) : ?>
                                            <option value="<?php echo $dValues['stdID']; ?>"><?php echo $dValues['stdName']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="input_class_error" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputPackage" class="control-label mandatory">Select Package</label>
                                <div class="">
                                    <select class="form-control" onchange="packageChange()" id="inputPackage" name="inputPackage">
                                        <option value="T" selected="selected">Free Trial</option>
                                        <option value="B">Bronze</option>
                                        <option value="S">Silver</option>
                                        <option value="G">Gold</option>
                                    </select>
                                    <span id="input_package_info" class="text-danger">Free Trial: Select All Subject</span>
                                    <span id="input_package_error" class="text-danger"></span>
                                </div>

                            </div>

                            <div class="form-group col-sm-12">
                                <label for="inputSubject" class="control-label mandatory">Select Subject</label>
                                <div class="selectSub" id="CheckboxListDiv">
                                    <ul id="CheckBoxList">
                                        <?php foreach ($subjectArr as $dValues) : ?>
                                            <li class="col-sm-3">
                                                <input type="checkbox" name="subject[]" value="<?php echo $dValues['subjectID']; ?>"><label><?php echo $dValues['subjectName']; ?></label>
                                            </li>
                                        <?php endforeach; ?>
                                        <span id="input_subject_error" class="text-danger"></span>
                                    </ul>
                                </div>
                            </div>

                            <div class="form-group col-sm-6">
                                <label for="inputFirstName" class="control-label mandatory">Password</label>
                                <div class="">
                                    <input type="password" class="form-control" id="inputPassword" name="inputPassword">
                                    <span id="password_error" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group col-sm-6">
                                <label for="inputFirstName" class="control-label mandatory">Confirm Password</label>
                                <div class="">
                                    <input type="password" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword">
                                    <span id="confirm_password_error" class="text-danger"></span>
                                </div>

                            </div>
                            <div class="form-group col-sm-12">
                                <label for="affiliateCode" class="control-label">Afiiliate Code</label>
                                <div class="">
                                    <input type="text" class="form-control" id="affiliateCode" name="affiliateCode">
                                    <span id="affiliate_code_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <label for="ihave" class="control-label mandatory">I have</label>
                                <div class="">
                                    <select class="form-control" id="ihave" name="ihave" required>
                                        <option value="accepted">Accepted</option>
                                    </select>
                                    <a href="http://bkzquiz.com/privacy_policy.php" target="_blank">Policy</a> , <a href="http://bkzquiz.com/publisher_terms.php" target="_blank">Term & Conditions</a>.
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="image_captchaWrap">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="captcha" name="captcha">
                                        <span id="captcha_error" class="text-danger"></span>
                                    </div>
                                    <div class="col-sm-4">
                                        <p id="image_captcha">
                                            <?php echo $captchaImg; ?>
                                            <a href="javascript:void(0);" class="captcha-refresh">
                                                <img class="captcha-refresh-img" src="<?php echo base_url("assets/images/refresh-button.png"); ?>"/>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="btn-submit-student_wrap">
                                    <button type="submit" class="btn btn-primary" id="btn-submit-student">Submit</button>&nbsp;
                                    <!--onclick="return mobile_validation(this)"-->
                                    <button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url(''); ?>'">Cancel</button>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="alert alert-warning">
                                    <p>(Please provide correct information or else your account won't be activated*)</p>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>

                    <div class="panel-body" id="affiliateUser" style="display:none">

                        <?php echo form_open_multipart('submit-signup-affiliate', ' id="addSignupformAffiliate"'); ?>

                        <div class="scrollable-body">
                            <fieldset>
                                <legend class="col-sm-12">Affiliate related details</legend>

                                <div class="form-group col-sm-6">
                                    <label for="inputAffFirstName" class="control-label mandatory">First Name</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="inputAffFirstName" name="inputAffFirstName" placeholder="First Name">
                                        <span id="inputAffFirstName_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="inputAffLastName" class="control-label mandatory">Last Name</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="inputAffLastName" name="inputAffLastName" placeholder="Last Name">
                                        <span id="inputAffLastName_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="inputDateofbirth" class="control-label mandatory">Date of birth </label>
                                    <div class="">
                                        <input type="text" class="form-control datepicker_class" id="inputDateofbirth" name="inputDateofbirth" />
                                        <span id="inputDateofbirth_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="inputAffEmail" class="control-label mandatory">Email</label>
                                    <div class="">
                                        <input type="email" class="form-control" id="inputAffEmail" placeholder="Email" name="inputAffEmail">
                                        <span id="inputAffEmail_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-12">
                                    <label for="inputAffContact" class="control-label mandatory">Mobile Number</label>
                                    <div class="">
                                        <input type="tel" class="form-control" id="inputAffContact" placeholder="Mobile Number" name="inputAffContact">
                                        <span id="inputAffContact_error" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="inputFirstName" class="control-label mandatory">Password</label>
                                    <div class="">
                                        <input type="password" class="form-control" id="inputAffPassword" name="inputAffPassword">
                                        <span id="inputAffPassword_error" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="form-group col-sm-6">
                                    <label for="inputFirstName" class="control-label mandatory">Confirm Password</label>
                                    <div class="">
                                        <input type="password" class="form-control" id="inputAffConfirmPassword" name="inputAffConfirmPassword">
                                        <span id="inputAffConfirmPassword_error" class="text-danger"></span>
                                    </div>

                                </div>

                                <!-- <input type="hidden" name="parentID" value=<?php echo (isset($parentID) && $parentID > 0) ? $parentID : 0; ?> /> -->
                            </fieldset>
                            <!-- Affiliate related details fieldset ends here-->
                           
                            <div class="form-group col-sm-12">
                                <label for="ihave" class="control-label mandatory">I have</label>
                                <div class="">
                                    <select class="form-control" id="ihave" name="ihave" required>
                                        <option value="accepted">Accepted</option>
                                    </select>
                                    <a href="http://bkzquiz.com/privacy_policy.php" target="_blank">Policy</a> , <a href="http://bkzquiz.com/publisher_terms.php" target="_blank">Term & Conditions</a>.
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="image_captchaWrap">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="captcha" name="affCaptcha">
                                        <span id="aff_captcha_error" class="text-danger"></span>
                                    </div>
                                    <div class="col-sm-4">
                                        <p id="image_captcha_aff">
                                            <?php echo $captchaImg; ?>
                                            <a href="javascript:void(0);" class="captcha-refresh-aff" >
                                                <img class="captcha-refresh-img" src="<?php echo base_url("assets/images/refresh-button.png"); ?>"/>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-sm-12">
                                <div class="btn-submit-student_wrap">
                                    <button type="submit" class="btn btn-primary" id="btn-submit-affiliate">Submit</button>&nbsp;
                                    <button type="button" class="btn btn-default" onclick="window.location='<?php echo base_url(''); ?>'">Cancel</button>
                                </div>
                            </div>
                            <div class="form-group col-sm-12">
                                <div class="alert alert-warning">
                                    <p>(Please provide correct information or else your account won't be activated*)</p>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
        
        
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var studentId;
        $('#affiliateOptIn').change(function() {
            $('#affiliateUser').toggle();
            $('#nonAffiliateUser').toggle();
        });
        $('#CheckBoxList input[type=checkbox]').change(function() {
            var packageValue = $("#inputPackage").val();
            switch (packageValue) {
                case "T":
                    checkboxLimit = 10;
                    break;
                case "B":
                    checkboxLimit = 1;
                    break;
                case "S":
                    checkboxLimit = 3;
                    break;
                case "G":
                    checkboxLimit = 6;
                    break;
                default:
                    break;
            }
            if ($('input[name="subject[]"][type=checkbox]:checked').length >= checkboxLimit) {
                $('input[name="subject[]"][type=checkbox]').each(function(o) {
                    if ($(this).is(":checked") == false)
                        $(this).prop("disabled", true);
                });
            } else {
                $('input[name="subject[]"][type=checkbox]').each(function(o) {
                    $(this).prop("disabled", false);
                });
            }


        });
      
        $("#btn-submit-student").click(function(e) {
            
            e.preventDefault();
            var subject_list = [];
            if ($('input[name="subject[]"][type=checkbox]:checked').length > 0) {
                $('input[name="subject[]"][type=checkbox]:checked').each(function(o) {
                    subject_list.push($(this).val());
                });
                $('#input_subject_error').html("");
            } else {
                $('#input_subject_error').html("Please select subject");
            }
            var inputFirstName = $("input[name='inputFirstName']").val();
            var inputLastName = $("input[name='inputLastName']").val();
            var inputEmail = $("input[name='inputEmail']").val();
            var inputContact = $("input[name='inputContact']").val();
            var inputBoard = $('#inputBoard').val();
            var inputSchool = $('#inputSchool').val();
            var inputClass = $('#inputClass').val();
            var inputPackage = $('#inputPackage').val();
            var affiliateCode = $('#affiliateCode').val();
            var inputSubject = subject_list.join(",");
            var inputPassword = $("input[name='inputPassword']").val();
            var inputConfirmPassword = $("input[name='inputConfirmPassword']").val();
            var captcha = $("input[name='captcha']").val();


            $.ajax({

                url: $("#addSignupform").closest('form').attr('action'),

                type: $("#addSignupform").closest('form').attr('method'),

                dataType: "json",

                data: {
                    inputFirstName: inputFirstName,
                    inputLastName: inputLastName,
                    inputEmail: inputEmail,
                    inputContact: inputContact,
                    inputBoard: inputBoard,
                    inputSchool: inputSchool,
                    inputClass: inputClass,
                    inputPackage: inputPackage,
                    inputPassword: inputPassword,
                    inputConfirmPassword: inputConfirmPassword,
                    inputSubject: inputSubject,
                    affiliateCode: affiliateCode,
                    captcha: captcha
                },

                success: function(data) {
                    if (data.error) {
                        if (data.first_name_error != '') {
                            $('#first_name_error').html(data.first_name_error);
                        } else {
                            $('#first_name_error').html('');
                        }
                        if (data.last_name_error != '') {
                            $('#last_name_error').html(data.last_name_error);
                        } else {
                            $('#last_name_error').html('');
                        }
                        if (data.email_error != '') {
                            $('#email_error').html(data.email_error);
                        } else {
                            $('#email_error').html('');
                        }
                        if (data.contact_error != '') {
                            $('#mobile_number_error').html(data.contact_error);
                        } else {
                            $('#mobile_number_error').html('');
                        }
                        if (data.board_error != '') {
                            $('#input_board_error').html(data.board_error);
                        } else {
                            $('#input_board_error').html('');
                        }
                        if (data.school_error != '') {
                            $('#input_school_error').html(data.school_error);
                        } else {
                            $('#input_school_error').html('');
                        }
                        if (data.class_error != '') {
                            $('#input_class_error').html(data.class_error);
                        } else {
                            $('#input_class_error').html('');
                        }
                        if (data.password_error != '') {
                            $('#password_error').html(data.password_error);
                        } else {
                            $('#password_error').html('');
                        }
                        if (data.confirm_password_error != '') {
                            $('#confirm_password_error').html(data.confirm_password_error);
                        } else {
                            $('#confirm_password_error').html('');
                        }
                        if (data.affiliate_code_error != '') {
                            $('#affiliate_code_error').html(data.affiliate_code_error);
                        } else {
                            $('#affiliate_code_error').html('');
                        }
                        if (data.captcha_error != '') {
                            $('#captcha_error').html(data.captcha_error);
                        } else {
                            $('#captcha_error').html('');
                        }
                    }
                    if (data.success) {
                        $("#flash-msg").show();
                        $("#flash-msg").html('<a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a><strong>' + data.message + '</strong>');
                        $('#first_name_error').html();
                        $('#last_name_error').html('');
                        $('#contact_error').html('');
                        $('#role_error').html('');
                        $('#password_error').html('');
                        $('#confirm_password_error').html('');
                        $('#captcha_error').html('');
                        $('#addSignupform')[0].reset();
                        studentId = data.userId;
                        //$("#viewModal").modal();
                        //$('#viewModal .modal-body').append('<spna>Name:<strong>'+ data.name+'</strong></span></br><spna>Email:<strong>'+ data.email+'</strong></span>');
                        //window.location.href='manage-users';
                        if(data.packageType == 'T')
                            window.location.href='info';
                        else
                            window.location.href='signup-paynow/'+studentId;
                    }
                }

            });

        });

        $("#btn-submit-affiliate").click(function(e) {

            e.preventDefault();
            var inputAffFirstName = $("input[name='inputAffFirstName']").val();
            var inputAffLastName = $("input[name='inputAffLastName']").val();
            var inputAffEmail = $("input[name='inputAffEmail']").val();
            var inputAffContact = $("input[name='inputAffContact']").val();
            var inputDateofbirth = $('#inputDateofbirth').val();
            var inputAffPassword = $("input[name='inputAffPassword']").val();
            var inputAffConfirmPassword = $("input[name='inputAffConfirmPassword']").val();
            var captcha = $("input[name='affCaptcha']").val();

            $.ajax({

                url: $("#addSignupformAffiliate").closest('form').attr('action'),

                type: $("#addSignupformAffiliate").closest('form').attr('method'),

                dataType: "json",

                data: {
                    inputAffFirstName: inputAffFirstName,
                    inputAffLastName: inputAffLastName,
                    inputAffEmail: inputAffEmail,
                    inputAffContact: inputAffContact,
                    inputDateofbirth: inputDateofbirth,
                    inputAffPassword: inputAffPassword,
                    inputAffConfirmPassword: inputAffConfirmPassword,
                    inputAffConfirmPassword: inputAffConfirmPassword,
                    captcha: captcha
                },

                success: function(data) {
                    if (data.error) {
                        if (data.first_name_error != '') {
                            $('#inputAffFirstName_error').html(data.first_name_error);
                        } else {
                            $('#inputAffFirstName_error').html('');
                        }
                        if (data.last_name_error != '') {
                            $('#inputAffLastName_error').html(data.last_name_error);
                        } else {
                            $('#inputAffLastName_error').html('');
                        }
                        if (data.email_error != '') {
                            $('#inputAffEmail_error').html(data.email_error);
                        } else {
                            $('#inputAffEmail_error').html('');
                        }
                        if (data.contact_error != '') {
                            $('#inputAffContact_error').html(data.contact_error);
                        } else {
                            $('#inputAffContact_error').html('');
                        }
                        if (data.date_of_birth_error != '') {
                            $('#inputDateofbirth_error').html(data.date_of_birth_error);
                        } else {
                            $('#inputDateofbirth_error').html('');
                        }
                        if (data.password_error != '') {
                            $('#inputAffPassword_error').html(data.password_error);
                        } else {
                            $('#inputAffPassword_error').html('');
                        }
                        if (data.confirm_password_error != '') {
                            $('#inputAffConfirmPassword_error').html(data.confirm_password_error);
                        } else {
                            $('#inputAffConfirmPassword_error').html('');
                        }
                        if (data.captcha_error != '') {
                            $('#aff_captcha_error').html(data.captcha_error);
                        } else {
                            $('#aff_captcha_error').html('');
                        }
                    }
                    if (data.success) {
                        $("#flash-msg").show();
                        $("#flash-msg").html('<a href="#" class="close" data-dismiss="alert" aria-label="close"><span class="glyphicon glyphicon-remove-sign"></span></a><strong>' + data.message + '</strong>');
                        $('#inputAffFirstName_error').html();
                        $('#inputAffLastName_error').html('');
                        $('#inputAffEmail_error').html('');
                        $('#inputAffContact_error').html('');
                        $('#inputDateofbirth_error').html('');
                        $('#inputAffPassword_error').html('');
                        $('#inputAffConfirmPassword_error').html('');
                        $('#addSignupformAffiliate')[0].reset();
                        window.location.href='affiliate-login';
                    }
                }

            });

        });

        $('.captcha-refresh').on('click', function(){
            $.get('<?php echo base_url().'captcha-refresh'; ?>', function(data){
                $('#image_captcha').html(data);
            });
        });
        $('.captcha-refresh-aff').on('click', function(){
            $.get('<?php echo base_url().'captcha-refresh'; ?>', function(data){
                $('#image_captcha_aff').html(data);
            });
        });

        // $("#btn-pay-later").click(function(e){
        //     window.location.href='signup-paylater/'+studentId;
        // });

        // $("#btn-pay-now").click(function(e){
        //     window.location.href='signup-paynow/'+studentId;
        // });
      
    });
</script>