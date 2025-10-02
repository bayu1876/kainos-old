/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    $("select#monthsalesunit").change(function(){
        var month = $(this).val();
        var year =  $("select#yearsalesunit").val();
        $.ajax({
            type:"POST",
            url: site_url+"report/get_reportsalesunit",
            data: ({month:month,year:year }),
            cache: false,
            success: function(data){
                $("#containerdatasalesunit").html(data);
            },
            beforeSend: function(){
                $("#containerdatasalesunit").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
    })

    $("select#yearsalesunit").change(function(){
        var month =  $("select#monthsalesunit").val();
        var year = $(this).val();
        $.ajax({
            type:"POST",
            url: site_url+"report/get_reportsalesunit",
            data: ({month:month,year:year }),
            cache: false,
            success: function(data){
                $("#containerdatasalesunit").html(data);
            },
            beforeSend: function(){
                $("#containerdatasalesunit").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
    })
    
})

