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
        url:site_url+"welcome/load_confirmtodaypersales",
        cache: false,
        data:({
            halaman:1
        }),
        success: function(data){
            $('#p'+1).html(data)
        },
        beforeSend: function(){
            $('#p'+1).html('<img src="'+base_url+'images/ajax-loader.gif" align="absmiddle">Loading...');
        }
    });



    $.ajax({
        type:"POST",
        url:site_url+"welcome/load_canceltodaypersales",
        cache: false,
        data:({
            halaman:1
        }),
        success: function(data){
            $('#pgc'+1).html(data)
        },
        beforeSend: function(){
            $('#pgc'+1).html('<img src="'+base_url+'images/ajax-loader.gif" align="absmiddle">Loading...');
        }
    });

    var totaldatacancel = $('#totaldatacancel').val();
    $("#page_cancel").paginate({
        count: totaldatacancel,
        start: 1,
        display: 20,//totalpage ,
        border: true,
        border_color: '#dddddd',
        text_color: '#3b5998',
        background_color: '#fff',
        border_hover_color: '#dd3c10',
        text_hover_color: '#333333',
        background_hover_color	: '#ffebe8',
        images: false,
        mouse: 'press',
        onChange  : function(page){
            $('._current','#paginationcancel').removeClass('_current').hide();
            $('#pgc'+page).addClass('_current').show();
            $.ajax({
                type:"POST",
                url:site_url+"welcome/paging_canceltodaypersales",
                cache: false,
                data:({
                    halaman:page
                }),
                success: function(data){
                    $('#pgc'+page).html(data)
                },
                beforeSend: function(){
                    //$('#p'+page).html('<img src="'+base_url+'images/ajax-loader.gif" align="absmiddle">&nbsp;Loading...');
                }
            });
            return false;
        }
    });


    var totaldata = $('#totaldata').val();
    $("#page_confirm").paginate({
        count: totaldata,
        start: 1,
        display: 20,//totalpage ,
        border: true,
        border_color: '#dddddd',
        text_color: '#3b5998',
        background_color: '#fff',
        border_hover_color: '#dd3c10',
        text_hover_color: '#333333',
        background_hover_color	: '#ffebe8',
        images: false,
        mouse: 'press',
        onChange  : function(page){
            $('._current','#paginationdemo').removeClass('_current').hide();
            $('#p'+page).addClass('_current').show();
            $.ajax({
                type:"POST",
                url:site_url+"welcome/paging_confirmtodaypersales",
                cache: false,
                data:({
                    halaman:page
                }),
                success: function(data){
                    $('#p'+page).html(data)
                    //alert(data);
                },
                beforeSend: function(){
                    //$('#p'+page).html('<img src="'+base_url+'images/ajax-loader.gif" align="absmiddle">&nbsp;Loading...');
                }
            });
            return false;
        }
    });


    $('.subpanel').show();
})
