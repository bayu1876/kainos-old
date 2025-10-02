/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
 


    $("#form_mobileoffering_letter").validationEngine();
    $("form#form_mobileoffering_letter").submit(function() {
        if($("#form_mobileoffering_letter").validationEngine({
            returnIsValid:true
        })){
            datacomment = tinyMCE.getInstanceById('roomcomment');
            if (datacomment) {
                // copy the contents of the editor to the textarea
                $("#roomcomment").val(datacomment.getContent());
            }
            datafnb = tinyMCE.getInstanceById('fnb_comment');
            if (datafnb) {
                // copy the contents of the editor to the textarea
                $("#fnb_comment").val(datafnb.getContent());
            }
            datapackage = tinyMCE.getInstanceById('package_comment');
            if (datapackage) {
                // copy the contents of the editor to the textarea
                $("#package_comment").val(datapackage.getContent());
            }
            datagroup = tinyMCE.getInstanceById('group_comment');
            if (datagroup) {
                // copy the contents of the editor to the textarea
                $("#group_comment").val(datagroup.getContent());
            }
            dataothpackcomment = tinyMCE.getInstanceById('otherpackagereqcomment');
            if (dataothpackcomment) {
                // copy the contents of the editor to the textarea
                $("#otherpackagereqcomment").val(dataothpackcomment.getContent());
            }
            dataopcomment = tinyMCE.getInstanceById('opcomment');
            if (dataopcomment) {
                // copy the contents of the editor to the textarea
                $("#opcomment").val(dataopcomment.getContent());
            }
            // if($("#form_offering_letter").validationEngine({returnIsValid:true})){
            $.ajax({
                type:"POST",
                url: site_url+"mobile_offering/add_offering_letter",
                // cache: true,
                data:$('#form_mobileoffering_letter').serialize(),
                dataType:"html",
                success: function(data){
                    //alert(data)
                    $("#property").val('-- Choose --');
                    $("#no_offering").val('');
                    $("#account").val('');
                    $("#idaccount").val('');
                    // $("#letter_date").val('');
                    $("#contactperson").text('');
                    $("#roomcomment").text('');
                    $("#sales").val('-- Choose --');
                    $("#eventtype").val('-- Choose --');
                    $("#package").val('-- Choose --');
                    $("#customer").val('-- Choose --');
                    $("#letter_checkin").val('');
                    $("#letter_checkout").val('');
                    $("#source").val('-- Choose --');
                    $("#event_name").val('');
                    $("#pax_letter").val('');
                    $("#layout_letter").val('-- Choose --');
                    $("#bed_type").val('-- Choose --');
                    $(".checkinroom").val('');
                    $(".checkoutroom").val('');
                    $(".nightroom").val('');
                    $(".weektype").val('');
                    $(".qtyroom").val('');
                    $(".ratepernightroom").val('');
                    $(".revenueroom").val('');
                    $(".addonrow").remove();

                    $(".checkinres").val('');
                    $(".checkoutres").val('');
                    $(".dayres").val('');
                    $(".packageres").val('-- Choose --');
                    $("#totalmeetingreq").hide();
                    $("#divpackagecomment").hide();

                    $(".checkinfnb").val('');
                    $(".checkoutfnb").val('');
                    $(".agendafnb").val('');
                    $(".startjamfnb").val('07');
                    $(".startmenitfnb").val('00');
                    $(".endjamfnb").val('07');
                    $(".endmenitfnb").val('00');
                    $("#layout_fnb").val('');
                    $(".pax_fnb").val('');
                    $("#remarkfnb").val('');
                    $("#divfnbcomment").hide();
                    $("#divgroupcomment").hide();

                 
                    $('div#divarrangement').css('display','none');
                    $('div#roomrental').css('display','none');

                    $('div#divroomreq').css('display','none');
                    $('div#divfnbreq').css('display','none');
                    $('div#divresidence').css('display','none');
                    $('div#divmeetingpackagecomment').css('display','none');
                    $('div#divadditional').css('display','none');
                    $('div#divgroupcommentparent').css('display','none');

                    $('div#divpackage').css('display','none');
                    $('div#divpackage').css('display','none');
                    $('div#divpackcomment').css('display','none');
                    $('div#divstall').css('display','none');
                    $('div#divotherpackagerequierement').css('display','none');

                    $('label#datein').text('');
                    $('label#dateout').text('');
                    $('input#letter_checkout').hide();
                    $('input#letter_checkin').hide();

                    //tinyMCE.activeEditor.setContent('');
                    tinyMCE.getInstanceById('roomcomment').setContent('');
                    tinyMCE.getInstanceById('fnb_comment').setContent('');
                    tinyMCE.getInstanceById('package_comment').setContent('');
                    tinyMCE.getInstanceById('group_comment').setContent('');
                    tinyMCE.getInstanceById('otherpackagereqcomment').setContent('');
                    tinyMCE.getInstanceById('opcomment').setContent('');
                    $("#processing").html('<p>Offering Letter created.</p>  '+data );

                    $('#psubmit').hide();
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
                }
            });

        }
        return false;
    });

 


});


