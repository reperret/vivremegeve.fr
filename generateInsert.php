<?php 
        require_once("phpexcel/Classes/PHPExcel/IOFactory.php");

        $document_excel = PHPExcel_IOFactory::load("ListingRegion.xlsx");
        $feuille = $document_excel->getSheet(0);
        
        $tab=array();

        $first=true;

        echo "DELETE FROM T_REF_PROFESSIONNEL_POPULATION WHERE POP_IDPOPULATION LIKE 'MSP%'"; echo "<br>";
        echo "DELETE FROM T_REF_POPULATION  WHERE POP_CATEGORIE LIKE 'MSP%'"; echo "<br><br><br>";
        foreach($feuille->getRowIterator() as $ligne)
        {
            $numColonne=0;

            if ($first) 
            { 
                $first=false;
                continue;
            }
            
            $valeurLigne=array();
            
            
            foreach($ligne->getCellIterator() as $cellule)
            {
                if($numColonne==7)
                {
                    echo $cellule->getCalculatedValue(); echo "<br>";
                    echo "ça passe";
                }
                if($numColonne<=7)
                {
                    $valeurLigne[$numColonne]=$cellule->getCalculatedValue();
                    $numColonne++;
                    echo "ça passe2";
                }
                
                
 
            } 
            if($valeurLigne[5]!="")
            {
                echo "arf";
           
                $idPS = explode(";", $valeurLigne[5]);
                foreach($idPS as $id)
                {
                    $tab[]= "insert into T_REF_PROFESSIONNEL_POPULATION (PRO_IDPS,POP_IDPOPULATION) VALUES  ('IDPS_".$id."','".$valeurLigne[1]."')"; 
                }
            }
        }
     

print_r($tab);
    echo "<br><br>";
    foreach($tab as $ligne )
    {
        echo $ligne; echo "<br>";
    }
?>            

