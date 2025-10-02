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
            $("#processing").html('');
            $.ajax({
                type:"POST",
                url: site_url+"telemarketing/load_data_telemarketing",
                cache: true,
                success: function(data){
                    $("#datatelemarketing").html(data);
                },
                beforeSend: function(){
                    $("#datatelemarketing").html('<img src="'+base_url+'images/ajax-loader.gif"/>Loading...');
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

     
    



    //tinyMCE.execCommand('mceAddControl', false, 'deskripsi');
    $(".cloneTableTelemarketing").live('click', function(){
        // this tables id
        var thisTableId = $(this).parents("table").attr("id");
        // lastRow
        var lastRow = $('#'+thisTableId + " tr:last");
        // clone last row
        var newRow = lastRow.clone(true);
        // append row to this table
        $('#'+thisTableId).append(newRow);
        // make the delete image visible
        $('#'+thisTableId + " tr:last  ").css("display", "");
        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
        // clear the inputs (Optional)
        //$('#'+thisTableId + " tr:last td :input").val('');

        // new rows datepicker need to be re-initialized
        $(newRow).find("input").each(function(){
            if($(this).hasClass("hasDatepicker")){ // if the current input has the hasDatpicker class
                var this_id = $(this).attr("id"); // current inputs id
                //                var txtid = this_id.slice(0,4);
                //                var numberid = this_id.slice(4);
                var new_id = parseInt(this_id) + 1;
                // a new id
                $(this).attr("id", new_id); // change to new id
                $(this).removeClass('hasDatepicker'); // remove hasDatepicker class
                // re-init datepicker
                $(this).datepicker({
                    dateFormat: 'dd-mm-yy',
                    showButtonPanel: true
                });
            }

            if($(this).hasClass("accountname")){ // if the current input has the hasDatpicker class
                var this_idx = $(this).attr("id"); // current inputs id
                var txtidx = this_idx.slice(0,8);
                var numberidx = this_idx.slice(8);
                var new_idx = parseInt(numberidx) + 1;
                // a new id
                //    var new_idx =  parseInt(this_idx) + 1; // a new id
                $(this).attr("id", txtidx+new_idx); // change to new id
            //  $(this).attr("id", new_idx); // change to new id
            }
        });

        $(newRow).find("input:hidden").each(function(){
            if($(this).hasClass("idacc")){ // if the current input has the hasDatpicker class
                var this_id = $(this).attr("id"); // current inputs id
                var new_id =  parseInt(this_id) + 1; // a new id
                $(this).attr("id", new_id); // change to new id
            }
        });

        $(newRow).find("select").each(function(){
            if($(this).hasClass("weektypebreakdown")){ // if the current input has the hasDatpicker class
                var this_id = $(this).attr("id"); // current inputs id
                var new_id =  parseInt(this_id) + 1; // a new id
                $(this).attr("id", new_id); // change to new id
            }
        });

        return false;
    });

    // Delete a table row
    $("img.delRow").click(function(){
        $(this).parents("tr").remove();

        return false;
    });

    //begin untuk menampilkan data
    $.ajax({
        type:"POST",
        url: site_url+"telemarketing/load_data_telemarketing",
        cache: true,
        success: function(data){
            $("#datatelemarketing").html(data);
        },
        beforeSend: function(){
            $("#datatelemarketing").html('<img src="'+base_url+'images/ajax-loader.gif"/>Loading...');
        }
    });

    //begin fungsi untuk add data dari form
    tinyMCE.execCommand('mceAddControl', false, 'deskripsi');

    tinyMCE.execCommand('mceAddControl', false, 'resultsalescall');

    $("#teledate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#da").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#apptdate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#teledate").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })
    $("#apptdate").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })

    $("#da").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })

    //begin autocomplete account list
    //   var i;
    //   for(i=1;i<=30;i++){
    //    $("input.accountname[id^="+i+"]").autocomplete(site_url+"account/get_account",  {
    //        width: 144,
    //        selectFirst: false
    //    });
    //   }

    //$("input#accountname").autocomplete(site_url+"account/get_account",  {
      $("input#accountname").autocomplete(site_url+"account/get_account_pergroup",  {
      
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
    //    //end autocomplete account list

    //begin reset input box hasil dari autocomplete account list
    $('input#reset').click(function(){
        $('input#idacc').val('');
        $('input#idaccount').val('');
        return false;
    });
    //end reset input box hasil dari autocomplete account list

    $("#form_todolist").validationEngine();
    $("form#form_todolist").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }


        
        if($("#form_todolist").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"telemarketing/add_todolist",
                cache: true,
                data:$('#form_todolist').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data has been saved.');
                    $("input#subject").val('');
                    $("input#startdate").val('');
                    $("input#duedate").val('');
                    $("input#deskripsi").val('');
                    $("input#priority").val('');
                    $("input#status").val('');
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/ajax-loader.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });
    //end fungsi untuk add data dari form

    $(".my_date").datepicker({
        dateFormat: 'dd-mm-yy',
        showButtonPanel: true
    });


    $("#form_telemarketing").validationEngine();
    $("form#form_telemarketing").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }

        if($("#idacc").val() == ''){
            $.validationEngine.buildPrompt("#accountname","Please select company from available list","error");
        }else{
        if($("#form_telemarketing").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"telemarketing/add_telemarketing",
                cache: true,
                data:$('#form_telemarketing').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data has been saved.');
                    $("input#teledate").val('');
                    $("input#accountname").val('');
                    $("input#idacc").val('');
                    $("select.jam_tm").val('07');
                    $("select.menit_tm").val('00');
                    $("div#divdatacontact").text('');
                   
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/ajax-loader.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        }
        return false;
        
    });

    $("#form_edit_telemarketing").validationEngine();
    $("form#form_edit_telemarketing").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }

        if($("#form_edit_telemarketing").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"telemarketing/edit_telemarketing",
                cache: true,
                data:$('#form_edit_telemarketing').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data has been updated.');
                    window.location = site_url +'telemarketing';
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/ajax-loader.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });
    
    
    $("#form_edit_telemarketing_no_lead").validationEngine();
    $("form#form_edit_telemarketing_no_lead").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }

        if($("#form_edit_telemarketing_no_lead").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"telemarketing/edit_telemarketing_no_lead",
                cache: true,
                data:$('#form_edit_telemarketing_no_lead').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data has been updated.');
                    window.location = site_url +'telemarketing';

                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/ajax-loader.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });

    $("#resultlastdate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#resultlastdate").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })

    $("#nextcondate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#nextcondate").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })
    

    $("#form_close_telemarketing").validationEngine();
    $("form#form_close_telemarketing").submit(function() {
        datades = tinyMCE.getInstanceById('resultsalescall');
        if (datades) {
            $("#resultsalescall").val(datades.getContent());
        }

        if (datades.getContent() == '' || datades.getContent() == "<p>&nbsp;</p>") {
            $("#processing").html('Please Insert Sales Call Results.');
        }
        

        if($("#form_close_telemarketing").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"telemarketing/close_telemarketing",
                cache: true,
                data:$('#form_close_telemarketing').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data Has Been Saved.');
                    window.location = site_url +'sales_call_planning';
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/ajax-loader.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });

    $("select.qualified").live('change',function(){
        var this_id = $(this).attr('id');
        var idtelmar = $("input.idtelmar[id^="+this_id+"]").val();
        // alert(idtelmar)
        var val = $(this).val();
        if(val == 'yes'){
            window.location = site_url +'telemarketing/detil_telemarketing/'+idtelmar;
        }else if(val == 'no'){
            window.location = site_url +'telemarketing/detil_telemarketing_no_lead/'+idtelmar;
//            $.ajax({
//                type:"POST",
//                url: site_url+"telemarketing/edit_telemarketing2",
//                cache: true,
//                data:({
//                    idtel:idtelmar
//                }),
//                dataType:"html",
//                success: function(data){
//                    $.ajax({
//                        type:"POST",
//                        url: site_url+"telemarketing/load_data_telemarketing",
//                        cache: true,
//                        success: function(data){
//                            $("#datatelemarketing").html(data);
//                        },
//                        beforeSend: function(){
//                            $("#datatelemarketing").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
//                        }
//                    });
//                },
//                beforeSend: function(){
//                    $("#processing").html('<img src="'+base_url+'/images/ajax-loader.gif"/>');
//                }
//            });
        }
    })

    $("#reset").click(function(){
        $("input#idacc").val('');
        $("input#accountname").val('');
        $("div#divdatacontact").text('');
    });

    //load data history
    $.ajax({
        type:"POST",
        url: site_url+"telemarketing/get_telemarketing_by_date",
        cache: true,
        success: function(data){
            $("#datahisttelemarketing").html(data);
        },
        beforeSend: function(){
            $("#datahisttelemarketing").html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
        }
    });

    $("#histstartdate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#histenddate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    

    $("input#histstartdate").change(function(){
        var unqualified = $("input#unqualified").attr('checked');
        var qualifiedwithcall = $("input#qualifiedwithcall").attr('checked');
        var qualifiedwithoutcall = $("input#qualifiedwithoutcall").attr('checked');
        var fromdate = $("input#histstartdate").val();
        var todate = $("input#histenddate").val();
        var sales = $("select#sales").val();
        $.ajax({
            type:"POST",
            //url: site_url+"telemarketing/get_telemarketing_by_date",
            url: site_url+"telemarketing/get_telemarketing_by_detil",
            data:({
                histstartdate:$(this).val(),
                histenddate:$("input#histenddate").val(),
                sales:$("select#sales").val(),
                unqualified:unqualified,
                qualifiedwithcall:qualifiedwithcall,
                qualifiedwithoutcall:qualifiedwithoutcall
            }),
            dataType:"html",
            success: function(data){
                $('#datahisttelemarketing').html(data);
            },
            beforeSend: function(){
                $('#datahisttelemarketing').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#histenddate").change(function(){
          var unqualified = $("input#unqualified").attr('checked');
        var qualifiedwithcall = $("input#qualifiedwithcall").attr('checked');
        var qualifiedwithoutcall = $("input#qualifiedwithoutcall").attr('checked');
        var fromdate = $("input#histstartdate").val();
        var todate = $("input#histenddate").val();
        var sales = $("select#sales").val();
        $.ajax({
            type:"POST",
            //url: site_url+"telemarketing/get_telemarketing_by_date",
            url: site_url+"telemarketing/get_telemarketing_by_detil",
            data:({
                histenddate:$(this).val(),
                histstartdate:$("input#histstartdate").val(),
                sales:$("select#sales").val(),
                unqualified:unqualified,
                qualifiedwithcall:qualifiedwithcall,
                qualifiedwithoutcall:qualifiedwithoutcall
            }),
            dataType:"html",
            success: function(data){
                $('#datahisttelemarketing').html(data);
            },
            beforeSend: function(){
                $('#datahisttelemarketing').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    });

    $("select#sales").change(function(){
         var unqualified = $("input#unqualified").attr('checked');
        var qualifiedwithcall = $("input#qualifiedwithcall").attr('checked');
        var qualifiedwithoutcall = $("input#qualifiedwithoutcall").attr('checked');
        var fromdate = $("input#histstartdate").val();
        var todate = $("input#histenddate").val();
        var sales = $("select#sales").val();
        $.ajax({
            type:"POST",
            url: site_url+"telemarketing/get_telemarketing_by_detil",
            data:({
                histenddate:$("input#histenddate").val(),
                histstartdate:$("input#histstartdate").val(),
                sales:$(this).val(),
                unqualified:unqualified,
                qualifiedwithcall:qualifiedwithcall,
                qualifiedwithoutcall:qualifiedwithoutcall
            }),
            dataType:"html",
            success: function(data){
                $('#datahisttelemarketing').html(data);
            },
            beforeSend: function(){
                $('#datahisttelemarketing').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });
    });


$("input#unqualified").change(function(){
    var unqualified = $(this).attr('checked');
     
    var qualifiedwithcall = $("input#qualifiedwithcall").attr('checked');
    var qualifiedwithoutcall = $("input#qualifiedwithoutcall").attr('checked');
    var fromdate = $("input#histstartdate").val();
    var todate = $("input#histenddate").val();
    var sales = $("select#sales").val();

    $.ajax({
            type:"POST",
            url: site_url+"telemarketing/get_telemarketing_by_detil",
            data:({
                histstartdate:fromdate,
                histenddate:todate,
                sales:sales,
                unqualified:unqualified,
                qualifiedwithcall:qualifiedwithcall,
                qualifiedwithoutcall:qualifiedwithoutcall
            }),
            dataType:"html",
            success: function(data){
                $('#datahisttelemarketing').html(data);
            },
            beforeSend: function(){
                $('#datahisttelemarketing').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });

        return false;
})

$("input#qualifiedwithcall").change(function(){
    var unqualified = $("input#unqualified").attr('checked');
    var qualifiedwithcall = $("input#qualifiedwithcall").attr('checked');
    var qualifiedwithoutcall = $("input#qualifiedwithoutcall").attr('checked');
    var fromdate = $("input#histstartdate").val();
    var todate = $("input#histenddate").val();
    var sales = $("select#sales").val();

    $.ajax({
            type:"POST",
            url: site_url+"telemarketing/get_telemarketing_by_detil",
            data:({
                histstartdate:fromdate,
                histenddate:todate,
                sales:sales,
                unqualified:unqualified,
                qualifiedwithcall:qualifiedwithcall,
                qualifiedwithoutcall:qualifiedwithoutcall
            }),
            dataType:"html",
            success: function(data){
                $('#datahisttelemarketing').html(data);
            },
            beforeSend: function(){
                $('#datahisttelemarketing').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
            }
        });

        return false;
})



$("input#qualifiedwithoutcall").change(function(){
    var unqualified = $("input#unqualified").attr('checked');
    var qualifiedwithcall = $("input#qualifiedwithcall").attr('checked');
    var qualifiedwithoutcall = $("input#qualifiedwithoutcall").attr('checked');
    var fromdate = $("input#histstartdate").val();
    var todate = $("input#histenddate").val();
    var sales = $("select#sales").val();
    $.ajax({
        type:"POST",
        url: site_url+"telemarketing/get_telemarketing_by_detil",
        data:({
            histstartdate:fromdate,
            histenddate:todate,
            sales:sales,
            unqualified:unqualified,
            qualifiedwithcall:qualifiedwithcall,
            qualifiedwithoutcall:qualifiedwithoutcall
        }),
        dataType:"html",
        success: function(data){
            $('#datahisttelemarketing').html(data);
        },
        beforeSend: function(){
            $('#datahisttelemarketing').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
        }
    });

    return false;
})


     

});