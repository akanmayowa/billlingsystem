
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

  <script src="bootstrap/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="datatables-master/css/jquery.dataTables.min.css">
  
    <link rel="stylesheet" type="text/css" href="datatables-master/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="datatables-master/css/buttons.dataTables.min.css">
    

    <link rel="stylesheet" type="text/css" href=" https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js">
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css">
    <script type="text/javascript">      
// The plugin function for adding a new filtering routine
$.fn.dataTableExt.afnFiltering.push(
    function(oSettings, aData, iDataIndex){
        var dateStart = parseDateValue($("#min").val());
        var dateEnd = parseDateValue($("#max").val());
       
        // aData represents the table structure as an array of columns, so the script access the date value 
        // in the first column of the table via aData[0]
        var evalDate= parseDateValue(aData[0]);

        if (evalDate >= dateStart && evalDate <= dateEnd) {
            return true;
        }
        else {
            return false;
            
        }
});

// Convert a dd M yyyy date value into a numeric string for comparison (example 12 Oct 2010 becomes 20101012
function parseDateValue(rawDate) {
	var month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
	var dateArray = rawDate.split(" ");
	var numMonth = Number(month.indexOf(dateArray[1]))+1;
	if(numMonth.toString().length<2){
		numMonth = "0"+numMonth;
	} else {
		numMonth = numMonth.toString();
	}
	var parsedDate = dateArray[2] + numMonth + dateArray[0];
	return parsedDate;
}
		
var oTable = $('#maintable').dataTable({
    "iDisplayLength": 25,
    "bStateSave": false,
    "lengthChange": false,
    "ordering": false,
    "info":     false
});

$('#min,#max').datepicker({
    format: "dd M yyyy",
    weekStart: 1,
    daysOfWeekHighlighted: "0",
    autoclose: true,
    todayHighlight: true
});

// Add event listeners to the two range filtering inputs
$("#min").datepicker().on( 'changeDate', function() {
	oTable.fnDraw(); 
});
$("#max").datepicker().on( 'changeDate', function() { 
	oTable.fnDraw(); 
});
</script>  




</head>
<body>

<?php include('../nav.php');?>	

<BR><BR><p></p>


<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h4 style="color: red;"><B> BILLING HISTORY</B></h4></th>
                                        </tr>
                                    </thead>   
                                </table>
                            </div>


      <div class="float-left">
<table class="table table-dark">
  <thead>
    <tr> 
      <th style="color: red;">REGISTRATION NUMBER</th>
      <th><?php echo htmlentities($result->hospitalnos); ?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th style="color: red;">PATIENT NAME:</th>
      <td><?php echo htmlentities($result->surname); ?><?php echo htmlentities($result->firstname); ?></td>
    </tr>
  </tbody>
</table>
</div>




<p></p>

<div class="form-group">
	<div class="input-group input-daterange">
		<input type="text" id="min" class="form-control" value="04 Nov 2016">
		<span class="input-group-addon">to</span>
		<input type="text" id="max" class="form-control" value="04 Nov 2016">
	</div>
</div>



<div class="table-responsive">

   <table   id="maintable" class="table table-dark table-striped"  cellspacing="0" width="100%">
      
   <thead>
          <tr>
            <th>Billing No.</th>
            <th>Date of Billing</th>
            <th><p>CUMULATIVE</p>&Sigma;AmountPaid</th>
            <th>&Sigma;Bill Total</th>             
            <th>&Sigma;Balance</th>
            <th  style="background-color: blue;color: white;" ><p>LEDGER</p>Credit</th>
            <th  style="background-color: red;color: white;" >Debit</th>
            <th  style="background-color: green;color: white;" >Balance</th>
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
    $balance = 0;
?>
<tbody>
<tr>           
    <td><?php echo htmlentities($result->billingnos);?></td>

    <td><?php echo htmlentities($result->order_date);?></td>


            <td><?php echo $y;?></td>
            <td><?php echo $x;?></th>
            <td><?php echo $z;?></td>




    <td style="background-color: blue;color: white;"    ><?php echo $result->order_amount_paid > 0 ? $result->order_amount_paid : '' ?></td>
            <td  style="background-color: red;color: white;"   ><?php echo $result->order_total_after_tax > 0 ? $result->order_total_after_tax : '' ?></td>
            <td  style="background-color: green;color: white;" ><?php echo $balance = ($balance + $result->order_total_after_tax - $result->order_amount_paid) ?></td>
  
  </tr>
  <?php
$cnt++;
}} ?>    
  </tbody>
          


<tfoot style="background-color: #c0c0c0; color: #ffffff; font-size: 0.8em; " class="table table-dark table-striped" >
    <tr>
            <th>Billing No.</th>
       
            <th>AmountPaid</th>
            <th>Bill Total</th>
            <th>Balance</th>
            <th  style="background-color: blue;color: white;" >Credit</th>
            <th  style="background-color: red;color: white;">Debit</th>
            <th  style="background-color: green;color: white;">Balance</th>
    </tr>
    </tfoot>


    <?php }} ?>    
</table>
</div>

  
<div class="float-left">
 <table  class="table table-dark table-striped">
  <thead>
    <tr> 
      <th h5 class="card-title text-LEFT" style="background-color: red;color: white;">&Sigma;-DEBIT</th>
      <th  style="background-color: red;color: white;"><?php echo $x;?></th>
    </tr>
  </thead>
  <tbody>



    <tr>
      <th h5 class="card-title text-LEFT" style="background-color: blue;color: white;">&Sigma;-CREDIT</th>
      <td style="background-color: blue;color: white;"><?php echo $y;?></td>
    </tr>

    <tr>
      <th h5 class="card-title text-LEFT" style="background-color: green;color: white;">&Sigma;-BALANCE</th>
      <td style="background-color: green;color: white;"><?php echo $z;?></td>
    </tr>
  </tbody>
</table>
</div>
 

<script type="text/javascript" src="datatables-master/js/jquery-2.2.4.min.js"></script>
<script type="text/javascript" src="datatables-master/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="datatables-master/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="datatables-master/js/jszip.min.js"></script>
<script type="text/javascript" src="datatables-master/js/pdfmake.min.js"></script>
<script type="text/javascript" src="datatables-master/js/vfs_fonts.js"></script>
<script type="text/javascript" src="datatables-master/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="datatables-master/js/buttons.print.min.js"></script>
<script type="text/javascript" src="datatables-master/js/app.js"></script>
<script type="text/javascript" src="datatables-master/js/jquery.mark.min.js"></script>
<script type="text/javascript" src="datatables-master/js/datatables.mark.js"></script>
<script type="text/javascript" src="datatables-master/js/buttons.colVis.min.js"></script>   
    <?php include('../footer.php');?>	
    
</body>
</html>
