<?php
require_once 'connection.php';

session_start();

if(isset($_SESSION["admin_login"]))
{
	header("location:/index/fnphybilling/admin/admin_home.php");
}


if(isset($_REQUEST['btn_login']))	//login button name is "btn_login" and set this
{
	$email		=$_REQUEST["txt_email"];	//textbox name "txt_email"
	$password	=$_REQUEST["txt_password"];	//textbox name "txt_password"
	$role		=$_REQUEST["txt_role"];		//select option name "txt_role"

	if(empty($email)){
		$errorMsg[]="please enter email";	//check email textbox not empty or null
	}
	else if(empty($password)){
		$errorMsg[]="please enter password";	//check passowrd textbox not empty or null
	}
	else if(empty($role)){
		$errorMsg[]="please select role";	//check select option not empty or null
	}
	else if($email AND $password AND $role)
	{
		try
		{
			$select_stmt=$db->prepare("SELECT id,email,password,role FROM masterlogin
										WHERE
										email=:uemail AND password=:upassword AND role=:urole"); //sql select query
			$select_stmt->bindParam(":uemail",$email);
			$select_stmt->bindParam(":upassword",$password);	//bind all parameter
			$select_stmt->bindParam(":urole",$role);
			$select_stmt->execute();

			while($row=$select_stmt->fetch(PDO::FETCH_ASSOC))
			{
				$id		=$row["id"];
				$dbemail	=$row["email"];
				$dbpassword	=$row["password"];
				$dbrole		=$row["role"];
			}
			if($email!=null AND $password!=null AND $role!=null)
				if($select_stmt->rowCount()>0)
				{
					if($email==$dbemail AND $password==$dbpassword AND $role==$dbrole)
					{
						switch($dbrole)		//role base user login start
						{
							case "admin":
								$_SESSION["admin_login"]=$email;
								$_SESSION['id'] = $id;
								$loginMsg="Admin... Successfully Login...";
								header("refresh:1; /index/fnphybilling/admin/admin_home.php");
								break;

							case "supervisor";
								$_SESSION["supervisor_login"]=$email;
								$_SESSION['id'] = $id;
								$loginMsg="supervisor... Successfully Login...";
								header("refresh:3;supervisor/supervisor_home.php");
								break;

							case "user":
								$_SESSION["user_login"]=$email;
								$_SESSION['id'] = $id;
								$loginMsg="User... Successfully Login...";
								header("refresh:3;user/user_home.php");
								break;

							default:
								$errorMsg[]="wrong email or password or role";
						}
					}
					else
					{
						$errorMsg[]="wrong email or password or role";
					}
				}
				else
				{
					$errorMsg[]="wrong email or password or role";
				}

			else
			{
				$errorMsg[]="wrong email or password or role";
			}
		}

		catch(PDOException $e)
		{
			$e->getMessage();
		}
	}
	else
	{
		$errorMsg[]="wrong email or password or role";
	}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <script src="bootstrap/jquery/jquery.min.js"></script>
  <script src="bootstrap/js/popper.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
<style>
:root {
  --input-padding-x: 1.5rem;
  --input-padding-y: .75rem;
}

body {
  background: #007bff;
  background: linear-gradient(to right, green, green);
}

.card-signin {
  border: 0;
  border-radius: 1rem;
  box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
}

.card-signin .card-title {
  margin-bottom: 2rem;
  font-weight: 300;
  font-size: 1.5rem;
}

.card-signin .card-body {
  padding: 2rem;
}

.form-signin {
  width: 100%;
}

.form-signin .btn {
  font-size: 80%;
  border-radius: 5rem;
  letter-spacing: .1rem;
  font-weight: bold;
  padding: 1rem;
  transition: all 0.2s;
}

.form-label-group {
  position: relative;
  margin-bottom: 1rem;
}

.form-label-group input {
  height: auto;
  border-radius: 2rem;
}

.form-label-group>input,
.form-label-group>label {
  padding: var(--input-padding-y) var(--input-padding-x);
}

.form-label-group>label {
  position: absolute;
  top: 0;
  left: 0;
  display: block;
  width: 100%;
  margin-bottom: 0;
  /* Override default `<label>` margin */
  line-height: 1.5;
  color: #495057;
  border: 1px solid transparent;
  border-radius: .25rem;
  transition: all .1s ease-in-out;
}

.form-label-group input::-webkit-input-placeholder {
  color: transparent;
}

.form-label-group input:-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-ms-input-placeholder {
  color: transparent;
}

.form-label-group input::-moz-placeholder {
  color: transparent;
}

.form-label-group input::placeholder {
  color: transparent;
}

.form-label-group input:not(:placeholder-shown) {
  padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
  padding-bottom: calc(var(--input-padding-y) / 3);
}

.form-label-group input:not(:placeholder-shown)~label {
  padding-top: calc(var(--input-padding-y) / 3);
  padding-bottom: calc(var(--input-padding-y) / 3);
  font-size: 12px;
  color: #777;
}

.btn-google {
  color: white;
  background-color: #ea4335;
}

.btn-facebook {
  color: white;
  background-color: #3b5998;
}

/* Fallback for Edge
-------------------------------------------------- */

@supports (-ms-ime-align: auto) {
  .form-label-group>label {
    display: none;
  }
  .form-label-group input::-ms-input-placeholder {
    color: #777;
  }
}

/* Fallback for IE
-------------------------------------------------- */

@media all and (-ms-high-contrast: none),
(-ms-high-contrast: active) {
  .form-label-group>label {
    display: none;
  }
  .form-label-group input:-ms-input-placeholder {
    color: #777;
  }
}

</style>
</head>
<body>


<?php include('indexnav.php');?>

<br/><br/><br/><br/>
  <div class="container">
    <div class="row">
      <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
  <div class="card card-signin my-5">



		<?php
		if(isset($errorMsg))
		{
			foreach($errorMsg as $error)
			{
			?>
				<div class="alert alert-danger">
					<strong><?php echo $error; ?></strong>
				</div>
            <?php
			}
		}
		if(isset($loginMsg))
		{
		?>
			<div class="alert alert-success">
				<strong>SUCCESS ! <?php echo $loginMsg; ?></strong>
			</div>
        <?php
		}
		?>

          <div class="card-body">
            <h5 class="card-title text-center">
			<img src="/index/fnphybilling/admin/img/yaba2.jpg" width="70" height="70" alt="logo">
			<B style="color: GREEN";>AUTOMATED BILLING</B>
			</h5>

            <form method="post" class="form-signin">
              <div class="form-label-group">
                <input type="email" id="inputEmail" value="akanmayowa@yahoo.com" name="txt_email" class="form-control" placeholder="Email address" required autofocus>
                <label for="inputEmail">Email address</label>
              </div>

              <div class="form-label-group">
                <input type="password" value="123456" name="txt_password" id="inputPassword" class="form-control" placeholder="Password" required>
                <label for="inputPassword">Password</label>
              </div>



              <div class="form-label-group">

					<div class="form-label-group">
						<select class="form-control" name="txt_role">
						<option value="" selected="selected">Role</option>
						<option value="admin">HOD</option>
						<option value="supervisor">Supervisor</option>
						<option value="user">Staff</option>
					</select>	</div>
				</div>

              <button name="btn_login" onclick="window.location.href='admin/admin_home.php';"  class="btn btn-lg btn-primary btn-block text-uppercase" type="submit">Login</button>
              <hr class="my-4">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
