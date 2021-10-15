<?php



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
          <img src="imgs/data/users/Admin@admin.com-Emad Othman.jpg" alt="">
        </div>
        <div class="info">
          <p class="name">Emad Othman</p>
          <p class="date">Posted In : 12-10-2021 On 09:30 PM</p>
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
        <img src="imgs/data/posts/turtle.jpg" alt="">
      </div>
      <div class="text">
        <p>
          Turtles are an order of reptiles known as Testudines;
          characterized by a shell developed mainly from their ribs.
          Modern turtles are divided into two major groups,
          the side-necked turtles and hidden neck turtles which differ in the way the head retracts.
          There are 360 living and recently extinct species of turtles, including tortoises and terrapins.
          They are found on every continent, some islands and much of the ocean. Like other reptiles,
          birds, and mammals, they breathe air and do not lay eggs underwater, although many species live in or around
          water.
          Genetic evidence typically places them in close relation to crocodilians and birds.
        </p>
        <p class="ss-date">Posted In : 12-10-2021 On 09:30 PM</p>
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