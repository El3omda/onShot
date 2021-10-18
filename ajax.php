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

// Later Page

if ($_REQUEST['want'] == 'plater') {

  $sqllater = "SELECT * FROM later WHERE UserID = '{$_SESSION['ID']}'";

  $resultlater = mysqli_query($conn, $sqllater);

  $laterPosts = "";

  if ( $resultlater->num_rows > 0 ) {

    while ($rowlater = $resultlater->fetch_assoc()) {

      // Get Post Data 

      $sqlgetpd = "SELECT * FROM posts WHERE PostID = '{$rowlater['PostID']}'";
      $resultgetpd = mysqli_query($conn, $sqlgetpd);
      $rowgetpd = $resultgetpd->fetch_assoc();

      // Get Post Owner Data

      $sqlgetpod = "SELECT * FROM users WHERE UserID = '{$rowgetpd['UserID']}'";
      $resultgetpod = mysqli_query($conn, $sqlgetpod);
      $rowgetpod = $resultgetpod->fetch_assoc();

      // Get Love Count

      $sqlglc = "SELECT COUNT(*) AS lc FROM love WHERE PostID = '{$rowgetpd['PostID']}'";

      $resultglc = mysqli_query($conn, $sqlglc);

      $rowglc = $resultglc->fetch_assoc();

      // Insert Love Count

      $sqlilc = "UPDATE posts SET LoveCount = '{$rowglc['lc']}' WHERE PostID = '{$rowgetpd['PostID']}'";

      mysqli_query($conn, $sqlilc);

      // Get Share Count

      $sqlgsc = "SELECT COUNT(*) AS sc FROM share WHERE PostID = '{$rowgetpd['PostID']}'";

      $resultgsc = mysqli_query($conn, $sqlgsc);

      $rowgsc = $resultgsc->fetch_assoc();

      // Insert Share Count

      $sqlisc = "UPDATE posts SET ShareCount = '{$rowgsc['sc']}' WHERE PostID = '{$rowgetpd['PostID']}'";

      mysqli_query($conn, $sqlisc);

      // Fix Add Active Class

      #love

      $sqlcac = "SELECT * FROM love WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$rowgetpd['PostID']}'";

      $resultcac = mysqli_query($conn, $sqlcac);

      if ($resultcac->num_rows > 0) {
        $fixclass = " love-active ";
      } else {
        $fixclass = "";
      }

      # Share
      
      $sqlcacs = "SELECT * FROM share WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$rowgetpd['PostID']}'";

      $resultcacs = mysqli_query($conn, $sqlcacs);

      if ($resultcacs->num_rows > 0) {
        $fixclasss = " share-active ";
      } else {
        $fixclasss = "";
      }

      $laterPosts .= '
      
        
      <div class="post">

        <div class="post-head">
        
          <div class="user">
            <div class="image">
              <img src="' . $rowgetpod['UserPhoto'] . '" alt="">
            </div>
            <div class="info">
              <p class="name">
              ' . $rowgetpod['UserName'] . '
              </p>
            </div>
          </div>
        
          <div class="post-option">
            <i onclick="remove(' . $rowgetpd['PostID'] . ')" class="fa fa-minus"></i>
          </div>
        </div>
        
        <div class="post-media">
          <img src="' . $rowgetpd['PostImage'] . '" alt="">
        </div>
        
        <div class="post-text">
          <p>
          ' . $rowgetpd['PostText'] . '
          </p>
          <a href="post.php?pid=' . $rowgetpd['PostID'] . '">Read More</a>
        </div>
        
        <div class="post-options-bottom">
          <div class="love">
            <i onclick="love(' . $rowgetpd['PostID'] . ')" class="fa ' . $fixclass . ' fa-heart"></i>
            <span class="love-count">' . $rowgetpd['LoveCount'] . '</span>
          </div>
          <div class="share">
            <i onclick="share(' . $rowgetpd['PostID'] . ')" class="fa ' . $fixclasss . ' fa-share-alt"></i>
            <span class="share-count">' . $rowgetpd['ShareCount'] . '</span>
          </div>
        </div>
      </div>
      
      ';

    }
      
    echo $laterPosts;
  }

}

// Start Explorer Page 

if ($_REQUEST['want'] == 'pexplore') {

  $sqllater = "SELECT * FROM posts";

  $resultlater = mysqli_query($conn, $sqllater);

  $laterPosts = "";

  if ( $resultlater->num_rows > 0 ) {

    while ($rowlater = $resultlater->fetch_assoc()) {

      // Get Post Data 

      $sqlgetpd = "SELECT * FROM posts WHERE PostID = '{$rowlater['PostID']}'";
      $resultgetpd = mysqli_query($conn, $sqlgetpd);
      $rowgetpd = $resultgetpd->fetch_assoc();

      // Get Post Owner Data

      $sqlgetpod = "SELECT * FROM users WHERE UserID = '{$rowgetpd['UserID']}'";
      $resultgetpod = mysqli_query($conn, $sqlgetpod);
      $rowgetpod = $resultgetpod->fetch_assoc();

      // Get Love Count

      $sqlglc = "SELECT COUNT(*) AS lc FROM love WHERE PostID = '{$rowgetpd['PostID']}'";

      $resultglc = mysqli_query($conn, $sqlglc);

      $rowglc = $resultglc->fetch_assoc();

      // Insert Love Count

      $sqlilc = "UPDATE posts SET LoveCount = '{$rowglc['lc']}' WHERE PostID = '{$rowgetpd['PostID']}'";

      mysqli_query($conn, $sqlilc);

      // Get Share Count

      $sqlgsc = "SELECT COUNT(*) AS sc FROM share WHERE PostID = '{$rowgetpd['PostID']}'";

      $resultgsc = mysqli_query($conn, $sqlgsc);

      $rowgsc = $resultgsc->fetch_assoc();

      // Insert Share Count

      $sqlisc = "UPDATE posts SET ShareCount = '{$rowgsc['sc']}' WHERE PostID = '{$rowgetpd['PostID']}'";

      mysqli_query($conn, $sqlisc);

      // Fix Add Active Class

      #love

      $sqlcac = "SELECT * FROM love WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$rowgetpd['PostID']}'";

      $resultcac = mysqli_query($conn, $sqlcac);

      if ($resultcac->num_rows > 0) {
        $fixclass = " love-active ";
      } else {
        $fixclass = "";
      }

      # Share
      
      $sqlcacs = "SELECT * FROM share WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$rowgetpd['PostID']}'";

      $resultcacs = mysqli_query($conn, $sqlcacs);

      if ($resultcacs->num_rows > 0) {
        $fixclasss = " share-active ";
      } else {
        $fixclasss = "";
      }

      // Fix Later Table Icon Font

      # Check If The Post Is Already In Later Table
      
      $sqlcife = "SELECT * FROM later WHERE PostID = '{$rowgetpd['PostID']}'";

      $resultcife = mysqli_query($conn, $sqlcife);

      if ($resultcife->num_rows > 0) {

        $fixicon = "minus";

      } else {

        $fixicon = "plus";

      }

      // Fix Post Publisher Image

      if ($rowgetpd['IsPage'] == '1') {
        $sqlgetPageImage = "SELECT * FROM pages WHERE PageID = '{$rowgetpd['PageID']}'";
        $resultgetPageImage = mysqli_query($conn, $sqlgetPageImage);
        $rowgetPageImage = $resultgetPageImage->fetch_assoc();

        $fixImage = $rowgetPageImage['PageImage'];
        $fixName = $rowgetPageImage['PageName'];
      } else {
        $fixImage = $rowgetpod['UserPhoto'];
        $fixName = $rowgetpod['UserName'];
      }

      

      $laterPosts .= '
      
        
      <div class="post">

        <div class="post-head">
        
          <div class="user">
            <div class="image">
              <img src="' . $fixImage . '" alt="">
            </div>
            <div class="info">
              <p class="name">
              ' . $fixName . '
              </p>
            </div>
          </div>
        
          <div class="post-option">
            <i onclick="addlater(' . $rowgetpd['PostID'] . ')" class="fa fa-' . $fixicon . '"></i>
          </div>
        </div>
        
        <div class="post-media">
          <img src="' . $rowgetpd['PostImage'] . '" alt="">
        </div>
        
        <div class="post-text">
          <p>
          ' . $rowgetpd['PostText'] . '
          </p>
          <a href="post.php?pid=' . $rowgetpd['PostID'] . '">Read More</a>
        </div>
        
        <div class="post-options-bottom">
          <div class="love">
            <i onclick="love(' . $rowgetpd['PostID'] . ')" class="fa ' . $fixclass . ' fa-heart"></i>
            <span class="love-count">' . $rowgetpd['LoveCount'] . '</span>
          </div>
          <div class="share">
            <i onclick="share(' . $rowgetpd['PostID'] . ')" class="fa ' . $fixclasss . ' fa-share-alt"></i>
            <span class="share-count">' . $rowgetpd['ShareCount'] . '</span>
          </div>
        </div>
      </div>
      
      ';

    }
      
    echo $laterPosts;
  }

}



if ($_REQUEST['want'] == 'increaselove') {

  # Check If User Have Set Love

  $sqlCheckLovers = "SELECT * FROM love WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$_REQUEST['postid']}'";
  $resultlovers = mysqli_query($conn, $sqlCheckLovers);

  if ($resultlovers->num_rows > 0) {
    
    // Remove Love
    $sqldlove = "DELETE FROM love WHERE PostID = '{$_REQUEST['postid']}' AND UserID = '{$_SESSION['ID']}'";
    mysqli_query($conn, $sqldlove);

  } else {

  // Add Love To The Post

    $sqlaltp = "INSERT INTO love (PostID, UserID) VALUES ('{$_REQUEST['postid']}', '{$_SESSION['ID']}')";
    mysqli_query($conn, $sqlaltp);

  }

}

if ($_REQUEST['want'] == 'increaseshare') {

  # Check If User Have Already Set Share

  $sqlCheckShares = "SELECT * FROM share WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$_REQUEST['postid']}'";
  $resultshares = mysqli_query($conn, $sqlCheckShares);

  if ($resultshares->num_rows > 0) {
    
    // Remove Love
    $sqldshare = "DELETE FROM share WHERE PostID = '{$_REQUEST['postid']}' AND UserID = '{$_SESSION['ID']}'";
    mysqli_query($conn, $sqldshare);

  } else {

  // Add Share To The Post

    $sqlastp = "INSERT INTO share (PostID, UserID) VALUES ('{$_REQUEST['postid']}', '{$_SESSION['ID']}')";
    mysqli_query($conn, $sqlastp);

  }

}


if ($_REQUEST['want'] == 'removepost') {

  // Remove Post From Later Posts

  $sqlrflp = "DELETE FROM later WHERE PostID = '{$_REQUEST['postid']}' AND UserID = '{$_SESSION['ID']}'";

  mysqli_query($conn, $sqlrflp);

}

if ($_REQUEST['want'] == 'addlater') {

  // Add Post To Later Posts

  $sqlaflp = "INSERT INTO later (PostID, UserID) VALUES ('{$_REQUEST['postid']}', '{$_SESSION['ID']}')";

  mysqli_query($conn, $sqlaflp);

}

if ($_REQUEST['want'] == 'getPostlove') {

  // Get Number Of Lovers

  $sqlgnols = "SELECT COUNT(*) AS lc FROM love WHERE PostID = '{$_REQUEST['pid']}' AND UserID = '{$_SESSION['ID']}'";

  $resultgnols = mysqli_query($conn, $sqlgnols);

  $rowgnols = $resultgnols->fetch_assoc();

  echo $rowgnols['lc'];
}

if ($_REQUEST['want'] == 'getPostshare') {

  // Get Number Of shares

  $sqlgnols = "SELECT COUNT(*) AS sc FROM share WHERE PostID = '{$_REQUEST['pid']}' AND UserID = '{$_SESSION['ID']}'";

  $resultgnols = mysqli_query($conn, $sqlgnols);

  $rowgnols = $resultgnols->fetch_assoc();

  echo $rowgnols['sc'];
}

if ($_REQUEST['want'] == 'addlovetopost') {

  // Add Love On A Post


  # Check If User Have Set Love

  $sqlCheckLovers = "SELECT * FROM love WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$_REQUEST['postid']}'";
  $resultlovers = mysqli_query($conn, $sqlCheckLovers);

  if ($resultlovers->num_rows > 0) {
    
    // Remove Love
    $sqldlove = "DELETE FROM love WHERE PostID = '{$_REQUEST['postid']}' AND UserID = '{$_SESSION['ID']}'";
    mysqli_query($conn, $sqldlove);

  } else {

  // Add Love To The Post

    $sqlaltp = "INSERT INTO love (PostID, UserID) VALUES ('{$_REQUEST['postid']}', '{$_SESSION['ID']}')";
    mysqli_query($conn, $sqlaltp);

  }


}

if ($_REQUEST['want'] == 'addsharetopost') {

  // Add Love On A Post


  # Check If User Have Set Share

  $sqlCheckLovers = "SELECT * FROM share WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$_REQUEST['postid']}'";
  $resultlovers = mysqli_query($conn, $sqlCheckLovers);

  if ($resultlovers->num_rows > 0) {
    
    // Remove Love
    $sqldlove = "DELETE FROM share WHERE PostID = '{$_REQUEST['postid']}' AND UserID = '{$_SESSION['ID']}'";
    mysqli_query($conn, $sqldlove);

  } else {

  // Add Love To The Post

    $sqlaltp = "INSERT INTO share (PostID, UserID) VALUES ('{$_REQUEST['postid']}', '{$_SESSION['ID']}')";
    mysqli_query($conn, $sqlaltp);

  }


}

if ($_REQUEST['want'] == 'allcomment') {

  // Get Comment Of spacific Post

  $sqlgetcomment = "SELECT * FROM comment WHERE PostID = '{$_REQUEST['postid']}'";

  $resultgetcomment = mysqli_query($conn, $sqlgetcomment);

  $allcomments = "";

  if ($resultgetcomment->num_rows > 0) {

    while ($rowgetcomment = $resultgetcomment->fetch_assoc()) {

      // Get User Data 

      $sqlGetud = "SELECT * FROM users WHERE UserID = '{$rowgetcomment['UserID']}'";

      $resultUserD = mysqli_query($conn, $sqlGetud);

      $rowGetUD = $resultUserD->fetch_assoc();

      $allcomments .= '
      
      <div class="comment">
      <div class="image">
        <img src="' . $rowGetUD['UserPhoto'] . '" alt="">
      </div>
      <div class="comment-info">
        <p class="user">
        ' . $rowGetUD['UserName'] . '
        </p>
        <p class="comment-content">
        ' . $rowgetcomment['CommentText'] . '
        </p>
      </div>
    </div>
      
      '; 

    }

    echo $allcomments;

  }

}


if ($_REQUEST['want'] == 'addcomment') {

  // Add Comment To Comment Table

  $sqlic = "INSERT INTO comment (PostID,UserID,CommentText) VALUES ('{$_REQUEST['postid']}','{$_REQUEST['userid']}','{$_REQUEST['comment']}')";

  mysqli_query($conn, $sqlic);

}


if ($_REQUEST['want'] == 'PostCommentNo') {

  // Get Comment To Number

  $sqlgetcn = "SELECT COUNT(*) AS cn FROM comment WHERE PostID = '{$_REQUEST['postid']}'";

  $resultgetcn = mysqli_query($conn, $sqlgetcn);

  $rowgetcn = $resultgetcn->fetch_assoc();

  echo $rowgetcn['cn'];

}

// Change Typing Status

if ($_REQUEST['want'] == 'typing') {

  // Change Status

  $sqlcstt = "UPDATE users SET TypeStatus = '1' WHERE UserID = '{$_REQUEST['senderid']}'";
  mysqli_query($conn, $sqlcstt);
}

if ($_REQUEST['want'] == 'nottyping') {

  // Change Status

  $sqlcstt = "UPDATE users SET TypeStatus = '0' WHERE UserID = '{$_REQUEST['senderid']}'";
  mysqli_query($conn, $sqlcstt);
}

if ($_REQUEST['want'] == 'show') {

  // Change Status

  $sqlcstt = "SELECT * FROM users WHERE UserID = '{$_SESSION['ID']}'";
  $resultccc = mysqli_query($conn, $sqlcstt);

  $rowccc = $resultccc->fetch_assoc();

  if ($rowccc['TypeStatus'] == 1) {
    echo 'User Is Typing . . .';
  } else {
    echo ' ';
  }
}

if ($_REQUEST['want'] == 'allpages') {

  // Get User Pages From DB

  $sqlGetup = "SELECT * FROM pages WHERE UserID = '{$_SESSION['ID']}'";

  $resultGetup = mysqli_query($conn, $sqlGetup);

  $allpages = "";

  while ($rowGetup = $resultGetup->fetch_assoc()) {

    $allpages .= '
    
    <div class="post">
      <div class="post-media">
        <img src="' . $rowGetup['PageImage'] . '" alt="">
      </div>
      <div style="font-weight:bold;font-size:18px;text-align: center;margin-bottom: 10px;">' . $rowGetup['PageName'] . '</div>
      <div style="font-weight:bold;font-size:18px;text-align: center;line-height: 1.3;font-size: 15px;color: #444;">' . $rowGetup['PageDes'] . '</div>
      <div class="post-options-bottom">
        <div class="love">
          <i onclick="remove(' . $rowGetup['PageID'] . ')" class="fa fa-trash"></i>
        </div>
        <div class="share">
          <a href="page.php?id=' . $rowGetup['PageID'] . '"><i class="fa fa-external-link"></i></a>
        </div>
      </div>
    </div>
    
    ';

  }
  echo $allpages;
}


if ($_REQUEST['want'] == 'removepage') {

  // Remove Spacific Page By Id

  $sqlDsp = "DELETE FROM pages WHERE PageID = '{$_REQUEST['pageid']}' AND UserID = '{$_SESSION['ID']}'";

  mysqli_query($conn, $sqlDsp);

}

if ($_REQUEST['want'] == 'allpageposts') {
  // Get All Posts Of the Page By Its ID

  $sqlgetallpp = "SELECT * FROM posts WHERE IsPage = 1 AND PageID = '{$_REQUEST['pageid']}'";

  $resultgetallpp = mysqli_query($conn, $sqlgetallpp);

  $allpp = "";

  while ($rowgetallpp = $resultgetallpp->fetch_assoc()) {

    if ($rowgetallpp['UserID'] == '0') {

      // Get Page Data

      $sqlgetpaged = "SELECT * FROM pages WHERE PageID = '{$rowgetallpp['PageID']}'";

      $resultgetpaged = mysqli_query($conn, $sqlgetpaged);

      $rowgetpaged = $resultgetpaged->fetch_assoc();

    }

    // Fix Add Active Class

      #love

      $sqlcac = "SELECT * FROM love WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$rowgetallpp['PostID']}'";

      $resultcac = mysqli_query($conn, $sqlcac);

      if ($resultcac->num_rows > 0) {
        $fixclass = " love-active ";
      } else {
        $fixclass = "";
      }

      # Share
      
      $sqlcacs = "SELECT * FROM share WHERE UserID = '{$_SESSION['ID']}' AND PostID = '{$rowgetallpp['PostID']}'";

      $resultcacs = mysqli_query($conn, $sqlcacs);

      if ($resultcacs->num_rows > 0) {
        $fixclasss = " share-active ";
      } else {
        $fixclasss = "";
      }

      // Fix Delete Post

      if ($rowgetpaged['UserID'] == $_SESSION['ID']) {
        $fixDelete = '
        <div class="post-option">
          <i onclick="remove(' . $rowgetallpp['PostID'] . ')" class="fa fa-trash"></i>
        </div>
        ';
      } else {
        $fixDelete = "";
      }



      // Get Love Count

      $sqlglc = "SELECT COUNT(*) AS lc FROM love WHERE PostID = '{$rowgetallpp['PostID']}'";

      $resultglc = mysqli_query($conn, $sqlglc);

      $rowglc = $resultglc->fetch_assoc();

      // Insert Love Count

      $sqlilc = "UPDATE posts SET LoveCount = '{$rowglc['lc']}' WHERE PostID = '{$rowgetallpp['PostID']}'";

      mysqli_query($conn, $sqlilc);

      // Get Share Count

      $sqlgsc = "SELECT COUNT(*) AS sc FROM share WHERE PostID = '{$rowgetallpp['PostID']}'";

      $resultgsc = mysqli_query($conn, $sqlgsc);

      $rowgsc = $resultgsc->fetch_assoc();

      // Insert Share Count

      $sqlisc = "UPDATE posts SET ShareCount = '{$rowgsc['sc']}' WHERE PostID = '{$rowgetallpp['PostID']}'";

      mysqli_query($conn, $sqlisc);



    $allpp .= '
    
    <div class="post">

    <div class="post-head">

      <div class="user">
        <div class="image">
          <img src="' . $rowgetpaged['PageImage'] . '" alt="">
        </div>
        <div class="info">
          <p class="name">
            ' . $rowgetpaged['PageName'] . '
          </p>
        </div>
      </div>

      ' . $fixDelete . '
    </div>

    <div class="post-media">
      <img src="' . $rowgetallpp['PostImage'] . '" alt="">
    </div>

    <div class="post-text">
      <p>
        ' . $rowgetallpp['PostText'] . '
      </p>
      <a href="post.php?pid=' . $rowgetallpp['PostID'] . '">Read More</a>
    </div>

    <div class="post-options-bottom">
      <div class="love">
        <i onclick="love(' . $rowgetallpp['PostID'] . ')" class="fa ' . $fixclass . ' fa-heart"></i>
        <span class="love-count">' . $rowgetallpp['LoveCount'] . '</span>
      </div>
      <div class="share">
        <i onclick="share(' . $rowgetallpp['PostID'] . ')" class="fa ' . $fixclasss . ' fa-share-alt"></i>
        <span class="share-count">' . $rowgetallpp['ShareCount'] . '</span>
      </div>
    </div>
  </div>
    
    ';

  }
  echo $allpp;
}


if ($_REQUEST['want'] == 'removePagePost') {

  // Remove Post From The Page

  $sqlremovepfp = "DELETE FROM posts WHERE UserID = '0' AND PageID = '{$_REQUEST['pageid']}' AND PostID = '{$_REQUEST['postid']}'";
  mysqli_query($conn, $sqlremovepfp);

}

if ($_REQUEST['want'] == 'follow') {

  // Add Follow For Spacific Page

  # Check If User Already Have Followed This Page
  
  $sqlcfufp = "SELECT * FROM pagefollowers WHERE UserID = '{$_SESSION['ID']}' AND PageID = '{$_REQUEST['pageid']}'";

  $resultcfufp = mysqli_query($conn, $sqlcfufp);

  if ($resultcfufp->num_rows > 0) {

  // Remove Follow

  $sqldeletef = "DELETE FROM pagefollowers WHERE UserID = '{$_SESSION['ID']}' AND PageID = '{$_REQUEST['pageid']}'";
  
  mysqli_query($conn, $sqldeletef);

  } else {
    // Add Follow
    $sqlAddf = "INSERT INTO pagefollowers (UserID, PageID) VALUES ('{$_SESSION['ID']}', '{$_REQUEST['pageid']}')";

    mysqli_query($conn, $sqlAddf); 

  }

  
    // Update Followers Count

    # Count Page Followers

    $sqlGetFollowers = "SELECT COUNT(*) AS tf FROM pagefollowers WHERE PageID = '{$_REQUEST['pageid']}'";

    $resultgetFollowers = mysqli_query($conn, $sqlGetFollowers);

    $rowgetFollowers = $resultgetFollowers->fetch_assoc();

    # Update Followers Count

    $sqlUpdatefollowers = "UPDATE pages SET Followers = '{$rowgetFollowers['tf']}' WHERE PageID = '{$_REQUEST['pageid']}'";

    mysqli_query($conn, $sqlUpdatefollowers);

}

if ($_REQUEST['want'] == 'getfollowers') {

  $sqlGetFollowers = "SELECT COUNT(*) AS tf FROM pagefollowers WHERE PageID = '{$_REQUEST['pageid']}'";

  $resultgetFollowers = mysqli_query($conn, $sqlGetFollowers);

  $rowgetFollowers = $resultgetFollowers->fetch_assoc();

  echo $rowgetFollowers['tf'];

}
