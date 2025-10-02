/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

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
                url: site_url+"entertainment/load_data_entertainment",
                cache: false,
                success: function(data){
                    $("#dataentertainment").html(data);
                },
                beforeSend: function(){
                    $("#dataentertainment").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
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


    $.ajax({
        type:"POST",
        url: site_url+"entertainment/load_data_entertainment",
        cache: false,
        success: function(data){
            $("#dataentertainment").html(data);
        },
        beforeSend: function(){
            $("#dataentertainment").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
        }
    });

    tinyMCE.execCommand('mceAddControl', false, 'deskripsi');

    $("#dateentertainment").datepicker({
        dateFormat:'dd-mm-yy'       
    });

     $("#daterequest").datepicker({
        dateFormat:'dd-mm-yy'
    });

$("#daterequest").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })

    $("#dateentertainment").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })

    $("#enddate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#enddate").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    }) 
 
    //begin autocomplete account list
   // $("#idaccount").autocomplete(site_url+"account/get_account", {
    $("#idaccount").autocomplete(site_url+"account/get_account_pergroup", {
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
    //end autocomplete account list

    //begin reset input box hasil dari autocomplete account list
    $('input#reset').click(function(){
        $('input#idacc').val('');
        $('input#idaccount').val('');
        return false;
    });
    //end reset input box hasil dari autocomplete account list


    $("#form_entertainment").validationEngine();
    $("form#form_entertainment").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }

          if($("#idacc").val() == ''){
            $.validationEngine.buildPrompt("#idaccount","Please select company from available list","error");
        }else{
        if($("#form_entertainment").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"entertainment/add_entertainment",
                cache: false,
                data:$('#form_entertainment').serialize(),
                dataType:"html",
                success: function(data){
                    // window.location = site_url +'activities/entertainment';
                    $('select#property').val('--Choose--');
                    $('input#dateentertainment').val('');
                    $('input#idaccount').val('');
                    $('div#divdatacontact').text('');
                    tinyMCE.getInstanceById('deskripsi').setContent('');
                    $("#processing").html(data);
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/> Processing...');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        }
        return false;
    });

    $("#form_edit_entertain").validationEngine();
    $("form#form_edit_entertain").submit(function() {
      
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }
        if($("#form_edit_entertain").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"entertainment/update_entertainment",
                cache: false,
                data:$('#form_edit_entertain').serialize(),
                dataType:"html",
                success: function(){
                    window.location = site_url +'entertainment';
                    $('select#property').val('--Choose--');
                    $('input#dateentertainment').val('');
                    $('input#idaccount').val('');
                    $('div#divdatacontact').text('');
                    tinyMCE.getInstanceById('deskripsi').setContent('');
                    $("#processing").html('Data has been saved.');
                    
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });

    $("#reset").click(function(){
        $("input#idacc").val('');
        $("input#accountname").val('');
        $("div#divdatacontact").text('');
    });

    $("#form_close_entertainment").validationEngine();
    $("form#form_close_entertainment").submit(function() {

        datades = tinyMCE.getInstanceById('deskripsi');
        if (datades) {
            $("#deskripsi").val(datades.getContent());
        }

        if (datades.getContent() == '' || datades.getContent() == "<p>&nbsp;</p>") {
            $("#processing").html('Please insert entertainment results.');
        }
        if($("#form_close_entertainment").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"entertainment/edit_close_entertainment",
                cache: false,
                data:$('#form_close_entertainment').serialize(),
                dataType:"html",
                success: function(){
                    window.location = site_url +'entertainment';
                    $('select#property').val('--Choose--');
                    $('input#dateentertainment').val('');
                    $('input#idaccount').val('');
                    $('input#enddate').val('');
                    $('div#divdatacontact').text('');
                    tinyMCE.getInstanceById('deskripsi').setContent('');
                    $("#processing").html('Data has been saved.');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        
        }
        return false;
    });

    //load data history
    $.ajax({
        type:"POST",
        url: site_url+"entertainment/get_entertainment_by_date",
        cache: false,
        success: function(data){
            $("#datahistentertainment").html(data);
        },
        beforeSend: function(){
            $("#datahistentertainment").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
        }
    });

    $("#histstartdate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#histenddate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("input#histstartdate").change(function(){
        $.ajax({
            type:"POST",
            url: site_url+"entertainment/get_entertainment_by_date",
            cache: false,
            data:({
                histstartdate:$(this).val(),
                enddate:$("input#histenddate").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistentertainment').html(data);
            },
            beforeSend: function(){
                $('#datahistentertainment').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#histenddate").change(function(){
        $.ajax({
            type:"POST",
            url: site_url+"entertainment/get_entertainment_by_date",
            cache: false,
            data:({
                histenddate:$(this).val(),
                histstartdate:$("input#histstartdate").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistentertainment').html(data);
            },
            beforeSend: function(){
                $('#datahistentertainment').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });

    
});