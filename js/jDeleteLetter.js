/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    $("#number").autocomplete(site_url+"delete_offering_letter/get_offering", {
        width: 198,
        selectFirst: false
    });

    $('input#number').flushCache();
    $("#number").result(function(event, data, formatted) {
        if (data){
            $.ajax({
                type:"POST",
                url: site_url+"delete_offering_letter/get_detiloffering",
                data:({
                    offeringnumber:data[1]
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
         var offnumber = $("#offeringnumber").val();
         if(confirm("Are you sure?")){
         $.ajax({
                type:"POST",
                url: site_url+"delete_offering_letter/delete_offering",
                data:({
                    offeringnumber:offnumber
                }),
                dataType:"html",
                success: function(data){
                    $('#containerdata').html("Offering Letter No."+data+" has been deleted!");
                },
                beforeSend: function(){
                    $('#containerdata').html('');
                }
            });
         }
    })
});

