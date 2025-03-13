<html>

<head>
<title>Ma page</title>
<script src="https://www.google.com/recaptcha/api.js"></script>
</head>

<body>
<?php
$reCaptcha = new ReCaptcha("6LdC8hcTAAAAAP5ymwIVmOKyiznK0oRksUa7M7G0");
if(isset($_POST["g-recaptcha-response"])) {
    $resp = $reCaptcha->verifyResponse(
        $_SERVER["REMOTE_ADDR"],
        $_POST["g-recaptcha-response"]
        );
    if ($resp != null && $resp->success) {echo "OK";}
    else {echo "CAPTCHA incorrect";}
    }
?>  

</body>

</html>


