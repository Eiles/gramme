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
      <a class="nav-link" href="/admin.php">Gramme - Archi <span class="sr-only">(current)</span></a>
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
  <div class="row" style="margin-left:50px;margin-top:50px">
    <div class="col-md-3">
      <a href="/postcreate.php" class="btn btn-primary-outline"> Créer un projet GRAMME</a> <br> <br>
      <a href="/postselect.php" class="btn btn-primary-outline"> Gerer les projets GRAMME</a>
    </div>
    <div class="col-md-3">
      <a href="/studio/postcreate.php" class="btn btn-success-outline"> Créer un projet STUDIO</a> <br> <br>
      <a href="/studio/postselect.php" class="btn btn-success-outline"> Gerer les projets STUDIO</a>
    </div>
    <div class="col-md-3">
      <a href="/design/postcreate.php" class="btn btn-info-outline"> Créer un projet DESIGN</a> <br> <br>
      <a href="/design/postselect.php" class="btn btn-info-outline"> Gerer les projets DESIGN</a>
    </div>
  </div>
</body>
</html>