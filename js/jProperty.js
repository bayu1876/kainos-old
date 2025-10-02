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
            $.ajax({
                type:"POST",
                url: site_url+"property/load_targetproperty",
                cache: false,
                success: function(data){
                    $("#containerdatatarget").html(data);
                },
                beforeSend: function(){
                    $("#containerdatatarget").html('<img src="'+base_url+'images/WebResource.axd.gif"/><br/>Loading...');
                }
            });
            $("#result").html('');
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
    url: site_url+"property/load_data_property",
    cache: false,
    success: function(data){
        $("#dataproperty").html(data);
    },
    beforeSend: function(){
        $("#dataproperty").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    }
});

 tinyMCE.execCommand('mceAddControl', false, 'bankproperty');

$("#form_property").validationEngine();
     $("form#form_property").submit(function() {
//           if($("#form_property").validationEngine({"ajaxKodeProperty":{
//						"file":site_url+"setup/validate_kode_property",
//						"extraData":"name=kodes",
//						"alertTextOk":"* Code available to use.",
//						"alertTextLoad":"* Checking, please wait",
//						"alertText":"* Code already used."}, returnIsValid:true})){
   if($("#form_property").validationEngine({returnIsValid:true})){
           dataproperty = tinyMCE.getInstanceById('bankproperty');
           if(dataproperty){
                // copy the contents of the editor to the textarea
                $("#bankproperty").val(dataproperty.getContent());
           }
           $.ajax({
              type:"POST",
              url: site_url+"property/add_property",
              cache: false,
              data:$('#form_property').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data has been saved.');
                $("input#kode").val('');
                $("input#namaproperty").val('');
                $("textarea#alamatproperty").val('');
                $("input#phoneproperty").val('');
                $("input#faxproperty").val('');
                $("input#emailproperty").val('');
                $("input#bankproperty").val('');
                   window.location = site_url +'property';
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



$("#form_editproperty").validationEngine();
     $("form#form_editproperty").submit(function() {
//           if($("#form_property").validationEngine({"ajaxKodeProperty":{
//						"file":site_url+"setup/validate_kode_property",
//						"extraData":"name=kodes",
//						"alertTextOk":"* Code available to use.",
//						"alertTextLoad":"* Checking, please wait",
//						"alertText":"* Code already used."}, returnIsValid:true})){
   if($("#form_editproperty").validationEngine({returnIsValid:true})){
           dataproperty = tinyMCE.getInstanceById('bankproperty');
           if(dataproperty){
                // copy the contents of the editor to the textarea
                $("#bankproperty").val(dataproperty.getContent());
           }
           $.ajax({
              type:"POST",
              url: site_url+"property/update_property",
              cache: false,
              data:$('#form_editproperty').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data has been saved.');
                $("input#kode").val('');
                $("input#namaproperty").val('');
                $("textarea#alamatproperty").val('');
                $("input#phoneproperty").val('');
                $("input#faxproperty").val('');
                $("input#emailproperty").val('');
                $("input#bankproperty").val('');
                   window.location = site_url +'property';
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


$.ajax({
    type:"POST",
    url: site_url+"property/load_targetproperty",
    cache: false,
    success: function(data){
        $("#containerdatatarget").html(data);
    },
    beforeSend: function(){
        $("#containerdatatarget").html('<img src="'+base_url+'images/WebResource.axd.gif"/><br/>Loading...');
    }
});

$("#formtargetproperty").validationEngine();

$("#formtargetproperty").submit(function(){
    if($("#formtargetproperty").validationEngine({returnIsValid:true})){
    $.ajax({
        type:"POST",
        url: site_url+"property/add_targetproperty",
        cache: false,
        data:$('#formtargetproperty').serialize(),
        success: function(data){
            $("#property").val('');
            $('#yeartarget').val('');
            $(".amount").val('0');
            $("#result").html(data);
        },
        beforeSend: function(){
            $("#result").html('<img src="'+base_url+'images/WebResource.axd.gif"/><br/>Loading...');
        }
    });
    }
    return false;
})

$("#bypropertytarget").change(function(){
    var property = $(this).val();
    var year = $("#byyeartarget").val();
    $.ajax({
        type:"POST",
         url: site_url+"property/get_targetproperty_detail",
        cache: false,
        data :({property:property,
                year:year}),
        success: function(data){
            $("#containerdatatarget").html(data);
        },
        beforeSend: function(){
            $("#containerdatatarget").html('<img src="'+base_url+'images/WebResource.axd.gif"/><br/>Loading...');
        }
    });
    return false;
})


$("#byyeartarget").change(function(){
    var property = $("#bypropertytarget").val();
    var year = $(this).val();
    $.ajax({
        type:"POST",
         url: site_url+"property/get_targetproperty_detail",
        cache: false,
        data :({property:property,
                year:year}),
        success: function(data){
            $("#containerdatatarget").html(data);
        },
        beforeSend: function(){
            $("#containerdatatarget").html('<img src="'+base_url+'images/WebResource.axd.gif"/><br/>Loading...');
        }
    });
    return false;
})

$("#activated").live('click',function(){
    var property = $("#propertyactivated").val();
    var year = $("#yearactivated").val();
    $.ajax({
        type:"POST",
        url: site_url+"property/activated_target_property",
        cache: false,
        data :({
            property:property,
            year:year
        }),
        success: function(data){
            $("#containerdatatarget").html(data);
        },
        beforeSend: function(){
            $("#containerdatatarget").html('<img src="'+base_url+'images/WebResource.axd.gif"/><br/>Loading...');
        }
    });
    return false;
})


$("#deactivated").live('click',function(){
    var property = $("#propertydeactivated").val();
    var year = $("#yeardeactivated").val();
    $.ajax({
        type:"POST",
        url: site_url+"property/deactivated_target_property",
        cache: false,
        data :({
            property:property,
            year:year
        }),
        success: function(data){
            $("#containerdatatarget").html(data);
        },
        beforeSend: function(){
            $("#containerdatatarget").html('<img src="'+base_url+'images/WebResource.axd.gif"/><br/>Loading...');
        }
    });
    return false;
})

});

 