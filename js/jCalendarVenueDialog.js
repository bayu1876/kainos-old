/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
$("#dialogcalendarvenue").dialog({
        autoOpen:false,
        modal:false,
        draggable:true,
        resizable:false,
        height:260,
        width:250
    })

    $("span.detilagendaoff").click(function(){
         $("#dialogcalendarvenue").dialog( 'open');
        var this_id = $(this).attr('id');
        
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_detilcalendarvenueoffering",
            data:({idbanquet:this_id}),
            dataType:"html",
            success: function(data){
                $('#containervenuedetil').html(data);
            },
            beforeSend: function(){
                $('#containervenuedetil').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

    $("span.detilagendaconf").click(function(){
         $("#dialogcalendarvenue").dialog( 'open');
        var this_id = $(this).attr('id');

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_detilcalendarvenueconfirm",
            data:({idbanquet:this_id}),
            dataType:"html",
            success: function(data){
                $('#containervenuedetil').html(data);
            },
            beforeSend: function(){
                $('#containervenuedetil').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

    $("span.detilagendadef").click(function(){
         $("#dialogcalendarvenue").dialog( 'open');
        var this_id = $(this).attr('id');

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_detilcalendarvenuedefinit",
            data:({idbanquet:this_id}),
            dataType:"html",
            success: function(data){
                $('#containervenuedetil').html(data);
            },
            beforeSend: function(){
                $('#containervenuedetil').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })
})
