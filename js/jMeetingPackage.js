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
//             $.ajax({
//                type:"POST",
//                url: site_url+"meeting_package/load_data_mpackage",
//                cache: true,
//                success: function(data){
//                    $("#datameetingpackage").html(data);
//                },
//                beforeSend: function(){
//                    $("#datameetingpackage").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
//                }
//            });

            $.ajax({
                type:"POST",
                url: site_url+"meeting_package/load_data_meetingtype",
                cache: false,
                success: function(data){
                    $("#datameetingtype").html(data);
                },
                beforeSend: function(){
                    $("#datameetingtype").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                }
            });

             $.ajax({
                type:"POST",
                url: site_url+"meeting_package/load_data_meetingstruct",
                cache: false,
                success: function(data){
                    $("#datastructurerate").html(data);
                },
                beforeSend: function(){
                    $("#datastructurerate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
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

//    $.ajax({
//        type:"POST",
//        url: site_url+"meeting_package/load_data_mpackage",
//        cache: true,
//        success: function(data){
//            $("#datameetingpackage").html(data);
//        },
//        beforeSend: function(){
//            $("#datameetingpackage").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
//        }
//    });


    $.ajax({
        type:"POST",
        url: site_url+"meeting_package/load_data_meetingtype",
        cache: false,
        success: function(data){
            $("#datameetingtype").html(data);
        },
        beforeSend: function(){
            $("#datameetingtype").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
        }
    });

    $("#form_package_name").validationEngine();
    $("form#form_package_name").submit(function() {         
        if($("#form_package_name").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"meeting_package/add_package_name",
                cache: false,
                data:$('#form_package_name').serialize(),
                dataType:"html",
                success: function(data){
                    //window.location = site_url +'task';
                     $.ajax({
                        type:"POST",
                        url: site_url+"meeting_package/load_data_meetingtype",
                        cache: false,
                        success: function(data){
                            $("#datameetingtype").html(data);
                        },
                        beforeSend: function(){
                            $("#datameetingtype").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
                    
                    
                    $("#processing").html('Data has been saved.'); 
                    $("input#packagecode").val('');
                    $("input#packagename").val('');
                    $("input#meetingcat").val(''); 
                    
                    
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


    $("#form_add_meeting_package").validationEngine();
    $("form#form_add_meeting_package").submit(function() {
        if($("#form_add_meeting_package").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"meeting_package/add_meeting_package",
                cache: false,
                data:$('#form_add_meeting_package').serialize(),
                dataType:"html",
                success: function(data){
                    //window.location = site_url +'meeting_package';
                    $("select#property").val('--Choose--');
//                    $("select#meetingtype").val('--Choose--');
//                    $("select#bedtype").val('--Choose--');
//                    $("select#weektype").val('--Choose--');
//                    $("select#meetingstruct").val('--Choose--');
//                    $("select#roomtype").val('--Choose--');
//                    $("input#cb1").val('');
//                    $("input#cb2").val('');
//                    $("input#cb3").val('');
//                    $("input#lunch").val('');
//                    $("input#dinner").val('');
//                    $("input#roomrates").val('');
//                    $("input#packageprice").val('');
                    
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
        return false;
    });


    $("#form_structure_rate").validationEngine();
    $("form#form_structure_rate").submit(function() {
        if($("#form_structure_rate").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"meeting_package/add_struc_rate",
                cache: false,
                data:$('#form_structure_rate').serialize(),
                dataType:"html",
                success: function(data){
                    //window.location = site_url +'task';
                    alert('Data has been saved');
                    $("#processing").html('Data has been saved.');
                    $("input#strucname").val('');
                    
                     $.ajax({
                        type:"POST",
                        url: site_url+"meeting_package/load_data_meetingstruct",
                        cache: false,
                        success: function(data){
                            $("#datastructurerate").html(data);
                        },
                        beforeSend: function(){
                            $("#datastructurerate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
                        }
                    });
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

    $.ajax({
        type:"POST",
        url: site_url+"meeting_package/load_data_meetingstruct",
        cache: false,
        success: function(data){
            $("#datastructurerate").html(data);
        },
        beforeSend: function(){
            $("#datastructurerate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
        }
    });



    $("select#sortproperty").change(function(){
        var property = $(this).val();
        var packagetype = $("select#sortpackname").val();
        
        $.ajax({
            type:"POST",
            url: site_url+"meeting_package/get_meetingpackage_bydetil",
            cache: false,
            data:({
                property:property,
                packagetype:packagetype
            }),
            success: function(data){
                $("#datameetingpackage").html(data);
            },
            beforeSend: function(){
                $("#datameetingpackage").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
        
    });

     $("select#sortpackname").change(function(){
        var property = $("select#sortproperty").val();
        var packagetype = $(this).val();

        $.ajax({
            type:"POST",
            url: site_url+"meeting_package/get_meetingpackage_bydetil",
            cache: false,
            data:({
                property:property,
                packagetype:packagetype
            }),
            success: function(data){
                $("#datameetingpackage").html(data);
            },
            beforeSend: function(){
                $("#datameetingpackage").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
    })


 $("select#property").change(function(){
        var property = $(this).val();
        $.ajax({
            type:"POST",
            url: site_url+"meeting_package/get_structrate_not_used_on_hotel",
            cache: false,
            data:({
                property:property
            
            }),
            success: function(data){
                $("#refstrucrate").html(data);
            },
            beforeSend: function(){
                $("#refstrucrate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
    });


 $("select#bedtype").change(function(){
        var bedtype = $(this).val();
        var property = $("#property").val();
        $.ajax({
            type:"POST",
            url: site_url+"meeting_package/get_structrate_not_used_on_hotel_bedtype",
            cache: false,
            data:({
                property:property,
                bedtype :bedtype
            
            }),
            success: function(data){
                $("#refstrucrate").html(data);
            },
            beforeSend: function(){
                $("#refstrucrate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
    });
    
    $("select#meetingtype").change(function(){
        var meetingtype = $(this).val();
        var property = $("#property").val();
        var bedtype = $("#bedtype").val();
        $.ajax({
            type:"POST",
            url: site_url+"meeting_package/get_structrate_not_used_on_hotel_bedtype_packagetype",
            cache: false,
            data:({
                property:property,
                bedtype :bedtype,
                meetingtype:meetingtype
            
            }),
            success: function(data){
                $("#refstrucrate").html(data);
            },
            beforeSend: function(){
                $("#refstrucrate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
    });
    
    $("select#roomtype").change(function(){
        var roomtype = $(this).val();
        var property = $("#property").val();
        var meetingtype = $("#meetingtype").val();
        var bedtype = $("#bedtype").val();
        $.ajax({
            type:"POST",
            url: site_url+"meeting_package/get_structrate_not_used_on_hotel_bedtype_packagetype_roomtype",
            cache: false,
            data:({
                property:property,
                bedtype :bedtype,
                meetingtype:meetingtype,
                roomtype:roomtype
            }),
            success: function(data){
                $("#refstrucrate").html(data);
            },
            beforeSend: function(){
                $("#refstrucrate").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
    });


$("#meetingstruct").change(function(){
    var property = $("#property").val();;
    var bedtype = $("#bedtype").val();
    var weektype = $("#weektype").val();
    var packagename = $("#meetingtype").val();
    var roomtype = $("#roomtype").val();
    var struct = $("#meetingstruct").val();
    
        $.ajax({
            type:"POST",
            url: site_url+"meeting_package/check_meetingpackage",
            cache: false,
            data:({
                property:property,
                bedtype:bedtype,
                weektype:weektype,
                meetingpackage:packagename,
                roomtype:roomtype,
                struct:struct
            }),
            success: function(data){
                if(data != '' && data != 'Package has been used.'){
                    $.validationEngine.buildPrompt("#meetingstruct",data,"error");
                  
                }else{
                      $.validationEngine.closePrompt('.formError',true);

                }
                if(data == 'Meeting Package with this Rate\'s structure already exist, please use another Rate\'s Structure.'){
                    $.validationEngine.buildPrompt("#meetingstruct",data,"error");
                      $("#btnsubmitmeetingpackage").hide();
                      $("#processing").html("Please check your Structure Rate.");
                }else{
                    $("#btnsubmitmeetingpackage").show();
                    $("#processing").html("");
                }
        },
            beforeSend: function(){
                $("#datameetingpackage").html('<img src="'+base_url+'/images/ajax-loader.gif"/>Loading...');
            }
        });
})
    
});


 