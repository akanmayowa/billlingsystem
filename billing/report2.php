<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
 
    <title>rport</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery/jquery.min.js"></script>
  <script src="bootstrap/js/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap-data-table-master/css/vendor/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
    <link href="bootstrap-data-table-master/css/jquery.bdt.css" type="text/css" rel="stylesheet">
  
</head>
<body>

<?php include('../nav.php');?>
<br/><br/><br/><br/>


<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h3 style="color: red;"><B>BILLING REPORT STATEMENT</B></h3></th>
                                        </tr>
                                    </thead>   
                                </table>
                            </div>








<div class="float-left">
<table class="table table-dark table-striped">
<thead style="background-color: green;color: white;"    >
<th>NUMBER OF BILLS</th>
<th>    <?php 
$sql ="SELECT billingnos from  invoice_order";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$bg=$query->rowCount();
?>
<?php echo htmlentities($bg);?>	</th>
</thead>
<tbody style="background-color: red;color: white;"  >
    <tr>
    <th>NUMBER OF PATIENT</th>
    <th>
    <?php 
$sql ="SELECT hospitalnos from  patientinfo";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$bg=$query->rowCount();
?>
<?php echo htmlentities($bg);?>		
    
    </th>
 </tr>
</tbody>
</table>
</div>
<br/><br/><br/><br/><br/><br/>
<table  id="bootstrap-table" class="table table-dark table-striped" >
<thead>
<th>REGISTRN #</th>
<th>FULL NAME</th>
<th>LEDGER</th>
</thead>
<tbody>
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
    <td><?php echo htmlentities($result->surname);?> <?php echo htmlentities($result->surname);?> </td>  
<td><a style="color: red;" href="reportview.php?hospitalnos=<?php echo htmlentities($result->hospitalnos);?>"><b>CLICK TO VIEW LEDGER</b></a></td>
</tr>
<?php

$cnt++;
}} ?>
</tbody>
</table>

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