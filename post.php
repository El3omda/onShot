<?php

session_start();


if (!isset($_SESSION['ID'])) {
  header('Location: sign.php');
}


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
          <img src="
          <?php
            if ($rowpd['IsPage'] == 0) {
              echo $rowgud['UserPhoto'];
            } else {
              // Get Page Of The Post Data
              
              $sqlgetppd = "SELECT * FROM pages WHERE PageID = '{$rowpd['PageID']}'";
              $resultgetppd = mysqli_query($conn, $sqlgetppd);
              $rowgetppd = $resultgetppd->fetch_assoc();
              echo $rowgetppd['PageImage'];
            }
          ?>
          " alt="">
        </div>
        <div class="info">
          <p class="name">
          <?php
            if ($rowpd['IsPage'] == 0) {
              echo $rowgud['UserName'];
            } else {
              echo $rowgetppd['PageName'];
            }
          ?>
          </p>
          <p class="date">Posted In : <?php echo $rowpd['PostDate'] . " On " . $rowpd['PostTime'];?></p>
        </div>
      </div>
      <div class="post-option">
        <i class="fa fa-ellipsis-h"></i>
      </div>
      <div class="post-option-box">
        <ul>
          <li><a class="later" onclick="addlater(window.location.search.replace('?pid=',''))">Save For Later</a></li>
          <li><a class="ban" onclick="removeTimeline(window.location.search.replace('?pid=',''))">Ban This Post</a></li>
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
        <i onclick="addlove()" class="fa 
        <?php
        
          // Fix Add Active Class

          #love

          $sqlcac = "SELECT * FROM love WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$_REQUEST['pid']}'";

          $resultcac = mysqli_query($conn, $sqlcac);

          if ($resultcac->num_rows > 0) {
            $fixclass = " love-active ";
          } else {
            $fixclass = "";
          }

          echo $fixclass;

        ?>
         fa-heart"></i>
        <span class="love-count">0</span>
      </div>
      <div class="comment">
        <i class="fa fa-comment"></i>
        <span class="comment-count"></span>
      </div>
      <div class="share">
        <i onclick="addshare()" class="fa
        
        <?php
        
        # Share
      
        $sqlcacs = "SELECT * FROM share WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$_REQUEST['pid']}'";

        $resultcacs = mysqli_query($conn, $sqlcacs);

        if ($resultcacs->num_rows > 0) {
          $fixclasss = " share-active ";
        } else {
          $fixclasss = "";
        }
        
        echo $fixclasss;

        ?>
        
        fa-share-alt"></i>
        <span class="share-count"></span>
      </div>
    </div>

  </div>
      <input type="hidden" class="userid" value="<?php echo $_SESSION['ID'];?>">
  <!-- Start Comments -->
  <div class="comment-container">
    <div class="type-comment">
      <textarea class="ct" name="comment" placeholder="Type Your comment Here . . ."></textarea>
      <button onclick="addcomment(document.querySelector('.ct').value)">Comment</button>
    </div>
    <div class="content-box">
      
    </div>
  </div>

  <!-- End Comments -->
  <script src="plugins/jquery.js"></script>
  <script>
  $('.comment i').click(function() {
    $('.comment-container').fadeToggle();
  })
  $('.post-option i').click(function() {
    $('.post-option-box').fadeToggle();
    $(this).toggleClass('active');
  })


  function love(postid) {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'ajax.php?want=increaselove&postid=' + postid, true);
    xhttp.send();
  }

  var idofpost = window.location.search.replace('?pid=','');
  
  
  // Get Shares Count

  setInterval(function () {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
      document.querySelector('.share-count').innerHTML = this.responseText;
    }

    xhttp.open('GET', 'ajax.php?want=getsharecountpost&postid=' + idofpost, true);

    xhttp.send();
  }, 500)

  // Add Love

  function addlove() {

    const xhttp = new XMLHttpRequest();

    xhttp.open('GET', 'ajax.php?want=addlovetopost&postid=' + idofpost, true);

    xhttp.send();

  }

  // Add Share To the Post

  function addshare() {

    const xhttp = new XMLHttpRequest();

    xhttp.open('GET', 'ajax.php?want=addsharetopost&postid=' + idofpost, true);

    xhttp.send();

  }

  // Get All Comments

  setInterval(function () {

    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
      document.querySelector('.comment-container .content-box').innerHTML = this.responseText;
    }

    xhttp.open('GET', 'ajax.php?want=allcomment&postid=' + idofpost, true);
    xhttp.send();

  }, 500)
  
  // Add A Comment On A Post

  var userid = document.querySelector('.userid').value;

  function addcomment(comment) {

    const xhttp = new XMLHttpRequest();

    xhttp.open('GET', 'ajax.php?want=addcomment&comment=' + comment + '&postid=' + idofpost + '&userid=' + userid,true);
    xhttp.send();

    document.querySelector('.ct').value = '';

  }

  // Get Comment Number

  setInterval(function () {
    const xhttp = new XMLHttpRequest();
  
    xhttp.onload = function () {
      document.querySelector('.comment-count').innerHTML = this.responseText;
    }

    xhttp.open('GET', 'ajax.php?want=PostCommentNo&postid=' + idofpost ,true);

    xhttp.send();
  }, 500)


  function addlater(postid) {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'ajax.php?want=addlater&postid=' + postid, true);
    xhttp.send();
  }

  setInterval(function () {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
      document.querySelector('.later').innerHTML = this.responseText;
    }

    xhttp.open('GET', 'ajax.php?want=checklaterstatus&postid=' + idofpost, true);

    xhttp.send();
  }, 500)

  // Remove From Time Line

  function removeTimeline(postid) {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'ajax.php?want=removeFromTimeLine&postid=' + postid, true);
    xhttp.send();
  }

  setInterval(function () {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
      document.querySelector('.ban').innerHTML = this.responseText;
    }

    xhttp.open('GET', 'ajax.php?want=checkbanstatus&postid=' + idofpost, true);

    xhttp.send();
  }, 500)

  // Get Love Count

  setInterval(function () {
    const xhttp = new XMLHttpRequest();

    xhttp.onload = function () {
      document.querySelector('.love-count').innerHTML = this.responseText;
    }

    xhttp.open('GET', 'ajax.php?want=getlovecountpost&postid=' + idofpost, true);

    xhttp.send();
  }, 500)

  </script>
</body>

</html>