<?php
require_once 'config.php';
?>


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
<script src="js/invoice.js"></script>
<link href="bootstrap/css/style.css" rel="stylesheet">
<link href="bootstrap-data-table-master/css/vendor/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="bootstrap-data-table-master/css/jquery.bdt.css" type="text/css" rel="stylesheet">
   
 
</head>
<body>
<?php 
session_start();

include('../nav.php');?>

<br/><br/><br/><br/><br/>


<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h3 style="color: red;"><B>GENERATE BILL</B></h3></th>
                                        </tr>
                                    </thead>
                               </table>
                            </div>


<?php
	$database_username = 'root';
	$database_password = '';
	$pdo_conn = new PDO( 'mysql:host=localhost;dbname=fnphybilling', $database_username, $database_password );
?>
<?php	
	$pdo_statement = $pdo_conn->prepare("SELECT * FROM patientinfo ORDER BY id DESC");
	$pdo_statement->execute();
	$result = $pdo_statement->fetchAll();
?>
<br/>
<div class="table-responsive">
<table  id="bootstrap-table" class="table table-dark table-striped">
<thead>
          <tr>
          <th>REGSTN NOS</th>
        
            <th>FULLNAME</th>
            <th>PATIENT-TYPE</th>
            <th>WARD</th>
            <th>BILLING</th>
          </tr>
        </thead>

 <?php
$sql = "SELECT * from  patientinfo";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{
?>
<tr>
    <td><?php echo htmlentities($result->hospitalnos);?></td>
    
    <td><?php echo htmlentities($result->surname);?> <?php echo htmlentities($result->firstname);?></td>  
    <td><?php echo htmlentities($result->ptype);?></td>
    <td><?php echo htmlentities($result->ward);?></td>
<td><a href="readpatientdemo.php?hospitalnos=<?php echo htmlentities($result->hospitalnos);?>"><button class="btn btn-info btn-xs">BILLING</button></a></td>
</tr>
<?php

$cnt++;
}} ?>
        </tbody>
        </table>	
        </div>


<script src="http://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="bootstrap-data-table-master/js/vendor/bootstrap.min.js" type="text/javascript"></script>
<script src="bootstrap-data-table-master/js/vendor/jquery.sortelements.js" type="text/javascript"></script>
<script src="bootstrap-data-table-master/js/jquery.bdt.min.js" type="text/javascript"></script>

    
<script>
$(document).ready( function () {
    $('#bootstrap-table').bdt();
});
</script>
<?php include('../footer.php');?>
</body>
</html>