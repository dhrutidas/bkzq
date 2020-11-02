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

        $(document).on('click', '#addques',function (){
            var ipval = $('#QueTxt').val();
            if($('#QueTxt').val() != ''){
                $.ajax({
                    url: 'ajax-question-count',
                    data: {value: ipval, action: 'getsearchdata', match: 'none'},
                    type: 'POST',
                    success: function (data) {                      
                       if(data){
                           if(parseInt(data) > 0){
                            if(!confirm("Question is duplicate.\nDo you still want to proceed further ?")){
                                return false;
                              }
                           }
                           allowAddQuestion();
                       }
                      
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
                    + '<div class="col-md-4"><input type="text" name="ansimg" id="ansimg'+cnt+'" class="ansimg" onclick="openTab(this);"></div>'
                    + '<div class="col-md-1"><input type="checkbox" class="anschk" name="newans"></div></div>');
                cnt++;
                $("#rowCount").val(cnt);
            }
            if(cnt === 5){
                $("#adbtn").hide();
            }
        });

        $('#level-select').change(function() {
            var levelId = $(this).val();
            $.ajax({
                url: 'get-level-stage-html',
                data: {levelID: levelId},
                dataType: "json",
                type: 'POST',
                success: function (data) {
                    $('#section-level').html('');
                    if (data.error){
                        $('#section-level').html('');
                    }
                    if(data.success){
                        $('#section-level').append(data.html);
                         $(".multiselect-ui").multiselect({
                             includeSelectAllOption: true
                         })
                    }
                  
                }

            });
            // var getDropdown_levelID = $(this).val();
            // var getDropdown_levelID_array = $.map(getDropdown_levelID, function(i){
            //     return `#level_stage_${i}`;
            // });

            // var getDropdown_levelID_array_toString = getDropdown_levelID_array.toString();

            // $(".toogleStageSec").removeClass("toogleStageSec_show");
            // $(getDropdown_levelID_array_toString).addClass("toogleStageSec_show");
        });
        $('#select-subject').change(function() {
            var subjectID = $(this).val();
            $.ajax({
                url: 'get-chapter-subject-html',
                data: {subjectID: subjectID},
                type: 'POST',
                dataType: "json",
                success: function (data) {
                    $('#chapter-level').append(data);
                   // $('#multiselect-ui').multiselect('reload'); 
                    $(".multiselect-ui").multiselect({
                        includeSelectAllOption: true
                    })
                    $('#chapter-level').html('');
                    if (data.error){
                        $('#chapter-level').html('');
                    }
                    if(data.success){
                        $('#chapter-level').append(data.html);
                         $(".multiselect-ui").multiselect({
                             includeSelectAllOption: true
                         })
                    }
                }

            });
        });
        $("#question_next").click(function () {
            var data_id = $(this).attr('data-id');
			var data_step = $(this).attr('data-step');
			var data_num = $(this).attr('data-num');
			var data_name = $(this).attr('data-name');

			
            event.preventDefault();
            $.ajax({

                url: $("#question_basic").closest('form').attr('action'),

                type: $("#question_basic").closest('form').attr('method'),

                dataType: "json",

                data: $('#question_basic').serialize(),

                success: function(data) {
                    if (data.error) {
                        $('#question_text_error').html('');
                        $('#options_error').html('');
                        $('#answer_error').html('');
                        if (data.question_text_error != '') {
                            $('#question_text_error').html(data.question_text_error);
                        } else {
                            $('#question_text_error').html('');
                        }
                        if (data.options_error != '') {
                            $('#options_error').html(data.options_error);
                        } else {
                            $('#options_error').html('');
                        }
                        if (data.answer_error != '') {
                            $('#answer_error').html(data.answer_error);
                        } else {
                            $('#answer_error').html('');
                        }
                        
                    }
                    if (data.success) {
                       
                        $('#inputAffLastName_error').html('');
                        $('#options_error').html('');
                        $('#answer_error').html('');
                       
                        $(".stepping").removeClass("active");

                        if (data_name == 'prev') {
                            $(`#step${parseInt(data_num) - 1}`).addClass("active");
                        }
                        else if (data_name == 'next' || data_name == 'skip') {
                            $(`#step${parseInt(data_num) + 1}`).addClass("active");
                        }
                        else {
                            alert("submit")
                        }
                    }
                }

            });
            
        });
        $("#submit-btn").click(function () {
           
            event.preventDefault();
            $.ajax({

                url: 'save-question',

                type: $("#question_basic").closest('form').attr('method'),

                dataType: "json",

                data: $('#question_basic').serialize(),

                success: function(data) {
                    
                    if (data.error) {
                        $('#error_level').html('');
                        $('#error_subject').html('');
                        $('#error_standard').html('');
                        if (data.error_level != '') {
                            $('#error_level').html(data.error_level);
                        } else {
                            $('#error_level').html('');
                        }
                        if (data.error_subject != '') {
                            $('#error_subject').html(data.error_subject);
                        } else {
                            $('#error_subject').html('');
                        }
                        if (data.error_standard != '') {
                            $('#error_standard').html(data.error_standard);
                        } else {
                            $('#error_standard').html('');
                        }
                        
                    }
                    if (data.success) {
                       
                        window.location.href='qm';
                    }
                }

            });
            
        });
        $('input[type=checkbox]').change(function() {
            checkboxLimit = 1;
            if ($('input[type=checkbox]:checked').length >= checkboxLimit) {
                $('input[type=checkbox]').each(function(o) {
                    if ($(this).is(":checked") == false)
                        $(this).prop("disabled", true);
                });
            } else {
                $('input[type=checkbox]').each(function(o) {
                    $(this).prop("disabled", false);
                });
            }


        });
        $(document).on('click', '#increaseOptionBtn', function () {
            var cnt = parseInt($("#optionsrowCount").val());
            if(cnt < 6){
               
                $('#increasingFeilds_Wrap').append('<div class="row align-center-row marb10">'
                    + '<div class="col-sm-10"><input type="text" class="form-control" name="options['+cnt+']" id="options_'+cnt+'"></div>'
                    + '<div class="col-sm-2"><input type="checkbox" name="answer['+cnt+']" id="answer_'+cnt+'"></div>'
                    + '</div>');
                    cnt++;
                $("#optionsrowCount").val(cnt);
            }
            if(cnt === 5){
                $("#increaseOptionBtn").hide();
            }
       
        });
		$(document).on('click', '#addButtonTag', function () {
            var cnt_tag = parseInt($("#rowCount_tag").val());
            if(cnt_tag < 11){
				$.ajax({
						url: 'ajax-getdata-tag',
						type: 'GET',
						success: function (data) {
						$('#question_tag').append('<div class="col-md-6">Tag '+cnt_tag+' : '+data+'</div>');
						cnt_tag++;
						$("#rowCount_tag").val(cnt_tag);
              $("select[name=inputLevel]").each(function () {
                       $(this).multiselect({ includeSelectAllOption: true,enableFiltering:true,enableCaseInsensitiveFiltering: true,numberDisplayed:1  });
              });
              $("select[name=inputSubject]").each(function () {
                       $(this).multiselect({ includeSelectAllOption: true,enableFiltering:true,enableCaseInsensitiveFiltering: true,numberDisplayed:1   });
              });
              $("select[name=inputStandard]").each(function () {
                       $(this).multiselect({ includeSelectAllOption: true,enableFiltering:true,enableCaseInsensitiveFiltering: true,numberDisplayed:1  });
              });
						}
					});
            }
            if(cnt_tag === 10){
                $("#addButtonTag").hide();
            }
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
            						var boardArr =[];var levelArr =[];
            						var subjectArr =[]; var standardArr =[];
            						var imagePathArr = [];
                        $("input[name=txtans]").each(function () {
                                ansValues.push($(this).val());
                        });
            						$("input[name=ansimg]").each(function () {
                                imagePathArr.push($(this).val());
                        });
                        $("input[name=newans]").each(function () {
                                $valueObject=($(this).is(":checked"))?'Y':'N';
                                ansCorrection.push($valueObject);
                        });
            						$("select[name=inputBoard]").each(function () {
            							       boardArr.push($(this).val());
                        });
            						$("select[name=inputLevel]").each(function () {
            							       levelArr.push($(this).val());
                        });
            						$("select[name=inputSubject]").each(function () {
            							       subjectArr.push($(this).val());
                        });
            						$("select[name=inputStandard]").each(function () {
          							         standardArr.push($(this).val());
                        });

                        var questionValues = $('#QueTxt').val();
                        var questionImage = $('#quesImage').val();
                            $.ajax({
                                url: 'ajax-getdata',
                                data:{
                                        level:levelArr,board:boardArr,subject:subjectArr,standard:standardArr,imagePath:imagePathArr,
                                        questionText:questionValues,
                                        questionImage:questionImage,
                                        ansValues: ansValues,
                                        ansCorrection: ansCorrection,
                                        action: 'QnAPost'
                                    },
                                type: 'POST',
                                success: function (data) {
                                  result=JSON.parse(data);
                                   alert(result.msg);
                                   if(result.status == true){
                                   window.open('./Question-preview/'+result.Qid);
                                   location.reload();
                                  }
                                }

                            }); //ajax end here
                    } //confirmation box end here

                } //checkbox closed here


            }); //onlick end here

        });


    });
function makeItLive(auth)
{
qid=$("#qidhidden").val();

if(!(auth=='Y' || auth=='QA')){
  reason=$("#rejectionReason").val();
  if(reason.trim()==""){
    alert("Rejection reason is required.");
    var callStatus='N';
  }
  else{
    var callStatus='Y';
    dataValue=  {  questionId: qid ,status:'Executive',msg:reason }
  }
}
else {
  var callStatus='Y';
  dataValue=  {  questionId: qid ,status:auth }
}

if(callStatus=='Y'){
$.ajax({
    url: '/admin/Questions/makeItLive',
    data:dataValue,
    type: 'POST',
    success: function (data) {
      result=JSON.parse(data);
       if(result==true){
         alert("Successfully Updated !!!!");
       }
       window.close();
       //Commented out as we don't need to reload the previous page
      // window.opener.location.reload();
    }
});
}
}

function allowAddQuestion(){
    $.ajax({
        url: 'ajax-getdata',
        data: {action: 'getansmenu'},
        type: 'POST',
        success: function (data){
            $('#mbobomb').html(data);
            $('#AnsModal').modal('show');
            $('#quesText').text($('#QueTxt').val());
            $("#rowCount").val(1);
        }
      });
}
