/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
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
                url: site_url+"room_night_production_manual/load_rnpmanual_currentmonth",
                
                
                success: function(data){
                    $("#containerrnpsales").html(data);
                },
                beforeSend: function(){
                    $("#containerrnpsales").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
            
            
             $.ajax({
                type:"POST",
                url: site_url+"room_night_production_manual/get_form_pdf",
                
                
                success: function(data){
                    $("#containerprintpdf").html(data);
                },
                beforeSend: function(){
                    $("#containerprintpdf").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
                }
            });
            //$.validationEngine.closePrompt('.formError',true);
            $(this).parent().siblings().find("a").removeClass('current'); // Remove "current" class from all tabs
            $(this).addClass('current'); // Add class "current" to clicked tab
            var currentTab = $(this).attr('href'); // Set variable "currentTab" to the value of href of clicked tab
            $(currentTab).siblings().hide(); // Hide all content divs
            $(currentTab).show(); // Show the content div with the id equal to the id of clicked tab
            return false;
        }
        );
    //end tab 
    
    $("#dateproduction").datepicker({
        dateFormat:'dd-mm-yy'
    });

    //iwn : edit forecast

    $("#ed_dateproduction").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#his_dateproduction_from").datepicker({
        dateFormat:'dd-mm-yy'
    });
    $("#his_dateproduction_to").datepicker({
        dateFormat:'dd-mm-yy'
    });

    $("#ed_formroomnightproductionmanual").submit(function(){
        $.ajax({
            type:"POST",
            url: site_url+"room_night_production_manual/load_roomnight_production_by_datesales",
            data:$(this).serialize(),
            success: function(data){

                $("#containerroomnightproduction").html(data);
            },
            beforeSend: function(){
                $("#containerroomnightproduction").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    $("#his_formroomnightproductionmanual").submit(function(){
        $.ajax({
            type:"POST",
            url: site_url+"room_night_production_manual/load_roomnight_production_by_fromtodatesales",
            data:$(this).serialize(),
            success: function(data){
                $("#containerroomnightproduction_his").html(data);
            },
            beforeSend: function(){
                $("#containerroomnightproduction_his").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })

    //

    //    $("#formroomnightproduction").submit(function(){
    //        $.ajax({
    //            type:"POST",
    //            url: site_url+"room_night_production/get_room_production",
    //                
    //            data:$(this).serialize(),
    //            success: function(data){
    //                $("#containerdatarnp").html(data);
    //            },
    //            beforeSend: function(){
    //                $("#containerdatarnp").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    //            }
    //        });
    //        return false;
    //    })
 
    
    $("#yearprint").live('change',function(){
        var year = $(this).val();
        var month = $("#monthprint").val();
        $.ajax({
            type:"POST",
            url: site_url+"room_night_production_manual/get_roomnightproduction",
            data:({
                month:month,
                year:year
            }),
            success: function(data){
                $("#containerrnpsales").html(data);
            },
            beforeSend: function(){
                $("#containerrnpsales").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })
    
    $("#monthprint").live('change',function(){
        var year = $("#yearprint").val();
        var month = $(this).val();
        $.ajax({
            type:"POST",
            url: site_url+"room_night_production_manual/get_roomnightproduction",
            data:({
                month:month,
                year:year
            }),
            success: function(data){
                $("#containerrnpsales").html(data);
            },
            beforeSend: function(){
                $("#containerrnpsales").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
            }
        });
        return false;
    })
  
    
    
    $(".cloneTableRoomProduction").live('click', function(){
        // this tables id
        var thisTableId = $(this).parents("table").attr("id");

        var txtid =  $('#'+thisTableId + " tr:last  ").attr("id").slice(0,9);
        var numberid = $('#'+thisTableId + " tr:last  ").attr("id").slice(9);
        var new_id = parseInt(numberid) + 1;


        // lastRow
        var lastRow = $('#'+thisTableId + " tr#masterrow1");

        // clone last row
        var newRow = lastRow.clone(true);

        // append row to this table
        
        
        $('#'+thisTableId).append(newRow);

        // make the delete image visible
        $('#'+thisTableId + " tr:last  ").css("display", "");
        $('#'+thisTableId + " tr:last  ").css("visibility", "visible");
        $('#'+thisTableId + " tr:last td:last img").css("visibility", "visible");
        $('#'+thisTableId + " tr:last td:last .cloneTableRoomProduction").css("visibility", "hidden");
        $('#'+thisTableId + " tr:last").addClass('additionalx');
        
       
        $('#'+thisTableId + " tr:last  ").attr("id", txtid+new_id);
        
        // clear the inputs (Optional)
    
        
        $('#'+thisTableId + " tr:last td :input").attr('readonly','readonly');

        $('#'+thisTableId + " tr#masterrow1 td :input").val('');
        $('#'+thisTableId + " tr#masterrow1 td .containercontact").html('Please select company first.');
      

        //new rows datepicker need to be re-initialized
        $(newRow).find("input").each(function(){
            if($(this).hasClass("company")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var txtid1 = this_id1.slice(0,7);
                var numberid1 = this_id1.slice(7);
                var new_id1 = parseInt(numberid1) + 1;
                // a new id
                $(this).attr("id", txtid1+new_id1); // change to new id
               
            //  $(this).val('');
            }
            
            if($(this).hasClass("totalroom")){ // if the current input has the hasDatpicker class
                var this_id2 = $(this).attr("id"); // current inputs id
                var txtid2 = this_id2.slice(0,10);
                var numberid2 = this_id2.slice(10);
                var new_id2 = parseInt(numberid2) + 1;
                // a new id
                $(this).attr("id", txtid2+new_id2); // change to new id
            //  $(this).val('');
            }
            
            if($(this).hasClass("revenue")){ // if the current input has the hasDatpicker class
                var this_id3 = $(this).attr("id"); // current inputs id
                var txtid3 = this_id3.slice(0,8);
                var numberid3 = this_id3.slice(8);
                var new_id3 = parseInt(numberid3) + 1;
                // a new id
                $(this).attr("id", txtid3+new_id3); // change to new id
            //  $(this).val('');
            }
            
            
             if($(this).hasClass("rate")){ // if the current input has the hasDatpicker class
                var this_id6 = $(this).attr("id"); // current inputs id
                var txtid6 = this_id6.slice(0,5);
                var numberid6 = this_id6.slice(5);
                var new_id6 = parseInt(numberid6) + 1;
                // a new id
                $(this).attr("id", txtid6+new_id6); // change to new id
            //  $(this).val('');
            }
            
            
            if($(this).hasClass("contactid")){ // if the current input has the hasDatpicker class
                var this_id4 = $(this).attr("id"); // current inputs id
                var txtid4 = this_id4.slice(0,10);
                var numberid4 = this_id4.slice(10);
                var new_id4 = parseInt(numberid4) + 1;
                // a new id
                $(this).attr("id", txtid4+new_id4); // change to new id
               
            //  $(this).val('');
            }
            
            if($(this).hasClass("contactname")){ // if the current input has the hasDatpicker class
                var this_id5 = $(this).attr("id"); // current inputs id
                var txtid5 = this_id5.slice(0,12);
                var numberid5 = this_id5.slice(12);
                var new_id5 = parseInt(numberid5) + 1;
                // a new id
                
                $(this).attr("id", txtid5+new_id5); // change to new id
                $(this).css("visibility","visible");
            //  $(this).val('');
            }
            
         
        });
        
        $(newRow).find("input").each(function(){
            if($(this).hasClass("company")){ // if the current input has the hasDatpicker class
                var this_id1 = $(this).attr("id"); // current inputs id
                var txtid1 = this_id1.slice(0,8);
                var numberid1 = this_id1.slice(8);
                var new_id1 = parseInt(numberid1) + 1;
                // a new id
                $(this).attr("id", txtid1+new_id1); // change to new id
                // $(this).val('');
            }
        })
        
        $(newRow).find("div").each(function(){
            if($(this).hasClass("containercontact")){ // if the current input has the hasDatpicker class
                var this_id3 = $(this).attr("id"); // current inputs id
                var txtid3 = this_id3.slice(0,17);
                var numberid3 = this_id3.slice(17);
                var new_id3 = parseInt(numberid3) + 1;
                // a new id
                $(this).attr("id", txtid3+new_id3); // change to new id
                $(this).remove();
            }
        });
        return false;
    });
    //END CLONE TABLE MASTER ADDITIONAL

    // Delete a table row
    $("img.delRow").click(function(){
        $(this).parents("tr").remove();
        return false;
    });
    
    
    
     
    $(".contactradio").live('change',function(){
        var idcontact = $(this).attr('id');
        var idnumber = $(this).parent('div').attr('id').slice(17);
        $.ajax({
            type:"POST",
            url: site_url+"room_night_production_manual/get_contact_by_idcontact",
            cache: false,
            data:({
                idcontact:idcontact
            }),
            dataType:"html",
            success: function(data){
                $("#contactname-"+idnumber).val(data);
                $("#contactid-"+idnumber).val(idcontact);
            },
            beforeSend: function(){

            }
        });
        return false;
    })
    
    $("#formroomnightproductionmanual").submit(function(){
        $.ajax({
            type:"POST",
            url: site_url+"room_night_production_manual/submit_rnp_manual",
            data:$(this).serialize(),
            dataType:"html",
            success: function(data){
                $("#containerresult").html(data);
                $(".additionalx").remove();

        $("tr#masterrow1 td :input").val('');
        $("tr#masterrow1 td .containercontact").html('Please select company first.');
        $("#containerresult").html('Insert Success.');

            },
            beforeSend: function(){
                $("#containerresult").html('Processing..');
            }
        });
        return false;
    })
    
    
     
     
     
//      $("#company1").autocomplete({
//        minLength: 0,
//        source:function(req,add){
//            $.ajax({
//                url: site_url+ "account/get_account_new" ,
//                dataType: 'json',
//                type:'POST',
//                data:req,
//                success:function(data){
//                    $("#processing").html('');
//                    add($.ui.autocomplete.filter(data.message, extractLast(req.term )));
//                    term: extractLast(req.term)
//                },
//                beforeSend: function(){
//                    $("#processing").html('<img src="'+base_url+'images/ui-lightness/ui-anim_basic_16x16.gif"/>');
//                },
//                error:function(XMLHttpRequest){
//                    alert(XMLHttpRequest.responseText);
//                }
//            })
//        },
//        focus: function() {
//            // prevent value inserted on focus
//            return false;
//        },
//        select: function( event, ui ) {
//            var id = $(this).attr('id').slice(7);
//            var idcompany = ui.item.value;
//            var companyname = ui.item.label;
//            $.ajax({
//                type:"POST",
//                url: site_url+"room_night_production_manual/get_contact",
//                cache: false,
//                data:({
//                    idcompany:idcompany
//                }),
//                dataType:"html",
//                success: function(data){
//                    $("#containercontact-"+id).html(data);
//                },
//                beforeSend: function(){
//
//                }
//            });
//            // $('input#idacc').val(idcompany);
//            $(this).val(companyname);
//            return false;
//        }
//    })
//    
    
    
    $("#company1").autocomplete(site_url+"room_night_production_manual/get_account_autocomplete", {
        width: 198,
        selectFirst: false
    });

    $('input#company1').flushCache();


    $("#company1").result(function(event, data, formatted) {
        if (data){
            var id = $(this).attr('id').slice(7);
            $.ajax({
                type:"POST",
                cache: false,
                url: site_url+"room_night_production_manual/get_contact",
                data:({
                    idcompany:data[1]
                    }),
                dataType:"html",
                success: function(data){
                    $("#containercontact-"+id).html(data);
                },
                beforeSend: function(){
                   
                }
            });
        }//end IF
    });
    
    function split( val ) {
        return val.split( /,\s*/ );
    }

    function extractLast( term ) {
        return split( term ).pop();
    }
    
    
    
    
    
    $("input.totalroom").live('keyup',function(){
     
        var this_id = $(this).attr('id').slice(10);
     
        var totalroom = $(this).val();
        var rate = $("input.rate[id^='rate-"+this_id+"']").val();
       

        var total = parseInt(totalroom) * parseInt(rate.replace(/\,/g,'')); 
        if(isNaN(total)){
            $("input.revenue[id^='revenue-"+this_id+"']").val("");
        }else{
            $("input.revenue[id^='revenue-"+this_id+"']").val(addCommas(total));
        }
        
         
    });
    
    
     $("input.rate").live('keyup',function(){
     
        var this_id = $(this).attr('id').slice(5);
     
        var totalroom = $("input.totalroom[id^='totalroom-"+this_id+"']").val();
        var rate = $(this).val();
       

        var total = parseInt(totalroom) * parseInt(rate.replace(/\,/g,'')); 
        if(isNaN(total)){
            $("input.revenue[id^='revenue-"+this_id+"']").val("");
        }else{
            $("input.revenue[id^='revenue-"+this_id+"']").val(addCommas(total));
        }
        
         
    });
    
    function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
    
})