/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    var tabContainers = $('div#forms > div.innerContent'); // change div#forms to your new div id (example:div#pages) if you want to use tabs on another page or div.

    tabContainers.hide().filter(':first').show();
    $('ul.switcherTabsConfirmation a').click(function () {
    tabContainers.hide();
    tabContainers.filter(this.hash).show();
    $('ul.switcherTabsConfirmation li').removeClass('selected');
    $(this).parent().addClass('selected');
    $.validationEngine.closePrompt('.formError',true);
    $("#processing").html('');
    $.ajax({
          type:"POST",
          url: site_url+"confirmation_letter/loading_data_confirmation",
          cache: true,
          success: function(data){
            $("div#box-1").html(data);
          },
          beforeSend: function(){
            $("div#box-1").html('<img src="'+base_url+'images/facebox/loading.gif"/> Loading...');
          }
    });
    return false;
}).filter(':first').click();





});//END DOCUMENT READY