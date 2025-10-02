<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename, $stream=TRUE)
{
    require_once("dompdf06/dompdf_config.inc.php");
    //require_once("ConvertCharset/ConvertCharset.class.php");
    //spl_autoload_register('DOMPDF_autoload');
    $dompdf = new DOMPDF();
    $dompdf->set_paper("legal", "portrait");
    //$html = '<html><body><p>Put your html here, or generate it with your favourite templating system.</p></body></html>';


    $dompdf->load_html($html);
    //$pdf = $dompdf->output();
    $dompdf->render();

    
    $dompdf->stream($filename.".pdf",array("Attachment" => 1));
 
        

}

?>
