<?php

$host = "localhost";
$dbuser = "root";
$dbpassword = "";
$dbname = "userdb";
$conn = mysqli_connect($host, $dbuser, $dbpassword, $dbname);
if(!$conn) {
    die("Error!");
}

?>
