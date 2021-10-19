<?php

session_start();

if (!isset($_SESSION['UserEmail'])) {
  header('location:sign.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Testing Home</title>
</head>
<body>
  <?php include "side-nav.php";?>
  <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
    <input name="signout" type="submit" value="Logout">
  </form>
  <script src="plugins/jquery.js"></script>
</body>
</html>