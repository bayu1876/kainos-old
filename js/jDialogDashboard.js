/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $("#dialog_detail_confirm").dialog({
        autoOpen:false,
        modal:false,
        draggable:true,
        resizable:true,
        height:660,
        width:850,
        zIndex:-100000
    })

//    $('.accountconfirm').live("click",function(){
//        var lastnumber = $(this).attr('id');
//        $("#containerdatacl").html(lastnumber);
//
//        $("#dialog_detail_confirm").dialog( 'open');
//        return false;
//    })

    $(".accountconfirm").live('click',function(){
                var lastnumber = $(this).attr('id');
                var w = 880;
                var h = screen.height;
                var left = (screen.width/2)-(w/2);
                var top = (screen.height/2)-(h/2);
                //window.open(path+"barcodeprint.php?bar="+barcode,
                window.open(site_url+"welcome/detail_confirm_business/"+lastnumber,
                "_blank",
                "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=yes, width="+w+", height="+h+",top="+(top-100)+", left="+left+" ");
                return false;
            })



             $(".accountoffering").live('click',function(){
                var lastnumber = $(this).attr('id');
                var w = 880;
                var h = screen.height;
                var left = (screen.width/2)-(w/2);
                var top = (screen.height/2)-(h/2);
                //window.open(path+"barcodeprint.php?bar="+barcode,
                window.open(site_url+"welcome/detail_offering/"+lastnumber,
                "_blank",
                "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=yes, width="+w+", height="+h+",top="+(top-100)+", left="+left+" ");
                return false;
            })

})