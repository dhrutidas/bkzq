var timer;

$(document).ready(function () {
    clearTimeout(timer);
    timerQuiz();
    $("#next,#skip").click(function(){

        var questionId = $('#questionId').val();
        var indexId = $('#indexId').val();
        var currentID  = this.id;
        var correctAns = 0;
        var userCorrectAns = "N";

            if(currentID == 'next'){
                correctAns = $("#onlineQuiz input[name=optradio]:checked").val();
                correctAns=(correctAns!=0)?correctAns:0;
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
                    //console.log(result);

                    var imagePath = result['imagePath'];
                    var skipStatus = result['skipStatus'];
                    var maxStatus = result['maxStatus'];
                    var systemCrctAnsID = result['systemCrctAnsID'];


                    if(parseInt(systemCrctAnsID) == parseInt(correctAns)){
                        (currentID == 'next')?loadResultIcon('resultValueIconRight'):'';
                    }else{
                        (currentID == 'next')?loadResultIcon('resultValueIconWrong'):'';
                    }
                    if(currentID == 'submit'){
                        $("#onlineQuiz").submit();
                    }
                    //if for remove the skip button
                    if(skipStatus == 'N'){
                        $("#skipDiv").text('');
                    }
                    //alert(maxStatus);
                    if(maxStatus == 'N'){
                        $("#nextDiv").html('<input type="submit" class="btn btn-primary" id="submit"></button>');
                    }
                    var questionData = '';
                    if(result['questionimage'] != ''){
                        questionData = 'Q'+(result['first_key']+1)+' : <a href="#" class="pop"><img src="'+result['questionimage']+'" class="img-rounded" alt="Question Image" width="80" height="80"></a> '+result['question'];
                    }else{
                        questionData = 'Q'+(result['first_key']+1)+': '+result['question'];
                    }
                    $('#questionId').val(result['questionId']);
                    $('#indexId').val(result['first_key']);
                    $('#question').html(questionData);

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
                            optionData = '<a href="#" class="pop"><img src="'+splitOptionData[1]+'" class="img-rounded" alt="Option Image" width="80" height="80"></a> '+splitOptionData[0];
                        }else{
                            optionData = splitOptionData[0];
                        }

                        var data = '<input type="radio" name="optradio" id="option'+cnt+'" value="'+i+'"><div id="label'+cnt+'">'+optionData+'</div>';
                        $('#label'+cnt).html(data);
                    }
                    //} //end the if loop
                      clearTimeout(timer);
                      timerQuiz();
                 }
                }); //ajax end here
          //  }
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
                        $("#nextDiv").html('<input type="submit" class="btn btn-primary" id="submit"></button>');
                    }
                 }
                }); //ajax end here
        });
});

function timerQuiz(){
secs = 60;
timer = setInterval(function () {
    var element = document.getElementById("timerQuizStatus");
    element.innerHTML = '<h3>'+secs+'</h3>';
    if(secs < 1){
        clearInterval(timer);
        NextElement=document.getElementById('next');
        if(NextElement === null)
        {
            document.getElementById('submit').click();
        }
        else{
          NextElement.click();
        }
    }
    secs--;
}, 1000)
}

function loadResultIcon(resultValueIcon){
    modal = document.getElementById(resultValueIcon);
    modal.style.display = "block";
    setTimeout(function() {
      modal.style.display = "none";
    }, 1500);
}

$(document).on('click', '.pop', function (event) {
    event.preventDefault();
    $('.imagepreview').empty();
    $('.imagepreview').attr('src', $(this).find('img').attr('src'));
    $('#imagemodal').modal('show');
});
