<!doctype html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title>GRAMME</title>
    <meta name="description" content="PLACEMENT GRAMME">

    <link rel="stylesheet" href="css/styles.css">

</head>

<body>
    
    <script src="js/jquery-2.2.0.min.js"></script>
  	<script src="js/scripts.js"></script>
    <?php 
    $mysqli = new mysqli('127.0.0.1', 'root', 'strtoupper', 'gramme');
        $selectedPosts=$mysqli->query("SELECT posts.idposts, posts.title,posts.type,posts.year, posts.text FROM posts  WHERE idposts IN (SELECT idpost from homepage)");
        while ($row = $selectedPosts->fetch_row()) {
          $postlist["id"][]=$row[0];
          $postlist["title"][]=$row[1];
          $postlist["type"][]=$row[2];
          $postlist["year"][]=$row[3];
          $postlist["text"][]=$row[4];
        }
        $i=0;
        while($postlist["id"][$i]){
          $selectedPosts=$mysqli->query("SELECT i.url FROM postimages LEFT JOIN images as i ON postimages.idimage=i.idimages WHERE postimages.idpost=".$postlist["id"][$i]);
          $row = $selectedPosts->fetch_row();
          echo('<div data-id="'.$postlist["id"][$i].'" class="project"><img src="img/'.$row[0].'"></div>');
          echo('<script>
              $("div[data-id=\"'.$postlist["id"][$i].'\"]").click(function(){
                $("#modal").html("<span class=\"sousTitre\">'.$postlist["title"][$i].'</span><br>'.$postlist["type"][$i].'<br>'.$postlist["year"][$i].'<br><br>'.$postlist["text"][$i].'<br><br>');
                    while($row = $selectedPosts->fetch_row()){
                      echo("<img style='width:700px' src='img/".$row[0]."'><br><br><br>");
                    }
          echo('© GRAMME <br><br><br>")
          resizeModal();
          $(\'#fond\').fadeIn(30);   
          $(\'#fond\').fadeTo("slow",0.8);
          $("#modal").fadeIn(30);
   
        $(\'.popup .close\').click(function (e) {
         // On désactive le comportement du lien
        e.preventDefault();
        // On cache la fenetre modale
        hideModal();
        });
          });</script>');
          $i++;
        }
      ?>
    <div id="modal" class="popup"></div>
    <div id="fond"></div>
</body>
</html>