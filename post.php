<?php

require_once "config.php";

if (isset($_REQUEST['pid'])) {

  // Get Post Data
  $sqlgpd = "SELECT * FROM posts WHERE PostID = '{$_REQUEST['pid']}'";
  $resultpd = mysqli_query($conn, $sqlgpd);
  $rowpd = $resultpd->fetch_assoc();

  // Get User Info

  $sqlgud = "SELECT * FROM users WHERE UserID = '{$rowpd['UserID']}'";
  $resultgud = mysqli_query($conn, $sqlgud);
  $rowgud = $resultgud->fetch_assoc();

} else {
  header("Location:home.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Post</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/post.css">
</head>

<body>

  <?php include "side-nav.php";?>

  <div class="post-container">

    <div class="head">
      <div class="user">
        <div class="image">
          <img src="<?php echo $rowgud['UserPhoto'];?>" alt="">
        </div>
        <div class="info">
          <p class="name"><?php echo $rowgud['UserName'];?></p>
          <p class="date">Posted In : <?php echo $rowpd['PostDate'] . " On " . $rowpd['PostTime'];?></p>
        </div>
      </div>
      <div class="post-option">
        <i class="fa fa-ellipsis-h"></i>
      </div>
      <div class="post-option-box">
        <ul>
          <li><a href="#">Save For Later</a></li>
          <li><a href="#">Report</a></li>
          <li><a href="#">Remove From Time Line</a></li>
        </ul>
      </div>
    </div>

    <div class="info">
      <div class="media">
        <img src="<?php echo $rowpd['PostImage'];?>" alt="">
      </div>
      <div class="text">
        <p>
          <?php echo $rowpd['PostText'];?>
        </p>
        <p class="ss-date">Posted In : <?php echo $rowpd['PostDate'] . " On " . $rowpd['PostTime'];?></p>
      </div>
    </div>

    <div class="option">
      <div class="love">
        <i class="fa fa-heart"></i>
        <span class="love-count">100</span>
      </div>
      <div class="comment">
        <i class="fa fa-comment"></i>
        <span class="comment-count">50</span>
      </div>
      <div class="share">
        <i class="fa fa-share-alt"></i>
        <span class="share-count">5</span>
      </div>
    </div>

  </div>

  <!-- Start Comments -->
  <div class="comment-container">
    <div class="type-comment">
      <textarea name="comment" placeholder="Type Your comment Here . . ."></textarea>
      <button>Comment</button>
    </div>
    <div class="content-box">
      <div class="comment">
        <div class="image">
          <img src="imgs/data/users/Admin@admin.com-Emad Othman.jpg" alt="">
        </div>
        <div class="comment-info">
          <p class="user">
            Mohamed Ali
          </p>
          <p class="comment-content">
            I Love Turtles
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- End Comments -->
  <script src="plugins/jquery.js"></script>
  <script>
  $('.comment i').click(function() {
    $('.comment-container').fadeToggle();
  })
  $('.post-option i').click(function () {
    $('.post-option-box').fadeToggle();
    $(this).toggleClass('active');
  })
  </script>
</body>

</html>