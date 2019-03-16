<!doctype html>
<html>
<head>
<title>Email Confirmation</title>
</head>

<body>
<?php

require "database.php";

$username = $_GET['username'];
$code = $_GET['code'];


$query = mysql_query("SELECT * FROM `customers` WHERE `email` = $username";

while($row = mysql_fetch_assoc($query)){
	$db_code = $row['confirmed_code'];
}
if($code == $db_code){
	mysql_query("UPDATE `customers` SET confirmed = 1");
	mysql_query("UPDATE `customers` SET confirmed_code = 0");
}
else{
		echo "Username and code do not match";
}


?>
</body>
</html>