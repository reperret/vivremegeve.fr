<?php

// Register API keys at https://www.google.com/recaptcha/admin
$siteKey = '6LdC8hcTAAAAALai9tRHxOpbruUt41_BElgMm3aX';
$secret = '6LdC8hcTAAAAAP5ymwIVmOKyiznK0oRksUa7M7G0';

// reCAPTCHA supported 40+ languages listed here: https://developers.google.com/recaptcha/docs/language
$lang = 'fr';

if (isset($_POST['g-recaptcha-response']))
{
    // The POST data here is unfiltered because this is an example.
    // In production, *always* sanitise and validate your input'
    ?>
    <h2><tt>POST</tt> data</h2>
    <?php
// If the form submission includes the "g-captcha-response" field
// Create an instance of the service using your secret
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);

// If file_get_contents() is locked down on your PHP installation to disallow
// its use with URLs, then you can use the alternative request method instead.
// This makes use of fsockopen() instead.
//  $recaptcha = new \ReCaptcha\ReCaptcha($secret, new \ReCaptcha\RequestMethod\SocketPost());

// Make the call to verify the response and also pass the user's IP address
    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

    if ($resp->isSuccess())
	{
		echo "ok";	
	}
	else
	{
		echo "ko";	
	}
// If the response is a success, that's it!
}    ?>
</body>
</html>
