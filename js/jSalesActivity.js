/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){

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
                url: site_url+"sales/load_sales_activity",
                cache: true,
                success: function(data){
                    $("#datasalesactivity").html(data);
                },
                beforeSend: function(){
                    $("#datasalesactivity").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
            
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
                url: site_url+"sales/load_sales_activity",
                cache: true,
                success: function(data){
                    $("#datasalesactivity").html(data);
                },
                beforeSend: function(){
                    $("#datasalesactivity").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });



    $("#form_activity").validationEngine();
    $("form#form_activity").submit(function(){
        if($("#form_activity").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"sales/add_activity",
                cache: true,
                data:$('#form_activity').serialize(),
                dataType:"json",
                success: function(){
                    $("#processing").html('Data has been saved.');
                    $("input#nama_activity").val('');
                    window.location = site_url +'sales/sales_activity';
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Saving...');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });

    $("#form_editactivity").validationEngine();
    $("form#form_editactivity").submit(function(){
        if($("#form_editactivity").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"sales/update_activity",
                cache: true,
                data:$('#form_editactivity').serialize(),
                dataType:"json",
                success: function(){
                    $("#processing").html('Data has been saved.');
                    $("input#nama_activity").val('');
                    window.location = site_url +'sales/sales_activity';
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Saving...');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });

})