/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {

    $("#startdate").datepicker({dateFormat:'dd-mm-yy'});
    $("#enddate").datepicker({dateFormat:'dd-mm-yy'});

    $("input#btnGo").click(function(){
        var startdate = $("input#startdate").val();
       // var enddate = $("input#enddate").val();
        var property = $("select#propertyvenue").val();
        var venue = $("select#venue").val();
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_calendarvenue_by_filter",
            cache: false,
            data:({startdate:startdate,
                  // enddate:enddate,
                   property:property,
                   venue:venue}),
            datatype:"html",
            success: function(data){
                $("#containerdatavenue").html(data);
            },
            beforeSend: function(){
                $("#containerdatavenue").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
    })


    $("select#propertyvenue").change(function(){
        $.ajax({
            type:"POST",
            url: site_url+"calendar/get_venue_by_property",
            cache: false,
            data:({
                property:$(this).val()
            }),
            datatype:"html",
            success: function(data){
                $("#containeroptvenue").html(data);
            },
            beforeSend: function(){
                $("#containeroptvenue").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
    })
})
