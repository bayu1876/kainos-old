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
    $(".content-box-header h3").click( // When the h3 is clicked...
        function () {
            $(this).parent().next().toggle(); // Toggle the Content Box
            $(this).parent().parent().toggleClass("closed-box"); // Toggle the class "closed-box" on the content box
            $(this).parent().find(".content-box-tabs").toggle(); // Toggle the tabs
        }
        );

    // Content box tabs:
    $('.content-box .content-box-content div.tab-content').hide(); // Hide the content divs
    $('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
    $('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"
    $('.content-box ul.content-box-tabs li a').click( // When a tab is clicked...
        function() {
            $.ajax({
                type:"POST",
                url: site_url+"other_activities/load_data_oth_activities",
                cache: false,
                success: function(data){
                    $("#dataotheractivities").html(data);
                },
                beforeSend: function(){
                    $("#dataotheractivities").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });

            $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
            $(this).addClass('current'); // Add class "current" to clicked tab
            var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
            $(currentTab).siblings().hide(); // Hide all content divs
            $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
            return false;
        }
        );

    tinyMCE.execCommand('mceAddControl', false, 'deskripsi');

    $("#dateactivities").datepicker({
        dateFormat:'dd-mm-yy'       
    });

    $("#dateactivities").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    });

    $("#enddate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#enddate").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    });


    $("#form_other_activities").validationEngine();
    $("form#form_other_activities").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }
        
        if($("#idacc").val() == ''){
            $.validationEngine.buildPrompt("#accountname","Please select company from available list","error");
        }else{
        if($("#form_other_activities").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"other_activities/add_other_activities",
                cache: false,
                data:$('#form_other_activities').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'other_activities';
                    $("#processing").html('Data has been saved.');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        }
        return false;
    });



    $("#form_edit_other_activities").validationEngine();
    $("form#form_edit_other_activities").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }
        if($("#form_edit_other_activities").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"other_activities/edit_other_activities",
                cache: false,
                data:$('#form_edit_other_activities').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'other_activities';
                    $("#processing").html('Data has been updated.');
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


    $("#form_close_otheract").validationEngine();
    $("form#form_close_otheract").submit(function() {
        datades = tinyMCE.getInstanceById('deskripsi');
        if (datades) {
            $("#deskripsi").val(datades.getContent());
        }
        
        if (datades.getContent() == '' || datades.getContent() == "<p>&nbsp;</p>") {
            $("#processing").html('Please insert activities results.');
        }
        
        if($("#form_close_otheract").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"other_activities/edit_close_otheractivities",
                cache: false,
                data:$('#form_close_otheract').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'other_activities';
                    $("#processing").html('Data has been updated.' );
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
        }else{
        //alert('gagal');
        }
        return false;
    });

    $("input#accountname").autocomplete(site_url+"account/get_account_pergroup",  {

    //$("input#accountname").autocomplete(site_url+"account/get_account",  {
        width: 204,
        selectFirst: false
    });

    $('input#accountname').flushCache();

    $("input#accountname").result(function(event, data, formatted) {
        if (data){
            $("input#idacc").val(data[1]);
            $.ajax({
                type:"POST",
                url: site_url+"contact/get_contact_byaccount",
                cache: false,
                data:({
                    idaccount:data[1]
                }),
                dataType:"html",
                success: function(data){
                    $('#divdatacontact').html(data);
                },
                beforeSend: function(){
                    $('#divdatacontact').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
        }//end IF
    });

    //begin reset input box hasil dari autocomplete account list
    $('input#reset').click(function(){
        $('input#idacc').val('');
        $('input#accountname').val('');
        $('#divdatacontact').html('');
        return false;
    });
    //end

    //load data
    $.ajax({
        type:"POST",
        url: site_url+"other_activities/load_data_oth_activities",
        cache: false,
        success: function(data){
            $("#dataotheractivities").html(data);
        },
        beforeSend: function(){
            $("#dataotheractivities").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
        }
    });

    //load data history
    $.ajax({
        type:"POST",
        url: site_url+"other_activities/get_other_activities_by_date",
        cache: false,
        success: function(data){
            $("#datahistotheractivities").html(data);
        },
        beforeSend: function(){
            $("#datahistotheractivities").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
        }
    });

    $("#startdate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#enddate").datepicker({
        dateFormat:'dd-mm-yy'
    });

     $("select#sales").change(function(){
         $.ajax({
            type:"POST",
            url: site_url+"other_activities/get_other_activities_by_date",
            cache: false,
            data:({
                sales:$(this).val(),
                startdate:$("input#startdate").val(),
                enddate:$("input#enddate").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistotheractivities').html(data);
            },
            beforeSend: function(){
                $('#datahistotheractivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
     })

    $("input#startdate").change(function(){ 
        $.ajax({
            type:"POST",
            url: site_url+"other_activities/get_other_activities_by_date",
            cache: false,
            data:({
                sales:$("select#sales").val(),
                startdate:$(this).val(),
                enddate:$("input#enddate").val() 
            }),
            dataType:"html",
            success: function(data){
                $('#datahistotheractivities').html(data);
            },
            beforeSend: function(){
                $('#datahistotheractivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#enddate").change(function(){ 
        $.ajax({
            type:"POST",
            url: site_url+"other_activities/get_other_activities_by_date",
            cache: false,
            data:({
                sales:$("select#sales").val(),
                enddate:$(this).val(),
                startdate:$("input#startdate").val() 
            }),
            dataType:"html",
            success: function(data){
                $('#datahistotheractivities').html(data);
            },
            beforeSend: function(){
                $('#datahistotheractivities').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });


});