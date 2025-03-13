<?php  
$urlPhoto="";

                        if(is_file($_SERVER['DOCUMENT_ROOT']."/".$urlPhoto))
						{ ?>
							<img src="<?php echo $_SERVER['DOCUMENT_ROOT']."/".$urlPhoto;?>" width="71"> 
							<?php
                         echo "fuck";
						}
						else
						{
						?>
							<img src="<?php echo $_SERVER['DOCUMENT_ROOT']."/"."avatars/silouette.jpg";?>" width="71"> 
							<?php
						} ?>