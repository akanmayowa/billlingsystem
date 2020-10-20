<?php
include_once 'database.php';
$result = mysqli_query($conn,"SELECT * FROM invoice_order WHERE order_total_after_tax > order_amount_paid");
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="../bootstrap/jquery/jquery.min.js"></script>
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <script src="../bootstrap/jquery/jquery.min.js"></script>
  <script src="../bootstrap/js/bootstrap.min.js"></script>
  <link href="../bootstrap-data-table-master/css/vendor/font-awesome.min.css" type="text/css" rel="stylesheet">
  <link href="../bootstrap-data-table-master/css/pagination.css" type="text/css" rel="stylesheet">
    <link href="../bootstrap-data-table-master/css/jquery.bdt.css" type="text/css" rel="stylesheet">
</head>
<body>

<?php include('../nav.php');?>
<br><br><br><br>



      <div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h3 style="color: red;"><B> PENDING SMS</B></h3></th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>
                            <br>








      <form method="post" action="sendsms.php">
      <div class="container-fluid"> <h5 class="card-title text-right"><B> <button type="submit" class="btn btn-danger" name="save"><b>Send Pending SMS</b> </button>	</div>



<div class="">
<table id="bootstrap-table" class="table table-dark table-striped">
<thead>
<tr>
<th>Registrn Nos</th>
<th>Patient FullName</th>
<th>NOK-Name</th>
<th>NOK-Phone Number</th>
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
<td><?php echo $row["noknumber"]; ?></td>
<td><?php echo $row["order_total_amount_due"]; ?></td>
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
<script src="http://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="../bootstrap-data-table-master/js/vendor/bootstrap.min.js" type="text/javascript"></script>
<script src="../bootstrap-data-table-master/js/vendor/jquery.sortelements.js" type="text/javascript"></script>
<script src="../bootstrap-data-table-master/js/jquery.bdt.min.js" type="text/javascript"></script>
<script>
$(document).ready( function () {
    $('#bootstrap-table').bdt();
});
</script>
<?php include('../footer.php');?>

</body>
</html>
