/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {


    $("select#month").change(function(){
        var month = $(this).val();
        var year = $("select#year").val();
        var idsales = $("input:hidden#idsales").val();
        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_telemarketing",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containertelemarketing").html(data);
            },
            beforeSend: function(){
                $("div#containertelemarketing").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_lastminutescall",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerlastminutescall").html(data);
            },
            beforeSend: function(){
                $("div#containerlastminutescall").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_salescallplanning",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containersalescallplanning").html(data);
            },
            beforeSend: function(){
                $("div#containersalescallplanning").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_entertainment",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerentertainment").html(data);
            },
            beforeSend: function(){
                $("div#containerentertainment").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });


         $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_otheractivities",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerotheractivities").html(data);
            },
            beforeSend: function(){
                $("div#containerotheractivities").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_task",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containertask").html(data);
            },
            beforeSend: function(){
                $("div#containertask").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });


         $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_complimentary",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containercomplimentary").html(data);
            },
            beforeSend: function(){
                $("div#containercomplimentary").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_offering",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containeroffering").html(data);
            },
            beforeSend: function(){
                $("div#containeroffering").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });


        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_confirm",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerconfirmdef").html(data);
            },
            beforeSend: function(){
                $("div#containerconfirmdef").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_offcancel",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerofferingcancel").html(data);
            },
            beforeSend: function(){
                $("div#containerofferingcancel").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });


        
    })




    $("select#year").change(function(){
        var month = $("select#year").val();
        var year = $(this).val();
         var idsales = $("input:hidden#idsales").val();;
        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_telemarketing",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containertelemarketing").html(data);
            },
            beforeSend: function(){
                $("div#containertelemarketing").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_lastminutescall",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerlastminutescall").html(data);
            },
            beforeSend: function(){
                $("div#containerlastminutescall").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        
        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_salescallplanning",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containersalescallplanning").html(data);
            },
            beforeSend: function(){
                $("div#containersalescallplanning").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_entertainment",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerentertainment").html(data);
            },
            beforeSend: function(){
                $("div#containerentertainment").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

         $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_otheractivities",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerotheractivities").html(data);
            },
            beforeSend: function(){
                $("div#containerotheractivities").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

         $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_task",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containertask").html(data);
            },
            beforeSend: function(){
                $("div#containertask").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_complimentary",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containercomplimentary").html(data);
            },
            beforeSend: function(){
                $("div#containercomplimentary").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_complimentary",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containercomplimentary").html(data);
            },
            beforeSend: function(){
                $("div#containercomplimentary").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });

        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_offering",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containeroffering").html(data);
            },
            beforeSend: function(){
                $("div#containeroffering").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });


        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_confirm",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerconfirmdef").html(data);
            },
            beforeSend: function(){
                $("div#containerconfirmdef").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });


        $.ajax({
            type:"POST",
            url: site_url+"sales/get_report_offcancel",
            data:({month:month,
                   year:year,
                   sales:idsales}),
            cache: true,
            success: function(data){
                $("div#containerofferingcancel").html(data);
            },
            beforeSend: function(){
                $("div#containerofferingcancel").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });




    })



    $("a.upload").click(function(e){
        e.preventDefault();
        var id = this.id;
        $.ajaxFileUpload({
            url:site_url+'/sales/do_upload',
            secureuri:false,
            fileElementId:'filetoupload',
            dataType: 'json',
            success: function (data, status)
            {
                if(typeof(data.error) != 'undefined')
                {
                    if(data.error != '')
                    {
                        $("#photoresult").html(data.error);
                    }else
                    {
                        $("#photoresult").html(data.msg);
                        //$("#idfile").val(data.idfile);
                        $("#filetoupload").val('');
                    }
                }
            },
            error: function (data, status, e)
            {
                $("#photoresult").html(data);
            }
        });
    });


    
});
