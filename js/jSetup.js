/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
      $("a[rel*=facebox]").facebox();
 
var tabContainers = $('div#forms > div.innerContent'); // change div#forms to your new div id (example:div#pages) if you want to use tabs on another page or div.
         tabContainers.hide().filter(':first').show();
         $('ul.switcherTabsProperty a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsProperty li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"property/load_data_property",
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


$('ul.switcherTabsMRoom a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsMRoom li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"meeting_room/load_data_mroom",
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


         $('ul.switcherTabsMPackage a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsMPackage li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"meeting_package/load_data_mpackage",
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

         //untuk view data account segment
         $('ul.switcherTabsSegment a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsSegment li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"account_segment/load_data_account_segment",
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

         

         

         $('ul.switcherTabsEventType a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsEventType li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"event_type/load_data_eventtype",
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

$("#form_property").validationEngine();
     $("form#form_property").submit(function() {
           if($("#form_property").validationEngine({"ajaxKodeProperty":{
						"file":site_url+"setup/validate_kode_property",
						"extraData":"name=user",
						"alertTextOk":"* Kode dapat digunakan.",
						"alertTextLoad":"* Checking, please wait",
						"alertText":"* Kode sudah digunakan."}, returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"property/add_property",
              cache: true,
              data:$('#form_property').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#kode").val('');
                $("input#nama").val('');
                $("textarea#alamat").val('');
                $("input#telp").val('');
                $("input#fax").val('');
                $("input#email").val('');
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




     $("#form_meeting_room").validationEngine();
     $("form#form_meeting_room").submit(function() {
           if($("#form_meeting_room").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"meeting_room/add_mroom",
              cache: true,
              data:$('#form_meeting_room').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#kode").val('');
                $("input#nama").val('');
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

     $("#form_meeting_package").validationEngine();
     $("form#form_meeting_package").submit(function() {
           if($("#form_meeting_package").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"meeting_package/add_mpackage",
              cache: true,
              data:$('#form_meeting_package').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#kode").val('');
                $("input#deskripsi").val('');
                 $("input#harga").val('');
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


     $("#form_segment").validationEngine();
     $("form#form_segment").submit(function() {
           if($("#form_segment").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"company_segment/add_csegment",
              cache: true,
              data:$('#form_segment').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#kode").val('');
                $("input#nama").val('');

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
         
     $("#form_company").validationEngine();
     $("form#form_company").submit(function() {
           if($("#form_company").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"company/add_company",
              cache: true,
              data:$('#form_company').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#kode").val('');
                $("input#nama").val('');

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


     $("#form_event_type").validationEngine();
     $("form#form_event_type").submit(function() {
           if($("#form_event_type").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"event_type/add_eventtype",
              cache: true,
              data:$('#form_event_type').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#kode").val('');
                $("input#nama").val('');

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

     /*------------------------------------------------------------------------*/
     // KOEZNANDAR

     $("#form_account").validationEngine();
     $("form#form_account").submit(function() {
           if($("#form_account").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"account/add_account",
              cache: true,
              data:$('#form_account').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#industri").val('');
                $("input#propinsi").val('');
                $("input#kota").val('');
                $("input#segment").val('');
                $("input#companyname").val('');
                $("input#telp").val('');
                $("input#fax").val('');
                $("input#otherphone").val('');
                $("input#email").val('');
                $("input#website").val('');
                $("input#alamat").val('');
                $("input#kode_pos").val('');
                $("input#member").val('');
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

     $("#form_contact").validationEngine();
     $("form#form_contact").submit(function() {
           if($("#form_contact").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"contact/add_contact",
              cache: true,
              data:$('#form_contact').serialize(),
              dataType:"json",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#idaccount").val('');
                $("input#propinsi").val('');
                $("input#kota").val('');
                $("input#salutation").val('');
                $("input#firstname").val('');
                $("input#lastname").val('');
                $("input#title").val('');
                $("input#department").val('');
                $("input#phone_office").val('');
                $("input#phone_fax").val('');
                $("input#mobile").val('');
                $("input#cont_email").val('');
                $("input#otheremail").val('');
                $("input#address").val('');
                $("input#postal_code").val('');
                $("input#deskripsi").val('');
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


     $("#form_contract_rate").validationEngine();
     $("form#form_contract_rate").submit(function() {
           if($("#form_contract_rate").validationEngine({returnIsValid:true})){
           $.ajax({
              type:"POST",
              url: site_url+"contract_rate/add_contract",
              cache: true,
              data:$('#form_contract_rate').serialize(),
              dataType:"html",
              success: function(){
                $("#processing").html('Data Telah Disimpan.');
                $("input#idaccount").val('');
                $("input#propinsi").val('');
                 
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

     //untuk menampilkan daftar account
     $('ul.switcherTabsAccount a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsAccount li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"account/load_data_account",
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

      //untuk menampilkan daftar contact
     $('ul.switcherTabsContact a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsContact li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"contact/load_data_contact",
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

     //untuk menampilkan contract rate
     $('ul.switcherTabsContractRate a').click(function () {
                tabContainers.hide();
                tabContainers.filter(this.hash).show();
                $('ul.switcherTabsContractRate li').removeClass('selected');
                $(this).parent().addClass('selected');
                $.validationEngine.closePrompt('.formError',true);
                $("#processing").html('');
                $.ajax({
                      type:"POST",
                      url: site_url+"contract_rate/load_data_contract_rate",
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

///auto complete account untuk tambah contact////////////////////////////////
        $("#idaccount").autocomplete(site_url+"account/get_account", {
                width: 245,
		selectFirst: false
        });

        $('input#idaccount').flushCache();


        $("#idaccount").result(function(event, data, formatted) {
		if (data){
                //alert(data[1]);
                    $('#idacc').val(data[1]);//$(this).parent().next().find("input").val(data[1]);
                    $.ajax({
                          type:"POST",
                          url: site_url+"account/get_accountdetil",
                          data:({idaccount:data[1]}),
                          dataType:"json",
                          success: function(data){
                           // alert(data.officephone);
                            $('input#phone_office').val(data.officephone);
                            $('input#phone_fax').val(data.fax);
                            $('input#postal_code').val(data.postalcode);
                            $('input#address').val(data.address);
                            $('select#propinsi').val(data.kodeprop);
                            $.ajax({
                                  type:"POST",
                                  url: site_url+"account/get_city2",
                                  cache: true,
                                  data:({idpropinsi:data.kodeprop,idkota:data.kodekota}) ,
                                  dataType:"html",
                                  success: function(data){
                                     $('#divcity').html(data);
                                      
                                 },
                                   beforeSend: function(){
                                    $('#divcity').html('<img src="'+base_url+'images/ajax-loader.gif"/>');
                                   }
                                });
                                
                            $('#processacc').html('');
                          },
                           beforeSend: function(){
                             $('#processacc').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                           }
                    });
            }//end IF
	});

        ///END auto complete account untuk tambah contact////////////////////////////////

        ///auto complete account untuk CONTRACT RATE////////////////////////////////
        $("#namaaccount").autocomplete(site_url+"account/get_account", {
                width: 245,
		selectFirst: false
        });

        $('input#namaaccount').flushCache();


        $("#namaaccount").result(function(event, data, formatted) {
		if (data){
                //alert(data[1]);
                    $('input#idacc').val(data[1]);

                }//end IF
	});

        ///END auto complete account untuk CONTRACT RATE////////////////////////////////


        ///auto complete account(member-parent) untuk account baru////////////////////////////////
        $("input#member").autocomplete(site_url+"account/get_account", {
                width: 245,
		selectFirst: false
                
        });

        


        $('input#member').flushCache();


        $("input#member").result(function(event, data, formatted) {
		if (data){
                //alert(data[1]);
                    $('input#idparent').val(data[1]);

                }//end IF
                
	});

        $('input#reset').click(function(){
             $("input#member").val('');
             $('input#idparent').val('');
             $('input#idaccount').val('');
             $('input#idacc').val('');

            return false;
        });



$("#birthday").datepicker({dateFormat:'dd-mm-yy'});

$("#birthday").change(function() {
    $.validationEngine.closePrompt('.formError',true);
});
        ///END auto complete account account baru////////////////////////////////

});//end document ready