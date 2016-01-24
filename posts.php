<?php
	session_start();
	/*if(!isset($_SESSION["id"])){
		die('FORBIDDEN')
	}*/
	if(isset($_GET["action"])){
		switch($_GET["action"]){
			case "getposts" : {
				getPosts();break;
			}
			case "modpost" : {
				modPost();break;
			}
			case "createpost" : {
				createPost();break;
			}
			case "savepage" : {
				savePage();break;
			}
		}
	}

	function getPosts(){
		$mysqli = new mysqli('127.0.0.1', 'root', 'strtoupper', 'gramme');
		$result = $mysqli->query("SELECT * FROM posts");
		$encode = array();

		while($row = mysqli_fetch_assoc($result)) {
   			$encode[] = $row;
		}
		echo json_encode($encode);
	}


	function modPost(){
		if(!isset($_POST["postid"])){
			die("No postid");
		}
		if(!isset($_POST["title"])){
			die("No title");
		}
		if(!isset($_POST["type"])){
			die("No type");
		}
		if(!isset($_POST["year"])){
			die("No year");
		}
		if(!isset($_POST["text"])){
			die("No text");
		}
		if(!isset($_POST["img1"])){
			die("No illustration");
		}
		if(!isset($_POST["imagelist"])){
			die("No image list");
		}
		$mysqli = new mysqli('127.0.0.1', 'root', 'strtoupper', 'gramme');
		$postid=$_POST["postid"];
		$title=$_POST["title"];
		$type=$_POST["type"];
		$year=$_POST["year"];
		$text=$_POST["text"];
		$img1=$_POST["img1"];
		$img2=isset($_POST["img2"])?$_POST["img2"]:NULL;
		$imagelist=$_POST["imagelist"];
		$i=0;
		$mysqli->query("DELETE FROM postimages WHERE idpost = ".$postid);
		foreach ($imagelist as $img){
    		$mysqli->query("INSERT INTO `postimages`(`idimage`, `idpost`, `atindex`) VALUES (".$img["id"].' , '.$postid.' , '.$i.")");
			$i++;
		}
		
		$mysqli->query("UPDATE posts SET title='".$title."'	 , type='".$type."', year='". $year."' , text='".$text."' , img1 = ".$img1.$img2?", img2 = ".$img2:""." WHERE idposts=".$postid);
	}

	function createPost(){
		/*if(!isset($_POST["title"])){
			die("No title");
		}
		if(!isset($_POST["type"])){
			die("No type");
		}
		if(!isset($_POST["year"])){
			die("No year");
		}
		if(!isset($_POST["text"])){
			die("No text");
		}
		if(!isset($_POST["img1"])){
			die("No illustration");
		}*/
		$mysqli = new mysqli('127.0.0.1', 'root', 'strtoupper', 'gramme');
		$title=$_POST["title"];
		$type=$_POST["type"];
		$year=$_POST["year"];
		$text=$_POST["text"];
		$img1=$_POST["img1"];
		$img2=isset($_POST["img2"])?$_POST["img2"]:NULL;
		$imagelist=$_POST["imagelist"];
		$result = $mysqli->query("SHOW TABLE STATUS LIKE 'images'");
		$data = mysqli_fetch_assoc($result);
		$autoincimages = $data['Auto_increment'];
		$result = $mysqli->query("SHOW TABLE STATUS LIKE 'posts'");
		$data = mysqli_fetch_assoc($result);
		$autoincposts = $data['Auto_increment'];
		echo ($mysqli->error);
		$count = count($_FILES);
		$j=0;
		foreach ($_FILES as $file) {
			$filenames[]=$file["name"];
			$filetmpnames[]=$file["tmp_name"];
		}
		for($i=$autoincimages;$i<$autoincimages+$count;$i++) {
		    $extension  = pathinfo($filenames[$j], PATHINFO_EXTENSION);
		    move_uploaded_file($filetmpnames[$j], getcwd()."/img/".$i.'.'.$extension);
		    $j++;
		}
		
		for($i=0;$i<$count;$i++) {
			$extension  = pathinfo($filenames[$i], PATHINFO_EXTENSION);
			echo("INSERT INTO `images`(`url`, `caption`) VALUES ('".($autoincimages+$i).'.'.$extension."', '')");
		    $mysqli->query("INSERT INTO `images`(`url`, `caption`) VALUES ('".($autoincimages+$i).'.'.$extension."', '')");
    		echo ($mysqli->error);
		}

		$i=0;
		for($j=$autoincimages;$j<$autoincimages+$count;$j++){
    		$mysqli->query("INSERT INTO `postimages`(`idimage`, `idpost`, `atindex`) VALUES (".$j.' , '.$autoincposts.' , '.$i.")");
    		echo ($mysqli->error);
			$i++;
		}
		$mysqli->query("INSERT INTO `posts`( `title`, `type`, `year`, `text`, `img1`, `img2`) VALUES ('".$title."','".$type."','".$year."','".$text."',".($img1?$img1:"NULL").','.($img2?$img2:"NULL").")");
		echo ($mysqli->error);
	}

	function savePage(){
		if(!isset($_POST["postlist"])){
			die("No post list");
		}
		$mysqli = new mysqli('127.0.0.1', 'root', 'strtoupper', 'gramme');
		$i=0;
		$postlist=$_POST["postlist"];
		$mysqli->query("TRUNCATE TABLE homepage");
		foreach ($postlist as $post){
    		$mysqli->query("INSERT INTO `homepage` (`idpost`, `atindex`) VALUES (".$post["id"] .','.$i.")");
			$i++;
		}
	}

	function saveImage(){
		if(!isset($_POST["postlist"])){
			die("No post list");
		}
	}
?>