$(document).ready(function () {
        $(document).on('change', '#QueImg,#QueTxt', function () {
            var txt = $(this).attr('id') === 'QueImg';
            var img = $(this).attr('id') === 'QueTxt';
            if (txt) {
                $('#QueTxt').val('');
                $('#results').html('');
            } else if (img) {
                $('#QueImg').val('');
            }
        });

        $(document).on('keyup', '#QueTxt', function () {
            var ipval = $('#QueTxt').val();
            if (ipval !== '') {
                $.ajax({
                    url: 'ajax-getdata',
                    data: {value: ipval, action: 'getdata'},
                    type: 'POST',
                    success: function (data) {
                        $('#results').html(data);
                    }

                });
            } else {
                $('#QueImg').val('')
                $('#results').html('');
            }
        });

        $(document).on('change', '#QueImg', function () {
            var ipval = $(this).val();
            if (ipval !== '') {
            window.storeimg = $('#QueImg').prop('files')[0];
                $('#results').html('<button data-toggle="modal" data-target="#AnsModal" type="button" id="addques" class="btn btn-primary btn-md">Add to Questions</button>');

            } else {
                $('#QueTxt').val('')
                $('#results').html('');
            }

        });

        $(document).on('click', '#addques', function () {
            if($('#QueTxt').val() != ''){
             $.ajax({
                url: 'ajax-getdata',
                data: {action: 'getansmenu'},
                type: 'POST',
                success: function (data) {
                    $('#mbobomb').html(data);
                    $('#AnsModal').modal('show');
                    $('#quesText').text($('#QueTxt').val());
                }
              }); 
            }else{
                alert('Please enter question');
                $('#QueTxt').focus();
                return false;
            }
            
        });

        $(document).on('click', '#adbtn', function () {
            var cnt = parseInt($("#rowCount").val());
            if(cnt < 6){
                $('#formMe').find('.col-md-12:last').after('<div class="col-md-12" style="padding-bottom:10px;">'
                    + '<div class="col-md-3" ><input type="text" name="txtans" class="txtans"></div>'
                    + '<div class="col-md-4"><input type="file" name="ansimg" class="ansimg"></div>'
                    + '<div class="col-md-4"><input type="text" name="ansimgdesc" class="ansimgdesc"></div>'
                    + '<div class="col-md-1"><input type="checkbox" class="anschk" name="newans"></div></div>');
                cnt++;
                $("#rowCount").val(cnt);
            }
            if(cnt === 5){
                $("#adbtn").hide();
            }
            
            // if ($('.txtans').length >= 2 && $('#submit').length === 0)
            // {
            //     //$('#formMe').last().append('<button type="submit" id="submit" class="btn btn-primary btn-sm">Submit Q&A</button>');
            // }

        });


        $(document).on("click", "input:checkbox", function () {
            if ($(this).is(":checked")) {
                var group = "input:checkbox[name='" + $(this).attr("name") + "']";
                $(group).prop("checked", false);
                $(this).prop("checked", true);
            } else {
                $(this).prop("checked", false);
            }
        });


        $(document).ready(function(){

            $("#QnAsubmit").click(function() {

            var error = 0;
            if($('input[type=checkbox]:checked').length == 0)
            {
                alert ( "Select any one option as answer." );
                error = 1;
                return false;
            }
            
                if(error == 0){
                    var confirmBox = confirm("Do you want to submit this question.");
                    if (confirmBox == true) {
                        var ansValues =[]; var ansCorrection=[];
                        $("input[name=txtans]").each(function () {
                            ansValues.push($(this).val());
                        });
                        $("input[name=newans]").each(function () {
                            $valueObject=($(this).is(":checked"))?'Y':'N';
                            ansCorrection.push($valueObject);
                        });
                        var level=$('#inputLevel').val();
                        var board=$('#inputBoard').val();
                        var subject=$('#inputSubject').val();
                        var standard=$('#inputStandard').val();
                        
                        var questionValues = $('#QueTxt').val();
                            $.ajax({
                                url: 'ajax-getdata',
                                data:
                                    {
                                        level:level,board:board,subject:subject,standard:standard,
                                        questionText:questionValues,
                                        ansValues: ansValues,
                                        ansCorrection: ansCorrection, 
                                        action: 'QnAPost'
                                    },
                                type: 'POST',
                                success: function (data) {
                                   alert(data);
                                   location.reload();
                                }

                            }); //ajax end here
                    } //confirmation box end here

                } //checkbox closed here
            

            }); //onlick end here

        });


    }); 