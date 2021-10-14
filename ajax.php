<?php

session_start();

require_once "config.php";

if (@$_REQUEST['want'] == 'noti') {

  $ID = $_SESSION['ID'];

  $sql = "SELECT COUNT(*) AS NumNoti FROM friendrequest WHERE FriendID = '$ID' AND RequestStatus = 'Pending'";
  $result = mysqli_query($conn, $sql);
  $row = $result->fetch_assoc();

  echo $row['NumNoti'];

}

@$requestMsg = $_REQUEST['msg'];

if (isset($requestMsg) && $requestMsg != '') {
  
  $Msg = $_REQUEST['msg'];

  $rid = $_REQUEST['rid'];

  $sid = $_SESSION['ID'];

  $sqlinsertMsg = "INSERT INTO chat (SenderID,ReceiverID,Msg) VALUES ('$sid', '$rid', '$Msg')";

  mysqli_query($conn, $sqlinsertMsg);

}

if ($_REQUEST['want'] == 'chat') {
  $rid = $_REQUEST['rid'];
  $sid = $_SESSION['ID'];

  // Get All Msgs
  $sqlgam = "SELECT * FROM chat WHERE (SenderID = '$sid' AND ReceiverID = '$rid') OR (SenderID = '$rid')";
  $resultgam = mysqli_query($conn, $sqlgam);
  $msgs = "";
  if ($resultgam->num_rows > 0) {
    while ($rowgam = $resultgam->fetch_assoc()) {
        
        if ($sid == $rowgam['SenderID']) {
          $checkMsg = 'msg-sender';
        } else {
          $checkMsg = 'msg-resiver';
        }

        $msgs .= '
          <div class="' . $checkMsg . ' mb2">
            ' . $rowgam['Msg'] . '
          </div>
          <div style="clear:both"></div>
        ';
    }
  }
  echo $msgs;
}

if ($_REQUEST['want'] == 'friend') {

  // Get Request Friend
  $id = $_SESSION['ID'];

  $sqlgrf = "SELECT * FROM friendrequest WHERE FriendID = '$id' AND RequestStatus = 'Pending'";
  $resultgrf = mysqli_query($conn, $sqlgrf);
  $requesfriends = "";

  if ($resultgrf->num_rows > 0) {
    while ($rowgrf = $resultgrf->fetch_assoc()) {
      $frid = $rowgrf['UserEmail'];
      // Get USer Data
      $sqlGUD = "SELECT * FROM users WHERE UserEmail = '$frid'";
      $resultGUD = mysqli_query($conn, $sqlGUD);
      $rowGUD = $resultGUD->fetch_assoc();
      $requesfriends .= '
          <div class="fr">
            <div class="image">
              <img src="' . $rowGUD['UserPhoto'] . '" alt="">
            </div>
            <div class="info">
              <p class="name">' . $rowGUD['UserName'] . '</p>
              <div class="action">
                <button class="acfri" onclick="accept(this.getAttribute(`data-id`), this.getAttribute(`data-email`))" data-email="' . $rowgrf['UserEmail'] . '" data-id="' . $rowGUD['UserID'] . '">Accept</button>
                <button class="cafri" onclick="cancel(this.getAttribute(`data-id`), this.getAttribute(`data-email`))" data-email="' . $rowgrf['UserEmail'] . '"  data-id="' . $rowGUD['UserID'] . '">Delete</button>
              </div>
            </div>
          </div>
      ';
    }
    echo $requesfriends;
  }

}

if ($_REQUEST['want'] == 'accept') {
  $acfriID = $_REQUEST['id'];
  $FEmail = $_REQUEST['email'];
  // Sql Add Friend To Friends 

  $sqlatf = "INSERT INTO friends (UserEmail,FriendID) VALUES ('{$_SESSION['UserEmail']}', '$acfriID')";
  if (mysqli_query($conn, $sqlatf)) {
    // Sql To Change Status Of Request
    $sqlrfr = "UPDATE friendrequest SET RequestStatus = 'Accepted' WHERE FriendID = '{$_SESSION['ID']}' AND UserEmail = '$FEmail'";
    mysqli_query($conn, $sqlrfr);
  }

}

if ($_REQUEST['want'] == 'cancel') {
  $acfriID = $_REQUEST['id'];
  $FEmail = $_REQUEST['email'];

  // Sql To Change Status Of Request
  $sqlcfr = "UPDATE friendrequest SET RequestStatus = 'Canceled' WHERE FriendID = '{$_SESSION['ID']}' AND UserEmail = '$FEmail'";
  mysqli_query($conn, $sqlcfr);

}

if ($_REQUEST['want'] == 'getfriends') {
  // Sql To Get UserFriends

  $sqlguf = "SELECT * FROM friends WHERE UserEmail = '{$_SESSION['UserEmail']}'";
  $resultguf = mysqli_query($conn, $sqlguf);
  $friendsList = "";
  if ($resultguf->num_rows > 0) {

    while ($rowguf = $resultguf->fetch_assoc()) {
      // Get Friend Data By Its Id 

      $sqlgfd = "SELECT * FROM users WHERE UserID = '{$rowguf['FriendID']}'";
      $resultgfd = mysqli_query($conn, $sqlgfd);
      $rowgfd = $resultgfd->fetch_assoc();

      if ($rowgfd['UserStatus'] == 'offline') {
        $fixstatus = '
        <i class="fa fa-circle fa-fw gray"></i> Offline
        ';
      } else {
        $fixstatus = '
        <i class="fa fa-circle fa-fw green"></i> Online
        ';
      }

      $friendsList .= '
      
        <div class="friend">
          <a style="text-decoration:none;" href="chat.php?rid=' . $rowgfd['UserID'] . '">
            <div class="image"> <img src="' . $rowgfd['UserPhoto'] . '" alt=""> </div>
            <div class="info">
              <p class="name">' . $rowgfd['UserName'] . '</p>
              <p class="status">' .
                $fixstatus
              .'</p>
            </div>
          </a>
        </div>

      ';
    }

  }
  echo $friendsList;
}

// Get All Chats

if ($_REQUEST['want'] == 'allchat') {

  // Get All User Msgs
  
  $sqlgaum = "SELECT * FROM chat WHERE SenderID = '{$_SESSION['ID']}' OR ReceiverID = '{$_SESSION['ID']}' ORDER BY MsgDate ASC LIMIT 20";
  $resultgaum = mysqli_query($conn, $sqlgaum);
  $allmsgs = "";

  if ($resultgaum->num_rows > 0 ) {

    while ($rowgaum = $resultgaum->fetch_assoc()) {
      // Get Reciver

      $sqlgr = "SELECT UserName FROM users WHERE UserID = '{$rowgaum['ReceiverID']}'";
      $resultgr = mysqli_query($conn, $sqlgr);
      $rowgr = $resultgr->fetch_assoc();

      // Get Sender

      $sqlgs = "SELECT UserName FROM users WHERE UserID = '{$rowgaum['SenderID']}'";
      $resultgs = mysqli_query($conn, $sqlgs);
      $rowgs = $resultgs->fetch_assoc();


      $allmsgs .= '
        <div class="am">
          <p class="msg">' . $rowgaum['Msg'] . '</p>
          <p class="sender"> From : ' . $rowgs['UserName'] . '</p>
          <p class="reciver"> To : ' . $rowgr['UserName'] . '</p>
          </div>
      ';
    }

  }

  echo $allmsgs;

}