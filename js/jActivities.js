/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    tinyMCE.execCommand('mceAddControl', false, 'deskripsi');

    $("#dateactivities").datepicker({
        dateFormat:'dd-mm-yy'
       
    });

    $("#dateactivities").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })
    

    $("select#startjam").change(function(){
        $("select#endjam").val($(this).val());
    })

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
                data:({
                    idaccount:data[1]
                }),
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
        if($("#form_activities").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"activities/add_salescall",
                cache: true,
                data:$('#form_activities').serialize(),
                dataType:"html",
                success: function(data){

                    $("#processing").html('1 new data added.');

                },
                beforeSend: function(){

                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });

$("#form_close_telemarketing").validationEngine();
    $("form#form_close_telemarketing").submit(function() {
        datades = tinyMCE.getInstanceById('deskripsi');
        if (datades) {
            $("#deskripsi").val(datades.getContent());
//            if($("#deskripsi").val() == ''){
//            $.validationEngine.buildPrompt(tinyMCE.getInstanceById('deskripsi'),"This field is required","error");
//            }
        }

           
         if (datades.getContent() == '' || datades.getContent() == "<p>&nbsp;</p>") {
            $("#processing").html('Please insert call results.');
         }
        
       
        if($("#form_close_telemarketing").validationEngine({
            returnIsValid:true
        })){
           
            $.ajax({
                type:"POST",
                url: site_url+"activities/edit_close_telemarketing",
                cache: true,
                data:$('#form_close_telemarketing').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Close telemarketing.');
                    window.location = site_url +'activities/sales_call_planning';
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
            
        }else{
        //alert('gagal');
        }
        return false;
    });




});