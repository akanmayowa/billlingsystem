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

    $grabBday = "SELECT * FROM invoice_order WHERE order_total_after_tax > order_amount_paid";
	if($rs = mysqli_query($link, $grabBday))
    {
        while($row=mysqli_fetch_array($rs))
        {
  
          $hospitalnos=  $row["hospitalnos"]; 
          $order_receiver_name= $row["order_receiver_name"]; 
          $order_total_amount_due =   $row["order_total_amount_due"]; 
          $billingnos= $row["billingnos"]; 
          $date2=    $row["date2"]; 
          $noknumber=$row['noknumber'];


          $body = "REGISTRATION- #:$hospitalnos \n PATIENTNAME:$order_receiver_name \n BILLTOTAL:$order_total_amount_due \n BILLID#:$billingnos \n BILLDUEDATE:$date2" ;
  
          $username = 'akanmayowa@yahoo.com';
          $password = 'philip01';
          $sender   = 'FNPHY';
          $message  = $body;
          $mobiles  = $row['noknumber'];
          $api_url  = 'https://portal.nigeriabulksms.com/api/';

          $data = array('username'=>$username, 'password'=>$password, 'sender'=>$sender, 'message'=>$message, 'mobiles'=>$mobiles);
          $data = http_build_query($data);
          $ch = curl_init(); 
          curl_setopt($ch,CURLOPT_URL, $api_url);
          curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
          curl_setopt($ch,CURLOPT_POST, true);
          curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
          $result = curl_exec($ch);
          $result = json_decode($result);
          if(isset($result->status) && strtoupper($result->status) == 'OK')
          {
             echo 'Message sent at N'.$result->price;
          
          }
          else if(isset($result->error))
          {
             echo 'Message failed - error: '.$result->error;
          }
          else
          {
              echo 'Unable to process request';
          }





                  
          } 
    }
  }

?>


<form method="post"	 action="smsviewpending.php">
<p align="center"><button type="submit" class="btn btn-success" name="save">PLEASE RETURN BACK TO VIEW PAGE</button></P>
</form>
</body>
</html>