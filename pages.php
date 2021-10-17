<?php

session_start();


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Pages</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/later.css">
  <link rel="stylesheet" href="css/pages.css">
</head>

<body>

  <?php include "side-nav.php";?>

  <div class="later-posts-container">


  </div>

  <script>
    setInterval(() => {
      const xhttp = new XMLHttpRequest();

      xhttp.onload = function () {
        document.querySelector('.later-posts-container').innerHTML = this.responseText;
      }

      xhttp.open('GET', 'ajax.php?want=allpages', true);
      xhttp.send();
    }, 500);

    function remove(pageid) {
      const xhttp = new XMLHttpRequest();
      xhttp.open('GET', 'ajax.php?want=removepage&pageid=' + pageid, true);
      xhttp.send();
    }
  </script>
</body>

</html>