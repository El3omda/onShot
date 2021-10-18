<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Explore New Posts</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/later.css">
</head>

<body>

  <?php include "side-nav.php";?>

  <div class="head">Explore New Posts</div>

  <!-- Start Later Posts Container -->

  <div class="later-posts-container">

  </div>

  <!-- End Later Posts Container -->

  <script>

  // Ajax For Get All Posts

  setInterval(function() {

    const xhttp = new XMLHttpRequest();

    xhttp.onload = function() {
      document.querySelector('.later-posts-container').innerHTML = this.responseText;
    }

    xhttp.open('GET', 'ajax.php?want=pexplore', true);

    xhttp.send();

  }, 500)


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

  function addlater(postid) {
    const xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'ajax.php?want=addlater&postid=' + postid, true);
    xhttp.send();
  }
  </script>

</body>

</html>