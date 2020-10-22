function question_load(){
  var selectedUserVal = $("#inputUser").val();
  var data_array = [];
  $.ajax({
      method: 'POST',
      url: "Questions/userQuestion",
      data: { userID: selectedUserVal },
      success: function (result)
      {
        $('#loadQuestions').empty();
        $('#countBox').html("<span><strong> No of Questions "+JSON.parse(result).count+"</strong></span>");
        if(JSON.parse(result).count>0){
        $.each( JSON.parse(result).resultSet, function( key, row ) {
          $('#loadQuestions').append('<tr><td>Q.'+(key+1)+'</td><td>'+row.qbID+'</td><td>'+row.questionText+'</td><td><img src="'+row.questionImg+'" hieght="100" width="100"/></td><td>'+row.addedOn+'</td><td><button class="btn btn-primary btn-md" onclick=window.open("./Question-preview/'+row.qbID+'");>Preview</button></td></tr>');
        });
      }
      else {
        $('#loadQuestions').append('<tr><td class="col-md-3" colspan="6"><center>No Record Found</center></td></tr>');
      }
      }
  });
}

$(document).ready(function () {
  question_load();
});
