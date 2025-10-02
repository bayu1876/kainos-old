/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//jQuery.noConflict();


$(document).ready(function() {
    
    
 

$('label#datein').text('');
$('label#dateout').text('');
$('input#letter_checkout').hide();
$('input#letter_checkin').hide();

var gt = 0;
$("input.revenueroom").each(function(){
        gt += parseInt($(this).val());
    });
    if(gt > 0)
        {
        $('#totalroomreq').show();
        $('#totalroomreq').val(gt+'.00');

        }
 
tinyMCE.execCommand('mceAddControl', false, 'roomcomment');
tinyMCE.execCommand('mceAddControl', false, 'fnb_comment');
tinyMCE.execCommand('mceAddControl', false, 'package_comment');
tinyMCE.execCommand('mceAddControl', false, 'group_comment');
tinyMCE.execCommand('mceAddControl', false, 'otherpackagecomment');
tinyMCE.execCommand('mceAddControl', false, 'otherpackagereqcomment');
tinyMCE.execCommand('mceAddControl', false, 'opcomment');
tinyMCE.execCommand('mceAddControl', false, 'remarkcancelol');

var tabContainers = $('div#forms > div.innerContent'); // change div#forms to your new div id (example:div#pages) if you want to use tabs on another page or div.
tabContainers.hide().filter(':first').show();
$('ul.switcherTabsOffering a').click(function () {
    tabContainers.hide();
    tabContainers.filter(this.hash).show();
    $('ul.switcherTabsOffering li').removeClass('selected');
    $(this).parent().addClass('selected');
    $.validationEngine.closePrompt('.formError',true);
    $("#processing").html('');
    $.ajax({
          type:"POST",
          url: site_url+"offering_letter/loading_data_offering",
          cache: true,
          success: function(data){
            $("div#box-1").html(data);
          },
          beforeSend: function(){
            $("div#box-1").html('<img src="'+base_url+'images/facebox/loading.gif"/> Loading...');
          }
    });
    return false;

}).filter(':first').click();

$("#letter_date").datepicker({dateFormat:'dd-mm-yy'});
$("#letter_checkin").datepicker({dateFormat:'dd-mm-yy'} );
$("#letter_checkout").datepicker({dateFormat:'dd-mm-yy'});
$("#checkin_si").datepicker({dateFormat:'dd-mm-yy'} );
$("#checkout_si").datepicker({dateFormat:'dd-mm-yy'} );
$("#checkin_dbl").datepicker({dateFormat:'dd-mm-yy'} );
$("#checkout_dbl").datepicker({dateFormat:'dd-mm-yy'} );
$("#date_fnb").datepicker({dateFormat:'dd-mm-yy'} );

$("#cir-1").datepicker({dateFormat:'dd-mm-yy'} );
$("#cor-1").datepicker({dateFormat:'dd-mm-yy'} );

$("#letter_checkin").change(function() {
    $.validationEngine.closePrompt('.formError',true);
    $("#cir-1").val($(this).val()); //tanggal checkin meeting package
    $('input#cifnb-1').val($(this).val());

    $("#cirq-1").val($(this).val()); //tanggal checkin room requirement
    $("#cirq-2").val($(this).val()); //tanggal checkin room requirement
    
    var cin = $(this).val();
    var cout = $("#letter_checkout").val();

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
    if (jml_hari <= 0)
    {
        alert('Error, periksa tgl');
        $("input.dayres[id^='1']").val(1);
        $("input.nightroom[id^='1']").val(0);
        $("input.nightroom[id^='2']").val(0);
    }else{
        $("input.dayres[id^='1']").val(jml_hari );
        $("input.nightroom[id^='1']").val(jml_hari);
        $("input.nightroom[id^='2']").val(jml_hari);
    }

    var et = $('select#eventtype').val();
    if(et != 'ME' && et !='RO'){
        $("#letter_checkout").val($(this).val());
    } 
    
});

$("#letter_checkout").change(function() {
    $.validationEngine.closePrompt('.formError',true);

    $('input#cofnb-1').val($(this).val());
    $("#cor-1").val($(this).val()); //tanggal checkout meeting package

    $("#corq-1").val($(this).val()); //tanggal checkout room requirement
    $("#corq-2").val($(this).val()); //tanggal checkout room requirement

    var cin = $("#letter_checkin").val();
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
    if (jml_hari <= 0)
    {
        alert('Error, periksa tgl');
    }else{
        $("input.dayres[id^='1']").val(jml_hari );
        $("input.nightroom[id^='1']").val(jml_hari);
        $("input.nightroom[id^='2']").val(jml_hari);
    }
});

$("#checkin_si").change(function() {
    var cin = $(this).val();
    var cout = $("#checkout_si").val();

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
    var diff =   milli_d2 - milli_d1;
    var jml_hari = (((diff / 1000) / 60) / 60) / 24;
    if (jml_hari < 0)
    {
        alert('Error, periksa tgl');
        $("#night_si").val('-');
    }else{
        $("#night_si").val(jml_hari);
        var night = 0;
        var room = 0;
        var rate = 0;
        night = $("#night_si").val();
        room = $("#room_si").val();
        rate = $("#ratepernight_si").val();
        $("#revenue_si").val(night*room*rate);

        var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
        $("#totalroomrevenue").val(total);
    }
});

    $("#checkout_si").change(function() {
        var cin = $("#checkin_si").val();
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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
          if (jml_hari < 0)
            {
                alert('Error, periksa tgl');
                $("#night_si").val('-');
            }else{
                 $("#night_si").val(jml_hari);
                  var night = 0;
        var room = 0;
        var rate = 0;
        night = $("#night_si").val();
        room = $("#room_si").val();
        rate = $("#ratepernight_si").val();
        $("#revenue_si").val(night*room*rate);

        var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
        $("#totalroomrevenue").val(total);
       }
    });

    $("#checkin_dbl").change(function() {
        var cin = $(this).val();
        var cout = $("#checkout_dbl").val();

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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
         if (jml_hari < 0)
            {
                alert('Error, periksa tgl');
                $("#night_dbl").val('-');
            }else{
                $("#night_dbl").val(jml_hari);
                var night = 0;
                var room = 0;
                var rate = 0;
                night = $("#night_dbl").val();
                room = $("#room_dbl").val();
                rate = $("#ratepernight_dbl").val();
                $("#revenue_dbl").val(night*room*rate);

                var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
                $("#totalroomrevenue").val(total);
            }
    });


    $("#checkout_dbl").change(function() {
        var cin = $("#checkin_dbl").val();
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
        var diff =    milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
         if (jml_hari < 0)
            {
                alert('Error, periksa tgl');
                $("#night_dbl").val('-');
            }else{
                 
                $("#night_dbl").val(jml_hari);
                var night = 0;
                var room = 0;
                var rate = 0;
                night = $("#night_dbl").val();
                room = $("#room_dbl").val();
                rate = $("#ratepernight_dbl").val();
                $("#revenue_dbl").val(night*room*rate);

                var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
                $("#totalroomrevenue").val(total);
            }

                 
    });


$(".checkinres").change(function() {
        var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(4));
        var val = $(this).val();

        $(this).val(val);
        
        var cin = $(this).val();
        var cout = $(".checkoutres[id^="+"cor-"+numberid+"]").val();

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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
            if (jml_hari < 0)
            {
                alert('Error, Check Date');
                
                $("input.dayres[id^="+numberid+"]").val(0);
            }else{
                $("input.dayres[id^="+numberid+"]").val(jml_hari+1);
                var day = 0;
                var price = 0;
                var pax = 0;
                day = $("input.dayres[id^="+numberid+"]").val();
                price = $("input.hargapackres[id^="+numberid+"]").val();
                pax = $("input.paxres[id^="+numberid+"]").val();
                

                var total = day * price * pax
                $("#total_res").val(total);
            }
    });

$(".checkoutres").change(function() {
    var this_id = $(this).attr('id');
    var numberid = parseInt(this_id.slice(4));

    var cin = $(".checkinres[id^="+"cir-"+numberid+"]").val();
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
    var diff =   milli_d2 - milli_d1;
    var jml_hari = (((diff / 1000) / 60) / 60) / 24;
    //alert(jml_hari);
    if (jml_hari < 0)
    {
        alert('Error, periksa tgl');
        $("input.dayres[id^="+numberid+"]").val(0);
    }else{
        $("input.dayres[id^="+numberid+"]").val(jml_hari+1);
        var day = 0;
        var price = 0;
        var pax = 0;
        day = $("input.dayres[id^="+numberid+"]").val();
        price = $("input.hargapackres[id^="+numberid+"]").val();
        pax = $("input.paxres[id^="+numberid+"]").val();
        var total = day * price * pax
        var grandtotal = 0;
        $("input.totalres[id^="+numberid+"]").val(total);

        $(".totalres").each(function(){
            grandtotal += parseInt($(this).val());
        });
        $('input#grandtotal_res').val(grandtotal);
    }//End IF
});


$(".checkinroom").change(function() {
    var this_id = $(this).attr('id');
    var numberid = parseInt(this_id.slice(5));
    //alert(numberid);
    var cin = $(this).val();
    var cout = $(".checkoutroom[id^="+"corq-"+numberid+"]").val();

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
    var diff =   milli_d2 - milli_d1;
    var jml_hari = (((diff / 1000) / 60) / 60) / 24;
    //alert(jml_hari);
    if (jml_hari < 0)
    {
        alert('Error, periksa tgl');
        $("input.nightroom[id^="+numberid+"]").val(' - ');
    }else{
        $("input.nightroom[id^="+numberid+"]").val(jml_hari);
        var night = 0;
        var price = 0;
        var qtyroom = 0;
        night = $("input.nightroom[id^="+numberid+"]").val();
        price = $("input.ratepernightroom[id^="+numberid+"]").val();
        qtyroom = $("input.qtyroom[id^="+numberid+"]").val();
        var total = night * price * qtyroom
        $("input.revenueroom[id^="+numberid+"]").val(total);
        var grandtotal = 0;
        $("input.revenueroom").each(function(){
            grandtotal += parseInt($(this).val());
        });
        if(isNaN(grandtotal))
        {
            grandtotal = 0;
        }
        $("#totalroomrevenue").val(grandtotal);
    }//End IF
});

$(".checkoutroom").change(function() {
    var this_id = $(this).attr('id');
    var numberid = parseInt(this_id.slice(5));
    //alert(numberid);
    var cin = $(".checkinroom[id^="+"cirq-"+numberid+"]").val();
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
    var diff =   milli_d2 - milli_d1;
    var jml_hari = (((diff / 1000) / 60) / 60) / 24;
    //alert(jml_hari);
    if (jml_hari < 0)
    {
        alert('Error, periksa tgl');
        $("input.nightroom[id^="+numberid+"]").val(' - ');
    }else{
        $("input.nightroom[id^="+numberid+"]").val(jml_hari);
        var night = 0;
        var price = 0;
        var qtyroom = 0;
        night = $("input.nightroom[id^="+numberid+"]").val();
        price = $("input.ratepernightroom[id^="+numberid+"]").val();
        qtyroom = $("input.qtyroom[id^="+numberid+"]").val();
        var total = night * price * qtyroom
        $("input.revenueroom[id^="+numberid+"]").val(total);
        var grandtotal = 0;
        $("input.revenueroom").each(function(){
            grandtotal += parseInt($(this).val());
        });
        if(isNaN(grandtotal))
        {
            grandtotal = 0;
        }
        $("#totalroomrevenue").val(grandtotal);
    }//End IF
});


$("input.qtyroom").keyup(function(){
    $('#totalroomreq').show();
    var this_id = $(this).attr('id');
   // alert(this_id);
    var qtyroom = $(this).val();
    var price = $("input.ratepernightroom[id^="+this_id+"]").val();
    var night = $("input.nightroom[id^="+this_id+"]").val();
    var total = night * price * qtyroom
    $("input.revenueroom[id^="+this_id+"]").val(total);

    var grandtotal = 0;
    $("input.revenueroom").each(function(){
        grandtotal += parseInt($(this).val());
    });

   $("input#totalroomrevenue").val(grandtotal);
   return false;
});
    

$("input.priceperpax").keyup(function(){
    var this_id = $(this).attr('id');
    var price = $(this).val();
    var pax = $(".paxfnb[id^="+this_id+"]").val();

    $(".revenuefnb[id^="+this_id+"]").val(price*pax);
    //alert(this_id);
    var total = 0;
    $(".revenuefnb").each(function(){
        total += parseInt($(this).val());
    });

    $("#total_revenue_fnb").val(total);
    return false;
});

$("input.paxfnb").keyup(function(){
    var this_id = $(this).attr('id');
    var price = $(".priceperpax[id^="+this_id+"]").val();
    var pax = $(this).val();

    $(".revenuefnb[id^="+this_id+"]").val(price*pax);
    var total = 0;
    $(".revenuefnb").each(function(){
        total += parseInt($(this).val());
    });
    $("#total_revenue_fnb").val(total);
    return false;
});
/////////////////////////////////////////////////////////////////

$(".packageres").change(function(){
    var packageres = $(this).val();
    var this_id = $(this).attr('id');
//    $(".desres[id^="+this_id+"]").val(packageres);
//    $(".hargapackres[id^="+this_id+"]").val(packageres);
//    alert(this_id);
    var property;
     if($('select#property').val() != undefined){
        property = $('select#property').val();
     }

    if($('select#editproperty').val() != undefined){
        property = $('select#editproperty').val();
    }
    
    var bedtype;
    bedtype =  $(".bedtypepackage[id^="+this_id+"]").val();

    
  
    var isnonres = packageres.slice(0,1)
// alert(property);
  
   
//   alert(bedtype);
//    if($('select.meetstruc').val() == undefined){
if(isnonres != 'N'){
   
    $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_detil_package/" ,
        cache: true,
        data:({kode: $(this).val(), property:property, bedtype:bedtype}),
        dataType:'json',
        success: function(data){
            //alert('idmpack:'+data.idmpackage);
            //(".desres[id^="+this_id+"]").val(data.deskripsi);
            $("input.hargapackres[id^="+this_id+"]").val(data.price);
            $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
            var mpack = $("input.mpackage[id^="+this_id+"]").val();
            //alert(mpack);
            var day = 0;
            var price = 0;
            var pax = 0;
            day = parseInt($("input.dayres[id^="+this_id+"]").val());
            price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
            pax = parseInt($("input.paxres[id^="+this_id+"]").val());

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
        url: site_url+"offering_letter/get_detil_packagenonres/" ,
        cache: true,
        data:({kode: $(this).val(), property:property}),
        dataType:'json',
        success: function(data){
            //alert('idmpack:'+data.idmpackage);
            //(".desres[id^="+this_id+"]").val(data.deskripsi);
            $("input.hargapackres[id^="+this_id+"]").val(data.price);
            $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
            var mpack = $("input.mpackage[id^="+this_id+"]").val();
            //alert(mpack);
            var day = 0;
            var price = 0;
            var pax = 0;
            day = parseInt($("input.dayres[id^="+this_id+"]").val());
            price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
            pax = parseInt($("input.paxres[id^="+this_id+"]").val());

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

//}
//else
//{
//     var idmpack;
//        idmpack =  $("input.mpackage[id^="+this_id+"]").val();
//    var meetstruc = $("select.meetstruc[id^="+this_id+"]").val();
//    $.ajax({
//        type:"POST",
//        url: site_url+"offering_letter/get_detil_editmpackage/" ,
//        cache: true,
//        data:({meetstruc: meetstruc, property: property,bedtype:bedtype,kode:idmpack}),
//        dataType:'json',
//        success: function(data){
//           // $(".desres[id^="+this_id+"]").val(data.deskripsi);
//            $(".hargapackres[id^="+this_id+"]").val(data.price);
//            $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
//            var mpack = $("input.mpackage[id^="+this_id+"]").val();
//           // alert(data.price);
//            var day = 0;
//            var price = 0;
//            var pax = 0;
//            day = parseInt($("input.dayres[id^="+this_id+"]").val());
//            price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
//            pax = parseInt($("input.paxres[id^="+this_id+"]").val());
//
//            var total = day * price * pax
//            var grandtotal = 0;
//            $("input.totalres[id^="+this_id+"]").val(total);
//
//            $(".totalres").each(function(){
//                grandtotal += parseInt($(this).val());
//            });
//
//            $('input#grandtotal_res').val(grandtotal);
//        },
//        beforeSend: function(){
//            $(".desres[id^="+this_id+"]").val('processing...');
//            $(".hargapackres[id^="+this_id+"]").val('processing...');
//        }
//    });
//
//}
return false;
    
});
///END PACKAGERES//////////////////////////////////////////////////////

$(".meetstruc").change(function(){

        var meetstruc = $(this).val();
        var this_id = $(this).attr('id');
        

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
//        alert(this_id);
//        alert(meetstruc);
//        alert(property);
//        alert(bedtype);
//        alert(packres);
        var packageres = $("select.packageres[id^="+this_id+"]").val();
        var isnonres = packageres.slice(0, 1);
    if(isnonres != 'N'){

    $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_detil_editmpackage/" ,
        cache: true,
        data:({meetstruc: $(this).val(), property: property,bedtype:bedtype,kode:idmpack}),
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

//AJAX for get price room breakdown
    $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_roompricemp_by_meetstructmpackage/" ,
        cache: true,
        data:({meetstruc: $(this).val(), property: property,bedtype:bedtype,kode:idmpack}),
        dataType:'json',
        success: function(data){
            // alert(data.strucrate)
            var total;
            var night =  $("input.nightroombreakdown[id^="+this_id+"]").val();
            var qtyroom = $("input.qtyroombreakdown[id^="+this_id+"]").val();
            var rate = data.price;
            total = parseInt(night) * parseInt(qtyroom) * parseInt(rate);
            $(".ratepernightroombreakdown[id^="+this_id+"]").val(data.price);
            $(".revenueroombreakdown[id^="+this_id+"]").val(total);
             
        },
        beforeSend: function(){
             $(".ratepernightroombreakdown[id^="+this_id+"]").val('processing...');
        }

    });

    //AJAX for get price f&b breakdown
     $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_fnbpricemp_by_meetstructmpackage/" ,
        cache: true,
        data:({meetstruc: $(this).val(), property: property, bedtype:bedtype,kode:idmpack}),
        dataType:'json',
        success: function(data){
             $(".cb1[id^="+this_id+"]").val(data.cb1);
             $(".cb2[id^="+this_id+"]").val(data.cb2);
             $(".lunch[id^="+this_id+"]").val(data.lunch);
             $(".dinner[id^="+this_id+"]").val(data.dinner);

             $(".idmpackagefnbbreak[id^="+this_id+"]").val(data.idmpackage);
             

             var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();
             var days = $("input.daysfnbbreakdown[id^="+this_id+"]").val();
             var cb1 = $("input.cb1[id^="+this_id+"]").val();
             var cb2 = $("input.cb2[id^="+this_id+"]").val();
             var lunch = $("input.lunch[id^="+this_id+"]").val();
             var dinner = $("input.dinner[id^="+this_id+"]").val();
             var total = (parseInt(cb1) + parseInt(cb2) + parseInt(lunch)+ parseInt(dinner)) * pax * days;
             $("input.totalfnbbreak[id^="+this_id+"]").val(total);
        },
        beforeSend: function(){
             $(".cb1[id^="+this_id+"]").val('processing..');
             $(".cb2[id^="+this_id+"]").val('processing..');
             $(".lunch[id^="+this_id+"]").val('processing..');
             $(".dinner[id^="+this_id+"]").val('processing..');
        }

    });

    }else{

    $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_detil_editmpackagenonres/" ,
        cache: true,
        data:({meetstruc: $(this).val(), property: property, kode:idmpack}),
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

    //AJAX for get price f&b breakdown
     $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_fnbpricemp_by_meetstructmpackage/" ,
        cache: true,
        data:({meetstruc: $(this).val(), property: property, bedtype:bedtype,kode:idmpack}),
        dataType:'json',
        success: function(data){
             $(".cb1[id^="+this_id+"]").val(data.cb1);
             $(".cb2[id^="+this_id+"]").val(data.cb2);
             $(".lunch[id^="+this_id+"]").val(data.lunch);
             $(".dinner[id^="+this_id+"]").val(data.dinner);
             $(".idmpackagefnbbreak[id^="+this_id+"]").val(data.dinner);
              
             var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();
             var days = $("input.daysfnbbreakdown[id^="+this_id+"]").val();
             var cb1 = $("input.cb1[id^="+this_id+"]").val();
             var cb2 = $("input.cb2[id^="+this_id+"]").val();
             var lunch = $("input.lunch[id^="+this_id+"]").val();
             var dinner = $("input.dinner[id^="+this_id+"]").val();
             var total = (parseInt(cb1) + parseInt(cb2) + parseInt(lunch)+ parseInt(dinner)) * days * pax;
            $("input.totalfnbbreak[id^="+this_id+"]").val(total);
        },
        beforeSend: function(){
             $(".cb1[id^="+this_id+"]").val('processing..');
             $(".cb2[id^="+this_id+"]").val('processing..');
             $(".lunch[id^="+this_id+"]").val('processing..');
             $(".dinner[id^="+this_id+"]").val('processing..');
        }

    });
    
    }
    return false;
});


$("select.bedtypepackage").change(function(){
    var this_id = $(this).attr('id');
    //alert(this_id);
    var property;
    if($('select#property').val() != undefined){
                    property = $('select#property').val();
                }

    if($('select#editproperty').val() != undefined){
        property = $('select#editproperty').val();
    }

    var packres;
    packres =  $("select.packageres[id^="+this_id+"]").val();

   
    if($('select.meetstruc').val() == undefined || $('select.meetstruc').val() == ''){
    $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_detil_package/" ,
        cache: true,
        data:({bedtype: $(this).val(), property: property,kode:packres}),
        dataType:'json',
        success: function(data){
           
             
          //$(".desres[id^="+this_id+"]").val(data.deskripsi);
            $(".hargapackres[id^="+this_id+"]").val(data.price);
            $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
            var mpack = $("input.mpackage[id^="+this_id+"]").val();
            //alert(mpack);
            var day = 0;
            var price = 0;
            var pax = 0;
            
            day = parseInt($("input.dayres[id^="+this_id+"]").val());
            price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
            pax = parseInt($("input.paxres[id^="+this_id+"]").val());

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
    else
        {
            var idmpack;
            idmpack =  $("input.mpackage[id^="+this_id+"]").val();
            var meetstruc = $("select.meetstruc[id^="+this_id+"]").val();
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_detil_editmpackage/" ,
                cache: true,
                data:({meetstruc: meetstruc, property: property,bedtype:$(this).val(),kode:idmpack}),
                dataType:'json',
                success: function(data){
                    //alert(data.idmpackage);
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

        }//END IF
        return false;
});

 $("input.paxres").keyup(function(){
                $('#totalmeetingreq').show();
                var this_id = $(this).attr('id');

                var day = 0;
                var price = 0;
                var pax = 0;
                day = parseInt($("input.dayres[id^="+this_id+"]").val());
                price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
                pax = parseInt($(this).val());

                var total = day * price * pax
                var grandtotal = 0;
                $("input.totalres[id^="+this_id+"]").val(total);

                $(".totalres").each(function(){
                    if($(this).val() == '')
                        {
                            grandtotal +=0;
                        }else
                            {
                                grandtotal += parseInt($(this).val());
                            }

                    
                });

                $('input#grandtotal_res').val(grandtotal);
        return false;
    });

    $("#property").change(function() {
       // alert($(this).val());
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_venueletter_by_property/"+$(this).val(),
            cache: true,
            success: function(data){
                $("div#venueletter").html(data);
            },
            beforeSend: function(){
                $("div#venueletter").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
            }
        });

        var eventtype = $('select#eventtype').val();



        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_package_byprop",
            data:({
                eventtype:eventtype,
                property:$(this).val()
            }),
            dataType:"html",
            success: function(data){
                $("#packagebyprop").html(data );
            },
            beforeSend: function(){
                $("#packagebyprop").html('<img src="'+base_url+'images/facebox/loading.gif"/>');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_venue_by_property/"+$(this).val(),
            cache: true,
            success: function(data){
                $("div#venuex").html(data);
            },
            beforeSend: function(){
                $("div#venuex").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
            }
        });


       $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_room_by_property/"+$(this).val(),
            cache: true,
            //dataType:'json',
            success: function(data){
                          
                $("div#refroom-1").html(data);
                $("div#refroom-2").html(data);
                $("div#refroom-3").html(data);
            },
            beforeSend: function(){

                $("div#refroom-1").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                $("div#refroom-2").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                $("div#refroom-3").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
            }
        });
                

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/generate_number/"+$(this).val(),
            cache: true,
            success: function(data){
                //alert(data);
                $("input#no_offering").val(data);
            },
            beforeSend: function(){
                $("input#no_offering").val("generating...");
            }
        });

//                $.ajax({
//                      type:"POST",
//                      url: site_url+"offering_letter/loading_data_package/"+$(this).val(),
//                      cache: true,
//                      success: function(data){
//                         //alert(data);
//                       $("div#package_property").html(data);
//                      },
//                      beforeSend: function(){
//                            $("div#package_property").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
//
//                        }
//                });
    });//end hotel

$('select.roomtype').live('change', function() {
                var divid = $(this).parent("div").attr('id');
                
                var numberid = divid.slice(8);
                var roomtype  = $(this).val();
                var weektype = $("select.weektype[id^="+numberid+"]").val();
                var account = $('input#idaccount').val();
               // var property = $('select#property').val();
                var property;

                if($('select#property').val() != undefined){
                    property = $('select#property').val();
                }

                if($('select#editproperty').val() != undefined){
                    property = $('select#editproperty').val();
                }

               // alert(property);
               // alert(weektype);
               // alert(roomtype);
               //alert(roomtype +'\n'+weektype+'\n'+account+'\n'+property);
                $.ajax({
                    type:"POST",
                    url: site_url+"offering_letter/get_room_price",
                    data:({account:account,
                           roomtype: roomtype,
                           property: property,
                           weektype: weektype}),
                    dataType:'json',
                    success: function(data){
                          //alert(data.acc +'\n'+data.prop+'\n'+data.rtype+'\n'+data.wtype+'\n');
                        $("input.ratepernightroom[id^="+numberid+"]").val(data.price);
                         $("input.struct[id^="+numberid+"]").val(data.id);
                       //  alert($("input.struct[id^="+numberid+"]").val());
                        var qtyroom = $("input.qtyroom[id^="+numberid+"]").val();
                        var price = data.price;
                        var night = $("input.nightroom[id^="+numberid+"]").val();
                        var total = night * price * qtyroom
                        $("input.revenueroom[id^="+numberid+"]").val(total);

                         var grandtotal = 0;
                        $("input.revenueroom").each(function(){
                            grandtotal += parseInt($(this).val());
                        });

                       $("input#totalroomrevenue").val(grandtotal);
                    },
                    beforeSend: function(){
                        $("input.ratepernightroom[id^="+numberid+"]").val("processing...");
                        $("input.revenueroom[id^="+numberid+"]").val('calculating...');
                        $("input#totalroomrevenue").val('calculating...');
                    }
                 });
          });


$("select.weektype").change(function() {
    //alert($(this).val());
    var this_id = $(this).attr('id');
    
    var roomtype  = $("div#refroom-"+this_id+" > select.roomtype").val();
    var weektype = $(this).val();
    var account = $('input#idaccount').val();
    //var property = $('select#property').val();

      var property;

                if($('select#property').val() != undefined){
                    property = $('select#property').val();
                }

                if($('select#editproperty').val() != undefined){
                    property = $('select#editproperty').val();
                }
    //alert(roomtype +'\n'+weektype+'\n'+account+'\n'+property);
    $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_room_price",
        data:({account:account,
               roomtype: roomtype,
               property: property,
               weektype: weektype}),
        dataType:'json',
        success: function(data){
              //alert(data.acc +'\n'+data.prop+'\n'+data.rtype+'\n'+data.wtype+'\n');
            $("input.ratepernightroom[id^="+this_id+"]").val(data.price);
            $("input.struct[id^="+this_id+"]").val(data.id);
            var strucval = $("input.struct[id^="+this_id+"]").val(); //untuk testing aja
            //alert(strucval);
            var qtyroom = $("input.qtyroom[id^="+this_id+"]").val();
            var price = data.price;
            var night = $("input.nightroom[id^="+this_id+"]").val();
            var total = night * price * qtyroom
            $("input.revenueroom[id^="+this_id+"]").val(total);
             var grandtotal = 0;
                        $("input.revenueroom").each(function(){
                            grandtotal += parseInt($(this).val());
                        });

                       $("input#totalroomrevenue").val(grandtotal);
        },
        beforeSend: function(){
             $("input.ratepernightroom[id^="+this_id+"]").val("processing...");
             $("input.revenueroom[id^="+this_id+"]").val('calculating...');
             $("input#totalroomrevenue").val('calculating...');
        }
    });

});//end Week TYPE




$("#week_si").change(function() {
// alert($(this).val());
$.ajax({
    type:"POST",
    url: site_url+"offering_letter/get_room_price",
    data:({company:$("#customer").val(),room: $('div#refroom_si > #type').val(), property: $("#property").val(),week:$(this).val()}),
    dataType:'json',
    success: function(data){
        //alert(data.id);
        $('#idstrucrate_si').val(data.id);
        $("#ratepernight_si").val(data.price);
    },
    beforeSend: function(){
        $("#ratepernight_si").val("processing...");
    }
});

});//end week si


$("#week_dbl").change(function() {
       // alert($(this).val());
//       $.post(site_url+"offering_letter/get_room_price", { company:$("#customer").val(),room: $('div#refroom_dbl > #type').val(), property: $("#property").val(),week:$(this).val() },
//            function(data){
//           // alert( data);
//            $("#ratepernight_dbl").val(data);
//        });
            $.ajax({
                      type:"POST",
                      url: site_url+"offering_letter/get_room_price",
                      data:({company:$("#customer").val(),room: $('div#refroom_dbl > #type').val(), property: $("#property").val(),week:$(this).val()}),
                      dataType:'json',
                      success: function(data){
                         //alert(data);
                        $('#idstrucrate_dbl').val(data.id);
                        $("#ratepernight_dbl").val(data.price);

                      },
                      beforeSend: function(){
                       $("#ratepernight_dbl").val("processing...");
                        }
                });
    });//end week si


$("select.additionaldes").change(function() {
        var this_id = $(this).attr('id');

       $.ajax({
                      type:"POST",
                      url: site_url+"offering_letter/get_additional_detil",
                      data:({id:$(this).val()}),
                      dataType:'json',
                      success: function(data){
                         //alert(data.id);
                        
                         $("input.qtyadd[id^="+this_id+"]").val(data.qty);
                         $("input.unitadd[id^="+this_id+"]").val(data.unit);
                         $("input.priceadd[id^="+this_id+"]").val(data.price);
                         $("input.totaladd[id^="+this_id+"]").val(data.price);

                      },
                      beforeSend: function(){
                        $("input.qtyadd[id^="+this_id+"]").val("loading...");
                         $("input.unitadd[id^="+this_id+"]").val("loading...");
                         $("input.priceadd[id^="+this_id+"]").val("loading...");
                         $("input.totaladd[id^="+this_id+"]").val("loading...");
                        }
                });

    });




    $("#customer").change(function() {
        if($(this).val() != ''){
            $.ajax({
                  type:"POST",
                  url: site_url+"offering_letter/get_customer/"+$(this).val(),
                  success: function(data){
                     //alert(data);
                    $('#contact').val(data);

                 },
                  beforeSend: function(){
                   $("#contact").val("processing...");
                 }
                });
                }else
                {
                    $("#contact").val("-");
                }
    });//end week si


                                $(".my_date").datepicker({
					dateFormat: 'dd-mm-yy',
					showButtonPanel: true
				});

				// -- Clone table rows
				$(".cloneTableRows").live('click', function(){
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

                                                if($(this).hasClass("priceperpax")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id
							 
						}

                                                 if($(this).hasClass("paxfnb")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id

						}

                                                if($(this).hasClass("revenuefnb")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
						}


                                                if($(this).hasClass("agendafnb")){ // if the current input has the hasDatpicker class
							var this_id9 = $(this).attr("id"); // current inputs id
							var new_id9 =  parseInt(this_id9) + 1; // a new id
							$(this).attr("id", new_id9); // change to new id
                                                       // $(this).val('');
						}

                                               


					});

                                        $(newRow).find("select").each(function(){
                                             if($(this).hasClass("endjamfnb")){ // if the current input has the hasDatpicker class

							$(this).attr("id", parseInt($(this).attr("id")) + 1); // change to new id

						}


                                                  if($(this).hasClass("startjamfnb")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id

						}


                                                if($(this).hasClass("startmenitfnb")){ // if the current input has the hasDatpicker class
							var this_id6 = $(this).attr("id"); // current inputs id
							var new_id6 =  parseInt(this_id6) + 1; // a new id
							$(this).attr("id", new_id6); // change to new id

						}



                                                if($(this).hasClass("endmenitfnb")){ // if the current input has the hasDatpicker class
							var this_id8 = $(this).attr("id"); // current inputs id
							var new_id8 =  parseInt(this_id8) + 1; // a new id
							$(this).attr("id", new_id8); // change to new id
						}

                                        });

                                      

                                        

					return false;
				});

                                /////Room Req
                                $(".cloneRowsRoomReq").live('click', function(){
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
					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");

					// clear the inputs (Optional)
					$('#'+thisTableId + " tr:last td :input").val('');
                                        // new rows datepicker need to be re-initialized
					$(newRow).find("input").each(function(){
						if($(this).hasClass("hasDatepicker")){ // if the current input has the hasDatpicker class
							var this_id = $(this).attr("id"); // current inputs id

							var txtid = this_id.slice(0,5);
                                                        var numberid = this_id.slice(5);
                                                        var new_id = parseInt(numberid) + 1;
                                                        // a new id

							$(this).attr("id", txtid+new_id); // change to new id
							$(this).removeClass('hasDatepicker'); // remove hasDatepicker class
							 // re-init datepicker
							$(this).datepicker({
								dateFormat: 'dd-mm-yy',
								showButtonPanel: true
							});
						}

                                               if($(this).hasClass("nightroom")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id
                                                        $(this).val('');
						}

                                                if($(this).hasClass("qtyroom")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id
                                                        $(this).val('');
						}

                                                if($(this).hasClass("ratepernightroom")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
                                                        $(this).val('');
                                                }

                                                if($(this).hasClass("revenueroom")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id
                                                        $(this).val('');
                                                }
 					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("weektype")){ // if the current input has the hasDatpicker class
							var this_id6 = $(this).attr("id"); // current inputs id
							var new_id6 =  parseInt(this_id6) + 1; // a new id
							$(this).attr("id", new_id6); // change to new id

						}
                                        });

                                        $(newRow).find("div").each(function(){
                                            if($(this).hasClass("refroomtype")){ // if the current input has the hasDatpicker class
							var this_id7 = $(this).attr("id"); // current inputs id

                                                        var txtid = this_id7.slice(0,8);
                                                        var numberid = this_id7.slice(8);
                                                        var new_id7 = parseInt(numberid) + 1;
                                                       
							$(this).attr("id", txtid+new_id7); // change to new id
						}
                                        });

                                       $(newRow).find("input:hidden").each(function(){
                                            if($(this).hasClass("struct")){ // if the current input has the hasDatpicker class
							var this_id8 = $(this).attr("id"); // current inputs id


                                                        var new_id8 = parseInt(this_id8) + 1;

							$(this).attr("id",new_id8); // change to new id
						}
                                        });




                                       
				});
                                //End Room Req

                           /////EDIT Room Req
                                $(".cloneRowsEditRoomReq").live('click', function(){
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
					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");

					// clear the inputs (Optional)
					//$('#'+thisTableId + " tr:last td :input").val('');
                                        // new rows datepicker need to be re-initialized
					$(newRow).find("input").each(function(){
						if($(this).hasClass("hasDatepicker")){ // if the current input has the hasDatpicker class
							var this_id = $(this).attr("id"); // current inputs id

							var txtid = this_id.slice(0,5);
                                                        var numberid = this_id.slice(5);
                                                        var new_id = parseInt(numberid) + 1;
                                                        // a new id

							$(this).attr("id", txtid+new_id); // change to new id
							$(this).removeClass('hasDatepicker'); // remove hasDatepicker class
							 // re-init datepicker
							$(this).datepicker({
								dateFormat: 'dd-mm-yy',
								showButtonPanel: true
							});
						}

                                               if($(this).hasClass("nightroom")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id

						}

                                                if($(this).hasClass("qtyroom")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id
                                                        $(this).val('');
						}

                                                if($(this).hasClass("ratepernightroom")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
                                                        
                                                }

                                                if($(this).hasClass("revenueroom")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id
                                                        $(this).val('');
                                                }
 					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("weektype")){ // if the current input has the hasDatpicker class
							var this_id6 = $(this).attr("id"); // current inputs id
							var new_id6 =  parseInt(this_id6) + 1; // a new id
							$(this).attr("id", new_id6); // change to new id

						}
                                        });

                                        $(newRow).find("div").each(function(){
                                            if($(this).hasClass("refroomtype")){ // if the current input has the hasDatpicker class
							var this_id7 = $(this).attr("id"); // current inputs id

                                                        var txtid = this_id7.slice(0,8);
                                                        var numberid = this_id7.slice(8);
                                                        var new_id7 = parseInt(numberid) + 1;

							$(this).attr("id", txtid+new_id7); // change to new id
						}
                                        });

                                       $(newRow).find("input:hidden").each(function(){
                                            if($(this).hasClass("struct")){ // if the current input has the hasDatpicker class
							var this_id8 = $(this).attr("id"); // current inputs id


                                                        var new_id8 = parseInt(this_id8) + 1;

							$(this).attr("id",new_id8); // change to new id
						}
                                        });
				});
                                //End EDIT Room Req


                                 /////EDIT Room Breakout
                                $(".cloneRowsEditRoomBreakout").live('click', function(){
					// this tables id
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
                                        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
					// clear the inputs (Optional)
					//$('#'+thisTableId + " tr:last td :input").val('');

					// new rows datepicker need to be re-initialized
					$(newRow).find("input").each(function(){
						if($(this).hasClass("hasDatepicker")){ // if the current input has the hasDatpicker class
                                                        var this_id = $(this).attr("id"); // current inputs id

							var txtid = this_id.slice(0,4);
                                                        var numberid = this_id.slice(4);

                                                        var new_id = parseInt(numberid) + 1;
                                                        // a new id
                                                        
                                                        

							$(this).attr("id", txtid+new_id); // change to new id
							$(this).removeClass('hasDatepicker'); // remove hasDatepicker class
							 // re-init datepicker
							$(this).datepicker({
								dateFormat: 'dd-mm-yy',
								showButtonPanel: true
							});
						}

                                                     if($(this).hasClass("nightroombreakdown")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
						}

                                                  if($(this).hasClass("qtyroombreakdown")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id
						}

                                                   if($(this).hasClass("ratepernightroombreakdown")){ // if the current input has the hasDatpicker class
							var this_id6 = $(this).attr("id"); // current inputs id
							var new_id6 =  parseInt(this_id6) + 1; // a new id
							$(this).attr("id", new_id6); // change to new id
						}

                                                  if($(this).hasClass("revenueroombreakdown")){ // if the current input has the hasDatpicker class
							var this_id7 = $(this).attr("id"); // current inputs id
							var new_id7 =  parseInt(this_id7) + 1; // a new id
							$(this).attr("id", new_id7); // change to new id
                                                    }
					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("weektypebreakdown")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
						}
                                        });
					return false;
				});
                                //End EDIT Room Breakout



                                $(".cloneRowsRoomComment").live('click', function(){
                                        $("div#divroomcomment").toggle();
//                                        $( "div#divroomcomment" ).toggle(function() {
//                                              alert('First handler for .toggle() called.');
//                                            }, function() {
//                                              alert('Second handler for .toggle() called.');
//                                            });
//					// this tables id
//					var thisTableId = $(this).parents("table").attr("id");
//
//					// lastRow
//					var lastRow = $('#'+thisTableId + " tr:last");
//
//					// clone last row
//					var newRow = lastRow.clone(true);
//
//					// append row to this table
//					$('#'+thisTableId).append(newRow);
//
//
//					// make the delete image visible
//					//$('#'+thisTableId + " tr:last td:first img").css("visibility", "visible");
//                                        $('#'+thisTableId + " tr:last  ").css("display", "");
//                                        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
//                                        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//
//					// clear the inputs (Optional)
//					$('#'+thisTableId + " tr:last td :input").val('');
//
//					// new rows datepicker need to be re-initialized

					return false;
				});


                                 $(".cloneRowsBanquetComment").live('click', function(){
                                        $("div#divfnbcomment").toggle();
//					// this tables id
//					var thisTableId = $(this).parents("table").attr("id");
//
//					// lastRow
//					var lastRow = $('#'+thisTableId + " tr:last");
//
//					// clone last row
//					var newRow = lastRow.clone(true);
//
//					// append row to this table
//					$('#'+thisTableId).append(newRow);
//
//					// make the delete image visible
//                                        $('#'+thisTableId + " tr:last  ").css("display", "");
//                                        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
//                                        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//
//					// clear the inputs (Optional)
//					$('#'+thisTableId + " tr:last td :input").val('');

					// new rows datepicker need to be re-initialized

					return false;
				});



                                $(".cloneRowsPackageComment").live('click', function(){
                                    $("div#divpackagecomment").toggle();
//					// this tables id
//					var thisTableId = $(this).parents("table").attr("id");
//
//					// lastRow
//					var lastRow = $('#'+thisTableId + " tr:last");
//
//					// clone last row
//					var newRow = lastRow.clone(true);
//
//					// append row to this table
//					$('#'+thisTableId).append(newRow);
//
//					// make the delete image visible
//                                        $('#'+thisTableId + " tr:last  ").css("display", "");
//                                        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
//                                        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//
//					// clear the inputs (Optional)
//					$('#'+thisTableId + " tr:last td :input").val('');
//
//					// new rows datepicker need to be re-initialized

					return false;
				});



                                $(".cloneRowsGroupComment").live('click', function(){
                                $("div#divgroupcomment").toggle();
//					// this tables id
//					var thisTableId = $(this).parents("table").attr("id");
//
//					// lastRow
//					var lastRow = $('#'+thisTableId + " tr:last");
//
//					// clone last row
//					var newRow = lastRow.clone(true);
//
//					// append row to this table
//					$('#'+thisTableId).append(newRow);
//
//					// make the delete image visible
//                                        $('#'+thisTableId + " tr:last  ").css("display", "");
//                                        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
//                                        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//
//					// clear the inputs (Optional)
//					$('#'+thisTableId + " tr:last td :input").val('');

					// new rows datepicker need to be re-initialized

					return false;
				});



                                $(".cloneRowsOPRComment").live('click', function(){
                                    $("div#divoprcomment").toggle();
//					// this tables id
//					var thisTableId = $(this).parents("table").attr("id");
//
//					// lastRow
//					var lastRow = $('#'+thisTableId + " tr:last");
//
//					// clone last row
//					var newRow = lastRow.clone(true);
//
//					// append row to this table
//					$('#'+thisTableId).append(newRow);
//
//					// make the delete image visible
//                                        $('#'+thisTableId + " tr:last  ").css("display", "");
//                                        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
//                                        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
//
//					// clear the inputs (Optional)
//					$('#'+thisTableId + " tr:last td :input").val('');

					// new rows datepicker need to be re-initialized

					return false;
				});



                       $(".cloneTableResidence").live('click', function(){
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
                                        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
					// clear the inputs (Optional)
					//$('#'+thisTableId + " tr:last td :input").val('');

					// new rows datepicker need to be re-initialized
					$(newRow).find("input").each(function(){
						if($(this).hasClass("hasDatepicker")){ // if the current input has the hasDatpicker class
							var this_id = $(this).attr("id"); // current inputs id
                                                        
                                                        
							var txtid = this_id.slice(0,4);
                                                        var numberid = this_id.slice(4);
                                                        var new_id = parseInt(numberid) + 1;
                                                        // a new id

							$(this).attr("id", txtid+new_id); // change to new id
							$(this).removeClass('hasDatepicker'); // remove hasDatepicker class
							 // re-init datepicker
							$(this).datepicker({
								dateFormat: 'dd-mm-yy',
								showButtonPanel: true
							});


						}


                                                if($(this).hasClass("desres")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id
                                                        $(this).val('');
						}

                                                

                                                if($(this).hasClass("hargapackres")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id
                                                        $(this).val('');
						}

                                                if($(this).hasClass("paxres")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
                                                        $(this).val('');
                                                }

                                                if($(this).hasClass("totalres")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id
                                                        $(this).val('');
                                                }

                                                if($(this).hasClass("dayres")){ // if the current input has the hasDatpicker class
							var this_id6 = $(this).attr("id"); // current inputs id
							var new_id6 =  parseInt(this_id6) + 1; // a new id
							$(this).attr("id", new_id6); // change to new id
                                                       
						}

 

                                                
					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("packageres")){ // if the current input has the hasDatpicker class
							var this_id1 = $(this).attr("id"); // current inputs id
							var new_id1 =  parseInt(this_id1) + 1; // a new id
							$(this).attr("id", new_id1); // change to new id

						}
                                        });

                                         $(newRow).find("select").each(function(){
                                            if($(this).hasClass("bedtypepackage")){ // if the current input has the hasDatpicker class
							var this_id9 = $(this).attr("id"); // current inputs id
							var new_id9 =  parseInt(this_id9) + 1; // a new id
							$(this).attr("id", new_id9); // change to new id

						}
                                        });



                                        $(newRow).find("input:hidden").each(function(){
                                            if($(this).hasClass("mpackage")){ // if the current input has the hasDatpicker class
							var this_id8 = $(this).attr("id"); // current inputs id


                                                        var new_id8 = parseInt(this_id8) + 1;

							$(this).attr("id",new_id8); // change to new id
						}
                                        });
                                        
					return false;
				});


                                $(".cloneTablePackageReq").live('click', function(){
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
					$('#'+thisTableId + " tr:last td :input").val('');

                                         $(newRow).find("input").each(function(){
                                               if($(this).hasClass("hasDatepicker")){ // if the current input has the hasDatpicker class
							var this_id = $(this).attr("id"); // current inputs id
                                                        var txtid = this_id.slice(0,4);
                                                        var numberid = this_id.slice(4);
                                                        var new_id = parseInt(numberid) + 1;
                                                        // a new id
                                                        $(this).attr("id", txtid+new_id); // change to new id
							$(this).removeClass('hasDatepicker'); // remove hasDatepicker class
							 // re-init datepicker
							$(this).datepicker({
								dateFormat: 'dd-mm-yy',
								showButtonPanel: true
							});
						}
                                                
					        if($(this).hasClass("daypack")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id
                                                }

                                                if($(this).hasClass("hargapackage")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id
                                                }

                                                if($(this).hasClass("paxpack")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
                                                }

                                                if($(this).hasClass("totalpack")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id
                                                }
                                         });

                                          $(newRow).find("select").each(function(){
                                            if($(this).hasClass("package")){ // if the current input has the hasDatpicker class
							var this_id9 = $(this).attr("id"); // current inputs id
							var new_id9 =  parseInt(this_id9) + 1; // a new id
							$(this).attr("id", new_id9); // change to new id

						}
                                        });
					 

					return false;
				});



                                $(".cloneTableAdditional").live('click', function(){

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
					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");

					// clear the inputs (Optional)
					$('#'+thisTableId + " tr:last td :input").val('');

//					 new rows datepicker need to be re-initialized
                                        $(newRow).find("input").each(function(){
					        if($(this).hasClass("qtyadd")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id
                                                        $(this).val('');
						}
                                                if($(this).hasClass("unitadd")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id
                                                        $(this).val('');
						}
                                                if($(this).hasClass("priceadd")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
                                                        $(this).val('');
                                                }
                                                if($(this).hasClass("totaladd")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id
                                                        $(this).val('');
                                                }
					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("additionaldes")){ // if the current input has the hasDatpicker class
							var this_id1 = $(this).attr("id"); // current inputs id
							var new_id1 =  parseInt(this_id1) + 1; // a new id
							$(this).attr("id", new_id1); // change to new id

						}
                                        });

					return false;
				});




                                $(".cloneTableOtherPackageReq").live('click', function(){

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
					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");

					// clear the inputs (Optional)
					$('#'+thisTableId + " tr:last td :input").val('');

//					 new rows datepicker need to be re-initialized
                                        $(newRow).find("input").each(function(){
					        if($(this).hasClass("priceotpack")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id
                                                        $(this).val('');
						}
                                                if($(this).hasClass("paxotpack")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id
                                                        $(this).val('');
						}
                                                if($(this).hasClass("totalotpack")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
                                                        $(this).val('');
                                                }

					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("idotpackage")){ // if the current input has the hasDatpicker class
							var this_id1 = $(this).attr("id"); // current inputs id
							var new_id1 =  parseInt(this_id1) + 1; // a new id
							$(this).attr("id", new_id1); // change to new id

						}
                                        });

					return false;
				});


                    $(".cloneTableWeddingPackage").live('click', function(){
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
					$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");

					// clear the inputs (Optional)
					$('#'+thisTableId + " tr:last td :input").val('');
//					 new rows datepicker need to be re-initialized
                             $(newRow).find("input").each(function(){
					        if($(this).hasClass("stallprice")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id
                                                        $(this).val('');
						}
                              if($(this).hasClass("stallpax")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id
                                                        $(this).val('');
						}
                              if($(this).hasClass("stalltotal")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
                                                        $(this).val('');
                                                }

					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("wedstall")){ // if the current input has the hasDatpicker class
							var this_id1 = $(this).attr("id"); // current inputs id
							var new_id1 =  parseInt(this_id1) + 1; // a new id
							$(this).attr("id", new_id1); // change to new id

						}
                                        });

					return false;
				});





                                $(".cloneTableEditFnB").live('click', function(){
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
					 
					// make the delete image visible
					//$('#'+thisTableId + " tr:last td:first img").css("visibility", "visible");
                                        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
					// clear the inputs (Optional)
					$('#'+thisTableId + " tr:last td :input").val('');

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

                                                if($(this).hasClass("priceperpax")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id

						}

                                                 if($(this).hasClass("paxfnb")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id

						}

                                                if($(this).hasClass("revenuefnb")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
						}
					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("startjamfnb")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id

						}

                                                 if($(this).hasClass("endjamfnb")){ // if the current input has the hasDatpicker class
							var this_id6 = $(this).attr("id"); // current inputs id
							var new_id6 =  parseInt(this_id6) + 1; // a new id
							$(this).attr("id", new_id6); // change to new id

						}
                                        });



					return false;
				});


                                $(".cloneTableEditResidence").live('click', function(){
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


					// new rows datepicker need to be re-initialized
					$(newRow).find("input").each(function(){
						if($(this).hasClass("hasDatepicker")){ // if the current input has the hasDatpicker class
							var this_id = $(this).attr("id"); // current inputs id


							var txtid = this_id.slice(0,4);
                                                        var numberid = this_id.slice(4);
                                                        var new_id = parseInt(numberid) + 1;
                                                        // a new id

							$(this).attr("id", txtid+new_id); // change to new id
							$(this).removeClass('hasDatepicker'); // remove hasDatepicker class
							 // re-init datepicker
							$(this).datepicker({
								dateFormat: 'dd-mm-yy',
								showButtonPanel: true
							});


						}


                                                if($(this).hasClass("desres")){ // if the current input has the hasDatpicker class
							var this_id2 = $(this).attr("id"); // current inputs id
							var new_id2 =  parseInt(this_id2) + 1; // a new id
							$(this).attr("id", new_id2); // change to new id
                                                        $(this).val('');
						}



                                                if($(this).hasClass("hargapackres")){ // if the current input has the hasDatpicker class
							var this_id3 = $(this).attr("id"); // current inputs id
							var new_id3 =  parseInt(this_id3) + 1; // a new id
							$(this).attr("id", new_id3); // change to new id
                                                        $(this).val('');
						}

                                                if($(this).hasClass("paxres")){ // if the current input has the hasDatpicker class
							var this_id4 = $(this).attr("id"); // current inputs id
							var new_id4 =  parseInt(this_id4) + 1; // a new id
							$(this).attr("id", new_id4); // change to new id
                                                        $(this).val('');
                                                }

                                                if($(this).hasClass("totalres")){ // if the current input has the hasDatpicker class
							var this_id5 = $(this).attr("id"); // current inputs id
							var new_id5 =  parseInt(this_id5) + 1; // a new id
							$(this).attr("id", new_id5); // change to new id
                                                        $(this).val('');
                                                }

                                                if($(this).hasClass("dayres")){ // if the current input has the hasDatpicker class
							var this_id6 = $(this).attr("id"); // current inputs id
							var new_id6 =  parseInt(this_id6) + 1; // a new id
							$(this).attr("id", new_id6); // change to new id

						}

//                                                if($(this).hasClass("mpackage")){ // if the current input has the hasDatpicker class
//							var this_id9 = $(this).attr("id"); // current inputs id
//							var new_id9 =  parseInt(this_id9) + 1; // a new id
//							$(this).attr("id", new_id9); // change to new id
//
//						}

					});

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("packageres")){ // if the current input has the hasDatpicker class
							var this_id1 = $(this).attr("id"); // current inputs id
							var new_id1 =  parseInt(this_id1) + 1; // a new id
							$(this).attr("id", new_id1); // change to new id

						}
                                        });

                                        $(newRow).find("select").each(function(){
                                            if($(this).hasClass("meetstruc")){ // if the current input has the hasDatpicker class
							var this_id9 = $(this).attr("id"); // current inputs id
							var new_id9 =  parseInt(this_id9) + 1; // a new id
							$(this).attr("id", new_id9); // change to new id

						}
                                        });

                                         $(newRow).find("select").each(function(){
                                            if($(this).hasClass("bedtypepackage")){ // if the current input has the hasDatpicker class
							var this_idx = $(this).attr("id"); // current inputs id
							var new_idx =  parseInt(this_idx) + 1; // a new id
							$(this).attr("id", new_idx); // change to new id

						}
                                        });

                                        $(newRow).find("input:hidden").each(function(){
                                            if($(this).hasClass("mpackage")){ // if the current input has the hasDatpicker class
							var this_id8 = $(this).attr("id"); // current inputs id


                                                        var new_id8 = parseInt(this_id8) + 1;

							$(this).attr("id",new_id8); // change to new id
						}
                                        });

					return false;
				});



				// Delete a table row
				$("img.delRow").click(function(){
					$(this).parents("tr").remove();
                                        
					return false;
				});


                                $("img.delRowfnbreq").click(function(){
					$(this).parents("tr").remove();
                                        var total = 0;
                                        $(".revenuefnb").each(function(){
                                            total += parseInt($(this).val());
                                        });

                                //         var total = parseInt($("#revenue_si").val())  ;
                                        $("#total_revenue_fnb").val(total);
					return false;
				});

                                 $("img.delRoomreq").click(function(){
					$(this).parents("tr").remove();
                                          var total = 0;
                                          $("input.revenueroom").each(function(){
                                            total += parseInt($(this).val());
                                          });
                                          $("input#totalroomrevenue").val(total+'.00');
					return false;
				});


                                $("img.delRowresidence").click(function(){
					$(this).parents("tr").remove();
                                        var total = 0;
                                        $("input.totalres").each(function(){
                                            total += parseInt($(this).val());
                                        });
                                       $("input#grandtotal_res").val(total);
					return false;
				});


                                $("img.delPack").click(function(){
                                    $(this).parents("tr").remove();
                                    return false;
                                });

 
 $("#form_offering_letter").validationEngine();
     $("form#form_offering_letter").submit(function() {
        if($("#form_offering_letter").validationEngine({returnIsValid:true})){
         
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
              url: site_url+"offering_letter/add_offering_letter",
             // cache: true,
              data:$('#form_offering_letter').serialize(),
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
//        $('div#meetingpackagecontent').css('display','none');
//        $('div#otherpackagecontent').css('display','none');
//        $('div#roompackageonly').css('display','none');

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
                $("#processing").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });
        
        }
	return false;
     });

 

 $("input.qtyadd").keyup(function(){
                var this_id = $(this).attr('id');
                var qty = 0;
                var price = 0;
                var total = 0;
                qty = parseInt($(this).val());
                price = parseInt($("input.priceadd[id^="+this_id+"]").val());
               // total = parseInt($("input.totaladd[id^="+this_id+"]").val());

                total = qty * price
                var grandtotal = 0;
                $("input.totaladd[id^="+this_id+"]").val(total);

//                $(".totalres").each(function(){
//                    grandtotal += parseInt($(this).val());
//                });
//
//                $('input#grandtotal_res').val(grandtotal);
        return false;
    });

    $("input.priceadd").keyup(function(){
                var this_id = $(this).attr('id');
                var qty = 0;
                var price = 0;
                var total = 0;
                qty = parseInt($("input.qtyadd[id^="+this_id+"]").val());
                price = parseInt($(this).val());
               // total = parseInt($("input.totaladd[id^="+this_id+"]").val());

                  total = qty * price;
                var grandtotal = 0;
                $("input.totaladd[id^="+this_id+"]").val(total);

//                $(".totalres").each(function(){
//                    grandtotal += parseInt($(this).val());
//                });
//
//                $('input#grandtotal_res').val(grandtotal);
        return false;
    });


    $("input.stallprice").keyup(function(){

                var this_id = $(this).attr('id');
                var qty = 0;
                var price = 0;
                var total = 0;
                qty = parseInt($("input.stallpax[id^="+this_id+"]").val());
                price = parseInt($(this).val());
                total = qty * price;

                $("input.stalltotal[id^="+this_id+"]").val(total);
        return false;
    });

    $("input.stallpax").keyup(function(){
                var this_id = $(this).attr('id');
                var qty = 0;
                var price = 0;
                var total = 0;
                price = parseInt($("input.stallprice[id^="+this_id+"]").val());
                qty = parseInt($(this).val());
                total = qty * price;

                $("input.stalltotal[id^="+this_id+"]").val(total);
        return false;
    });

$('input.priceotpack').keyup(function(){
   var this_id = $(this).attr('id');
   var price = $(this).val();
   var pax  = $('input.paxotpack[id^="'+this_id+'"]').val();
   var total = 0;
   total = parseInt(price) * parseInt(pax);
   $('input.totalotpack[id^="'+this_id+'"]').val(total);
});

$('input.paxotpack').keyup(function(){
   var this_id = $(this).attr('id');
   var price = $('input.priceotpack[id^="'+this_id+'"]').val();
   var pax  = $(this).val();
   var total = 0;
   total = parseInt(price) * parseInt(pax);
   $('input.totalotpack[id^="'+this_id+'"]').val(total);
});

$('select.idotpackage').change(function(){
    //alert($(this).attr('id'));
})

$('#eventtype').change(function(){
    var eventtype = $(this).val();
    //var property = $('#property').val();
    var property;
     if($('select#property').val() != undefined){
            property = $('select#property').val();
      }

    if($('select#editproperty').val() != undefined){
        property = $('select#editproperty').val();
    }
    if(eventtype == 'ME')
    {
        $('div#divroomreq').css('display','');
        $('div#divfnbreq').css('display','');
        $('div#divresidence').css('display','');
        $('div#divmeetingpackagecomment').css('display','');
        $('div#divadditional').css('display','');
        $('div#divgroupcommentparent').css('display','');

        $('div#divpackage').css('display','none');
        $('div#divpackage').css('display','none');
        $('div#divpackcomment').css('display','none');
        $('div#divstall').css('display','none');
        $('div#divotherpackagerequierement').css('display','none');
        
//        $('div#meetingpackagecontent').css('display','');
//
//        $('div#roompackageonly').css('display','');
//
//        $('div#otherpackagecontent').css('display','none');
//        
        $('label#datein').text('Check In');
        $('label#dateout').text('Check Out');

        $('input#letter_checkout').show();
        $('input#letter_checkin').show();

        $('#psubmit').show();
        
    }else if(eventtype == 'null')
    {
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
//        $('div#meetingpackagecontent').css('display','none');
//        $('div#otherpackagecontent').css('display','none');
//        $('div#roompackageonly').css('display','none');

        $('label#datein').text('');
        $('label#dateout').text('');
        $('input#letter_checkout').hide();
        $('input#letter_checkin').hide();

        $('#psubmit').hide();

       
    }else if(eventtype == 'RO')
    {
        $('div#divroomreq').css('display','');
        $('div#divfnbreq').css('display','none');
        $('div#divresidence').css('display','none');
        $('div#divmeetingpackagecomment').css('display','none');
        $('div#divadditional').css('display','');
        $('div#divgroupcommentparent').css('display','none');

        $('div#divpackage').css('display','none');
        $('div#divpackage').css('display','none');
        $('div#divpackcomment').css('display','none');
        $('div#divstall').css('display','none');
        $('div#divotherpackagerequierement').css('display','none');
//        $('div#meetingpackagecontent').css('display','none');
//        $('div#roompackageonly').css('display','');
//        $('div#otherpackagecontent').css('display','none');

        $('label#datein').text('Check In');
        $('label#dateout').text('Check Out');

        $('input#letter_checkout').show();
        $('input#letter_checkin').show();

        $('#psubmit').show();
        
    }
    else{
        $('div#divroomreq').css('display','none');
        $('div#divfnbreq').css('display','none');
        $('div#divresidence').css('display','none');
        $('div#divmeetingpackagecomment').css('display','none');
        $('div#divadditional').css('display','none');
        $('div#divgroupcommentparent').css('display','none');
        $('div#divpackage').css('display','');
        $('div#divpackage').css('display','');
        $('div#divpackcomment').css('display','');
        $('div#divstall').css('display','');
        $('div#divotherpackagerequierement').css('display','');
//        $('div#meetingpackagecontent').css('display','none');
//        $('div#roompackageonly').css('display','none');
//        $('div#otherpackagecontent').css('display','');
        $('label#datein').text('Date Event');
        $('label#dateout').text('');
        $('input#letter_checkin').show();
        $('input#letter_checkout').hide();
    }

    $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_package_byproperty",
            data:({
                eventtype:eventtype,
                property:property
            }),
            dataType:"html",
            success: function(data){
                $("#packagebyeventtypeproperty").html(data );
            },
            beforeSend: function(){
                $("#packagebyeventtypeproperty").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
            }
        });

         $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_package_byprop",
            data:({
                eventtype:eventtype,
                property:property
            }),
            dataType:"html",
            success: function(data){
                $("#packagebyprop").html(data );
            },
            beforeSend: function(){
                $("#packagebyprop").html('<img src="'+base_url+'images/facebox/loading.gif"/>');
            }
        });

        $.ajax({
              type:"POST",
              url: site_url+"offering_letter/get_otherpackage_byevent",
              data:({eventtype:eventtype}),
              dataType:"html",
              success: function(data){
                //$('#otherpackagerequirement > tr').remove();
                //$("#otherpackagerequirement tr:not(#master)").remove();
                $('#otherpackagerequirement #item_area tr:not(:last)').remove();
                $("#otpackage").html(data);
              },
               beforeSend: function(){
                $("#otpackage").html('<img src="'+base_url+'images/facebox/loading.gif"/> ');
               }
            });
});


    function log(event, data, formatted) {
		$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#contactperson");
	}

	function formatItem(row) {
		return row[0] + " (<strong>id: " + row[1] + "</strong>)";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	

        $("#account").autocomplete(site_url+"offering_letter/get_companyaccount", {
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


                          },
                           beforeSend: function(){
                             $('#contactperson').html('<img src="'+base_url+'images/facebox/loading.gif"/> ');
                           }
                    });
            }//end IF
	});


////        $("#form_edit_offering").validationEngine();
        $("form#form_edit_offering").submit(function() {
//        if($("#form_edit_offering").validationEngine({returnIsValid:true})){

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
            // if($("#form_offering_letter").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"offering_letter/edit_offering_letter",
             // cache: true,
              data:$('#form_edit_offering').serialize(),
              dataType:"html",
              success: function(data){
                //alert(data);
                $('#changeconfirm').hide(100);
                $('#changedata').hide(100);
                $('p#psubmit').hide();
             
                $("#processing").html('<p> '+data+'</p>');
                 
                $('input:checkbox#cbconfirmletter').attr('checked','');
                $('input:checkbox#cbchangedata').attr('checked','');

             //   $("div#divchangestatus").hide();
                if(data == 'Data has changed.'){
              //   window.location = site_url +'offering_letter';
                     $("#processing").html('<p> '+data+'</p>');
                }
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });
    
//        }
	 return false;
     });




          $("form#form_edit_offering_to_confirmation").submit(function() {
//        if($("#form_edit_offering").validationEngine({returnIsValid:true})){

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
            // if($("#form_offering_letter").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"offering_letter/edit_offering_to_confirmation_letter",
             // cache: true,
              data:$('#form_edit_offering_to_confirmation').serialize(),
              dataType:"html",
              success: function(data){
                //alert(data);
                $('#changeconfirm').hide(100);
                $('#changedata').hide(100);
                $('p#psubmit').hide();

                $("#processing").html('<p> '+data+'</p>');

                $('input:checkbox#cbconfirmletter').attr('checked','');
                $('input:checkbox#cbchangedata').attr('checked','');
 
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });

//        }
	 return false;
     });

 
$("#changestatus").change(function(){
    var val = $(this).val();
    if(val == 'confirm'){
        $('#changeconfirm').show(100);
        $('#changedata').hide(100);
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
        $('p#psubmit').hide();
        $('input#btnupdate').hide();

    }else if(val=='cancel'){
        $('#changeconfirm').hide(100);
        $('#changedata').show(100);
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
        $('p#psubmit').hide();
        $('input#btnupdate').hide();
    }else{
        $('#changeconfirm').hide(100);
        $('#changedata').hide(100);
        $('p#psubmit').hide();
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
         $('p#psubmit').hide();
         $('input#btnupdate').show();
    }
});



$("#changestatusconfirmation").change(function(){
    var val = $(this).val();
    if(val == 'beo'){
        $('#changeconfirm').show(100);
        $('#changedata').hide(100);
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
        $('p#psubmit').hide();
        $('input#btnupdate').hide();

    }else if(val=='cancel'){
        $('#changeconfirm').hide(100);
        $('#changedata').show(100);
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
        $('p#psubmit').hide();
        $('input#btnupdate').hide();
    }else{
        $('#changeconfirm').hide(100);
        $('#changedata').hide(100);
        $('p#psubmit').hide();
        $('input:checkbox#cbconfirmletter').attr('checked','');
        $('input:checkbox#cbchangedata').attr('checked','');
         $('p#psubmit').hide();
         $('input#btnupdate').show();
    }
});




$('input:checkbox#cbconfirmletter').change(function(){
    //alert($(this).val());
    if($(this).is(':checked')){
        $('p#psubmit').show();
    }else
        {
        $('p#psubmit').hide();
        }
    
});


$('input:checkbox#cbchangedata').change(function(){
    if($(this).is(':checked')){
        $('p#psubmit').show();
    }else
    {
        $('p#psubmit').hide();
    }

});


$("#editproperty").change(function() {
       // alert($(this).val());
          $.ajax({
                      type:"POST",
                      url: site_url+"offering_letter/get_venueletter_by_property/"+$(this).val(),
                      cache: true,
                      success: function(data){
                        $("div#venueletter").html(data);
                      },
                      beforeSend: function(){
                        $("div#venueletter").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                      }
                });

        $.ajax({
                      type:"POST",
                      url: site_url+"offering_letter/get_venue_by_property/"+$(this).val(),
                      cache: true,
                      success: function(data){
                        $("div#venuex").html(data);
                      },
                      beforeSend: function(){
                        $("div#venuex").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                      }
                });



                $.ajax({
                      type:"POST",
                      url: site_url+"offering_letter/get_room_by_property/"+$(this).val(),
                      cache: true,
                      //dataType:'json',
                      success: function(data){
                          var numrowroom = $('#jmlroomrow').val();
                          var i=4;
                          for(i=4;i<=numrowroom+1;i++){
                                $("div#refroom-"+i+"").html(data);
                          }
                          
//                          $("div#refroom-2").html(data);
//                          $("div#refroom-3").html(data);
                       },
                      beforeSend: function(){
                          $("div#refroom-1").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                          $("div#refroom-2").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                          $("div#refroom-3").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                     }
                });
    });//end hotel


$('select#sales').change(function(){
     $('select#source').val($(this).val());
});


$("select.startjamfnb").change(function(){
   var start = $(this).val();
   var this_id = $(this).attr('id');
  // alert(this_id);
   $("select.endjamfnb[id^="+this_id+"]").val(start);
   
});

$("select.endjamfnb").change(function(){
   var start = $(this).val();
   var this_id = $(this).attr('id');
  //  alert(this_id);
   

});


$('select#venue_letter').live('change',function(){
   $('select#venue_fnb').val(($(this).val()));
});


$('select#layout_letter').live('change',function(){
   $('select#layout_fnb').val(($(this).val()));
});


$('input#pax_letter').live('keyup',function(){
   $('input#pax_fnb').val(($(this).val()));
});




//$("#form_edit_confirmation").validationEngine();
     $("form#form_edit_confirmation").submit(function() {
   //if($("#form_edit_confirmation").validationEngine({returnIsValid:true})){

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
            // if($("#form_offering_letter").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"confirmation_letter/edit_confirmation_letter",
             // cache: true,
              data:$('#form_edit_confirmation').serialize(),
              dataType:"html",
              success: function(data){
                //alert(data);
                $('#changeconfirm').hide(100);
                $('#changedata').hide(100);
                $('p#psubmit').hide();

                $("#processing").html('<p> '+data+'</p>');

                $('input:checkbox#cbconfirmletter').attr('checked','');
                $('input:checkbox#cbchangedata').attr('checked','');

             //   $("div#divchangestatus").hide();
                if(data == 'Data has changed.'){
                 window.location = site_url +'confirmation_letter';
                }
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });

      //  }
	 return false;
     });



$("#pax_letter").keypress(function(e)
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


$('input.checkinroombreakdown').change(function(){
        var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(4));
        var val = $(this).val();

        $(this).val(val);

        var cin = $(this).val();
        var cout = $(".checkoutroombreakdown[id^="+"cob-"+numberid+"]").val();

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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
            if (jml_hari < 0)
            {
                alert('Error, Check Date');
                $("input.nightroombreakdown[id^="+numberid+"]").val(0);
            }else{
                $("input.nightroombreakdown[id^="+numberid+"]").val(jml_hari);
                
               
            }
    return false;
});

$('input.checkoutroombreakdown').change(function(){
  var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(4));
        var val = $(this).val();

        $(this).val(val);

        var cin = $(".checkinroombreakdown[id^="+"cib-"+numberid+"]").val();
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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
            if (jml_hari < 0)
            {
                alert('Error, Check Date');
                $("input.nightroombreakdown[id^="+numberid+"]").val(0);
            }else{
                $("input.nightroombreakdown[id^="+numberid+"]").val(jml_hari);


            }


//     var this_id = $(this).attr('id');
//     var qtyroom = $(this).val();
//     var night =    $("input.nightroombreakdown[id^="+this_id+"]").val();
//     var rate = $("input.ratepernightroombreakdown[id^="+this_id+"]").val();
//     var total = parseInt(qtyroom) * parseInt(rate) * parseInt(night);
//     $("input.revenueroombreakdown[id^="+this_id+"]").val(total);

return false;
});


$('input.checkinfnbbreakdown').change(function(){
        var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(5));
        var val = $(this).val();

        $(this).val(val);
        //alert(val);
        var cin = $(this).val();
        var cout = $(".checkoutfnbbreakdown[id^="+"cofb-"+numberid+"]").val();

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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
            if (jml_hari <  0)
            {
                alert('Error, Check Date');
                $("input.daysfnbbreakdown[id^="+numberid+"]").val(0);
            }else{
                $("input.daysfnbbreakdown[id^="+numberid+"]").val(jml_hari+1);
            }
     var pax = $("input.paxfnbbreak[id^="+numberid+"]").val();
     var days = $("input.daysfnbbreakdown[id^="+numberid+"]").val();
     var cb1 = $("input.cb1[id^="+numberid+"]").val();
     var cb2 = $("input.cb2[id^="+numberid+"]").val();
     var lunch = $("input.lunch[id^="+numberid+"]").val();
     var dinner = $("input.dinner[id^="+numberid+"]").val();
     var total = (parseInt(cb1) + parseInt(cb2) + parseInt(lunch)+ parseInt(dinner)) * pax * days;
     $("input.totalfnbbreak[id^="+numberid+"]").val(total);
    return false;
});

$('input.checkoutfnbbreakdown').change(function(){
  var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(5));
        var val = $(this).val();

        $(this).val(val);

        var cin = $(".checkinfnbbreakdown[id^="+"cifb-"+numberid+"]").val();
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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
        if (jml_hari <  0)
        {
            alert('Error, Check Date');
            $("input.daysfnbbreakdown[id^="+numberid+"]").val(0);
        }else{
            $("input.daysfnbbreakdown[id^="+numberid+"]").val(jml_hari+1 );
        }
    
     var pax = $("input.paxfnbbreak[id^="+numberid+"]").val();
     var days = $("input.daysfnbbreakdown[id^="+numberid+"]").val();
     var cb1 = $("input.cb1[id^="+numberid+"]").val();
     var cb2 = $("input.cb2[id^="+numberid+"]").val();
     var lunch = $("input.lunch[id^="+numberid+"]").val();
     var dinner = $("input.dinner[id^="+numberid+"]").val();
     var total = (parseInt(cb1) + parseInt(cb2) + parseInt(lunch)+ parseInt(dinner)) * pax * days;
     $("input.totalfnbbreak[id^="+numberid+"]").val(total);

return false;
});


$('input.checkinpack').change(function(){
        var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(4));
        var val = $(this).val();

        $(this).val(val);
        //alert(val);
        var cin = $(this).val();
        var cout = $(".checkoutpack[id^="+"cop-"+numberid+"]").val();

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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
            if (jml_hari <  0)
            {
                alert('Error, Check Date');
                $("input.daypack[id^="+numberid+"]").val(0);
            }else{
                $("input.daypack[id^="+numberid+"]").val(jml_hari );
            }
    return false;
});

$('input.checkoutpack').change(function(){
  var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(4));
        var val = $(this).val();

        $(this).val(val);

        var cin = $(".checkinpack[id^="+"cip-"+numberid+"]").val();
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
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
        if (jml_hari <  0)
        {
            alert('Error, Check Date');
            $("input.daypack[id^="+numberid+"]").val(0);
        }else{
            $("input.daypack[id^="+numberid+"]").val(jml_hari );
        }
return false;
});

$('input.qtyroombreakdown').keyup(function(){
     var this_id = $(this).attr('id');
     var qtyroom = $(this).val();
     var night =    $("input.nightroombreakdown[id^="+this_id+"]").val();
     var rate = $("input.ratepernightroombreakdown[id^="+this_id+"]").val();
     var total = parseInt(qtyroom) * parseInt(rate) * parseInt(night);
     $("input.revenueroombreakdown[id^="+this_id+"]").val(total);
});


$('input.paxfnbbreak').keyup(function(){
    //alert('asdsd');
     var this_id = $(this).attr('id');
     var pax = $(this).val();
     //var days = $("input.daysfnbbreakdown[id^="+this_id+"]").val();
     var cb1 = $("input.cb1[id^="+this_id+"]").val();
     var cb2 = $("input.cb2[id^="+this_id+"]").val();
     var lunch = $("input.lunch[id^="+this_id+"]").val();
     var dinner = $("input.dinner[id^="+this_id+"]").val();
     var total = (parseInt(cb1) + parseInt(cb2) + parseInt(lunch)+ parseInt(dinner)) * pax  
     $("input.totalfnbbreak[id^="+this_id+"]").val(total);
     var grandtotal = 0;
        $("input.totalfnbbreak").each(function(){
            grandtotal += parseInt($(this).val());
        });
        
        $('input#grandtotalfnbbreak').val(grandtotal);
});


$('select.ref_meetstruc').change(function(){
    var this_id = $(this).attr('id');
    var val = $(this).val();
    var property;
    if($('select#property').val() != undefined){
        property = $('select#property').val();
    }

    if($('select#editproperty').val() != undefined){
        property = $('select#editproperty').val();
    }
    var bedtype;
    bedtype =  $("input.idbedtypefnbbreak[id^="+this_id+"]").val();

    var idmpack;
    idmpack =  $("input.idmpackagefnbbreak[id^="+this_id+"]").val();
//
//     alert(bedtype)
//     alert(idmpack)
//     alert(property)
//     alert($(this).val())

if(val != 0){


    $.ajax({
        type:"POST",
        url: site_url+"offering_letter/get_fnbpricemp_by_meetstructmpackage/" ,
        cache: true,
        data:({meetstruc: $(this).val(), property: property, bedtype:bedtype,kode:idmpack}),
        dataType:'json',
        success: function(data){
             $(".cb1[id^="+this_id+"]").val(data.cb1);
             $(".cb2[id^="+this_id+"]").val(data.cb2);
             $(".lunch[id^="+this_id+"]").val(data.lunch);
             $(".dinner[id^="+this_id+"]").val(data.dinner);
             $(".idmpackagefnbbreak[id^="+this_id+"]").val(data.idmpackage);
             var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();
            // var days = $("input.daysfnbbreakdown[id^="+this_id+"]").val();
             var cb1 = $("input.cb1[id^="+this_id+"]").val();
             var cb2 = $("input.cb2[id^="+this_id+"]").val();
             var lunch = $("input.lunch[id^="+this_id+"]").val();
             var dinner = $("input.dinner[id^="+this_id+"]").val();
             var total = (parseInt(cb1) + parseInt(cb2) + parseInt(lunch)+ parseInt(dinner)) * pax ;//* days;
             $("input.totalfnbbreak[id^="+this_id+"]").val(total);
        },
        beforeSend: function(){
             $(".cb1[id^="+this_id+"]").val('processing..');
             $(".cb2[id^="+this_id+"]").val('processing..');
             $(".lunch[id^="+this_id+"]").val('processing..');
             $(".dinner[id^="+this_id+"]").val('processing..');
        }

    });
}else{
     $(".cb1[id^="+this_id+"]").val(0);
             $(".cb2[id^="+this_id+"]").val(0);
             $(".lunch[id^="+this_id+"]").val(0);
             $(".dinner[id^="+this_id+"]").val(0);
             //$(".idmpackagefnbbreak[id^="+this_id+"]").val(data.idmpackage);
             var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();
            // var days = $("input.daysfnbbreakdown[id^="+this_id+"]").val();
             var cb1 = $("input.cb1[id^="+this_id+"]").val();
             var cb2 = $("input.cb2[id^="+this_id+"]").val();
             var lunch = $("input.lunch[id^="+this_id+"]").val();
             var dinner = $("input.dinner[id^="+this_id+"]").val();
             var total = (parseInt(cb1) + parseInt(cb2) + parseInt(lunch)+ parseInt(dinner)) * pax ;//* days;
             $("input.totalfnbbreak[id^="+this_id+"]").val(total);
}

});



$('select.package').live('change',function(){
    //alert('halo');
    var this_id = $(this).attr('id');


     $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_package_price",
                data:({
                    idpackage:$(this).val()
                }),
                dataType:"html",
                success: function(data){
                    //alert(data)
                    $("input.hargapackage[id^="+this_id+"]").val(data);
                },
                beforeSend: function(){
                    $("input.hargapackage[id^="+this_id+"]").val('processing...');
                }
            });
        
});





});//end document ready

