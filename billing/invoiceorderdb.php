
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

$sql = "
 CREATE TABLE  invoice_order
  (
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_id int(22) NOT NULL,
billingnos varchar(150) NOT NULL UNIQUE,
hospitalnos int(150) NOT NULL,
order_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
nokname varchar(120) NOT NULL,
noknumber varchar(255) NOT NULL,
nokemail varchar(255) NOT NULL,
date2 date NOT NULL,
order_receiver_name varchar(250) NOT NULL,
order_total_before_tax decimal(10,2) NOT NULL,
order_total_tax decimal(10,2) NOT NULL,
order_tax_per varchar(250) NOT NULL,
order_total_after_tax double(10,2) NOT NULL,
order_amount_paid decimal(10,2) NOT NULL,
order_total_amount_due decimal(10,2) NOT NULL,
rrrcode varchar(200) NULL,
ptype varchar(200) NOT NULL,
ward varchar(200) NULL
) ";


if ($mysql->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $mysql->error;
}

$mysql->close();
?>
