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

        $.validationEngine.closePrompt('.formError',true);
            $.ajax({
                type:"POST",
                url: site_url+"complimentary/load_data_complimentary",
                cache: true,

                dataType:"html",
                success: function(data){
                    $("#datacomplimentary").html(data);
                },
                beforeSend: function(){
                    $("#datacomplimentary").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });

            $.ajax({
                type:"POST",
                url: site_url+"complimentary/load_data_complimentary_history",
                cache: true,

                dataType:"html",
                success: function(data){
                    $("#datacomplimentaryhistory").html(data);
                },
                beforeSend: function(){
                    $("#datacomplimentaryhistory").html('<img src="'+base_url+'images/loading.gif"/>');
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





    tinyMCE.execCommand('mceAddControl', false, 'deskripsi');


    $(".cloneTableComplimentary").live('click', function(){
        // this tables id
        var thisTableId = $(this).parents("table").attr("id");
        // lastRow
        var lastRow = $('#'+thisTableId + " tr:last");
        // clone last row
        var newRow = lastRow.clone(true);
        // append row to this table
        $('#'+thisTableId).append(newRow);
        // make the delete image visible
        $('#'+thisTableId + " tr:last  ").css("display", "");
        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
        $('#'+thisTableId + " tr:last").addClass('addonrow');
        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
        // clear the inputs (Optional)
        //$('#'+thisTableId + " tr:last td :input").val('');

        // new rows datepicker need to be re-initialized
        $(newRow).find("input").each(function(){
            if($(this).hasClass("hasDatepicker")){ // if the current input has the hasDatpicker class
                var this_id = $(this).attr("id"); // current inputs id
                var new_id = this_id + 1; // a new id
                $(this).attr("id", new_id); // change to new id
                $(this).removeClass('hasDatepicker'); // remove hasDatepicker class
                // re-init datepicker
                $(this).datepicker({
                    dateFormat: 'dd-mm-yy',
                    showButtonPanel: true
                });
            }

            if($(this).hasClass("accountname")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
            }

             if($(this).hasClass("qtyroom")){ // if the current input has the hasDatpicker class
               var this_idxx = $(this).attr("id"); // current inputs id
                var txtid = this_idxx.slice(0,7);
                var numberid = this_idxx.slice(7);
                var new_id7 = parseInt(numberid) + 1;
                $(this).attr("id", txtid+new_id7); // change to new id
            }

            

            
        });

        $(newRow).find("input:hidden").each(function(){
            if($(this).hasClass("idacc")){ // if the current input has the hasDatpicker class
                var this_id = $(this).attr("id"); // current inputs id
                var new_id =  parseInt(this_id) + 1; // a new id
                $(this).attr("id", new_id); // change to new id
            }
        });

        $(newRow).find("div").each(function(){
            if($(this).hasClass("containerRoom")){ // if the current input has the hasDatpicker class
                var this_idx = $(this).attr("id"); // current inputs id
                var txtid = this_idx.slice(0,8);
                var numberid = this_idx.slice(8);
                var new_id7 = parseInt(numberid) + 1;
                $(this).attr("id", txtid+new_id7); // change to new id
            }
        });

//        $(newRow).find("select").each(function(){
//            if($(this).hasClass("roomtype")){ // if the current input has the hasDatpicker class
//                var this_idx = $(this).attr("id"); // current inputs id
//                var txtid = this_idx.slice(0,3);
//                var numberid = this_idx.slice(3);
//                var new_id7 = parseInt(numberid) + 1;
//                $(this).attr("id", txtid+new_id7); // change to new id
//            }
//        });

        return false;
    });

    $(".my_date").datepicker({
        dateFormat: 'dd-mm-yy',
        showButtonPanel: true
    });

    // Delete a table row
    $("img.delRow").click(function(){
        $(this).parents("tr").remove();

        return false;
    });

    $("#date").datepicker({
        dateFormat:'dd-mm-yy'
       
    });

     $("#datestart").datepicker({
        dateFormat:'dd-mm-yy'

    });

    $("#dateend").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#datestart").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    });

     $("#dateend").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    });

    $("#date").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    });

    $("#form_complimentary").validationEngine();
    $("form#form_complimentary").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }
        if($("#form_complimentary").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"complimentary/add_complimentary",
                cache: true,
                data:$('#form_complimentary').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data has been saved.');
                    window.location = site_url +'complimentary';
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Saving...');
                }
            });
            
        }else{
        //alert('gagal');
        }
        return false;
    });


$("select#property").change(function(){
    $.ajax({
            type:"POST",
            url: site_url+"complimentary/get_room_byproperty",
            cache: true,
            data:({property:$(this).val()}),
            dataType:"html",
            success: function(data){
               $(".addonrow").remove();
                $(".containerRoom").html(data);
            },
            beforeSend: function(){
                $(".containerRoom").html('<img src="'+base_url+'images/loading.gif"/>');
            }
        });
});


 $.ajax({
            type:"POST",
            url: site_url+"complimentary/load_data_complimentary",
            cache: true,
           
            dataType:"html",
            success: function(data){
                $("#datacomplimentary").html(data);
            },
            beforeSend: function(){
                $("#datacomplimentary").html('<img src="'+base_url+'images/loading.gif"/>');
            }
        });



//$("#account").autocomplete(site_url+"offering_letter/get_companyaccount", {
  $("#account").autocomplete(site_url+"account/get_account", {
                width: 198,
		selectFirst: false
        });
        $('input#account').flushCache();
        $("#account").result(function(event, data, formatted) {
		if (data){
                    $('#idaccount').val(data[1]);//$(this).parent().next().find("input").val(data[1]);
                    $.ajax({
                          type:"POST",
                          url: site_url+"offering_letter/get_contact_byaccount",
                          data:({idaccount:data[1]}),
                          dataType:"html",
                          success: function(data){
                            //$('#otherpackagerequirement > tr').remove();
                            //$("#otherpackagerequirement tr:not(#master)").remove();
                            $('#contactperson').html(data);
                            var eventtype = $("select#eventtype").val();
                            if(eventtype == "RO"){
                                $("input#event_name").val($("input#account").val());
                            }
                          },
                           beforeSend: function(){
                             $('#contactperson').html('<img src="'+base_url+'images/loading.gif"/> ');
                           }
                    });
            }//end IF
	});



    $("input#reset").click(function(){
        //alert('asdas');
        $("#account").val('');
        $("#idaccount").val('');

        $("#contactperson").html('');
        return false;
    })


    $("input#cake").change(function(){
        var ischecked = $(this).attr('checked');
        if(ischecked == true){
            $("#specrow").show();
        }else{
             $("#specrow").hide();
             $("input#spec").val('');
        }
    })


    $.ajax({
        type:"POST",
        url: site_url+"complimentary/load_data_complimentary_history",
        cache: true,

        dataType:"html",
        success: function(data){
            $("#datacomplimentaryhistory").html(data);
        },
        beforeSend: function(){
            $("#datacomplimentaryhistory").html('<img src="'+base_url+'images/loading.gif"/>');
        }
    });
});