<?php
/**
 * HTML2PDF Librairy - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @author      Laurent MINGUET <webmaster@html2pdf.fr>
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */
    // get the HTML

    ob_start();
    $num = 'CMD01-'.date('ymd');
    $nom = 'PERRET Rémy';
    $date = '01/01/2012';
?>


<style type="text/css">
<!--
    div.zone { border: none; border-radius: 6mm; background: #FFFFFF; border-collapse: collapse; padding:2mm; font-size: 2.7mm;}
    h1 { padding: 0; margin: 0; color: #CC0033; font-size: 7mm; text-align: center;}
    h2 { padding: 0; margin: 0; color: #222222; font-size: 5mm; position: relative;   text-align: center;}
-->
</style>
<page format="100x100" orientation="L" backcolor="#CCC" style="font: arial;">
    <div style="position: absolute; width: 300; height: 100; left: 10mm; top: 80mm; font-style: italic; font-weight: normal; text-align: left; font-size: 2.8mm;">
       Ceci est votre carte d'adhérent à l'association Vivre Megève. <br>Vous devez imprimer cette carte et la présenter à chaque partenaire de l'association Vivre Megève
    </div>
    <table style="width: 99%;border: none;" cellspacing="4mm" cellpadding="0">
        <tr>
            <td style="width: 100%">
                <div class="zone" style="height: 53mm;position: relative;font-size: 5mm;">
				
					<h1>CARTE D'ADHERENT </h1>
                    <div style="position: absolute; right: 10mm; top: 9mm; text-align: right; font-size: 6mm; ">
                        <b>VIVRE MEGEVE</b><br>
                    </div>
                    <div style="position: absolute; left: 35mm; top: 25mm; text-align: left; font-size: 4mm; ">
                        <b>PERRET Rémy</b><br>
                        <b>Date Naissance :</b> 24/08/1989<br>
                        <b>N° Adhérent : </b>4878984<br>
                         <b>Date validité :</b> 08/10/2015<br>
                    </div>
                    
                    <div style="position: absolute ; left: 5mm; top: 25%; vertical-align: middle;text-align: center;">
						<img src="ALLARD_Geraldine (2).JPG">
                    </div>
                    
                </div>
            </td>
        </tr>
       
    </table>
</page>
<?php
     $content = ob_get_clean();

    // convert
    require_once(dirname(__FILE__).'/../html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('ticket.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }

