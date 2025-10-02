/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
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
            $.ajax({
    type:"POST",
    url: site_url+"wedding_stall/load_data_ref_wedding_stall",
    cache: true,
    success: function(data){
        $("#datarefweddingstall").html(data);
    },
    beforeSend: function(){
        $("#datarefweddingstall").html('<img src="'+base_url+'/images/ajax-loader.gif"/>');
    }
});



    $.ajax({
        type:"POST",
        url: site_url+"wedding_stall/load_data_wedding_stall",
        cache: true,
        success: function(data){
            $("#dataweddingstall").html(data);
        },
        beforeSend: function(){
            $("#dataweddingstall").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });
    
    
 $.ajax({
                type:"POST",
                url: site_url+"wedding_stall/load_structrate_stall",
                cache: false,
                success: function(data){
                    $("#datastructurerate").html(data);
                },
                beforeSend: function(){
                    $("#datastructurerate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                }
            });
            
            
            $.ajax({
              type:"POST",
              url: site_url+"wedding_stall/get_structurerate_by_category",
             
               
              dataType:"html",
              success: function(data){
                $(".containerstrucrate").html(data);
               // $(".containerstrucrate #csr1").html(data);

              },
               beforeSend: function(){
                $(".containerstrucrate").html('Loading..........');
               }
            });
    $.validationEngine.closePrompt('.formError',true);
     $("#processing1").html(' ');
    
    
    
            $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
            $(this).addClass('current'); // Add class "current" to clicked tab
            var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
            $(currentTab).siblings().hide(); // Hide all content divs
            $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
            return false;
        }
        );



    $(".cloneTableWeddingStall").live('click', function(){
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

        if($(this).hasClass("qty")){ // if the current input has the hasDatpicker class
            var this_id3 = $(this).attr("id"); // current inputs id
            var txtid3 = this_id3.slice(0,4);
            var numberid3 = this_id3.slice(4);
            var new_id3 = parseInt(numberid3) + 1;
            // a new id
            $(this).attr("id", txtid3+new_id3); // change to new id
            $(this).val('');
        }
    });

    $(newRow).find("select").each(function(){
        if($(this).hasClass("property")){ // if the current input has the hasDatpicker class
            var this_id6 = $(this).attr("id"); // current inputs id
            var txtid6 = this_id6.slice(0,5);
            var numberid6 = this_id6.slice(5);
            var new_id6 = parseInt(numberid6) + 1;
            // a new id
            $(this).attr("id", txtid6+new_id6); // change to new id
        }

        if($(this).hasClass("weddingstall")){ // if the current input has the hasDatpicker class
            var this_id5 = $(this).attr("id"); // current inputs id
            var txtid5 = this_id5.slice(0,4);
            var numberid5 = this_id5.slice(4);
            var new_id5 = parseInt(numberid5) + 1;
            // a new id
            $(this).attr("id", txtid5+new_id5); // change to new id
        }

        if($(this).hasClass("structure")){ // if the current input has the hasDatpicker class
            var this_id4 = $(this).attr("id"); // current inputs id
            var txtid4 = this_id4.slice(0,4);
            var numberid4 = this_id4.slice(4);
            var new_id4 = parseInt(numberid4) + 1;
            // a new id
            $(this).attr("id", txtid4+new_id4); // change to new id
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


$.ajax({
    type:"POST",
    url: site_url+"wedding_stall/load_data_ref_wedding_stall",
    cache: true,
    success: function(data){
        $("#datarefweddingstall").html(data);
    },
    beforeSend: function(){
        $("#datarefweddingstall").html('<img src="'+base_url+'/images/ajax-loader.gif"/>');
    }
});

 

    $.ajax({
        type:"POST",
        url: site_url+"wedding_stall/load_data_wedding_stall",
        cache: true,
        success: function(data){
            $("#dataweddingstall").html(data);
        },
        beforeSend: function(){
            $("#dataweddingstall").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });



    $("form#form_master_wedding_stall").submit(function() {
        if($("#form_master_wedding_stall").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"wedding_stall/add_wedding_stall",
                cache: true,
                data:$('#form_master_wedding_stall').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing1").html('Data has been saved.');
                    $("input#stall_name").val('');
                },
                beforeSend: function(){
                    $("#processing1").html('<img src="'+base_url+'images/loading.gif"/> process...');
                }
            });
        }
        return false;
    });


    $("form#form_edit_master_wedding_stall").submit(function() {
        if($("#form_edit_master_wedding_stall").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"wedding_stall/edit_wedding_stall",
                cache: true,
                data:$('#form_edit_master_wedding_stall').serialize(),
                dataType:"html",
                success: function(data){
                     window.location = site_url +'wedding_stall';
                    $("#processing").html('Data has been saved.');
                    $("input#stall_name").val('');
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
                    
                    $("#processing1").html('Data has been saved. '+data);
                    $("input#stall_name").val('');
                     window.location = site_url +'wedding_stall';
                },
                beforeSend: function(){
                    $("#processing1").html('<img src="'+base_url+'images/loading.gif"/> process...');
                }
            });
        }
        return false;
    });


$("form#form_edit_weddingstall").submit(function() {
        if($("form#form_edit_weddingstall").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"wedding_stall/edit_weddingstall_property",
                cache: true,
                data:$('form#form_edit_weddingstall').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'wedding_stall';
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


    $("select.property").change(function(){
        var this_id = $(this).attr('id');
       // alert(this_id);
    })

    $("select.weddingstall").change(function(){
        var this_id = $(this).attr('id');
     //   alert(this_id);
    })

    $("select.structure").change(function(){
        var this_id = $(this).attr('id');
       // alert(this_id);
    })

//    $("input.price").keyup(function(){
//        var this_id = $(this).attr('id');
//        alert(this_id);
//    })




 //ANGKA AJA/////
$("input.price").keypress(function(e)
{
      //if the letter is not digit then display error and don't type anything
      if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
      {
            //display error message
            // alert('Plizz deh..., angka aja nape??');
            return false;
      }
//    return false;
});
    
    
    
    
    $("#form_structure_rate").validationEngine();
    $("form#form_structure_rate").submit(function() {
        if($("#form_structure_rate").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"wedding_stall/add_struc_rate",
                cache: false,
                data:$('#form_structure_rate').serialize(),
                dataType:"html",
                success: function(data){
                    //window.location = site_url +'task';
                    alert('Data has been saved');
                    $("#processing").html('Data has been saved.');
                    $("input#strucname").val('');
                    
                     $.ajax({
                        type:"POST",
                        url: site_url+"wedding_stall/load_structrate_stall",
                        cache: false,
                        success: function(data){
                            $("#datastructurerate").html(data);
                        },
                        beforeSend: function(){
                            $("#datastructurerate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });
});
 
