<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Sortable - Default functionality</title>
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
              $("#sortable").append($("<li><img src='#' class='imgpreview' name='"+(id)+"' data-id='"+id+"'><button class='imgBtn' data-id='"+(id)+"'>Supprimer</button></li>"));
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
      $(".title").clone().appendTo("#theform");
      $(".type").clone().appendTo("#theform");
      $(".year").clone().appendTo("#theform");
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
  <div id="postedit">
    <input type="text" class="title" name="title" placeholder="Titre">
    <input type="text" class="type" name="type" placeholder="Type">
    <input type="text" class="year" name="year" placeholder="Année">
    <textarea name="text" class="text" form="theform" placeholder="Texte">Enter text here...</textarea>
    <input type='file' class="imgInp" name="0" data-id="0"/>
  </div>
    <ul id="sortable" style="height:80vh; overflow:scroll">

    </ul>
    <button id="savebutton">Save</button>
  </div>
  <form enctype="multipart/form-data" action="posts.php?action=createpost" method="post" id="theform">
    
    <input type="submit">
  </form>
</body>
</html>