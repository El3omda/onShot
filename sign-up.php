<?php

session_start();

require_once "config.php";

if (!isset($_SESSION['ReEmail'])) {
  header("Location:sign.php");
}

if (isset($_POST['finishre'])) {
  // Sql For Add New User
  $UserEmail = $_POST['UserEmail'];
  $UserPassword = $_POST['UserPassword'];
  $UserName = $_POST['UserName'];
  $BirthDay = $_POST['BirthDay'];
  $BirthMon = $_POST['BirthDay'];
  $BirthYea = $_POST['BirthDay'];

  // User Favorits
  
  $favs = [];

  foreach ($_POST as $name => $value) {
    if ($value == 'on') {
      array_push($favs, $name);
    }
  }

// Create Unique ID For Users

#Random Number

$rand = rand(0,1000);

# Date Values

$year = date('y');
$month = date('m');
$day = date('d');
$hour = date('d');
$min = date('i');
$sec = date('s');

$UserId = $rand . "0" . $year . "0" . $month . "0" . $day . "0" . $hour . "0" . $min . "0" . $sec;

$UserPhoto = "imgs/data/users/" . $UserEmail . "-" . $UserName . ".jpg";

  $UserFav = implode(" ", $favs);

  $sqlnu = "INSERT INTO users (UserID,UserEmail,UserPassword,UserName,BirthDay,BirthMon,BirthYear,UserFav,UserStatus,UserPhoto)
            VALUES ({$UserId},'$UserEmail', '$UserPassword', '$UserName', '$BirthDay', '$BirthMon', '$BirthYea', '$UserFav','online','$UserPhoto')";
  if (mysqli_query($conn, $sqlnu)) {
    $_SESSION['UserEmail'] = $_POST['UserEmail'];
    $_SESSION['UserName'] = $_POST['UserName'];
    $_SESSION['ID'] = $UserId;
    header("Location:photo.php");
  } else {
    echo mysqli_error($conn);
  }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link rel="stylesheet" href="css/my-frame.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/sign-up.css">
</head>

<body>

  <?php include "nav.php"?>
  <!-- Start Info Container -->

  <div class="info-container">
    <!-- <p class="head mb2 setpasshead">Set Your Password</p> -->
    <p class="head mb2 userinfohead">Enter Your Infomations</p>
    <p class="head mb2 userfavhead">Select Your Favorites</p>
    <p class="head mb2 checkhead">Checking Your Data</p>
    <form action="" method="POST">
      <input name="UserEmail" type="hidden" value="<?php echo $_SESSION['ReEmail'];?>">

      <!-- Start Set Password -->

      <div class="set-pass">

        <div class="input-feild">
          <label for="pass1" class="db mb1">Password</label>
          <input name="UserPassword" class="mb1" id="pass1" type="password" placeholder="Enter Your Password">
        </div>

        <div class="input-feild">
          <label for="pass2" class="db mb1">Repeat Password</label>
          <input name="UserPassword2" class="mb2" id="pass2" type="password" placeholder="Repeat Your Password">
        </div>

        <span class="btn center setpassbtn">Continue</span>

      </div>

      <!-- End Set Password -->

      <!-- Start User Informations -->

      <div class="user-info">

        <div class="input-feild">
          <label for="UserName" class="db mb1">Name</label>
          <input name="UserName" class="mb1" id="UserName" type="text" placeholder="Enter Your Name">
        </div>

        <div class="input-feild mb2">
          <label for="day" class="db mb1">Birthday</label>
          <input class="birthin" id="day" name="BirthDay" type="number" min="1" max="30" placeholder="Day">
          <input class="birthin" name="BirthMon" type="number" min="1" max="12" placeholder="Month">
          <input class="birthin" name="BirthYea" type="number" min="1900" max="<?php echo date('Y');?>"
            placeholder="Year">
        </div>

        <span class="btn center userinfobtn">Continue</span>

      </div>

      <!-- End User Informations -->

      <!-- Start User Fav -->

      <div class="user-fav">

        <ul class="box-fav mb1">
          <li><input type="checkbox" name="Sports" id="sports"> <label for="sports">Sports</label></li>
          <li><input type="checkbox" name="Science" id="science"> <label for="science">Science</label></li>
          <li><input type="checkbox" name="beauty" id="beauty"> <label for="beauty">Beauty</label></li>
          <li><input type="checkbox" name="nature" id="nature"> <label for="nature">Nature</label></li>
          <li><input type="checkbox" name="comedy" id="comedy"> <label for="comedy">Comedy</label></li>
          <li><input type="checkbox" name="technology" id="technology"> <label for="technology">Technology</label></li>
          <li><input type="checkbox" name="foods" id="foods"> <label for="foods">Foods</label></li>
          <li><input type="checkbox" name="cartoon" id="cartoon"> <label for="cartoon">Cartoon</label></li>
          <li><input type="checkbox" name="culture" id="culture"> <label for="culture">Culture</label></li>
          <li><input type="checkbox" name="music" id="music"> <label for="music">Music</label></li>
        </ul>

        <span class="btn center userfavbtn">Continue</span>

      </div>

      <!-- End User Fav -->

      <!-- Start Check -->

      <div class="check">
        <ul class="list mb1">
          <li><i class="fa fa-spinner fa-spin"></i> Checking Your Email</li>
          <li><i class="fa fa-spinner fa-spin"></i> Checking Your Password</li>
          <li><i class="fa fa-spinner fa-spin"></i> Checking Your Name</li>
          <li><i class="fa fa-spinner fa-spin"></i> Checking Your Birthday</li>
          <li><i class="fa fa-spinner fa-spin"></i> Checking Your Favorites</li>
        </ul>

        <button name="finishre" type="submit" class="btn center checkbtn">Finish</button>

      </div>

      <!-- End Check -->

    </form>

  </div>

  <!-- End Info Container -->

  <?php include "footer.php"?>

  <script src="plugins/jquery.js"></script>

  <script>
  function run() {
    let c = document.querySelectorAll('.check ul li i');
    setTimeout(function() {
      c[0].classList.remove('fa-spinner')
      c[0].classList.remove('fa-spin')
      c[0].classList.add('fa-check')
      c[0].style = "color:#21cd12"
      c[0].parentElement.style = "color:#21cd12"
    }, 1000)
    setTimeout(function() {
      c[1].classList.remove('fa-spinner')
      c[1].classList.remove('fa-spin')
      c[1].classList.add('fa-check')
      c[1].style = "color:#21cd12"
      c[1].parentElement.style = "color:#21cd12"
    }, 2000)
    setTimeout(function() {
      c[2].classList.remove('fa-spinner')
      c[2].classList.remove('fa-spin')
      c[2].classList.add('fa-check')
      c[2].style = "color:#21cd12"
      c[2].parentElement.style = "color:#21cd12"
    }, 3000)
    setTimeout(function() {
      c[3].classList.remove('fa-spinner')
      c[3].classList.remove('fa-spin')
      c[3].classList.add('fa-check')
      c[3].style = "color:#21cd12"
      c[3].parentElement.style = "color:#21cd12"
    }, 4000)
    setTimeout(function() {
      c[4].classList.remove('fa-spinner')
      c[4].classList.remove('fa-spin')
      c[4].classList.add('fa-check')
      c[4].style = "color:#21cd12"
      c[4].parentElement.style = "color:#21cd12"
    }, 5000)
    setTimeout(function() {
      $('.checkbtn').fadeIn()
    }, 5500)
  }
  // Set Pass
  var setpassbtn = document.querySelector('.setpassbtn');
  var pass1 = document.querySelector('#pass1')
  var pass2 = document.querySelector('#pass2')
  // User Info
  var username = document.querySelector('.user-info input[name="UserName"]');
  var birthday = document.querySelector('.user-info input[name="BirthDay"]');
  var birthmon = document.querySelector('.user-info input[name="BirthMon"]');
  var birthyea = document.querySelector('.user-info input[name="BirthYea"]');
  var userinfobtn = document.querySelector('.userinfobtn');
  // User Fav
  var favorites = document.querySelectorAll('.user-fav ul li label');
  var userfavbtn = document.querySelector('.userfavbtn');

  favorites.forEach(function(fav) {
    fav.addEventListener('click', function() {
      fav.parentElement.classList.toggle('active')
    })
  })

  favorites.forEach(function(fav) {
    $('.userfavbtn').hide()
    fav.onclick = function() {
      if (fav.parentElement.classList.length > 0) {
        $('.userfavbtn').fadeIn()
      } else {
        $('.userfavbtn').fadeOut()
      }
    }
  })

  if (pass1.value == "" || pass2.value == "") {
    $('.setpassbtn').hide()
  } else {
    $('.setpassbtn').fadeIn()
  }

  pass2.oninput = function() {
    if (pass1.value == '' || pass2 == '') {
      $('.setpassbtn').fadeOut()
    } else if (pass1.value == pass2.value) {
      $('.setpassbtn').fadeIn()
    } else {
      $('.setpassbtn').fadeOut()
    }
  }

  pass1.oninput = function() {
    if (pass1.value == '' || pass2 == '') {
      $('.setpassbtn').fadeOut()
    } else if (pass1.value == pass2.value) {
      $('.setpassbtn').fadeIn()
    } else {
      $('.setpassbtn').fadeOut()
    }
  }

  setpassbtn.onclick = function() {

    $('.info-container .set-pass').fadeOut()
    $('.userinfohead').delay(500).fadeIn()
    $('.info-container .setpasshead').fadeOut()
    $('.user-info').delay(500).fadeIn()

  }

  userinfobtn.onclick = function() {

    $('.info-container .userinfohead').fadeOut()
    $('.userfavhead').delay(500).fadeIn()
    $('.info-container .user-info').fadeOut()
    $('.user-fav').delay(500).fadeIn()

  }

  userfavbtn.onclick = function() {

    $('.info-container .userfavhead').fadeOut()
    $('.checkhead').delay(500).fadeIn()
    run()
    $('.info-container .user-fav').fadeOut()
    $('.check').delay(500).fadeIn()

  }

  // User Info

  if (username.value == "" || birthday.value == "" || birthmon.value == "" || birthyea.value == "") {
    $('.userinfobtn').hide()
  }
  username.oninput = function() {
    if (username.value == "" || birthday.value == "" || birthmon.value == "" || birthyea.value == "") {
      $('.userinfobtn').hide()
    } else {
      $('.userinfobtn').fadeIn()
    }
  }
  birthday.oninput = function() {
    if (username.value == "" || birthday.value == "" || birthmon.value == "" || birthyea.value == "") {
      $('.userinfobtn').hide()
    } else {
      $('.userinfobtn').fadeIn()
    }
  }
  birthmon.oninput = function() {
    if (username.value == "" || birthday.value == "" || birthmon.value == "" || birthyea.value == "") {
      $('.userinfobtn').hide()
    } else {
      $('.userinfobtn').fadeIn()
    }
  }
  birthyea.oninput = function() {
    if (username.value == "" || birthday.value == "" || birthmon.value == "" || birthyea.value == "") {
      $('.userinfobtn').hide()
    } else {
      $('.userinfobtn').fadeIn()
    }
  }

  $(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
  </script>

</body>

</html>