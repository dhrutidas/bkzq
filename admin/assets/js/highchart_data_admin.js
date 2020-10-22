$(document).ready(function () {
  loadHighChart();
});


function loadHighChart()
{
      Highcharts.chart('admin_status', {
          data: {
              table: 'datatable'
          },
          chart: {
              type: 'column'
          },
          title: {
              text: ''
          },
          credits: {
              enabled: false
          },
          xAxis: {
              allowDecimals: false,
              minTickInterval: 1
            },
          yAxis: {
              allowDecimals: false,
              title: {
                  text: 'User counts'
              }
          },
          tooltip: {
              formatter: function () {
                  return '<b>' + this.series.name + '</b><br/>' +
                      this.point.y + ' ' + this.point.name.toLowerCase();
              },
              enabled: false
          }
      });
}
