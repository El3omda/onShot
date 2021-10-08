<?php

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "onshot";

$conn = mysqli_connect($host,$user,$pass,$dbname);

if (!$conn) {
  echo "Connection Error => " . mysqli_connect_error();
}