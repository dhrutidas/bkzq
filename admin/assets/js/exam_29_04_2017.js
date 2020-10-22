$(document).ready(function () {
    
    $("#next,#skip").click(function(){
        
        var questionId = $('#questionId').val();
        var indexId = $('#indexId').val();
        var currentID  = this.id;
        var correctAns = 0;
        var userCorrectAns = "N";
        if(currentID == 'next'){
            var con = true;
        }else{
            var con = confirm("Do you want to skip this question?");    
        }
        
    if (con == true) {
            
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

                    var imagePath = result['imagePath'];
                    var skipStatus = result['skipStatus'];
                    var maxStatus = result['maxStatus'];
                    var systemCrctAnsID = result['systemCrctAnsID'];
                    var skipRemaining = (Number(result['canSkip']) - Number(result['skipedCount']) );

                    if(parseInt(systemCrctAnsID) == parseInt(correctAns)){
                        userCorrectAns = "You have given the correct answer.";
                    }else{
                        userCorrectAns = "You have given the incorrect answer.";
                    }
                    if(currentID == 'next'){
                        alert(userCorrectAns);
                        // $("#modal_data").html(userCorrectAns);
                        // $("#viewModal").modal('show');
                        // setTimeout(function() {$('#viewModal').modal('hide');}, 2000);
                    }
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
                    var questionData = '';
                    if(result['questionimage'] != ''){
                        questionData = 'Q'+ (Number(result['first_key'])+1) +': '+result['question']+' <a href="#" class="pop"><img src="'+result['questionimage']+'" class="img-rounded" alt="Question Image" width="80" height="80"></a>';
                    }else{
                        questionData = 'Q'+ (Number(result['first_key'])+1) +': '+result['question'];
                    }
                    $('#questionId').val(result['questionId']);
                    $('#indexId').val(result['first_key']);
                    $('#question').html(questionData);
                    $('#skip').text(skipRemaining);
                    var response  = result['options'];
                    // Now the two will work
                    var cnt = 0;
                    for (var i in response) {
                        cnt++;

                        var optionData = '';
                        var option = '#option'+cnt;
                        
                        //alert(response[i]);
                        var splitOptionData = (response[i]).split('#image#');
                        //alert('data :'+splitOptionData[0]+"== image:"+splitOptionData[1]);
                        if(splitOptionData[1] !== ""){
                            optionData = splitOptionData[0]+' <a href="#" class="pop"><img src="'+splitOptionData[1]+'" class="img-rounded" alt="Option Image" width="80" height="80"></a>';
                        }else{
                            optionData = splitOptionData[0];
                        }

                        var data = '<input type="radio" name="optradio" id="option'+cnt+'" value="'+i+'"><div id="label'+cnt+'">'+optionData+'</div>';
                        $('#label'+cnt).html(data);
                    }
                    //} //end the if loop
                    
                 }
                }); //ajax end here
            }

        }//confirmation box end here

    }); //click function end here 
        
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

        // $("#reset").click(function(){
        //     $('input[name="optradio"]').attr('checked', false);
        // });

        //$("input:radio[name='optradio']").change(function(){
        $('body').on('change', '#option1, #option2, #option3, #option4, #option5', function() {
           $.ajax({
                dataType: "json",
                method: 'post',
                url: "radio-button-validation", 
                data: {},
                success: function (result)
                 {
                    var skipStatus = result['skipStatus'];
                    var maxStatus = result['maxStatus'];
                    //if for remove the skip button
                    if(skipStatus == 'N'){
                        $("#skipDiv").text('');
                    }
                    //alert(maxStatus);
                    if(maxStatus == 'N'){
                        $("#nextDiv").html('<button type="submit" class="btn btn-primary" id="submit">Submit</button>');
                    }
                    
                 }
                }); //ajax end here

        });

});

$(document).on('click', '.pop', function (event) {
    event.preventDefault();
    $('.imagepreview').empty();
    $('.imagepreview').attr('src', $(this).find('img').attr('src'));
    $('#imagemodal').modal('show');   
}); 

