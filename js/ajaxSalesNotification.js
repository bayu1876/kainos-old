/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
     $("#activitiesnotify").html('');
    $.ajax({
        type:"POST",
        url: site_url+"activities/get_open_activities",
        dataType:"html",
        success: function(data){
           
            if(data == 0){
                 $("#activitiesnotify").html('');
            }else{
                $("#activitiesnotify").html('<img class="actnotify" title="You have open activities." style="cursor:pointer" src="'+base_url+'images/bb_notification.png"/>');
                $("#containeropenactivities").html(data);
            }
        },
        beforeSend: function(){
            $("#activitiesnotify").html('');
        }
    });
        
    
  $('.qualifiednotify').live('click',function(e) {
       $('.subpanel').show();
        
    });

     $('.qualifiednotify').live('change',function(e) {
        $('.subpanel').show();
        var id = $(this).attr('id');
        var qualified = $(this).val();
        if(qualified == 'yes')
        {
            window.location = site_url +'telemarketing/detil_telemarketing/'+id;
        }else if(qualified == 'no'){
            $.ajax({
                type:"POST",
                url: site_url+"telemarketing/edit_telemarketing2",
                data:({idtel:id}),
                dataType:"html",
                success: function(){
                    ///////////
                    $.ajax({
                        type:"POST",
                        url: site_url+"activities/get_open_activities",
                        dataType:"html",
                        success: function(data){
                            if(data == '0'){
                                $("#activitiesnotify").html( );
                            }else{
                                $("#activitiesnotify").html('<img class="actnotify" title="You have open activities." style="cursor:pointer" src="'+base_url+'images/bb_notification.png"/>');
                                $("#containeropenactivities").html(data);
                            }
                        }
                    });
                    /////////////////
                },
                beforeSend: function(){
                     $("#containeropenactivities").html('<img class="actnotify" title="You have open activities." style="cursor:pointer" src="'+base_url+'/images/ajax-loader.gif"/>');
                }
            });
        }
    });



    $('.actionslscallnotify').live('click',function(e) {
        $('.subpanel').show();

    });

    $('.actionslscallnotify').live('change',function(e) {
        $('.subpanel').show();
        var id = $(this).attr('id');
        var action = $(this).val();
        if(action == 'edit')
        {
            window.location = site_url +'sales_call_planning/edit_scp_telemarketing/'+id;
        }else if(action == 'close'){
           window.location = site_url +'sales_call_planning/close/'+id;
        }
    });


    $('.actionslscall2notify').live('click',function(e) {
        $('.subpanel').show();

    });
      $('.actionslscall2notify').live('change',function(e) {
        $('.subpanel').show();
        var id = $(this).attr('id');
        var action = $(this).val();
        if(action == 'close')
        {
            window.location = site_url +'sales_call_planning/close_last_minutes/'+id;
        }
         
    });



     $('.actionentertainnotify').live('click',function(e) {
        $('.subpanel').show();
     });

     $('.actionentertainnotify').live('change',function(e) {
        $('.subpanel').show();
        var id = $(this).attr('id');
        var action = $(this).val();
        if(action == 'edit')
        {
            window.location = site_url +'entertainment/edit_entertainment/'+id;
        }else if(action == 'close'){
            window.location = site_url +'entertainment/close_entertainment/'+id;
        }else if(action == 'print'){
            window.location = site_url +'entertainment/generate_pdf_entertainment/'+id;
        }
    });



    $('.actionothactnotify').live('click',function(e) {
        $('.subpanel').show();
    });

      $('.actionothactnotifiy').live('change',function(e) {
        $('.subpanel').show();
        var id = $(this).attr('id');
        var action = $(this).val();
        if(action == 'edit')
        {
            window.location = site_url +'other_activities/change_other_activities/'+id;
        }else if(action == 'close'){
            window.location = site_url +'other_activities/close_other_activities/'+id;
        }
    });


$('.actiontasknotify').live('click',function(e) {
        $('.subpanel').show();
    });
      $('.actiontasknotifiy').live('change',function(e) {
        $('.subpanel').show();
        var id = $(this).attr('id');
        var action = $(this).val();
        if(action == 'edit')
        {
            window.location = site_url +'task/change_task/'+id;
        }else if(action == 'close'){
            window.location = site_url +'task/close_task/'+id;
        }
    });


   
});


