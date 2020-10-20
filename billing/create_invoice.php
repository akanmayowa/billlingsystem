r<?php 
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName'])
{

$invoice->saveInvoice($_POST);
echo "<script>alert('Bill successfully Created');</script>";
echo "<script>window.location.href='createbillview.php'</script>";
//header("Location:createbillview.php");

}

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
<style>
    .container-fluid{
        margin: 45px;
    }
</style>

</head>
<body>

<?php
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','fnphybilling');
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS);
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
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
{

	?>

<?php include('../nav.php');?>
<br><br><br>
<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h3 style="color: red;"><B>GENERATE BILL</B></h3></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

<div class="container-fluid">
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form">

		<div  class="container-fluid">

			<input id="currency" type="hidden" value="$">
			<div class="row">
				<div class="container">

					<div class="form-group">
					<label style="color:green;"><b>REGISTRATION NUMBER <b style="color:red;">*</b></b></label>
						<input readonly type="number" class="form-control" value="<?php echo htmlentities($result->hospitalnos);?>"     name="hospitalnos"  autocomplete="off">
					</div>


					<div class="form-group">
				<label style="color:red;"><b>BILLING NUMBER</b><b style="color:red;"> *</b></label>
						<input type="text" class="form-control" name="billingnos" required >
					</div>


					<div class="form-group">
					<label style="color:red;"><b>RECIEPT PAYMENT #</b></label>
						<input type="text"  readonly class="form-control" name="rrrcode" value="NIL" autocomplete="off">
					</div>

				</div>


				<div class="container">

					<div class="form-group">
					<label style="color:red;"><b>EXPECTD DATE OF PAYMNT</b></label>
						<input type="date"required  class="form-control" name="date2"  autocomplete="off">
					</div>


					<div class="form-group">
					<label style="color:green;"><b>FULLNAME</b></label>
						<input type="text" required class="form-control" READONLY value="<?php echo htmlentities($result->surname);?> <?php echo htmlentities($result->firstname);?>" name="companyName" id="PatientName" placeholder="FullName" autocomplete="off">
					</div>



					<div class="form-group">
					<label style="color:green;"><b>NOK-NAME</b></label>
						<input type="text" required class="form-control" READONLY value="<?php echo htmlentities($result->nokname);?>" name="nokname" id="nokname" placeholder="nokName" autocomplete="off">
					</div>



					<div class="form-group">
					<label style="color:green;"><b>NOK-FONE NUMBER</b></label>
						<input type="text" required  READONLY class="form-control" value="<?php echo htmlentities($result->noknumber);?>" name="noknumber" id="address" placeholder="Nok number">
					</div>



					<div class="form-group">
					<label style="color:green;"><b>NOK-EMAILADDRESS</b></label>
						<input type="text" required  READONLY class="form-control" value="<?php echo htmlentities($result->nokemail);?>" name="nokemail" id="address" placeholder="Email Address">
					</div>




					<div class="form-group">
					<label style="color:green;"><b>PATIENT TYPE</b></label>
						<input type="text" required DISABLED class="form-control" value="<?php echo htmlentities($result->ptype);?>" name="ptype" id="address" placeholder="ptype">
					</div>



					<div class="form-group">
					<label style="color:green;"><b>WARD</b></label>
						<input type="text" required  DISABLED class="form-control" value="<?php echo htmlentities($result->ward);?>" name="ward" id="address" placeholder="ward">
					</div>









				</div>
			</div>




			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
					<table class="table table-bordered table-hover" id="invoiceItem">
						<tr>
							<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
							<th width="1%"><b style="color:green;"></b></th>
							<th width="20%"><b style="color:green;">Item Name</b></th>
							<th width="10%"><b style="color:green;">Quantity<b></th>
							<th width="15%"><b style="color:green;">Price</b></th>
							<th width="15%"><b style="color:green;">Total<b></th>
						</tr>
						<tr>



							<td><input class="itemRow" type="checkbox"></td>
<td><input type="hidden" value="1"     name="productCode[]" id="productCode_1" class="form-control" autocomplete="off"></td>
	<td><select  required  name="productName[]" id="productName_1" class="form-control" autocomplete="off" >
	<option value="" selected>-PLS SELECT-</option>
  <option value="ACCOMODATION">ACCOMODATION</option>
  <option value="FEEDING">FEEDING</option>
  <option value="DRUG DEPOSIT">DRUG DEPOSIT</option>
  <option value="OCCUPATIONAL THERAPY">OCCUPATIONAL THERAPY</option>
  <option value="PLAN CHEST XRAY">PLAN CHEST XRAY</option>
  <option value="SERVICE CHARGE">SERVICE CHARGE</option>
  <option value="REPATRIATION FEE">REPATRIATION FEE</option>
   <option value="OTHERS">OTHERS</option>
</select></td>



							<td><input required  type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
							<td><input required  type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
							<td><input required readonly type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
						</tr>
					</table>
				</div>
			</div>


			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
					<button class="btn btn-success" id="addRows" type="button">+ Add More</button>
				</div>
			</div>


			<div class="container">





					<div class="form-group">
						<label style="color:red;"><b>Subtotal:</b> </label>
								<input   id="subTotal" readonly value="<?php echo htmlentities($subtotal);?>" type="number" class="form-control" name="subTotal"  placeholder="Subtotal">
						</div>





						<div class="form-group">
						<label style="color:red;"><b>Tax Rate: </b></label>
								<input  value="" readonly  type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate">
						</div>

						<div class="form-group">
						<label style="color:red;"><b>Tax Amount:</b>  </label>
								<input value="" readonly  type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
						</div>




			<div class="form-group">
			<label style="color:red;"><b>Total:</b>  </label>
			<input readonly    type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
			</div>




						<div class="form-group">
						<label style="color:red;"><b>Amount Paid: </b>  </label>
							<input  value=""  readonly type="number" class="form-control" name="amountPaid" id="amountPaid" >
						</div>


						<div class="form-group">
						<label style="color:red;"><b>Amount Due: </b>   </label>
							<input readonly type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due">
						</div>


				<div class="form-group">
						<input type="hidden" value="<?php echo $_SESSION['id']; ?>" class="form-control" name="userId">
						<input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="GENERATE BILL" class="form-control btn btn-success submit_btn invoice-save-btm">
					</div>





			<div class="clearfix"></div>


		<?php }} ?>


	</form>
</div>
</div>
<?php include('../footer.php');?>
</div>
</body>
</html>
