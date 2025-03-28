<?php
/**
 * HTML2PDF Library - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2016 Laurent MINGUET
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

    // get the HTML
if(isset($_GET['nb']) && $_GET['nb']!='')
{
    $nbAGenerer=$_GET['nb'];
}
else
{
    $nbAGenerer=30;
}

    ob_start();
    include(dirname(__FILE__).'/res/new2.php');
    $content = ob_get_clean();

    // convert to PDF
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        //$html2pdf->addFont("Roboto", "", "roboto.ttf");
        $html2pdf = new HTML2PDF('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('new.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
