<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other page after logout
header("Location: index.php"); // Replace "login.php" with the URL of your login page
exit();
?>
