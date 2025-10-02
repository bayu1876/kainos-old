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
            $("#processing").html('');
            $.ajax({
                type:"POST",
                url: site_url+"room_rental/load_struc_roomrental",
                cache: true,
                success: function(data){
                    $("#datarateroomrental").html(data);
                },
                beforeSend: function(){
                    $("#datarateroomrental").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
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





    $(".cloneTableRoomRental").live('click', function(){
         
        // this tables id
        var thisTableId = $(this).parents("table").attr("id");
        // lastRow
        var lastRow = $('#'+thisTableId + " tr:last");
        // clone last row
        var newRow = lastRow.clone(true);
        // append row to this table
        $('#'+thisTableId).append(newRow);
        // make the delete image visible
        //$('#'+thisTableId + " tr:last td:first img").css("visibility", "visible");
        $('#'+thisTableId + " tr:last  ").css("display", "");
        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
        // clear the inputs (Optional)
        //$('#'+thisTableId + " tr:last td :input").val('');
        $('#'+thisTableId + " tr:last").addClass('addonRowRoomRental');
        // new rows datepicker need to be re-initialized
        $(newRow).find("input").each(function(){
            if($(this).hasClass("strucname")){ // if the current input has the hasDatpicker class
                var this_id3 = $(this).attr("id"); // current inputs id
                var new_id3 =  parseInt(this_id3) + 1; // a new id
                $(this).attr("id", new_id3); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("price")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
                $(this).val('');
            }
        });
        return false;
    });


    $("img.delRowRoomRental").click(function(){
        $(this).parents("tr").remove();
        $.validationEngine.closePrompt('.formError',true);
        return false;
    });



    $("form#formroomrental").validationEngine();
     $("form#formroomrental").submit(function() {
        if($("form#formroomrental").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"room_rental/add_rateroomrental",
             // cache: true,
              data:$('#formroomrental').serialize(),
              dataType:"html",
              success: function(data){
                $(".addonRowRoomRental").remove();
                $("#processing").html('Data has been saved.');
                
                $(".strucname").val('');
                $(".price").val('');
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
               }
            });
        }
	return false;
     });


     $.ajax({
        type:"POST",
        url: site_url+"room_rental/load_struc_roomrental",
        cache: true,
        success: function(data){
            $("#datarateroomrental").html(data);
        },
        beforeSend: function(){
            $("#datarateroomrental").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });




$("form#form_editroomrental").validationEngine();
     $("form#form_editroomrental").submit(function() {
        if($("form#form_editroomrental").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"room_rental/update_roomrental",
             // cache: true,
              data:$('#form_editroomrental').serialize(),
              dataType:"html",
              success: function(data){
                $("#processing").html('Data has been saved.');
                $(".strucname").val('');
                $(".price").val('');
                window.location = site_url +'room_rental/';
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
               }
            });
        }
	return false;
     });
});


  