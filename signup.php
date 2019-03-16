<?php
	session_start();
	require "database.php";
	$errorMessage = $_GET['errorMessage'];
	if($_POST) {

			$success = false;
			
			//variables to save username and password
			$username = $_POST['username'];
			$email = $_POST['username'];
			$password = $_POST['password'];
			$confirmcode = rand(0,254);
			
			//connect to database and then insert into table the new user
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customers (email,password_hash,confirmed_code) values(?, ?, ?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($username,MD5($password),$confirmcode));
			Database::disconnect();
            
			
			//confirmation information for email
			$subject = "Confirmation Email";
			$message =
			"
			Please Confirm Your Email:
			Click the link below to verify account:
			http://csis.svsu.edu/~ngbodeis/crud_oo_complete/emailconfirmation.php?=$username&code=$confirmcode
			";
			$headers = "To: <$email>\r\n";
			$headers .= "From: <ngbodeis@svsu.edu>\r\n";
			
			
			
			//send to email, subject line, message, and additional headers explained above
			mail($email, $subject, $message, $headers);
			
					
			header("Location: login.php"); // go back to login screen
    }
	
?>
<html>
	<meta charset='UTF-8'>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css' rel='stylesheet'>
    <script src='https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js'></script>
<h3>Create an Account</h3>
<form class="form-horizontal" action="signup.php" method="post">
	
	
	<p><?php echo $errorMessage; ?></p>
	<div class="control-group">
		<label class="control-label">Username (Email)</label>
		<div class="controls">
			<input name ="username" type="text" placeholder="me@email.com">
			<input name ="password" type="password" required>
			<button type="submit" class="btn btn-success">Create Account</button>
			<a href="login.php" class="btn btn-danger">Back</a>
		</div>
	</div>
</form>
</html>