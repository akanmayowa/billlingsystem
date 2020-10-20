<?php
if(isset($_POST["submit"]))
{

  $nokname=$_REQUEST['nokname'];
  $nokemail=$_REQUEST['nokemail'];
  $msg=$_REQUEST['msg'];
  
try{
    $pdo = new PDO("mysql:host=localhost;dbname=fnphybilling", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e){
    die("ERROR: Could not connect. " . $e->getMessage());
}


try
{
  $curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.pepipost.com/v2/sendEmail",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  
  CURLOPT_POSTFIELDS => "{\"personalizations\":
    [{\"recipient\":\"$nokemail\"}],
    \"from\":{\"fromEmail\":\"mayowaakan@pepisandbox.com\",\"fromName\":\"mayowaakan\"},\"subject\":\"Welcome to Pepipost\",\"content\":\"$msg\"}",


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


    $sql = "INSERT INTO emaildb (nokname, msg, nokemail) VALUES (:nokname, :msg, :nokemail)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nokname', $_REQUEST['nokname']);
    $stmt->bindParam(':msg', $_REQUEST['msg']);
    $stmt->bindParam(':nokemail', $_REQUEST['nokemail']);
    $stmt->execute();
    echo "Records inserted successfully.";
} catch(PDOException $e){
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
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<title>Email Page</title>		
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="../bootstrap/jquery/jquery.min.js"></script>
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>	
</head>
<body>
<?php include('../nav.php');?>
</br></br></br></br>

<div class="container">

            <h5 class="card-title text-center">
			<img src="../img/yaba2.jpg" width="70" height="70" alt="logo">
			<B style="color: GREEN";>AUTOMATED BILLING</B></h5>
			</div>



<div class="container">

<div class="">	   <h5 class="card-title text-LEFT" style="color:green;"><B> FORWARD EMAIL</B>	</div>
<form class="form-horizontal"action="" method="post">
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
      <label class="control-label col-sm"><b style="color:green;">NOK EMAILADDRESS:</b></label>
      <div class="col-sm-10">          
        <input type="text" readonly class="form-control"  value="<?php echo htmlentities($result->nokemail);?>"  required placeholder="Phone numberr" name="nokemail">
      </div>
    </div>

    <div class="form-group">
      <label class="control-label col-sm-2" for="pwd"><b style="color:red;">Message:</b></label>
      <div class="col-sm-10">          
        <input type="text" class="form-control"  required placeholder="Message Here" name="msg">
      </div>
    </div>

   
    <?php }} ?>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
      <input type="submit" class="btn btn-success form-control col-sm-4" value="SEND EMAIL"     name="submit"/>
      </div>
    </div>
  </form>
</div>
<?php include('../footer.php');?>
 </body>
 </html>