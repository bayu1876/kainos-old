/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    //Minimize Content Box

    $(".content-box-header h3").css({
        "cursor":"s-resize"
    }); // Give the h3 in Content Box Header a different cursor
    $(".closed-box .content-box-content").hide(); // Hide the content of the header if it has the class "closed"
    $(".closed-box .content-box-tabs").hide(); // Hide the tabs in the header if it has the class "closed"

    

    // Content box tabs:

    $('.content-box .content-box-content div.tab-content').hide(); // Hide the content divs
    $('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
    $('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"

    $('.content-box ul.content-box-tabs li a').click( // When a tab is clicked...
        function() {
            $.ajax({
                type:"POST",
                url: site_url+"task/load_data_task",
                dataType:'html',
                cache: true,
                success: function(data){
                    $("#datatodolist").html(data);
                },
                beforeSend: function(){
                    $("#datatodolist").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
            $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
            $(this).addClass('current'); // Add class "current" to clicked tab
            var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
            $(currentTab).siblings().hide(); // Hide all content divs
            $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
            return false;
        }
        );



    //begin untuk menampilkan data
    $.ajax({
        type:"POST",
        url: site_url+"task/load_data_task",
        dataType:'html',
        cache: true,
        success: function(data){
            $("#datatask").html(data);
        },
        beforeSend: function(){
            $("#datatask").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
        }
    });

    //begin fungsi untuk add data dari form
    tinyMCE.execCommand('mceAddControl', false, 'deskripsi');

    $("#startdate").datepicker({
        dateFormat:'dd-mm-yy'       
    });
    $("#enddate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#startdate").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })
    $("#enddate").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })    

    $("#form_task").validationEngine();
    $("form#form_task").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }
        if($("#form_task").validationEngine({
            returnIsValid:true
        })){
            
            $.ajax({
                type:"POST",
                url: site_url+"task/add_task",
                cache: true,
                data:$('#form_task').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'task';
                    $("#processing").html('Data has been saved.');
                    $("input#subject").val('');
                    $("input#startdate").val('');
                    $("input#enddate").val('');
                    $("input#deskripsi").val('');
                    $("input#priority").val('');
                    $("input#status").val('');
                    
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
    //end fungsi untuk add data dari form

    $("#form_edit_task").validationEngine();
    $("form#form_edit_task").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }
        if($("#form_edit_task").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"task/edit_task",
                cache: true,
                data:$('#form_edit_task').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'task';
                    $("#processing").html('');
                    $("input#subject").val('');
                    $("input#startdate").val('');
                    $("input#enddate").val('');
                    $("input#deskripsi").val('');
                    $("input#priority").val('');
                    $("input#status").val('');
                    
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
    //end fungsi untuk add data dari form

    
    //load data history
    $.ajax({
        type:"POST",
        url: site_url+"task/get_task_by_date",
        cache: true,
        success: function(data){
            $("#datahisttask").html(data);
        },
        beforeSend: function(){
            $("#datahisttask").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
        }
    });

    $("#histstartdate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#histenddate").datepicker({
        dateFormat:'dd-mm-yy'
    });



    $("select#sales").change(function(){
        
        $.ajax({
            type:"POST",
            url: site_url+"task/get_task_by_date",
            data:({
                sales:$(this).val(),
                histstartdate: $("input#histstartdate").val(),
                histenddate:$("input#histenddate").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahisttask').html(data);
            },
            beforeSend: function(){
                $('#datahisttask').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#histstartdate").change(function(){
        $.ajax({
            type:"POST",
            url: site_url+"task/get_task_by_date",
            data:({
                sales:$("select#sales").val(),
                histstartdate:$(this).val(),
                histenddate:$("input#histenddate").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahisttask').html(data);
            },
            beforeSend: function(){
                $('#datahisttask').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#histenddate").change(function(){
        $.ajax({
            type:"POST",
            url: site_url+"task/get_task_by_date",
            data:({
                 sales:$("select#sales").val(),
                histenddate:$(this).val(),
                histstartdate:$("input#histstartdate").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahisttask').html(data);
            },
            beforeSend: function(){
                $('#datahisttask').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });

    $("#form_close_task").validationEngine();
    $("form#form_close_task").submit(function() {
        datades = tinyMCE.getInstanceById('deskripsi');
        if (datades) {
            $("#deskripsi").val(datades.getContent());
        }
        if (datades.getContent() == '' || datades.getContent() == "<p>&nbsp;</p>") {
            $("#processing").html('Please insert task results.');
        }
        if($("#form_close_task").validationEngine({
            returnIsValid:true
        })){

            $.ajax({
                type:"POST",
                url: site_url+"task/edit_close_task",
                cache: true,
                data:$('#form_close_task').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'task';
                    $("#processing").html('');
                    $("input#subject").val('');
                    $("input#startdate").val('');
                    $("input#enddate").val('');
                    $("input#deskripsi").val('');
                    $("input#priority").val('');
                    $("input#status").val('');

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


});