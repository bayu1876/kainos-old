/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    $("#number").autocomplete({
        minLength: 0,
        source:function(req,add){
            $.ajax({
                url: site_url+ "change_contact/search_OL" ,
                dataType: 'json',
                type:'POST',
                data:req,
                success:function(data){
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
            var number = ui.item.value;
            
            $.ajax({
                url: site_url+ "change_contact/get_detail_OL" ,
                dataType: 'html',
                type:'POST',
                data:({number:number}),
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
            $(this).val(number);
            return false;
        }
    })

    $("#company").live('focus',function(){$(this).autocomplete({
        minLength: 2,
        source:function(req,add){
            $.ajax({
                url: site_url+ "change_contact/search_company" ,
                dataType: 'json',
                type:'POST',
                data:req,
                success:function(data){
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
            var companyid = ui.item.value;
            $.ajax({
                url: site_url+ "change_contact/get_contacts_by_company" ,
                dataType: 'html',
                type:'POST',
                data:({companyid:companyid}),
                success:function(data){
                    $("#containerdatacontact").html(data);
                } ,
                beforeSend: function(){
                    $('#containerdatacontact').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                },
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
            $(this).val( ui.item.label);
            return false;
        }
    })});

    function split( val ) {
        return val.split( /,\s*/ );
    }

    function extractLast( term ) {
        return split( term ).pop();
    }

    var idcontact;
    $(".contactpersonletter").live('change',function(){
            idcontact = ($(this).val())
        }
    )

    $("#btnchangecontact").live('click',function(){
        var ol = $("#number").val();
        

        $.ajax({
                url: site_url+ "change_contact/submit_contact_OL" ,
                dataType: 'html',
                type:'POST',
                data:({idcontact:idcontact,olnumber:ol}),
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
        return false;
    })

     $("#btnreset").live('click',function(){
        $("#number").val('');
          $("#containerdata").html('');
        return false;
    })
})