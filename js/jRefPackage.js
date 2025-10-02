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
            $("#processingx").html('');
            $.validationEngine.closePrompt('.formError',true);
            $("#processing").html('');
            $.ajax({
                type:"POST",
                url: site_url+"package/load_data_ref_package",
                cache: true,
                success: function(data){
                    $("#datarefpackage").html(data);
                },
                beforeSend: function(){
                    $("#datarefpackage").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });

            $.ajax({
                type:"POST",
                url: site_url+"package/load_data_package",
                cache: true,
                success: function(data){
                    $("#datapackage").html(data);
                },
                beforeSend: function(){
                    $("#datapackage").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
            
            
        $.ajax({
                type:"POST",
                url: site_url+"package/load_structurerate_package",
                cache: false,
                success: function(data){
                    $("#datastructurerate").html(data);
                },
                beforeSend: function(){
                    $("#datastructurerate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
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




    $.ajax({
        type:"POST",
        url: site_url+"package/load_data_ref_package",
        cache: true,
        success: function(data){
            $("#datarefpackage").html(data);
        },
        beforeSend: function(){
            $("#datarefpackage").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });


    $.ajax({
        type:"POST",
        url: site_url+"package/load_data_package",
        cache: true,
        success: function(data){
            $("#datapackage").html(data);
        },
        beforeSend: function(){
            $("#datapackage").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });



$("form#formpackagenonmeeting").validationEngine();
     $("form#formpackagenonmeeting").submit(function() {
        if($("form#formpackagenonmeeting").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"package/add_package",
             // cache: true,
              data:$('#formpackagenonmeeting').serialize(),
              dataType:"html",
              success: function(data){
                $(".addonRowPackage").remove();
                $("#processing").html('Data has been saved.');
                $(".packageproperty").val('-- Choose --');
                $(".packagestrucrate").val('-- Choose --');
                $(".packageref").val('-- Choose --');
                $(".packageevent").val('-- Choose --');
                $(".packagepax").val('');
                $(".packageprice").val('');
                $(".packagepriceadd").val('');
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
               }
            });
        }
	return false;
     });
    


    $(".cloneTablePackage").live('click', function(){
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
        $('#'+thisTableId + " tr:last").addClass('addonRowPackage');
        // new rows datepicker need to be re-initialized
        $(newRow).find("input").each(function(){
            if($(this).hasClass("packageprice")){ // if the current input has the hasDatpicker class
                var this_id3 = $(this).attr("id"); // current inputs id
                var new_id3 =  parseInt(this_id3) + 1; // a new id
                $(this).attr("id", new_id3); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("packagepax")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("packagepriceadd")){ // if the current input has the hasDatpicker class
                var this_id2 = $(this).attr("id"); // current inputs id
                var new_id2 =  parseInt(this_id2) + 1; // a new id
                $(this).attr("id", new_id2); // change to new id
                $(this).val('');
            }
        });
 
        $(newRow).find("select").each(function(){
            if($(this).hasClass("packageproperty")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
            }

            if($(this).hasClass("packageevent")){ // if the current input has the hasDatpicker class
                var this_id1sr = $(this).attr("id"); // current inputs id
                var new_id1sr =  parseInt(this_id1sr) + 1; // a new id
                $(this).attr("id", new_id1sr); // change to new id
            }

            if($(this).hasClass("packagestrucrate")){ // if the current input has the hasDatpicker class
                var this_idps = $(this).attr("id"); // current inputs id
                var new_idps =  parseInt(this_idps) + 1; // a new id
                $(this).attr("id", new_idps); // change to new id
            }

            if($(this).hasClass("packageref")){ // if the current input has the hasDatpicker class
                var this_idpref = $(this).attr("id"); // current inputs id
                var new_idpref =  parseInt(this_idpref) + 1; // a new id
                $(this).attr("id", new_idpref); // change to new id
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


    $("img.delRowPackage").click(function(){
        $(this).parents("tr").remove();
        $.validationEngine.closePrompt('.formError',true);
        return false;
    });

 


tinyMCE.execCommand('mceAddControl', false, 'facilities');

    $("form#form_ref_package").validationEngine();
     $("form#form_ref_package").submit(function() {
        datafac = tinyMCE.getInstanceById('facilities');
        if (datafac) {
            // copy the contents of the editor to the textarea
            $("#facilities").val(datafac.getContent());
        }
        if($("form#form_ref_package").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"package/add_master_package",
             // cache: true,
              data:$('#form_ref_package').serialize(),
              dataType:"html",
              success: function(data){
                tinyMCE.getInstanceById('facilities').setContent('');
                $("#processingx").html('Data has been saved.');
                
                $("#package_name").val('');
                $("#facilities").val('');
              },
               beforeSend: function(){
                $("#processingx").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
               }
            });
        }
	return false;
     });



      $("form#form_editrefpackage").validationEngine();
     $("form#form_editrefpackage").submit(function() {
        datafac = tinyMCE.getInstanceById('facilities');
        if (datafac) {
            // copy the contents of the editor to the textarea
            $("#facilities").val(datafac.getContent());
        }
        if($("form#form_editrefpackage").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"package/update_refpackage",
             // cache: true,
              data:$('#form_editrefpackage').serialize(),
              dataType:"html",
              success: function(data){
                tinyMCE.getInstanceById('facilities').setContent('');
                $("#processingx").html('Data has been updated.');

                $("#package_name").val('');
                $("#facilities").val('');
                 window.location = site_url +'package/';
              },
               beforeSend: function(){
                $("#processingx").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
               }
            });
        }
	return false;
     });


     $("select#property").change(function(){
        var property = $(this).val();
        var eventtype = $("select#event_type").val();
        $.ajax({
              type:"POST",
              url: site_url+"package/get_detilpackage",
             // cache: true,
              data:({property:property,
                     eventtype:eventtype}),
              dataType:"html",
              success: function(data){
                $("div#datapackage").html(data);
            
              },
               beforeSend: function(){
                $("div#datapackage").html('Loading...');
               }
            });

     })

     $("select#event_type").change(function(){
        var property = $("select#property").val();
        var eventtype = $(this).val();
       $.ajax({
              type:"POST",
              url: site_url+"package/get_detilpackage",
             // cache: true,
              data:({property:property,
                     eventtype:eventtype}),
              dataType:"html",
              success: function(data){
                $("div#datapackage").html(data);

              },
               beforeSend: function(){
                $("div#datapackage").html('Loading...');
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
                        url: site_url+"package/load_structurerate_package",
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
    
    
    $(".packageevent").live('change',function(){
        var val = $(this).val();
        var id =$(this).attr('id');
       
        $.ajax({
              type:"POST",
              url: site_url+"package/get_structurerate_by_category",
             
              data:({eventtype:val ,id:id
                      }),
              dataType:"html",
              success: function(data){
                $(".containerstrucrate[id^="+id+"]").html(data);
               // $(".containerstrucrate #csr1").html(data);

              },
               beforeSend: function(){
                $(".containerstrucrate[id^="+id+"]").html('Loading..........');
               }
            });
        return false;
    })
     
});