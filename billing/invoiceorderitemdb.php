
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

$sql = 
"   CREATE TABLE invoice_order_item 
(
    order_item_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    order_id INT(44) NOT NULL,
  item_code INT(44) NOT NULL,
    item_name varchar(250) NOT NULL,
    order_item_quantity decimal(10,2) NOT NULL,
    order_item_price decimal(10,2) NOT NULL,
    order_item_final_amount decimal(10,2) NOT NULL

)";


if ($mysql->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $mysql->error;
}

$mysql->close();
?>