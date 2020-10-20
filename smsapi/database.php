<?php
error_reporting(1);
$servername = "localhost";
$username = "root";
$password = "";
$dbname= "fnphybilling";
$conn = new mysqli($servername, $username, $password ,$dbname);
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
?>