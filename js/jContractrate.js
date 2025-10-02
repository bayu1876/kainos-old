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
                url: site_url+"contract_rate/load_data_contract_rate",
                cache: false,
                success: function(data){
                    $("#datacontract").html(data);
                },
                beforeSend: function(){
                    $("#datacontract").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
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

 
    $("#namaaccount").autocomplete({
        minLength: 2,
        source:function(req,add){
            $.ajax({
                url: site_url+ "account/get_account_new" ,
                dataType: 'json',
                type:'POST',
                data:req,
                success:function(data){
                    $("#processing").html('');
                    add($.ui.autocomplete.filter(data.message, extractLast(req.term )));
                        term: extractLast(req.term)
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/ui-lightness/ui-anim_basic_16x16.gif"/>');
                },
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
            var idcompany = ui.item.value;
            var companyname = ui.item.label;
            $.ajax({
                type:"POST",
                url: site_url+"contract_rate/check_contract",
                cache: false,
                data:({
                    idaccount:idcompany
                }),
                dataType:"html",
                success: function(data){

                    if(data == 'Yes'){
                        alert('This account already has contract rate');
                        $("select#rate_structure").attr('disabled','disabled');
                    }else{
                        $("select#rate_structure").attr('disabled','');
                    }
                            
                },
                beforeSend: function(){

                }
            });
          
            $('input#idacc').val(idcompany);
            $(this).val(companyname);
            return false;
        }
    })
    
    
    
    
    
    $("#searchgroup").autocomplete({
        minLength: 2,
        source:function(req,add){
            $.ajax({
                url: site_url+ "account/get_account_new" ,
                dataType: 'json',
                type:'POST',
                data:req,
                success:function(data){
                    $("#processing").html('');
                    add($.ui.autocomplete.filter(data.message, extractLast(req.term )));
                        term: extractLast(req.term)
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/ui-lightness/ui-anim_basic_16x16.gif"/>');
                },
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
            var idcompany = ui.item.value;
            var companyname = ui.item.label;
          
            $.ajax({
                type:"POST",
                url: site_url+"contract_rate/get_group_detail",
                cache: false,
                data:({
                    idaccount:idcompany
                }),
                dataType:"html",
                success: function(data){
                    $("#datacontract").html(data);
                },
                beforeSend: function(){

                }
            });
          
            $('input#idacc').val(idcompany);
            $(this).val(companyname);
            return false;
        }
    })
    
    
    
    $("#companynamekuta").autocomplete({
        minLength: 2,
        source:function(req,add){
            $.ajax({
                url: site_url+ "account/get_account_new" ,
                dataType: 'json',
                type:'POST',
                data:req,
                success:function(data){
                    $("#processing").html('');
                    add($.ui.autocomplete.filter(data.message, extractLast(req.term )));
                        term: extractLast(req.term)
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/ui-lightness/ui-anim_basic_16x16.gif"/>');
                },
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
        },
        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
            var idcompany = ui.item.value;
            var companyname = ui.item.label;
            
            $("#companyxxx").html(companyname);
            $.ajax({
                type:"POST",
                url: site_url+"account/get_contact",
                cache: false,
                data:({
                    idcompany:idcompany
                }),
                dataType:"html",
                success: function(data){
                    $("#containercontact").html(data);
                         
                },
                beforeSend: function(){

                }
            });
          
         
            $(this).val(companyname);
            return false;
        }
    })

    function split( val ) {
        return val.split( /,\s*/ );
    }

    function extractLast( term ) {
        return split( term ).pop();
    }

  
    $(".contactperson").live('click',function(){
        var idcontact = $(this).attr('id');
    
        $.ajax({
            type:"POST",
            url: site_url+"account/get_contact_detail",
            cache: false,
            data:({
                idcontact:idcontact
            }),
            dataType:"json",
            success: function(data){
                $("#contactaddress").html(data.address);
                $("#contactphone").html(data.phone);
                $("#contactfax").html(data.fax);
                $("#hpcontact").html(data.mobile);
                $('#spancontact').html(data.salutation+' '+data.firstname+' '+data.lastname);
                $("#spansales").html(data.salesfirstname+' '+data.saleslastname);
                $("#spansalesposition").html(data.salesposition);
            },
            beforeSend: function(){

            }
        });
          
    })

     

    $("#form_contract_rate").validationEngine();
    $("form#form_contract_rate").submit(function() {
        var idacc = $("input#idacc").val();
        if($("#idacc").val() == ''){
            $.validationEngine.buildPrompt("#namaaccount","Please select company from available list","error");
        }else{
            if($("#form_contract_rate").validationEngine({
                returnIsValid:true
            })){
                $.ajax({
                    type:"POST",
                    url: site_url+"contract_rate/add_contract",
                    cache: false,
                    data:$('#form_contract_rate').serialize(),
                   
                    success: function(data){
                        $("#processing").html(data);
                    },
                    beforeSend: function(){
                        $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                    }
                });
                $.validationEngine.closePrompt('.formError',true);
            }else{
        //alert('gagal');
        }//End form_contract_rate

        }
        return false;
    });
    
    
    $("#form_renewal_contractrate").validationEngine();
    $("form#form_renewal_contractrate").submit(function() {
        var idacc = $("input#idacc").val();
        if($("#idacc").val() == ''){
            $.validationEngine.buildPrompt("#namaaccount","Please select company from available list","error");
        }else{
            if($("#form_renewal_contractrate").validationEngine({
                returnIsValid:true
            })){
                $.ajax({
                    type:"POST",
                    url: site_url+"contract_rate/submit_renew_contract",
                    cache: false,
                    data:$('#form_renewal_contractrate').serialize(),
                   
                    success: function(data){
                        $("#processing").html(data);
                    },
                    beforeSend: function(){
                        $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                    }
                });
                $.validationEngine.closePrompt('.formError',true);
            }else{
        //alert('gagal');
        }//End form_contract_rate

        }
        return false;
    });


    $.ajax({
        type:"POST",
        url: site_url+"contract_rate/load_data_contract_rate",
        cache: false,
        success: function(data){
            $("#datacontract").html(data);
        },
        beforeSend: function(){
            $("#datacontract").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });


   

    $('input#reset').click(function(){
        $("input#namaaccount").val('');
        $('input#idacc').val('');
        $("select#rate_structure").val('-- Choose Rate Structure --');
        return false;
    });


    //    $("input.contactperson").change(function(){
    //        var val = $(this).val();
    //        $.ajax({
    //              type:"POST",
    //              url: site_url+"contract_rate/get_detil_contact",
    //              cache: false,
    //              data:({contact:val}),
    //              dataType:"html",
    //              success: function(data){
    //                $("#detilcontact").html(data);
    //             },
    //               beforeSend: function(){
    //                $("#detilcontact").html('<img src="'+base_url+'images/loading.gif"/>');
    //               }
    //            });
    //
    //          $.ajax({
    //              type:"POST",
    //              url: site_url+"contract_rate/get_detil_contact2",
    //              cache: false,
    //              data:({contact:val}),
    //              dataType:"html",
    //              success: function(data){
    //                $("#divcontact").html(data);
    //              },
    //              beforeSend: function(){
    //                $("#divcontact").html('<img src="'+base_url+'images/loading.gif"/>');
    //              }
    //            });
    //    })





    $("#namaaccount").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if(e.which == 8){
            $("input#idacc").val('');
               
        }
        return true;
    
    });

 
    $("#searchgroup").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if(e.which == 8){
            $("input#idacc").val('');

        }
        return true;

    });


    $("#myTable").tablesorter();



    $("#btnreset").click(function(){
        $("#searchgroup").val('');
        $.ajax({
            type:"POST",
            url: site_url+"contract_rate/load_data_contract_rate",
            cache: false,
            success: function(data){
                $("#datacontract").html(data);
            },
            beforeSend: function(){
                $("#datacontract").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })



$("#rate_structure").change(function(){
    $.ajax({
            type:"POST",
            url: site_url+"contract_rate/get_rate_structure",
            cache: false,
            data:({idkatrate:$(this).val()}),
            success: function(data){
                $("#dialogratestructure").html(data);
                $("#dialogratestructure").dialog({position:['top',100],width:500,title:'Rate Structure'});
            },
            beforeSend: function(){
               // $("#dialogratestructure").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
    return false;
});
});