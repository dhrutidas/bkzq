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
            if($('#QueTxt').val() != ''){
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
                     $(this).multiselect({ includeSelectAllOption: true,enableFiltering:true,numberDisplayed:1   });
            });
            $("select[name=inputSubject]").each(function () {
                     $(this).multiselect({ includeSelectAllOption: true,enableFiltering:true,numberDisplayed:1   });
            });
            $("select[name=inputStandard]").each(function () {
                     $(this).multiselect({ includeSelectAllOption: true,enableFiltering:true,numberDisplayed:1   });
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
                                   window.open('./Question-preview/'+result.Qid);
                                   location.reload();
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
       window.opener.location.reload();
    }
});
}
}
