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




    $("#letter_date").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#letter_checkin").datepicker({
        dateFormat:'dd-mm-yy'
    } );
    $("#letter_checkout").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#checkin_si").datepicker({
        dateFormat:'dd-mm-yy'
    } );
    $("#checkout_si").datepicker({
        dateFormat:'dd-mm-yy'
    } );
    $("#checkin_dbl").datepicker({
        dateFormat:'dd-mm-yy'
    } );
    $("#checkout_dbl").datepicker({
        dateFormat:'dd-mm-yy'
    } );
    $("#date_fnb").datepicker({
        dateFormat:'dd-mm-yy'
    } );

    $("#cir-1").datepicker({
        dateFormat:'dd-mm-yy'
    } );
    $("#cor-1").datepicker({
        dateFormat:'dd-mm-yy'
    } );

    $("#letter_checkin").change(function() {
        $.validationEngine.closePrompt('.formError',true);
     
        $("#cir-1").val($(this).val()); //tanggal checkin meeting package
        $('input#cifnb-1').val($(this).val());

        $("#cirq-1").val($(this).val()); //tanggal checkin room requirement
        $("#cirq-2").val($(this).val()); //tanggal checkin room requirement

        $('input#cip-1').val($(this).val());
        $('input#cop-1').val($(this).val());

        $('input#das-1').val($(this).val());
     
       var et = $('select#eventtype').val();
        if(et != 'ME' && et != 'RO' && et != 'GD' && et != 'GH' && et != 'OT'){
            $("#letter_checkout").val($(this).val());
            $('input#cofnb-1').val($(this).val());
        }

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
            $("input.dayres[id^='1']").val(1);
            $("input.nightroom[id^='1']").val(0);
            $("input.nightroom[id^='2']").val(0);
        }else{
            $("input.dayres[id^='1']").val(jml_hari+1 );
            $("input.nightroom[id^='1']").val(jml_hari);
            $("input.nightroom[id^='2']").val(jml_hari);
        }

        $("input.daypack[id^='1']").val(1 );

       
    //$.validationEngine.intercept = false
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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

        var milli_d1 = tgl_awal.getTime();
        var milli_d2 = tgl_akhir.getTime();
        var diff = milli_d2 - milli_d1;
        var jml_hari = (((diff / 1000) / 60) / 60) / 24;
        if (jml_hari <= 0)
        {
            alert('Error, periksa tgl');
        }else{
            $("input.dayres[id^='1']").val(jml_hari+1 );
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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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
            var pack = $("select.packageres[id^="+numberid+"]").val();
           // var isnonres = pack.slice(0,1);
             var isnonres; 
            
            $.ajax({
                type:"POST",
                url: site_url+"meeting_package/get_typepackage_detail" ,
                data:({
                    idtypepackage:pack
                }),
                dataType:'json',
                success: function(data){
                    isnonres = data.kategori;
           
                    if(isnonres.slice(0,1) != 'N'){
                     $("input.dayres[id^="+numberid+"]").val(jml_hari);
                    }else{
                        $("input.dayres[id^="+numberid+"]").val(jml_hari+1);
                    }
                }
            });
            
            
//            if(isnonres != 'N'){
//                $("input.dayres[id^="+numberid+"]").val(jml_hari);
//            }else{
//                $("input.dayres[id^="+numberid+"]").val(jml_hari+1);
//            }

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
            $("input.dayres[id^="+numberid+"]").val(0);
        }else{
            
            
            var pack = $("select.packageres[id^="+numberid+"]").val();
            var isnonres;
             
            $.ajax({
                type:"POST",
                url: site_url+"meeting_package/get_typepackage_detail" ,
                data:({
                    idtypepackage:pack
                }),
                dataType:'json',
                success: function(data){
                    isnonres = data.kategori;
           
                    if(isnonres.slice(0,1) != 'N'){
                        $("input.dayres[id^="+numberid+"]").val(jml_hari);
                    }else{
                        $("input.dayres[id^="+numberid+"]").val(jml_hari+1);
                    }
                }
            });
            
            
            
           

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


    $(".startdateadditional").change(function(){
        var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(4));

        var cin = $(this).val();
        var cout = $(".enddateadditional[id^="+"eda-"+numberid+"]").val();

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
       
        }else{
            if(!isNaN(jml_hari)){
                if($("select.additionaldes[id^="+numberid+"]").val() == 1){
                    $("input.daysadd[id^="+numberid+"]").val(jml_hari);
                }else{
                    $("input.daysadd[id^="+numberid+"]").val(jml_hari+1);
                }
                var days = $("input.daysadd[id^="+numberid+"]").val();
                var qty =  $("input.qtyadd[id^="+numberid+"]").val();
                var price = $("input.priceadd[id^="+numberid+"]").val();

                var total = parseInt(days) * parseInt(qty) * parseInt(price);
                if(!isNaN(total)){
                    $("input.totaladd[id^="+numberid+"]").val(total);
                }
            }
        
        }//End IF
    })


    $(".enddateadditional").change(function(){
        var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(4));

        var cin = $(".startdateadditional[id^="+"sda-"+numberid+"]").val();
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

        }else{
            if(!isNaN(jml_hari)){
                if($("select.additionaldes[id^="+numberid+"]").val() == 1){
                    $("input.daysadd[id^="+numberid+"]").val(jml_hari);
                }else{
                    $("input.daysadd[id^="+numberid+"]").val(jml_hari+1);
                }

                var days = $("input.daysadd[id^="+numberid+"]").val();
                var qty =  $("input.qtyadd[id^="+numberid+"]").val();
                var price = $("input.priceadd[id^="+numberid+"]").val();
            
                var total = parseInt(days) * parseInt(qty) * parseInt(price);
                if(!isNaN(total)){
                    $("input.totaladd[id^="+numberid+"]").val(total);
                }
            }
        }//End IF
    })


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

        var tgl_awal = new Date(yr1, mon1-1, dt1);//Month is 0-11 in JavaScript

        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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
 
    $(".packageres").live('change',function(){
        
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
       // var isnonres = packageres.slice(0,1)
       var isnonres;
        $.ajax({
            type:"POST",
            url: site_url+"meeting_package/get_typepackage_detail" ,
            data:({
                idtypepackage:packageres
            }),
            dataType:'json',
            success: function(data){
                isnonres = data.kategori;
               
               if(isnonres.slice(0,1) != 'N'){
   
            bedtype =  $(".bedtypepackage[id^="+this_id+"]").val();
            $(".hargapackres[id^="+this_id+"]").val('');

            var cinx =  $(".checkinres[id^="+"cir-"+this_id+"]").val();
            var coutx =  $(".checkoutres[id^="+"cor-"+this_id+"]").val();

            var dt1x   = parseInt(cinx.substring(0,2),10);
            var mon1x  = parseInt(cinx.substring(3,5),10);
            var yr1x   = parseInt(cinx.substring(6,10),10);

            var dt2x   = parseInt(coutx.substring(0,2),10);
            var mon2x  = parseInt(coutx.substring(3,5),10);
            var yr2x   = parseInt(coutx.substring(6,10),10);

            var tgl_awalx = new Date(yr1x, mon1x-1, dt1x);
            var tgl_akhirx = new Date(yr2x, mon2x-1, dt2x);

            var milli_d1x = tgl_awalx.getTime();
            var milli_d2x = tgl_akhirx.getTime();
            var diffx = milli_d2x - milli_d1x;
            var jml_harix = (((diffx / 1000) / 60) / 60) / 24;
            if (jml_harix < 0)
            {
                alert('Error, periksa tgl');
                $("input.dayres[id^="+this_id+"]").val(1);

            }else{
                $("input.dayres[id^="+this_id+"]").val(jml_harix);

            }
   
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_detil_package/" ,
                cache: false,
                data:({
                    kode: packageres,
                    property:property,
                    bedtype:bedtype
                }),
                dataType:'json',
                success: function(data){
                    //alert('idmpack:'+data.idmpackage);
                    //(".desres[id^="+this_id+"]").val(data.deskripsi);
                    //$("input.hargapackres[id^="+this_id+"]").val(data.price);
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
                //     $(".hargapackres[id^="+this_id+"]").val('processing...');
                }
            });




            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_meetingstructure2/" ,
                cache: false,
                data:({
                    typepackage: packageres,
                    property:property,
                    roompackage:bedtype//new 14April
                }),
                dataType:'html',
                success: function(data){
                    $("#structrate-"+this_id).html(data);

                },
                beforeSend: function(){
                    $("#structrate-"+this_id).html("Loading...");
                }
            });


        // $(".bedtypepackage[id^="+this_id+"]").val('--Choose--');
    
        //END isnonres != 'N'
        }else{
           
            //Package Non Residential here
            $("select.bedtypepackage[id^="+this_id+"]").val('3');
    
            bedtype =  $(".bedtypepackage[id^="+this_id+"]").val();

    
            $(".hargapackres[id^="+this_id+"]").val('');

            var cin =  $(".checkinres[id^="+"cir-"+this_id+"]").val();
            var cout =  $(".checkoutres[id^="+"cor-"+this_id+"]").val();

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
                $("input.dayres[id^="+this_id+"]").val(1);

            }else{
                $("input.dayres[id^="+this_id+"]").val(jml_hari+1);
         
            }

            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_detil_packagenonres/" ,
                cache: false,
                data:({
                    kode:packageres,
                    property:property
                }),
                dataType:'json',
                success: function(data){
                    //alert('idmpack:'+data.idmpackage);
                    //(".desres[id^="+this_id+"]").val(data.deskripsi);
                    //  $("input.hargapackres[id^="+this_id+"]").val(data.price);
                    //$("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
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
                //   $(".hargapackres[id^="+this_id+"]").val('processing...');
                }
            });


            
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_meetingstructure2/" ,
                cache: false,
                data:({
                    typepackage: packageres,
                    property:property,
                    roompackage:bedtype
                }),
                dataType:'html',
                success: function(data){
                    $("#structrate-"+this_id).html(data);

                },
                beforeSend: function(){
                    $("#structrate-"+this_id).html("Loading..");
                }
            });




        //  $(".bedtypepackage[id^="+this_id+"]").val(3);
        }
            } 
        }); 
        
     
        
 
        return false;
    
    });
    ///END PACKAGERES//////////////////////////////////////////////////////

    $(".meetstruc").change(function(){
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
        //        alert(this_id);
        //        alert(meetstruc);
        //        alert(property);
        //        alert(bedtype);
        //        alert(packres);
        var packageres = $("select.packageres[id^="+this_id+"]").val();
        var isnonres = packageres.slice(0, 1);
        if(isnonres != 'N'){

            //    $.ajax({
            //        type:"POST",
            //        url: site_url+"offering_letter/get_detil_editmpackage/" ,
            //        cache: true,
            //        data:({meetstruc: $(this).val(), property: property,bedtype:bedtype,kode:idmpack}),
            //        dataType:'json',
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_packageprice_bymeetstruc",
                cache: false,
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

            //AJAX for get price room breakdown
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_roompricemp_by_meetstructmpackage/" ,
                cache: false,
                data:({
                    meetstruc: $(this).val(),
                    property: property,
                    bedtype:bedtype,
                    kode:idmpack
                }),
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
                cache: false,
                data:({
                    meetstruc: $(this).val(),
                    property: property,
                    bedtype:bedtype,
                    kode:idmpack
                }),
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

            //    $.ajax({
            //        type:"POST",
            //        url: site_url+"offering_letter/get_detil_editmpackagenonres/" ,
            //        cache: true,
            //        data:({meetstruc: $(this).val(), property: property, kode:idmpack}),
            //        dataType:'json',
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_packageprice_bymeetstruc",
                cache: false,
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

            //AJAX for get price f&b breakdown
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_fnbpricemp_by_meetstructmpackage/" ,
                cache: false,
                data:({
                    meetstruc: $(this).val(),
                    property: property,
                    bedtype:bedtype,
                    kode:idmpack
                }),
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
        var meetstruc  = $("div#structrate-"+this_id+" > select.meetingstrucnew").val();
        //    if($("div#structrate-"+this_id+" > select.meetingstrucnew").val() != undefined){
        //            meetstruc = $('select.meetstruc').val();
        //    }
        //
        //    if($('select.meetstruc').val() != undefined){
        //        meetstruc = $("div#structrate-"+this_id+" > select.meetingstrucnew").val();
        //    }
    
        //   alert(meetstruc)
        var property;
        if($('select#property').val() != undefined){
            property = $('select#property').val();
        }

        if($('select#editproperty').val() != undefined){
            property = $('select#editproperty').val();
        }
    

        var packres;
        packres =  $("select.packageres[id^="+this_id+"]").val();
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_meetingstructure2/" ,
            cache: false,
            data:({
                typepackage: packres,
                property:property,
                roompackage:$(this).val()//new 14April
            }),
            dataType:'html',
            success: function(data){
                $("#structrate-"+this_id).html(data);

            },
            beforeSend: function(){
                $("#structrate-"+this_id).html("Loading...");
            }
        });

        //   $.ajax({
        //            type:"POST",
        //            url: site_url+"offering_letter/get_packageprice_bymeetstruc",
        //            data:({
        //                meetstruc:meetstruc,
        //                bedtype:$(this).val(),
        //                property:property,
        //                typepackage:packres
        //            }),
        //            dataType:"json",
        //            success: function(data){
        //                $("input.hargapackres[id^="+this_id+"]").val(data.price);
        //                $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
        //                var day = 0;
        //                var price = 0;
        //                var pax = 0;
        //
        //                day = parseInt($("input.dayres[id^="+this_id+"]").val());
        //                price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
        //                pax = parseInt($("input.paxres[id^="+this_id+"]").val());
        //
        //                if(isNaN(day)){
        //                    day = 0;
        //                }
        //                if(isNaN(price)){
        //                    price = 0;
        //                }
        //                if(isNaN(pax)){
        //                    pax = 0;
        //                }
        //
        //                var total = day * price * pax
        //                var grandtotal = 0;
        //                $("input.totalres[id^="+this_id+"]").val(total);
        //
        //                $(".totalres").each(function(){
        //                    grandtotal += parseInt($(this).val());
        //                });
        //                $('input#grandtotal_res').val(grandtotal);
        //            //   alert(data.idmpackage);
        //
        //            },
        //            beforeSend: function(){
        //
        //            }
        //        });
        //    if($('select.meetstruc').val() == undefined || $('select.meetstruc').val() == ''){
        //    $.ajax({
        //        type:"POST",
        //        url: site_url+"offering_letter/get_detil_package/" ,
        //        cache: true,
        //        data:({bedtype: $(this).val(), property: property,kode:packres}),
        //        dataType:'json',
        //        success: function(data){
        //            //$(".desres[id^="+this_id+"]").val(data.deskripsi);
        ////            $(".hargapackres[id^="+this_id+"]").val(data.price);
        ////            $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
        //            var mpack = $("input.mpackage[id^="+this_id+"]").val();
        //            //alert(mpack);
        //            var day = 0;
        //            var price = 0;
        //            var pax = 0;
        //
        //            day = parseInt($("input.dayres[id^="+this_id+"]").val());
        //            price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
        //            pax = parseInt($("input.paxres[id^="+this_id+"]").val());
        //
        //            var total = day * price * pax
        //            var grandtotal = 0;
        //            $("input.totalres[id^="+this_id+"]").val(total);
        //            $(".totalres").each(function(){
        //                grandtotal += parseInt($(this).val());
        //            });
        //
        //            $('input#grandtotal_res').val(grandtotal);
        //        },
        //        beforeSend: function(){
        //            $(".desres[id^="+this_id+"]").val('processing...');
        ////            $(".hargapackres[id^="+this_id+"]").val('processing...');
        //        }
        //    });
        //
        //
        //    }
        //    else
        //        {
        //            var idmpack;
        //            idmpack =  $("input.mpackage[id^="+this_id+"]").val();
        //            var meetstruc = $("select.meetstruc[id^="+this_id+"]").val();
        //            $.ajax({
        //                type:"POST",
        //                url: site_url+"offering_letter/get_detil_editmpackage/" ,
        //                cache: true,
        //                data:({meetstruc: meetstruc, property: property,bedtype:$(this).val(),kode:idmpack}),
        //                dataType:'json',
        //                success: function(data){
        //                    //alert(data.idmpackage);
        //                   // $(".desres[id^="+this_id+"]").val(data.deskripsi);
        ////                    $(".hargapackres[id^="+this_id+"]").val(data.price);
        ////                    $("input.mpackage[id^="+this_id+"]").val(data.idmpackage);
        ////                    var mpack = $("input.mpackage[id^="+this_id+"]").val();
        //                   // alert(data.price);
        //                    var day = 0;
        //                    var price = 0;
        //                    var pax = 0;
        //                    day = parseInt($("input.dayres[id^="+this_id+"]").val());
        //                    price = parseInt($("input.hargapackres[id^="+this_id+"]").val());
        //                    pax = parseInt($("input.paxres[id^="+this_id+"]").val());
        //
        //                    var total = day * price * pax
        //                    var grandtotal = 0;
        //                    $("input.totalres[id^="+this_id+"]").val(total);
        //
        //                    $(".totalres").each(function(){
        //                        grandtotal += parseInt($(this).val());
        //                    });
        //
        //                    $('input#grandtotal_res').val(grandtotal);
        //                },
        //                beforeSend: function(){
        //                    $(".desres[id^="+this_id+"]").val('processing...');
        ////                    $(".hargapackres[id^="+this_id+"]").val('processing...');
        //                }
        //            });
        //
        //        }//END IF
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




    //////////////////PROPERTY/////////////////////////////////////////////////
    $("#property").change(function() {
        // alert($(this).val());
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_venueletter_by_property/"+$(this).val(),
            cache: false,
            success: function(data){
                $("div#venueletter").html(data);
            },
            beforeSend: function(){
                $("div#venueletter").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });

        var eventtype = $('select#eventtype').val();

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_package_byprop",
            cache: false,
            data:({
                eventtype:eventtype,
                property:$(this).val()
            }),
            dataType:"html",
            success: function(data){
                $("#packagebyprop").html(data );
            },
            beforeSend: function(){
                $("#packagebyprop").html('<img src="'+base_url+'images/loading.gif"/>');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_venue_by_property/"+$(this).val(),
            cache: false,
            success: function(data){
                $("div#venuex").html(data);
            },
            beforeSend: function(){
                $("div#venuex").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });


        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_room_by_property/"+$(this).val(),
            cache: false,
            //dataType:'json',
            success: function(data){
                $("div#refroom-1").html(data);
                $("div#refroom-2").html(data);
                $("div#refroom-3").html(data);
                $("div#refroom-4").html(data);
                $("div#refroom-5").html(data);
            },
            beforeSend: function(){
                $("div#refroom-1").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                $("div#refroom-2").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                $("div#refroom-3").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                $("div#refroom-4").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                $("div#refroom-5").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });


        
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_stall_by_property/" ,
            data:({
                
                property:$(this).val()
            }),
            cache: false,
            success: function(data){
                $("div#containerstall").html(data);
            },
            beforeSend: function(){
                $("div#containerstall").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });
                

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/generate_number/"+$(this).val(),
            cache: false,
            success: function(data){
                //alert(data);
                $("input#no_offering").val(data);
            },
            beforeSend: function(){
                $("input#no_offering").val("generating...");
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_additional_byproperty",
            cache: false,
            data:({
                property:$(this).val()
            }),
            
            dataType:"html",
            success: function(data){
                //$('#otherpackagerequirement #item_area tr:not(:last)').remove();
                $('#additional #item_area tr.addition').remove();
                $("div#containeradditional").html(data);
            },
            beforeSend: function(){
                $("div#containeradditional").html('<img width="25px" height="25px" alt="Loading..." src="'+base_url+'images/loading.gif"/>');
            }
        });


        //Venue Room Rental by Property
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_venuerental_byproperty/"+$(this).val(),
            cache: false,
            success: function(data){
                $("div.venuerental").html(data);
            },
            beforeSend: function(){
                $("div.venuerental").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });
   
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
        var roomstruc = $("select.roomstruc[id^="+numberid+"]").val();



        if(roomstruc == '' || roomstruc == undefined){
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_room_price",
                cache: false,
                data:({
                    account:account,
                    roomtype: roomtype,
                    property: property,
                    weektype: weektype
                }),
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
        }else{
            var room = $(this).val();
            var week = $("select.weektype[id^="+numberid+"]").val();
            var roomstruct = $("select.roomstruc[id^="+numberid+"]").val();
            var bedtype = $("select.bedtype[id^="+numberid+"]").val();
            $.ajax({
                type:"POST",
                cache: false,
                url: site_url+"offering_letter/get_roomstrucrate_price",
                data:({
                    property:property,
                    room:room,
                    week:week,
                    roomstruc:roomstruct,
                    bedtype:bedtype
                }),
                dataType:'json',
                success: function(data){
                    $("input.ratepernightroom[id^="+numberid+"]").val(data);

                    var grandtotal = 0;

                    $("input.revenueroom").each(function(){
                        grandtotal += parseInt($(this).val());
                    });

                    $("input#totalroomrevenue").val(grandtotal);
                },
                beforeSend: function(){
                //                             $("input.ratepernightroom[id^="+numberid+"]").val("processing...");
                //                             $("input.revenueroom[id^="+numberid+"]").val('calculating...');
                //                             $("input#totalroomrevenue").val('calculating...');
                }
            });
        // alert(roomstruc);
        }
    });


    $("select.weektype").change(function() {
       
        var this_id = $(this).attr('id');
        var roomtype  = $("div#refroom-"+this_id+" > select.roomtype").val();
        var weektype = $(this).val();
        var account = $('input#idaccount').val();
        
        var property;
        if($('select#property').val() != undefined){
            property = $('select#property').val();
        }
        if($('select#editproperty').val() != undefined){
            property = $('select#editproperty').val();
        }
        var roomstruc = $("select.roomstruc[id^="+this_id+"]").val();
        
        if(roomstruc == '' || roomstruc == undefined){
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_room_price",
                cache: false,
                data:({
                    account:account,
                    roomtype: roomtype,
                    property: property,
                    weektype: weektype
                }),
                dataType:'json',
                success: function(data){
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
                        var rr = $(this).val();
                        if(isNaN(rr)){
                            rr = 0;
                        }
                        grandtotal += parseInt(rr);
                    });

                    $("input#totalroomrevenue").val(grandtotal);
                },
                beforeSend: function(){
                    $("input.ratepernightroom[id^="+this_id+"]").val("processing...");
                    $("input.revenueroom[id^="+this_id+"]").val('calculating...');
                    $("input#totalroomrevenue").val('calculating...');
                }
            });
        }
        else{
       
            var room = $("select.roomtype[id^="+this_id+"]").val();
            var week = $(this).val();
            var roomstruct = $("select.roomstruc[id^="+this_id+"]").val();
            var bedtype = $("select.bedtype[id^="+this_id+"]").val();
            $.ajax({
                type:"POST",
                cache: false,
                url: site_url+"offering_letter/get_roomstrucrate_price",
                data:({
                    property:property,
                    room:room,
                    week:week,
                    roomstruc:roomstruct,
                    bedtype:bedtype
                }),
                dataType:'json',
                success: function(data){
                    $("input.ratepernightroom[id^="+this_id+"]").val(data);
                    var grandtotal = 0;
                    $("input.revenueroom").each(function(){
                        var rr = $(this).val();
                        if(isNaN(rr)){
                            rr = 0;
                        }
                        grandtotal += parseInt(rr);
                    });
                    $("input#totalroomrevenue").val(grandtotal);
                },
                beforeSend: function(){
                //                 $("input.ratepernightroom[id^="+this_id+"]").val("processing...");
                //                 $("input.revenueroom[id^="+this_id+"]").val('calculating...');
                //                 $("input#totalroomrevenue").val('calculating...');
                }
            });
        // alert(roomstruc);
        }
    });//end Week TYPE




    $("#week_si").change(function() {
        // alert($(this).val());
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_room_price",
            cache: false,
            data:({
                company:$("#customer").val(),
                room: $('div#refroom_si > #type').val(),
                property: $("#property").val(),
                week:$(this).val()
                }),
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
            cache: false,
            data:({
                company:$("#customer").val(),
                room: $('div#refroom_dbl > #type').val(),
                property: $("#property").val(),
                week:$(this).val()
                }),
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


    $("select.additionaldes").live('change', function(){
        var this_id = $(this).attr('id');
        var property;

        if($('select#property').val() != undefined){
            property = $('select#property').val();
        }

        if($('select#editproperty').val() != undefined){
            property = $('select#editproperty').val();
        }

        //        alert($(this).val());
        //        alert(property)
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_additionalmax_detil",
            cache: false,
            data:({
                idref:$(this).val(),
                idproperty:property
            }),
            dataType:'json',
            success: function(data){
                //alert(data );
                $("input.idadditionalx[id^="+this_id+"]").val(data.idadd);
               
                $("input.idadditionaledit[id^="+this_id+"]").val(data.idadd);

                $("input.qtyadd[id^="+this_id+"]").val(data.qty);
                $("input.unitadd[id^="+this_id+"]").val(data.unit);
                $("input.priceadd[id^="+this_id+"]").val(data.price);
                $("input.totaladd[id^="+this_id+"]").val(data.price * data.qty);
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
                cache: false,
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

    ///////////////////////////////////////////
    ///////////////////////////////////////////

    $(".cloneTableRoomRental").live('click', function(){
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
        $('#'+thisTableId + " tr:last").addClass('addonRowRental');
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
                    showButtonPanel: false
                });
            }

            if($(this).hasClass("dayrental")){ // if the current input has the hasDatpicker class
                var this_id6 = $(this).attr("id"); // current inputs id
                var new_id6 =  parseInt(this_id6) + 1; // a new id
                $(this).attr("id", new_id6); // change to new id
            }

            if($(this).hasClass("hargarental")){ // if the current input has the hasDatpicker class
                var this_id3 = $(this).attr("id"); // current inputs id
                var new_id3 =  parseInt(this_id3) + 1; // a new id
                $(this).attr("id", new_id3); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("paxrental")){ // if the current input has the hasDatpicker class
                var this_id4 = $(this).attr("id"); // current inputs id
                var new_id4 =  parseInt(this_id4) + 1; // a new id
                $(this).attr("id", new_id4); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("totalrental")){ // if the current input has the hasDatpicker class
                var this_id5 = $(this).attr("id"); // current inputs id
                var new_id5 =  parseInt(this_id5) + 1; // a new id
                $(this).attr("id", new_id5); // change to new id
                $(this).val('');
            }

        });

        //                                         $(newRow).find("div").each(function(){
        //                                                if($(this).hasClass("structratemeeeting")){ // if the current input has the hasDatpicker class
        //                                                    var this_id = $(this).attr("id"); // current inputs id
        //                                                    var txtid = this_id.slice(0,11);
        //                                                    var numberid = this_id.slice(11);
        //                                                    var new_id = parseInt(numberid) + 1;
        //                                                    // a new id
        //
        //                                                    $(this).attr("id", txtid+new_id); // change to new id
        //                                                }
        //                                            });

        $(newRow).find("select").each(function(){
            if($(this).hasClass("venuerental")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
                $(this).val('-- Choose --');
            }

            if($(this).hasClass("strucrental")){ // if the current input has the hasDatpicker class
                var this_id1sr = $(this).attr("id"); // current inputs id
                var new_id1sr =  parseInt(this_id1sr) + 1; // a new id
                $(this).attr("id", new_id1sr); // change to new id
                $(this).val('-- Choose --');
            }
        });



        return false;
    });
				 
    ///////////////////////////////////////////
    //////////////////////////////////////////
    $(".cloneRowsFBBreakdown").live('click', function(){
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
        $('#'+thisTableId + " tr:last").addClass('addonRowRental');
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
                    showButtonPanel: false
                });
            }
                                                
            if($(this).hasClass("paxfnbbreak")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("cb1")){ // if the current input has the hasDatpicker class
                var this_id2 = $(this).attr("id"); // current inputs id
                var new_id2 =  parseInt(this_id2) + 1; // a new id
                $(this).attr("id", new_id2); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("lunch")){ // if the current input has the hasDatpicker class
                var this_id3 = $(this).attr("id"); // current inputs id
                var new_id3 =  parseInt(this_id3) + 1; // a new id
                $(this).attr("id", new_id3); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("cb2")){ // if the current input has the hasDatpicker class
                var this_id4 = $(this).attr("id"); // current inputs id
                var new_id4 =  parseInt(this_id4) + 1; // a new id
                $(this).attr("id", new_id4); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("dinner")){ // if the current input has the hasDatpicker class
                var this_id5 = $(this).attr("id"); // current inputs id
                var new_id5 =  parseInt(this_id5) + 1; // a new id
                $(this).attr("id", new_id5); // change to new id
                $(this).val('');
            }

            if($(this).hasClass("cb3")){ // if the current input has the hasDatpicker class
                var this_id6 = $(this).attr("id"); // current inputs id
                var new_id6 =  parseInt(this_id6) + 1; // a new id
                $(this).attr("id", new_id6); // change to new id
                $(this).val('');
            }






            if($(this).hasClass("cb1cbox")){ // if the current input has the hasDatpicker class
                var this_id7 = $(this).attr("id"); // current inputs id
                var new_id7 =  parseInt(this_id7) + 1; // a new id
                $(this).attr("id", new_id7); // change to new id
            }

            if($(this).hasClass("lunchcbox")){ // if the current input has the hasDatpicker class
                var this_id8 = $(this).attr("id"); // current inputs id
                var new_id8 =  parseInt(this_id8) + 1; // a new id
                $(this).attr("id", new_id8); // change to new id
            }

            if($(this).hasClass("cb2cbox")){ // if the current input has the hasDatpicker class
                var this_id9 = $(this).attr("id"); // current inputs id
                var new_id9 =  parseInt(this_id9) + 1; // a new id
                $(this).attr("id", new_id9); // change to new id
            }

            if($(this).hasClass("dinnercbox")){ // if the current input has the hasDatpicker class
                var this_id10 = $(this).attr("id"); // current inputs id
                var new_id10 =  parseInt(this_id10) + 1; // a new id
                $(this).attr("id", new_id10); // change to new id
            }

            if($(this).hasClass("cb3cbox")){ // if the current input has the hasDatpicker class
                var this_id11 = $(this).attr("id"); // current inputs id
                var new_id11 =  parseInt(this_id11) + 1; // a new id
                $(this).attr("id", new_id11); // change to new id
            }

            if($(this).hasClass("totalfnbbreak")){ // if the current input has the hasDatpicker class
                var this_id12 = $(this).attr("id"); // current inputs id
                var new_id12 =  parseInt(this_id12) + 1; // a new id
                $(this).attr("id", new_id12); // change to new id
            }

                                                    





        });


        $(newRow).find("input:hidden").each(function(){
            if($(this).hasClass("idmpackagefnbbreak")){ // if the current input has the hasDatpicker class
                var this_id4 = $(this).attr("id"); // current inputs id
                var new_id4 =  parseInt(this_id4) + 1; // a new id
                $(this).attr("id", new_id4); // change to new id

            }

            if($(this).hasClass("idbedtypefnbbreak")){ // if the current input has the hasDatpicker class
                var this_id5 = $(this).attr("id"); // current inputs id
                var new_id5 =  parseInt(this_id5) + 1; // a new id
                $(this).attr("id", new_id5); // change to new id
                                                     
            }
        });

        $(newRow).find("select").each(function(){
            if($(this).hasClass("ref_meetstruc")){ // if the current input has the hasDatpicker class
                var this_id4 = $(this).attr("id"); // current inputs id
                var new_id4 =  parseInt(this_id4) + 1; // a new id
                $(this).attr("id", new_id4); // change to new id
                $(this).val('--Choose--');
            }

                                                     
        });
 


        return false;
    });
				 
    ///////////////////////////////////////////


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
                var txtid = this_id.slice(0,6);
                var numberid = this_id.slice(6);
                var new_id = parseInt(numberid) + 1;
                $(this).attr("id", txtid+new_id); // change to new id
                $(this).removeClass('hasDatepicker'); // remove hasDatepicker class
                // re-init datepicker
                $(this).datepicker({
                    dateFormat: 'dd-mm-yy',
                    showButtonPanel: true
                });
            }

            if($(this).hasClass("agendafnb")){ // if the current input has the hasDatpicker class
                var this_id9 = $(this).attr("id"); // current inputs id
                var new_id9 =  parseInt(this_id9) + 1; // a new id
                $(this).attr("id", new_id9); // change to new id
            // $(this).val('');
            }

            if($(this).hasClass("paxfnb")){ // if the current input has the hasDatpicker class
                var this_id10 = $(this).attr("id"); // current inputs id
                var new_id10 =  parseInt(this_id10) + 1; // a new id
                $(this).attr("id", new_id10); // change to new id
            // $(this).val('');
            }

            if($(this).hasClass("remarkfnb")){ // if the current input has the hasDatpicker class
                var this_id11 = $(this).attr("id"); // current inputs id
                var new_id11 =  parseInt(this_id11) + 1; // a new id
                $(this).attr("id", new_id11); // change to new id
            //$(this).val('');
            }
        });

        $(newRow).find("select").each(function(){
            if($(this).hasClass("endjamfnb")){ // if the current input has the hasDatpicker class
                var this_id7 = $(this).attr("id"); // current inputs id
                var new_id7 =  parseInt(this_id7) + 1; // a new id
                $(this).attr("id", new_id7); // change to new id
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

            if($(this).hasClass("bedtype")){ // if the current input has the hasDatpicker class
                var this_id6x = $(this).attr("id"); // current inputs id
                var new_id6x =  parseInt(this_id6x) + 1; // a new id
                $(this).attr("id", new_id6x); // change to new id

            }
        });

        $(newRow).find("div").each(function(){
            if($(this).hasClass("refroomtype")){ // if the current input has the hasDatpicker class
                var this_idx = $(this).attr("id"); // current inputs id

                var txtid = this_idx.slice(0,8);
                var numberid = this_idx.slice(8);
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

            if($(this).hasClass("weektypenew")){ // if the current input has the hasDatpicker class
                var this_id61 = $(this).attr("id"); // current inputs id
                var new_id61 =  parseInt(this_id61) + 1; // a new id
                $(this).attr("id", new_id61); // change to new id
            }

            if($(this).hasClass("roomstruc")){ // if the current input has the hasDatpicker class
                var this_idrs = $(this).attr("id"); // current inputs id
                var new_idrs =  parseInt(this_idrs) + 1; // a new id
                $(this).attr("id", new_idrs); // change to new id
            }

            if($(this).hasClass("bedtype")){ // if the current input has the hasDatpicker class
                var this_idbt = $(this).attr("id"); // current inputs id
                var new_idbt =  parseInt(this_idbt) + 1; // a new id
                $(this).attr("id", new_idbt); // change to new id
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

            if($(this).hasClass("refstrucrateroom")){ // if the current input has the hasDatpicker class
                var this_id71 = $(this).attr("id"); // current inputs id

                var txtid1 = this_id71.slice(0,17);
                var numberid1 = this_id71.slice(17);
                var new_id71 = parseInt(numberid1) + 1;

                $(this).attr("id", txtid1+new_id71); // change to new id
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
        $('#'+thisTableId + " tr:last").addClass('addonRowMeeting');
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
        $(newRow).find("div").each(function(){
            if($(this).hasClass("structratemeeeting")){ // if the current input has the hasDatpicker class
                var this_id = $(this).attr("id"); // current inputs id


                var txtid = this_id.slice(0,11);
                var numberid = this_id.slice(11);
                var new_id = parseInt(numberid) + 1;
                // a new id

                $(this).attr("id", txtid+new_id); // change to new id

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
            if($(this).hasClass("packagewedding")){ // if the current input has the hasDatpicker class
                var this_id9 = $(this).attr("id"); // current inputs id
                var new_id9 =  parseInt(this_id9) + 1; // a new id
                $(this).attr("id", new_id9); // change to new id
            }
        });
					 

        return false;
    });


    $(".cloneEditTablePackageReq").live('click', function(){
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
            if($(this).hasClass("editpackagewedding")){ // if the current input has the hasDatpicker class
                var this_id9 = $(this).attr("id"); // current inputs id
                var new_id9 =  parseInt(this_id9) + 1; // a new id
                $(this).attr("id", new_id9); // change to new id
                $(this).val('--Choose--');
            }

            if($(this).hasClass("strucpackage")){ // if the current input has the hasDatpicker class
                var this_id91 = $(this).attr("id"); // current inputs id
                var new_id91 =  parseInt(this_id91) + 1; // a new id
                $(this).attr("id", new_id91); // change to new id
                $(this).val('--Choose--');
            }
        });

        $(newRow).find("input:hidden").each(function(){
            if($(this).hasClass("refpack")){ // if the current input has the hasDatpicker class
                var this_id92 = $(this).attr("id"); // current inputs id
                var new_id92 =  parseInt(this_id92) + 1; // a new id
                $(this).attr("id", new_id92); // change to new id
            }

            if($(this).hasClass("idpackagewedding")){ // if the current input has the hasDatpicker class
                var this_idpw = $(this).attr("id"); // current inputs id
                var new_idpw =  parseInt(this_idpw) + 1; // a new id
                $(this).attr("id", new_idpw); // change to new id
                $(this).val('');
            }
        });

        $(newRow).find("div").each(function(){
            if($(this).hasClass("containerstructratepackage")){ // if the current input has the hasDatpicker class
                var this_id = $(this).attr("id"); // current inputs id


                var txtid = this_id.slice(0,15);
                var numberid = this_id.slice(15);
                var new_id = parseInt(numberid) + 1;
                // a new id

                $(this).attr("id", txtid+new_id); // change to new id
                $(this).html('');
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

        $('#'+thisTableId + " tr:last").addClass('addition');

        // clear the inputs (Optional)
        //$('#'+thisTableId + " tr:last td :input").val('');

        //					 new rows datepicker need to be re-initialized
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
                $(this).val('');
            }
                                                
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

            if($(this).hasClass("daysadd")){ // if the current input has the hasDatpicker class
                var this_id6 = $(this).attr("id"); // current inputs id
                var new_id6 =  parseInt(this_id6) + 1; // a new id
                $(this).attr("id", new_id6); // change to new id
                $(this).val('');
            }

                                                

                                                
        });

        $(newRow).find("select").each(function(){
            if($(this).hasClass("additionaldes")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
                $(this).val('--Choose--');
            }
        });

        $(newRow).find("input:hidden").each(function(){
            if($(this).hasClass("idadditionalx")){ // if the current input has the hasDatpicker class
                var this_id11 = $(this).attr("id"); // current inputs id
                var new_id11 =  parseInt(this_id11) + 1; // a new id
                $(this).attr("id", new_id11); // change to new id
                $(this).val('');
            }
        });

        return false;
    });


    $(".cloneTableEditAdditional").live('click', function(){
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

        $('#'+thisTableId + " tr:last").addClass('addition');

        // clear the inputs (Optional)
        //$('#'+thisTableId + " tr:last td :input").val('');

        //new rows datepicker need to be re-initialized
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

            if($(this).hasClass("daysadd")){ // if the current input has the hasDatpicker class
                var this_id61 = $(this).attr("id"); // current inputs id
                var new_id61 =  parseInt(this_id61) + 1; // a new id
                $(this).attr("id", new_id61); // change to new id
                $(this).val('');
            }

                                                 

                                               
        });

        $(newRow).find("select").each(function(){
            if($(this).hasClass("additionaldes")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id
                $(this).val('--Choose--');
            }

            if($(this).hasClass("meetstrucadditional")){ // if the current input has the hasDatpicker class
                var this_id1x = $(this).attr("id"); // current inputs id
                var new_id1x =  parseInt(this_id1x) + 1; // a new id
                $(this).attr("id", new_id1x); // change to new id
                $(this).val('');
            }
        });

        $(newRow).find("input:hidden").each(function(){
            if($(this).hasClass("idadditionaledit")){ // if the current input has the hasDatpicker class
                var this_id6 = $(this).attr("id"); // current inputs id
                var new_id6 =  parseInt(this_id6) + 1; // a new id
                $(this).attr("id", new_id6); // change to new id
                $(this).val('');
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
        //$('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");

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
                $(this).val($("#letter_checkin").val());
            }
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

    $(".cloneTableEditWeddingPackage").live('click', function(){
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
        //					 new rows datepicker need to be re-initialized
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
                $(this).val($("#letter_checkin").val());
            }
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

            //                                if($(this).hasClass("wedstall")){ // if the current input has the hasDatpicker class
            //                                    var this_id1 = $(this).attr("id"); // current inputs id
            //                                    var new_id1 =  parseInt(this_id1) + 1; // a new id
            //                                    $(this).attr("id", new_id1); // change to new id
            //
            //                                }

            if($(this).hasClass("editwedstall")){ // if the current input has the hasDatpicker class
                var this_idx = $(this).attr("id"); // current inputs id
                var new_idx =  parseInt(this_idx) + 1; // a new id
                $(this).attr("id", new_idx); // change to new id

            }


            if($(this).hasClass("strucstall")){ // if the current input has the hasDatpicker class
                var this_id19 = $(this).attr("id"); // current inputs id
                var new_id19 =  parseInt(this_id19) + 1; // a new id
                $(this).attr("id", new_id19); // change to new id

            }
        });

        $(newRow).find("input:hidden").each(function(){
            if($(this).hasClass("idwedstall")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var new_id1 =  parseInt(this_id1) + 1; // a new id
                $(this).attr("id", new_id1); // change to new id

            }

            if($(this).hasClass("idrefstall")){ // if the current input has the hasDatpicker class
                var this_idxc = $(this).attr("id"); // current inputs id
                var new_idxc =  parseInt(this_idxc) + 1; // a new id
                $(this).attr("id", new_idxc); // change to new id

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
                $(this).val('--Choose--');
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
                $(this).val('--Choose--');
            }
        });

        $(newRow).find("input:hidden").each(function(){
            if($(this).hasClass("mpackage")){ // if the current input has the hasDatpicker class
                var this_id8 = $(this).attr("id"); // current inputs id


                var new_id8 = parseInt(this_id8) + 1;

                $(this).attr("id",new_id8); // change to new id
            }
        });

        $(newRow).find("div").each(function(){
            if($(this).hasClass("structratemeeeting")){ // if the current input has the hasDatpicker class
                var this_id = $(this).attr("id"); // current inputs id


                var txtid = this_id.slice(0,11);
                var numberid = this_id.slice(11);
                var new_id = parseInt(numberid) + 1;
                // a new id

                $(this).attr("id", txtid+new_id); // change to new id
                $(this).html('');
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


    $("img.delFnbBreakdown").click(function(){
        $(this).parents("tr").remove();
        var total = 0;
        var totalroom = 0;
        $("input.totalfnbbreak").each(function(){
            total += parseInt($(this).val());
        });

        $("input.revenueroombreakdown").each(function(){
            totalroom += parseInt($(this).val());
        });

                                          
        $("input#grandtotalfnbbreak").val(total );

        $("input#fnbnroom").val(total +totalroom);
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

        if($("#idaccount").val() == ''){
            $.validationEngine.buildPrompt("#account","Please select company from available list","error");
        }else{
        if($("#form_offering_letter").validationEngine({
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
                url: site_url+"offering_letter/add_offering_letter",
                cache: false,
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
                      $('div#roomrental').css('display','none');
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
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
                }
            });
        
        }
        }
        return false;
    });

 

    $("input.qtyadd").keyup(function(){
        var this_id = $(this).attr('id');
        var qty = 0;
        var price = 0;
        var days = 0;
        var total = 0;
        qty = parseInt($(this).val());
        days = parseInt($("input.daysadd[id^="+this_id+"]").val());
        price = parseInt($("input.priceadd[id^="+this_id+"]").val());

        total = qty * price *days;
             
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

    $('select#eventtype').change(function(){
        var eventtype = $(this).val();
        var property;
        if($('select#property').val() != undefined){
            property = $('select#property').val();
        }

        if($('select#editproperty').val() != undefined){
            property = $('select#editproperty').val();
        }
        if(eventtype == 'ME' || eventtype == 'GH' || eventtype == 'GD' || eventtype == 'OT')
        {
            $('div#divroomreq').css('display','');
            $('div#divfnbreq').css('display','');
            $('div#divresidence').css('display','');
            $('div#divmeetingpackagecomment').css('display','');
            $('div#divadditional').css('display','');
            $('div#divgroupcommentparent').css('display','');
            $('div#roomrental').css('display','');

            $('div#divpackage').css('display','none');
            $('div#divpackage').css('display','none');
            $('div#divpackcomment').css('display','none');
            $('div#divstall').css('display','none');
            $('div#divotherpackagerequierement').css('display','none');
          
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
            $('div#roomrental').css('display','none');

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

       
        }else if(eventtype == 'RO'){
            $('div#divroomreq').css('display','');
            $('div#divfnbreq').css('display','none');
            $('div#divresidence').css('display','none');
            $('div#divmeetingpackagecomment').css('display','none');
            $('div#divadditional').css('display','');
            $('div#divgroupcommentparent').css('display','none');
            $('div#roomrental').css('display','');

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
            $("input#event_name").val($("input#account").val());

            $("select#venue_letter").val("NN"+property);
            $("select#layout_letter").val("NN")
        
        }
        else{
            $('div#divroomreq').css('display','');
            $('div#divfnbreq').css('display','');
            $('div#divresidence').css('display','none');
            $('div#divmeetingpackagecomment').css('display','none');
            $('div#divadditional').css('display','');
            $('div#divgroupcommentparent').css('display','none');

            $('div#roomrental').css('display','none');

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
            cache: false,
            data:({
                eventtype:eventtype,
                property:property
            }),
            dataType:"html",
            success: function(data){
                $("#packagebyeventtypeproperty").html(data );
            },
            beforeSend: function(){
                $("#packagebyeventtypeproperty").html('<img src="'+base_url+'images/loading.gif"/> Simpan...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_package_byprop",
            cache: false,
            data:({
                eventtype:eventtype,
                property:property
            }),
            dataType:"html",
            success: function(data){
                $("#packagebyprop").html(data );
            },
            beforeSend: function(){
                $("#packagebyprop").html('<img src="'+base_url+'images/loading.gif"/>');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_otherpackage_byevent",
            cache: false,
            data:({
                eventtype:eventtype
            }),
            dataType:"html",
            success: function(data){
                //$('#otherpackagerequirement > tr').remove();
                //$("#otherpackagerequirement tr:not(#master)").remove();
                $('#otherpackagerequirement #item_area tr:not(:last)').remove();
                $("#otpackage").html(data);
            },
            beforeSend: function(){
                $("#otpackage").html('<img src="'+base_url+'images/loading.gif"/> ');
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
	

    //$("#account").autocomplete(site_url+"offering_letter/get_companyaccount", {
    $("#account").autocomplete(site_url+"account/get_account_pergroup", {
        width: 198,
        selectFirst: false
    });

    $('input#account').flushCache();


    $("#account").result(function(event, data, formatted) {
        if (data){
            $('#idaccount').val(data[1]);//$(this).parent().next().find("input").val(data[1]);
            $.ajax({
                type:"POST",
                cache: false,
                url: site_url+"offering_letter/get_contact_byaccount",
                data:({
                    idaccount:data[1]
                    }),
                dataType:"html",
                success: function(data){
                    //$('#otherpackagerequirement > tr').remove();
                    //$("#otherpackagerequirement tr:not(#master)").remove();
                    $('#contactperson').html(data);
                    var eventtype = $("select#eventtype").val();
                    if(eventtype == "RO"){
                        $("input#event_name").val($("input#account").val());
                    }
                },
                beforeSend: function(){
                    $('#contactperson').html('<img src="'+base_url+'images/loading.gif"/> ');
                }
            });
        }//end IF
    });
 
    $("form#form_edit_offering").submit(function() {

        var confirmx = confirm("ARE YOU SURE?");
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
            // if($("#form_offering_letter").validationEngine({returnIsValid:true})){
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/edit_offering_letter",
                cache: false,
                data:$('#form_edit_offering').serialize(),
                dataType:"html",
                success: function(data){
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

                    $("#editproperty").val('-- Choose --');
                    $("#no_offering").val('');
                    $("#editaccount").val('');
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
                    $("#editpax_letter").val('');
                    $("#layout_letter").val('-- Choose --');
                    $("#venue_letter").val('-- Choose --');
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
                    $('input#letter_checkout').hide();
                    $('input#letter_checkin').hide();


                    $("#divchangestatus").hide();
                    $("#btnupdate").hide();
                    $(".button").hide();
                    //tinyMCE.activeEditor.setContent('');
                    tinyMCE.getInstanceById('roomcomment').setContent('');
                    tinyMCE.getInstanceById('fnb_comment').setContent('');
                    tinyMCE.getInstanceById('package_comment').setContent('');
                    tinyMCE.getInstanceById('group_comment').setContent('');
                    tinyMCE.getInstanceById('otherpackagereqcomment').setContent('');
                    tinyMCE.getInstanceById('opcomment').setContent('');
 
                    if(data == 'Data has changed.'){
                        //   window.location = site_url +'offering_letter';
                        $("#processing").html('<p> '+data+'</p>');
                    }
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>updating...');
                }
            });
    
        //        }
        }//end if confirm
        return false;
    });

$("#btnSubmitnew").click(function(){
     //var status = $('select#changestatus').val();
        var status = $('select#changestatusnew').val();
        //var cancelreason = $('select#cancelreason').val();
        var cancelreason = $('select#cancelreasonnew').val();
        //var datepostpone = $("#datepostponed").val();
        var datepostpone = $("#datepostponednew").val();
//        var btnconfirm = $("#btnconfirmnew").val();
//        var btncancel = $("#btncancelnew").val();
//        var btnupdate = $("#btnupdate").val();

        if((status == 'cancel' || status == 'LOSS' || status == 'REMOVE') && cancelreason == ''){
            alert('Please choose cancel reason first.');
        }else if(status == 'POSTPONED' && datepostpone == ''){
            alert('Please insert date first.');
        }else{
            var confirmx = confirm('ARE YOU SURE?');
            if(confirmx == true){
                $("#dialog").dialog('close');
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
                //if($("#form_offering_letter").validationEngine({returnIsValid:true})){
                $.ajax({
                    type:"POST",
                    url: site_url+"offering_letter/edit_offering_letter_meeting",
                    cache: false,
                    data:$('form#form_edit_offeringmeeting').serialize(),
                    dataType:"html",
                    success: function(data){
                        //alert(data);
                        ///////////////////////////////////////////////////////////
                        $('#changeconfirm').hide(100);                          ///
                        $('#changedata').hide(100);                             ///
                        $('p#psubmit').hide();                                  ///
                                                                                ///
                        $("#processing").html('<p> '+data+'</p>');              ///
                                                                                ///
                        $('input:checkbox#cbconfirmletter').attr('checked',''); ///
                        $('input:checkbox#cbchangedata').attr('checked','');    ///
                        ///////////////////////////////////////////////////////////

                        $("#editproperty").val('-- Choose --');
                        $("#no_offering").val('');
                        $("#editaccount").val('');
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
                        $("#editpax_letter").val('');
                        $("#layout_letter").val('-- Choose --');
                        $("#venue_letter").val('-- Choose --');
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
                        $('div#roomrental').css('display','none');

                        $('div#divpackage').css('display','none');
                        $('div#divpackage').css('display','none');
                        $('div#divpackcomment').css('display','none');
                        $('div#divstall').css('display','none');
                        $('div#divotherpackagerequierement').css('display','none');

                        $('label#datein').text('');
                        $('label#dateout').text('');
                        $('input#letter_checkout').hide();
                        $('input#letter_checkin').hide();

                        $("#divchangestatus").hide();
                        $("#btnupdate").hide();
                        $(".button").hide();
                        //tinyMCE.activeEditor.setContent('');
                        tinyMCE.getInstanceById('roomcomment').setContent('');
                        tinyMCE.getInstanceById('fnb_comment').setContent('');
                        tinyMCE.getInstanceById('package_comment').setContent('');
                        tinyMCE.getInstanceById('group_comment').setContent('');
                        tinyMCE.getInstanceById('otherpackagereqcomment').setContent('');
                        tinyMCE.getInstanceById('opcomment').setContent('');
                        //   $("div#divchangestatus").hide();
                        if(data == 'Data has changed.'){
                            //   window.location = site_url +'offering_letter';
                            $("#processing").html('<p> '+data+'</p>');
                        }
                    },
                    beforeSend: function(){
                        $("#processing").html('<img src="'+base_url+'images/loading.gif"/>updating...');
                    }
                });
            // }
            }else{//condition confirm dialog
            }//endif
        }//endif cancel reason
        return false;
        
})


    //$("#form_edit_offeringmeeting").validationEngine();
    $("form#form_edit_offeringmeeting").submit(function() {
        $("#dialog").dialog('close');
        //if($("#form_edit_offering").validationEngine({returnIsValid:true})){
        //var status = $('select#changestatus').val();
        var status = $('select#changestatusnew').val();
        //var cancelreason = $('select#cancelreason').val();
        var cancelreason = $('select#cancelreasonnew').val();

        //var datepostpone = $("#datepostponed").val();
        var datepostpone = $("#datepostponednew").val();

//        var btnconfirm = $("#btnconfirmnew").val();
//        var btncancel = $("#btncancelnew").val();
//        var btnupdate = $("#btnupdate").val();
        
        if((status == 'cancel' || status == 'LOSS' || status == 'REMOVE') && cancelreason == ''){
            alert('Please choose cancel reason first.');
        }else if(status == 'POSTPONED' && datepostpone == ''){
            alert('Please insert date first.');
        }else{
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
                //if($("#form_offering_letter").validationEngine({returnIsValid:true})){
                $.ajax({
                    type:"POST",
                    url: site_url+"offering_letter/edit_offering_letter_meeting",
                    cache: false,
                    data:$('form#form_edit_offeringmeeting').serialize(),
                    dataType:"html",
                    success: function(data){
                        //alert(data);
                        ///////////////////////////////////////////////////////////
                        $('#changeconfirm').hide(100);                          ///
                        $('#changedata').hide(100);                             ///
                        $('p#psubmit').hide();                                  ///
                                                                                ///
                        $("#processing").html('<p> '+data+'</p>');              ///
                                                                                ///
                        $('input:checkbox#cbconfirmletter').attr('checked',''); ///
                        $('input:checkbox#cbchangedata').attr('checked','');    ///
                        ///////////////////////////////////////////////////////////

                        $("#editproperty").val('-- Choose --');
                        $("#no_offering").val('');
                        $("#editaccount").val('');
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
                        $("#editpax_letter").val('');
                        $("#layout_letter").val('-- Choose --');
                        $("#venue_letter").val('-- Choose --');
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
                        $('div#roomrental').css('display','none');

                        $('div#divpackage').css('display','none');
                        $('div#divpackage').css('display','none');
                        $('div#divpackcomment').css('display','none');
                        $('div#divstall').css('display','none');
                        $('div#divotherpackagerequierement').css('display','none');

                        $('label#datein').text('');
                        $('label#dateout').text('');
                        $('input#letter_checkout').hide();
                        $('input#letter_checkin').hide();


                        $("#divchangestatus").hide();
                        $("#btnupdate").hide();
                        $(".button").hide();
                        //tinyMCE.activeEditor.setContent('');
                        tinyMCE.getInstanceById('roomcomment').setContent('');
                        tinyMCE.getInstanceById('fnb_comment').setContent('');
                        tinyMCE.getInstanceById('package_comment').setContent('');
                        tinyMCE.getInstanceById('group_comment').setContent('');
                        tinyMCE.getInstanceById('otherpackagereqcomment').setContent('');
                        tinyMCE.getInstanceById('opcomment').setContent('');
                        //   $("div#divchangestatus").hide();
                        if(data == 'Data has changed.'){
                            //   window.location = site_url +'offering_letter';
                            $("#processing").html('<p> '+data+'</p>');
                        }
                    },
                    beforeSend: function(){
                        $("#processing").html('<img src="'+base_url+'images/loading.gif"/>updating...');
                    }
                });

            // }
            }else{//condition confirm dialog



            }//endif
        }//endif cancel reason

        
        return false;
    });


    $("form#form_edit_off_to_conf").submit(function() {
        //        if($("#form_edit_offering").validationEngine({returnIsValid:true})){

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
            // if($("#form_offering_letter").validationEngine({returnIsValid:true})){
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/edit_offering_to_confirmation_letter",
                cache: false,
                data:$('form#form_edit_off_to_conf').serialize(),
                dataType:"html",
                success: function(data){
                
                    //                $('#changeconfirm').hide(100);
                    //                $('#changedata').hide(100);
                    //                $('p#psubmit').hide();
                    //                $("#processing").html('<p> '+data+'</p>');
                    //                $('input:checkbox#cbconfirmletter').attr('checked','');
                    //                $('input:checkbox#cbchangedata').attr('checked','');

                    $('#changeconfirm').hide(100);
                    $('#changedata').hide(100);
                    $('p#psubmit').hide();

                    $("#processing").html('<p> '+data+'</p>');              ///
                    ///
                    $('input:checkbox#cbconfirmletter').attr('checked',''); ///
                    $('input:checkbox#cbchangedata').attr('checked','');    ///
                    ///////////////////////////////////////////////////////////

                    $("#editproperty").val('-- Choose --');
                    $("#editproperty").val('-- Choose --');
                 
                    $("#no_offering").val('');
                    $("#editaccount").val('');
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
                    $("#editpax_letter").val('');
                    $("#layout_letter").val('-- Choose --');
                    $("#venue_letter").val('-- Choose --');
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

                    $('label#datein').text('');
                    $('label#dateout').text('');
                    $('input#letter_checkout').hide();
                    $('input#letter_checkin').hide();


                    $("#divchangestatus").hide();
                    $("#btnupdate").hide();

                    //tinyMCE.activeEditor.setContent('');
                    tinyMCE.getInstanceById('roomcomment').setContent('');
                    tinyMCE.getInstanceById('fnb_comment').setContent('');
                    tinyMCE.getInstanceById('package_comment').setContent('');
                    tinyMCE.getInstanceById('group_comment').setContent('');
                    tinyMCE.getInstanceById('otherpackagereqcomment').setContent('');
                    tinyMCE.getInstanceById('opcomment').setContent('');

                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
        }//END IF CONFIRM
        //        }
        return false;
    });



    $("form#form_edit_off_to_confmeeting_new").submit(function() {
        //        if($("#form_edit_offering").validationEngine({returnIsValid:true})){
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
            // if($("#form_offering_letter").validationEngine({returnIsValid:true})){
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/edit_offering_to_confirmationmeeting_new",
                cache: false,
                data:$('form#form_edit_off_to_confmeeting_new').serialize(),
                dataType:"html",
                success: function(data){
 
                    $('#changeconfirm').hide(100);
                    $('#changedata').hide(100);
                    $('p#psubmit').hide();

                    $("#processing").html('<p> '+data+'</p>');              ///
                    ///
                    $('input:checkbox#cbconfirmletter').attr('checked',''); ///
                    $('input:checkbox#cbchangedata').attr('checked','');    ///
                    ///////////////////////////////////////////////////////////

                    $("#editproperty").val('-- Choose --');
                    $("#editproperty").val('-- Choose --');

                    $("#no_offering").val('');
                    $("#editaccount").val('');
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
                    $("#editpax_letter").val('');
                    $("#layout_letter").val('-- Choose --');
                    $("#venue_letter").val('-- Choose --');
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
                    $('div#roomrental').css('display','none');

                    $('div#divpackage').css('display','none');
                    $('div#divpackage').css('display','none');
                    $('div#divpackcomment').css('display','none');
                    $('div#divstall').css('display','none');
                    $('div#divotherpackagerequierement').css('display','none');

                    $('label#datein').text('');
                    $('label#dateout').text('');
                    $('input#letter_checkout').hide();
                    $('input#letter_checkin').hide();


                    $("#divchangestatus").hide();
                    $("#btnupdate").hide();

                    //tinyMCE.activeEditor.setContent('');
                    tinyMCE.getInstanceById('roomcomment').setContent('');
                    tinyMCE.getInstanceById('fnb_comment').setContent('');
                    tinyMCE.getInstanceById('package_comment').setContent('');
                    tinyMCE.getInstanceById('group_comment').setContent('');
                    tinyMCE.getInstanceById('otherpackagereqcomment').setContent('');
                    tinyMCE.getInstanceById('opcomment').setContent('');

                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
        }//end if confirm
        return false;
    });

 
    //$("#changestatus").change(function(){
    //    var val = $(this).val();
    //    //alert(val);
    //    if(val == 'confirm'){
    //        $('#changeconfirm').show(100);
    //        $('#changedata').hide(100);
    //        $('input:checkbox#cbconfirmletter').attr('checked','');
    //        $('input:checkbox#cbchangedata').attr('checked','');
    //        $('p#psubmit').hide();
    //        $('input#btnupdate').hide();
    //    }else if(val=='cancel'){
    ////          $.ajax({
    ////                type:"POST",
    ////                url: site_url+"offering_letter/get_cancel_reason",
    ////                cache: false,
    ////                success: function(data){
    ////                    $("#containercancelreason").html(data);
    ////                },
    ////                beforeSend: function(){
    ////                    $("#containercancelreason").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    ////                }
    ////            });
    //        $("select#cancelreason").val('--Choose--');
    //        $("div#containerhotelcompetitor").html('');
    //        $('#changeconfirm').hide(100);
    //        $('#changedata').show(100);
    //        $('input:checkbox#cbconfirmletter').attr('checked','');
    //        $('input:checkbox#cbchangedata').attr('checked','');
    //        $('p#psubmit').hide();
    //        $('input#btnupdate').hide();
    //    }else if(val == 'LOSS'){
    //        $('#changedata').show(100);
    //        $.ajax({
    //                type:"POST",
    //                url: site_url+"offering_letter/get_cancel_reason",
    //                cache: false,
    //                data:({
    //                    status:val
    //                }),
    //                success: function(data){
    //                    $("#containercancelreason").html(data);
    //                },
    //                beforeSend: function(){
    //                    $("#containercancelreason").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    //                }
    //            });
    //
    //    }
    //    else{
    //        $('#changeconfirm').hide(100);
    //        $('#changedata').hide(100);
    //        $('p#psubmit').hide();
    //        $('input:checkbox#cbconfirmletter').attr('checked','');
    //        $('input:checkbox#cbchangedata').attr('checked','');
    //        $('p#psubmit').hide();
    //        $('input#btnupdate').show();
    //    }
    //});
    $("#changestatus").change(function(){
        var status = $(this).val();
        if(status != ''){
            $('p#psubmit').hide();
            $('input#btnupdate').hide();
            $('#changedata').show(100);
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_cancel_reason",
                cache: false,
                data:({
                    status:status
                }),
                success: function(data){
                    $("#containercancelreason").html(data);
                },
                beforeSend: function(){
                    $("#containercancelreason").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
        }else{
            $('p#psubmit').hide();
            $('input#btnupdate').show();
            $("div#containercancelreason").html('');
            $('#changedata').hide(100);
        }
        return false;
    })

    $("#changestatusnew").change(function(){
        var status = $(this).val();
        if(status != ''){
//            $('p#psubmit').hide();
//            $('input#btnupdate').hide();
//            $('#changedata').show(100);
            $.ajax({
                type:"POST",
                url: site_url+"offering_letter/get_cancel_reasonnew",
                cache: false,
                data:({
                    status:status
                }),
                success: function(data){
                    $("#containercancelreasonnew").html(data);
                },
                beforeSend: function(){
                    $("#containercancelreasonnew").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
        }else{
            $("#containercancelreasonnew").html('');
        }
        return false;
    })

    $("#changestatustoconfirmation").change(function(){
        var val = $(this).val();
        alert('Please re-check data before confirmation.');
        if(val == 'confirm'){
            $('#changeconfirm').show(100);
            $('#changedata').hide(100);
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
        }else if(val == 'LOSS' || val == 'REMOVE' || val == 'POSTPONED'){
            $('#changedata').show(100);
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
    //$('input#btnupdateconfirm').hide();
    //}
    //



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
            cache: false,
            success: function(data){
                $("div#venueletter").html(data);
            },
            beforeSend: function(){
                $("div#venueletter").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_venue_by_property/"+$(this).val(),
            cache: false,
            success: function(data){
                $("div#venuex").html(data);
            },
            beforeSend: function(){
                $("div#venuex").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });



        //                $.ajax({
        //                      type:"POST",
        //                      url: site_url+"offering_letter/get_room_by_property/"+$(this).val(),
        //                      cache: true,
        //                      //dataType:'json',
        //                      success: function(data){
        //                          var numrowroom = $('#jmlroomrow').val();
        //                          var i=4;
        //                          for(i=4;i<=numrowroom+1;i++){
        //                                $("div#refroom-"+i+"").html(data);
        //                          }
        //
        ////                          $("div#refroom-2").html(data);
        ////                          $("div#refroom-3").html(data);
        //                       },
        //                      beforeSend: function(){
        //                          $("div#refroom-1").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
        //                          $("div#refroom-2").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
        //                          $("div#refroom-3").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
        //                     }
        //                });

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_room_by_property/"+$(this).val(),
            cache: false,
            //dataType:'json',
            success: function(data){
                $("div#refroom-1").html(data);
                $("div#refroom-2").html(data);
                $("div#refroom-3").html(data);
                $("div#refroom-4").html(data);
                $("div#refroom-5").html(data);
            },
            beforeSend: function(){
                $("div#refroom-1").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                $("div#refroom-2").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                $("div#refroom-3").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                $("div#refroom-4").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
                $("div#refroom-5").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
            }
        });

        //Venue Room Rental by Property
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_venuerental_byproperty/"+$(this).val(),
            cache: false,
            success: function(data){
                $("div.venuerental").html(data);
            },
            beforeSend: function(){
                $("div.venuerental").html('<img width="25px" height="25px" src="'+base_url+'images/loading.gif"/>');
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
            cache: false,
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



 

    //ANGKA AJA/////
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

    $("input.qtyroom").keypress(function(e)
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
    //END ANGKA AJA/////


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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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
            $("input.daypack[id^="+numberid+"]").val(jml_hari+1);
        }
            
        var pax = $("input.pax_pack[id^="+this_id+"]").val();
        var price = $("input.hargapackage[id^="+this_id+"]").val();
        var day = $("input.daypack[id^="+this_id+"]").val();

        if(pax == '')
        {
            pax = 0;
        }

        if(price == '')
        {
            price = 0;
        }

        if(day == '')
        {
            day = 0;
        }

        var total = 0;
        total = parseInt(pax) * parseInt(price)  ;
        $("input.totalpack[id^="+this_id+"]").val(total);

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

        var tgl_awal = new Date(yr1, mon1-1, dt1);
        var tgl_akhir = new Date(yr2, mon2-1, dt2);

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
            $("input.daypack[id^="+numberid+"]").val(jml_hari+1);
        }


        var pax = $("input.pax_pack[id^="+this_id+"]").val();
        var price = $("input.hargapackage[id^="+this_id+"]").val();
        var day = $("input.daypack[id^="+this_id+"]").val();

        if(pax == '')
        {
            pax = 0;
        }

        if(price == '')
        {
            price = 0;
        }

        if(day == '')
        {
            day = 0;
        }

        var total = 0;
        total = parseInt(pax) * parseInt(price)  ;
        $("input.totalpack[id^="+this_id+"]").val(total);
        return false;
    });

    $('input.qtyroombreakdown').keyup(function(){
        var this_id = $(this).attr('id');
        var qtyroom = $(this).val();
        var night =    $("input.nightroombreakdown[id^="+this_id+"]").val();
        var rate = $("input.ratepernightroombreakdown[id^="+this_id+"]").val();
        var total = parseInt(qtyroom) * parseInt(rate) * parseInt(night);
        $("input.revenueroombreakdown[id^="+this_id+"]").val(total);

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
    });


    $('input.paxfnbbreak').keyup(function(){
        //alert('asdsd');
        var this_id = $(this).attr('id');
        var pax = $(this).val();
        //var days = $("input.daysfnbbreakdown[id^="+this_id+"]").val();
        var cb1 = $("input.cb1[id^="+this_id+"]").val();
        var cb2 = $("input.cb2[id^="+this_id+"]").val();
        var cb3 = $("input.cb3[id^="+this_id+"]").val();
        var lunch = $("input.lunch[id^="+this_id+"]").val();
        var dinner = $("input.dinner[id^="+this_id+"]").val();
        var total = (parseInt(cb1) + parseInt(cb2)+ parseInt(cb3) + parseInt(lunch)+ parseInt(dinner)) * pax
        $("input.totalfnbbreak[id^="+this_id+"]").val(total);
        var totalfb = 0;
        //strNumber = strNumber.replace(/[\D\s]/g, '');
        $("input.totalfnbbreak").each(function(){
            totalfb += parseInt($(this).val());
        });

        var totalroom = 0;
        $("input.revenueroombreakdown").each(function(){
            totalroom += parseInt($(this).val().replace(/[\D\s]/g, ''));
        });
        
        $('input#grandtotalfnbbreak').val( totalfb);
        $('input#fnbnroom').val(totalroom + totalfb);

    });


    $('select.ref_meetstruc').change(function(){
   
        var this_id = $(this).attr('id');
    
        $(".cb1cbox[id^="+this_id+"]").attr("checked","checked");
        $(".lunchcbox[id^="+this_id+"]").attr("checked","checked");
        $(".cb2cbox[id^="+this_id+"]").attr("checked","checked");
        $(".dinnercbox[id^="+this_id+"]").attr("checked","checked");
        $(".cb3cbox[id^="+this_id+"]").attr("checked","checked");

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
                cache: false,
                data:({
                    meetstruc: $(this).val(),
                    property: property,
                    bedtype:bedtype,
                    kode:idmpack
                }),
                dataType:'json',
                success: function(data){
                    $(".cb1[id^="+this_id+"]").val(data.cb1);
                    $(".cb2[id^="+this_id+"]").val(data.cb2);
                    $(".cb3[id^="+this_id+"]").val(data.cb3);
                    $(".lunch[id^="+this_id+"]").val(data.lunch);
                    $(".dinner[id^="+this_id+"]").val(data.dinner);
                    $(".idmpackagefnbbreak[id^="+this_id+"]").val(data.idmpackage);
                    var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();
                    // var days = $("input.daysfnbbreakdown[id^="+this_id+"]").val();
                    var cb1 = $("input.cb1[id^="+this_id+"]").val();
                    var cb2 = $("input.cb2[id^="+this_id+"]").val();
                    var cb3 = $("input.cb3[id^="+this_id+"]").val();
                    var lunch = $("input.lunch[id^="+this_id+"]").val();
                    var dinner = $("input.dinner[id^="+this_id+"]").val();
                    var total = (parseInt(cb1) + parseInt(cb2)+parseInt(cb3) + parseInt(lunch)+ parseInt(dinner)) * pax ;//* days;
                    $("input.totalfnbbreak[id^="+this_id+"]").val(total);

                    var totalfb = 0;
                    //strNumber = strNumber.replace(/[\D\s]/g, '');
                    $("input.totalfnbbreak").each(function(){
                        totalfb += parseInt($(this).val());
                    });

                    var totalroom = 0;
                    $("input.revenueroombreakdown").each(function(){
                        totalroom += parseInt($(this).val().replace(/[\D\s]/g, ''));
                    });

                    $('input#grandtotalfnbbreak').val( totalfb);
                    $('input#fnbnroom').val(totalroom + totalfb);


        
                },
                beforeSend: function(){
                    $(".cb1[id^="+this_id+"]").val('processing..');
                    $(".cb2[id^="+this_id+"]").val('processing..');
                    $(".cb3[id^="+this_id+"]").val('processing..');
                    $(".lunch[id^="+this_id+"]").val('processing..');
                    $(".dinner[id^="+this_id+"]").val('processing..');
                }

            });
        }else{
            $(".cb1[id^="+this_id+"]").val(0);
            $(".cb2[id^="+this_id+"]").val(0);
            $(".cb3[id^="+this_id+"]").val(0);
            $(".lunch[id^="+this_id+"]").val(0);
            $(".dinner[id^="+this_id+"]").val(0);
            //$(".idmpackagefnbbreak[id^="+this_id+"]").val(data.idmpackage);
            var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();
            // var days = $("input.daysfnbbreakdown[id^="+this_id+"]").val();
            var cb1 = $("input.cb1[id^="+this_id+"]").val();
            var cb2 = $("input.cb2[id^="+this_id+"]").val();
            var cb3 = $("input.cb3[id^="+this_id+"]").val();
            var lunch = $("input.lunch[id^="+this_id+"]").val();
            var dinner = $("input.dinner[id^="+this_id+"]").val();
            var total = (parseInt(cb1) + parseInt(cb2)+ parseInt(cb3) + parseInt(lunch)+ parseInt(dinner)) * pax ;//* days;
            $("input.totalfnbbreak[id^="+this_id+"]").val(total);


            var totalfb = 0;
            //strNumber = strNumber.replace(/[\D\s]/g, '');
            $("input.totalfnbbreak").each(function(){
                totalfb += parseInt($(this).val());
            });

            var totalroom = 0;
            $("input.revenueroombreakdown").each(function(){
                totalroom += parseInt($(this).val().replace(/[\D\s]/g, ''));
            });

            $('input#grandtotalfnbbreak').val( totalfb);
            $('input#fnbnroom').val(totalroom + totalfb);

        }

    });



    $('select.packagewedding').live('change',function(){
        //alert('halo');
        var this_id = $(this).attr('id');
    
        //alert($(this).val());
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_package_price",
            cache: false,
            data:({
                idpackage:$(this).val()
            }),
            dataType:"json",
            success: function(data){
                //alert(data.pax)
                $("input.hargapackage[id^="+this_id+"]").val(data.price);
                $("input.paxpack[id^="+this_id+"]").val(data.pax);
                // alert(data.idrefpackage)
                $("input.refpack[id^="+this_id+"]").val(data.idrefpackage);
                    
                //alert(data.idmeetstruc)
                $("select.strucpackage[id^="+this_id+"]").val(data.idmeetstruc);
                var pax = $("input.paxpack[id^="+this_id+"]").val();
                var price = $("input.hargapackage[id^="+this_id+"]").val();
                var day = $("input.daypack[id^="+this_id+"]").val();
                if(pax == '')
                {
                    pax = 0;
                }

                if(price == '')
                {
                    price = 0;
                }

                if(day == '')
                {
                    day = 0;
                }

                var total = 0;
                total = parseInt(pax) * parseInt(price)  ;
                $("input.totalpack[id^="+this_id+"]").val(total);

            },
            beforeSend: function(){
                $("input.hargapackage[id^="+this_id+"]").val('processing...');
            }
        });


            
        
    });


    $('select.editpackagewedding').live('change',function(){
        //alert('halo');
        var this_id = $(this).attr('id');
        var strucpack = $("select.strucpackage[id^="+this_id+"]").val();
        // alert(strucpack);
        // alert($(this).val())

        //updated 1 July 2010
        $.ajax({
            type:"POST",
            cache: false,
            url: site_url+"offering_letter/get_package_strucrate",
            data:({
                idpackage:$(this).val()
            }),
            dataType:"html",
            success: function(data){
                $("#structratepack-"+this_id).html(data);
            },
            beforeSend: function(){
                $("#structratepack-"+this_id).html('Loading');
            }
        });
        //end updated 2 July 2010
        
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_editpackage_price",
            cache: false,
            data:({
                idrefpackage:$(this).val(),
                idmeetstruc:strucpack
            }),
            dataType:"json",
            success: function(data){
                // alert(data.price);
                $("input.idpackagewedding[id^="+this_id+"]").val(data.idpackage);
                $("input.hargapackage[id^="+this_id+"]").val(data.price);
                $("input.paxpack[id^="+this_id+"]").val(data.pax);
                //alert(data.idrefpackage)
                $("input.refpack[id^="+this_id+"]").val(data.idrefpackage);
                //alert(data.idmeetstruc)
                $("select.strucpackage[id^="+this_id+"]").val(data.idmeetstruc);
                var pax = $("input.paxpack[id^="+this_id+"]").val();
                var price = $("input.hargapackage[id^="+this_id+"]").val();
                var day = $("input.daypack[id^="+this_id+"]").val();
                if(pax == '')
                {
                    pax = 0;
                }
                    
                if(price == '')
                {
                    price = 0;
                }

                if(day == '')
                {
                    day = 0;
                }

                var total = 0;
                total = parseInt(pax) * parseInt(price)  ;
                $("input.totalpack[id^="+this_id+"]").val(total);
            },
            beforeSend: function(){
                $("input.hargapackage[id^="+this_id+"]").val('processing...');
            }
        });
    });


    $('input.paxpack').keyup(function(){
        //alert('asd');
        var this_id = $(this).attr('id');
        var pax = $(this).val();
        var price = $("input.hargapackage[id^="+this_id+"]").val();
        var day = $("input.daypack[id^="+this_id+"]").val();

        if(pax == '')
        {
            pax = 0;
        }

        if(price == '')
        {
            price = 0;
        }

        if(day == '')
        {
            day = 0;
        }

        var total = 0;
        total = parseInt(pax) * parseInt(price) ;
        $("input.totalpack[id^="+this_id+"]").val(total);
    
    })


    $('select.wedstall').live('change',function(){
        //alert('halo');
        var this_id = $(this).attr('id');
        //$("input.idrefstall[id^="+this_id+"]").val($(this).val());
        // alert(this_id);
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_stall_price",
            cache: false,
            data:({
                idstall:$(this).val()
            }),
            dataType:"json",
            success: function(data){
                //alert(data.price)
                $("input.stallprice[id^="+this_id+"]").val(data.price);
                $("input.idwedstall[id^="+this_id+"]").val(data.idwedstall);
                $("select.strucstall[id^="+this_id+"]").val(data.idmeetstruc);
                var pax = $("input.stallpax[id^="+this_id+"]").val();
                var price = $("input.stallprice[id^="+this_id+"]").val();

                if(pax == '')
                {
                    pax = 0;
                }

                if(price == '')
                {
                    price = 0;
                }

                 
                var total = 0;
                total = parseInt(pax) * parseInt(price)  ;
                $("input.stalltotal[id^="+this_id+"]").val(total);

            },
            beforeSend: function(){
                $("input.stallprice[id^="+this_id+"]").val('processing...');
            }
        });

    });


    $('select.editwedstall').live('change',function(){
     
        var this_id = $(this).attr('id');
        // alert(this_id );
        var struc =  $("select.strucstall[id^="+this_id+"]").val();
    
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_stall_detil",
            cache: false,
            data:({
                idstall:$(this).val(),
                idstruc:struc
            }),
            dataType:"json",
            success: function(data){
                // alert(data.idmeetstruc)
                $("input.stallprice[id^="+this_id+"]").val(data.price);
                $("input.idwedstall[id^="+this_id+"]").val(data.idwedstall);
                $("select.strucstall[id^="+this_id+"]").val(data.idmeetstruc);
                $("input.idrefstall[id^="+this_id+"]").val(data.idrefstall);
                var pax = $("input.stallpax[id^="+this_id+"]").val();
                var price = $("input.stallprice[id^="+this_id+"]").val();

                if(pax == '')
                {
                    pax = 0;
                }

                if(price == '')
                {
                    price = 0;
                }


                var total = 0;
                total = parseInt(pax) * parseInt(price)  ;
                $("input.stalltotal[id^="+this_id+"]").val(total);


            },
            beforeSend: function(){
                $("input.stallprice[id^="+this_id+"]").val('processing...');
            }
        });

    });


    $('input.stallpax').keyup(function(){
        //alert('asd');
        var this_id = $(this).attr('id');
        var pax = $(this).val();
        var price = $("input.stallprice[id^="+this_id+"]").val();
   

        if(pax == '')
        {
            pax = 0;
        }

        if(price == '')
        {
            price = 0;
        }
 

        var total = 0;
        total = parseInt(pax) * parseInt(price) ;
        $("input.stalltotal[id^="+this_id+"]").val(total);


    })

    $('select.strucpackage').live('change',function(){
        var this_id = $(this).attr('id');
        var idrefpackage =  $("select.editpackagewedding[id^="+this_id+"]").val();//$("input.refpack[id^="+this_id+"]").val();
        //alert($(this).val());
   
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_package_ratebystruc",
            cache: false,
            data:({
                idstruc:$(this).val(),
                idrefpack:idrefpackage
            }),
            dataType:"json",
            success: function(data){
                //alert(data.price);
                $("input.hargapackage[id^="+this_id+"]").val(data.price);
                $("input.idpackagewedding[id^="+this_id+"]").val(data.idpackage);

                var night;
                var pax;
                var harga;

                night = $("input.daypack[id^="+this_id+"]").val();
                pax =  $("input.paxpack[id^="+this_id+"]").val();
                harga = $("input.hargapackage[id^="+this_id+"]").val();

                    
                var total = parseInt(night)* parseInt(pax) * parseInt(harga);
                    
                $("input.totalpack[id^="+this_id+"]").val(total);
            },
            beforeSend: function(){
                $("input.hargapackage[id^="+this_id+"]").val('processing...');
            }
        });
    });

    $('select.strucpackagenew').live('change',function(){
        var divid = $(this).parent("div").attr('id');
        var this_id = divid.slice(15);
        //alert(this_id);
        // var this_id = $(this).attr('id');
        var idrefpackage =  $("select.editpackagewedding[id^="+this_id+"]").val();//$("input.refpack[id^="+this_id+"]").val();
        //alert($(this).val());

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_package_ratebystruc",
            cache: false,
            data:({
                idstruc:$(this).val(),
                idrefpack:idrefpackage
            }),
            dataType:"json",
            success: function(data){
                //alert(data.price);
                $("input.hargapackage[id^="+this_id+"]").val(data.price);
                $("input.idpackagewedding[id^="+this_id+"]").val(data.idpackage);

                var night;
                var pax;
                var harga;

                night = $("input.daypack[id^="+this_id+"]").val();
                pax =  $("input.paxpack[id^="+this_id+"]").val();
                harga = $("input.hargapackage[id^="+this_id+"]").val();


                var total = parseInt(night)* parseInt(pax) * parseInt(harga);

                $("input.totalpack[id^="+this_id+"]").val(total);
            },
            beforeSend: function(){
                $("input.hargapackage[id^="+this_id+"]").val('processing...');
            }
        });
    });

    $('select.strucstall').live('change',function(){
        var this_id = $(this).attr('id');
        var idwedstall = $("select.editwedstall[id^="+this_id+"]").val();//$("input.idwedstall[id^="+this_id+"]").val();
        //alert(this_id);
        var property;
        if($('select#property').val() != undefined){
            property = $('select#property').val();
        }

        if($('select#editproperty').val() != undefined){
            property = $('select#editproperty').val();
        }

    

        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_stall_ratebystruc",
            cache: false,
            data:({
                idstrucstall:$(this).val(),
                idproperty:property,
                idwedstall:idwedstall
            }),
            dataType:"json",
            success: function(data){
                //alert(data.price);
                $("input.stallprice[id^="+this_id+"]").val(data.price);
                $("input.idrefstall[id^="+this_id+"]").val(data.idrefstall);

                var pax = $("input.stallpax[id^="+this_id+"]").val();
                var price = $("input.stallprice[id^="+this_id+"]").val();

                if(pax == '')
                {
                    pax = 0;
                }

                if(price == '')
                {
                    price = 0;
                }
                var total = 0;
                total = parseInt(pax) * parseInt(price)  ;
                $("input.stalltotal[id^="+this_id+"]").val(total);
            },
            beforeSend: function(){
                $("input.stallprice[id^="+this_id+"]").val('processing...');
            }
        });
    });



    $(".contactpersonletter").live('change',function(){
        var this_id = $(this).attr('id');
        // alert($(this).val())
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_sales_bycontactperson",
            cache: false,
            data:({
                idcontact:$(this).val()
            
            }),
            dataType:"html",
            success: function(data){
                // alert(data);
                $('select#sales').val(data);
                $('select#source').val(data);
            },
            beforeSend: function(){

            }
        });

    })


    $("input#event_name").keyup(function()
    {
        $("input#agenda_fnb").val($(this).val());
    })


    $("select.meetstrucadditional").change(function(){
        var this_id = $(this).attr('id');
        var ref_add = $("select.additionaldes[id^="+this_id+"]").val();
        var property;
   
        if($('select#property').val() != undefined){
            property = $('select#property').val();
        }

        if($('select#editproperty').val() != undefined){
            property = $('select#editproperty').val();
        }

        //        alert(property);
        //        alert(ref_add);
        //        alert($(this).val());
   
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_detilstruc_additional",
            cache: false,
            data:({
                idstrucrate:$(this).val(),
                idproperty:property,
                idrefadd:ref_add
            }),
            dataType:"json",
            success: function(data){
                // alert(data.qty);
                $("input.idadditionaledit[id^="+this_id+"]").val(data.idadditional);
                //$("input.qtyadd[id^="+this_id+"]").val(data.qty);
                $("input.unitadd[id^="+this_id+"]").val(data.unit);
                $("input.priceadd[id^="+this_id+"]").val(data.price);
           
                //            if($("select.additionaldes[id^="+this_id+"]").val() == 1){
                //                $("input.daysadd[id^="+this_id+"]").val(jml_hari);
                //            }else{
                //                $("input.daysadd[id^="+this_id+"]").val(jml_hari+1);
                //            }
                var days = $("input.daysadd[id^="+this_id+"]").val();
                var qty =  $("input.qtyadd[id^="+this_id+"]").val();
                var price = $("input.priceadd[id^="+this_id+"]").val();

                var total = parseInt(days) * parseInt(qty) * parseInt(price);
                if(!isNaN(total)){
                    $("input.totaladd[id^="+this_id+"]").val(total);
                }
            },
            beforeSend: function(){

            }
        });
   
    });


    $(".cb1cbox").change(function(){
        var this_id = $(this).attr("id");
        //alert(this_id);
        if(!$(this).is(":checked")){
            $("input.cb1[id^="+this_id+"]").val(0);
        }

        var cb1 =  $("input.cb1[id^="+this_id+"]").val();
        var lunch =  $("input.lunch[id^="+this_id+"]").val();
        var cb2 =  $("input.cb2[id^="+this_id+"]").val();
        var dinner =  $("input.dinner[id^="+this_id+"]").val();
        var cb3 =  $("input.cb3[id^="+this_id+"]").val();

        var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();

        var total = (parseInt(cb1) + parseInt(lunch) + parseInt(cb2) + parseInt(dinner) + parseInt(cb3)) * pax;
    
        $("input.totalfnbbreak[id^="+this_id+"]").val(total);

        var totalfb = 0;
        //strNumber = strNumber.replace(/[\D\s]/g, '');
        $("input.totalfnbbreak").each(function(){
            totalfb += parseInt($(this).val());
        });

        var totalroom = 0;
        $("input.revenueroombreakdown").each(function(){
            totalroom += parseInt($(this).val().replace(/[\D\s]/g, ''));
        });

        $('input#grandtotalfnbbreak').val( totalfb);
        $('input#fnbnroom').val(totalroom + totalfb);
    
    })

    $(".lunchcbox").change(function(){
        var this_id = $(this).attr("id");
        //alert(this_id);

        if(!$(this).is(":checked")){
            $("input.lunch[id^="+this_id+"]").val("0");
        }

        var cb1 =  $("input.cb1[id^="+this_id+"]").val();
        var lunch =  $("input.lunch[id^="+this_id+"]").val();
        var cb2 =  $("input.cb2[id^="+this_id+"]").val();
        var dinner =  $("input.dinner[id^="+this_id+"]").val();
        var cb3 =  $("input.cb3[id^="+this_id+"]").val();

        var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();

        var total = (parseInt(cb1) + parseInt(lunch) + parseInt(cb2) + parseInt(dinner) + parseInt(cb3)) * pax;

        $("input.totalfnbbreak[id^="+this_id+"]").val(total);

        var totalfb = 0;
        //strNumber = strNumber.replace(/[\D\s]/g, '');
        $("input.totalfnbbreak").each(function(){
            totalfb += parseInt($(this).val());
        });

        var totalroom = 0;
        $("input.revenueroombreakdown").each(function(){
            totalroom += parseInt($(this).val().replace(/[\D\s]/g, ''));
        });

        $('input#grandtotalfnbbreak').val( totalfb);
        $('input#fnbnroom').val(totalroom + totalfb);

    })

    $(".cb2cbox").change(function(){
        var this_id = $(this).attr("id");
        //alert(this_id);


        if(!$(this).is(":checked")){
            $("input.cb2[id^="+this_id+"]").val("0");
        }

        var cb1 =  $("input.cb1[id^="+this_id+"]").val();
        var lunch =  $("input.lunch[id^="+this_id+"]").val();
        var cb2 =  $("input.cb2[id^="+this_id+"]").val();
        var dinner =  $("input.dinner[id^="+this_id+"]").val();
        var cb3 =  $("input.cb3[id^="+this_id+"]").val();

        var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();

        var total = (parseInt(cb1) + parseInt(lunch) + parseInt(cb2) + parseInt(dinner) + parseInt(cb3)) * pax;

        $("input.totalfnbbreak[id^="+this_id+"]").val(total);

        var totalfb = 0;
        //strNumber = strNumber.replace(/[\D\s]/g, '');
        $("input.totalfnbbreak").each(function(){
            totalfb += parseInt($(this).val());
        });

        var totalroom = 0;
        $("input.revenueroombreakdown").each(function(){
            totalroom += parseInt($(this).val().replace(/[\D\s]/g, ''));
        });

        $('input#grandtotalfnbbreak').val( totalfb);
        $('input#fnbnroom').val(totalroom + totalfb);
    })

    $(".dinnercbox").change(function(){
        var this_id = $(this).attr("id");
        //alert(this_id);
        if(!$(this).is(":checked")){
            $("input.dinner[id^="+this_id+"]").val("0");
        }

        var cb1 =  $("input.cb1[id^="+this_id+"]").val();
        var lunch =  $("input.lunch[id^="+this_id+"]").val();
        var cb2 =  $("input.cb2[id^="+this_id+"]").val();
        var dinner =  $("input.dinner[id^="+this_id+"]").val();
        var cb3 =  $("input.cb3[id^="+this_id+"]").val();

        var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();

        var total = (parseInt(cb1) + parseInt(lunch) + parseInt(cb2) + parseInt(dinner) + parseInt(cb3)) * pax;

        $("input.totalfnbbreak[id^="+this_id+"]").val(total);

        var totalfb = 0;
        //strNumber = strNumber.replace(/[\D\s]/g, '');
        $("input.totalfnbbreak").each(function(){
            totalfb += parseInt($(this).val());
        });

        var totalroom = 0;
        $("input.revenueroombreakdown").each(function(){
            totalroom += parseInt($(this).val().replace(/[\D\s]/g, ''));
        });

        $('input#grandtotalfnbbreak').val( totalfb);
        $('input#fnbnroom').val(totalroom + totalfb);

    })

    $(".cb3cbox").change(function(){
        var this_id = $(this).attr("id");
        //alert(this_id);
        if(!$(this).is(":checked")){
            $("input.cb3[id^="+this_id+"]").val("0");
        }

        var cb1 =  $("input.cb1[id^="+this_id+"]").val();
        var lunch =  $("input.lunch[id^="+this_id+"]").val();
        var cb2 =  $("input.cb2[id^="+this_id+"]").val();
        var dinner =  $("input.dinner[id^="+this_id+"]").val();
        var cb3 =  $("input.cb3[id^="+this_id+"]").val();

        var pax = $("input.paxfnbbreak[id^="+this_id+"]").val();

        var total = (parseInt(cb1) + parseInt(lunch) + parseInt(cb2) + parseInt(dinner) + parseInt(cb3)) * pax;

        $("input.totalfnbbreak[id^="+this_id+"]").val(total);

        var totalfb = 0;
        //strNumber = strNumber.replace(/[\D\s]/g, '');
        $("input.totalfnbbreak").each(function(){
            totalfb += parseInt($(this).val());
        });

        var totalroom = 0;
        $("input.revenueroombreakdown").each(function(){
            totalroom += parseInt($(this).val().replace(/[\D\s]/g, ''));
        });

        $('input#grandtotalfnbbreak').val( totalfb);
        $('input#fnbnroom').val(totalroom + totalfb);

    })

    $("input#reset").click(function(){
        //alert('asdas');
        $("#account").val('');
        $("#idaccount").val('');

        $("#contactperson").html('');
        $("input#event_name").val('');
        $("select#eventtype").val('--Choose--');
        $("select#layout_letter").val('--Choose--');
        $("select#venue_letter").val('--Choose--');
        $("#source").val("--Choose--");
        $("#sales").val("--Choose--");

        return false;
    })



    $("select.roomstruc").change(function(){
        var this_id = $(this).attr("id");
        //alert(this_id);
        var property = $("select#editproperty").val();
        var room = $("select.roomtype[id^="+this_id+"]").val();
        var week = $("select.weektype[id^="+this_id+"]").val();
        var bedtype = $("select.bedtype[id^="+this_id+"]").val();
        var roomstruct = $(this).val();
        //    alert("prop"+property);
        //    alert("rm"+room);
        //    alert("wk"+week);
        //    alert("bt"+bedtype);
        //    alert("rrs"+roomstruct);

    
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_roomstrucrate_price",
            cache: false,
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
            
                var grandtotal = 0;

                $("input.revenueroom").each(function(){

                    grandtotal += parseInt($(this).val());
                });

                $("input#totalroomrevenue").val(grandtotal);
           
            },
            beforeSend: function(){

            }
        });
    })


    $('select.meetingstrucnew').live('change', function() {
        var divid = $(this).parent("div").attr('id');
        var this_id = divid.slice(11);

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
            cache: false,
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


    $(".checkinrental").change(function() {
        var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(5));
        var val = $(this).val();

        $(this).val(val);

        var cin = $(this).val();
        var cout = $(".checkoutrental[id^="+"corr-"+numberid+"]").val();

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
            alert('Error, Check Date');
            $("input.dayrental[id^="+numberid+"]").val(0);
        }else{
            
            if(isNaN(jml_hari)){
                $("input.dayrental[id^="+numberid+"]").val(0);
            }else{
                $("input.dayrental[id^="+numberid+"]").val(jml_hari+1);



                var day = $("input.dayrental[id^="+numberid+"]").val();
                var harga = $("input.hargarental[id^="+numberid+"]").val();
                var pax = $("input.paxrental[id^="+numberid+"]").val();

                var total = parseInt(day) * parseInt(harga);// * parseInt(pax);
                if(isNaN(total)){
                    $("input.totalrental[id^="+numberid+"]").val("");
                }else{
                    $("input.totalrental[id^="+numberid+"]").val(total);
                }
            }
               
        }
    });

    $(".checkoutrental").change(function() {
        var this_id = $(this).attr('id');
        var numberid = parseInt(this_id.slice(5));

        var cin = $(".checkinrental[id^="+"cirr-"+numberid+"]").val();
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
            $("input.dayrental[id^="+numberid+"]").val(0);
        }else{
            if(isNaN(jml_hari)){
                $("input.dayrental[id^="+numberid+"]").val(0);
            }else{
                $("input.dayrental[id^="+numberid+"]").val(jml_hari+1);




                var day = $("input.dayrental[id^="+numberid+"]").val();
                var harga = $("input.hargarental[id^="+numberid+"]").val();
                var pax = $("input.paxrental[id^="+numberid+"]").val();

                var total = parseInt(day) * parseInt(harga);// * parseInt(pax);
                if(isNaN(total)){
                    $("input.totalrental[id^="+numberid+"]").val("");
                }else{
                    $("input.totalrental[id^="+numberid+"]").val(total);
                }

            }
        }//End IF
    });



    $("select.strucrental").change(function(){
        var this_id = $(this).attr('id');
        var idrefroom = $(this).val();
    
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_roomrental_detil",
            cache: false,
            data:({
                idrefroom:idrefroom
            }),
            dataType:"html",
            success: function(data){
                //   alert(data);
                $("input.hargarental[id^="+this_id+"]").val(data);
                var day = $("input.dayrental[id^="+this_id+"]").val();
                var harga = $("input.hargarental[id^="+this_id+"]").val();
                var pax = $("input.paxrental[id^="+this_id+"]").val();

                var total = parseInt(day) * parseInt(harga);// * parseInt(pax);
                if(isNaN(total)){
                    $("input.totalrental[id^="+this_id+"]").val("");
                }else{
                    $("input.totalrental[id^="+this_id+"]").val(total);
                }
             

            },
            beforeSend: function(){

            }
        })

    });


    $("input.paxrental").keyup(function(){
        var this_id = $(this).attr('id');
        var day = $("input.dayrental[id^="+this_id+"]").val();
        var harga = $("input.hargarental[id^="+this_id+"]").val();
        var pax = $("input.paxrental[id^="+this_id+"]").val();

        var total = parseInt(day) * parseInt(harga);// * parseInt(pax);
        if(isNaN(total)){
            $("input.totalrental[id^="+this_id+"]").val("");
        }else{
            $("input.totalrental[id^="+this_id+"]").val(total);
        }
    });
    

    
    //$("select#cancelreason").change(function(){
    $("select#cancelreason").live('change',function(){
        var this_val = $(this).val();
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_hotel_competitor",
            cache: false,
            data:({
                cancelreason:this_val
            }),
            dataType:"html",
            success: function(data){
                $("div#containerhotelcompetitor").html(data);
            },
            beforeSend: function(){
                $("div#containerhotelcompetitor").html('Loading...');
            }
        })

    })

    $("select#cancelreasonnew").live('change',function(){
        var this_val = $(this).val();
        $.ajax({
            type:"POST",
            url: site_url+"offering_letter/get_hotel_competitor",
            cache: false,
            data:({
                cancelreason:this_val
            }),
            dataType:"html",
            success: function(data){
                $("div#containerhotelcompetitornew").html(data);
            },
            beforeSend: function(){
                $("div#containerhotelcompetitornew").html('Loading...');
            }
        })
    })


   
});//end document ready

