$(document).ready(function () {

    initial_functions();
    
    $("#cmp_type_selection").change(cmp_type_product);
    $("#category_selection").change(product_cmp_type);
    
    $("#select_tat_complaint_type").change(load_complaint_type_tat_analysis);
    $("#select_tat_product_cat").change(load_product_cat_tat_analysis);
    $("#select_tat_channel").change(load_channel_tat_analysis);
    $("#cmp_status").change(container_sub_cat);
    
    $("#region").change(function(){
        
        var aID = $('#nav_tabs .active a').attr('href').substring(1);
        
        if( aID === "Category" ){ cmp_type_product(); product_cmp_type(); }
        
        else if( aID === "Product" ){ container_sub_cat(); }
        
        else if( aID === "Channel" ){ container_channel(); }
        
        else if( aID === "TAT" ){ load_complaint_type_tat_analysis(); load_product_cat_tat_analysis(); load_channel_tat_analysis(); }
        
        initial_functions();
    
    });
           
    $("#href_category").click(function(){
        
        cmp_type_product();
        product_cmp_type();
    });
    
    $("#href_product").click(container_sub_cat);
    $("#href_channel").click(container_channel);
    
    $("#href_tat").click(function(){ 
        
        load_complaint_type_tat_analysis();
        load_product_cat_tat_analysis();
        load_channel_tat_analysis();
    });
   
});

function initial_functions(){
    
    bar_chart();    
    cmp_type_product();
    product_cmp_type();
}

function bar_chart() {
    
    var region = document.getElementById('region').value;
    
    $.ajax({
        method: 'post',
        url: "home-graph-data", 
        data: {selected_region: region}, 
        success: function (result)
        {
            var results_array = result.split('!~!');
            var complaint_type = results_array[0].split('~');
            var open = results_array[1].split('~').map(function (item) {
                return parseInt(item, 10);
            });
            var closed = results_array[2].split('~').map(function (item) {
                return parseInt(item, 10);
            });
            var resolved = results_array[4].split('~').map(function (item) {
                return parseInt(item, 10);
            });

            $('#container').highcharts({
                title: {text: null},
                xAxis: {categories: complaint_type},
                chart: {height: 400},
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {textShadow: '0 0 3px black'}
                },
                labels: {items: [{style: {left: '50px', top: '18px', color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'}}]},
                series: [{type: 'column', name: 'Open', data: open},
                    {type: 'column', name: 'Closed', data: closed},
                    {type: 'column', name: 'Resolved', data: resolved}]
            });

            var open_total = 0;
            $.each(open, function () {
                open_total += this;
            });
            var closed_total = 0;
            $.each(closed, function () {
                closed_total += this;
            });
            var resolved_total = 0;
            $.each(resolved, function () {
                resolved_total += this;
            });

            var total = eval(open_total + closed_total + resolved_total);

            $('#closed_num').text(closed_total);
            $('#closed_per').text(((closed_total / total) * 100).toFixed(2) + '%');
            $('#open_num').text(open_total);
            $('#open_per').text(((open_total / total) * 100).toFixed(2) + '%');
            $('#resolved_num').text(resolved_total);
            $('#resolved_per').text(((resolved_total / total) * 100).toFixed(2) + '%');

            $('#container_all').highcharts({
                credits: {enabled: false},
                title: {text: null},
                chart: {height: 235 },
                plotOptions: {
                    pie: {size: '100%',
                        dataLabels: {enabled: true, formatter: function () {
                                return Math.round(this.percentage * 100) / 100 + ' %';
                            }, distance: -20}
                    }
                },
                series: [{
                        type: 'pie',
                        name: 'Total Complaint',
                        data: [{name: 'Open', y: open_total, color: Highcharts.getOptions().colors[0]},
                            {name: 'Closed', y: closed_total, color: Highcharts.getOptions().colors[1]},
                            {name: 'Resolved', y: resolved_total, color: Highcharts.getOptions().colors[2]}]
                    }]
            });
        }
    });
}

function cmp_type_product() {
    
    var region = document.getElementById('region').value;
    var cmp_type_selection = document.getElementById('cmp_type_selection').value;
    $.ajax({method: 'post', url: "home-pie-chart-left-data", data: {selected_region: region, complaint_type: cmp_type_selection}, success: function (result)
        {
            var results_array = result.split('!~!');
            var categories = results_array[0].split('~');
            var sum_of_category = results_array[1].split('~').map(function (item) {
                return parseInt(item, 10);
            });
            var data_array = [];
            for (var i = 0; i <= (categories.length - 1); i++)
            {
                var res = {name: categories[i], y: sum_of_category[i], color: Highcharts.getOptions().colors[i]};
                data_array.push(res);
            }
            $('#cmp_type_product').highcharts({
                credits: {enabled: false},
                title: {text: null},
                chart: {height: 300},
                plotOptions: {
                    pie: {
                        size: '100%',
                        dataLabels: {enabled: true, formatter: function () {
                                return Math.round(this.percentage * 100) / 100 + ' %';
                            }, distance: -30},
                        allowPointSelect: true,
                        cursor: 'pointer',
                        showInLegend: true
                    }
                },
                series: [{
                        type: 'pie',
                        name: 'Total Complaint',
                        data: data_array
                    }]
            });
        }});
}

function product_cmp_type() {
    
    var region = document.getElementById('region').value;
    var category_selection = document.getElementById('category_selection').value;
    
    $.ajax({method: 'post', url: "home-pie-chart-right-data", data: {selected_region: region, category: category_selection}, success: function (result)
        {
            var results_array = result.split('!~!');
            var categories = results_array[0].split('~');
            var sum_of_category = results_array[1].split('~').map(function (item) {
                return parseInt(item, 10);
            });
            var data_array = [];
            for (var i = 0; i <= (categories.length - 1); i++)
            {
                var res = {name: categories[i], y: sum_of_category[i], color: Highcharts.getOptions().colors[i]};
                data_array.push(res);
            }
            $('#product_cmp_type').highcharts({
                credits: {enabled: false},
                title: {text: null},
                chart: {height: 300},
                plotOptions: {
                    pie: {
                        size: '100%',
                        dataLabels: {enabled: true, formatter: function () {
                                return Math.round(this.percentage * 100) / 100 + ' %';
                            }, distance: -30},
                        allowPointSelect: true,
                        cursor: 'pointer',
                        showInLegend: true
                    }
                },
                series: [{
                        type: 'pie',
                        name: 'Total Complaint',
                        data: data_array
                    }]
            });
        }});
}

function container_sub_cat(){
    
    var region = document.getElementById('region').value;
    var cmp_status = document.getElementById('cmp_status').value;
    
    $.ajax({method: 'post', url: "home-bar-sub-cat-graph-data", data: {selected_region: region, status: cmp_status}, success: function (result)
        {
            var results_array = result.split('!~!');
            var complaint_type = results_array[0].split('~');
            var open = results_array[1].split('~').map(function (item) {
                return parseInt(item, 10);
            });
            $('#container_sub_cat').highcharts({
                title: {text: null},
                chart: {height: 300},
                xAxis: {categories: complaint_type},
                labels: {items: [{style: {left: '50px', top: '18px', color: (Highcharts.theme && Highcharts.theme.textColor) || 'black'}}]},
                series: [{type: 'column', name: cmp_status, data: open}]
            });
        }
    });
}

function container_channel() {
    
    var region = document.getElementById('region').value;
    
    $.ajax({method: 'post', url: "home-bar-channel-cmp-type-data", data: {selected_region: region}, success: function (result) {

            var explodeResult = result.split("!~!");
            var explodeNames = explodeResult[2].split("~");
            var explodeValues = explodeResult[0].split("~");
            var complaint_type_name_new = explodeResult[4].split(',');
            var newString = [];
            var newStringB = [];
            for (var i = 0; i < explodeNames.length; i++) {

                var newStringB = [];
                newStringB['name'] = explodeNames[i];
                newStringB['data'] = explodeValues[i].split(",").map(function (item) {
                    return parseInt(item, 10);
                });
                newString.push(newStringB);
            }
            $('#container_channel').highcharts({
                chart: {type: 'column', height: 300},
                title: {text: null},
                xAxis: {categories: complaint_type_name_new},
                yAxis: {
                    min: 0, title: {text: 'Values'},
                    stackLabels: {
                        enabled: true,
                        style: {fontWeight: 'bold', color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'}
                    }
                },
                plotOptions: {
                    column: {
                        stacking: 'normal',
                        dataLabels: {
                            enabled: true,
                            color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                            style: {textShadow: '0 0 3px black'}
                        }
                    }
                },
                series: newString
            });
        }
    });
}

//@shrikant mavlankar #08092015
function load_complaint_type_tat_analysis() {

    var s_region = $("#region").val();
    var s_comtype = $("#select_tat_complaint_type").val();

    //Complaint type
    $.ajax({
        url: 'ajax-load-complaint-type-tat',
        method: 'POST',
        dataType: 'json',
        data: {region_val: s_region, comp_type_val: s_comtype},
        success: function (data) {

            //$("#container_tat_complaint_type").html(data);

            if (data.early !== "N") {

                $('#container_tat_complaint_type').highcharts({
                    credits: {enabled: false},
                    title: {text: null},
                    chart: {height: 300},
                    plotOptions: {
                        pie: {
                            size: '100%',
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    return Math.round(this.percentage * 100) / 100 + ' %';
                                },
                                distance: -30
                            },
                            allowPointSelect: true,
                            cursor: 'pointer',
                            showInLegend: true
                        }
                    },
                    series: [{
                            type: 'pie',
                            name: 'Total Complaint',
                            data: [
                                {name: "Early", y: data.early},
                                {name: "On Time", y: data.on_time},
                                {name: "Late", y: data.late}
                            ]
                        }]
                });
            }
            else {
                $("#container_tat_complaint_type").html("<p>Records not found.</p>");
            }
        }
    });
}

//@shrikant mavlankar #09092015
function load_product_cat_tat_analysis() {

    var s_region = $("#region").val();
    var s_prodtype = $("#select_tat_product_cat").val();

    //Product Category
    $.ajax({
        url: 'ajax-load-product-category-tat',
        method: 'POST',
        dataType: 'json',
        data: {region_val: s_region, prod_cat_val: s_prodtype},
        success: function (data) {

            //$("#container_tat_product_cat").html(data);

            if (data.early !== "N") {

                $('#container_tat_product_cat').highcharts({
                    credits: {enabled: false},
                    title: {text: null},
                    chart: {height: 300},
                    plotOptions: {
                        pie: {
                            size: '100%',
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    return Math.round(this.percentage * 100) / 100 + ' %';
                                },
                                distance: -30
                            },
                            allowPointSelect: true,
                            cursor: 'pointer',
                            showInLegend: true
                        }
                    },
                    series: [{
                            type: 'pie',
                            name: 'Total Complaint',
                            data: [
                                {name: "Early", y: data.early},
                                {name: "On Time", y: data.on_time},
                                {name: "Late", y: data.late}
                            ]
                        }]
                });
            }
            else {
                $("#container_tat_product_cat").html("<p>Records not found.</p>");
            }
        }
    });
}

//@shrikant mavlankar #09092015
function load_channel_tat_analysis() {

    var s_region = $("#region").val();
    var s_channel = $("#select_tat_channel").val();
    
    //Channel
    $.ajax({
        url: 'ajax-load-channel-tat',
        method: 'POST',
        dataType: 'json',
        data: {region_val: s_region, channel_val: s_channel},
        success: function (data) {

            //$("#container_tat_channel").html(data);

            if (data.early !== "N") {
                
                $('#container_tat_channel').highcharts({
                    credits: {enabled: false},
                    title: {text: null},
                    chart: {height: 300},
                    plotOptions: {
                        pie: {
                            size: '100%',
                            dataLabels: {
                                enabled: true,
                                formatter: function () {
                                    return Math.round(this.percentage * 100) / 100 + ' %';
                                },
                                distance: -30
                            },
                            allowPointSelect: true,
                            cursor: 'pointer',
                            showInLegend: true
                        }
                    },
                    series: [{
                            type: 'pie',
                            name: 'Total Complaint',
                            data: [
                                {name: "Early", y: data.early},
                                {name: "On Time", y: data.on_time},
                                {name: "Late", y: data.late}
                            ]
                        }]
                });
            }
            else {
                $("#container_tat_channel").html("<p>Records not found.</p>");
            }
        }
    });
}
