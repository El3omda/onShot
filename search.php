<?php

  session_start();

  require_once "config.php";

  if (@$_REQUEST['re'] == 1) {
    header("Location:chat.php");
  }

  // Get Search Key

  $searchKey = $_REQUEST['key'];

  // SQl Select Users By Email , ID , Name

  $UserEmail = $_SESSION['UserEmail'];
  $UserName = $_SESSION['UserName'];

  $sqlsu = "SELECT * FROM users WHERE (UserEmail LIKE '%{$searchKey}%' OR UserName LIKE '%{$searchKey}%' OR UserID LIKE '%{$searchKey}%') AND (UserEmail != '$UserEmail' OR UserName != '$UserName')";
  $result = mysqli_query($conn, $sqlsu);







    if ($result->num_rows > 0) {

      while ($row = $result->fetch_assoc()) {

        echo '
          <div class="res-box">
            <div class="image">
              <img src="' . $row['UserPhoto'] . '"/>
            </div>
            <div class="info">
              <p class="username">' . $row['UserName'] . '</p>
              <div class="action">
                <form action="search.php?re=1" method="POST">
                  <button name="add" value="' . $row['UserID'] . '" type="submit"><i class="fa fa-plus"></i> Add Friend</button>
                  <button name="follow" value="' . $row['UserID'] . '" type="submit"><i class="fa fa-link"></i> Follow</button>
                </form>
              </div>
            </div>
          </div>
        ';
      
      }

    } else {
      echo "No";
    }
  
    if (isset($_POST['add'])) {
      // Add Friend Request
      foreach ($_POST as $name => $value) {
        $FriendID = $value;
      }

      # Check If There Is A Request
      $sqlfr = "INSERT INTO friendrequest (UserEmail,FriendID,RequestStatus) VALUES ('$UserEmail','$FriendID','Pending')";
      mysqli_query($conn, $sqlfr);
    }

  ?>

  <style>
    .res-box {
      padding: 20px ;
      overflow: hidden;
      border-bottom: 1px solid #000;
    }
    .res-box .image {
      float: left;
      width: 100px;
      height: 100px;
    }
    .res-box .image img {
      width: 100%;
      height: 100%;
    }
    .res-box .info {
      margin-top: 20px;
    }
    .res-box .info .username {
      font-weight: bold;
      margin-bottom: 10px;
    }
    .res-box .action button {
      padding: 10px;
      font-family: ubuntu,arial;
      background: linear-gradient(45deg, #fd508f, #f96b45);
      color: #fff;
      border:1px solid #fd508f;
      border-radius: 5px;
      cursor: pointer;
      transition: all .3;
    }
    .res-box .action button:hover {
      background: none;
      color: #fd508f;
    }
  </style>