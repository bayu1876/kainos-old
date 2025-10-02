/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function initMCE() {
  tinyMCE.init({
    // General options
    convert_urls : false,
    file_browser_callback : 'myFileBrowser',
//   forced_root_block : false,
//   force_br_newlines : true,
//   force_p_newlines : false,

    mode : "textareas",
    theme : "advanced",
    //plugins : "style,table,advimage,advlink,emotions,iespell,preview,media,contextmenu,paste,directionality,noneditable,advlist",
    plugins : "table,preview",

    // Theme options
    theme_advanced_buttons1 : "undo,redo,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor",
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell",

    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,

    // Example content CSS (should be your site CSS)
    content_css : "css/content.css",

    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js"
  });
}


function myFileBrowser (field_name, url, type, win) {
 
 //url='upload.php';
 //alert("Field_Name: " + field_name + "\nURL: " + url + "\nType: " + type + "\nWin: " + win); // debug/testing
 /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
 the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
 These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */
 var cmsURL = 'upload.php'   ;  // <-------- PERHATIKAN INI !
 if (cmsURL.indexOf("?") < 0) {
 //add the type as the only query parameter
 cmsURL = cmsURL + "?type=" + type;
 }
 else {
 //add the type as an additional query parameter
 // (PHP session ID is now included if there is one at all)
 cmsURL = cmsURL + "&type=" + type;
 }
 tinyMCE.activeEditor.windowManager.open({
 file : cmsURL,
 title : 'My File Browser',
 width : 940,  // Your dimensions may differ - toy around with them!
 height : 400,
 resizable : "yes",
 inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
 close_previous : "no"
 }, {
 window : win,
 input : field_name
 });
 return false;
 }

$(document).ready(function(){
    $("#formuser").validationEngine();
});

