
$(document).ready(function(){
    if ($('#chartdiv').length){
    var inputs = document.getElementsByTagName("input");
    for (var i=0; i<inputs.length;i++){
        var service= document.getElementsByTagName('input')[i].name;
        addEventListener("load", ajarx(service));
    } }
});

function ajarx(service){
    var data;
    $.ajax({
        url: window.location.origin+'/orders/chart',
        data: { service: service },
        async: false,
        success: function(orders) {
           return data=orders;
        },

    complete:
        function(data){
            var n=$.map(data.responseJSON,function(i){
                return i.service;
            });
            $(n).highcharts({
                chart: {
                    type: 'pyramid',
                    marginRight: 100
                },
                colors: ["#ff3831", "#0000ff", "#fff709", "#32cd32", "#aaeeee", "#ff0066", "#eeaaee",
                    "#55BF3B", "#DF5353", "#7798BF", "#aaeeee"],
                title: {
                    text: '',
                    x: -50
                },
                plotOptions: {
                    pyramid: {
                        reversed:false,
                        depth: 300
                    },
                    series: {
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b> ({point.y:,.0f})',
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                            softConnector: true
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: 'Заявки',
                    data: $.map(data.responseJSON,function(i){
                        return [[i.name,i.data]];
                    })
                }]
            });
        }
    });
    return data;
}
           // var inputs = document.getElementsByTagName("input");
          // var dat=document.getElementsByTagName('div')[3].id;
            //var dat=document.getElementById("chartdiv").nextElementSibling;
            /*$("#chartdiv").each(function(data){
                ch(data);
            });*/
              // console.log(dat);
              //  addEventListener("load", ch(dat));

            //function ch(data){
       /* var chart = AmCharts.makeChart((dat), {
            "type": "funnel",
            "theme": "none",
            "dataProvider":  $.map(data.responseJSON,function(i){
                return {title: i.name, value: i.data};
            }),
            "balloon": {
                "fixedPosition": true
            },
            "description": $.map(data.responseJSON,function(i){
                return i.pro;
            }),
            "valueField": "value",
            "titleField": "title",
            "marginRight": 100,
            "marginLeft": 0,
            "startX": -500,
            "depth3D":100,
            "angle":60,
            "outlineAlpha":1,
            "outlineColor":"#FFFFFF",
            "outlineThickness":2,
            "labelPosition": "right",
            "balloonText": "[[title]]%: [[value]] заявки [[description]]",
            "exportConfig":{
                "menuItems": [{
                    "icon": '/lib/3/images/export.png',
                    "format": 'png'
                }]
            }
        });
    jQuery('.chart-input').off().on('input change',function() {
        var property	= jQuery(this).data('property');
        var target		= chart;
        var value		= Number(this.value);
        chart.startDuration = 0;

        if ( property == 'innerRadius') {
            value += "%";
        }

        target[property] = value;
        chart.validateNow();
    });}*/

/*
$(document).ready(function(){
    if ($('#chartdiv').length){
        var name=document.getElementsByName('name');
        var data=ajarx(name);
    }

});*/



/*function (data) {
 var data = {"success":1,"data":[{"name":"dj","data":250}, {"name":"yu","data":400},{"name":"tr","data":700}]};

 $('#chart').highcharts({
 chart: {
 type: 'pyramid',
 marginRight: 100,
 options3d:{
 alfa: 100,
 depth: 100
 }
 },
 title: {
 text: 'Marketing',
 x: -50
 },
 plotOptions: {
 pyramid: {
 reversed:false

 },
 series: {
 dataLabels: {
 enabled: true,
 format: '<b>{point.name}</b> ({point.y:,.0f})',
 color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
 softConnector: true
 }
 }
 },
 legend: {
 enabled: false
 },
 series: [{
 name: 'Unique users',
 data: $.map(data.data,function(i){
 return [[i.name, i.data]];
 })
 //data: [data]
 }]
 });
 }*/

/*
 $(function (data) {
 var options = {
 chart: {
 type: 'pyramid',
 renderTo: 'chart',
 marginRight: 100
 },
 title: {
 text: 'Activity',
 x: -50
 },
 plotOptions: {
 pyramid: {
 reversed:false
 },
 series: {
 dataLabels: {
 enabled: true,
 format: '<b>{point.name}</b> ({point.y:,.0f})',
 color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
 softConnector: true
 }
 }
 },
 legend: {
 enabled: false
 },
 name: 'Activity Count',
 series: [{}]
 };




 //            {"success":1,"data":[{"name":"new","data":151},{"name":"old","data":351}]}

 // var data = {"success":1,"data":[{"name":"John Spoon","data":300}, {"name":"Dave Jones","data":200},{"name":"Other","data":500}]};

 options.series = [{
 data: $.map(data.data,function(i){
 return [[i.name, i.data]];
 })
 }];

 var chart = new Highcharts.Chart(options);


 })




$(function () {
    var data = [
        { Budget: 30, Department: "Administration" },
        { Budget: 100, Department: "Sales" },
        { Budget: 40, Department: "IT" },
        { Budget: 50, Department: "Marketing" },
        { Budget: 40, Department: "Development" },
        { Budget: 20, Department: "Support" }
    ];

    $(function () {
        //  Create a basic funnel chart
        $("#chartNormal").igFunnelChart({
            width: "100%",  //"325px",
            height: "450px",
            dataSource: data,
            valueMemberPath: "Budget",
            innerLabelMemberPath: "Budget",
            innerLabelVisibility: "visible",
            outerLabelMemberPath: "Department",
            outerLabelVisibility: "visible"
        });
    });
});*/