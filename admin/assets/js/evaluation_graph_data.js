$(document).ready(function () {

/*
    //this will trigger to load the chapter in subject load
    $("#inputMainSubject").change(function(){

        var subjectId = $("#inputMainSubject").val();
        if(subjectId != ""){
            var dropdowndata = "<option value=''>----Select----</option>";
            $.ajax({
                method: 'post',
                dataType: "json",
                url: "ajax-subject-chapter",
                data: {subjectid: subjectId},
                success: function (result)
                {
                    $.each(result, function(i, obj) {
                      //use obj.id and obj.name here, for example:
                      dropdowndata += '<option value="'+obj.chapterID+'" >'+obj.chapterName+'</option>'
                    });
                    //alert(result);
                    $("#inputSubject").empty();
                    $("#inputSubject").html(dropdowndata);

                }
            });

        }else{
            $("#inputSubject").html('<option value="">----Select----</option>');
        }
    });
    */

    function validation() {
        if ($("#inputStudent").val() == '') {
            alert("Please select student name");
            $("#inputStudent").focus();
            return false;
        }
    }

    initial_functions();

    function initial_functions(){

        evaluation_chart();
        //performance_pie_chart();
    }

function evaluation_chart() {

    Highcharts.chart('container', {
    data: {
        table: 'datatable'
    },
    chart: {
        type: 'column'
    },
    title: {
        text: 'Evaluation'
    },
    credits: {
        enabled: false
    },
    yAxis: {
        tickInterval: 10,
        allowDecimals: false,
        title: {
            text: 'Count'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.series.name + '</b><br/>' +
                this.point.y + ' ' + this.point.name.toLowerCase();
        },
        enabled: true
    }
});

}//function end here

}); //document load end here
