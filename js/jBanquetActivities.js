/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    $("#startdate").datepicker({dateFormat:'dd-mm-yy'});
    $("#enddate").datepicker({dateFormat:'dd-mm-yy'});

    $.ajax({
            type:"POST",
            url:site_url+"report_activities/load_banquet_activities",
             
            cache: true,
            success: function(data){
                $('#databanquetactivities').html(data);
            },
            beforeSend: function(){
                $('#databanquetactivities').html('<img src="'+base_url+'images/ajax-loader.gif" align="absmiddle">Loading...');
            }
        });


    $("input#btnGo").click(function(){
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
        var property = $("select#property").val();
       $.ajax({
            type:"POST",
            url:site_url+"report_activities/get_banquet_activities",
            data:({
                startdate:startdate,
                enddate:enddate,
                property:property
            }),
            cache: true,
            success: function(data){
                $('#databanquetactivities').html(data);
            },
            beforeSend: function(){
                $('#databanquetactivities').html('<img src="'+base_url+'images/ajax-loader.gif" align="absmiddle">Loading...');
            }
        });
        return false;
    })

    
});

