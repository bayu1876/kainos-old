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
            $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
            $(this).addClass('current'); // Add class "current" to clicked tab
            var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
            $(currentTab).siblings().hide(); // Hide all content divs
            $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
            return false;
        }
        );


        $('.btn_showsalesperson').toggle(function() {
        //alert('First handler for .toggle() called.');
        var this_id = $(this).attr('id');
        $(".containersalesperson[id^="+this_id+"]").css('display','none');

    }, function() {
        var this_id = $(this).attr('id');
        $(".containersalesperson[id^="+this_id+"]").css('display','');
    //alert('Second handler for .toggle() called.');
    });



    $('.btn_showgroup').toggle(function() {
        //alert('First handler for .toggle() called.');
        var this_id = $(this).attr('id');
        $(".containertargetgroup[id^="+this_id+"]").css('display','');
   
    }, function() {
        var this_id = $(this).attr('id');
        $(".containertargetgroup[id^="+this_id+"]").css('display','none');
    //alert('Second handler for .toggle() called.');
    });


    $('.btn_showsalesbudget').toggle(function() {
        //alert('First handler for .toggle() called.');
        var this_id = $(this).attr('id');
        $(".containersalesbudget[id^="+this_id+"]").css('display','none');

    }, function() {
        var this_id = $(this).attr('id');
        $(".containersalesbudget[id^="+this_id+"]").css('display','');
        //alert('Second handler for .toggle() called.');
    });

     $('.btn_showunittarget').toggle(function() {
        //alert('First handler for .toggle() called.');
        var this_id = $(this).attr('id');
        $(".containerunittarget[id^="+this_id+"]").css('display','');

    }, function() {
        var this_id = $(this).attr('id');
        $(".containerunittarget[id^="+this_id+"]").css('display','none');
        //alert('Second handler for .toggle() called.');
    });


    $('.btn_showbreakgroup').toggle(function() {
        //alert('First handler for .toggle() called.');
        var this_id = $(this).attr('id');
        $(".containerbreakgroup[id^="+this_id+"]").css('display','');

    }, function() {
        var this_id = $(this).attr('id');
        $(".containerbreakgroup[id^="+this_id+"]").css('display','none');
        //alert('Second handler for .toggle() called.');
    });


    $('.btn_showbreakgroup').toggle(function() {
        //alert('First handler for .toggle() called.');
        var this_id = $(this).attr('id');
        $(".containerbreakgroup[id^="+this_id+"]").css('display','');
    }, function() {
        var this_id = $(this).attr('id');
        $(".containerbreakgroup[id^="+this_id+"]").css('display','none');
        //alert('Second handler for .toggle() called.');
    });


});


  