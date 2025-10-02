/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
     //tabbed forms box
     $("#dateactivities").datepicker({dateFormat:'dd-mm-yy'});
     tinyMCE.execCommand('mceAddControl', false, 'deskripsi');

     var tabContainers = $('div#forms > div.innerContent'); // change div#forms to your new div id (example:div#pages) if you want to use tabs on another page or div.
         tabContainers.hide().filter(':first').show();

         $('ul.switcherTabsActivities a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsActivities li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
//                $.ajax({
//                      type:"POST",
//                      url: site_url+"activities/call",
//                      cache: true,
//                      success: function(data){
//                        $("div#box-1").html(data);
//                      },
//                      beforeSend: function(){
//                        $("div#box-1").html('<img src="'+base_url+'images/facebox/loading.gif"/> Loading...');
//                      }
//                });
                return false;

         }).filter(':first').click();

         //begin autocomplete account list
         $("#idaccount").autocomplete(site_url+"account/get_account", {
                width: 245,
		selectFirst: false
         });

         $('input#idaccount').flushCache();
         $("#idaccount").result(function(event, data, formatted) {
		if (data){
                    
                    $('input#idacc').val(data[1]);
                    $.ajax({
                          type:"POST",
                          url: site_url+"contact/get_contact_byaccount",
                          data:({idaccount:data[1]}),
                          dataType:"html",
                          success: function(data){
                              $('#divdatacontact').html(data);
                          },
                           beforeSend: function(){
                             $('#divdatacontact').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                           }
                    });

                }//end IF
	 });
         //end autocomplete account list

         //begin reset input box hasil dari autocomplete account list
         $('input#reset').click(function(){
             $('input#idacc').val('');
             $('input#idaccount').val('');
            return false;
         });
         //end reset input box hasil dari autocomplete account list


$("#form_activities").validationEngine();
     $("form#form_activities").submit(function() {
            dataact = tinyMCE.getInstanceById('deskripsi');
            if (dataact) {
                $("#deskripsi").val(dataact.getContent());
            }
           if($("#form_activities").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"activities/add_salescall",
              cache: true,
              data:$('#form_activities').serialize(),
              dataType:"html",
              success: function(data){
                  
                $("#processing").html('Data Telah Disimpan.');
              
             },
               beforeSend: function(){

                $("#processing").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });
            $.validationEngine.closePrompt('.formError',true);
            }else{
      //alert('gagal');
     }
	return false;
     });


});//end document ready
