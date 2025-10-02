/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    $("#startfilter").datepicker({
        dateFormat: 'dd-mm-yy',minDate:0
    });

    $("#endfilter").datepicker({
        dateFormat: 'dd-mm-yy',minDate:0
    });

    
    $("#btnShowing").click(function(){
        var start = $("#startfilter").val();
        var end = $("#endfilter").val();
        var sales = $("#salesfilter").val();
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/filter_offering",
            
            data:({
                start:start,
                end:end,
                sales:sales 
            }),
            dataType:'html',
            success: function(data){
                $("#dataofferingletter").html(data);
                
              
            },
            beforeSend: function(){
                $("#dataofferingletter").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });
        return false;
    })
    
     $("#btnShowAll").click(function(){
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/loading_data_offering",
            cache: false,
            success: function(data){
                $("div#dataofferingletter").html(data);
            },
            beforeSend: function(){
                $("div#dataofferingletter").html('<img src="'+base_url+'images/loading.gif"/> Loading...');
            }
        });
        return false;
    })
    
    
    
    
    
    
    
    $("#dialoginforoom").dialog({
        autoOpen:false,
        modal:false,
        draggable:true,
        resizable:true,
        height:360,
        width:850
    })

    $("#letter_checkout").change(function(){
        var property = $("#property").val();
        var checkin = $("#letter_checkin").val();
        var checkout = $("#letter_checkout").val();
        var event = $("#eventtype").val();
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_roominformation",
            cache: true,
            data:({
                property:property,
                checkindate:checkin,
                checkoutdate:checkout,
                eventtype:event
            }),
            dataType:'html',
            success: function(data){
                $("#dialoginforoom").html(data);
                $("#containerroominfo").html(data);
            },
            beforeSend: function(){
                $("#dialoginforoom").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });
        
       
        if(event != 'RO'){
        $("#dialoginforoom").dialog( 'open');
        }
    })


    $("#letter_checkin").change(function(){
        var property = $("#property").val();
        var checkin = $("#letter_checkin").val();
        var checkout = $("#letter_checkout").val();
        var event = $("#eventtype").val();
        if(event == 'AR' || event == 'BD' || event == 'TM' || event == 'WE'){
            checkout = checkin;
        }
        if(event != 'ME' && event != 'RO'){
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_roominformation",
                cache: true,
                data:({
                    property:property,
                    checkindate:checkin,
                    checkoutdate:checkout,
                    eventtype:event
                }),
                dataType:'html',
                success: function(data){
                    $("#dialoginforoom").html(data);
                    $("#containerroominfo").html(data);
                },
                beforeSend: function(){
                    $("#dialoginforoom").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                }
            });
            $("#dialoginforoom").dialog( 'open');
        }//end if
    })
})
