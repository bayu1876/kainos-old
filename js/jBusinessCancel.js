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

            $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
            $(this).addClass('current'); // Add class "current" to clicked tab
            var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
            $(currentTab).siblings().hide(); // Hide all content divs
            $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
            return false;
        }
    );

$("#startdate").datepicker({dateFormat:'dd-mm-yy'});
$("#enddate").datepicker({dateFormat:'dd-mm-yy'});
    $("input#statusloss").change(function(){
        var statusloss = $(this).attr('checked');
        var statusremove = $("input#statusremove").attr('checked');
//        $.ajax({
//            type:"POST",
//            url: site_url+"report/get_reportbusinesscancel",
//            data:({statusloss:statusloss,statusremove:statusremove}),
//            dataType:"html",
//            success: function(data){
//                $('#containerreportcancel').html(data);
//            },
//            beforeSend: function(){
//                $('#containerreportcancel').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
//            }
//        });
        $.ajax({
            type:"POST",
            url: site_url+"report/get_cancelreason2",
            data:({statusloss:statusloss,statusremove:statusremove}),
            dataType:"html",
            success: function(data){
                $('#containercancelreason').html(data);
            },
            beforeSend: function(){
                $('#containercancelreason').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#statusremove").change(function(){
        var statusremove = $(this).attr('checked');
        var statusloss =  $("input#statusloss").attr('checked');
//        $.ajax({
//            type:"POST",
//            url: site_url+"report/get_reportbusinesscancel",
//            data:({statusloss:statusloss,statusremove:statusremove}),
//            dataType:"html",
//            success: function(data){
//                $('#containerreportcancel').html(data);
//            },
//            beforeSend: function(){
//                $('#containerreportcancel').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
//            }
//        });

        $.ajax({
            type:"POST",
            url: site_url+"report/get_cancelreason2",
            data:({statusloss:statusloss,statusremove:statusremove}),
            dataType:"html",
            success: function(data){
                $('#containercancelreason').html(data);
            },
            beforeSend: function(){
                $('#containercancelreason').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })


    $("select#cancelreason").live('change',function(){
         var cancelreason = $("select#cancelreason").val();
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
          var property = $("select#property").val();
        var salesgroup = $("select#salesgroup").val();
         $.ajax({
            type:"POST",
            url: site_url+"report/get_reportbusinesscanceldetail",
//            data:({cancelreason:cancelreason,startdate:startdate,enddate:enddate}),
            data:({cancelreason:cancelreason,
                   startdate:startdate,
                   enddate:enddate,
                   salesgroup:salesgroup,
                   property:property }),
            dataType:"html",
            success: function(data){
                $('#containerreportcancel').html(data);
            },
            beforeSend: function(){
                $('#containerreportcancel').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#startdate").change(function(){
        var cancelreason = $("select#cancelreason").val();
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
          var property = $("select#property").val();
        var salesgroup = $("select#salesgroup").val();
         $.ajax({
            type:"POST",
            url: site_url+"report/get_reportbusinesscanceldetail",
//            data:({cancelreason:cancelreason,startdate:startdate,enddate:enddate}),
            data:({cancelreason:cancelreason,
                   startdate:startdate,
                   enddate:enddate,
                   salesgroup:salesgroup,
                   property:property }),
            dataType:"html",
            success: function(data){
                $('#containerreportcancel').html(data);
            },
            beforeSend: function(){
                $('#containerreportcancel').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#enddate").change(function(){
        var cancelreason = $("select#cancelreason").val();
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
        var property = $("select#property").val();
        var salesgroup = $("select#salesgroup").val();
         $.ajax({
            type:"POST",
            url: site_url+"report/get_reportbusinesscanceldetail",
//            data:({cancelreason:cancelreason,startdate:startdate,enddate:enddate}),
             data:({cancelreason:cancelreason,
                   startdate:startdate,
                   enddate:enddate,
                   salesgroup:salesgroup,
                   property:property }),
            dataType:"html",
            success: function(data){
                $('#containerreportcancel').html(data);
            },
            beforeSend: function(){
                $('#containerreportcancel').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })



    $("select#property").change(function(){
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
        var property = $(this).val();
        var salesgroup = $("select#salesgroup").val();
        var cancelreason = $("select#cancelreason").val();
         $.ajax({
            type:"POST",
            url: site_url+"report/get_reportbusinesscanceldetail",
            data:({cancelreason:cancelreason,
                   startdate:startdate,
                   enddate:enddate,
                   salesgroup:salesgroup,
                   property:property }),
            dataType:"html",
            success: function(data){
                $('#containerreportcancel').html(data);
            },
            beforeSend: function(){
                $('#containerreportcancel').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

    $("select#salesgroup").change(function(){
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
        var salesgroup = $(this).val();
        var property = $("select#property").val();
        var cancelreason = $("select#cancelreason").val();
         $.ajax({
            type:"POST",
            url: site_url+"report/get_reportbusinesscanceldetail",
            data:({cancelreason:cancelreason,
                   startdate:startdate,
                   enddate:enddate,
                   salesgroup:salesgroup,
                   property:property }),
            dataType:"html",
            success: function(data){
                $('#containerreportcancel').html(data);
            },
            beforeSend: function(){
                $('#containerreportcancel').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

   
});


  