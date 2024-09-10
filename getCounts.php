<?php
include("dbConn.php");

$response = [];

// Fetch user count
$user_sql = "SELECT COUNT(*) AS user_count FROM users";
$user_result = $conn->query($user_sql);
$user_data = $user_result->fetch_assoc();
$response['users'] = $user_data['user_count'];

// Fetch order count
$order_sql = "SELECT COUNT(*) AS order_count FROM orders";
$order_result = $conn->query($order_sql);
$order_data = $order_result->fetch_assoc();
$response['orders'] = $order_data['order_count'];

// Fetch book count
$book_sql = "SELECT COUNT(*) AS book_count FROM book";
$book_result = $conn->query($book_sql);
$book_data = $book_result->fetch_assoc();
$response['books'] = $book_data['book_count'];

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
