<?php 
	session_start();
	unset($_SESSION["user_ID"]);
	session_commit();
	header("Location: ../index.php");	
?>