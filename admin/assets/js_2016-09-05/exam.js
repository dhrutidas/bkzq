$(document).ready(function () {
    
    $("#next,#skip").click(function(){
        
        var questionId = $('#questionId').val();
        var indexId = $('#indexId').val();
        var currentID  = this.id;
        var correctAns = 0;
       if( (currentID == 'next') && ($('input[name=optradio]:checked').length<=0) ){
             alert("Please select one of the answer.");
             return false;
        }else{
            if(currentID == 'next'){
                correctAns = $("#onlineQuiz input[name=optradio]:checked").val();
            }else{
                correctAns = 0;
            }
            $.ajax({
                dataType: "json",
                method: 'post',
                url: "next-question-data", 
                data: {currentQuestionId: questionId,currentIndexId: indexId,buttonID: currentID,correctOption: correctAns}, 
                success: function (result)
                 {
                    var skipStatus = result['skipStatus'];
                    var maxStatus = result['maxStatus'];
                    // if(skipStatus == 'N'){
                    //     alert("You can't skip this Question.");
                    //     return false;
                    // }else{
                        //if for remove the skip button
                    if(skipStatus == 'N'){
                        $("#skipDiv").text('');
                    }
                    //alert(maxStatus);
                    if(maxStatus == 'N'){
                        $("#nextDiv").html('<button type="submit" class="btn btn-primary" id="submit">Submit</button>');
                    }

                    $('#questionId').val(result['questionId']);
                    $('#indexId').val(result['first_key']);
                    $('#question').text(result['question']);
                    
                    var response  = result['options'];
                    // Now the two will work
                    var cnt = 0;
                    for (var i in response) {
                        cnt++;
                        var option = '#option'+cnt;
                        
                        var data = '<input type="radio" name="optradio" id="option'+cnt+'" value="'+i+'"><div id="label'+cnt+'">'+response[i]+'</div>';
                        $('#label'+cnt).html(data);
                    }
                    //} //end the if loop
                    
                 }
                }); //ajax end here
            }
        }); 
        
        $("#inputLevel").change(function(){
            var selectedVal = $("#inputLevel").val();
            $.ajax({
                method: 'post', 
                url: "ajax-get-stage", 
                data: {level: selectedVal}, 
                success: function (result)
                {
                    
                    $('#inputStage').html(result);
                }
            });    
        });
    $("#reset").click(function(){
        $('input[name="optradio"]').attr('checked', false);
    });

});
