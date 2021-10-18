<?php


require_once "config.php";

?>

<nav>
  <ul>
    <li><a href="home.php">
        <div class="cont">
          <p class="protect"></p><img src="imgs/home.png" alt="">
        </div>
      </a></li>
    <li><a href="chat.php">
        <div class="cont">
          <p class="protect"></p><img src="imgs/chat.png" alt="">
        </div>
      </a></li>
    <li><a href="explore.php">
        <div class="cont">
          <p class="protect"></p><img src="imgs/compass.png" alt="">
        </div>
      </a></li>
    <li><a href="#">
        <div class="cont">
          <p class="protect"></p><img src="imgs/hearts.png" alt="">
        </div>
      </a></li>
    <li><a href="later.php">
        <div class="cont">
          <p class="protect"></p><img src="imgs/push-pin.png" alt="">
        </div>
      </a></li>
      <?php
      
      // If User Has Page As Admin

      $sqlhpaa = "SELECT * FROM pages WHERE UserID = '{$_SESSION['ID']}'";

      $resulthpaa = mysqli_query($conn, $sqlhpaa);

      if ($resulthpaa->num_rows > 0) {

        echo '
        
        <li>
          <a href="pages.php">
            <div class="cont">
              <p class="protect"></p><img src="imgs/page.png" alt="">
            </div>
          </a>
        </li>

        ';

      }
      
      ?>
  </ul>
  <span class="gear">
    <div class="cont">
      <p class="protect"></p><img src="imgs/gear.png" alt="">
    </div>
  </span>
</nav>

<div class="settings-box">
  <ul>
    <li><a href="#">Profile</a></li>
    <li><a href="#">Edit Profile</a></li>
    <li><a href="create-page.php">Create Page</a></li>
    <li><a href="sign-out.php">Logout</a></li>
  </ul>
  <p class="arrow"></p>
</div>

<div class="top-nav">
  <div class="logo">
    <img src="imgs/logo.png" alt="">
  </div>
  <div class="search">
    <i class="fa fa-search"></i>
    <form action="search.php" method="POST">
      <input name="SearchKey" onkeyup="searchdb(this.value)" type="search" placeholder="Search Peoples, Pages"
        autocomplete="off">
    </form>

  </div>
  <div class="noti">
    <div class="layout">
    </div>
    <img src="imgs/notification.png" alt="">
    <span class="num"><?php echo $row['NumNoti'];?></span>
  </div>
</div>
<div class="search-result"></div>

<div class="noti-box">
  <div class="close">
    <i class="fa fa-times"></i>
  </div>
  <div class="friend-request">
    <div class="friend-box">

    </div>
  </div>
</div>
<style>
  .noti-box {
    width: 25%;
    height: 100%;
    background-color: #fff;
    position: absolute;
    right: 0;
    z-index: 100000;
    border-left: 1px solid #ccc;
    display: none;
  }

  .noti-box .friend-request .friend-box .fr {
    padding: 10px;
    border-bottom: 1px solid #fd508f;
    overflow: scroll;
    font-family: ubuntu, arial;
    overflow: hidden;
  }

  .noti-box .friend-request .image {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    float: left;
  }

  .noti-box .friend-request .image img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    border: 1px solid #fd508f;
  }

  .noti-box .friend-request .info {
    float: left;
    width: 50%;
    margin-left: 15px;
    margin-top: 15px;
  }

  .noti-box .friend-request .info .action {
    clear: both;
    margin-top: 10px;
  }

  .noti-box .friend-request .info .action button {
    padding: 5px;
    font-family: ubuntu, arial;
    font-weight: bold;
    font-size: 12px;
    color: #fff;
    background: linear-gradient(45deg, #fd508f, #f96b45);
    border: 1px solid #fd508f;
    border-radius: 5px;
    cursor: pointer;
    transition: all .3s;
  }

  .noti-box .friend-request .info .action button:hover {
    background: #fff;
    color: #fd508f;
  }

  .noti-box .close {
    width: 58px;
    height: 58px;
    text-align: center;
    line-height: 58px;
    border: 1px solid #fd508f;
    position: absolute;
    left: -58px;
    font-size: 20px;
    cursor: pointer;
    color: #fff;
    background-color: #fd508f;
    transition: all .3s;
  }

  .noti-box .close:hover {
    background-color: #fff;
    color: #fd508f;
  }

  * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
  }

  .search {
    position: relative;
  }

  .search-result {
    width: 38%;
    height: 500px;
    background-color: #FFF;
    border: 1px solid #CCC;
    border-radius: 5px;
    position: absolute;
    top: 70px;
    right: 19%;
    display: none;
    z-index: 1000;
  }
  nav {
    border-right: 1px solid #ccc;
    width: 50px;
    text-align: center;
    float: left;
    height: 100vh;
    position: relative;
    background-color: #ffffff;
  }

  .gear {
    position: absolute;
    bottom: 20px;
    left: 50%;
    transform: translateX(-50%);
    cursor: pointer;
  }

  .gear img {
    width: 100%;
  }

  .cont {
    position: relative;
  }

  .protect {
    position: absolute;
    width: 100%;
    height: 100%;
    user-select: none;
  }

  nav ul {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
  }

  nav ul li {
    margin-bottom: 30px;
    width: 100%;
  }

  nav ul li img {
    width: 65%;
  }

  .settings-box {
    position: fixed;
    z-index: 10000;
    left: 60px;
    bottom: 15px;
    border: 1px solid #fd508f;
    border-radius: 5px;
    display: none;
  }

  .settings-box ul {
    list-style: none;
    font-family: ubuntu, arial;
  }

  .settings-box ul li {
    background-color: #fd508f;
    text-align: center;
    border-bottom: 1px solid #fff;
  }

  .settings-box ul li:first-of-type {
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;
  }

  .settings-box ul li:last-of-type {
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    border-bottom: none;
  }

  .settings-box ul li a {
    text-decoration: none;
    padding: 10px;
    color: #000;
    display: block;
    color: #fff;
    transition: all .3s;
    border-radius: none;
  }

  .settings-box ul li a:hover {
    color: #fd508f;
    background-color: #fff;
  }

  .arrow {
    border-width: 10px;
    border-style: solid;
    border-color: transparent #fd508f transparent transparent;
    position: absolute;
    bottom: 8px;
    left: -21px;
  }

  .top-nav {
    padding: 10px 0;
    overflow: hidden;
    border-bottom: 1px solid #CCC;
    background-color: #fff;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
  }

  .top-nav>div {
    float: left;
  }

  .top-nav .logo {
    width: 40%;
  }

  .top-nav .logo img {
    width: 100px;
    margin-left: 10px;
  }

  .top-nav .search {
    width: 40%;
    text-align: right;
    border: 1px solid #CCC;
    border-radius: 4px;
    padding: 3px 0;
    color: #666;
  }

  .top-nav .search i {
    float: left;
    width: 30px;
    height: 30px;
    line-height: 30px;
    text-align: center;
  }

  .top-nav .search input {
    float: right;
    height: 30px;
    width: calc(100% - 30px);
    margin-top: 5px;
    outline: none;
    border: none;
    font-size: 17px;
    font-family: ubuntu, arial;
    margin-top: 0px;
  }

  .top-nav .search input::placeholder {
    opacity: 1;
    transition: all .5s;
  }

  .top-nav .search input:focus::placeholder {
    opacity: 0;
  }

  .top-nav .noti {
    width: 20%;
    text-align: right;
    position: relative;
  }

  .layout {
    position: absolute;
    right: 15px;
    width: 30px;
    height: 100%;
    cursor: pointer;
  }

  .top-nav .noti img {
    width: 25px;
    margin-right: 15px;
    margin-top: 7px;
    cursor: pointer;
  }

  .top-nav .noti .num {
    position: absolute;
    bottom: 0;
    right: 10px;
    background-color: #fd508f;
    color: #fff;
    font-weight: bold;
    font-family: ubuntu, arial;
    font-size: 13px;
    width: 15px;
    height: 15px;
    line-height: 15px;
    text-align: center;
    border-radius: 50%;
  }
</style>
<script src="plugins/jquery.js"></script>
<script>
$('.close').click(function() {
  $('.noti-box').fadeOut();
})
$('.noti .layout').click(function() {
  $('.noti-box').fadeToggle();
})
var settings = document.querySelector('.gear');
settings.onclick = function() {
  $('.settings-box').fadeToggle();
}

// Ajax Request

var searchRes = document.querySelector('.search-result');
var search = document.querySelector('input[name="SearchKey"');

search.oninput = function() {
  if (search.value == "") {
    searchRes.style = "display:none";
  } else {
    searchRes.style = "display:block"
  }
}


function searchdb(str) {
  if (str == "") {
    document.querySelector('.search-result').innerHTML = "";
    return;
  }
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.querySelector('.search-result').innerHTML = this.responseText;
  }
  xhttp.open("GET", "search.php?key=" + str);
  xhttp.send();
}

setInterval(() => {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.querySelector('.noti .num').innerHTML = this.responseText;
  }

  xhttp.open('GET', 'ajax.php?want=noti', true);
  xhttp.send();
}, 500);

// Ajax For Get Friend Requests

setInterval(function () {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.querySelector('.noti-box .friend-box').innerHTML = this.responseText;
  }
  xhttp.open('GET', 'ajax.php?want=friend', true);
  xhttp.send();
}, 1000);

// Accept Friend Ajax

function accept(ids,emails) {
  const xhttp = new XMLHttpRequest();
  xhttp.open('GET', 'ajax.php?want=accept&id=' + ids + "&email=" + emails, true);
  xhttp.send();
}

// Remove Friend Ajax

function cancel(ids,emails) {
  const xhttp = new XMLHttpRequest();
  xhttp.open('GET', 'ajax.php?want=cancel&id=' + ids + "&email=" + emails, true);
  xhttp.send();
}

// Add Follow If Page

function follow(pageid) {
  const xhttp = new XMLHttpRequest();
  xhttp.open('GET', 'ajax.php?want=follow&pageid=' + pageid, true);
  xhttp.send();
}
</script>