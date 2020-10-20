
<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'fnphybilling');
try
{
    $dbh = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e)
{
    die("ERROR: Could not connect. " . $e->getMessage());
}
?>

<?php
$userid=intval($_GET['hospitalnos']);
$sql = "SELECT * FROM patientinfo WHERE hospitalnos = :id";
$query = $dbh->prepare($sql);
$query->bindParam(':id',$userid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery/jquery.min.js"></script>
  <script src="bootstrap/js/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link href="bootstrap-data-table-master/css/vendor/font-awesome.min.css" type="text/css" rel="stylesheet">

    <link href="bootstrap-data-table-master/css/jquery.bdt.css" type="text/css" rel="stylesheet">


</head>
<body>

<?php include('../nav.php');?>

<BR><BR><br>


<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h4 style="color: red;">BILLING PROFILE</h4></th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

      <div class="float-left" >
<table class="table table-dark">
  <thead>

  <tr>
      <th  colspan="2"><a class="" href='create_invoice.php?hospitalnos=<?php echo htmlentities($result->hospitalnos);?>'><h5><b>CLICK TO GENERATE BILL</b></h5></a></th>

    </tr>
    <tr>
      <th>REGISTRATION NUMBER</th>
      <th><?php echo htmlentities($result->hospitalnos); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>PATIENT NAME:</th>
      <td><?php echo htmlentities($result->surname); ?><?php echo htmlentities($result->firstname); ?></td>
    </tr>
  </tbody>
</table>
</div>
<br>
<div class="table-responsive">
                        <table id="bootstrap-table"  class="table table-dark table-striped">

 <thead>
 <tr>
 <th colspan="1"></th>
  <th colspan="3">CUMULATIVE</th>
  <th colspan="3">LEDGER</th>
  <th colspan="3">BILLING</th>

 </tr>
   </thead>
        <thead>
          <tr>
          <th>Billing No.</th>
          <th>&Sigma;AmountPaid</th>
            <th>&Sigma;Bill Total</th>

            <th>&Sigma;Balance</th>
            <th  style="background-color: blue;color: white;"        >Credit</th>
            <th   style="background-color: red;color: white;"    >Debit</th>
            <th    style="background-color: green;color: white;"   >Balance</th>
            <th   style="background-color: blue;color: white;"     >AmountPaid</th>
            <th    style="background-color: red;color: white;"    >Bill Total</th>
            <th   style="background-color: green;color: white;"     >Balance</th>
            <th>Print</th>
            <th>Manage Bill</th>

          </tr>
        </thead>

 <?php
$sql = "SELECT  * from invoice_order WHERE hospitalnos = :id";
$query = $dbh->prepare($sql);
$query->bindParam(':id',$userid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
    $x = 0;
    $y = 0;
    $z = 0;


    $balance = 0;
foreach($results as $result)
{
    $x += $result->order_total_after_tax;
    $y += $result->order_amount_paid;
    $z = $y - $x;
?>
<tr>

<td><?php echo htmlentities($result->billingnos);?></td>
             <td><?php echo $y;?></td>
            <td><?php echo $x;?></th>
            <td><?php echo $z;?></td>


            <td style="background-color: blue;color: white;"    ><?php echo $result->order_amount_paid > 0 ? $result->order_amount_paid : '' ?></td>
            <td  style="background-color: red;color: white;"   ><?php echo $result->order_total_after_tax > 0 ? $result->order_total_after_tax : '' ?></td>

            <td  style="background-color: green;color: white;" ><?php echo $balance = ($balance + $result->order_amount_paid - $result->order_total_after_tax
            ) ?>
            </td>


            <td   style="background-color: blue;color: white;"          ><?php echo htmlentities($result->order_amount_paid);?></td>
    <td style="background-color: red;color: white;"    ><?php echo htmlentities($result->order_total_after_tax);?></td>
    <td  style="background-color: green;color: white;" ><?php echo htmlentities($result->order_total_amount_due);?></td>

<td><a href="print_invoice.php?invoice_id=<?php echo htmlentities($result->order_id);?>"><button class="btn btn-info btn-xs">Print</button></a></td>
<td><a href="edit_invoice.php?update_id=<?php echo htmlentities($result->order_id);?>"><button class="btn btn-primary btn-xs">Manage Bill</button></a></td>
   </tr>

<?php
$cnt++;
}} ?>
      </table>
                    </div>
                    </div>

                    <?php }} ?>


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
