<html>
<head>
	<meta charset="utf-8">
	<title>Gramme - Login </title>
  	<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  	<link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">
  	<script src="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/js/bootstrap.js"></script>
  	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
<header>
 <nav class="navbar navbar-light bg-faded">
  <ul class="nav navbar-nav">
    <li class="nav-item active">
      <a class="nav-link" href="admin">Gramme - Admin <span class="sr-only">(current)</span></a>
    </li>
  </ul>
</nav>
</header>
<?php
session_start();
if (!isset($_POST['submit'])){
?>	
<div style="width:60%;margin:auto">
<!-- The HTML login form -->
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="form-login">
		<label>Username: </label><input type="text" name="username" /><br/>
		<label>Password: </label><input type="password" name="password" /><br/>
 		<div class="form-group">
		<input type="submit" name="submit" class="btn btn-primary" style="margin-left:50px;margin-top:20px" value="Login" />
		</div>
	</form>
</div>
<?php
} else {
	require_once("dbconnect.php");
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	# check connection
	if ($mysqli->connect_errno) {
		echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
		exit();
	}
	$username = $_POST['username'];
	$password = $_POST['password'];
 
	$sql = "SELECT * from users WHERE username LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1";
	$result = $mysqli->query($sql);
	if (!$result->num_rows == 1) {
		echo "<p>Invalid username/password combination</p>";
	} else {
		echo "<p>Logged in successfully</p>";
		$_SESSION['id'] = 'admin';
		session_start();
		header('Location: /admin.php');
	}
}
?>		
</body>
</html>