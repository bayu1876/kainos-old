/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
//    $("#number").autocomplete(site_url+"delete_confirm_letter/get_confirm", {
//        width: 198,
//        selectFirst: false
//    });
//
//    $('input#number').flushCache();
//    $("#number").result(function(event, data, formatted) {
//        if (data){
//            $.ajax({
//                type:"POST",
//                url: site_url+"delete_confirm_letter/get_detilconfirm",
//                data:({
//                    confirmnumber:data[1]
//                }),
//                dataType:"html",
//                success: function(data){
//                    $('#containerdata').html(data);
//                },
//                beforeSend: function(){
//                    $('#containerdata').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
//                }
//            });
//        }//end IF
//    });
//

   
    $("#number").autocomplete({
        minLength: 0,
        source:function(req,add){
            $.ajax({
                url: site_url+ "delete_contract/search_contract" ,
                dataType: 'json',
                type:'POST',
                data:req,
                success:function(data){
                    $("#processing").html('');
                    add( $.ui.autocomplete.filter(
                    data.message, extractLast( req.term ) ) );
                    term: extractLast( req.term )
                } ,
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
            var ratenumber = ui.item.value;
            $.ajax({
                url: site_url+ "delete_contract/get_detail_contract" ,
                dataType: 'html',
                type:'POST',
                data:({ratenumber:ratenumber}),
                success:function(data){
                    $("#containerdata").html(data);
                } ,
                beforeSend: function(){
                    $('#containerdata').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                },
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
            $(this).val(ratenumber);
            return false;
        }
    })

    function split( val ) {
        return val.split( /,\s*/ );
    }

    function extractLast( term ) {
        return split( term ).pop();
    }



    $("input#btn_delete").live('click',function(){
         var contractnumber = $("#number").val();
         if(confirm("Are you sure?")){
         $.ajax({
                type:"POST",
                url: site_url+"delete_contract/submit_delete_contract",
                data:({
                    number:contractnumber
                }),
                dataType:"html",
                success: function(data){
                    $('#containerdata').html("Contract No."+contractnumber+" has been deleted!");
                },
                beforeSend: function(){
                    $('#containerdata').html('Deleting..');
                }
            });
         }
    })


    $("input#btnreset").live('click',function(){
        $("#number").val('');
        $('#containerdata').html('');
        return false;
    })
});

