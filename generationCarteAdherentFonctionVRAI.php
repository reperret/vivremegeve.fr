<?php
function generateCarteUtilisateur($idUtilisateur, $sortie, $numAdherent)
{
	include('connexion.php');
	$nom=NULL;
	$prenom=NULL;
	$dateAdhesion=NULL;
	$numResident=NULL;
	$urlPhoto=NULL;
	$typeAdherent=NULL;
    
	$resultats = $dbh->query('SET NAMES UTF8');
	$resultats = $dbh->query('SELECT * from utilisateur WHERE idUtilisateur='.$idUtilisateur);
	$lignes=$resultats->fetchAll(PDO::FETCH_OBJ);
	
	
	foreach ($lignes as $colonne)
	{  
		$nom=$colonne->nom;
		$prenom=$colonne->prenom;
		$dateAdhesion=$colonne->dateAdhesion;
		$numResident=$colonne->numResident;
		$urlPhoto=$colonne->urlPhoto;
		$typeAdherent=$colonne->typeAdherent;
	}

	$date = new DateTime($dateAdhesion);
	$date->format('y');
	$date->modify('+1 year');
	

    ob_start();

?>


<style type="text/css">
<!--
    div.zone { border: none; border-radius: 6mm; background: #cd1231; border-collapse: collapse; padding:2mm; font-size: 2.7mm;}
    h1 { padding: 0; margin: 0; color: #FFFFFF; font-size: 6mm; font-weight:bold; text-align: center;}
    h2 { padding: 0; margin: 0; color: #FFFFFF; font-size: 4mm; font-weight:bold; position: relative;   text-align: center;}
-->
</style>
<page format="100x100" orientation="L" backcolor="#CCC" style="font: arial;">
    <div style="position: absolute; width: 300; height: 100; left: 10mm; top: 80mm; font-style: italic; font-weight: normal; text-align: left; font-size: 2.8mm;">
       Ceci est votre carte d'adhérent à l'association Vivre Megève. <br>Vous pouvez l'imprimer afin de la présenter le cas échéant à chaque partenaire de l'association Vivre Megève.
    </div>
    <table style="width: 99%;border: none;" cellspacing="4mm" cellpadding="0">
        <tr>
            <td style="width: 100%">
                <div class="zone" style="height: 53mm;position: relative;font-size: 5mm;">
				
					<h1>CARTE D'ADHERENT </h1>
                    <div style="position: absolute; right: 20mm; top: 9mm; text-align: right; font-size: 8mm;  color:#FFF">
                        <img src="images/logoCarte.png" width="200"> 
                    </div>
                    <div style="position: absolute; left: 28mm; top: 25mm; text-align: left; font-size: 5mm; color:#FFF ">
                        <b><?php echo $nom;?></b>
                         
                    </div>
                     <div style="position: absolute; left: 28mm; top: 30mm; text-align: left; font-size: 5mm; color:#FFF ">
                        <i><?php echo $prenom;?></i>
                         
                    </div>
                    
                      <div style="position: absolute; left: 28mm; top: 38mm; text-align: left; font-size: 3mm; color:#FFF ">
                       <b>N° Adhérent :</b> <?php echo $numAdherent;?><br>
                    </div>
                    
                    <div style="position: absolute; left: 28mm; top: 41mm; text-align: left; font-size: 3mm;color:#FFF ">
                       <b>N° Carte résident :</b><br> <?php echo $numResident;?><br>
                    </div>
                    
                    
                     <div style="position: absolute; left: 28mm; top: 49mm; text-align: left; font-size: 3mm; color:#FFF ">
                       <b>Date validité :</b> 31/08/2017<br>
                    </div>
                    
                     <div style="position: absolute; left: 75mm; top: 8mm; text-align: left; font-size: 5mm; color:#FFF ">
                       <?php echo $typeAdherent;?><?php  //echo $date->format('d/m/Y') ;?><br>
                    </div>
                    
                    
                   
                    
                    <div style="position: absolute ; left: 5mm; top: 30%; vertical-align: middle;text-align: center;">
						
						<?php if(file_exists($urlPhoto))
						{ ?>
							<img src="<?php echo $urlPhoto;?>" width="71"> 
							<?php
						}
						else
						{
						?>
							<img src="avatars/silouette.jpg"> 
							<?php
						} ?>
						
                    </div>
                    
                </div>
            </td>
        </tr>
       
    </table>
</page>
<?php
     $content = ob_get_clean();

    // convert
    require_once('html2pdf/html2pdf.class.php');
    try
    {	
		
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
	
		$nomFacture1= time().$idUtilisateur;
		$nomFacture2=$nomFacture1.".pdf";
		
		if($sortie!=NULL && $sortie=="regeneration")
		{
			$html2pdf->Output();
		}
		else
		{
			$html2pdf->Output("cartesGenerees/".$nomFacture2, "F");
		}
		
	
	
    }
    catch(HTML2PDF_exception $e) 
	{
        echo $e;
        exit;
    }

?>
</body>
</html>
<?php
	return $nomFacture2;
}
?>