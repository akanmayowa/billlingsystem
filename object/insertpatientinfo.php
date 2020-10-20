<?php

require_once 'config.php';
if(isset($_POST['insert']))
{
$hospitalnos=$_POST['hospitalnos'];
$surname=$_POST['surname'];
$firstname=$_POST['firstname'];
$nokname=$_POST['nokname'];
$noknumber=$_POST['noknumber'];
$ward=$_POST['ward'];
$nokemail=$_POST['nokemail'];
$ptype=$_POST['ptype'];
$sql="INSERT INTO patientinfo(hospitalnos,surname,firstname,nokname,noknumber,ward,nokemail,ptype)
 VALUES(:hospitalnos,:surname,:firstname,:nokname,:noknumber,:ward,:nokemail,:ptype)";
$query = $dbh->prepare($sql);
$query->bindParam(':hospitalnos',$hospitalnos,PDO::PARAM_STR);
$query->bindParam(':surname',$surname,PDO::PARAM_STR);
$query->bindParam(':firstname',$firstname,PDO::PARAM_STR);
$query->bindParam(':nokname',$nokname,PDO::PARAM_STR);
$query->bindParam(':noknumber',$noknumber,PDO::PARAM_STR);
$query->bindParam(':ward',$ward,PDO::PARAM_STR);
$query->bindParam(':ptype',$ptype,PDO::PARAM_STR);
$query->bindParam(':nokemail',$nokemail,PDO::PARAM_STR);

$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
echo "<script>alert('Record inserted successfully');</script>";
echo "<script>window.location.href='patientview.php'</script>";
}
else
{
echo "<script>alert('Something went wrong. Please try again');</script>";
echo "<script>window.location.href='patientview.php'</script>";
}
}
?>