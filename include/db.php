<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbase = "twincom_wms";

$conn = mysqli_connect($servername, $username, $password,$dbase);
if (!$conn) {
    die("Connection failed: ask me" . $conn->connect_error);
}

?> 