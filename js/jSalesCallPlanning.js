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

    $("#startdatescp").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#enddatescp").datepicker({
        dateFormat:'dd-mm-yy'
    });
    
    
    $("#startdateall").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#enddateall").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("input#startdatescp").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"sales_call_planning/get_salescallplanning",
                data:({
                    startdate:$(this).val(),
                    enddate:$("input#enddatescp").val(),
                      salesscp :$("select#salesscp").val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })

      $("input#enddatescp").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"sales_call_planning/get_salescallplanning",
                data:({
                   enddate :$(this).val(),
                   startdate :$("input#startdatescp").val(),
                   salesscp :$("select#salesscp").val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })
    
    $("input#startdateall").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"sales_call_planning/get_salescallplanning_by_sales",
                data:({
                    startdate:$(this).val(),
                    enddate:$("input#enddateall").val(),
                      salesscp :$("select#salesall").val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })

      $("input#enddateall").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"sales_call_planning/get_salescallplanning_by_sales",
                data:({
                   enddate :$(this).val(),
                   startdate :$("input#startdateall").val(),
                   salesscp :$("select#salesall").val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })



 $("select#salesscp").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"sales_call_planning/get_salescallplanning",
                data:({
                     enddate :$("input#enddatescp").val(),
                   startdate :$("input#startdatescp").val(),
                    salesscp :$("select#salesscp").val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })
    
    
    $("select#salesall").change(function(){
         $.ajax({
                type:"POST",
                url: site_url+"sales_call_planning/get_salescallplanning_by_sales",
                data:({
                     enddate :$("input#enddateall").val(),
                   startdate :$("input#startdateall").val(),
                    salesscp :$(this).val()
                }),
                dataType:"html",
                success: function(data){
                    $('#datatodolist').html(data);
                },
                beforeSend: function(){
                    $('#datatodolist').html('<img src="'+base_url+'images/ajax-loader.gif"/> ');
                }
            });
    })



    $("#startdatescphistory").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#enddatescphistory").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#dateactivities").change(function(){
        $.validationEngine.closePrompt('.formError',true);
    })    

    $("select#startjam").change(function(){
        $("select#endjam").val($(this).val());
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

    $("#reset").click(function(){
        $("input#idacc").val('');
        $("input#accountname").val('');
        $("div#divdatacontact").text('');
    });




    $("#form_activities").validationEngine();
    $("form#form_activities").submit(function() {
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }
         if($("#idacc").val() == ''){
            $.validationEngine.buildPrompt("#idaccount","Please select company from available list","error");
        }else{
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
                    $("input#dateactivities").val('');
                    $("input#idacc").val('');
                    $("input#idaccount").val('');                    
                    $("input#accountname").val('');
                    $("div#divdatacontact").text(''); 
                    tinyMCE.getInstanceById('deskripsi').setContent('');
                    $("#processing").html('Data Has Been Saved.');
                },
                beforeSend: function(){

                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        }
        return false;
    });

 

    //begin untuk menampilkan data
    $.ajax({
        type:"POST",
        url: site_url+"sales_call_planning/load",
        cache: true,
        success: function(data){
            $("#datatodolist").html(data);
        },
        beforeSend: function(){
            $("#datatodolist").html('<img src="'+base_url+'/images/loading.gif"/>Loading...');
        }
    });


 $.ajax({
        type:"POST",
        url: site_url+"activities/load_lastminutecall",
        cache: true,
        success: function(data){
            $("#datahistorylastminutecall").html(data);
        },
        beforeSend: function(){
            $("#datahistorylastminutecall").html('<img src="'+base_url+'/images/loading.gif"/>Loading...');
        }
    });

     

    $("form#form_weekly").submit(function() {
        $.ajax({
            type:"POST",
            url: site_url+"activities/generate_pdf_salescallplan_weekly",
            cache: true,
            data:$('#form_weekly').serialize(),
            dataType:"html",
            success: function(data){

            },
            beforeSend: function(){
 
            }
        });       
    });

    $("#pdfscplan_daily").live('click',function(){
        //alert('asd');
        $("div#daily").toggle();
        //$("div#weekly").hide();
        return false;
    });

    $("#pdfscplan_weekly").live('click',function(){
        //alert('sssss');
        $("div#weekly").show();
        $("div#daily").hide();
    });

    $("#dailydate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    //load data history
    $.ajax({
        type:"POST",
        url: site_url+"sales_call_planning/get_sales_call_planning_by_date",
        cache: true,
        success: function(data){
            $("#datahistsalescall").html(data);
        },
        beforeSend: function(){
            $("#datahistsalescall").html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
        }
    });

    $("#histstartdate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    
    $("#histenddate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    
    $("#histstartdateadmin").datepicker({
        dateFormat:'dd-mm-yy'
    });
    
    $("#histenddateadmin").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("input#histstartdate").change(function(){
        $.ajax({
            type:"POST",
            //url: site_url+"sales_call_planning/get_sales_call_planning_by_date",
            url: site_url+"sales_call_planning/get_salescallplanning_bydetil",
            data:({
                histstartdate:$(this).val(),
                histenddate:$("input#histenddate").val(),
                 sales:$("select#sales").val(),
                 city:$("select#city").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistsalescall').html(data);
            },
            beforeSend: function(){
                $('#datahistsalescall').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#histenddate").change(function(){
        $.ajax({
            type:"POST",
            //url: site_url+"sales_call_planning/get_sales_call_planning_by_date",
            url: site_url+"sales_call_planning/get_salescallplanning_bydetil",
            data:({
                histenddate:$(this).val(),
                histstartdate:$("input#histstartdate").val(),
                sales:$("select#sales").val(),
                city:$("select#city").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistsalescall').html(data);
            },
            beforeSend: function(){
                $('#datahistsalescall').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });


    $("select#sales").change(function(){
        $.ajax({
            type:"POST",
            url: site_url+"sales_call_planning/get_salescallplanning_bydetil",
            data:({
                histenddate:$("input#histenddate").val(),
                histstartdate:$("input#histstartdate").val(),
                sales:$(this).val(),
                city:$("select#city").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistsalescall').html(data);
            },
            beforeSend: function(){
                $('#datahistsalescall').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });
    
       



 $("select#city").change(function(){
        $.ajax({
            type:"POST",
            url: site_url+"sales_call_planning/get_salescallplanning_bydetil",
            data:({
                histenddate:$("input#histenddate").val(),
                histstartdate:$("input#histstartdate").val(),
                sales:$("select#sales").val(),
                city:$(this).val() 
            }),
            dataType:"html",
            success: function(data){
                $('#datahistsalescall').html(data);
            },
            beforeSend: function(){
                $('#datahistsalescall').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });



    //close last minutes sales call
    $("#resultnextcondate").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#resultlastdate").datepicker({
        dateFormat:'dd-mm-yy'
    });
    
    tinyMCE.execCommand('mceAddControl', false, 'resultsalescall');
    
    $("#form_close_last_minutes_call").validationEngine();
    $("form#form_close_last_minutes_call").submit(function() {
        datades = tinyMCE.getInstanceById('resultsalescall');
        if (datades) {
            $("#resultsalescall").val(datades.getContent());
        }
        if (datades.getContent() == '' || datades.getContent() == "<p>&nbsp;</p>") {
            $("#processing").html('Please Insert Task Results.');
        }
        if($("#form_close_last_minutes_call").validationEngine({
            returnIsValid:true
        })){

            $.ajax({
                type:"POST",
                url: site_url+"sales_call_planning/close_save_last_minutes_call",
                cache: true,
                data:$('#form_close_last_minutes_call').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data Has Been Saved.');
                    window.location = site_url +'sales_call_planning'; 
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



    $("form#form_edit_scptelemarketing").validationEngine();
    $("form#form_edit_scptelemarketing").submit(function() {
         
        dataact = tinyMCE.getInstanceById('deskripsi');
        if (dataact) {
            $("#deskripsi").val(dataact.getContent());
        }
        if($("form#form_edit_scptelemarketing").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"sales_call_planning/edit_submit_scp_telemarketing",
                cache: true,
                data:$('#form_edit_scptelemarketing').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'sales_call_planning';
                    $("#processing").html('Data Has Been Saved.');
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



//////FILTER LAST MINUTES CALL/////////////////////
$("#histlastminutestart").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#histlastminuteend").datepicker({
        dateFormat:'dd-mm-yy'
    });

$("input#histlastminutestart").change(function(){
        $.ajax({
            type:"POST",
            //url: site_url+"sales_call_planning/get_sales_call_planning_by_date",
            url: site_url+"activities/get_lastminutecall_bydetil",
            data:({
                histlastminutestart:$(this).val(),
                histlastminuteend:$("input#histlastminuteend").val(),
                saleslastminutecall:$("select#saleslastminutecall").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistorylastminutecall').html(data);
            },
            beforeSend: function(){
                $('#datahistorylastminutecall').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    })

    $("input#histlastminuteend").change(function(){
        $.ajax({
            type:"POST",
            //url: site_url+"sales_call_planning/get_sales_call_planning_by_date",
            url: site_url+"activities/get_lastminutecall_bydetil",
            data:({
                histlastminuteend:$(this).val(),
                histlastminutestart:$("input#histlastminutestart").val(),
                saleslastminutecall:$("select#saleslastminutecall").val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistorylastminutecall').html(data);
            },
            beforeSend: function(){
                $('#datahistorylastminutecall').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });


    $("select#saleslastminutecall").change(function(){
        $.ajax({
            type:"POST",
            url: site_url+"activities/get_lastminutecall_bydetil",
            data:({
                histlastminuteend:$("input#histlastminuteend").val(),
                histlastminutestart:$("input#histlastminutestart").val(),
                saleslastminutecall:$(this).val()
            }),
            dataType:"html",
            success: function(data){
                $('#datahistorylastminutecall').html(data);
            },
            beforeSend: function(){
                $('#datahistorylastminutecall').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
    });

/////END LAST MINUTE CALL//////////////////////////





});