function graphReLoad(){
  var selectedLevelVal = $("#inputLevel").val();
  var selectedSubjectVal = $("#inputSubject").val();

  var data_array = [];
  $.ajax({
      method: 'POST',
      url: "home/graphData",
      data: { subjectID: selectedSubjectVal, levelID: selectedLevelVal },
      success: function (result)
      {
        $.each( JSON.parse(result), function( key, row ) {
          var onFlyArray = { name:row.chapterName,y:parseInt(row.stageID)};
          //console.log(onFlyArray);
          data_array.push(onFlyArray);
        });
        subjectNew=[{
            name: 'Chapter',
            colorByPoint: true,
            data:data_array
        }];
        subject_bar_chart(subjectNew);
        performance_pie_chart(subjectNew);
      }
  });
}

$(document).ready(function () {
  graphReLoad();
});

function subject_bar_chart(subjectData) {
    // Build the chart for Students
    $('#performance_status').highcharts({
        chart: {  plotBackgroundColor: null,  plotBorderWidth: null,  plotShadow: false,  type: 'pie' },
        title: {  text: ''  },
        tooltip: {  pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'  },
        plotOptions: {
            pie: {  allowPointSelect: true,cursor: 'pointer',dataLabels: {enabled: false},showInLegend: true  }
        },
        series: subjectData
    });
}

function performance_pie_chart(subjectData) {
    $('#level_status').highcharts({
        chart: {  type: 'bar'  },
        title: {  text: null  },
        subtitle: {  text: null  },
        xAxis: {  type: 'category'  },
        yAxis: {  title: {  text: 'Stages'  }  },
        legend: {  enabled: false },
        plotOptions: {  series: {  borderWidth: 0,  dataLabels: {  enabled: true,  format: 'Stage {point.y:1f}'  }  }  },
        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>',
            enabled: false
        },
        series:subjectData
    });
}
