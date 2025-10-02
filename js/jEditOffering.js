/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {


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

////////////////////////////////////////////////////////////////////////////
//         $('#letter_date').datepicker({
//             onSelect: function() {
//                 $.validationEngine.closePrompt('.formError',true);
//             },
//             dateFormat:'dd-mm-yy'
//        });
//        $('#letter_checkin').datepicker({
//             onSelect: function() {
//                 $.validationEngine.closePrompt('.formError',true);
//             },
//             dateFormat:'dd-mm-yy'
//        });
//        $('#letter_checkout').datepicker({
//             onSelect: function() {
//                 $.validationEngine.closePrompt('.formError',true);
//             },
//             dateFormat:'dd-mm-yy'
//        });
/////////////////////////////////////////////////////////////////////////////
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


    $('#revenue_si').dblclick(function() {
    $('#revenue_si').attr('readonly','');
});

    $("#letter_checkin").change(function() {
         $.validationEngine.closePrompt('.formError',true);
        $("#checkin_si").val($(this).val());
        $("#checkin_dbl").val($(this).val());

        $("#cir-1").val($(this).val());

        var cin = $(this).val();
        var cout = $("#letter_checkout").val();

        var dt1   = parseInt(cin.substring(0,2),10);
        var mon1  = parseInt(cin.substring(3,5),10);
	var yr1   = parseInt(cin.substring(6,10),10);

        var dt2   = parseInt(cout.substring(0,2),10);
        var mon2  = parseInt(cout.substring(3,5),10);
	var yr2   = parseInt(cout.substring(6,10),10);

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

        var milli_d1 = tgl_awal.getTime();
        var milli_d2 = tgl_akhir.getTime();
        var diff = milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        if (jml_hari < 0)
            {
                alert('Error, periksa tgl');
                $("#night_si").val('-');
                $("#night_dbl").val('-');
            }else{
                $("#night_si").val(jml_hari);
                $("#night_dbl").val(jml_hari);
                 $("input.dayres[id^='1']").val(jml_hari);
            }

    });

    $("#letter_checkout").change(function() {
         $.validationEngine.closePrompt('.formError',true);
        $("#checkout_si").val($(this).val());
        $("#checkout_dbl").val($(this).val());

       $("#cor-1").val($(this).val());
        var cin = $("#checkin_si").val();
        var cout = $(this).val();

        var dt1   = parseInt(cin.substring(0,2),10);
        var mon1  = parseInt(cin.substring(3,5),10);
	var yr1   = parseInt(cin.substring(6,10),10);

        var dt2   = parseInt(cout.substring(0,2),10);
        var mon2  = parseInt(cout.substring(3,5),10);
	var yr2   = parseInt(cout.substring(6,10),10);

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

        var milli_d1 = tgl_awal.getTime();
        var milli_d2 = tgl_akhir.getTime();
        var diff = milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
       if (jml_hari < 0)
            {
                alert('Error, periksa tgl');
                $("#night_si").val('-');
                $("#night_dbl").val('-');
            }else{
                $("#night_si").val(jml_hari);
                $("#night_dbl").val(jml_hari);
                $("input.dayres[id^='1']").val(jml_hari);
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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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

        var cin = $(this).val();
        var cout = $(".checkoutres[id^="+"cor-"+numberid+"]").val();

        var dt1   = parseInt(cin.substring(0,2),10);
        var mon1  = parseInt(cin.substring(3,5),10);
	var yr1   = parseInt(cin.substring(6,10),10);

        var dt2   = parseInt(cout.substring(0,2),10);
        var mon2  = parseInt(cout.substring(3,5),10);
	var yr2   = parseInt(cout.substring(6,10),10);

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

        var milli_d1 = tgl_awal.getTime();
        var milli_d2 = tgl_akhir.getTime();
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
            if (jml_hari < 0)
            {
                alert('Error, periksa tgl');

                $("input.dayres[id^="+numberid+"]").val(' - ');
            }else{
                  $("input.dayres[id^="+numberid+"]").val(jml_hari);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

        var milli_d1 = tgl_awal.getTime();
        var milli_d2 = tgl_akhir.getTime();
        var diff =   milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        //alert(jml_hari);
            if (jml_hari < 0)
            {
                alert('Error, periksa tgl');

                $("input.dayres[id^="+numberid+"]").val(' - ');
            }else{
                  $("input.dayres[id^="+numberid+"]").val(jml_hari);

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
            }


    });


//    $(".checkinres").change(function() {
//        var this_id = $(this).attr('id');
//       // var price = $(".priceperpax[id^="+this_id+"]").val();
////        var pax = $(this).val();
//        var cin = $(this).val();
//        var cout = $(".checkoutres[id^="+this_id+"]").val();
//
//        var dt1   = parseInt(cin.substring(0,2),10);
//        var mon1  = parseInt(cin.substring(3,5),10);
//	var yr1   = parseInt(cin.substring(6,10),10);
//
//        var dt2   = parseInt(cout.substring(0,2),10);
//        var mon2  = parseInt(cout.substring(3,5),10);
//	var yr2   = parseInt(cout.substring(6,10),10);
//
//        var tgl_awal = new Date(yr1, mon1, dt1);
//        var tgl_akhir = new Date(yr2, mon2, dt2);
//
//        var milli_d1 = tgl_awal.getTime();
//        var milli_d2 = tgl_akhir.getTime();
//        var diff =   milli_d2 - milli_d1;
//        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
//         if (jml_hari < 0)
//            {
//                alert('Error, periksa tgl');
//                $(".dayres[id^="+this_id+"]").val('-');
//            }else{
//                $(".dayres[id^="+this_id+"]").val(jml_hari);
//                var day = 0;
//                var pax = 0;
//                var price = 0;
//                day = jml_hari;
//                pax = $(".paxres[id^="+this_id+"]").val();
//                price = $(".hargapackres[id^="+this_id+"]").val();
//                $(".totalres[id^="+this_id+"]").val(day*pax*price);
////                var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
////                $("#totalroomrevenue").val(total);
//            }
//    });
//
//    $(".checkoutres").change(function() {
//        var this_id = $(this).attr('id');
//       // var price = $(".priceperpax[id^="+this_id+"]").val();
////        var pax = $(this).val();
//
//        var cin = $(this).val();
//        var cout = $(".checkinres[id^="+this_id+"]").val();
//
//        var dt1   = parseInt(cin.substring(0,2),10);
//        var mon1  = parseInt(cin.substring(3,5),10);
//	var yr1   = parseInt(cin.substring(6,10),10);
//
//        var dt2   = parseInt(cout.substring(0,2),10);
//        var mon2  = parseInt(cout.substring(3,5),10);
//	var yr2   = parseInt(cout.substring(6,10),10);
//
//        var tgl_awal = new Date(yr1, mon1, dt1);
//        var tgl_akhir = new Date(yr2, mon2, dt2);
//
//        var milli_d1 = tgl_awal.getTime();
//        var milli_d2 = tgl_akhir.getTime();
//        var diff =   milli_d2 - milli_d1;
//        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
//         if (jml_hari < 0)
//            {
//                alert('Error, periksa tgl');
//                $(".dayres[id^="+this_id+"]").val('-');
//            }else{
//                $(".dayres[id^="+this_id+"]").val(jml_hari);
//                var day = 0;
//                var pax = 0;
//                var price = 0;
//                day = jml_hari;
//                pax = $(".paxres[id^="+this_id+"]").val();
//                price = $(".hargapackres[id^="+this_id+"]").val();
//
//                $(".totalres[id^="+this_id+"]").val(day*pax*price);
////                var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
////                $("#totalroomrevenue").val(total);
//            }
//    });



    $("#night_si").change(function() {
        var night = 0;
        var room = 0;
        var rate = 0;
        night = $(this).val();
        room = $("#room_si").val();
        rate = $("#ratepernight_si").val();
        $("#revenue_si").val(night*room*rate);

        var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
        $("#totalroomrevenue").val(total);
    });


    $("#night_dbl").change(function() {
        var night = 0;
        var room = 0;
        var rate = 0;
        night = $(this).val();
        room = $("#room_dbl").val();
        rate = $("#ratepernight_dbl").val();
        $("#revenue_dbl").val(night*room*rate);
       var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
        $("#totalroomrevenue").val(total);
    });


    $("#room_si").keyup(function() {
        var night = 0;
        var room = 0;
        var rate = 0;
        night = $("#night_si").val();
        room = $(this).val();
        rate = $("#ratepernight_si").val();
        $("#revenue_si").val(night*room*rate);

        var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
        $("#totalroomrevenue").val(total);
    });


    $("#room_dbl").keyup(function() {
        var night = 0;
        var room = 0;
        var rate = 0;
        night = $("#night_dbl").val();
        room = $(this).val();
        rate = $("#ratepernight_dbl").val();
        $("#revenue_dbl").val(night*room*rate);

        var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
        $("#totalroomrevenue").val(total);
    });

    $("#ratepernight_si").keyup(function() {
        var night = 0;
        var room = 0;
        var rate = 0;
        night = $("#night_si").val();
        room = $("#room_si").val();
        //rate = $(this).val();
        rate =  $(this).val() ;
        $("#revenue_si").val(night*room*rate);

        var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
        $("#totalroomrevenue").val(total);
    });

    $("#ratepernight_dbl").keyup(function() {
        var night = 0;
        var room = 0;
        var rate = 0;
        night = $("#night_dbl").val();
        room = $("#room_dbl").val();
        rate = $(this).val();
        $("#revenue_dbl").val(night*room*rate);

        var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
        $("#totalroomrevenue").val(total);
    });



    $("input.priceperpax").keyup(function(){
        var this_id = $(this).attr('id');
        var price = $(this).val();
        var pax = $(".paxfnb[id^="+this_id+"]").val();
        //var revenue = $(".revenuefnb[id^="+this_id+"]").val();

       //$(".paxfnb[id^="+this_id+"]").val("ewwe");
       $(".revenuefnb[id^="+this_id+"]").val(price*pax);
        //alert(this_id);
        var total = 0;
        $(".revenuefnb").each(function(){
            total += parseInt($(this).val());
        });

//         var total = parseInt($("#revenue_si").val())  ;
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

//         var total = parseInt($("#revenue_si").val())  ;
        $("#total_revenue_fnb").val(total);
        return false;
    });
/////////////////////////////////////////////////////////////////
    $(".packageres").change(function(){
        var packageres = $(this).val();
        var this_id = $(this).attr('id');
        $(".desres[id^="+this_id+"]").val(packageres);
        $(".hargapackres[id^="+this_id+"]").val(packageres);
        //alert(packageres);
        $.ajax({
                      type:"POST",
                      url: site_url+"offering_letter/get_detil_package/" ,
                      cache: true,
                      data:({kode: $(this).val(), property: $("#property").val()}),
                      dataType:'json',
                      success: function(data){
                        $(".desres[id^="+this_id+"]").val(data.deskripsi);
                        $(".hargapackres[id^="+this_id+"]").val(data.price);
                       // $("input.idmpackageres[id^="+this_id+"]").val($(this).val());

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

//                $.ajax({
//                      type:"POST",
//                      url: site_url+"offering_letter/teststring/" ,
//                      cache: true,
//
//
//                      success: function(data){
//
//                        alert(data);
//                      },
//                      beforeSend: function(){
//
//                      }
//                });

//////////////////////////////////////////////////////////////////////////////////////////////
        $("input.paxres").keyup(function(){
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
                    grandtotal += parseInt($(this).val());
                });

                $('input#grandtotal_res').val(grandtotal);
        return false;
    });




//
   // alert('asdasd');

//       var total = 0;
//        $(".revenuefnb").each(function(){
//            total += parseInt($(this).val());
//        });
//
////         var total = parseInt($("#revenue_si").val())  ;
//        $("#total_revenue_fnb").val(total);
        return false;
    });


    $("#property").change(function() {
       // alert($(this).val());
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

                        $("div#refroom_si").html(data);
                        $("div#refroom_dbl").html(data);
                      },
                      beforeSend: function(){
                            $("div#refroom_si").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                            $("div#refroom_dbl").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');

                        }
                });


                  
    });//end hotel



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


//     $.post(site_url+"offering_letter/get_room_price", {  company:$("#customer").val(),room: $('div#refroom_si > #type').val(), property: $("#property").val(),week:$(this).val() },
//            function(data){
//           // alert( data);
//            $("#ratepernight_si").val(data);
//        });


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
//
                }else
                    {
                        $("#contact").val("-");
                    }
    });//end week si




                                $(".my_date").datepicker({
					dateFormat: 'dd-mm-yy',
					showButtonPanel: true
				});

//////
//                                $(".my_date_res").datepicker({
//					dateFormat: 'dd-mm-yy',
//					showButtonPanel: true
//				});



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

					return false;
				});

                                $(".cloneRowsRoomComment").live('click', function(){

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
					$('#'+thisTableId + " tr:last td :input").val('');

					// new rows datepicker need to be re-initialized

					return false;
				});


                                 $(".cloneRowsBanquetComment").live('click', function(){

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

					return false;
				});



                                $(".cloneRowsPackageComment").live('click', function(){

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

					return false;
				});



                                $(".cloneRowsGroupComment").live('click', function(){

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

//                                                if($(this).hasClass("idmpackageres")){ // if the current input has the hasDatpicker class
//							var this_id7 = $(this).attr("id"); // current inputs id
//							var new_id7 =  parseInt(this_id7) + 1; // a new id
//							$(this).attr("id", new_id7); // change to new id
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
                                        var night_si = 0;
                                        var room_si = 0;
                                        var rate_si = 0;
                                        var night_dbl = 0;
                                        var room_dbl = 0;
                                        var rate_dbl = 0;
                                        var total_si = 0;
                                        var total_dbl = 0;
//
//
//                                            if($('#night_si').val()!= null )
//                                            {
//                                                night_si  = $('#night_si').val();
//                                            }
//
//                                            if($('#room_si').val()!= null )
//                                            {
//                                                room_si  = $('#room_si').val();
//                                            }
//
//                                            if($('#rate_si').val()!= null )
//                                            {
//                                                rate_si  = $('#rate_si').val();
//                                            }
//
//                                            if($('#night_dbl').val()!= null )
//                                            {
//                                                night_dbl  = $('#night_dbl').val();
//                                            }
//
//                                            if($('#room_dbl').val()!= null )
//                                            {
//                                                room_dbl  = $('#room_dbl').val();
//                                            }
//
//                                            if($('#rate_dbl').val()!= null )
//                                            {
//                                                rate_dbl = $('#rate_dbl').val();
//                                            }
//
//                                            total_si = parseint(night_si) + parseint(room_si) + parseint(rate_si);
//                                            total_dbl  = parseint(night_dbl) + parseint(room_dbl) + parseint(rate_dbl);
                                            if($('#revenue_si').val()!= null )
                                            {
                                                 total_si = $('#revenue_si').val();
                                            }

                                             if($('#revenue_dbl').val()!= null )
                                            {
                                                 total_dbl = $('#revenue_dbl').val();
                                            }
                                       // var total = parseInt($("#revenue_si").val()) + parseInt($("#revenue_dbl").val());
                                        $("#totalroomrevenue").val(total_si+total_dbl);
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


  $("#form_offering_letter").validationEngine();
     $("form#form_offering_letter").submit(function() {
       if($("#form_offering_letter").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"offering_letter/add_offering_letter",
              cache: true,
              data:$('#form_offering_letter').serialize(),
              dataType:"html",
              success: function(data){
                    var d = new Date();

//                    var curr_date = d.getDate();
//                    var curr_month = d.getMonth();
//                    var curr_year = d.getFullYear();



                 //alert(data)

                 $("#no_offering").val('');
//                 $("#letter_date").val(d.format('dd-mm-yyyy'));
//                 $("#customer").val('Pilih');
                 $("#property").val('Pilih');
//                 $("#property option[value='Pilih']").attr("selected", "selected");
                 $("#sales").val('Pilih');
                 $("#eventtype").val('Pilih');
                 $("#package").val('Pilih');
                 $("#customer").val('Pilih');
                 $("#letter_checkin").val('');
                 $("#letter_checkout").val('');
//
                 $("#source").val('');
                 $("#event_name").val('');

                 $("#processing").html('<p>Offering Letter created.</p>  '+data );
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Simpan...');
               }
            });
            }else{
      //alert('gagal');
     }
	return false;
     });





});//end document ready

