/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {

    $("#start").datepicker({
        dateFormat:'dd-mm-yy' ,
        onClose: function(dateText, inst) {
            $.ajax({
                type:"POST",
                url: site_url+"package_report/get_package_report_between",
                data:({
                    start:dateText,
                    end:$("#end").val(),
                    status:$('#status').val(),
                    property:$('#property').val()
                }),
                success: function(data){
                    $("#containerreportpackage").html(data);
                },
                beforeSend: function(){
                    $("#containerreportpackage").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
        }

    });


    $("#end").datepicker({
        dateFormat:'dd-mm-yy' ,
        onClose: function(dateText, inst) {
            $.ajax({
                type:"POST",
                url: site_url+"package_report/get_package_report_between",
                data:({
                    start:$("#start").val(),
                    end:dateText,
                    status:$('#status').val(),
                    property:$('#property').val()
                }),
                success: function(data){
                    $("#containerreportpackage").html(data);
                },
                beforeSend: function(){
                    $("#containerreportpackage").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
        }

    });

    $("#status").change(function(){
        $.ajax({
                type:"POST",
                url: site_url+"package_report/get_package_report_between",
                data:({
                    start:$("#start").val(),
                    end:$("#end").val(),
                    status:$(this).val(),
                    property:$('#property').val()
                }),
                success: function(data){
                    $("#containerreportpackage").html(data);
                },
                beforeSend: function(){
                    $("#containerreportpackage").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
    })


    $("#property").change(function(){
        $.ajax({
                type:"POST",
                url: site_url+"package_report/get_package_report_between",
                data:({
                    start:$("#start").val(),
                    end:$("#end").val(),
                    status:$('#status').val(),
                    property:$(this).val()
                }),
                success: function(data){
                    $("#containerreportpackage").html(data);
                },
                beforeSend: function(){
                    $("#containerreportpackage").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
    })

})
