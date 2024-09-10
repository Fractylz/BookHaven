<?php
session_start(); // Start session

include("dbConn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform a database query to check user credentials
    $query = "SELECT * FROM users WHERE user_username ='$username' AND user_password ='$password'";

    // Run the query and fetch data from your database here...
    $result = mysqli_query($conn, $query); // Assuming $connection is your established database connection

    // Validate and sanitize input (optional, as you're already doing this)
    // $username = trim($username);
    // $username = stripslashes($username);
    // $username = htmlspecialchars($username);
    // $password = trim($password);
    // $password = stripslashes($password);
    // $password = htmlspecialchars($password);

    // Fetch user data as an associative array
    $user = mysqli_fetch_assoc($result);

    // Check if the query returned a valid user and verify password
    if ($user) {
        // Set session variables
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['user_username'];
        $_SESSION['access_level'] = $user['user_al'];

        // Redirect based on access level
        if ($user['user_al'] === 'Admin') {
            echo "<script>alert('You have successfully loggen in. Welcome Admin.'); window.location.href='adminPage.php';</script>";
            exit();
        } elseif ($user['user_al'] === 'Customer') {
            echo "<script>alert('You are now logged in.'); window.location.href='books.php';</script>";
            exit();
        }
    } else {
        // Invalid credentials - handle this case (display error message or redirect back to login page)
        header("Location: login.php?error=1"); // Redirect back to login page with error flag
        exit();
    }
}
?>


