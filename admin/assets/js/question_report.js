
  $( document ).ready(function() {
    $.ajax({
        url: 'ajax-getdata-tag',
        type: 'GET',
        success: function (data) {
          $('#question_tag').append('<div>'+data+'</div>');
          $('#inputLevel').multiselect({ includeSelectAllOption: true,enableFiltering:true, enableClickableOptGroups:true, enableCollapsibleOptGroups : true });
          $('#inputSubject').multiselect({ includeSelectAllOption: true,enableFiltering:true, enableClickableOptGroups:true, enableCollapsibleOptGroups : true });
          $('#inputStandard').multiselect({ includeSelectAllOption: true,enableFiltering:true  });
        }
      });

      $.ajax({
          url: 'ajax-get-users',
          type: 'GET',
          success: function (result) {
          $.each( JSON.parse(result), function( key, row ) {
            $('#user').append('<option value="'+row.userID+'">'+row.fName+'</option>');
          });
          }
        });
  });
function findQuestions(){
  var selectedUserVal = $("#user").val();
  var levelArr = $("#inputLevel").val();
  var boardArr = $("#inputBoard").val();
  var subjectArr = $("#inputSubject").val();
  var standardArr = $("#inputStandard").val();
  var status = $("#inputStatus").val();

  $.ajax({
      method: 'POST',
      url: "Question_Report/userQuestionSearch",
      data: { userID: selectedUserVal,level:levelArr,board:boardArr,subject:subjectArr,standard:standardArr,status:status },
      success: function (result)
      {
        $('#question-list').empty();
        $('#countBox').html("<span><strong> No of Questions "+JSON.parse(result).count+"/"+JSON.parse(result).rsCountAll+"</strong></span>");
        if(JSON.parse(result).count>0){
        $.each( JSON.parse(result).resultSet, function( key, row ) {
          $('#question-list').append('<tr><td>Q.'+(key+1)+'</td><td>'+row.qbID+'</td><td>'+row.questionText+'</td><td><img src="'+row.questionImg+'" hieght="100" width="100"/></td><td>'+row.addedOn+'</td><td><button class="btn btn-primary btn-md" onclick=window.open("./Question-preview/'+row.qbID+'");>Preview</button></td></tr>');
        });
      }
      else {
        $('#question-list').append('<tr><td class="col-md-3" colspan="6"><center>No Record Found</center></td></tr>');
      }
      }
  });
}
