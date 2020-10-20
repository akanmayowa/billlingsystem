<?php

require_once "connection.php";

if(isset($_REQUEST['btn_register'])) //check button name "btn_register" and set this
{
	$username	= $_REQUEST['txt_username'];	//textbox name "txt_username"
	$email		= $_REQUEST['txt_email'];	//textbox name "txt_email"
	$password	= $_REQUEST['txt_password'];	//textbox name "txt_password"
	$role		= $_REQUEST['txt_role'];	//select option name "txt_role"
		
	if(empty($username)){
		$errorMsg[]="Please enter username";	//check username textbox not empty or null
	}
	else if(empty($email)){
		$errorMsg[]="Please enter email";	//check email textbox not empty or null
	}
	else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errorMsg[]="Please enter a valid email address";	//check proper email format 
	}
	else if(empty($password)){
		$errorMsg[]="Please enter password";	//check passowrd textbox not empty or null
	}
	else if(strlen($password) < 6){
		$errorMsg[] = "Password must be atleast 6 characters";	//check passowrd must be 6 characters
	}
	else if(empty($role)){
		$errorMsg[]="Please select role";	//check not select role 
	}
	else
	{	
		try
		{	
			$select_stmt=$db->prepare("SELECT username, email FROM masterlogin 
										WHERE username=:uname OR email=:uemail"); // sql select query
			$select_stmt->bindParam(":uname",$username);   
			$select_stmt->bindParam(":uemail",$email);      //bind parameters
			$select_stmt->execute();
			$row=$select_stmt->fetch(PDO::FETCH_ASSOC);	//execute query and fetch record store in "$row" variable
			
			if($row["username"]==$username){
				$errorMsg[]="Sorry username already exists";	//check new user type username already exists or not in username textbox
			}
			else if($row["email"]==$email){
				$errorMsg[]="Sorry email already exists";	//check new user type email already exists or not in email textbox
			}
			
			else if(!isset($errorMsg))
			{
				$insert_stmt=$db->prepare("INSERT INTO masterlogin(username,email,password,role) VALUES(:uname,:uemail,:upassword,:urole)"); //sql insert query					
				$insert_stmt->bindParam(":uname",$username);	
				$insert_stmt->bindParam(":uemail",$email);	  		//bind all parameter 
				$insert_stmt->bindParam(":upassword",$password);
				$insert_stmt->bindParam(":urole",$role);
				
				if($insert_stmt->execute())
				{
					$registerMsg="Register Successfully.....Wait Login page"; //execute query success message
					header("refresh:4;index.php"); //refresh 4 second and redirect to index.php page
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=2.0">
<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery/jquery.min.js"></script>
  <script src="bootstrap/js/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <style>
body {
    font-family: Arial, Helvetica, sans-serif;
   
}

* {
    box-sizing: border-box;
}

/* Add padding to containers */
.container {
    padding: 16px;
    background-color: white;
}

/* Full-width input fields */
input[type=text], input[type=password] 
{
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

input[type=text]:focus, input[type=password]:focus {
    background-color: #ddd;
    outline: none;
}


input[type=email], input[type=select] 
{
    width: 100%;
    padding: 15px;
    margin: 5px 0 22px 0;
    display: inline-block;
    border: none;
    background: #f1f1f1;
}

input[type=email]:focus, input[type=select]:focus {
    background-color: #ddd;
    outline: none;
}
/* Overwrite default styles of hr */
hr {
    border: 1px solid #f1f1f1;
    margin-bottom: 25px;
}

/* Set a style for the submit button */
.registerbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
    opacity: 0.9;
}

.registerbtn:hover {
    opacity: 1;
}

/* Add a blue text color to links */
a {
    color: dodgerblue;
}

/* Set a grey background color and center the text of the "sign in" section */
.signin {
    background-color: #f1f1f1;
    text-align: center;
}
</style>	
</head>

	<body>
	
	

	<?php include('admin/nav.php');?>	


	<br><br>	<br><br>
	<div class="wrapper">
	
	<div class="container">
			
		<div class="col-lg-12">
		
		<?php
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger">
					<strong>WRONG ! <?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		if(isset($registerMsg))
		{
		?>
			<div class="alert alert-success">
				<strong>SUCCESS ! <?php echo $registerMsg; ?></strong>
			</div>
        <?php
		}
		?>   
		
		</div>	</div>	</div>

		
			<div class="table-responsive">
							<table class="table table-dark table-striped">
                                    <thead>
                                        <tr>
                                            <th><h2 style="color: red;">Register User</h2></th>
                                        </tr>
                                    </thead>
                               
                                </table>
                            </div>

			
				<form method="post" class="form-horizontal">
  <div class="container">
   

    <label for="email"><b>USERNAME</b></label>
    <input type="text" required placeholder="enter username"  name="txt_username" required>

	
    <label for="email"><b>Email</b></label>

    <input type="email" required name="txt_email"  placeholder="enter email" required>

    <label for="psw-repeat"><b>Password</b></label>
    <input type="password" name="txt_password" placeholder="enter passowrd" required>
   


	<label for="select"><b>Select Type</b></label>
					<select required style="width: 100%;padding: 15px;margin: 5px 0 22px 0;display: inline-block;border: none;background: #f1f1f1;" type="text" required name="txt_role">
						<option value="" selected="selected"> - Select Role - </option>
						<!--<option value="admin">Admin</option>-->
						<option value="supervisor">Supervisor</option>
						<option value="user">User</option>
					</select>
    <hr>
	<input type="submit"  name="btn_register" class="registerbtn" value="Register">
		
		
  </div>

</form>
	<?php include('admin/footer.php');?>									
	</body>
</html>