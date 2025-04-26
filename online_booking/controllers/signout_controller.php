<?php 
session_start();
unset($_SESSION["userID"]);
session_commit();
header("Location: ../index.php");
exit();
?>