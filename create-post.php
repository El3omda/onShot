<?php


session_start();


if (!isset($_SESSION['ID'])) {
  header('Location: sign.php');
}


require_once "config.php";


// Upload Image



$target_dir = "imgs/data/posts/";
$target_file = $target_dir . basename(@$_FILES["PostImage"]["name"]);
$uploadOk = 1;
$GLOBALS['ex'] = $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["up"])) {
  @$check = getimagesize($_FILES["PostImage"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }
}

// Check file size
if (@$_FILES["PostImage"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" ) {
  $uploadOk = 0;
}

$PostID = rand(0, 1000) . "0" . date('Y') . "0" . date('m') . "0" . date('s');

@$newfilename = $_SESSION['UserEmail'] . "-" . $_SESSION['ID'] . "." . $imageFileType;


$PostImage = "imgs/data/posts/" . $newfilename;

@$PostText = $conn->real_escape_string($_POST['PostText']);


if (isset($_POST['submit'])) {

  // Insert Post To Page Post


  $sqliptp = "INSERT INTO posts (PostID,IsPage,UserID,PostText,PostImage) 
              VALUES ('$PostID', '0', '{$_SESSION['ID']}', '$PostText', '$PostImage')";


  if (mysqli_query($conn, $sqliptp)) {

    if ($uploadOk == 1) {
      $temp = explode(".", $_FILES["PostImage"]["name"]);
      move_uploaded_file($_FILES["PostImage"]["tmp_name"], "imgs/data/posts/" . $newfilename);
    }

    $_POST['PostText'] = '';
    $_POST['submit'] = '';

  } else {
    echo "<p style='margin: 50px;'>Faild</p>" . mysqli_error($conn); 
  }

}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Post</title>
  <link rel="stylesheet" href="css/page.css">
</head>

<body>

<?php include "side-nav.php";?>

  <div class="page-container" style="margin-top: 200px;">
    <div class="page-content">
      <div class="create-post">
        <form action="<?php $_SERVER['PHP_SELF']?>" method="POST" class="fo"
          enctype="multipart/form-data">
          <div class="p-image">
            <label for="PostImage">Upload Post Image</label>
            <input type="file" name="PostImage" id="PostImage" required>
          </div>

          <div class="p-text">
            <label for="PostText">Post Text</label>
            <textarea style="padding: 0;border-radius: 5px;box-sizing: border-box;padding: 5px;" class="pote" name="PostText" id="PostText" required></textarea>
          </div>

          <div class="submit">
            <input type="submit" name="submit" value="Create Post">
          </div>
        </form>
      </div>
    </div>
  </div>

</body>

</html>