<?php

session_start();

require_once "config.php";

if (isset($_SESSION['UserEmail'])) {
  header('location:home.php');
}


@$UserEmail = $_POST['UserEmail'];

@$UserPassword = $_POST['UserPassword'];

if (isset($_POST['signup'])) {
  // Sql For Check IF Email In Use
  $sqlce = "SELECT * FROM users WHERE UserEmail = '$UserEmail'";
  $resultce = mysqli_query($conn, $sqlce);
  if ($resultce->num_rows > 0) {
    $msg = "Email Is Already Register";
  } else {
    header("Location:sign-up.php");
    $_SESSION['ReEmail'] = $_POST['UserEmail'];
  }
}

if (isset($_POST['signin'])) {
  // Sql For Sign In
  $sqlsin = "SELECT * FROM users WHERE UserEmail = '$UserEmail'AND UserPassword = '$UserPassword'";
  $resultsin = mysqli_query($conn, $sqlsin);
  if ($resultsin->num_rows > 0) {
    $rowuser = $resultsin->fetch_assoc();
    $_SESSION['UserID'] = $rowuser['ID'];
    $_SESSION['UserEmail'] = $rowuser['UserEmail'];
    $_SESSION['UserName'] = $rowuser['UserName'];
    $_SESSION['ID'] = $rowuser['UserID'];
    
    $UserEmail = $_SESSION['UserEmail'];

    $sql = "UPDATE users SET UserStatus = 'online' WHERE UserEmail = '$UserEmail'";

    mysqli_query($conn, $sql);

    header("Refresh:3;url=home.php");
  } else {
    $msg2 = "Wrong Password Or Email";
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign in Or Sign Up</title>
  <link rel="stylesheet" href="css/my-frame.css">
  <link rel="stylesheet" href="css/sign.css">
</head>

<body>
  <?php include "nav.php"?>

  <div class="sign-container">

    <div class="sign-in">

      <div class="content">
        <div class="head mb2">
          Sign In
        </div>
        <form action="" method="POST">
          <div class="input-feild">
            <label for="UserEmail" class="mb1">Email</label>
            <input name="UserEmail" id="UserEmail" class="mb1" type="email" placeholder="Enter Your Email" required>
          </div>
          <div class="input-feild">
            <label for="UserPassword" class="mb1">Password</label>
            <input name="UserPassword" id="UserPassword" class="mb1" type="password" placeholder="Enter Your Password"
              required>
          </div>
          <div class="input-feild">
            <input name="signin" type="Submit" Value="Sign In">
            <p class="screen"><?php echo @$msg2;?></p>
          </div>
        </form>
      </div>

    </div>

    <div class="sign-up">
      <div class="content">
        <div class="head mb2">
          Sign Up
        </div>
        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
          <div class="input-feild">
            <label for="UserEmail2" class="mb1">Email</label>
            <input name="UserEmail" id="UserEmail2" class="mb1" type="email" placeholder="Enter Your Email" required>
          </div>
          <div class="input-feild">
            <input name="signup" type="submit" Value="Sign Up">
            <p class="screen"><?php echo @$msg;?></p>
          </div>
        </form>
      </div>
    </div>

  </div>

  <!-- Start Small Devices -->

  <div class="small-sign">
    <div class="switch">
      <ul class="list">
        <li class="center active" id="signin">Sign In</li>
        <li class="center" id="signup">Sign Up</li>
      </ul>
    </div>
    <div class="box-content">
      <div class="signin">
        <form action="" method="POST">
          <div class="input-feild">
            <label for="UserEmail3" class="mb1">Email</label>
            <input name="UserEmail" id="UserEmail3" class="mb1" type="email" placeholder="Enter Your Email" required>
          </div>
          <div class="input-feild">
            <label for="UserPassword2" class="mb1">Password</label>
            <input name="UserPassword" id="UserPassword2" class="mb1" type="password" placeholder="Enter Your Password"
              required>
          </div>
          <div class="input-feild">
            <input name="signin" type="Submit" Value="Sign In">
            <p class="screen"><?php echo @$msg2;?></p>
          </div>
        </form>
      </div>
      <div class="signup">
        <form action="" method="POST">
          <div class="input-feild">
            <label for="UserEmail4" class="mb1">Email</label>
            <input name="UserEmail" id="UserEmail4" class="mb1" type="email" placeholder="Enter Your Email">
          </div>
          <div class="input-feild">
            <input name="signup" type="submit" Value="Sign Up">
            <p class="screen"><?php echo @$msg;?></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- End Small Devices -->

  <?php include "footer.php"?>

  <script src="plugins/jquery.js"></script>
  <script>
  $('.switch ul li:first-of-type').click(function() {
    $('.signup').css("display", "none")
    $('.signin').css("display", "block")
    $(this).addClass('active')
    $('#signup').removeClass('active')

  })

  $('.switch ul li:last-of-type').click(function() {
    $('.signin').css("display", "none")
    $('.signup').css("display", "block")
    $(this).addClass('active')
    $('#signin').removeClass('active')
  })
  </script>
</body>

</html>