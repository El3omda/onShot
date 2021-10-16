<?php session_start();
require_once "config.php"; 
// Get Sender ID 
$UserEmail = $_SESSION['UserEmail']; 
$sqlgsi = "SELECT * FROM users WHERE UserEmail = '$UserEmail'";
$resultgsi = mysqli_query($conn, $sqlgsi);
$rowgsi = $resultgsi->fetch_assoc(); 

@$UserID = $_REQUEST['rid'];

// Get Reciver Name

$sqlgrn = "SELECT UserName,UserStatus FROM users WHERE UserID = '$UserID'";
$resultgrn = mysqli_query($conn, $sqlgrn);
$rowgrn = $resultgrn->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Start Chatting With Your Friends </title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/my-frame.css">
  <link rel="stylesheet" href="css/chat.css">
</head>

<body style="margin-top: 64px;"> <?php include "side-nav.php";?> <div class="heading">
    <div class="chat"><span class="resiver">
      <?php
      
      if ( $rowgrn['UserStatus'] == 'offline' ) {
        echo $rowgrn['UserName'] . ' Is ' . 'Offline';
      } elseif ( $rowgrn['UserStatus'] == 'online') {
        echo $rowgrn['UserName'] . ' Is ' . 'Online';
      } else {
        echo '';
      }
      
      ?>
    </span> </div>
    <div class="title"> Your Friends </div>
  </div>
  <div class="chat-box">
    <div class="chat-msgs"> </div>
    <div class="send-msg">
      <form class="msg-send" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
        <div class="send"> <input type="text" class="msgToSend" name="msg" placeholder="Enter Your Message Here . . ."
            autofocus> <input type="hidden" name="sender" value="<?php echo $rowgsi['UserID'];?>"> <input class="rid"
            type="hidden" name="resiver" value="<?php echo $_REQUEST['rid'];?>"> <button class="stdb"
            onclick="insertMsg(document.querySelector('.msgToSend').value)"> <i class="fa fa-paper-plane"></i> </button>
        </div>
      </form>
    </div>
  </div>
  <div class="friends-container">
    
  </div>
  <div class="ss-friends">

  </div>
  <div class="ssbox">
    <i class="fa fa-users"></i>
  </div>
  <div class="closevox">
    <i class="fa fa-times"></i>
  </div>

  <!-- <?php
  
  // Check Reciver Typing Status

  $sqlcrus = "SELECT * FROM users WHERE UserID = '{$_SESSION['ID']}'";

  $resultcrus = mysqli_query($conn, $sqlcrus);

  $rowcrus = $resultcrus->fetch_assoc();

  if ($rowcrus['TypeStatus'] == '1') {
  
    echo '';
  
  }

  ?> -->

<p class="typing"></p>
  
  <script src="plugins/jquery.js"></script>
  <script>
  $('.ssbox').click(function() {
    $('.ss-friends').fadeIn()
    $(this).hide()
    $('.closevox').show()
  })

  $('.closevox').click(function () {
    $('.ss-friends').fadeOut()
    $('.ssbox').fadeIn()
    $(this).hide()
  })
  
  var form = document.querySelector('.msg-send');
  form.onclick = function(e) {
    e.preventDefault();
  } // Submit Msg With Ajax 
  let reciverID = document.querySelector('.rid').value;

  function insertMsg(Msg) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.querySelector('.msgToSend').value = '';
    }
    xhttp.open('GET', 'ajax.php?msg=' + Msg + '&rid=' + reciverID, true);
    xhttp.send();
  }
  if (document.querySelector('.msgToSend').value = '') {
    document.querySelector('.stdb').onclick = function() {
      document.querySelector('.msgToSend').focus();
    }
  } // Get Chat Msgs
  setInterval(function () {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.querySelector('.chat-msgs').innerHTML = this.responseText;
      document.querySelector('.chat-msgs').scrollTop = document.querySelector('.chat-msgs').scrollHeight;
    }
    xhttp.open('GET', 'ajax.php?want=chat&rid=' + reciverID, true);
    xhttp.send();
  }, 500);

  // Get USer Friends By Ajax

  setInterval(function () {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
      document.querySelector('.friends-container').innerHTML = this.responseText;
      document.querySelector('.ss-friends').innerHTML = this.responseText;
    }
    xhttp.open('GET', 'ajax.php?want=getfriends', true);
    xhttp.send()
  }, 1000);

  // Show Recent Msgs
  if (window.location.search == "") {
    
    // Ajax Request

    setInterval(function () {
      const xhttp = new XMLHttpRequest();

      xhttp.onload = function () {
        document.querySelector('.chat-msgs').innerHTML = this.responseText;
      }

      xhttp.open('GET', 'ajax.php?want=allchat', true);

      xhttp.send();

    }, 1000);

    document.querySelector('.msg-send').style = "display:none"
  }

  // Typing Status

  var senderid = document.querySelector('input[name="resiver"]').value;

  document.querySelector('.msgToSend').oninput = function () {
    

    if (document.querySelector('.msgToSend').value.length > 0) {

    const xhttp = new XMLHttpRequest();

    xhttp.open('GET', 'ajax.php?want=typing&senderid=' + senderid, true);

    xhttp.send();

    setInterval(function() {

      const xhttp = new XMLHttpRequest();

      xhttp.onload = function () {

        document.querySelector('.typing').innerHTML = this.responseText;

      }

      xhttp.open('GET', 'ajax.php?want=show&senderid=' + senderid, true);

      xhttp.send();

    }, 500)
      
    } else {
      
      const xhttp = new XMLHttpRequest();

    xhttp.open('GET', 'ajax.php?want=nottyping&senderid=' + senderid, true);

    xhttp.send();

    }

    
  
  }

  

  </script>
</body>

</html>