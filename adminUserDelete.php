<?php
include "dbConn.php";

if (isset($_GET['id'])) {
    $userID = intval($_GET['id']);

    // Check if the user exists
    $checkStmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $checkStmt->bind_param("i", $userID);
    $checkStmt->execute();
    $result = $checkStmt->get_result();

    if ($result->num_rows == 0) {
        echo "<script>alert('User not found.'); window.location.href = 'adminUser.php';</script>";
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
        // Start a transaction
        $conn->begin_transaction();

        try {
            // Delete related records in order_items table
            $deleteOrderItemsStmt = $conn->prepare("
                DELETE order_items FROM order_items
                INNER JOIN orders ON order_items.order_id = orders.order_id
                WHERE orders.user_id = ?
            ");
            $deleteOrderItemsStmt->bind_param("i", $userID);
            $deleteOrderItemsStmt->execute();
            $deleteOrderItemsStmt->close();

            // Delete related records in orders table
            $deleteOrdersStmt = $conn->prepare("DELETE FROM orders WHERE user_id = ?");
            $deleteOrdersStmt->bind_param("i", $userID);
            $deleteOrdersStmt->execute();
            $deleteOrdersStmt->close();

            // Delete the user
            $deleteUserStmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
            $deleteUserStmt->bind_param("i", $userID);
            $deleteUserStmt->execute();
            $deleteUserStmt->close();

            // Commit the transaction
            $conn->commit();

            echo "<script>alert('User deleted successfully.'); window.location.href = 'adminUser.php';</script>";
            exit();
        } catch (Exception $e) {
            // Rollback the transaction on error
            $conn->rollback();
            echo "Error deleting user: " . $conn->error;
        }
    }
    $checkStmt->close();
} else {
    echo "<script>alert('Invalid user ID.'); window.location.href = 'adminUser.php';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delete User</title>
    <link rel="stylesheet" href="adminUserDelete.css">
</head>
<body>
    <div class="container">
        <h2>Delete User</h2>
        <div class="message">
            Are you sure you want to delete this user?
        </div>
        <form method="post">
            <input type="submit" name="confirm" value="Confirm" onclick="return confirm('Are you sure? This action cannot be undone.');">
            <a href="adminUser.php">Cancel</a>
        </form>
    </div>
</body>
</html>
