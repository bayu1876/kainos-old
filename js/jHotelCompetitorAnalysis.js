/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


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
            $.validationEngine.closePrompt('.formError',true);
            $("#processing2").html('');

             $("#resultforecast").html('');
            ////////////////
            $.ajax({
                type:"POST",
                url: site_url+"hotel_competitor_analysis/load_budget_property",
                cache: false,
                dataType:"html",
                success: function(data){
                    $("#containerdatabudget").html(data);
                },
                beforeSend: function(){
                    $("#containerdatabudget").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });

            $.ajax({
                type:"POST",
                url: site_url+"hotel_competitor_analysis/load_propertyforecast",
                cache: false,
                dataType:"html",
                success: function(data){
                    $("#containerforecast").html(data);
                },
                beforeSend: function(){
                    $("#containerforecast").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
            ////////////////


            $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
            $(this).addClass('current'); // Add class "current" to clicked tab
            var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
            $(currentTab).siblings().hide(); // Hide all content divs
            $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
            return false;
        }
        );

    $("form#form_account").validationEngine();
    $("#form_htl_comp_analysis").validationEngine();
    $("#form_initial_balance").validationEngine();
    $("#formforecast").validationEngine();

    $("#formadd_hotelcompanalysis_perhotel").validationEngine();

    $('.add').click(function(){
        var id = $(this).attr('id').substr(3, 1);
        //$('#idaccount'+id).clone(true).insertAfter(this);
        //alert($(newacc).attr('class'));
        var accname = $('#account'+id).val();
        $('#idaccount'+id).clone(true).appendTo($("#containergroup"+id));
        $('#containergroup'+id).append(accname+'');
        //        var clon = $('#idaccount'+id).clone(true);
        //        $("#listgroup"+id).append("<li>"+$(clon).append+"</li>");
        return false;
    })
      
 
    function split( val ) {
        return val.split( /,\s*/ );
    }
    
    function extractLast( term ) {
        return split( term ).pop();
    }
 

    $(".account").autocomplete({
        minLength: 0,
        source:function(req,add){
            $.ajax({
                url: site_url+ "account/search_account" ,
                dataType: 'json',
                type:'POST',
                data:req,
                success:function(data){

                    //if(data.response = 'true'){
                    // add(data.message);
                    add( $.ui.autocomplete.filter(
                        data.message, extractLast( req.term ) ) );
                        term: extractLast( req.term )

                //}
                },
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
        },
        search: function() {
            // custom minLength
            var term = extractLast(this.value);
            if ( term.length < 1 ) {
                return false;
            }
        },

        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
            var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.label );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( ", " );
            //$('.idaccount').val(ui.item.value);

            var id = $(this).attr('id').substr(7);
             
            var totalitem = $('#totalitem'+id).val();
            var newid = (id*100) +totalitem;
            
            var htlcomp = $("#htlcomp"+id).val();
            
            var newclone = $('#idaccount'+id).clone(true);
            newclone.attr('id',"idaccount"+newid);
            newclone.attr('name',"idgroup["+htlcomp+"][]");
            newclone.val(ui.item.value);
            //newclone.appendTo($("#containergroup"+id))
            $("#containergroup"+id+" ul").append("<li id='"+newid+"'>"+ui.item.label+", <b>RNO :</b> <input type='text' style='height:10px' name='rno["+htlcomp+"][]' size='1'/>  <a href='' class='remove' id='rem"+newid+"'> <img alt='' src='../images/icon_delete.gif'/></a></li>" );
            // $('#containergroup'+id).append("" );
            newclone.appendTo($("#"+newid));
            $('#totalitem'+id).val(parseInt(totalitem) + 1);
            $(this).val('');
            return false;
        }
    })
            


    $(".accountperhotel1").autocomplete({
        minLength: 0,
        source:function(req,add){
            $.ajax({
                url: site_url+ "account/search_account" ,
                dataType: 'json',
                type:'POST',
                data:req,
                success:function(data){
                    //if(data.response = 'true'){
                    // add(data.message);
                    add( $.ui.autocomplete.filter(
                    data.message, extractLast( req.term ) ) );
                    term: extractLast( req.term )
                //}
                },
                error:function(XMLHttpRequest){
                    alert(XMLHttpRequest.responseText);
                }
            })
        },
        search: function() {
            // custom minLength
            var term = extractLast(this.value);
            if ( term.length < 1 ) {
                return false;
            }
        },

        focus: function() {
            // prevent value inserted on focus
            return false;
        },
        select: function( event, ui ) {
           var terms = split( this.value );
            // remove the current input
            terms.pop();
            // add the selected item
            terms.push( ui.item.label );
            // add placeholder to get the comma-and-space at the end
            terms.push( "" );
            this.value = terms.join( ", " );
            //$('.idaccount').val(ui.item.value);

            var id = $(this).attr('id').substr(15);

            var totalitem = $('#totalitemperhotel'+id).val();
            var newid = (id*100) +totalitem;

            var htlcomp = $("#hotelcompperhotel").val();

            var newclone = $('#idaccountperhotel'+id).clone(true);
            newclone.attr('id',"idaccountperhotel"+newid);
            newclone.attr('name',"idgroupperhotel["+htlcomp+"][]");
            newclone.val(ui.item.value);
            //newclone.appendTo($("#containergroup"+id))
            $("#containergroupperhotel"+id+" ul").append("<li id='"+newid+"'>"+ui.item.label+", <b>RNO :</b> <input type='text' style='height:10px' name='rno["+htlcomp+"][]' size='1'/>  <a href='' class='remove' id='rem"+newid+"'> <img alt='' src='../images/icon_delete.gif'/></a></li>" );
            // $('#containergroup'+id).append("" );
            newclone.appendTo($("#"+newid));
            $('#totalitemperhotel'+id).val(parseInt(totalitem) + 1);
            $(this).val('');
            return false;
        }
    })
            


    $(".remove").live('click',function(){
        //    alert($(this).attr('id').substr(3));

        var id = $(this).attr('id').substr(3);
        // $("#idaccount")
        //alert($("#idaccount"+id).val());
        $(this).parents('li').remove();
        return false;
    })

    $("#tglhca").datepicker({
        dateFormat:'dd-mm-yy' ,
        onClose: function(dateText, inst) {
            $.ajax({
                type:"POST",
                url: site_url+"hotel_competitor_analysis/get_hotelcomp_perdate",
                data:({
                    date:dateText
                }),
                success: function(data){
                    $("#containerdata").html(data);
                },
                beforeSend: function(){
                    $("#containerdata").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
        }

    });


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



    $("form#form_account").submit(function() {
        if($("#form_account").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"hotel_competitor_analysis/add_group",
                cache: false,
                data:$('#form_account').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing2").html(data);
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
                //window.location = site_url +'contact/add_contact_by_account/'+data;
                },
                beforeSend: function(){
                    $("#processing2").html('<img src="'+base_url+'images/loading.gif"/>Processing...');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });



    $("#perdate").datepicker({
        dateFormat:'dd-mm-yy',
        onSelect: function(dateText, inst) {
            $.validationEngine.closePrompt('#perdate' );
        }

    });

     $("#dateperhotel").datepicker({
        dateFormat:'dd-mm-yy',
        onSelect: function(dateText, inst) {
            $.validationEngine.closePrompt('#dateperhotel' );
        }

    });


    $("form#formbudgetproperty").submit(function() {
        if($("#formbudgetproperty").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"hotel_competitor_analysis/add_budgethcaproperty",
                cache: false,
                data:$('#formbudgetproperty').serialize(),
                dataType:"html",
                success: function(data){
                    //window.location = site_url +'contact/add_contact_by_account/'+data;
                    $("#resultbudgetprop").html(data);
                },
                beforeSend: function(){
                    $("#resultbudgetprop").html('<img src="'+base_url+'images/loading.gif"/>');
                }
            });
            $.validationEngine.closePrompt('.formError',true);
        }else{
        //alert('gagal');
        }
        return false;
    });



$("form#formforecast").submit(function() {
        if($("#formforecast").validationEngine({returnIsValid:true})){
            $.ajax({
                type:"POST",
                url: site_url+"hotel_competitor_analysis/add_forecast",
                cache: false,
                data:$('#formforecast').serialize(),
                dataType:"html",
                success: function(data){
                    $("#resultforecast").html(data);
                },
                beforeSend: function(){
                    $("#resultforecast").html('<img src="'+base_url+'images/loading.gif"/>');
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
        url: site_url+"hotel_competitor_analysis/load_budget_property",
        cache: false,
        dataType:"html",
        success: function(data){
            $("#containerdatabudget").html(data);
        },
        beforeSend: function(){
            $("#containerdatabudget").html('<img src="'+base_url+'images/loading.gif"/>');
        }
    });



    $("#budgetbyprop").change(function(){
        var prop = $(this).val();
        var year = $("#budgetbyyear").val();
        $.ajax({
            type:"POST",
            url: site_url+"hotel_competitor_analysis/get_budgetproperty_detail",
            cache: false,
            data:({property:prop,year:year}),
            dataType:"html",
            success: function(data){
                $("#containerdatabudget").html(data);
            },
            beforeSend: function(){
                $("#containerdatabudget").html('<img src="'+base_url+'images/loading.gif"/>');
            }
        });
    })

    $("#budgetbyyear").change(function(){
        var prop = $("#budgetbyprop").val();
        var year = $(this).val();
        $.ajax({
            type:"POST",
            url: site_url+"hotel_competitor_analysis/get_budgetproperty_detail",
            cache: false,
            data:({property:prop,year:year}),
            dataType:"html",
            success: function(data){
                $("#containerdatabudget").html(data);
            },
            beforeSend: function(){
                $("#containerdatabudget").html('<img src="'+base_url+'images/loading.gif"/>');
            }
        });
    })

    $("#deactivated").live('click',function(){
        var year = $("#yearactivated").val();
        var property = $("#propertyactivated").val();
        $.ajax({
            type:"POST",
            url: site_url+"hotel_competitor_analysis/deactivated_budgetproperty",
            cache: false,
            data:({property:property,year:year}),
            dataType:"html",
            success: function(data){
                $("#containerdatabudget").html(data);
            },
            beforeSend: function(){
                $("#containerdatabudget").html('<img src="'+base_url+'images/loading.gif"/>');
            }
        });
        return false;
    })

    $("#activated").live('click',function(){
        var year = $("#yearactivated").val();
        var property = $("#propertyactivated").val();
         $.ajax({
            type:"POST",
            url: site_url+"hotel_competitor_analysis/activated_budgetproperty",
            cache: false,
            data:({property:property,year:year}),
            dataType:"html",
            success: function(data){
                $("#containerdatabudget").html(data);
            },
            beforeSend: function(){
                $("#containerdatabudget").html('<img src="'+base_url+'images/loading.gif"/>');
            }
        });
        return false;
    })
});