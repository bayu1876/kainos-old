/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
 //$("#myTable").tablesorter( {sortList: [[0,0], [1,0]]} );
$("#startdate").datepicker({dateFormat:'dd-mm-yy'});
$("#enddate").datepicker({dateFormat:'dd-mm-yy'});
 
$("input#startdate").change(function(){
    //alert($("input#enddate").val());
      var confirm = $("input#confirm").attr('checked');
      var tentativ = $("input#tentative").attr('checked');
      var cancel = $("input#cancel").attr('checked');
      var salesgroup = $("select#salesgroup").val();
    $.ajax({
            type:"POST",
            //url: site_url+"report/get_report_by_date",
            url: site_url+"report/get_report_bydetil",
            data:({startdate:$(this).val(),
                   enddate:$("input#enddate").val(),
                   property:$('select#property').val(),
                   sales:$('select#sales').val(),
                   salesgroup:salesgroup,
                confirm:confirm,
                    tentativ:tentativ,
                    cancel:cancel}),
            dataType:"html",
            success: function(data){
                $('#containersummary').html(data);
            },
            beforeSend: function(){
                $('#containersummary').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
})

$("input#enddate").change(function(){
    //alert($("input#enddate").val());
      var confirm = $("input#confirm").attr('checked');
        var tentativ = $("input#tentative").attr('checked');
        var cancel = $("input#cancel").attr('checked');
        var salesgroup = $("select#salesgroup").val();
    $.ajax({
            type:"POST",
           // url: site_url+"report/get_report_by_date",
            url: site_url+"report/get_report_bydetil",
            data:({enddate:$(this).val(),
                   startdate:$("input#startdate").val(),
                   property:$('select#property').val(),
                   sales:$("select#sales").val(),
                   salesgroup:salesgroup,
                   confirm:confirm,
                    tentativ:tentativ,
                    cancel:cancel}),
            dataType:"html",
            success: function(data){
                $('#containersummary').html(data);
            },
            beforeSend: function(){
                $('#containersummary').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});

$("select#property").change(function(){
    var confirm = $("input#confirm").attr('checked');
        var tentativ = $("input#tentative").attr('checked');
        var cancel = $("input#cancel").attr('checked');
        var salesgroup = $("select#salesgroup").val();
     $.ajax({
            type:"POST",
             // url: site_url+"report/get_report_by_property",
             // url: site_url+"report/get_report_by_date",
            url: site_url+"report/get_report_bydetil",
            data:({enddate:$("input#enddate").val(),
                   startdate:$("input#startdate").val(),
                   property:$(this).val(),
                   sales:$("select#sales").val(),
                   salesgroup:salesgroup,
                    confirm:confirm,
                    tentativ:tentativ,
                    cancel:cancel}),
            dataType:"html",
            success: function(data){
                $('#containersummary').html(data);
            },
            beforeSend: function(){
                $('#containersummary').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});

$("select#sales").live("change",function(){
    var confirm = $("input#confirm").attr('checked');
        var tentativ = $("input#tentative").attr('checked');
        var cancel = $("input#cancel").attr('checked');
        var salesgroup = $("select#salesgroup").val();
     $.ajax({
            type:"POST",
              //url: site_url+"report/get_report_by_property",
              //url: site_url+"report/get_report_by_date",
             url: site_url+"report/get_report_bydetil",
             data:({enddate:$("input#enddate").val(),
                    startdate:$("input#startdate").val(),
                    property:$("select#property").val(),
                    sales:$(this).val(),
                    salesgroup:salesgroup,
                    confirm:confirm,
                    tentativ:tentativ,
                    cancel:cancel
                    }),
            dataType:"html",
            success: function(data){
                $('#containersummary').html(data);
            },
            beforeSend: function(){
                $('#containersummary').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});

$("select#salesgroup").change(function(){
     $.ajax({
            type:"POST",
             url: site_url+"report/get_salesbygroup",
             data:({salesgroup:$(this).val()
                    }),
            dataType:"html",
            success: function(data){
                $('#containersalesbygroup').html(data);
            },
            beforeSend: function(){
                $('#containersalesbygroup').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });

       
        var sales = $("select#sales").val();
        var confirm = $("input#confirm").attr('checked');
        var tentativ = $("input#tentative").attr('checked');
        var cancel = $("input#cancel").attr('checked');
        
        $.ajax({
            type:"POST",
             url: site_url+"report/get_report_bydetil",
             data:({enddate:$("input#enddate").val(),
                    startdate:$("input#startdate").val(),
                    property:$("select#property").val(),
                    sales:sales,
                    salesgroup:$(this).val(),
                    confirm:confirm,
                    tentativ:tentativ,
                    cancel:cancel
                    }),
            dataType:"html",
            success: function(data){
                $('#containersummary').html(data);
            },
            beforeSend: function(){
                $('#containersummary').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });

        return false;
});

$('select#month_salesbysegment').change(function(){
     var year = $('select#year_salesbysegment').val();
     var group = $("select#group_salesbysegment").val();
     $.ajax({
            type:"POST",
            //url: site_url+"report/get_SBSS",
            url: site_url+"report/get_SBSS_new",
            data:({month:$(this).val(),year:year,group:group}),
            dataType:"html",
            success: function(data){
                $('#containerstatsalesbysegment').html(data);
            },
            beforeSend: function(){
                $('#containerstatsalesbysegment').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});


$('select#year_salesbysegment').change(function(){
    // alert($(this).val());
     var month = $('select#month_salesbysegment').val();
     var group = $("select#group_salesbysegment").val();
     $.ajax({
            type:"POST",
            //url: site_url+"report/get_SBSS",
            url: site_url+"report/get_SBSS_new",
            data:({month:month,year:$(this).val(),group:group}),
            dataType:"html",
            success: function(data){
                $('#containerstatsalesbysegment').html(data);
            },
            beforeSend: function(){
                $('#containerstatsalesbysegment').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});


$('select#group_salesbysegment').change(function(){
     var year = $('select#year_salesbysegment').val();
     var month = $('select#month_salesbysegment').val();
     $.ajax({
            type:"POST",
            url: site_url+"report/get_SBSS_new",
            data:({month:month,year:year,group:$(this).val()}),
            dataType:"html",
            success: function(data){
                $('#containerstatsalesbysegment').html(data);
            },
            beforeSend: function(){
                $('#containerstatsalesbysegment').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});


$('select#monthsalesperson').change(function(){
    // alert($(this).val());
     var year = $('select#yearsalesperson').val();
     $.ajax({
            type:"POST",
            url: site_url+"report/get_SBSP",
            data:({month:$(this).val(),year:year}),
            dataType:"html",
            success: function(data){
                $('#containerdata').html(data);
            },
            beforeSend: function(){
                $('#containerdata').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});


$('select#yearsalesperson').change(function(){
    // alert($(this).val());
     var month = $('select#monthsalesperson').val();
     $.ajax({
            type:"POST",
            url: site_url+"report/get_SBSP",
            data:({month:month,year:$(this).val()}),
            dataType:"html",
            success: function(data){
                $('#containerdata').html(data);
            },
            beforeSend: function(){
                $('#containerdata').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});


$('select#monthcompany').change(function(){
    // alert($(this).val());
     var year = $('select#yearcompany').val();
     $.ajax({
            type:"POST",
            url: site_url+"report/get_SBCC",
            data:({month:$(this).val(),year:year}),
            dataType:"html",
            success: function(data){
                $('#containerdata').html(data);
            },
            beforeSend: function(){
                $('#containerdata').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});


$('select#yearcompany').change(function(){
    // alert($(this).val());
     var month = $('select#monthcompany').val();
     $.ajax({
            type:"POST",
            url: site_url+"report/get_SBCC",
            data:({month:month,year:$(this).val()}),
            dataType:"html",
            success: function(data){
                $('#containerdata').html(data);
            },
            beforeSend: function(){
                $('#containerdata').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});

$('select#monthhotel').change(function(){
     //alert($(this).val());
     var year = $('select#yearhotel').val();
     $.ajax({
            type:"POST",
            url: site_url+"report/get_SBHotel",
            data:({month:$(this).val(),year:year}),
            dataType:"html",
            success: function(data){
                $('#containerdata').html(data);
            },
            beforeSend: function(){
                $('#containerdata').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});


$('select#yearhotel').change(function(){
    // alert($(this).val());
     var month = $('select#monthhotel').val();
     $.ajax({
            type:"POST",
            url: site_url+"report/get_SBHotel",
            data:({month:month,year:$(this).val()}),
            dataType:"html",
            success: function(data){
                $('#containerdata').html(data);
            },
            beforeSend: function(){
                $('#containerdata').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
});


$("input#confirm").change(function(){
       
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
        var property = $("select#property").val();
        var sales = $("select#sales").val();
        var salesgroup = $("select#salesgroup").val();
        var confirm = $("input#confirm").attr('checked');
        var tentativ = $("input#tentative").attr('checked');
        var cancel = $("input#cancel").attr('checked');
        $.ajax({
            type:"POST",
            url: site_url+"report/get_report_bydetil",
            data:({startdate:startdate,
                   enddate:enddate,
                   property:property,
                   sales:sales,
                   salesgroup:salesgroup,
                   confirm:confirm,
                   tentativ:tentativ,
                   cancel:cancel}),
            dataType:"html",
            success: function(data){
                $('#containersummary').html(data);
            },
            beforeSend: function(){
                $('#containersummary').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
    });

    $("input#tentative").change(function(){
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
        var property = $("select#property").val();
        var sales = $("select#sales").val();
        var salesgroup = $("select#salesgroup").val();
        var confirm = $("input#confirm").attr('checked');
        var tentativ = $("input#tentative").attr('checked');
        var cancel = $("input#cancel").attr('checked');
        $.ajax({
            type:"POST",
            url: site_url+"report/get_report_bydetil",
            data:({startdate:startdate,
                   enddate:enddate,
                   property:property,
                   sales:sales,
                   salesgroup:salesgroup,
                   confirm:confirm,
                   tentativ:tentativ,
                   cancel:cancel}),
            dataType:"html",
            success: function(data){
                $('#containersummary').html(data);
            },
            beforeSend: function(){
                $('#containersummary').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
    });

    $("input#cancel").change(function(){
        var startdate = $("input#startdate").val();
        var enddate = $("input#enddate").val();
        var property = $("select#property").val();
        var sales = $("select#sales").val();
        var salesgroup = $("select#salesgroup").val();
        var confirm = $("input#confirm").attr('checked');
        var tentativ = $("input#tentative").attr('checked');
        var cancel = $("input#cancel").attr('checked');
        $("#containerhotel").html('');
        if(cancel == true){
            $("select#cancelstatus").attr('disabled', '');
            $("select#cancelreason").attr('disabled', '');

        }else{
            $("select#cancelstatus").attr('disabled', 'disabled');
            $("select#cancelreason").attr('disabled', 'disabled');
        }
        $.ajax({
            type:"POST",
            url: site_url+"report/get_report_bydetil",
            data:({startdate:startdate,
                   enddate:enddate,
                   property:property,
                   sales:sales,
                   salesgroup:salesgroup,
                   confirm:confirm,
                   tentativ:tentativ,
                   cancel:cancel}),
            dataType:"html",
            success: function(data){
                $('#containersummary').html(data);
            },
            beforeSend: function(){
                $('#containersummary').html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        });
    });



 $("select#cancelstatus").change(function(){
     var val = $(this).val();
     $("#containerhotel").html('');
     $.ajax({
            type:"POST",
            url: site_url+"report/get_cancelreason",
            cache: false,
            data:({
                cancelstatus:val
            }),
            dataType:"html",
            success: function(data){
               $("#containerreason").html(data);
            },
            beforeSend: function(){
                 $("#containerreason").html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        })
 })

 $("select#cancelreason").live('change',function(){
    var this_val = $(this).val();
    if(this_val == 2)
    {
        $.ajax({
            type:"POST",
            url: site_url+"report/get_hotelcompetitor",
            cache: false,
            data:({
                cancelreason:this_val
            }),
            dataType:"html",
            success: function(data){
               $("#containerhotel").html(data);
            },
            beforeSend: function(){
                 $("#containerhotel").html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
            }
        })
    }else{
         $("#containerhotel").html('<img src="'+base_url+'images/WebResource.axd.gif" align="absmiddle"><br/>Loading...');
    }
    //$('#containersummary').html(this_val);
 })

});