/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

     $("#number").autocomplete(site_url+"confirmation_letter/get_definit_letter", {
        width: 198,
        selectFirst: false
    });

    $('input#number').flushCache();
    $("#number").result(function(event, data, formatted) {
        if (data){
            $.ajax({
                type:"POST",
                url: site_url+"confirmation_letter/get_definitletter_detil",
                data:({
                    confirmnumber:data[1]
                }),
                cache: false,
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

    $("input#btn_update").live('click',function(){
         var confnumber = $("#number").val();
         var status = $("select#status").val();
         if(confirm("Are you sure?")){
         $.ajax({
                type:"POST",
                url: site_url+"confirmation_letter/update_status_definit_letter",
                cache: false,
                data:({
                    confirmnumber:confnumber,
                    status:status
                }),
                dataType:"html",
                success: function(data){
                    $('#containerdata').html(data);
                },
                beforeSend: function(){
                    $('#containerdata').html('');
                }
            });
         }
    })
})

