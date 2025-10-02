/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {


    $("input#confnumber").autocomplete(site_url+"group_order/get_confirmation",  {
        width: 324,
        selectFirst: false
    });

    $('input#confnumber').flushCache();
    //
    $("input#confnumber").result(function(event, data, formatted) {
         
        if (data){
           // $("input#idcompany").val(data[1]);
            $.ajax({
                type:"POST",
                url: site_url+"group_order/get_grouporder",
                data:({
                    confirmnumber:data[1]
                }),
                dataType:"html",
                success: function(data){
                    $('#containerdata').html(data);
                },
                beforeSend: function(){
                    $('#containerdata').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
        }//end IF
    });
});