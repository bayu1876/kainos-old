/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {

    $.ajax({
        type:"POST",
        //url:site_url+"company/load_data_account",
        url:site_url+"company/load_company_persalesgroup",
        
        data:({
            halaman:1
        }),
        cache: true,
        success: function(data){
            $('#p'+1).html(data)
        //alert(data);
        },
        beforeSend: function(){
            $('#p'+1).html('<img src="'+base_url+'images/ajax-loader.gif" align="absmiddle">&nbsp;Loading...');
        }
    });




    var totalpage = $('#totalhalaman').val();
    $("#demo5").paginate({
        count: totalpage,
        start: 1,
        display: 20,//totalpage ,
        border: true,
        border_color: '#dddddd',
        text_color: '#3b5998',
        background_color: '#fff',
        border_hover_color: '#dd3c10',
        text_hover_color: '#333333',
        background_hover_color	: '#ffebe8',
        images: false,
        mouse: 'press',
        onChange  : function(page){
            $('._current','#paginationdemo').removeClass('_current').hide();
            $('#p'+page).addClass('_current').show();

            $.ajax({
                type:"POST",
                //url:site_url+"company/paging_company",
                url:site_url+"company/paging_company_persalesgroup",
                data:({
                    halaman:page
                }),
                cache: true,
                success: function(data){
                    $('#p'+page).html(data)
                //alert(data);
                },
                beforeSend: function(){
                    $('#p'+page).html('<img src="'+base_url+'images/ajax-loader.gif" align="absmiddle">&nbsp;Loading...');
                }
            });


        }
    });

});