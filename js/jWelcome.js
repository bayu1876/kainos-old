/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    tinyMCE.execCommand('mceAddControl', false, 'notes');

    $.ajax({
                      type:"POST",
                      url: site_url+"welcome/get_datasalesachievment",
                      cache: true,
                      dataType:'html',
                      success: function(data){
                         $("#datasalestarget").html(data);
                          

                       },
                      beforeSend: function(){
                            $("#datasalestarget").html('<img width="25px" height="25px" src="'+base_url+'images/facebox/loading.gif"/>');
                     
                      }
                });
});