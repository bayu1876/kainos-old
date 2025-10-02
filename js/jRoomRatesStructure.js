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
               $.ajax({
                type:"POST",
                url: site_url+"room_rates_stucture/get_option_structure_rate",
                cache: true,
                success: function(data){
                    $("#containerstructurerate").html(data);
                },
                beforeSend: function(){
                    $("#containerstructurerate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>');
                }
            });
            

            $.ajax({
                type:"POST",
                url: site_url+"room_rates_stucture/load_ref_room_structure",
                cache: true,
                success: function(data){
                    $("#datarefroomstructure").html(data);
                },
                beforeSend: function(){
                    $("#datarefroomstructure").html('<img src="'+base_url+'/images/ajax-loader.gif"/>');
                }
            });

            $.ajax({
                type:"POST",
                url: site_url+"room_rates_stucture/load_room_structure",
                cache: true,
                success: function(data){
                    $("#dataroomstructure").html(data);
                },
                beforeSend: function(){
                    $("#dataroomstructure").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
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


    $(".cloneTableRoomStructure").live('click', function(){
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
        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");

        // clear the inputs (Optional)
        $('#'+thisTableId + " tr:last td :input").val('');

        //new rows datepicker need to be re-initialized
        $(newRow).find("input").each(function(){
            if($(this).hasClass("price")){ // if the current input has the hasDatpicker class
                var this_id2 = $(this).attr("id"); // current inputs id
                var txtid2 = this_id2.slice(0,6);
                var numberid2 = this_id2.slice(6);
                var new_id2 = parseInt(numberid2) + 1;
                // a new id
                $(this).attr("id", txtid2+new_id2); // change to new id
                $(this).val('');
            }
        });

        $(newRow).find("select").each(function(){
            if($(this).hasClass("property")){ // if the current input has the hasDatpicker class
                var this_id7 = $(this).attr("id"); // current inputs id
                var txtid7 = this_id7.slice(0,5);
                var numberid7 = this_id7.slice(5);
                var new_id7 = parseInt(numberid7) + 1;
                // a new id
                $(this).attr("id", txtid7+new_id7); // change to new id
            }

            if($(this).hasClass("roomtype")){ // if the current input has the hasDatpicker class
                var this_id6 = $(this).attr("id"); // current inputs id
                var txtid6 = this_id6.slice(0,5);
                var numberid6 = this_id6.slice(5);
                var new_id6 = parseInt(numberid6) + 1;
                // a new id
                $(this).attr("id", txtid6+new_id6); // change to new id
            }

            if($(this).hasClass("weektype")){ // if the current input has the hasDatpicker class
                var this_id5 = $(this).attr("id"); // current inputs id
                var txtid5 = this_id5.slice(0,5);
                var numberid5 = this_id5.slice(5);
                var new_id5 = parseInt(numberid5) + 1;
                // a new id
                $(this).attr("id", txtid5+new_id5); // change to new id
            }

            if($(this).hasClass("bedtype")){ // if the current input has the hasDatpicker class
                var this_id4 = $(this).attr("id"); // current inputs id
                var txtid4 = this_id4.slice(0,4);
                var numberid4 = this_id4.slice(4);
                var new_id4 = parseInt(numberid4) + 1;
                // a new id
                $(this).attr("id", txtid4+new_id4); // change to new id
            }

            if($(this).hasClass("struct")){ // if the current input has the hasDatpicker class
                var this_id3 = $(this).attr("id"); // current inputs id
                var txtid3 = this_id3.slice(0,7);
                var numberid3 = this_id3.slice(7);
                var new_id3 = parseInt(numberid3) + 1;
                // a new id
                $(this).attr("id", txtid3+new_id3); // change to new id
            }

             
        });
        return false;
    });
    //END CLONE TABLE MASTER ADDITIONAL

    // Delete a table row
    $("img.delRow").click(function(){
        $(this).parents("tr").remove();
        return false;
    });

    //    $("select.property").change(function(){
    //        var this_id = $(this).attr('id');
    //        alert(this_id);
    //    })
    //
    //    $("select.roomtype").change(function(){
    //        var this_id = $(this).attr('id');
    //        alert(this_id);
    //    })
    //
    //    $("select.weektype").change(function(){
    //        var this_id = $(this).attr('id');
    //        alert(this_id);
    //    })
    //
    //    $("select.bedtype").change(function(){
    //        var this_id = $(this).attr('id');
    //        alert(this_id);
    //    })
    //
    //    $("select.struct").change(function(){
    //        var this_id = $(this).attr('id');
    //        alert(this_id);
    //    })


    $.ajax({
        type:"POST",
        url: site_url+"room_rates_stucture/load_ref_room_structure",
        cache: true,
        success: function(data){
            $("#datarefroomstructure").html(data);
        },
        beforeSend: function(){
            $("#datarefroomstructure").html('<img src="'+base_url+'/images/ajax-loader.gif"/>');
        }
    });

    $.ajax({
        type:"POST",
        url: site_url+"room_rates_stucture/load_room_structure",
        cache: true,
        success: function(data){
            $("#dataroomstructure").html(data);
        },
        beforeSend: function(){
            $("#dataroomstructure").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
        }
    });

    



    $("form#form_ref_room_structure").submit(function() {
        if($("#form_ref_room_structure").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"room_rates_stucture/add_ref_room_structure",
                cache: true,
                data:$('#form_ref_room_structure').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data has been saved.');
                    $("input#roomstruc").val('');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> process...');
                }
            });
        }
        return false;
    });


    $("form#form_room_structure").submit(function() {
        if($("#form_room_structure").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"room_rates_stucture/add_room_structure",
                cache: true,
                data:$('#form_room_structure').serialize(),
                dataType:"html",
                success: function(data){
                    //window.location = site_url +'room_rates_stucture';
                    $("#processing").html('Data has been saved.');
                //$("select#property").val('-- Choose --');
                //$("input#price").val('');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/> process...');
                }
            });
        }
        return false;
    });

    $("form#form_weddingstall").submit(function() {
        if($("form#form_weddingstall").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"wedding_stall/add_weddingstall_property",
                cache: true,
                data:$('form#form_weddingstall').serialize(),
                dataType:"html",
                success: function(data){
                    
                    $("#processing").html('Data has been saved. '+data);
                    $("input#stall_name").val('');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/> process...');
                }
            });
        }
        return false;
    });


    //ANGKA AJA/////
    $("input.price").keypress(function(e){
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57)){
            //display error message
            // alert('Plizz deh..., angka aja nape??');
            return false;
        }
    //    return false;
    });


    $("select#sortproperty").change(function(){
        var property = $(this).val();
        var room = $("select#sortroomtype").val();
        var bed = $("select#sortbedtype").val();

        $.ajax({
            type:"POST",
            url: site_url+"room_rates_stucture/get_roomratesstruc_detil",
            data:({
                property:property,
                roomtype:room,
                bedtype:bed
            }),
            success: function(data){
                $("#dataroomstructure").html(data);
            },
            beforeSend: function(){
                $("#dataroomstructure").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
    })

     $("select#sortroomtype").change(function(){
        var property = $("select#sortproperty").val();
        var room = $(this).val();
        var bed = $("select#sortbedtype").val();

        $.ajax({
            type:"POST",
            url: site_url+"room_rates_stucture/get_roomratesstruc_detil",
            data:({
                property:property,
                roomtype:room,
                bedtype:bed
            }),
            success: function(data){
                $("#dataroomstructure").html(data);
            },
            beforeSend: function(){
                $("#dataroomstructure").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
    })

     $("select#sortbedtype").change(function(){
        var property = $("select#sortproperty").val();
        var room = $("select#sortroomtype").val();
        var bed = $(this).val();

        $.ajax({
            type:"POST",
            url: site_url+"room_rates_stucture/get_roomratesstruc_detil",
            data:({
                property:property,
                roomtype:room,
                bedtype:bed
            }),
            success: function(data){
                $("#dataroomstructure").html(data);
            },
            beforeSend: function(){
                $("#dataroomstructure").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
    })


    $(".struct").live('change',function(){
            var id = $(this).attr('id').slice(7);
            var idstruct = $(this).attr('id');
            var propid = "prop-"+id;
            var roomid = "room-"+id;
            var bedid = "bed-"+id;
            var weekid = "week-"+id;

            var property = $(".property[id^="+propid+"]").val();
            var roomtype = $(".roomtype[id^="+roomid+"]").val();
            var bedtype = $(".bedtype[id^="+bedid+"]").val();
            var weektype = $(".weektype[id^="+weekid+"]").val();
            var struct = $(this).val();
             
            $.ajax({
                type:"POST",
                url: site_url+"room_rates_stucture/check_room_rates",
                
                data:({
                    property:property,
                    bedtype:bedtype,
                    weektype:weektype,
                    roomtype:roomtype,
                    struct:struct
                }),
                success: function(data){
                    if(data != '' && data != 'Package has been used.'){
                        $.validationEngine.buildPrompt("#"+idstruct,data,"error");

                    }else{
                        $.validationEngine.closePrompt('.formError',true);

                    }
                    if(data == 'Room rates already exist, please use another Rate\'s Structure'){
                        $.validationEngine.buildPrompt("#"+idstruct,data,"error");
                        $("#btnroomrates").hide();
                        $("#processing").html("Please check your Structure Rate.");
                    }else{
                        $("#btnroomrates").show();
                        $("#processing").html("");
                    }
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                }
            });
    })
});
 
