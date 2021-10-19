<?php

session_start();

if (!isset($_SESSION['ID'])) {
  header('Location: sign.php');
}


require_once "config.php";

// Upload Page Image

$target_dir = "imgs/data/pages/";
$target_file = $target_dir . basename(@$_FILES["PageImage"]["name"]);
$uploadOk = 1;
$GLOBALS['ex'] = $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["up"])) {
  @$check = getimagesize($_FILES["PageImage"]["tmp_name"]);
  if($check !== false) {
    $uploadOk = 1;
  } else {
    $uploadOk = 0;
  }
}

// Check file size
if (@$_FILES["PageImage"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" ) {
  $uploadOk = 0;
}


$PageID = rand(0,1000) . date('y') . date('m') . date('d') . date('i');

if (isset($_POST['submit'])) {

  // Insert Page Data
  $newfilename = $_SESSION['UserEmail'] . "-" . $PageID . "-" . $_SESSION['UserName'] . "." . $imageFileType;

  @$PageName = $_POST['PageName'];
  @$PageDes = $_POST['PageDes'];
  @$PageType = $_POST['PageType'];
  @$PageImage = "imgs/data/pages/" . $newfilename;

  $sqlipd = "INSERT INTO pages (PageName,PageID,UserID,PageType,PageDes,PageImage) VALUES ('$PageName','$PageID','{$_SESSION['ID']}','$PageType','$PageDes','$PageImage')";

  if (mysqli_query($conn, $sqlipd)) {
    if ($uploadOk == 1) {
      $temp = explode(".", $_FILES["PageImage"]["name"]);
      move_uploaded_file($_FILES["PageImage"]["tmp_name"], "imgs/data/pages/" . $newfilename);
    }
    header("Location:pages.php");
  }

}

// echo "<p style='margin: 50px;'>" . $newfilename . "</p>";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Create New Page</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/create-page.css">
</head>
<body>
  
  <?php include "side-nav.php";?>

  <div class="container">
    
    <div class="create">

      <div class="head">
        Create New Page
      </div>

      <form class="content" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST" enctype="multipart/form-data">

        <div class="input-feild">
          <label for="PageName">Page Name</label>
          <input type="text" id="PageName" name="PageName" required>
        </div>

        <div class="input-feild">
          <label for="PageDes">Page Description</label>
          <input type="text" id="PageDes" name="PageDes" required>
        </div>

        <div class="input-feild">
          <label for="PageType">SElect Page Type</label>
          <select id="PageType" name="PageType" required>
            <option selected disabled>Select Type</option>
            <option value="Sports">Sports</option>
            <option value="Science">Science</option>
            <option value="beauty">beauty</option>
            <option value="nature">nature</option>
            <option value="comedy">comedy</option>
            <option value="foods">foods</option>
            <option value="cartoon">cartoon</option>
            <option value="culture">culture</option>
            <option value="music">music</option>
            <option value="technology">technology</option>
          </select>
        </div>

        <div class="input-feild">
          <label for="PageImage">Page Image</label>
          <input type="file" id="PageImage" name="PageImage" required>
        </div>

        <div class="input-feild">
          <input type="submit" name="submit" value="Create">
        </div>

      </form>
    </div>

  </div>

</body>
</html>