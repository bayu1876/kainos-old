/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
  //setInterval( "alert('Hello San')", 10000  );
//  setInterval("cekLeads()", 5000  );
//
//  function cekLeads()
//  {
//      alert('asdad');
//  }

setInterval(function()
{
   // $('#responsecontainer').fadeOut("slow").load('response.php').fadeIn("slow");

   $.ajax({
                type:"POST",
                url: site_url+"mobile_offering/get_openleads",
                cache: false,
                dataType:"html",
                success: function(data){
                     $("#leadsnotify").html('');
                  if(data == 'no leads'){
                      $("#divopenleads").html('');
                      $("#leadsnotify").html('');

                  }else{
                      $("#leadsnotify").html('<img src="'+base_url+'images/bb_notification.png"/>');
                      $("#divopenleads").html(data);
                  }
                },
                beforeSend: function(){

                }
            });



            $.ajax({
                type:"POST",
                url: site_url+"mobile_offering/get_mobileoffering",

                dataType:"html",
                success: function(data){
                  $("#containermobileoffering").html(data);
                },
                beforeSend: function(){

                }
            });
}, 5000);

 

});


