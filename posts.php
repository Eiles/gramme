<?php
	session_start();

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
		*/
		if(!isset($_SESSION["id"])){
			die('FORBIDDEN');
		}
		$mysqli = new mysqli('127.0.0.1', 'root', 'strtoupper', 'gramme');
		$title=$_POST["title"];
		$type=$_POST["type"];
		$year=$_POST["year"];
		$text=$_POST["text"];
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
		if($count==0){
			die("NO FILE");
		}
		$j=0;
		foreach ($_FILES as $file) {
			$filenames[]=$file["name"];
			$filetmpnames[]=$file["tmp_name"];
		}
		for($i=$autoincimages;$i<$autoincimages+$count;$i++) {
		    $extension  = pathinfo($filenames[$j], PATHINFO_EXTENSION);
		    $result=move_uploaded_file($filetmpnames[$j], getcwd()."/img/".$i.'.'.$extension);
		    $j++;
		}
		
		for($i=0;$i<$count;$i++) {
			$extension  = pathinfo($filenames[$i], PATHINFO_EXTENSION);
		    $mysqli->query("INSERT INTO `images`(`url`, `caption`) VALUES ('".($autoincimages+$i).'.'.$extension."', '')");
    		echo ($mysqli->error);
		}

		$i=0;
		for($j=$autoincimages;$j<$autoincimages+$count;$j++){
    		$mysqli->query("INSERT INTO `postimages`(`idimage`, `idpost`, `atindex`) VALUES (".$j.' , '.$autoincposts.' , '.$i.")");
    		echo ($mysqli->error);
			$i++;
		}
		$mysqli->query("INSERT INTO `posts`( `title`, `type`, `year`, `text`) VALUES ('".$title."','".$type."','".$year."','".$text."')");
		echo ($mysqli->error);
	}

	function savePage(){
		if(!isset($_SESSION["id"])){
			die('FORBIDDEN');
		}
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

?>