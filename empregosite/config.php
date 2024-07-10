<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbnome = "empregosite";

$conn = new mysqli($servername, $username, $password, $dbnome);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>