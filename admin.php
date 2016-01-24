<?php
  session_start();
  if(!isset($_SESSION["id"])){
      header('Location: /login.php');
    }     
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Default functionality</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
  <script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js" integrity="sha384-XXXXXXXX" crossorigin="anonymous"></script>
 
</head>
<body>
<header>
 <nav class="navbar navbar-light bg-faded">
  <ul class="nav navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="admin">Gramme - Archi <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">Studio</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">Design</a>
    </li>
  </ul>
</nav>
</header>
  <div>
    <a href="/postcreate.php"> Créer un projet GRAMME</a>
    <a href="/postselect.php"> Gerer les projets GRAMME</a>
    <a href="/studio/postcreate.php"> Créer un projet STUDIO</a>
    <a href="/studio/postselect.php"> Gerer les projets STUDIO</a>
    <a href="/design/postcreate.php"> Créer un projet DESIGN</a>
    <a href="/design/postselect.php"> Gerer les projets DESIGN</a>
  </div>
</body>
</html>