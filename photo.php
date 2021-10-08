<?php

session_start();

require_once "config.php";

if (!isset($_SESSION['UserEmail'])) {
  header("Location:sign.php");
}
// echo "<pre>";
// print_r($_SESSION);
// echo "<pre>";

$target_dir = "imgs/data/users/";
$target_file = $target_dir . basename(@$_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$GLOBALS['ex'] = $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["up"])) {
  @$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }
}

// Check file size
if (@$_FILES["fileToUpload"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" ) {
  $uploadOk = 0;
}

if (isset($_POST['up'])) {
  if ($uploadOk == 1) {
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $newfilename = $_SESSION['UserEmail'] . "-" . $_SESSION['UserName'] . "." . $imageFileType;
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "imgs/data/users/" . $newfilename);
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Upload Your Photo</title>
  <link rel="stylesheet" href="css/my-frame.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sign-up.css">
</head>

<body>

  <?php include "nav.php"?>
  <!-- Start Info Container -->

  <div class="info-container">
    <p class="head mb2 setpasshead">Upload Your Photo</p>
    <p class="head mb2 userinfohead">All Is Done</p>
    <p class="upbtn1 btn b count">Continue</p>
    <form class="uplo" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">
      <label for="image-upload" class="custom-file-upload mb2">
        <i class="fa fa-cloud-upload"></i> Click To Upload
      </label>
      <input type="file" id="image-upload" name="fileToUpload" id="fileToUpload">
      <input class="btn mb2" type="submit" value="Upload Image" name="up">
    </form>

    <!-- Start User Informations -->

    <div class="user-info">

      <div class="img-box mb1">
        <img src="<?php
        
        if (file_exists("imgs/data/users/" . $_SESSION['UserEmail'] . "-" . $_SESSION['UserName'] . ".jpg")) {
          echo "imgs/data/users/" . $_SESSION['UserEmail'] . "-" . $_SESSION['UserName'] . ".jpg";
        } else {
          echo "imgs/user.png";
        }

        ?>" alt="">
      </div>
      <p class="name mb2"><?php echo $_SESSION['UserName'];?></p>
      <p class="center"><a style="width: 30%;margin:auto;font-weight:bold;text-decoration: none;" class="btn" href="home.php">Home Page</a></p>
    </div>

    <!-- End User Informations -->

  </div>

  <!-- End Info Container -->

  <?php include "footer.php"?>

  <script src="plugins/jquery.js"></script>

  <script>
  // Set Pass
  var count = document.querySelector('.count');
  var form = document.querySelector('.uplo');
  count.onclick = function() {

    $('.info-container .set-pass').fadeOut()
    $('.info-container .setpasshead').fadeOut()
    $('.userinfohead').delay(500).fadeIn()
    $('.uplo').fadeOut()
    $('.skip').fadeOut()
    $('.count').fadeOut()
    $('.user-info').delay(500).fadeIn()

  }
  userinfobtn.onclick = function() {

    $('.info-container .userinfohead').fadeOut()
    $('.userfavhead').delay(500).fadeIn()
    $('.info-container .user-info').fadeOut()
    $('.user-fav').delay(500).fadeIn()

  }
  </script>

</body>

</html>