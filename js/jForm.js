/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
   
    $('a[rel*=facebox]').facebox();
     $("form#form_sales").submit(function() {
           $.ajax({
              type:"POST",
              url: site_url+"sales/add_sales",
              cache: true,
              data:$('#form_sales').serialize(),
              dataType:"json",
              success: function(data){

                $("#processing").hide();
              },
               beforeSend: function(){
                //$("#email").val("simpan.....");
                $("#processing").show();
               }
            });

	return false;
     });

     $("form#form_jabatan").submit(function() {
           $.ajax({
              type:"POST",
              url: site_url+"jabatan/add_jabatan",
              cache: true,
              data:$('#form_jabatan').serialize(),
              dataType:"json",
              success: function(data){

                $("#processing").hide();
              },
               beforeSend: function(){

                $("#processing").show();
               }
            });
 
	return false;
     });

     $("a.hapus_user").live('click', function(e) {
        //$(this).parent().parent().remove();
        e.preventDefault();
        var id = this.id;
        $.ajax({
              type:"POST",
              url: site_url+"admin_room/delete_user/"+id,
              cache: true,
              success: function(){
                 $("#table_body #"+id).remove();
                 $("#deleting").hide();
              },
               beforeSend: function(){
                //$("#email").val("simpan.....");
                $("#deleting").show();
               }
            });
     });

     $("a.edit_user").live('click', function(e) {
        //$(this).parent().parent().remove();
        e.preventDefault();
        var id = this.id;
            jQuery.facebox({ ajax: site_url+"admin_room/edit_user/"+id })
     });


     $("a.hapus_kategori").live('click', function(e) {
        //$(this).parent().parent().remove();
        e.preventDefault();
        var id = this.id;
        $.ajax({
              type:"POST",
              url: site_url+"admin_room/delete_kategori/"+id,
              cache: true,
              success: function(){
                 $("#table_body #"+id).remove();
                 $("#deleting").hide();
              },
               beforeSend: function(){
                $("#deleting").show();
               }
            });
     });

     $("a.edit_kategori").live('click', function(e) {
        e.preventDefault();
        var id = this.id;
            jQuery.facebox({ ajax: site_url+"admin_room/edit_kategori/"+id })
     });


});//end document ready

