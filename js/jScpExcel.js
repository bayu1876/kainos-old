/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

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
        url: site_url+"scp_excel/load_salescallplanning_dki",
       
        dataType:"html",
        success: function(data){
            $('#datatodolist').html(data);
        },
        beforeSend: function(){
            $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
        }
    });


 

    $("#dateactivities").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#startdatescp").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#enddatescp").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("input#startdatescp").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"scp_excel/get_salescallplanning",
                data:({
                    startdate:$(this).val(),
                    enddate:$("input#enddatescp").val(),
                      salesscp :$("select#salesscp").val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })

      $("input#enddatescp").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"scp_excel/get_salescallplanning",
                data:({
                   enddate :$(this).val(),
                   startdate :$("input#startdatescp").val(),
                   salesscp :$("select#salesscp").val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })


 $("select#salesscp").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"scp_excel/get_salescallplanning",
                data:({
                     enddate :$("input#enddatescp").val(),
                   startdate :$("input#startdatescp").val(),
                    salesscp :$("select#salesscp").val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })



    $("#startdatescphistory").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#enddatescphistory").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#dateactivities").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })

    $("select#startjam").change(function(){
        $("select#endjam").val($(this).val());
    })


   




});