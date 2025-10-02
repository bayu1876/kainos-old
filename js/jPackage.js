/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 $(document).ready(function() {

    $("form#form_editpackage").validationEngine();
     $("form#form_editpackage").submit(function() {
        if($("form#form_editpackage").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"package/update_package",
             // cache: true,
              data:$('#form_editpackage').serialize(),
              dataType:"html",
              success: function(data){
              
                $("#processing").html('Data has been updated.');
                $("#property").val('-- Choose --');
                $("#strucrate").val('-- Choose --');
                $("#packageref").val('-- Choose --');
                $("#event_type").val('-- Choose --');
                $("#priceperpax").val('');
                $("#totalpax").val('');
                $("#addprice").val('');
                $("#packageprice").val('');
                window.location = site_url +'package/';
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
               }
            });
        }
	return false;
     });

     $("input#priceperpax").keyup(function(){
         var price = $(this).val();
         var pax = $("input#totalpax").val();
         var total = parseInt(price) * parseInt(pax);
         if(isNaN(total))
         {
             total = '';
         }
         $("input#packageprice").val(total);
     })


    $("input#totalpax").keyup(function(){
         var price = $("input#priceperpax").val();
         var pax = $(this).val();
         var total = parseInt(price) * parseInt(pax);
         if(isNaN(total))
         {
             total = '';
         }

         $("input#packageprice").val(total);
    })




 });