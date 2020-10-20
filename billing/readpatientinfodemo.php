<?php
require_once 'config.php';
?>


<!DOCTYPE html>
<html lang="en">
<head>
 
    <title>View Profile</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery/jquery.min.js"></script>
  <script src="bootstrap/js/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>


</head>
<body>


<br/><br/><br/>
<div class="container">
            <h5 class="card-title text-center">
			<img src="../admin/img/yaba2.jpg" width="70" height="70" alt="logo">
			<B style="color: GREEN";>AUTOMATED BILLING</B></h5>
			</div>
<div class="container">
<br/>
<h5 class="card-title text-center" style="color:green;"><B>PATIENT lIST</B></h5> 
</div>



<table class="table table-dark table-striped"  >
<thead>
<th>REGISTRATN NOS</th>
<th>PAYMENT  #</th>
<th>FULL NAME</th>
<th>AMOUNT PAID</th>
<th>PAYMENT DATE</th>
<th>PROFILE</th>
<th>EDIT</th>
<th>DELETE</th>
</thead>
<tbody>
<?php
$sql = "SELECT hospitalnos,paymentnos,surname,firstname,nokname,noknumber,nokemail,ward, paymentdate, amount, dateofduration, id from  patientinfo";
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
    <td><?php echo htmlentities($result->paymentnos);?></td>
    <td><?php echo htmlentities($result->surname);?> <?php echo htmlentities($result->firstname);?></td>  
    <td><?php echo htmlentities($result->amount);?></td>
    <td><?php echo htmlentities($result->dateofduration);?></td>

<td><a href="readpatientdemo.php?id=<?php echo htmlentities($result->hospitalnos);?>"><button class="btn btn-info btn-xs">Profile</button></a></td>
<td><a href="updatepatient.php?id=<?php echo htmlentities($result->id);?>"><button class="btn btn-primary btn-xs">Manage</button></a></td>
<td><a href="deletepatient.php?del=<?php echo htmlentities($result->id);?>"><button class="btn btn-danger btn-xs" onClick="return confirm('Do you really want to delete');">Delete</button></a></td>
    </tr>
<?php

$cnt++;
}} ?>
</tbody>
</table>

</body>
</html>