<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Default functionality</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
  <style>
  #left { float:left; list-style-type: none; margin: 0; padding: 0; width: 49%; }
  #sortable {list-style-type: none; margin: 0; padding: 0; }
  #sortable li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 10vh; }
  #sortable li span { position: relative; margin-left: -1.3em; }
  #postslist{float: right; list-style-type: none; margin: 0; padding: 0; width: 49%;}
  #postslist li { margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 10vh; }
  #postslist li span { position: absolute; margin-left: -1.3em; }
  img{ display: inline-block;}
  </style>
  <script>
  var hasChanged=0;
  var selectedPosts=[];
  var availablePosts=[];
  $(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
    $("#sortable").on("sortupdate",function(){
        hasChanged=1;
    });
    $(window).bind('beforeunload', function(){
      if(hasChanged)
        return "Des changements ont été effectués mais n'ont pas été sauvegardés.";
    });

     $(document).on( "click","#postslist li .ui-icon-plus",function(){
      hasChanged=1;
      var li=$(this).parent();
      var id = li.attr("post-id");
      var i = 0;
      $(this).removeClass("ui-icon-plus").addClass("ui-icon-minus")
      li.remove();
      while (availablePosts[i]) {
        if(availablePosts[i].id==id){
          $("#sortable").prepend($(availablePosts[i].content));
          selectedPosts.push(availablePosts[i]);
          availablePosts.splice(i,1);
          return;
        }
        i++;
      }
    })

     $(document).on( "dblclick","#postslist li",function(){
      hasChanged=1;
      var li=$(this).parent();
      var id = $(this).attr("post-id");
      var i = 0;
      $(this).find(".ui-icon").removeClass("ui-icon-plus").addClass("ui-icon-minus")
      $(this).remove();
      while (availablePosts[i]) {
        if(availablePosts[i].id==id){
          $("#sortable").prepend($(availablePosts[i].content));
          selectedPosts.push(availablePosts[i]);
          availablePosts.splice(i,1);
          return;
        }
        i++;
      }
    })
    $(document).on( "click","#sortable li .ui-icon-minus",function(){
      hasChanged=1;
      var li=$(this).parent();
      var id = li.attr("post-id");
      var i = 0;
      $(this).removeClass("ui-icon-minus").addClass("ui-icon-plus")
      li.remove();
      while (selectedPosts[i]) {
        if(selectedPosts[i].id==id){
          $("#postslist").prepend($(selectedPosts[i].content));
          availablePosts.push(selectedPosts[i]);
          selectedPosts.splice(i,1);
          return;
        }
        i++;
      }
    })
    $(document).on("click","#savebutton",function(){
      var postlist=[];
      var i=0;
      $( "#sortable" ).sortable( "refresh" );
      var sortedIDs = $( "#sortable" ).sortable( "toArray", {attribute:"post-id"} );
      console.log(sortedIDs);
      while (sortedIDs[i]) {
        postlist.push({id:sortedIDs[i]});
        i++;
      }
      $.ajax({
        method: "POST",
        url: "posts.php?action=savepage",
        data: {postlist:postlist }
      })
      .done(function() {
        hasChanged=0;
        alert("Page sauvegardée");
      });
    });
    initPosts();
  });
  function initPosts(){
    $("#sortable").find("li").each(function(){
        selectedPosts.push({id:$(this).attr("post-id"),content:$(this).eq(0)});
    });
    $("#postslist").find("li").each(function(){
        availablePosts.push({id:$(this).attr("post-id"),content:$(this).eq(0)});
    });
  }

  </script>
</head>
<body>
<header>
 <nav class="navbar navbar-light bg-faded">
  <ul class="nav navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="#">Gramme - Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">Projects</a>
    </li>
  </ul>
</nav>
</header>
  <div id="left">
    <ul id="sortable" style="height:80vh; overflow:scroll">
      <?php 
        $mysqli = new mysqli('127.0.0.1', 'root', 'strtoupper', 'gramme');
        $selectedPosts=$mysqli->query("SELECT posts.idposts, posts.title,posts.type,posts.year FROM posts WHERE idposts IN (SELECT idpost from homepage)");
        while ($row = $selectedPosts->fetch_row()) {
            echo '<li id="post1" post-id="'.$row[0].'" class="ui-state-default"><span class="ui-icon ui-icon-minus"></span><div style="float: left;height:100%">
              <img src="img/'.$row[4].'" style="height:100%">'
              .($row[5]?'<img src="img/'.$row[5].'" style="height:100%")':"").'
            </div>
            <div style="float: right;height:100%">
              '.$row[1].'/'.$row[2].'/'.$row[3].'
          </div></li>';
        }
  ?>
    </ul>
    <button id="savebutton">Save</button>
  </div>

  <div id="postslist">
    <?php 
        $mysqli = new mysqli('127.0.0.1', 'root', 'strtoupper', 'gramme');
        $selectedPosts=$mysqli->query("SELECT posts.idposts, posts.title,posts.type,posts.year FROM posts WHERE posts.idposts NOT IN (SELECT idpost from homepage)");
        while ($row = $selectedPosts->fetch_row()) {
            echo '<li id="post1" post-id="'.$row[0].'" class="ui-state-default"><span class="ui-icon ui-icon-plus"></span><div style="float: left;height:100%">
              <img src="img/'.$row[4].'" style="height:100%">'
              .($row[5]?'<img src="img/'.$row[5].'" style="height:100%")':"").'
            </div>
            <div style="float: right;height:100%">
              '.$row[1].'/'.$row[2].'/'.$row[3].
              '</div></li>';
        }
  ?>
  </div>
 
</body>
</html>