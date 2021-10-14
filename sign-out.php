<?php

require_once "config.php";

session_start();

if (!isset($_SESSION['UserEmail'])) {
  header('location:sign.php');
}

$UserEmail = $_SESSION['UserEmail'];

$sql = "UPDATE users SET UserStatus = 'offline' WHERE UserEmail = '$UserEmail'";

mysqli_query($conn, $sql);


session_destroy();


header('Refresh:3;url=sign.php');

?>

<div class="sign-out">
  <img src="imgs/logo.png" alt="">
  <p>Signing Out ...</p>
</div>

<style>
@font-face {
  font-family: ubuntu;
  src: url(fonts/ubuntu.ttf);
}

.sign-out {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 50px;
  text-align: center;
}

.sign-out img {
  width: 200px;
  margin-bottom: 20px;
}

.sign-out p {
  font-family: ubuntu, arial;
  color: #333;
  font-weight: bold;
}
</style>