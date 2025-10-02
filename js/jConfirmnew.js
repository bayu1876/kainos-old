/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $("#startfilter").datepicker({
        dateFormat: 'dd-mm-yy',minDate:0
    });

    $("#endfilter").datepicker({
        dateFormat: 'dd-mm-yy',minDate:0
    });

    
    $("#btnShowing").click(function(){
        var start = $("#startfilter").val();
        var end = $("#endfilter").val();
        var sales = $("#salesfilter").val();
        $.ajax({
            type:"POST",
            url: site_url+"confirmation_letter/filter_confirmation",
            data:({
                start:start,
                end:end,
                sales:sales 
            }),
            dataType:'html',
            success: function(data){
                $("#dataconfirmletter").html(data);
            },
            beforeSend: function(){
                $("#dataconfirmletter").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });
        return false;
    })
    
     $("#btnShowAll").click(function(){
     $.ajax({
    type:"POST",
    url: site_url+"confirmation_letter/loading_data_confirmation",
    cache: false,
    success: function(data){
        $("#dataconfirmletter").html(data);
    },
    beforeSend: function(){
        $("#dataconfirmletter").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    }
});
        return false;
    })
        
    
    
    
    
 $.ajax({
    type:"POST",
    url: site_url+"confirmation_letter/loading_data_confirmation",
    cache: false,
    success: function(data){
        $("#dataconfirmletter").html(data);
    },
    beforeSend: function(){
        $("#dataconfirmletter").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    }
});


$("form#form_edit_confirmationmeetingnew").submit(function() {

        var confirmx = confirm('ARE YOU SURE?');

        if(confirmx == true){


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
        dataremark = tinyMCE.getInstanceById('remarkcancelol');
        if (dataremark) {
            // copy the contents of the editor to the textarea
            $("#remarkcancelol").val(dataremark.getContent());
        }
    
     $.ajax({
            type:"POST",
            url: site_url+"confirmation_letter/edit_confirmationmeetingnew",
            data:$('#form_edit_confirmationmeetingnew').serialize(),
            dataType:"html",
            success: function(data){
                $("#processing").html('<p> '+data+'</p>');
                //alert(data);
                ///////////////////////////////////////////////////////////
                $('#changeconfirm').hide(100);
                $('#changedata').hide(100);
                $('p#psubmit').hide();

                $("#processing").html('<p> '+data+'</p>');              ///
                                                                        ///
                $('input:checkbox#cbconfirmletter').attr('checked',''); ///
                $('input:checkbox#cbchangedata').attr('checked','');    ///
                ///////////////////////////////////////////////////////////

                //$("#editproperty").val('-- Choose --');
                $("#editproperty").val('-- Choose --');
                $("#no_confirm").val('');
                $("#editaccount").val('');
                $("#idaccount").val('');
                $("#letter_date_confirm").val('');
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
                $("#editpax_letter").val('');
                $("#layout_letter").val('-- Choose --');
                $("#venue_letter").val('--Choose--');
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
                $("#roomrental").hide();
                $("input#pax_letter").val('');
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
                $('input#letter_checkout_confirm').val('');
                $('input#letter_checkin_confirm').val('');


                $("#divchangestatus").hide();
                $("#btnupdateconfirm").hide();
                 $(".button").hide();
                //tinyMCE.activeEditor.setContent('');
//                tinyMCE.getInstanceById('roomcomment').setContent('');
//                tinyMCE.getInstanceById('fnb_comment').setContent('');
//                tinyMCE.getInstanceById('package_comment').setContent('');
//                tinyMCE.getInstanceById('group_comment').setContent('');
//                tinyMCE.getInstanceById('otherpackagereqcomment').setContent('');
//                tinyMCE.getInstanceById('opcomment').setContent('');

            },
            beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Updating...');
            }
        });
        }//END IF CONFIRM

    return false;
});


$("form#form_edit_confirmationnonmeetingnew").submit(function() {
        var confirmx = confirm('ARE YOU SURE');
        if(confirmx == true){
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
        dataremark = tinyMCE.getInstanceById('remarkcancelol');
        if (dataremark) {
            // copy the contents of the editor to the textarea
            $("#remarkcancelol").val(dataremark.getContent());
        }

     $.ajax({
            type:"POST",
            url: site_url+"confirmation_letter/edit_confirmationnonmeetingnew",
            data:$('#form_edit_confirmationnonmeetingnew').serialize(),
            dataType:"html",
            success: function(data){
                 //alert(data);
//                $('#changeconfirm').hide(100);
//                $('#changedata').hide(100);
//                $('p#psubmit').hide();
//
                $("#processing").html('<p> '+data+'</p>');
//
//                $('input:checkbox#cbconfirmletter').attr('checked','');
//                $('input:checkbox#cbchangedata').attr('checked','');
//
//                //   $("div#divchangestatus").hide();
//                if(data == 'Data has changed.'){
//                    window.location = site_url +'confirmation_letter';
//                }
                 
                //alert(data);
                ///////////////////////////////////////////////////////////
                $('#changeconfirm').hide(100);
                $('#changedata').hide(100);
                $('p#psubmit').hide();

                $("#processing").html('<p> '+data+'</p>');              ///
                                                                        ///
                $('input:checkbox#cbconfirmletter').attr('checked',''); ///
                $('input:checkbox#cbchangedata').attr('checked','');    ///
                ///////////////////////////////////////////////////////////

                //$("#editproperty").val('-- Choose --');
                $("#editproperty").val('-- Choose --');
                $("#no_confirm").val('');
                $("#editaccount").val('');
                $("#idaccount").val('');
                $("#letter_date_confirm").val('');
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
                $("#editpax_letter").val('');
                $("#layout_letter").val('-- Choose --');
                $("#venue_letter").val('--Choose--');
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
                $("#roomrental").hide();
                $("input#pax_letter").val('');
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
                $('input#letter_checkout_confirm').val('');
                $('input#letter_checkin_confirm').val('');


                $("#divchangestatus").hide();
                $("#btnupdateconfirm").hide();
                 $(".button").hide();
            },
            beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Updating...');
            }
        });

}//end if Confirm
    return false;
});


    $("select.meetingstrucnew").change(function(){

        $.ajax({
            type:"POST",
            url: site_url+"confirmation_letter/generate_room_breakdown",
            // data:$('#form_edit_confirmationmeetingnew').serialize(),
            dataType:"html",
            success: function(data){
                $("div#dataroombreakdown").html(data)
            },
            beforeSend: function(){
                $("div#dataroombreakdown").html('<img src="'+base_url+'images/loading.gif"/> Loading...');
            }
        });

    })



$("#letter_checkin_confirm").datepicker({dateFormat:'dd-mm-yy'} );
$("#letter_checkout_confirm").datepicker({dateFormat:'dd-mm-yy'} );


    $("#letter_checkin_confirm").change(function() {
        $.validationEngine.closePrompt('.formError',true);
 
        var cin = $(this).val();
        var cout = $("#letter_checkout_confirm").val();

        var dt1   = parseInt(cin.substring(0,2),10);
        var mon1  = parseInt(cin.substring(3,5),10);
        var yr1   = parseInt(cin.substring(6,10),10);

        var dt2   = parseInt(cout.substring(0,2),10);
        var mon2  = parseInt(cout.substring(3,5),10);
        var yr2   = parseInt(cout.substring(6,10),10);

        var tgl_awal = new Date(yr1, mon1, dt1);
        var tgl_akhir = new Date(yr2, mon2, dt2);

        var milli_d1 = tgl_awal.getTime();
        var milli_d2 = tgl_akhir.getTime();
        var diff = milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        if (jml_hari < 0)
        {
            alert('Error, periksa tgl');
 $(this).val('');
        }else{

        }
 
    });

    $("#letter_checkout_confirm").change(function() {
        $.validationEngine.closePrompt('.formError',true);

        var cin = $("#letter_checkin_confirm").val();
        var cout = $(this).val();

        var dt1   = parseInt(cin.substring(0,2),10);
        var mon1  = parseInt(cin.substring(3,5),10);
        var yr1   = parseInt(cin.substring(6,10),10);

        var dt2   = parseInt(cout.substring(0,2),10);
        var mon2  = parseInt(cout.substring(3,5),10);
        var yr2   = parseInt(cout.substring(6,10),10);

        var tgl_awal = new Date(yr1, mon1, dt1);
        var tgl_akhir = new Date(yr2, mon2, dt2);

        var milli_d1 = tgl_awal.getTime();
        var milli_d2 = tgl_akhir.getTime();
        var diff = milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        if (jml_hari < 0)
        {
            alert('Error, periksa tgl');
            $(this).val('');
        }else{

        }

    });


    $("#status").change(function(){
    var val = $(this).val();
    if(val == 'definit'){
        $('#changeconfirm').show(100);
        $('#changedata').hide(100);
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
        $('p#psubmit').hide();
        $('input#btnupdateconfirm').hide();

    }else if(val=='cancel'){
        $('#changeconfirm').hide(100);
        $('#changedata').show(100);
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
        $('p#psubmit').hide();
        $('input#btnupdateconfirm').hide();
    }else if(val == 'LOSS' || val =='REMOVE' || val == 'POSTPONED')
    {
        $('#changedata').show(100);
        $('p#psubmit').hide();
        $('input#btnupdateconfirm').hide();
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_cancel_reason",
            cache: false,
            data:({
                status:val
            }),
            success: function(data){
                $("#containercancelreason").html(data);
            },
            beforeSend: function(){
                $("#containercancelreason").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
    }
    else{
        $('#changeconfirm').hide(100);
        $('#changedata').hide(100);
        $('p#psubmit').hide();
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
        $('p#psubmit').hide();
        $('input#btnupdateconfirm').show();
    }
});

//var statusconfirm = $("select#status").val();
//if(statusconfirm != 'confirm'){
//  $('input#btnupdateconfirm').hide();
//}
//commented for a while 12 July 2010

$("input.checkinroombreakdown").change(function(){
    var this_id = $(this).attr('id');
    var numberid = parseInt(this_id.slice(4));
    //alert(numberid);
    var qtyroom = $("input.qtyroombreakdown[id^="+numberid+"]").val();
     var night = $("input.nightroombreakdown[id^="+numberid+"]").val();
     var rate = $("input.ratepernightroombreakdown[id^="+numberid+"]").val();
     var total = parseInt(qtyroom) * parseInt(rate) * parseInt(night);
     $("input.revenueroombreakdown[id^="+numberid+"]").val(total);

     var total2 = 0;
      var totalroom = 0;
      $("input.totalfnbbreak").each(function(){
        total2 += parseInt($(this).val());
      });

      $("input.revenueroombreakdown").each(function(){
        totalroom += parseInt($(this).val());
      });


      $("input#grandtotalfnbbreak").val(total2 );

      $("input#fnbnroom").val(total2 +totalroom);
})

$("input.checkoutroombreakdown").change(function(){
    var this_id = $(this).attr('id');
    var numberid = parseInt(this_id.slice(4));

     var qtyroom = $("input.qtyroombreakdown[id^="+numberid+"]").val();
     var night = $("input.nightroombreakdown[id^="+numberid+"]").val();
     var rate = $("input.ratepernightroombreakdown[id^="+numberid+"]").val();
     var total = parseInt(qtyroom) * parseInt(rate) * parseInt(night);
     $("input.revenueroombreakdown[id^="+numberid+"]").val(total);

      var total2 = 0;
      var totalroom = 0;
      $("input.totalfnbbreak").each(function(){
        total2 += parseInt($(this).val());
      });

      $("input.revenueroombreakdown").each(function(){
        totalroom += parseInt($(this).val());
      });


      $("input#grandtotalfnbbreak").val(total2 );

      $("input#fnbnroom").val(total2 +totalroom);

})



$(".meetstrucconfirm").change(function(){
       // var meetstruc = $(this).val();
       var this_id = $(this).attr('id');

        var typepackage = $("select.packageres[id^="+this_id+"]").val();
        var property;
        if($('select#property').val() != undefined){
            property = $('select#property').val();
        }


        if($('select#editproperty').val() != undefined){
            property = $('select#editproperty').val();
        }
        var bedtype;
        bedtype =  $("select.bedtypepackage[id^="+this_id+"]").val();

        var idmpack;
        idmpack =  $("input.mpackage[id^="+this_id+"]").val();
 
        var packageres = $("select.packageres[id^="+this_id+"]").val();
        var isnonres = packageres.slice(0, 1);
    if(isnonres != 'N'){
 
    $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_packageprice_bymeetstruc",
            data:({
                meetstruc:$(this).val(),
                bedtype:bedtype,
                property:property,
                typepackage:typepackage
            }),
               dataType:'json',
        success: function(data){
           // alert(data.idmpackage);
           // $(".desres[id^="+this_id+"]").val(data.deskripsi);
            $(".hargapackres[id^="+this_id+"]").val(data.price);
            $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
            var mpack = $("input.mpackage[id^="+this_id+"]").val();
           // alert(data.price);
            var day = 0;
            var price = 0;
            var pax = 0;

            day = parseInt($("input.dayres[id^="+this_id+"]").val());
            price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
            pax = parseInt($("input.paxres[id^="+this_id+"]").val());
             if(isNaN(day)){
                    day = 0;
                }
                if(isNaN(price)){
                    price = 0;
                }
                if(isNaN(pax)){
                    pax = 0;
                }
            var total = day * price * pax
            var grandtotal = 0;
            $("input.totalres[id^="+this_id+"]").val(total);

            $(".totalres").each(function(){
                grandtotal += parseInt($(this).val());
            });

            $('input#grandtotal_res').val(grandtotal);
        },
        beforeSend: function(){
            $(".desres[id^="+this_id+"]").val('processing...');
            $(".hargapackres[id^="+this_id+"]").val('processing...');
        }

    });





    }else{
 
$.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_packageprice_bymeetstruc",
            data:({
                meetstruc:$(this).val(),
                bedtype:bedtype,
                property:property,
                typepackage:typepackage
            }),
               dataType:'json',
        success: function(data){
           // alert(data.idmpackage);
           // $(".desres[id^="+this_id+"]").val(data.deskripsi);
            $(".hargapackres[id^="+this_id+"]").val(data.price);
            $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
            var mpack = $("input.mpackage[id^="+this_id+"]").val();
           // alert(data.price);
            var day = 0;
            var price = 0;
            var pax = 0;

            day = parseInt($("input.dayres[id^="+this_id+"]").val());
            price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
            pax = parseInt($("input.paxres[id^="+this_id+"]").val());
                    if(isNaN(day)){
                        day = 0;
                    }
                    if(isNaN(price)){
                        price = 0;
                    }
                    if(isNaN(pax)){
                        pax = 0;
                    }
            var total = day * price * pax
            var grandtotal = 0;
            $("input.totalres[id^="+this_id+"]").val(total);

            $(".totalres").each(function(){
                grandtotal += parseInt($(this).val());
            });

            $('input#grandtotal_res').val(grandtotal);
        },
        beforeSend: function(){
            $(".desres[id^="+this_id+"]").val('processing...');
            $(".hargapackres[id^="+this_id+"]").val('processing...');
        }
    });

    

    }
    return false;
});





/////////////////////////////////////////////////////////////////////////



$('select.bedtype').live('change', function() {
       var this_id = $(this).attr('id');
       var property;
       if($('select#property').val() != undefined){
            property = $('select#property').val();
       }

       if($('select#editproperty').val() != undefined){
           property = $('select#editproperty').val();
       }

       var bedtype = $(this).val();
       var roomtype = $("select.roomtypenew[id^="+this_id+"]").val();
       var weektype = $("select.weektypenew[id^="+this_id+"]").val();

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_strucrateroomreq",
            data:({property:property,
                   bedtype:bedtype,
                   roomtype:roomtype,
                   weektype:weektype}),
            cache: true,
            success: function(data){
                $("#refstrucrateroom-"+this_id).html(data);
            },
            beforeSend: function(){
                $("#refstrucrateroom-"+this_id).html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
   });



   $('select.roomstrucnew').live('change', function() {
        var divid = $(this).parent("div").attr('id');
        var this_id = divid.slice(17);

        var property = $("select#editproperty").val();
        var room = $("select.roomtypenew[id^="+this_id+"]").val();
        var week = $("select.weektypenew[id^="+this_id+"]").val();
        var bedtype = $("select.bedtype[id^="+this_id+"]").val();
        var roomstruct = $(this).val();

        var account = $("input#idaccount").val();
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_roomstrucrate_price",
            data:({
                property:property,
                room:room,
                week:week,
                roomstruc:roomstruct,
                bedtype:bedtype
            }),
            dataType:"html",
            success: function(data){
                //alert(data);
                $("input.ratepernightroom[id^="+this_id+"]").val(data);
                var qtyroom = $("input.qtyroom[id^="+this_id+"]").val();
                var price =  $("input.ratepernightroom[id^="+this_id+"]").val( );
                var night = $("input.nightroom[id^="+this_id+"]").val();
                var total = night * price * qtyroom
                $("input.revenueroom[id^="+this_id+"]").val(total);

               //$("input.struct[id^="+this_id+"]").val(data.id);

                var grandtotal = 0;

                $("input.revenueroom").each(function(){

                    grandtotal += parseInt($(this).val());
                });

                $("input#totalroomrevenue").val(grandtotal);

            },
            beforeSend: function(){

            }
        });

         $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_strucrateroom",
            data:({
                property:property,
                room:room,
                week:week,
                account:account

            }),
            dataType:"html",
            success: function(data){
              //  alert(data)
              $("input.struct[id^="+this_id+"]").val(data);

            },
            beforeSend: function(){

            }
        });
    })


    $('select.roomtypenew').live('change', function() {
        var divid = $(this).parent("div").attr('id');
       var this_id = divid.slice(8);

       //var this_id = $(this).attr('id');
       var property;
       if($('select#property').val() != undefined){
            property = $('select#property').val();
       }

       if($('select#editproperty').val() != undefined){
           property = $('select#editproperty').val();
       }

       var bedtype = $("select.bedtype[id^="+this_id+"]").val();
       var roomtype = $(this).val();
       var weektype = $("select.weektypenew[id^="+this_id+"]").val();

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_strucrateroomreq",
            data:({property:property,
                   bedtype:bedtype,
                   roomtype:roomtype,
                   weektype:weektype}),
            cache: true,
            success: function(data){
                $("#refstrucrateroom-"+this_id).html(data);
            },
            beforeSend: function(){
                $("#refstrucrateroom-"+this_id).html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
   });


    $('select.weektypenew').live('change', function() {
       var this_id = $(this).attr('id');
       var property;
       if($('select#property').val() != undefined){
            property = $('select#property').val();
       }

       if($('select#editproperty').val() != undefined){
           property = $('select#editproperty').val();
       }

       var bedtype = $("select.bedtype[id^="+this_id+"]").val();
       var roomtype = $("select.roomtypenew[id^="+this_id+"]").val();
       var weektype = $(this).val();

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_strucrateroomreq",
            data:({property:property,
                   bedtype:bedtype,
                   roomtype:roomtype,
                   weektype:weektype}),
            cache: true,
            success: function(data){
                $("#refstrucrateroom-"+this_id).html(data);
            },
            beforeSend: function(){
                $("#refstrucrateroom-"+this_id).html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
   });


   $('select.confirmmeetstruc').change(function() {

       var this_id = $(this).attr('id');
       
        var property;
         if($('select#property').val() != undefined){
            property = $('select#property').val();
         }

        if($('select#editproperty').val() != undefined){
            property = $('select#editproperty').val();
        }
       var bedtype;
       bedtype =  $(".bedtypepackage[id^="+this_id+"]").val();

       var typepackage = $("select.packageres[id^="+this_id+"]").val();


      // alert(this_id);
       $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_packageprice_bymeetstruc",
            data:({
                meetstruc:$(this).val(),
                bedtype:bedtype,
                property:property,
                typepackage:typepackage
            }),
            dataType:"json",
            success: function(data){
                $("input.hargapackres[id^="+this_id+"]").val(data.price);
                $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
                var day = 0;
                var price = 0;
                var pax = 0;

                day = parseInt($("input.dayres[id^="+this_id+"]").val());
                price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
                pax = parseInt($("input.paxres[id^="+this_id+"]").val());
                if(isNaN(day)){
                    day = 0;
                }
                if(isNaN(price)){
                    price = 0;
                }
                if(isNaN(pax)){
                    pax = 0;
                }
                var total = day * price * pax
                var grandtotal = 0;
                $("input.totalres[id^="+this_id+"]").val(total);

                $(".totalres").each(function(){
                    grandtotal += parseInt($(this).val());
                });
                $('input#grandtotal_res').val(grandtotal);
              //   alert(data.idmpackage);

            },
            beforeSend: function(){

            }
        });
});



 });//END DOCUMENT READY