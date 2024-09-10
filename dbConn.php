<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "bookhaven"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname , 4000 ); //!Change to your root

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}

?> 