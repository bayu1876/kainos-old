/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    $("#number").autocomplete(site_url+"delete_confirm_letter/get_confirm", {
        width: 198,
        selectFirst: false
    });

    $('input#number').flushCache();
    $("#number").result(function(event, data, formatted) {
        if (data){
            $.ajax({
                type:"POST",
                url: site_url+"delete_confirm_letter/get_detilconfirm",
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



    $("input#btn_delete").live('click',function(){
         var confnumber = $("#confirmnumber").val();
         if(confirm("Are you sure?")){
         $.ajax({
                type:"POST",
                url: site_url+"delete_confirm_letter/delete_confirm",
                data:({
                    confirmnumber:confnumber
                }),
                dataType:"html",
                success: function(data){
                    $('#containerdata').html("Confirm Letter No."+data+" has been deleted!");
                },
                beforeSend: function(){
                    $('#containerdata').html('');
                }
            });
         }
    })
});

