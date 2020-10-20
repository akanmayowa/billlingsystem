<?php 
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();


?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
<script src="jquery/jquery-ui.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<title></title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
</head>
<body>


<?php include('nav.php');?>
<div>
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
          <th>Hospital Fdr #</th>
            <th>Billing No.</th>
            <th>Billing S/N#</th>
            <th>Patient Name</th>
            <th>Billing Date</th>
            <th>Bill Total</th>
            <th>Print</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <?php		
		$invoiceList = $invoice->getInvoiceList();
        foreach($invoiceList as $invoiceDetails)
        {
			$invoiceDate = date("Y-m-d", strtotime($invoiceDetails["order_date"]));
            echo '
               <tr>
              
               <td>'.$invoiceDetails["hospitalnos"].'</td>
               <td>'.$invoiceDetails["billingnos"].'</td>
                <td>'.$invoiceDetails["order_id"].'</td>
                <td>'.$invoiceDetails["order_receiver_name"].'</td>
                <td>'.$invoiceDate.'</td>
                <td>'.$invoiceDetails["order_total_after_tax"].'</td>


                <td><a href="print_invoice.php?invoice_id='.$invoiceDetails["order_id"].'" title="Print Bill"><span class="glyphicon glyphicon-print"></span></a></td>
                <td><a href="edit_invoice.php?update_id='.$invoiceDetails["order_id"].'"  title="Edit Bill"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="#" id="'.$invoiceDetails["order_id"].'" class="deleteInvoice"  title="Delete Bill"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
        }       
        ?>
      </table>	
</div>	
<?php include('footer.php');?>
</div>
</body>
</html>