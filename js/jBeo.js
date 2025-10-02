/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    tinyMCE.execCommand('mceAddControl', false, 'fo_comment');
    tinyMCE.execCommand('mceAddControl', false, 'fnb_comment');
    tinyMCE.execCommand('mceAddControl', false, 'security_comment');
    tinyMCE.execCommand('mceAddControl', false, 'housekeeping_comment');
    tinyMCE.execCommand('mceAddControl', false, 'engineering_comment');
    tinyMCE.execCommand('mceAddControl', false, 'billing_comment');
    tinyMCE.execCommand('mceAddControl', false, 'signed_comment');
    tinyMCE.execCommand('mceAddControl', false, 'stewarding_comment');
    tinyMCE.execCommand('mceAddControl', false, 'kitchen_comment');


    var tabContainers = $('div#forms > div.innerContent'); // change div#forms to your new div id (example:div#pages) if you want to use tabs on another page or div.

    tabContainers.hide().filter(':first').show();
    $('ul.switcherTabsBeo a').click(function () {
    tabContainers.hide();
    tabContainers.filter(this.hash).show();
    $('ul.switcherTabsBeo li').removeClass('selected');
    $(this).parent().addClass('selected');
    $.validationEngine.closePrompt('.formError',true);
    $("#processing").html('');
    $.ajax({
          type:"POST",
          url: site_url+"beo/loading_data_beo",
          cache: false,
          success: function(data){
            $("div#box-1").html(data);
          },
          beforeSend: function(){
            $("div#box-1").html('<img src="'+base_url+'images/loading.gif"/> Loading...');
          }
    });
    return false;
}).filter(':first').click();



//$("#form_edit_beo").validationEngine();
     $("form#form_edit_beo").submit(function() {
//        if($("#form_edit_beo").validationEngine({returnIsValid:true})){

        datafnbcomment = tinyMCE.getInstanceById('fnb_comment');
        if (datafnbcomment) {
            // copy the contents of the editor to the textarea
            $("#fnb_comment").val(datafnbcomment.getContent());
        }else{
            $("#fnb_comment").val('');
        }

        datafocomment = tinyMCE.getInstanceById('fo_comment');
        if (datafocomment) {
            // copy the contents of the editor to the textarea
            $("#fo_comment").val(datafocomment.getContent());
        }else{
             $("#fo_comment").val('');
        }
        
        datasecuritycomment = tinyMCE.getInstanceById('security_comment');
        if (datasecuritycomment) {
            // copy the contents of the editor to the textarea
            $("#security_comment").val(datasecuritycomment.getContent());
        }else{
            $("#security_comment").val('');
        }

        datahkcomment = tinyMCE.getInstanceById('housekeeping_comment');
        if (datahkcomment) {
            // copy the contents of the editor to the textarea
            $("#housekeeping_comment").val(datahkcomment.getContent());
        }else{
            $("#housekeeping_comment").val('');
        }

        dataengineeringcomment = tinyMCE.getInstanceById('engineering_comment');
        if (dataengineeringcomment) {
            // copy the contents of the editor to the textarea
            $("#engineering_comment").val(dataengineeringcomment.getContent());
        }else{
            $("#engineering_comment").val('');
        }

         databillingcomment = tinyMCE.getInstanceById('billing_comment');
        if (databillingcomment) {
            // copy the contents of the editor to the textarea
            $("#billing_comment").val(databillingcomment.getContent());
        }else{
            $("#billing_comment").val('');
        }

        datasignedcomment = tinyMCE.getInstanceById('signed_comment');
        if (datasignedcomment) {
            // copy the contents of the editor to the textarea
            $("#signed_comment").val(datasignedcomment.getContent());
        }else{
            $("#signed_comment").val('');
        }
            
           
           $.ajax({
              type:"POST",
              url: site_url+"beo_letter/edit_beo_letter",
              cache: false,
              data:$('#form_edit_beo').serialize(),
              dataType:"html",
              success: function(data){
                 // alert(data)
                 $("#processing").html('<p>BEO Update.</p>  '+data );
                 $('#psubmit').hide();
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Updating...');
               }
            });

//        }
	return false;
     });


});//END DOCUMENT READY