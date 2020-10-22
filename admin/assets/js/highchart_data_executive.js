$(document).ready(function () {
  //for Executive
        Highcharts.chart('executive_status', {
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
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Questions counts'
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                        this.point.y + ' ' + this.point.name.toLowerCase();
                },
                
            }
        });
});



