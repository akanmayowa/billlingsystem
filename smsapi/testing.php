<?php
$testing = $_REQUEST["testing"];

if ($testing)
 {
    echo "Testing<br>";
}


require "twilio-php-master/Services/Twilio.php";

$AccountSid = "AC2a45021888475301e2afa5a18758224b";
$AuthToken = "687ba847c9194bdec8e517e689a6497f";


$fromNumber = "+14325551212";


$client = new Services_Twilio($AccountSid, $AuthToken);


$toNumber = "+1" . $_REQUEST["number"];
$message = $_REQUEST["message"];

// If testing we only need to load the PHP page in the browser
if ($testing) {
    $fromNumber = "+14325551212";
    $toNumber = "+14325551212";
    $message = "This is a test. Time is " . date('h:i.s');
}

try {
    $sms = $client->account->messages->sendMessage($fromNumber, $toNumber, $message);

    echo "An SMS message was sent to $toNumber";
}
catch (Exception $e) {
    echo "The message was not sent!<br><br>";
    echo "From Number: " . $fromNumber." (must be your Twilio phone number)<br>";
    echo "To Number: " . $toNumber." (this must be a verified phone number if you are using a trial account)<br>";
    echo "Message: " . $message."<br>";
    echo "<br>";
}
?>
<?php 










?>



<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Sms Page</title>		
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="js/jquery-1.12.4-jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>			
</head>
<body>

<div class="container">
<div class="container">
  <h2>SMS FORM</h2>
</div>
</br></br>



<FORM action="SendSMS.php" method="post" style="width: 250px; padding-left: 10px">
  <P>
     Phone Number (123-345-7890):<br> <INPUT type="text" name="phone" style="width: 100%"><BR>
     Message: <br><TextArea type="text" name="message" style="width: 100%"></TextArea><br><br>
     <BUTTON name="reset" type="reset">Reset</BUTTON>
     <BUTTON name="submit" value="submit" type="submit">Send</BUTTON>
  </P>
</FORM>
</div>
</body>
 </html>