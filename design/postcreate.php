<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Gramme</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
  <link rel="stylesheet" href="css/styles.css">
  <script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
  <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <style>
  #sortable {list-style-type: none; margin: 0; padding: 0; }
  #sortable li { height: 20vh; width: 100% }
  img{ display:block;max-height:90%;}
  </style>
  <script>
  $(function() {
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();
  });

  function readURL(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          
          reader.onload = function (e) {
              var id=$(".imgInp").last().attr("data-id");
              $("#sortable").append($("<li class='content-img'><img src='#' class='imgpreview' name='"+(id)+"' data-id='"+id+"'><button class='imgBtn btn-delete-post' data-id='"+(id)+"'>Supprimer</button></li>"));
              $('.imgpreview').last().attr('src', e.target.result);
              $( "input[data-id='"+id+"']" ).hide();
              $("#postedit").append("<input type='file' class='imgInp' name='"+(id+1)+"' data-id='"+(id+1)+"'/>")
          }
          
          reader.readAsDataURL(input.files[0]);
      }
    }
    
    $(document).on( "change",".imgInp",function(){
        readURL(this);
    });

    $(document).on( "click",".imgBtn",function(){
        var id=$(this).attr("data-id");
        $( "input[data-id='"+id+"']" ).remove();
        $(this).parent().remove();
    });

    $(document).on( "click","#savebutton",function(){
      if($("#sortable li img").length==0){
        alert("Impossible de créer un projet sans image");
        return;
      }
      $(".title").clone().appendTo("#theform");
      $(".type").clone().appendTo("#theform");
      $(".year").clone().appendTo("#theform");
      $("#sortable li img").each(function(){
        var id=$(this).attr("data-id");
        $("input[data-id='"+id+"']").appendTo("#theform");
      })
      $("#theform").submit();
    });

  </script>
</head>
<body>
<header>
 <nav class="navbar navbar-light bg-faded">
  <ul class="nav navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="/admin.php">Gramme - Home <span class="sr-only">(current)</span></a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">Projects</a>
    </li>
  </ul>
</nav>
</header>
  <div id="postedit" class="form-add-post">
    <div class="form-group">
      <label>Titre</label>
      <input type="text" class="title" name="title" placeholder="Titre">
    </div>

    <div class="form-group">
      <label>Sous-titre</label>
      <input type="text" class="type" name="type" placeholder="Type">
    </div>
    <div class="form-group">
      <label>Année </label>
      <input type="text" class="year" name="year" placeholder="Année">
    </div>
    <div class="form-group">
      <label>Descritption</label>
      <textarea name="text" class="text" form="theform" placeholder="Texte">Enter text here...</textarea>
    </div>
    
    <div class="form-group">
      <label>Images Projet</label>
      <input type='file' class="imgInp" name="0" data-id="0"/>
    </div>
  </div>
    <ul id="sortable" style="height:80vh; overflow:scroll;width:50%;margin:auto">

    </ul>
    <button id="savebutton" class="btn btn-primary" style="position:absolute;right:50px;bottom:0px">Save</button>
  </div>
  <form enctype="multipart/form-data" action="posts.php?action=createpost" method="post" id="theform" style="display:none">
    
  </form>
</body>
</html>