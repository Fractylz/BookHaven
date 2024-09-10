<?php
include "dbConn.php";

if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    // Fetch user data based on the provided ID
    $sql = "SELECT * FROM users WHERE user_id = $userID";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "User not found.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating user data
    $userID = $_POST['userID'];
    $userName = $_POST['userName'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $password = $_POST['password'];
    $phoneNumber = $_POST['phoneNumber'];
    $accessLevel = $_POST['accessLevel'];

    $sql = "UPDATE users SET user_username = '$userName', user_fullname = '$name', user_email = '$email', user_address = '$address', user_password = '$password', user_phoneNo = '$phoneNumber', user_al = '$accessLevel' WHERE user_id = $userID";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('User updated successfully.'); window.location.href = 'adminUser.php';</script>";
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="adminUserEdit.css">
</head>
<body>
    <h2>Edit User</h2>
    <form method="post">
        <!-- Display user data in input fields for editing -->
        <!-- Populate input fields with existing user data -->
        <input type="text" name="userName" value="<?php echo $row['user_username']; ?>">
        <input type="text" name="name" value="<?php echo $row['user_fullname']; ?>">
        <input type="text" name="email" value="<?php echo $row['user_email']; ?>">
        <input type="text" name="address" value="<?php echo $row['user_address']; ?>">
        <input type="text" name="password" value="<?php echo $row['user_password']; ?>">
        <input type="text" name="phoneNumber" value="<?php echo $row['user_phoneNo']; ?>">
        <input type="text" name="accessLevel" value="<?php echo $row['user_al']; ?>">
        <input type="hidden" name="userID" value="<?php echo $row['user_id']; ?>">
        <input type="submit" value="Update">
    </form>
</body>
</html>
