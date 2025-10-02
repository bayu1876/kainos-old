/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function(){
//Minimize Content Box

$(".content-box-header h3").css({
    "cursor":"s-resize"
}); // Give the h3 in Content Box Header a different cursor
$(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
$(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"

$(".content-box-header h3").click( // When the h3 is clicked...
    function () {
        $(this).parent().next().toggle(); // Toggle the Content Box
        $(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
        $(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
    }
    );

// Content box tabs:

$('.content-box .content-box-content div.tab-content').hide(); // Hide the content divs
$('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
$('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"

$('.content-box ul.content-box-tabs li a').click( // When a tab is clicked...
    function() {
        $.validationEngine.closePrompt('.formError',true);
        $.ajax({
                type:"POST",
                url: site_url+"offering_letter/loading_data_offering",
                cache: true,
                success: function(data){
                    $("#dataofferingletter").html(data);
                },
                beforeSend: function(){
                    $("#dataofferingletter").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
        $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
        $(this).addClass('current'); // Add class "current" to clicked tab
        var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
        $(currentTab).siblings().hide(); // Hide all content divs
        $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
        return false;
    }
    );

 $.ajax({
    type:"POST",
    url: site_url+"offering_letter/loading_data_offering",
    cache: true,
    success: function(data){
        $("#dataofferingletter").html(data);
    },
    beforeSend: function(){
        $("#dataofferingletter").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    }
});




$('select.bedtype').live('change', function() {
       var this_id = $(this).attr('id');
       var property;
       if($('select#property').val() != undefined){
            property = $('select#property').val();
       }

       if($('select#editproperty').val() != undefined){
           property = $('select#editproperty').val();
       }

       var bedtype = $(this).val();
       var roomtype = $("select.roomtypenew[id^="+this_id+"]").val();
       var weektype = $("select.weektypenew[id^="+this_id+"]").val();

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_strucrateroomreq",
            data:({property:property,
                   bedtype:bedtype,
                   roomtype:roomtype,
                   weektype:weektype}),
            cache: true,
            success: function(data){
                $("#refstrucrateroom-"+this_id).html(data);
            },
            beforeSend: function(){
                $("#refstrucrateroom-"+this_id).html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
   });



   $('select.roomstrucnew').live('change', function() {
        var divid = $(this).parent("div").attr('id');
        var this_id = divid.slice(17);

        var property = $("select#editproperty").val();
        var room = $("select.roomtypenew[id^="+this_id+"]").val();
        var week = $("select.weektypenew[id^="+this_id+"]").val();
        var bedtype = $("select.bedtype[id^="+this_id+"]").val();
        var roomstruct = $(this).val();

        var account = $("input#idaccount").val();
      
         
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_roomstrucrate_price",
            data:({
                property:property,
                room:room,
                week:week,
                roomstruc:roomstruct,
                bedtype:bedtype
            }),
            dataType:"html",
            success: function(data){
                //alert(data);
                $("input.ratepernightroom[id^="+this_id+"]").val(data);
                var qtyroom = $("input.qtyroom[id^="+this_id+"]").val();
                var price =  $("input.ratepernightroom[id^="+this_id+"]").val( );
                var night = $("input.nightroom[id^="+this_id+"]").val();
                var total = night * price * qtyroom
                $("input.revenueroom[id^="+this_id+"]").val(total);
               
               //$("input.struct[id^="+this_id+"]").val(data.id);

                var grandtotal = 0;

                $("input.revenueroom").each(function(){

                    grandtotal += parseInt($(this).val());
                });

                $("input#totalroomrevenue").val(grandtotal);

            },
            beforeSend: function(){

            }
        });

         $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_strucrateroom",
            data:({
                property:property,
                room:room,
                week:week,
                account:account

            }),
            dataType:"html",
            success: function(data){
              //  alert(data)
              $("input.struct[id^="+this_id+"]").val(data);

            },
            beforeSend: function(){

            }
        });
    })


    $('select.roomtypenew').live('change', function() {
        var divid = $(this).parent("div").attr('id');
       var this_id = divid.slice(8);
       
       //var this_id = $(this).attr('id');
       var property;
       if($('select#property').val() != undefined){
            property = $('select#property').val();
       }

       if($('select#editproperty').val() != undefined){
           property = $('select#editproperty').val();
       }

       var bedtype = $("select.bedtype[id^="+this_id+"]").val();
       var roomtype = $(this).val();
       var weektype = $("select.weektypenew[id^="+this_id+"]").val();

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_strucrateroomreq",
            data:({property:property,
                   bedtype:bedtype,
                   roomtype:roomtype,
                   weektype:weektype}),
            cache: true,
            success: function(data){
                $("#refstrucrateroom-"+this_id).html(data);
            },
            beforeSend: function(){
                $("#refstrucrateroom-"+this_id).html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
   });


    $('select.weektypenew').live('change', function() {
       var this_id = $(this).attr('id');
       var property;
       if($('select#property').val() != undefined){
            property = $('select#property').val();
       }

       if($('select#editproperty').val() != undefined){
           property = $('select#editproperty').val();
       }

       var bedtype = $("select.bedtype[id^="+this_id+"]").val();
       var roomtype = $("select.roomtypenew[id^="+this_id+"]").val();
       var weektype = $(this).val();

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_strucrateroomreq",
            data:({property:property,
                   bedtype:bedtype,
                   roomtype:roomtype,
                   weektype:weektype}),
            cache: true,
            success: function(data){
                $("#refstrucrateroom-"+this_id).html(data);
            },
            beforeSend: function(){
                $("#refstrucrateroom-"+this_id).html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
   });


});