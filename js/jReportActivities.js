/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    $("#histstartdate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#histenddate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("select#bysales").live("change",function(){
       // var sales = $("select#sales").val();
        var telemarketing = $("input#telemarketing").attr('checked');
        var salesgroup = $("select#bysalesgroup").val();
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $("input#task").attr('checked');
        var salescallplanning = $("input#salescallplanning").attr('checked');
        var salescallresult = $("input#salescallresult").attr('checked');
        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:$(this).val(),
                salesgroup:salesgroup,
                startdate:$("input#histstartdate").val(),
                enddate:$("input#histenddate").val(),
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult
            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('Loading...');
            }
        });
    });



    $("select#bysalesgroup").change(function(){
       // var sales = $("select#sales").val();
        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $("input#task").attr('checked');
        var salescallplanning = $("input#salescallplanning").attr('checked');
        var salescallresult = $("input#salescallresult").attr('checked');

        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:$("select#bysales").val(),
                salesgroup:$(this).val(),
                startdate:$("input#histstartdate").val(),
                enddate:$("input#histenddate").val(),
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult

            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_salesbygroup",
            data:({
                salesgroup:$(this).val()
            }),
            dataType:"html",
            success: function(data){
                $('#divsalesbygroup').html(data);
            },
            beforeSend: function(){
                $('#divsalesbygroup').html('Loading...');
            }
        });
    });

    $("input#histstartdate").change(function(){
         
        var sales = $("select#bysales").val();
        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $("input#task").attr('checked');
        var salescallplanning = $("input#salescallplanning").attr('checked');
        var salescallresult = $("input#salescallresult").attr('checked');
        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                startdate:$(this).val(),
                enddate:$("input#histenddate").val(),
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult
            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#histenddate").change(function(){
        var sales = $("select#bysales").val();
        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');;
        var otheract = $("input#otheract").attr('checked');
        var task = $("input#task").attr('checked');
        var salescallplanning = $("input#salescallplanning").attr('checked');
        var salescallresult = $("input#salescallresult").attr('checked');

        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                enddate:$(this).val(),
                startdate:$("input#histstartdate").val(),
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult
            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });


    $("input#telemarketing").change(function(){
        var isChecked = $(this).attr('checked');
        var sales = $("select#bysales").val();

        var salesgroup = $("select#bysalesgroup").val();

        var startdate = $("input#histstartdate").val();
        var enddate = $("input#histenddate").val();
        var telemarketing = $(this).attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $("input#task").attr('checked');
        var salescallplanning = $("input#salescallplanning").attr('checked');
         var salescallresult = $("input#salescallresult").attr('checked');
        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                salesgroup:salesgroup,
                enddate:enddate,
                startdate:startdate,
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult
            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });


    $("input#salescallplanning").change(function(){
        var isChecked = $(this).attr('checked');
        var sales = $("select#bysales").val();

        var salesgroup = $("select#bysalesgroup").val();

        var startdate = $("input#histstartdate").val();
        var enddate = $("input#histenddate").val();
        var salescallplanning = $(this).attr('checked');
        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $("input#task").attr('checked');
        var salescallresult = $("input#salescallresult").attr('checked');

        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                salesgroup:salesgroup,
                enddate:enddate,
                startdate:startdate,
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult
            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });

    $("input#lastminutecall").change(function(){
        var isChecked = $(this).attr('checked');
        var sales = $("select#bysales").val();
        var salesgroup = $("select#bysalesgroup").val();
        var startdate = $("input#histstartdate").val();
        var enddate = $("input#histenddate").val();

        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $(this).attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $("input#task").attr('checked');
        var salescallplanning = $("input#salescallplanning").attr('checked');
        var salescallresult = $("input#salescallresult").attr('checked');


        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                salesgroup:salesgroup,
                enddate:enddate,
                startdate:startdate,
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult
            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });

    });

    $("input#entertainment").change(function(){
        var isChecked = $(this).attr('checked');
        var sales = $("select#bysales").val();
         var salesgroup = $("select#bysalesgroup").val();
        var startdate = $("input#histstartdate").val();
        var enddate = $("input#histenddate").val();
        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $(this).attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $("input#task").attr('checked');
         var salescallplanning = $("input#salescallplanning").attr('checked');
         var salescallresult = $("input#salescallresult").attr('checked');


        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                salesgroup:salesgroup,
                enddate:enddate,
                startdate:startdate,
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult

            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });

    $("input#otheract").change(function(){
        var isChecked = $(this).attr('checked');
        var sales = $("select#bysales").val();
         var salesgroup = $("select#bysalesgroup").val();
        var startdate = $("input#histstartdate").val();
        var enddate = $("input#histenddate").val();

        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $(this).attr('checked');
        var task = $("input#task").attr('checked');
         var salescallplanning = $("input#salescallplanning").attr('checked');
         var salescallresult = $("input#salescallresult").attr('checked');

        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                salesgroup:salesgroup,
                enddate:enddate,
                startdate:startdate,
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult

            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });

    $("input#task").change(function(){
        var isChecked = $(this).attr('checked');
        var sales= $("select#bysales").val();
         var salesgroup = $("select#bysalesgroup").val();
        var startdate = $("input#histstartdate").val();
        var enddate = $("input#histenddate").val();

        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $(this).attr('checked');
        var salescallplanning = $("input#salescallplanning").attr('checked');
        var salescallresult = $("input#salescallresult").attr('checked');

        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                salesgroup:salesgroup,
                enddate:enddate,
                startdate:startdate,
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult
            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });


    $("input#salescallresult").change(function(){
        var isChecked = $(this).attr('checked');
        var sales= $("select#bysales").val();
         var salesgroup = $("select#bysalesgroup").val();
        var startdate = $("input#histstartdate").val();
        var enddate = $("input#histenddate").val();

        var telemarketing = $("input#telemarketing").attr('checked');
        var lastminutecall = $("input#lastminutecall").attr('checked');
        var entertainment = $("input#entertainment").attr('checked');
        var otheract = $("input#otheract").attr('checked');
        var task = $(this).attr('checked');
        var salescallplanning = $("input#salescallplanning").attr('checked');
        var salescallresult = $("input#salescallresult").attr('checked');

        $.ajax({
            type:"POST",
            url: site_url+"report_activities/get_report_bydetil",
            data:({
                sales:sales,
                salesgroup:salesgroup,
                enddate:enddate,
                startdate:startdate,
                telemarketing:telemarketing,
                lastminutecall:lastminutecall,
                entertainment:entertainment,
                otheract:otheract,
                task:task,
                salescallplanning:salescallplanning,
                salescallresult:salescallresult
            }),
            dataType:"html",
            success: function(data){
                $('#datareportactivities').html(data);
            },
            beforeSend: function(){
                $('#datareportactivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });


});