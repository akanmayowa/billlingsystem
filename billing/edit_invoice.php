<?php 
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName'] && !empty($_POST['invoiceId']) && $_POST['invoiceId']) {	
$invoice->updateInvoice($_POST);	
echo "<script>alert('Bill successfully Managed');</script>";
echo "<script>window.location.href='createbillview.php'</script>";
//header("Location:createbillview.php");	
}
if(!empty($_GET['update_id']) && $_GET['update_id']) {
$invoiceValues = $invoice->getInvoice($_GET['update_id']);		
$invoiceItems = $invoice->getInvoiceItems($_GET['update_id']);		
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
<link rel="stylesheet" href="bootstrap/css/style.css">

<style>
    .container-fluid{
        margin: 45px;        
    }
</style>




</head>

<?php include('../nav.php');?>
<br><br><br><br><br>

<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h3 style="color: red;"><B>MANAGE BILL</B></h3></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

<div class="container-fluid">
    	<form action=""  method="post" > 
	    <div class="container-fluid">
		      	<input id="currency" type="hidden" value="$">
				  <div class="row"> 
				<div class="container">
				
						  <div class="form-group">
						  <label style="color:green;"><b>REGISTRATION NUMBER #</b></label>
						<input type="number"  readonly  value="<?php echo $invoiceValues['hospitalnos']; ?>"   class="form-control" name="hospitalnos"  autocomplete="off">
					</div>
		
					<div class="form-group">
					<label style="color:red;"><b>BILLING NUMBER</b></label>
						<input type="number"  readonly   value="<?php echo $invoiceValues['billingnos']; ?>"  class="form-control" name="billingnos"  autocomplete="off">
					</div>


					<div class="form-group">
					<label style="color:red;"><b>RECIEPT PAYMENT #</b></label>
						<input required type="text"  class="form-control" name="rrrcode"  value="<?php echo $invoiceValues['rrrcode']; ?>"   autocomplete="off">
					</div>	  	  
		  		</div>  

					  <div class="container">
	<div class="form-group">
		<label style="color:red;"><b>DATE</b></label>
						<input type="date"   readonly   value="<?php echo $invoiceValues['date2']; ?>" class="form-control" name="date2"  autocomplete="off">
					</div>


					<div class="form-group">
					<label style="color:green;"><b>FULLNAME</b></label>
						<input type="text"  readonly    value="<?php echo $invoiceValues['order_receiver_name']; ?>"  class="form-control" name="companyName" id="PatientName" placeholder="FullName" autocomplete="off">
					</div>



					<div class="form-group">
					<label style="color:green;"><b>NOK=NAME</b></label>
						<input type="text"   readonly       class="form-control" value="<?php echo $invoiceValues['nokname']; ?>" name="nokname" id="nokname" placeholder="nokName" autocomplete="off">
					</div>



					<div class="form-group">
					<label style="color:green;"><b>NOK=FONE NUMBER</b></label>
						<input type="number"   readonly       class="form-control"  value="<?php echo $invoiceValues['noknumber']; ?>"  name="noknumber"id="address" placeholder="Nok number">
					</div>



					<div class="form-group">
					<label style="color:green;"><b>NOK-EMAILADDRESS</b></label>
						<input type="text"     readonly        class="form-control"   value="<?php echo $invoiceValues['nokemail']; ?>" name="nokemail" id="address" placeholder="Email Address">
					</div>
					
				

		
		      		</div>
		      	</div>
		      	<div class="row">
		      		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
		      			<table class="table table-bordered table-hover" id="invoiceItem">	
							<tr>
								<th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
								<th width="1%"></th>
								<th width="20%">Item Name</th>
								<th width="10%">Quantity</th>
								<th width="15%">Price</th>								
								<th width="15%">Total</th>
							</tr>
							<?php 
							$count = 0;
							foreach($invoiceItems as $invoiceItem){
								$count++;
							?>								
							<tr>
								<td><input    class="itemRow" type="checkbox"></td>
								<td><input required type="hidden" value="<?php echo $invoiceItem["item_code"]; ?>" name="productCode[]" id="productCode_<?php echo $count; ?>" class="form-control" autocomplete="off"></td>
<td>	
<select name="productName[]" id="productName_<?php echo $count; ?>" class="form-control" >
<option value="">-PLS SELECT-</option>
<option value="ACCOMODATION" <?php if (isset($invoiceItem['item_name']) && $invoiceItem['item_name'] == 'ACCOMODATION') {
            echo 'selected';
        } ?>>ACCOMODATION</option>
			<option value="FEEDING" <?php if (isset($invoiceItem['item_name']) && $invoiceItem['item_name'] == 'FEEDING') {
            echo 'selected';
        } ?>>FEEDING</option>
<option value="DRUG DEPOSIT" <?php if (isset($invoiceItem['item_name']) && $invoiceItem['item_name'] == 'DRUG DEPOSIT') {
            echo 'selected';
        } ?>>DRUG DEPOSIT</option>
  <option value="OCCUPATIONAL THERAPY" <?php if (isset($invoiceItem['item_name']) && $invoiceItem['item_name'] == 'OCCUPATIONAL THERAPY') {
            echo 'selected';
        } ?>>OCCUPATIONAL THERAPY</option>
 <option value="PLAN CHEST XRAY" <?php if (isset($invoiceItem['item_name']) && $invoiceItem['item_name'] == 'PLAN CHEST XRAY') {
            echo 'selected';
        } ?>>PLAN CHEST XRAY</option>
  <option value="SERVICE CHARGE" <?php if (isset($invoiceItem['item_name']) && $invoiceItem['item_name'] == 'SERVICE CHARGE') {
            echo 'selected';
        } ?>>SERVICE CHARGE</option>
 <option value="REPATRIATION FEE" <?php if (isset($invoiceItem['item_name']) && $invoiceItem['item_name'] == 'REPATRIATION FEE') {
            echo 'selected';
        } ?>>REPATRIATION FEE</option>
  <option value="OTHERS" <?php if (isset($invoiceItem['item_name']) && $invoiceItem['item_name'] == 'OTHERS') {
            echo 'selected';
        } ?>>OTHERS</option>
  </select>
</td>								
									<td><input required type="number" value="<?php echo $invoiceItem["order_item_quantity"]; ?>" name="quantity[]" id="quantity_<?php echo $count; ?>" class="form-control quantity" autocomplete="off"></td>
								<td><input required  type="number" value="<?php echo $invoiceItem["order_item_price"]; ?>" name="price[]" id="price_<?php echo $count; ?>" class="form-control price" autocomplete="off"></td>
								<td><input readonly type="number" value="<?php echo $invoiceItem["order_item_final_amount"]; ?>" name="total[]" id="total_<?php echo $count; ?>" class="form-control total" autocomplete="off"></td>
								<input type="hidden" value="<?php echo $invoiceItem['order_item_id']; ?>" class="form-control" name="itemId[]">
							</tr>	
							<?php } ?>		
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
					
							
									<input  readonly    value="<?php echo $invoiceValues['order_total_before_tax']; ?>" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
					
							</div>
							<div class="form-group">
							<label style="color:red;"><b>Tax Rate: </b></label>
								<input   readonly   value="<?php echo $invoiceValues['order_tax_per']; ?>" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tax Rate">
						</div>



					
							<div class="form-group">
							<label style="color:red;"><b>Tax Amount:</b>  </label>
								<input  readonly     value="<?php echo $invoiceValues['order_total_tax']; ?>" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
								</div>
							


							<div class="form-group">
							<label style="color:red;"><b>Total:</b>  </label>
							<input   readonly   value="<?php echo $invoiceValues['order_total_after_tax']; ?>" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
						</div>

							<div class="form-group">
							<label style="color:red;"><b>Amount Paid: </b>  </label>
								<input required  value="<?php echo $invoiceValues['order_amount_paid']; ?>" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Amount Paid">
							</div>

							<div class="form-group">
							<label style="color:red;"><b>Amount Due: </b>   </label>
						
									<input   readonly   value="<?php echo $invoiceValues['order_total_amount_due']; ?>" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Amount Due">
								</div>
			
		
					<div class="form-group">
							<input type="hidden" value="<?php echo $_SESSION['id']; ?>" class="form-control" name="userId">
							<input type="hidden" value="<?php echo $invoiceValues['order_id']; ?>" class="form-control" name="invoiceId" id="invoiceId">
			      			<input data-loading-text="Updating Invoice..." type="submit" name="invoice_btn" value="Manage Bill" class="form-control btn btn-success submit_btn invoice-save-btm">
			      		</div>
						
		   
		      	<div class="clearfix"></div>		      	
	     
		</form>			
    </div>
</div>	
<?php include('../footer.php');?>
</div>
</body></html>