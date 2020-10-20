<?php
require_once 'config.php';
if(isset($_POST['update']))
{
$userid=intval($_GET['id']);
$hospitalnos=$_POST['hospitalnos'];
$surname=$_POST['surname'];
$firstname=$_POST['firstname'];
$nokname=$_POST['nokname'];
$noknumber=$_POST['noknumber'];
$ward=$_POST['ward'];
$nokemail=$_POST['nokemail'];
$ptype=$_POST['ptype'];
$sql="update patientinfo set hospitalnos=:hospitalnos,surname=:surname,firstname=:firstname,nokname=:nokname,noknumber=:noknumber,ward=:ward,nokemail=:nokemail,ptype=:ptype where id=:uid";
$query = $dbh->prepare($sql);
$query->bindParam(':hospitalnos',$hospitalnos,PDO::PARAM_STR);
$query->bindParam(':surname',$surname,PDO::PARAM_STR);
$query->bindParam(':firstname',$firstname,PDO::PARAM_STR);
$query->bindParam(':nokname',$nokname,PDO::PARAM_STR);
$query->bindParam(':noknumber',$noknumber,PDO::PARAM_STR);
$query->bindParam(':ward',$ward,PDO::PARAM_STR);
$query->bindParam(':ptype',$ptype,PDO::PARAM_STR);
$query->bindParam(':nokemail',$nokemail,PDO::PARAM_STR);
$query->bindParam(':uid',$userid,PDO::PARAM_STR);
$query->execute();
echo "<script>alert('Record Updated successfully');</script>";
echo "<script>window.location.href='patientview.php'</script>";
}
?>
