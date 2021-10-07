<?php

$host = "localhost";
$user = "root";
$pass = "";
// $bdname = "onShot";

$conn = mysqli_connect($host,$user,$pass);

if (!$conn) {
  echo "Connection Error => " . mysqli_connect_error();
}