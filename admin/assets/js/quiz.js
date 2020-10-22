$(document).ready(function () {

    //this will trigger to load the chapter in subject load
    $("#inputSubject").change(function(){
        var subjectId = $("#inputSubject").val();
        if(subjectId != ""){
            var dropdowndata = "<option value=''>----Select----</option>"; 
            $.ajax({
                method: 'post', 
                dataType: "json",
                url: "ajax-get-chapter", 
                data: {subjectid: subjectId}, 
                success: function (result)
                {
                    $.each(result, function(i, obj) {
                      //use obj.id and obj.name here, for example:
                      dropdowndata += '<option value="'+obj.chapterID+'" >'+obj.chapterName+'</option>'
                    });
                    //alert(result);
                    $("#inputChapter").empty();
                    $("#inputChapter").html(dropdowndata);

                }
            });

        }else{
            $("#inputChapter").html('<option value="">----Select----</option>');
            $("#inputLevel").html('<option value="">----Select----</option>');
            $("#inputStage").html('<option value="">----Select----</option>');
        }
    });

    //this is will in changes of chapter
    $("#inputChapter").change(function(){
        var subjectVal = $("#inputSubject").val();
        var chapterVal = $("#inputChapter").val();
        if(chapterVal != ""){

            $.ajax({
                method: 'post', 
                dataType: "json",
                url: "ajax-get-subject-stage-level", 
                data: {subjectID: subjectVal,chapterID: chapterVal}, 
                success: function (result)
                {
                    //alert(result);
                    $("#inputLevel").html('<option value="'+result[0]['levelID']+'" SELECTED >'+result[0]['levelName']+'</option>');
                    $("#inputStage").html('<option value="'+result[0]['stageID']+'" SELECTED >'+result[0]['stageName']+'</option>');

                }
            });

        }else{
            $("#inputLevel").html('<option value="">----Select----</option>');
            $("#inputStage").html('<option value="">----Select----</option>');
        }
    });

    $("#inputStandard").change(function(){
        var standardId = $("#inputStandard").val();
        if(standardId != ""){
            var dropdowndata = "<option value=''>----Select----</option>"; 
            $.ajax({
                method: 'post', 
                dataType: "json",
                url: "ajax-get-chapter", 
                data: {standardId: standardId}, 
                success: function (result)
                {
                    $.each(result, function(i, obj) {
                      //use obj.id and obj.name here, for example:
                      dropdowndata += '<option value="'+obj.chapterID+'" >'+obj.chapterName+'</option>'
                    });
                    //alert(result);
                    $("#inputChapter").empty();
                    $("#inputChapter").html(dropdowndata);

                }
            });

        }else{
            $("#inputChapter").html('<option value="">----Select----</option>');
            $("#inputLevel").html('<option value="">----Select----</option>');
            $("#inputStage").html('<option value="">----Select----</option>');
        }
    });
});
