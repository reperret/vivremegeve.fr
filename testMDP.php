<?php
try
{

	echo $newMDPClair=uniqid();  echo "<br>";
	echo $newMDP=md5($newMDPClair);
	
} 
catch (InvalidSignatureException $e) 
{
    mail("reperret@hotmail.com","IPN Failed","The signature was invalid");
}

?>