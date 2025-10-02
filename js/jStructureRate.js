/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    $("form#form_editstruct").submit(function() {
        if($("#form_editstruct").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"meeting_package/update_structure_rate",
                cache: false,
                data:$('#form_editstruct').serialize(),
                dataType:"html",
                success: function(data){
                     window.location = site_url +'meeting_package';
                    ("#processing").html(' ');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });
    
    
    $("form#form_editstructadditional").submit(function() {
         
        if($("#form_editstructadditional").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"additional/update_structure_rate",
                cache: false,
                data:$('#form_editstructadditional').serialize(),
                dataType:"html",
                success: function(data){
                     window.location = site_url +'additional/master_additional';
                    ("#processing").html(' ');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });
    
    
    $("form#form_editstructstall").submit(function() {
         
        if($("#form_editstructstall").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"wedding_stall/update_structure_rate",
                cache: false,
                data:$('#form_editstructstall').serialize(),
                dataType:"html",
                success: function(data){
                     window.location = site_url +'wedding_stall';
                    ("#processing").html(' ');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });


$("form#form_editstructpackage").submit(function() {
         
        if($("#form_editstructpackage").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"package/update_structure_rate",
                cache: false,
                data:$('#form_editstructpackage').serialize(),
                dataType:"html",
                success: function(data){
                     window.location = site_url +'package';
                    ("#processing").html(' ');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });
})