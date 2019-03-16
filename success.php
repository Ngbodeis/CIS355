<?php
session_start();
	if(!$_SESSION){
		header("Location: login.php");
	}
	else{
		header("Location: customers.php");
	}
?>
