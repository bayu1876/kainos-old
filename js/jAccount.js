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
            $.validationEngine.closePrompt('.formError',true);
             $("#processing").html('');
            $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
            $(this).addClass('current'); // Add class "current" to clicked tab
            var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
            $(currentTab).siblings().hide(); // Hide all content divs
            $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
            return false;
        }
        );

    $("form#form_account").validationEngine();
    $("form#form_account").submit(function() {
        if($("#form_account").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"account/add_account",
                cache: false,
                data:$('#form_account').serialize(),
                dataType:"html",
                success: function(data){
                    if(data != ''){
                         $("#processing").html(data);
                    }else{
                         $("#processing").html('1 new data added.');
                    }

                    $("input#industri").val('');
                    $("input#propinsi").val('');
                    $("input#country").val('');
                    $("input#kota").val('');
                    $("input#segment").val('');
                    $("input#companyname").val('');
                    $("input#telp").val('');
                    $("input#fax").val('');
                    $("input#otherphone").val('');
                    $("input#email").val('');
                    $("input#website").val('');
                    $("input#alamat").val('');
                    $("input#kode_pos").val('');
                    $("input#member").val('');
                    window.location = site_url +'contact/add_contact_by_account/'+data;
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });


    $("form#form_edit_account").validationEngine();
    $("form#form_edit_account").submit(function() {
        if($("#form_edit_account").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"account/edit_account",
                cache: false,
                data:$('#form_edit_account').serialize(),
                dataType:"json",
                success: function(){
                    $("#processing").html('');
                    $("input#industri").val('');
                    $("input#country").val('');
                    $("input#propinsi").val('');
                    $("input#kota").val('');
                    $("input#segment").val('');
                    $("input#companyname").val('');
                    $("input#telp").val('');
                    $("input#fax").val('');
                    $("input#otherphone").val('');
                    $("input#email").val('');
                    $("input#website").val('');
                    $("input#alamat").val('');
                    $("input#kode_pos").val('');
                    $("input#member").val('');
                    window.location = site_url +'company';
                },
                beforeSend: function(){
                    $("#processing").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });

//    $.ajax({
//        type:"POST",
//        url: site_url+"company/load_data_account",
//        cache: true,
//        success: function(data){
//            $("#datacompany").html(data);
//        },
//        beforeSend: function(){
//            $("#datacompany").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
//        }
//    });


    $('select#propinsi').live('change', function() {
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
                $('#divcity').html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
    });

    $("input#companyname").keyup(function(){
        $("div#processing").text('');
    })

    //auto complete account(member-parent) untuk account baru//
    //$("input#member").autocomplete(site_url+"account/get_account", {
      $("input#member").autocomplete(site_url+"account/get_account_pergroup", {
        width: 295,
        selectFirst: false
    });

    $('input#member').flushCache();
    $("input#member").result(function(event, data, formatted) {
        if (data){
            $('input#idparent').val(data[1]);
        }//end IF
    });
    //END auto complete account(member-parent) untuk account baru//

    $('input#reset').click(function(){
        $("input#member").val('');
        $('input#idparent').val('');
        $('input#idaccount').val('');
        $('input#idacc').val('');

        return false;
    });

    //untuk reset search account
    $('input#resetaccount').click(function(){
        $("input#accountname").val('');
        $('input#idaccount').val('');
        $('#companysearchdata').html('');
        return false;
    });

    //untuk menampilkan hasil pencarian
    //$("input#accountname").autocomplete(site_url+"account/get_account",  {
    $("input#accountname").autocomplete(site_url+"account/get_account_pergroup",  {
        width: 400,
        selectFirst: false
    });
    
    $('input#accountname').flushCache();
    $("input#accountname").result(function(event, data, formatted) {
        if(data){ 
            $.ajax({
                type:"POST",
                url: site_url+"company/get_details",
                cache: false,
                data:({
                    idaccount:data[1]
                }),
                dataType:"html",
                success: function(data){
                    $('#companysearchdata').html(data);
                },
                beforeSend: function(){
                    $('#companysearchdata').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
        }//end IF
    });
    //end untuk menampilkan hasil pencarian

    $("#birthday").datepicker({
        dateFormat:'dd-mm-yy',
        changeYear:true,
        changeMonth:true
    });

    //ONLY NUMBER
    $("#telp").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            return false;
        }
    //    return false;
    });//END ONLY NUMBER

    //ONLY NUMBER
    $("#fax").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            return false;
        }
    //    return false;
    });//END ONLY NUMBER

    //ONLY NUMBER
    $("#kode_pos").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            return false;
        }
    //    return false;
    });//END ONLY NUMBER


    //ONLY NUMBER
    $("#otherphone").keypress(function(e)
    {
        //if the letter is not digit then display error and don't type anything
        if( e.which!=8 && e.which!=0 && (e.which<48 || e.which>57))
        {
            return false;
        }
    //    return false;
    });//END ONLY NUMBER



$("select#country").change(function(){
    var country = $(this).val();
    $("div#divcity").html('');
   $.ajax({
                type:"POST",
                url: site_url+"company/get_province",
                cache: false,
                data:({
                    idcountry:country
                }),
                dataType:"html",
                success: function(data){
                    $('#containerprovince').html(data);
                },
                beforeSend: function(){
                    $('#containerprovince').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
                }
            });
})


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
            url: site_url+"company/get_company_by_salesindustry",
            data:({
                sales:sales,
                industry:industry
            }),
            dataType:"html",
            success: function(data){
                $('#containercompany').html(data);
            },
            beforeSend: function(){
                $('#containercompany').html('<img src="'+base_url+'/images/ajax-loader.gif"/> ');
            }
        });
})

});
 