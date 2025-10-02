/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



 $.ajax({
    type:"POST",
    url: site_url+"beo_letter/loading_data_beo",
    // url: site_url+"beo_letter/loading_data_definit",
    cache: true,
    success: function(data){
        $("#databeoletter").html(data);
    },
    beforeSend: function(){
        $("#databeoletter").html('<img src="'+base_url+'images/loading.gif"/>Loading...');
    }
});

 