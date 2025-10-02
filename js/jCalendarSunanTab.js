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
            var now = new Date();
            $("#dateinput").val('');
            var property = $("#property").val();
            var currdate = now.getDate();
            var currmonth = now.getMonth() + 1;
            var curryear = now.getFullYear();
            if(currdate < 10){
                currdate = "0" + currdate;
            }

            if(currmonth < 10){
                currmonth = "0" + currmonth;
            }

            $.ajax({
                type:"POST",
                url: site_url+"calendar/get_calendarvenueperproperty_by_date",
                data:({
                    startdate:currdate + "-" + currmonth + "-" + curryear,
                    property:property
                }),
                dataType:"html",
                success: function(data){
                    $('#containercalendarvenue').html(data);
                },
                beforeSend: function(){
                    $('#containercalendarvenue').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
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


    $("#dialogcalendarvenue").dialog({
        autoOpen:false,
        modal:false,
        draggable:true,
        resizable:false,
        height:260,
        width:250
    })

    $("span.detilagendaoff").live('click',function(){
        $("#dialogcalendarvenue").dialog( 'open');
        var this_id = $(this).attr('id');

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_detilcalendarvenueoffering",
            data:({
                idbanquet:this_id
            }),
            dataType:"html",
            success: function(data){
                $('#containervenuedetil').html(data);
            },
            beforeSend: function(){
                $('#containervenuedetil').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

    $("span.detilagendaconf").live('click',function(){
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

    $("span.detilagendadef").live('click',function(){
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

     $("#dateinput").datepicker({
        dateFormat:'dd-mm-yy'
    });

$("#startdate").datepicker({dateFormat:'dd-mm-yy'});
 $("input#btnGo").click(function(){
        var startdate = $("input#startdate").val();
       // var enddate = $("input#enddate").val();
        var property = $("select#propertyvenue").val();
        var venue = $("select#venue").val();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_calendarvenue_by_filter",
            cache: false,
            data:({startdate:startdate,
                  // enddate:enddate,
                   property:property,
                   venue:venue}),
            datatype:"html",
            success: function(data){
                $("#containercalendarvenue").html(data);
            },
            beforeSend: function(){
                $("#containercalendarvenue").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
    })

//    $("input#btnGo").click(function(){
//          var startdate = $("#dateinput").val();
//          var property = $("#property").val();
//
//          $.ajax({
//            type:"POST",
//            url: site_url+"calendar/get_calendarvenueperproperty_by_date",
//            data:({startdate:startdate,property:property}),
//            dataType:"html",
//            success: function(data){
//                $('#containercalendarvenue').html(data);
//            },
//            beforeSend: function(){
//                $('#containercalendarvenue').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
//            }
//        });
//    })
    //

});


  