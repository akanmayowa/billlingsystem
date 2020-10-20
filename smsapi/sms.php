
<?php



if(isset($_POST["submit"]))
{
  
  $username = 'akanmayowa@yahoo.com';
  $password = 'philip01';
  $sender   = 'FNPHY';
  $message  = $_REQUEST['msg'];
  $mobiles  = $_REQUEST['noknumber'];
  $api_url  = 'https://portal.nigeriabulksms.com/api/';


try{
    $pdo = new PDO("mysql:host=localhost;dbname=fnphybilling", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}
try
{
  
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


    $sql = "INSERT INTO smsdb (nokname, msg, noknumber) VALUES (:nokname, :msg, :noknumber)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nokname', $_REQUEST['nokname']);
    $stmt->bindParam(':msg', $_REQUEST['msg']);
    $stmt->bindParam(':noknumber', $_REQUEST['noknumber']);
    $stmt->execute();
    echo "Records inserted successfully.";
} catch(PDOException $e)
{
    die("ERROR: Could not able to execute $sql. " . $e->getMessage());
}
unset($pdo);
}


?>



<?php 
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','fnphybilling');
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>
<?php
$userid=intval($_GET['order_id']);
$sql = "SELECT * FROM invoice_order where order_id=:uid";
$query = $dbh->prepare($sql);
$query->bindParam(':uid',$userid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>

<!DOCTYPE html>
<html>
<head>
<title></title>		
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery/jquery.min.js"></script>
  <script src="bootstrap/js/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<?php include('../nav.php');?>
</br></br></br></br>

<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h4 style="color: red;"><B> FORWARD SMS</B></h4></th>
                                        </tr>
                                    </thead>   
                                </table>
                            </div>


<div class="container">

  <form class="form-horizontal"   action="" method="post">
  <div class="form-group">
      <label class="control-label col-sm-2" for="email"><b style="color:green;">Patient FullName:<b></label>
      <div class="col-sm-10">
        <input type="text" readonly value="<?php echo htmlentities($result->order_receiver_name);?>"  class="form-control"  required placeholder="Nok Name" name="nokname">
      </div>
    </div>
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email"><b style="color:green;">NOK Name:</b></label>
      <div class="col-sm-10">
        <input type="text" readonly value="<?php echo htmlentities($result->nokname);?>"  class="form-control"  required placeholder="Nok Name" name="nokname">
      </div>
    </div>
    
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email"><b style="color:green;">Bill Number:</b></label>
      <div class="col-sm-10">
        <input type="text" readonly class="form-control" value="<?php echo htmlentities($result->billingnos);?>"   required placeholder="Nok Name" name="nokname">
      </div>
    </div>
    
    
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="email"><b style="color:green;">Bill Payment Date:</b></label>
      <div class="col-sm-10">
        <input type="text" readonly class="form-control"value="<?php echo htmlentities($result->order_date);?>"   required placeholder="Nok Name" name="nokname">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm"><b style="color:green;">NOK Phone Number:</b></label>
      <div class="col-sm-10">          
        <input type="text" readonly class="form-control"  value="<?php echo htmlentities($result->noknumber);?>"  required placeholder="Phone numberr" name="noknumber">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd"><b style="color:red;">Message:</b></label>
      <div class="col-sm-10">   
      <textarea name="msg" required  readonly class="form-control" row="5">REGISTRATION #:<?php echo htmlentities($result->hospitalnos);?> <?php echo "\n";?>PATIENTNAME: <?php echo htmlentities($result->order_receiver_name);?> <?php echo "\n";?>BILLTOTAL: <?php echo htmlentities($result->order_total_amount_due);?><?php echo "\n";?>
BILLID#: <?php echo htmlentities($result->billingnos);?><?php echo "\n";?>BILLDUEDATE: <?php echo htmlentities($result->date2);?><?php echo "\n";?></textarea>    
      </div>
    </div>

   
    <?php }} ?>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-success form-control col-sm-4" value="SEND SMS"     name="submit"/>
      </div>
    </div>
  </form>
</div>
<?php include('../footer.php');?>
 </body>
 </html>