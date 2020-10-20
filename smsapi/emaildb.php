
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fnphybilling";
$mysql = new mysqli($servername, $username, $password, $dbname);
if ($mysql->connect_error)
{
    die("Connection failed: " . $mysql->connect_error);
} 

$sql = "CREATE TABLE emaildb
(
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  nokname varchar(150) NOT NULL,
  msg varchar(250) NOT NULL,
  nokemail varchar(150) NOT NULL,
  amountdue varchar(150) NOT NULL,
  billstatus varchar(250) NOT NULL,
  billingnos varchar(150) NOT NULL,
  patientname varchar(250) NOT NULL,
  datedue varchar(100) NOT NULL
)";


if ($mysql->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $mysql->error;
}

$mysql->close();
?>