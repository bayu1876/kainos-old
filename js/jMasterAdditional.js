/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

    $.ajax({
        type:"POST",
        url: site_url+"additional/load_ref_additional",
        cache: true,
        success: function(data){
            $("#datarefadditional").html(data);
        },
        beforeSend: function(){
            $("#datarefadditional").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });



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
                url: site_url+"additional/load_master_additional",
                cache: true,
                success: function(data){
                    $("#datamasteradditional").html(data);
                },
                beforeSend: function(){
                    $("#datamasteradditional").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });

             $.ajax({
                type:"POST",
                url: site_url+"additional/load_ref_additional",
                cache: true,
                success: function(data){
                    $("#datarefadditional").html(data);
                },
                beforeSend: function(){
                    $("#datarefadditional").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
 

 $.ajax({
                type:"POST",
                url: site_url+"additional/load_structrate_additional",
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
              url: site_url+"additional/get_structurerate_by_category",
             
               
              dataType:"html",
              success: function(data){
                $(".containerstrucrate").html(data);
               // $(".containerstrucrate #csr1").html(data);

              },
               beforeSend: function(){
                $(".containerstrucrate").html('Loading..........');
               }
            });
            
            $("#processing").html('');

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
        url: site_url+"additional/load_master_additional",
        cache: true,
        success: function(data){
            $("#datamasteradditional").html(data);
        },
        beforeSend: function(){
            $("#datamasteradditional").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });

    $("form#form_master_additional").validationEngine();
    $("form#form_master_additional").submit(function() {
        if($("form#form_master_additional").validationEngine({
            returnIsValid:true
        }))

        {
            $.ajax({
                type:"POST",
                url: site_url+"additional/add_master_additional",
                cache: true,
                data:$('form#form_master_additional').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data has been saved.');
                    $("input#nameadditional").val('');
                    $("input#additionalunit").val('');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/> process...');
                }
            });
        }
        return false;
    });


 $("form#form_edit_master_additional").validationEngine();
    $("form#form_edit_master_additional").submit(function() {
        if($("form#form_edit_master_additional").validationEngine({
            returnIsValid:true
        }))

        {
            $.ajax({
                type:"POST",
                url: site_url+"additional/edit_data_master_additional",
                cache: true,
                data:$('form#form_edit_master_additional').serialize(),
                dataType:"html",
                success: function(data){
                window.location = site_url +'additional/master_additional';
                    $("#processing").html('Data has been saved.');
                    $("input#nameadditional").val('');
                    $("input#additionalunit").val('');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/> process...');
                }
            });
        }
        return false;
    });


    //CLONE TABLE MASTER ADDITIONAL
    $(".cloneTableMasterAdditional").live('click', function(){
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

            if($(this).hasClass("additional")){ // if the current input has the hasDatpicker class
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
        
         $(newRow).find("span").each(function(){
             if($(this).hasClass("containerstrucrate")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                 
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
            }

         });
        return false;
    });
    //END CLONE TABLE MASTER ADDITIONAL

   

    $("form#form_additional").validationEngine();
    $("form#form_additional").submit(function() {
        if($("form#form_additional").validationEngine({
            returnIsValid:true
        }))

        {
            $.ajax({
                type:"POST",
                url: site_url+"additional/add_additional",
                cache: true,
                data:$('form#form_additional').serialize(),
                dataType:"html",
                success: function(data){
                    //alert(data)
                    $("#processing").html('Data has been saved.');
                    $("input#nameadditional").val('');
                    $("input#additionalunit").val('');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Saving...');
                }
            });
        }
        return false;
    });

    $("form#form_edit_additional").validationEngine();
    $("form#form_edit_additional").submit(function() {
        if($("form#form_edit_additional").validationEngine({
            returnIsValid:true
        }))

        {
            $.ajax({
                type:"POST",
                url: site_url+"additional/edit_additional",
                cache: true,
                data:$('form#form_edit_additional').serialize(),
                dataType:"html",
                success: function(data){
                    //alert(data)
                    window.location = site_url +'additional/master_additional';
                    $("#processing").html('Data has been saved.');
                    $("input#nameadditional").val('');
                    $("input#additionalunit").val('');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Saving...');
                }
            });
        }
        return false;
    });

 $('select.property').live('change',function(){
        var this_id = $(this).attr('id');
       // alert(this_id);
    })

    $('select.additional').live('change',function(){
        var this_id = $(this).attr('id');
        //alert(this_id);
    })

     $('select.structure').live('change',function(){
        var this_id = $(this).attr('id');
    //    alert(this_id);
    })

    // Delete a table row
    $("img.delRow").click(function(){
        $(this).parents("tr").remove();
        return false;
    });



    $("select#sortproperty").change(function(){
        var property = $(this).val();
        var additional = $("select#sortaddname").val();
        $.ajax({
            type:"POST",
            url: site_url+"additional/get_addtitional_bydetil",
            data:({property:property,
                   additional:additional}),
            success: function(data){
                $("#datarefadditional").html(data);
            },
            beforeSend: function(){
                $("#datarefadditional").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });



    })


    $("select#sortaddname").change(function(){
        var property = $("select#sortproperty").val();
        var additional = $(this).val();
        $.ajax({
            type:"POST",
            url: site_url+"additional/get_addtitional_bydetil",
            data:({
                property:property,
                additional:additional
            }),
            success: function(data){
                $("#datarefadditional").html(data);
            },
            beforeSend: function(){
                $("#datarefadditional").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

    })
    
    
    $("#form_structure_rate").validationEngine();
    $("form#form_structure_rate").submit(function() {
        if($("#form_structure_rate").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"additional/add_struc_rate",
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
                        url: site_url+"additional/load_structrate_additional",
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