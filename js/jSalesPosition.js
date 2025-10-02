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
                url: site_url+"sales/load_sales_position",
                cache: true,
                success: function(data){
                    $("#datasalesposition").html(data);
                },
                beforeSend: function(){
                    $("#datasalesposition").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
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
    url: site_url+"sales/load_sales_position",
    cache: true,
    success: function(data){
        $("#datasalesposition").html(data);
    },
    beforeSend: function(){
        $("#datasalesposition").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    }
});


$("#form_edit_password").validationEngine();
     $("form#form_edit_password").submit(function() {
        if($("#form_edit_password").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"sales/change_password",
             // cache: true,
              data:$('#form_edit_password').serialize(),
              dataType:"html",
              success: function(data){
                 $("#processing").html( data);
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Updating...');
               }
            });

        }
	return false;
     });



     $("#form_position").validationEngine();
   $("form#form_position").submit(function(){
    if($("#form_position").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"sales/add_position",
              cache: true,
              data:$('#form_position').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data has been saved.');
                $("input#nama_group").val('');
                window.location = site_url +'sales/sales_position';
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

     $("#form_editposition").validationEngine();
   $("form#form_editposition").submit(function(){
    if($("#form_editposition").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"sales/update_jabatan",
              cache: true,
              data:$('#form_editposition').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data has been saved.');
                $("input#nama_jab").val('');
                window.location = site_url +'sales/sales_position';
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


});
 