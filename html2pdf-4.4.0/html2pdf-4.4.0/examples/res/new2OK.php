<page>
        <style type="text/css">
            table, html
            {
                width:  100%;
                margin:0px;
                padding:0px;
            }
         
            .contour
            {
                text-align: left;
                border: solid 1px #CCC;
            }
            .tg  {border-collapse:collapse;border-spacing:0; margin: 0px; padding: 0px}
            .tg td{font-family: Arial; sans-serif;font-size:14px;overflow:hidden; margin:0px;
            padding:0px;}
            .tg th{font-family: Arial, sans-serif; sans-serif;font-size:14px;font-weight:normal;overflow:hidden;border-color:black;margin: 0px}
            .tg .tg-cly1{text-align:left; padding: 0px; margin: 0px}
            .tg .tg-0lax{text-align:left;vertical-align:bottom; padding: 0px; margin: 0px}
            img{padding:0px;margin:0px}
        </style>
      

        
        
         <!--
       <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 1000px;  left: 50px; ">www.cabaneajeux.fr<br><barcode type="C39" value="1"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>

        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 19px;  left: 470px; ">www.cabaneajeux.fr<br><barcode type="C39" value="2"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>
        
        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 19px;  left: 731px; ">www.cabaneajeux.fr<br><barcode type="C39" value="3"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>
        
        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 153px;  left: 209px; ">www.cabaneajeux.fr<br><barcode type="C39" value="3"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>

-->
        <?php
        $xOffset=array();
        $xOffset[0]=212;
        $xOffset[1]=478;
        $xOffset[2]=740;
        $yOffset=134;
        $numAdherentSimule=1;
        $xInit=212;
        $yInit=19;
        $i=0;
        $first=true;
        $trOuvrant=true;
        $trFermant=false;
        $nbElementsParLigne=0;
        
        for($j=0; $j<24; $j++) 
        {
            
            if($first)
            {
                $yInit=19;  
                $first=false;
            }
            elseif($trOuvrant)
            {
                $yInit=$yInit+$yOffset;
            }
          
            
             if($trOuvrant){  $trOuvrant=false;} 
            
                        ?><div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: <?php echo $yInit;?>px;  left: <?php echo $xOffset[$nbElementsParLigne];?>px; ">www.cabaneajeux.fr<br><barcode type="C39" value="<?php echo $numAdherentSimule;?>"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div><?php
            
                $nbElementsParLigne++;
                if($nbElementsParLigne==3) $trFermant=true;
              if($trFermant){  $trFermant=false; $trOuvrant=true;$nbElementsParLigne=0;} 
            $numAdherentSimule++;
            
        }
        

        
              
        
        $xOffset=array();
        $xOffset[0]=209;
        $xOffset[1]=470;
        $xOffset[2]=731;
        $yOffset=134;
        $numAdherentSimule=1;
        $xInit=209;
        $yInit=19;
        $i=0;
        $first=true;
        $trOuvrant=true;
        $trFermant=false;
        $nbElementsParLigne=0;
                       
        for($j=0; $j<24; $j++) 
        {
        
                
            if($first) 
            { ?><table>
            <col style="width: 33.33%">
            <col style="width: 33.33%">
            <col style="width: 33.33%"><?php $first=false;
            }?>

            
        
                
                <?php if($trOuvrant){ echo "<tr>"; $trOuvrant=false;} ?>
                <td class="contour">
                    <table class="tg">
                        <tr>
                            <td class="tg-cly1" colspan="4" style="padding-left: 3px;">
                                <span style="font-size: 16px; font-weight: bold;  color: #984807;padding: 0px; margin :0px; ">Le monstre des couleurs
                                </span>
                            </td>
                            <td class="tg-0lax" colspan="2" rowspan="5"></td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="height:30px;width:80%;font-size: 12px; padding-left: 3px;font-style: italic; color: #984807;padding: 0px; margin :0px" colspan="4">
                                Association d'idées - Prise de risque - Communication
                            </td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="height:45px;width:70%;font-size: 10px;padding-left: 3px; margin :0px " colspan="4">
                                Faire deviner une liste de mots à son équipe en un minimum de temps et vioci le maximum où l'on peut aller facilement sans problème jusque là
                            </td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="width:20%;padding: 0px; margin :0px; text-align:center"><img src="picto1.png"></td>
                            <td class="tg-cly1" style="width:20%;padding: 0px; margin :0px; text-align:center"><img src="picto2.png"></td>
                            <td class="tg-cly1" style="width:20%;padding: 0px; margin :0px; text-align:center"><img src="picto3.png"></td>
                            <td class="tg-cly1" style="width:20%;padding: 0px; margin :0px; text-align:center" rowspan="2"><img src="picto4.png"></td>
                        </tr>
                        <tr>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center">12+</td>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center">2-12</td>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center">20'</td>
                        </tr>
                    </table>        
                </td>
                <?php 
                $nbElementsParLigne++;
                if($nbElementsParLigne==3) $trFermant=true;
                ?>
              
          
                <?php if($trFermant){ echo "</tr>"; $trFermant=false; $trOuvrant=true;$nbElementsParLigne=0;} ?>
        <?php
            $numAdherentSimule++;
        }
        if($nbElementsParLigne!=0) echo '</tr>';
        ?>

        </table>

</page>

<page>
        <style type="text/css">
            table, html
            {
                width:  100%;
                margin:0px;
                padding:0px;
            }
         
            .contour
            {
                text-align: left;
                border: solid 1px #CCC;
            }
            .tg  {border-collapse:collapse;border-spacing:0; margin: 0px; padding: 0px}
            .tg td{font-family: Arial; sans-serif;font-size:14px;overflow:hidden; margin:0px;
            padding:0px;}
            .tg th{font-family: Arial, sans-serif; sans-serif;font-size:14px;font-weight:normal;overflow:hidden;border-color:black;margin: 0px}
            .tg .tg-cly1{text-align:left; padding: 0px; margin: 0px}
            .tg .tg-0lax{text-align:left;vertical-align:bottom; padding: 0px; margin: 0px}
            img{padding:0px;margin:0px}
        </style>
      

        
        
         <!--
       <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 1000px;  left: 50px; ">www.cabaneajeux.fr<br><barcode type="C39" value="1"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>

        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 19px;  left: 470px; ">www.cabaneajeux.fr<br><barcode type="C39" value="2"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>
        
        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 19px;  left: 731px; ">www.cabaneajeux.fr<br><barcode type="C39" value="3"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>
        
        <div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: 153px;  left: 209px; ">www.cabaneajeux.fr<br><barcode type="C39" value="3"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div>

-->
        <?php
        $xOffset=array();
        $xOffset[0]=212;
        $xOffset[1]=478;
        $xOffset[2]=740;
        $yOffset=134;
        $numAdherentSimule=1;
        $xInit=212;
        $yInit=19;
        $i=0;
        $first=true;
        $trOuvrant=true;
        $trFermant=false;
        $nbElementsParLigne=0;
        
        for($j=0; $j<24; $j++) 
        {
            
            if($first)
            {
                $yInit=19;  
                $first=false;
            }
            elseif($trOuvrant)
            {
                $yInit=$yInit+$yOffset;
            }
          
            
             if($trOuvrant){  $trOuvrant=false;} 
            
                        ?><div style="rotate:90;margin:0px;padding:0px;text-align:center;font-size:8px;color: #984807;   position: absolute;  top: <?php echo $yInit;?>px;  left: <?php echo $xOffset[$nbElementsParLigne];?>px; ">www.cabaneajeux.fr<br><barcode type="C39" value="<?php echo $numAdherentSimule;?>"  label="label" style="width:27mm; height:8mm; color: #000; font-size: 2.5mm; font-weight: bold; margin:auto;color: #984807;" ></barcode></div><?php
            
                $nbElementsParLigne++;
                if($nbElementsParLigne==3) $trFermant=true;
              if($trFermant){  $trFermant=false; $trOuvrant=true;$nbElementsParLigne=0;} 
            $numAdherentSimule++;
            
        }
        

        
              
        
        $xOffset=array();
        $xOffset[0]=209;
        $xOffset[1]=470;
        $xOffset[2]=731;
        $yOffset=134;
        $numAdherentSimule=1;
        $xInit=209;
        $yInit=19;
        $i=0;
        $first=true;
        $trOuvrant=true;
        $trFermant=false;
        $nbElementsParLigne=0;
                       
        for($j=0; $j<24; $j++) 
        {
        
                
            if($first) 
            { ?><table>
            <col style="width: 33.33%">
            <col style="width: 33.33%">
            <col style="width: 33.33%"><?php $first=false;
            }?>

            
        
                
                <?php if($trOuvrant){ echo "<tr>"; $trOuvrant=false;} ?>
                <td class="contour">
                    <table class="tg">
                        <tr>
                            <td class="tg-cly1" colspan="4" style="padding-left: 3px;">
                                <span style="font-size: 16px; font-weight: bold;  color: #984807;padding: 0px; margin :0px; ">Le monstre des couleurs
                                </span>
                            </td>
                            <td class="tg-0lax" colspan="2" rowspan="5"></td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="height:30px;width:80%;font-size: 12px; padding-left: 3px;font-style: italic; color: #984807;padding: 0px; margin :0px" colspan="4">
                                Association d'idées - Prise de risque - Communication
                            </td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="height:45px;width:70%;font-size: 10px;padding-left: 3px; margin :0px " colspan="4">
                                Faire deviner une liste de mots à son équipe en un minimum de temps et vioci le maximum où l'on peut aller facilement sans problème jusque là
                            </td>
                        </tr>
                        <tr>
                            <td class="tg-cly1" style="width:20%;padding: 0px; margin :0px; text-align:center"><img src="picto1.png"></td>
                            <td class="tg-cly1" style="width:20%;padding: 0px; margin :0px; text-align:center"><img src="picto2.png"></td>
                            <td class="tg-cly1" style="width:20%;padding: 0px; margin :0px; text-align:center"><img src="picto3.png"></td>
                            <td class="tg-cly1" style="width:20%;padding: 0px; margin :0px; text-align:center" rowspan="2"><img src="picto4.png"></td>
                        </tr>
                        <tr>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center">12+</td>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center">2-12</td>
                            <td class="tg-0lax" style="font-size: 14px; font-weight: bold; font-style: italic; color: #984807;padding: 0px; margin :0px; color: #4a8522; text-align:center">20'</td>
                        </tr>
                    </table>        
                </td>
                <?php 
                $nbElementsParLigne++;
                if($nbElementsParLigne==3) $trFermant=true;
                ?>
              
          
                <?php if($trFermant){ echo "</tr>"; $trFermant=false; $trOuvrant=true;$nbElementsParLigne=0;} ?>
        <?php
            $numAdherentSimule++;
        }
        if($nbElementsParLigne!=0) echo '</tr>';
        ?>

        </table>

</page>

