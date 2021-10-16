<?php


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Saved Posts</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/later.css">
</head>

<body>

  <?php include "side-nav.php";?>

  <div class="head">Saved Posts For Later</div>

  <!-- Start Later Posts Container -->

  <div class="later-posts-container">


  </div>

  <!-- End Later Posts Container -->
  <script src="plugins/jquery.js"></script>
  <script>
    
    // Ajax For Get Latest Posts
    
    setInterval(function () {

      const xhttp = new XMLHttpRequest();

      xhttp.onload = function () {
        document.querySelector('.later-posts-container').innerHTML = this.responseText;
      }

      xhttp.open('GET', 'ajax.php?want=plater', true);

      xhttp.send();

    },500)


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

    function remove(postid) {
      const xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'ajax.php?want=removepost&postid=' + postid, true);
      xhttp.send();
    }
  </script>
</body>

</html>