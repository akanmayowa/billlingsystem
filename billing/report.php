<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
 
    <title>View Report Profile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery/jquery.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap-data-table-master/css/vendor/font-awesome.min.css" type="text/css" rel="stylesheet">
    <link href="bootstrap-data-table-master/css/jquery.bdt.css" type="text/css" rel="stylesheet">
 
    <link href="bootstrap-data-table-master/css/pagination.css" type="text/css" rel="stylesheet">
<body>

<?php include('../nav.php');?>
<br/><br/><p></p>
<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h5 style="color: red;">
<B>GENERAL BILLING  STATEMENT--->
<select name="" onchange="location = this.value;">
 <option value="" >-PLS SELECT REPORT-</option>
 <option value="report.php">  GENERAL  </option>
 <option value="reportin.php">  INPATIENT  </option>
 <option value="reportout.php">  OUTPATIENT </option>
</select>
</B>                                            
</h5>
                                            
                                            </th>
                                        </tr>
                                    </thead>   
                                </table>
                            </div>

                     
<div class="float-left">
<table class="table table-dark table-striped">
<thead style="background-color: green;color: white;"    >

<th>NUMBER OF BILLS</th>
<th>  
  <?php 
$sql ="SELECT billingnos from  invoice_order";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$bg=$query->rowCount();
?>
<?php echo htmlentities($bg);?>	
</th>
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




<br/>  <br/>
<table id="bootstrap-table" class="table table-dark table-striped"  >
<thead>
<th>REGISTRN #</th>
<th>FULL NAME</th>
<th>BLLNG #</th>
<th>PAYMENT DATE</th>
<th  style="background-color: red;color: white;" >BILL TOTAL</th>
<th  style="background-color: blue;color: white;" >AMOUNT PAID</th>
<th style="background-color: green;color: white;">BALANCE</th>

</thead>
<tbody>
<?php
$sql = "SELECT * from  invoice_order";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
    $x = 0;
    $y = 0;
    $z = 0;
foreach($results as $result)
{
    $x += $result->order_total_after_tax;
    $y += $result->order_amount_paid;
    $z = $y - $x;


?>
    <tr>
    <td><?php echo htmlentities($result->hospitalnos);?></td>
    <td><?php echo htmlentities($result->order_receiver_name);?> </td>  
    <td><?php echo htmlentities($result->billingnos);?></td> 
    <td><?php echo htmlentities($result->order_date);?></td>
    <td  style="background-color: red;color: white;" ><?php echo htmlentities($result->order_total_after_tax);?></td>
    <td  style="background-color: blue;color: white;" ><?php echo htmlentities($result->order_amount_paid);?></td>
    <td  style="background-color: green;color: white;"><?php echo htmlentities($result->order_total_amount_due);?></td>
</tr>
<?php

$cnt++;
}} ?>
</tbody>
</table>

<div class="float-left">
 <table  class="table table-dark table-striped">
  <thead>
    <tr> 
      <th h5 class="card-title text-LEFT" style="color:red;">TOTAL-BILL(N)</th>
      <th><?php echo $x;?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th h5 class="card-title text-LEFT" style="color:red;">TOTAL-PAYMENT(N)</th>
      <td><?php echo $y;?></td>
    </tr>

    <tr>
      <th h5 class="card-title text-LEFT" style="color:red;">TOTAL-BALANCE(N)</th>
      <td><?php echo $z;?></td>
    </tr>
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