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

<?php include('../nav.php');?>
<br><br><br>

<div class="container">
            <h5 class="card-title text-center">
			<img src="../img/yaba2.jpg" width="70" height="70" alt="logo">
			<B style="color: GREEN";>AUTOMATED BILLING</B></h5>
			</div>

      <div class="container"> <h5 class="card-title text-center" style="color:green;"><B> PENDING EMAIL</B>	</div>
      <form method="post" action="sendemail.php">
      <div class="container-fluid"> <h5 class="card-title text-right"><B> <button type="submit" class="btn btn-danger" onclick="window.location.href='sendemail.php'"name="save"><b>Send Pending Email</b> </button>	</div>


<div class="">
<table class="table table-dark table-striped">
<thead>
<tr>
<th>HSPTL FDR #</th>
<th>Patient FullName</th>
<th>NOK-Name</th>
<th>NOK-emailAddress</th>
<th>Amount Due</th>
<th>Bill Number</th>
<th>Bill DueDate</th>

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
</tr>
<?php 
$i++;
}
?>	
</tbody>
</table>
</div>


</form>

<?php include('../footer.php');?>
<script>
$("#checkAll").click(function () {
$('input:checkbox').not(this).prop('checked', this.checked);
});
</script>
</body>
</html>




