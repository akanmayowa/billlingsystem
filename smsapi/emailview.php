
<?php
include_once 'database.php';
$result = mysqli_query($conn,"SELECT * FROM invoice_order");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="../bootstrap/jquery/jquery.min.js"></script>
  <script src="../bootstrap/js/popper.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<br>
<?php include('../nav.php');?>
<br><br><br>
<div class="container">
            <h5 class="card-title text-center">
			<img src="../img/yaba2.jpg" width="70" height="70" alt="logo">
			<B style="color: GREEN";>AUTOMATED BILLING</B></h5>
			</div>
<br><br>

<div class="container"><h5 class="card-title text-center" style="color:green;"><B>SEND  EMAIL</B>	</div>



<div class="">
<table class="table table-dark table-striped">
<thead>
<tr>
<th>HOSPTL FDR#</th>
<th>Patient FullName</th>
<th>NOK-Name</th>
<th>NOK-EmailAddress</th>
<th>Amount Due</th>
<th>Bill Number</th>
<th>Bill DueDate</th>
<th>SMS</th>
</tr>
</thead>
<tbody>
<?php
$i=0;
while($row = mysqli_fetch_array($result)) {
?>
<tr>
<td><?php echo $row["hospitalnos"]; ?></td>
<td><?php echo $row["order_receiver_name"]; ?></td>
<td><?php echo $row["nokname"]; ?></td>
<td><?php echo $row["nokemail"]; ?></td>
<td><?php echo $row["order_total_before_tax"]; ?></td>
<td><?php echo $row["billingnos"]; ?></td>
<td><?php echo $row["date2"]; ?></td>
<td><a class="" href='email.php?order_id=<?php echo $row['order_id']; ?>'><b style="color:red;">CLICK TO SEND EMAIL</b></a></td>
</tr>
<?php 
$i++;
}
?>	
</tbody>
</table>
</div>
<?php include('../footer.php');?>
</body>
</html>

