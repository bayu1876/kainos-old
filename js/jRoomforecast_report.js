/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $("#container_remarkforecast").show();
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
            $("#processingx").html('');
            $.validationEngine.closePrompt('.formError',true);
            $("#processing").html('');
            $.ajax({
                type:"POST",
                url: site_url+"room_forecast/load_roomforecast_currentmonth2",
                cache: true,
                success: function(data){
                    $("#containerforecast").html(data);
                    $(".kolomtotal").hide();
                    $("#container_remarkforecast").show();
                },
                beforeSend: function(){
                    $("#containerforecast").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
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
        url: site_url+"room_forecast/load_roomforecast_currentmonth2",
        cache: true,
        success: function(data){
            $("#containerforecast").html(data);
            $(".kolomtotal").hide();
            $("#container_remarkforecast").show();
        },
        beforeSend: function(){
            $("#containerforecast").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });

    // remark
    var monthroomforecast = $("#month").val();
    var yearroomforecast = $("#year").val();

        // if not, set current date
    if(monthroomforecast == '' && yearroomforecast == '') {
         var d = new Date();
         monthroomforecast = d.getMonth()+1;
         yearroomforecast = d.getFullYear();
    }

    $.ajax({
        type:"POST",
        url: site_url+"room_forecast/load_roomforecastremark_filter2",
        cache: true,
        data:({monthroomforecast:monthroomforecast,yearroomforecast:yearroomforecast}),
        success: function(data){
            $("#container_remarkforecast").html(data);
        },
        beforeSend: function(){
            $("#container_remarkforecast").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });

    // end
    
//iwn split page room forecast

    $('#btnPage1_filter2').click(function(){
        $("#page").val(1);

        var page = $("#page").val();
        var monthroomforecast = $("#month").val();
        var yearroomforecast = $("#year").val();

        // if not, set current date
        if(monthroomforecast == '' && yearroomforecast == '') {
            var d = new Date();
            monthroomforecast = d.getMonth()+1;
            yearroomforecast = d.getFullYear();
        }

        $.ajax({
            type:"POST",
            url: site_url+"room_forecast/load_roomforecast_by_monthyear2",
            data:({page:page,monthroomforecast:monthroomforecast,yearroomforecast:yearroomforecast}),
            success: function(data){

                $("#containerforecast").html(data);
                $(".kolomtotal").hide();
            },
            beforeSend: function(){
                $("#containerforecast").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    });

    $('#btnPage2_filter2').click(function(){
        $("#page").val(2);

        var page = $("#page").val();
        var monthroomforecast = $("#month").val();
        var yearroomforecast = $("#year").val();

        // if not, set current date
        if(monthroomforecast == '' && yearroomforecast == '') {
            var d = new Date();
            monthroomforecast = d.getMonth()+1;
            yearroomforecast = d.getFullYear();
        }

        $.ajax({
            type:"POST",
            url: site_url+"room_forecast/load_roomforecast_by_monthyear2",
            data:({page:page,monthroomforecast:monthroomforecast,yearroomforecast:yearroomforecast}),
            success: function(data){
                $("#containerforecast").html(data);
                $(".kolomtotal").show();
            },
            beforeSend: function(){
                $("#containerforecast").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    });

//

//++
//    $("#formforecastperiod").submit(function(){
//        $.ajax({
//            type:"POST",
//            url: site_url+"room_forecast/add_roomforecast_period",
//            data:$('#formforecastperiod').serialize(),
//            success: function(data){
//                $("#processing").html(data);
//            },
//            beforeSend: function(){
//                $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
//            }
//        });
//        return false;
//++    })
    
    $("#formroomforecast").submit(function(){

    // remark
    var monthroomforecast = $("#month").val();
    var yearroomforecast = $("#year").val();

        // if not, set current date
    if(monthroomforecast == '' && yearroomforecast == '') {
         var d = new Date();
         monthroomforecast = d.getMonth()+1;
         yearroomforecast = d.getFullYear();
    }

    $.ajax({
        type:"POST",
        url: site_url+"room_forecast/load_roomforecastremark_filter2",
        cache: true,
        data:({monthroomforecast:monthroomforecast,yearroomforecast:yearroomforecast}),
        success: function(data){
            $("#container_remarkforecast").html(data);
        },
        beforeSend: function(){
            $("#container_remarkforecast").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });

    // end
    
        var page = $("#page").val();
        $.ajax({
            type:"POST",
            url: site_url+"room_forecast/load_roomforecast_by_monthyear2",
            data:$(this).serialize(),
            success: function(data){
               
                $("#containerforecast").html(data);
                
                if(page == 1){
                    $(".kolomtotal").hide();
                } else {
                    $(".kolomtotal").show();
                }
            },
            beforeSend: function(){
                $("#containerforecast").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })
    
    
    
})