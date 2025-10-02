/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $("a#prevdategf").live('click',function(event){
     
        event.preventDefault();
        var range = $("#rangegf").val();
        var lastdate = $("#lastdategf").val();
         
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitygf_prev",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomgolden").html(data);
            },
            beforeSend: function(){
            //$("#containerdataroomgolden").html('<img style="text-align="center" src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    $("a#nextdategf").live('click',function(event){
        var range = $("#rangegf").val();
        var lastdate = $("#lastdategf").val();
        event.preventDefault();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitygf_next",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomgolden").html(data);
            },
            beforeSend: function(){
            //$("#containerdataroomgolden").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })


    $("a#prevdatesi").live('click',function(event){

        event.preventDefault();
        var range = $("#rangesi").val();
        var lastdate = $("#lastdatesi").val();

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitysi_prev",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomseriti").html(data);
            },
            beforeSend: function(){
            //$("#containerdataroomgolden").html('<img style="text-align="center" src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    $("a#nextdatesi").live('click',function(event){
        var range = $("#rangesi").val();
        var lastdate = $("#lastdatesi").val();
        event.preventDefault();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitysi_next",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomseriti").html(data);
            },
            beforeSend: function(){
            //$("#containerdataroomgolden").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })


    $("a#prevdatese").live('click',function(event){

        event.preventDefault();
        var range = $("#rangese").val();
        var lastdate = $("#lastdatese").val();

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilityse_prev",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomserela").html(data);
            },
            beforeSend: function(){
            //$("#containerdataroomgolden").html('<img style="text-align="center" src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    $("a#nextdatese").live('click',function(event){
        var range = $("#rangese").val();
        var lastdate = $("#lastdatese").val();
        event.preventDefault();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilityse_next",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomserela").html(data);
            },
            beforeSend: function(){
            //$("#containerdataroomgolden").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })


    $("a#prevdatebi").live('click',function(event){
        event.preventDefault();
        var range = $("#rangebi").val();
        var lastdate = $("#lastdatebi").val();

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitybi_prev",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroombanana").html(data);
            },
            beforeSend: function(){
            //$("#containerdataroomgolden").html('<img style="text-align="center" src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    $("a#nextdatebi").live('click',function(event){
        var range = $("#rangebi").val();
        var lastdate = $("#lastdatebi").val();
        event.preventDefault();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitybi_next",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroombanana").html(data);
            },
            beforeSend: function(){
            //$("#containerdataroomgolden").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })



    $("a#prevdatecr").live('click',function(event){
        event.preventDefault();
        var range = $("#rangecr").val();
        var lastdate = $("#lastdatecr").val();

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitycr_prev",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomcarrcadin").html(data);
            },
            beforeSend: function(){
                //$("#containerdataroomgolden").html('<img style="text-align="center" src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    $("a#nextdatecr").live('click',function(event){
        var range = $("#rangecr").val();
        var lastdate = $("#lastdatecr").val();
        event.preventDefault();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitycr_next",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomcarrcadin").html(data);
            },
            beforeSend: function(){
                //$("#containerdataroomgolden").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })



 $("a#prevdatepr").live('click',function(event){
        event.preventDefault();
        var range = $("#rangepr").val();
        var lastdate = $("#lastdatepr").val();

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitypr_prev",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomprimeroyal").html(data);
            },
            beforeSend: function(){
                //$("#containerdataroomgolden").html('<img style="text-align="center" src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    $("a#nextdatepr").live('click',function(event){
        var range = $("#rangepr").val();
        var lastdate = $("#lastdatepr").val();
        event.preventDefault();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilitypr_next",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomprimeroyal").html(data);
            },
            beforeSend: function(){
                //$("#containerdataroomgolden").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })


     $("a#prevdateam").live('click',function(event){
        event.preventDefault();
        var range = $("#rangeam").val();
        var lastdate = $("#lastdateam").val();

        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilityam_prev",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomamaroossa").html(data);
            },
            beforeSend: function(){
                //$("#containerdataroomgolden").html('<img style="text-align="center" src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    $("a#nextdateam").live('click',function(event){
        var range = $("#rangeam").val();
        var lastdate = $("#lastdateam").val();
        event.preventDefault();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_dataroomavailabilityam_next",
            data:({
                range:range,
                lastdate:lastdate
            }),
            cache: false,
            success: function(data){
                $("#containerdataroomamaroossa").html(data);
            },
            beforeSend: function(){
                //$("#containerdataroomgolden").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })
 
})