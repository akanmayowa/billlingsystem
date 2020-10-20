<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<script src="js/jquery-1.12.4-jquery.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>	
</head>
<body>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname= "fnphybilling";

$link = mysqli_connect($servername, $username, $password ,$dbname);
if($link && mysqli_select_db($link,'fnphybilling'))
{

    $grabBday = "SELECT * FROM invoice_order";
    if($rs = mysqli_query($link, $grabBday))
    {
        while($row=mysqli_fetch_array($rs))
        {
            
			    
		$to = $row["nokemail"];
		$subject = "Happy birthday";
		$txt = "Happy birthday! Dear";
		$headers = "From: name@example.com" . "\r\n" .//your mail id
		"CC: somebodyelse@example.com";//if any (optional)

		mail($to,$subject,$txt,$headers);
		echo 'Email Send Successfully.';
			
			
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.pepipost.com/v2/sendEmail",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\"personalizations\":[{\"recipient\":\"$to\"}],\"from\":{\"fromEmail\":\"mayowaakan@pepisandbox.com\",\"fromName\":\"mayowaakan\"},\"subject\":\"Welcome to Pepipost\",\"content\":\"Hsecond triall\"}",
      CURLOPT_HTTPHEADER => array(
        "api_key: 5fc0c7e8833ce4628403e843e79f0fef",
        "content-type: application/json"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }

    }
    }
	echo 'Email Send Successfully.';
} 

?>




<form method="post"	 action="emailviewpending.php">
<p align="center"><button type="submit" class="btn btn-success" name="save">PLEASE RETURN BACK TO VIEW PAGE</button></P>
</form>
</body>
</html>