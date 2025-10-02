/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
     //tabbed forms box
     //
     var tabContainers = $('div#forms > div.innerContent'); // change div#forms to your new div id (example:div#pages) if you want to use tabs on another page or div.
         tabContainers.hide().filter(':first').show();
         $('ul.switcherTabsSlsPos a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsSlsPos li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"sales/update_data_jabatan",
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

 
        $('ul.switcherTabsSlsGroup a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsSlsGroup li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"sales/update_data_group",
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


        $('ul.switcherTabsSlsPerson a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsSlsPerson li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"sales/update_data_person",
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

         $('ul.switcherTabsSlsTarget a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsSlsTarget li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"sales/load_sales_target",
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

$("#form_position").validationEngine();
     $("form#form_position").submit(function() {
           if($("#form_position").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"sales/add_position",
              cache: true,
              data:$('#form_position').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#nama_jab").val('');
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });
            }else{
      //alert('gagal');
            }
	return false;
     });
     
$("#form_group").validationEngine();
     $("form#form_group").submit(function() {
         if($("#form_group").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"sales/add_group",
              cache: true,
              data:$('#form_group').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#nama_group").val('');
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });
            }else{
      //alert('gagal');
     }
	return false;
     });

$("#form_person").validationEngine();
$("form#form_person").submit(function() {
     if($("#form_person").validationEngine({returnIsValid:true})){
         $.ajax({
              type:"POST",
              url: site_url+"sales/add_person",
              cache: true,
              data:$('#form_person').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#nama").val('');
                $("input#telp1").val('');
                $("input#telp2").val('');
                $("input#email").val('');
                 
                
              },
               beforeSend: function(){
                $("#processing").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });
     }else{
       // alert('gagal');
     }
	return false;
     });

    $("#form_sales_target").validationEngine();
    $("form#form_sales_target").submit(function() {
    if($("#form_sales_target").validationEngine({returnIsValid:true})){
         $.ajax({
              type:"POST",
              url: site_url+"sales/add_sales_target",
              cache: true,
              data:$('#form_sales_target').serialize(),
              dataType:"html",
              success: function(data){
                //alert(data)
                $("#processingstp").html('Data Telah Disimpan.');
              },
               beforeSend: function(){
                $("#processingstp").html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
              }
            });
     }else{
       // alert('gagal');
     }
	return false;
     });



 $('select#sales').change(function(){
     $.validationEngine.closePrompt('.formError',true);
      $.ajax({
              type:"POST",
              url: site_url+"sales/get_salestarget",
              cache: true,
              data:({idsales:$(this).val()}) ,
              dataType:"html",
              success: function(data){
                 // alert(data);
                 $('#checksales').html('Sales already has target');
                 if(data == 'Y'){
                 $('input#amount').attr('readonly','readonly');
                 $('input#amount').val('');
                 }else{
                      $('#checksales').html('');
                     $('input#amount').removeAttr('readonly');
                 }
             },
               beforeSend: function(){
                   
                $('#checksales').html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });

 });
     

     $('select#propinsi').live('change', function() {
         $.ajax({
              type:"POST",
              url: site_url+"account/get_city",
              cache: true,
              data:({idpropinsi:$(this).val()}) ,
              dataType:"html",
              success: function(data){
                 $('#divcity').html(data);
             },
               beforeSend: function(){
                $('#divcity').html('<img src="'+base_url+'images/facebox/loading.gif"/> Simpan...');
               }
            });

     });

     $("#birthday").datepicker({dateFormat:'dd-mm-yy'});

     $("#birthday").change(function() {
        $.validationEngine.closePrompt('.formError',true);
     });

});//end document ready
