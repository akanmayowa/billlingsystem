<?php
class Invoice{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "fnphybilling";   
	private $invoiceUserTable = 'masterlogin';	
    private $invoiceOrderTable = 'invoice_order';
    private $invoiceOrderItemTable = 'invoice_order_item ';
	
    
	private $dbConnect = false;
	public function __construct()
	{
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
	}
	

	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}

	private function getNumRows($sqlQuery)
	 {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}


	public function loginUsers($email, $password){
		$sqlQuery = "
			SELECT id,username,email,password,role
			FROM ".$this->invoiceUserTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	



	public function checkLoggedIn()
	{
		if(!$_SESSION['id']) {
			header("Location:../fnphybilling/index.php");
		}
	}		



	public function saveInvoice($POST)
	 {		
		$sqlInsert = "
			INSERT INTO ".$this->invoiceOrderTable."
			(billingnos,hospitalnos,nokname,noknumber,date2,user_id, order_receiver_name, nokemail, order_total_before_tax,order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due,rrrcode,ward,ptype) 
			VALUES ('".$POST['billingnos']."','".$POST['hospitalnos']."', '".$POST['nokname']."', '".$POST['noknumber']."', '".$POST['date2']."', 
			'".$POST['userId']."', '".$POST['companyName']."', '".$POST['nokemail']."', '".$POST['subTotal']."',
			 '".$POST['taxAmount']."','".$POST['taxRate']."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."','".$POST['amountDue']."','".$POST['rrrcode']."','".$POST['ward']."','".$POST['ptype']."'
			  )";		
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect)
    	or die(mysqli_connect_errno()."	
	    <script>alert('BILL NUMBER ALREADY USED');</script>
         <script>window.location.href='createbillview.php'</script>");

		for ($i = 0; $i < count($POST['productCode']); $i++)
		 {
			$sqlInsertItem = "
			INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
			VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
	}	


	public function updateInvoice($POST) {
		if($POST['invoiceId']) {	
			$sqlInsert = "
				UPDATE ".$this->invoiceOrderTable." SET 
				hospitalnos = '".$POST['hospitalnos']."',
				billingnos = '".$POST['billingnos']."', 
			    nokname = '".$POST['nokname']."',
				noknumber = '".$POST['noknumber']."',
				date2 ='".$POST['date2']."', 
				order_receiver_name = '".$POST['companyName']."',
				nokemail ='".$POST['nokemail']."',
				order_total_before_tax = '".$POST['subTotal']."', 
				order_total_tax = '".$POST['taxAmount']."', 
				order_tax_per = '".$POST['taxRate']."', 
				order_total_after_tax = '".$POST['totalAftertax']."',
			    order_amount_paid = '".$POST['amountPaid']."', 
			   order_total_amount_due = '".$POST['amountDue']."', 
			   rrrcode = '".$POST['rrrcode']."',
			   ward = '".$POST['ward']."',
			   ptype = '".$POST['ptype']."'
		       WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['invoiceId']."'";		
			mysqli_query($this->dbConnect, $sqlInsert)
			or die(mysqli_connect_errno()."	
			<script>alert('PAYMENT NUMBER ALREADY USED');</script>
			 <script>window.location.href='createbillview.php'</script>");
		}		
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++)
		 {			
			$sqlInsertItem = "
				INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
				VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);			
		}       	
	}	





	public function getInvoiceList(){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['id']."'";
		return  $this->getData($sqlQuery);
	}	



	


	public function getInvoice($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['id']."' AND order_id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	


	public function getInvoiceItems($invoiceId){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);	
	}



	public function deleteInvoiceItems($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}


	public function deleteInvoice($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoiceId);	
		return 1;
	}
}
?>