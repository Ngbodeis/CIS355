<?php
	session_start();
	require "database.php";
	$errorMessage = $_GET['errorMessage'];
	if($_POST){
		$success = false;
		
		//variables to save username and password
		$username = $_POST['username'];
		$password = $_POST['password'];
		$passwordhash = md5($password);
		
		//connect to database
		$pdo = Database::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "SELECT * FROM customers WHERE email = '$username' AND password_hash = '$passwordhash'";
		$q = $pdo->prepare($sql);
		$q->execute(array());
		$data = $q->fetch(PDO::FETCH_ASSOC);
		
		//if success, then go to success page which sets session then directs to login
		if($data){
			$_SESSION["username"] = $username;
			header("Location: success.php");
		}
		else{
			header("Location: login.php?errorMessage=Invalid Login Attempt");
			exit();
		}
	}	
	
?>
<html>
        <meta charset='UTF-8'>
        <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
<h3>Log In(The login for Prog03 works)</h3>
<form class="form-horizontal" action="login.php" method="post">
	
	
	<p><?php echo $errorMessage; ?></p>
	<div class="control-group">
		<div class="controls">
			<label class="control-label">Username (Email):</label>
			<input name ="username" type="text" placeholder="me@email.com">
			<label class="control-label">Password:</label>
			<input name ="password" type="password" required>
			<button type="submit" class="btn btn-success">Log In</button>
			<a href="signup.php" class="btn btn-info">Sign Up</a>
		</div>
	</div>
</form>
</html>