<?php
$testa = $_POST['veio'];
if($testa != "") {
	
	$nome = $_POST['nome'];

	$to = $_POST['emails'];

	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";	
        $email = explode("\n", $to);
	
	function random_num(){
        for($x = 0; $x < 4; $x++){
        $n = $n . rand(1,9);
        }
         return mt_rand(1,2) . $n;
        }

        $de = $_POST['de'];
        $de = str_replace("%random_num%", random_num(), $de);
	$headers .= "From: ".$nome." <".$de.">\r\n";

	$i = 0;
	$count = 1;
        ?>
        <?
	while($email[$i]) {
        $message = $_POST['html'];
        $subject = $_POST['assunto'];
	$message = str_replace("_google_", $email[$i], $message);
	;
		$ok = "ok";
        $message = stripslashes($message);
		if(mail($email[$i], $subject, $message, $headers))
		echo "* Numero: $count <b>".$email[$i]."</b> <font color=green>OK</font><br><hr>";
		else
		echo "* Numero: $count <b>".$email[$i]."</b> <font color=red>ERRO AO ENVIAR</font><br><hr>";
		$i++;
		$count++;
	}
	$count--;
	if($ok == "ok")
	echo "<script> //alert('Terminaram os emails. ".$count." e-mails enviados'); </script>";
}

?>
<html>

<head>
<title>.: BYSCR43Z1 :.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style>
body {
	margin-left: 0;
	margin-right: 0;
	margin-top: 0;
	margin-bottom: 0;
}
.titulo {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 18px;
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
</style>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data" name="form1">
  <input type="hidden" name="veio" value="sim">
  <table width="464" height="511" border="0" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" class="normal">
    <tr>
      <td width="462" height="25" align="center" bgcolor="#99CCFF"><span class="titulo"> MASS MAIL 2014!</span></td>
    </tr>
    <tr>
      <td height="194" valign="top" bgcolor="#FFFFFF">
	  	<table width="100%"  border="0" cellpadding="0" cellspacing="5" class="normal" height="444">
		  <tr>
            <td align="right" height="17"><span class="texto">De / e-mail :</span></td>
            <td width="65%" height="17"><input name="nome" type="text" class="form" id="nome"  value="" style="width:48%" > <input name="de" type="text" class="form" id="de" value="" style="width:49%" ></td>
          </tr>
          <tr>
            <td align="right" height="17"><span class="texto">Assunto:</span></td>
            <td height="17"><input name="assunto" type="text" class="form" id="assunto" value="Fw:Enc: # Aviso Comunicado Digital Itau !" style="width:100%" ></td>
          </tr>
          <tr align="center" bgcolor="#99CCFF">
            <td height="20" colspan="2" bgcolor="#99CCFF"><span class="texto">C&oacute;digo HTML:</span></td>
          </tr>
          <tr align="right">
            <td height="146" colspan="2" valign="top"><br>
              <textarea name="html" style="width:100%" rows="8" wrap="VIRTUAL" class="form" id="html"> 

 </textarea>
              <span class="alerta">*Lembrete: texto em HTML</span></td>
          </tr>
          <tr align="center" bgcolor="#99CCFF">
            <td height="47" colspan="2"><span class="texto">Coloque o email de suas vitimas abaixo: </span>
              <p><span class="texto">OBS: um e-mail em cima do outro </span></td>
          </tr>
          <tr align="right">
            <td height="136" colspan="2" valign="top"><br>
<textarea name="emails" style="width:100%" rows="8" wrap="VIRTUAL" class="form" id="emails">

devscope@ig.com.br</textarea>
              <span class="alerta">*Separado por quebra de linha</span> </td>
          </tr>
          <tr>
            <td height="26" align="right" valign="top" colspan="2"><input type="Submit" id="enviar" name="Submit" value="Enviar"></td>
          </tr>
        </table>
	  </td>
    </tr>
    <tr>
      <td height="15" align="center" bgcolor="#99CCFF">&nbsp;</td>
    </tr>
  </table>

</form>
</body>