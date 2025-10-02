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
            $("#processing").html('');
            $.validationEngine.closePrompt('.formError',true);
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
                url: site_url+"user/load_data_user",
                cache: true,
                dataType:"html",
                success: function(data){
                    $("#datauser").html(data);
                },
                beforeSend: function(){
                    $("#datauser").html('<img src="'+base_url+'images/WebResource.axd.gif"/> Loading...');
                   // $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Loading...');
                }
            });


    $("form#form_user").validationEngine();
    $("form#form_user").submit(function() {
        if($("form#form_user").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"user/add_user_submit",
                cache: true,
                data:$('#form_user').serialize(),
                dataType:"html",
                success: function(data){
                    $("#processing").html('Data Telah Disimpan.'+data);
                },
                beforeSend: function(){
             $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Simpan...');
                }
            });
        }//end if

        return false;
        });


        $('select#sales').change(function(){
            var val = $(this).val();
            if(val != ''){


            $.ajax({
            type:"POST",
            url: site_url+"user/check_user_avaibility",
            cache: true,
            data:({
                idstaff:val
            }),
            dataType:"html",
            success: function(data){
                if(data == 'yes')
                {
                    $("p#psubmit").hide();
                    $("div#datarole").hide();
                    $("#processing").html('Staff already has user account.');
                }else if(data =='no'){
                    $("p#psubmit").show();
                    $("div#datarole").show();
                    $("#processing").html('');
                }else{
                    $("p#psubmit").hide();
                    $("div#datarole").hide()
                    $("#processing").html('Choose Staff');
                }
            },
            beforeSend: function(){

                $("#processing").html('<img src="'+base_url+'images/loading.gif"/> Simpan...');
            }
            });
            }else{
                    $("p#psubmit").hide();
                    $("div#datarole").hide()
                    $("#processing").html('Choose Staff.');
            }
        })



        $("form#form_edit_user").validationEngine();
    $("form#form_edit_user").submit(function() {
        if($("form#form_edit_user").validationEngine({
            returnIsValid:true
        })){
            $.ajax({
                type:"POST",
                url: site_url+"user/edit_user_submit",
                cache: true,
                data:$('#form_edit_user').serialize(),
                dataType:"html",
                success: function(data){
                    window.location = site_url +'user';
                    $("#processing").html('Data has been updated.'+data);
                },
                beforeSend: function(){
             $("#processing").html('<img src="'+base_url+'images/loading.gif"/> updating...');
                }
            });
        }//end if

        return false;
        });

 });
       
    