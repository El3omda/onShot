<?php

session_start();

require_once "config.php";

if (!isset($_REQUEST['id'])) {

  header("Location: home.php");

}

// Get Page Data By ID

$sqlgetpd = "SELECT * FROM pages WHERE PageID = '{$_REQUEST['id']}'";
$resultgetpd = mysqli_query($conn, $sqlgetpd);
$rowgetpd = $resultgetpd->fetch_assoc();

// Upload Image



$target_dir = "imgs/data/posts/pages/";
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

@$newfilename = $_SESSION['UserEmail'] . "-" . $_REQUEST['id'] . "-" . $PostID . "." . $imageFileType;


$PostImage = "imgs/data/posts/pages/" . $newfilename;

@$PostText = $conn->real_escape_string($_POST['PostText']);


if (isset($_POST['submit'])) {

  // Insert Post To Page Post


  $sqliptp = "INSERT INTO posts (PostID,IsPage,UserID,PostText,PostImage,PageID) 
              VALUES ('$PostID', '1', '0', '$PostText', '$PostImage', '{$rowgetpd['PageID']}')";


  if (mysqli_query($conn, $sqliptp)) {

    if ($uploadOk == 1) {
      $temp = explode(".", $_FILES["PostImage"]["name"]);
      move_uploaded_file($_FILES["PostImage"]["tmp_name"], "imgs/data/posts/pages/" . $newfilename);
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
  <title>Page <?php echo $rowgetpd['PageName'];?></title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/later.css">
  <link rel="stylesheet" href="css/page.css">
</head>

<body>

  <?php include "side-nav.php";?>

  <div class="page-container">
    <div class="page-content">
      <div class="page-head">
        <div class="image">
          <img src="<?php echo $rowgetpd['PageImage'];?>" alt="">
        </div>
        <div class="info">
          <p class="page-name"><?php echo $rowgetpd['PageName'];?></p>
          <p class="page-description"><?php echo $rowgetpd['PageDes'];?></p>
          <p class="followers"><span><?php echo $rowgetpd['Followers'];?></span> Followers</p>
        </div>
      </div>
      <p class="sep"></p>

      <?php
      

      if ($rowgetpd['UserID'] == $_SESSION['ID']) {

        echo '
        
        <div class="create-post">
        <p class="head">Create Post</p>

        <form action="' . $_SERVER['PHP_SELF'] . "?id=" . $rowgetpd['PageID'] . '" method="POST" class="fo" enctype="multipart/form-data">
          <div class="p-image">
            <label for="PostImage">Upload Post Image</label>
            <input type="file" name="PostImage" id="PostImage" required>
          </div>

          <div class="p-text">
            <label for="PostText">Post Text</label>
            <textarea class="pote" name="PostText" id="PostText" required></textarea>
          </div>

          <div class="submit">
            <input type="submit" name="submit" value="Create Post">
          </div>
        </form>
      </div>
        
        ';

      }
      
      
      ?>

    </div>
    <div class="later-posts-container">


    </div>
  </div>
  <script>

    var pageid = window.location.search.replace('?id=','');

    setInterval(function() {
      const xhttp = new XMLHttpRequest();

      xhttp.onload = function () {
        document.querySelector('.later-posts-container').innerHTML = this.responseText;
      }

      xhttp.open('GET', 'ajax.php?want=allpageposts&pageid=' + pageid, true);
      
      xhttp.send();

    }, 500)

    setInterval(function() {
      const xhttp = new XMLHttpRequest();

      xhttp.onload = function () {
        document.querySelector('.followers span').innerHTML = this.responseText;
      }

      xhttp.open('GET', 'ajax.php?want=getfollowers&pageid=' + pageid, true);
      
      xhttp.send();

    }, 500)

    function remove(postid) {

      const xhttp = new XMLHttpRequest();

      xhttp.open('GET', 'ajax.php?want=removePagePost&pageid=' + pageid + "&postid=" + postid, true);
      
      xhttp.send();

    }

    function love(postid) {
      const xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'ajax.php?want=increaselove&postid=' + postid, true);
      xhttp.send();
    }

    function share(postid) {
      const xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'ajax.php?want=increaseshare&postid=' + postid, true);
      xhttp.send();
    }

  </script>
</body>

</html>