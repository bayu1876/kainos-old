/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $("#number").autocomplete(site_url+"confirmation_letter/get_breakdown_confirmation", {
        width: 198,
        selectFirst: false
    });

    $('input#number').flushCache();
    $("#number").result(function(event, data, formatted) {
        if (data){
            $.ajax({
                type:"POST",
                url: site_url+"confirmation_letter/get_breakdown_confirmation_detail",
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
    
    
    $("#btnreset").live('click',function(){
        $("#number").val('');
        $("#containerdata").html('');
        return false;
    })

});//END DOCUMENT READY