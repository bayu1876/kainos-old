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

    $('.content-box .content-box-content div.tab-content').hide(); // Hide the content divs
    $('ul.content-box-tabs li a.default-tab').addClass('current'); // Add the class "current" to the default tab
    $('.content-box-content div.default-tab').show(); // Show the div with class "default-tab"

    $('.content-box ul.content-box-tabs li a').click( // When a tab is clicked...
        function() {
            $.ajax({
                type:"POST",
                url: site_url+"contact/load_data_contact",
                cache: false,
                success: function(data){
                    $("#datacontact").html(data);
                },
                beforeSend: function(){
                    $("#datacontact").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
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



    $("#form_contact").validationEngine();
    $("form#form_contact").submit(function() {
        if($("#idacc").val() == ''){
            $.validationEngine.buildPrompt("#idaccount","Please select company from available list","error");
        }else{
        if($("#form_contact").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"contact/add_contact",
                cache: false,
                data:$('#form_contact').serialize(),
                success: function(){
                    $("#processing").html('1 new data added.');
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
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }
        }
        return false;
    });

    $("#form_edit_contact").validationEngine();
    $("form#form_edit_contact").submit(function() {
        if($("#form_edit_contact").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"contact/edit_contact_submit",
                cache: false,
                data:$('#form_edit_contact').serialize(),
                dataType:"json",
                success: function(){
                    window.location = site_url +'contact';
                    $("#processing").html('Contact updated');
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
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });


    $.ajax({
        type:"POST",
        url: site_url+"contact/load_data_contact",
        cache: false,
        success: function(data){
            $("#datacontact").html(data);
        },
        beforeSend: function(){
            $("#datacontact").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
        }
    });


    $("#birthday").datepicker({
        dateFormat:'dd-mm-yy',
        changeYear:true,
        changeMonth:true
    });

    $("#birthday").change(function() {
        $.validationEngine.closePrompt('.formError',true);
    });

    //auto complete account untuk tambah contact//
    //$("#idaccount").autocomplete(site_url+"contact/get_account", {
      $("#idaccount").autocomplete(site_url+"account/get_account_pergroup", {
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
                cache: false,
                data:({
                    idaccount:data[1]
                }),
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
                        cache: false,
                        data:({
                            idpropinsi:data.kodeprop,
                            idkota:data.kodekota
                        }) ,
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
    //END auto complete account untuk tambah contact//

    $('input#reset').click(function(){
        $("input#member").val('');
        $('input#idparent').val('');
        $('input#idaccount').val('');
        $('input#idacc').val('');

        return false;
    });

    $('select#propinsi').live('change', function() {
        //alert('sda');
        $.ajax({
            type:"POST",
            url: site_url+"account/get_city",
            cache: false,
            data:({
                idpropinsi:$(this).val()
                }) ,
            dataType:"html",
            success: function(data){
                $('#divcity').html(data);
            },
            beforeSend: function(){
                $('#divcity').html('<img src="'+base_url+'images/loading.gif"/> Loading...');
            }
        });
    });

    //ONLY NUMBER
    $("#mobile").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            //display error message
            // alert('Plizz deh..., angka aja nape??');
            return false;
        }
    //    return false;
    });//END ONLY NUMBER


    //ONLY NUMBER
    $("#phone_office").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            return false;
        }
    //    return false;
    });//END ONLY NUMBER


    $("#phone_fax").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            return false;
        }
    //    return false;
    });//END ONLY NUMBER


    $("#secretaryphone").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            return false;
        }
    //    return false;
    });//END ONLY NUMBER


    $("#postal_code").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            return false;
        }
    //    return false;
    });//END ONLY NUMBER

    //untuk menampilkan hasil pencarian
    //$("input#contactname").autocomplete(site_url+"contact/get_contact",  {
    $("input#contactname").autocomplete(site_url+"contact/get_contact_pergroup",  {
        width: 400,
        selectFirst: false
    });
    $('input#contactname').flushCache();
    $("input#contactname").result(function(event, data, formatted) {
        if (data){
            $.ajax({
                type:"POST",
                url: site_url+"contact/get_details",
                cache: false,
                data:({
                    idcontact:data[1]
                }),
                dataType:"html",
                success: function(data){
                    $('#contactsearchdata').html(data);
                },
                beforeSend: function(){
                    $('#contactsearchdata').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
        }//end IF
    });
    //end untuk menampilkan hasil pencarian

    //untuk reset search account
    $('input#resetcontact').click(function(){
        $("input#contactname").val('');
        $('input#idcontact').val('');
        $('#contactsearchdata').html('');
        return false;
    });


    $("select#bysales").live('change',function(){
   var sales = $(this).val();
   $.ajax({
            type:"POST",
            url: site_url+"company/get_industry_by_sales",
            data:({
                sales:sales
            }),
            dataType:"html",
            success: function(data){
                $('#containerindustry').html(data);
            },
            beforeSend: function(){
                $('#containerindustry').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });

})

$("select#byindustry").live('change',function(){
    var industry = $(this).val();

})

$('input#byGo').live('click',function(){
    var sales = $("select#bysales").val();
    var industry = $("select#byindustry").val();
     $.ajax({
            type:"POST",
            url: site_url+"contact/get_contact_bysalesindustry",
            data:({
                sales:sales,
                industry:industry
            }),
            dataType:"html",
            success: function(data){
                $('#containerdatacontact').html(data);
            },
            beforeSend: function(){
                $('#containerdatacontact').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
})

});

 