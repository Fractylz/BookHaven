<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include("dbConn.php");

$user_id = $_SESSION['user_id'];

// Fetch cart details
$cart_sql = "SELECT 
                sc.order_quantity,
                b.book_price,
                sc.book_id
            FROM 
                shoppingcart sc
            JOIN 
                book b ON sc.book_id = b.book_id
            WHERE 
                sc.user_id = ?";
$cart_stmt = $conn->prepare($cart_sql);
$cart_stmt->bind_param("i", $user_id);
$cart_stmt->execute();
$cart_result = $cart_stmt->get_result();

$total_amount = 0;
$order_items = []; // Array to store order items

while ($row = $cart_result->fetch_assoc()) {
    $total_amount += $row['order_quantity'] * $row['book_price'];
    $order_items[] = $row; // Store each row in the array
}

$cart_stmt->close();

// Insert order details into orders table
$order_sql = "INSERT INTO orders (payment_mode, amount_paid, user_id) VALUES ('credit_card', ?, ?)";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("di", $total_amount, $user_id);
$order_stmt->execute();
$order_id = $order_stmt->insert_id;
$order_stmt->close();

// Insert order items into order_items table
foreach ($order_items as $item) {
    $order_item_sql = "INSERT INTO order_items (order_id, book_id, quantity, subtotal) VALUES (?, ?, ?, ?)";
    $order_item_stmt = $conn->prepare($order_item_sql);
    $subtotal = $item['order_quantity'] * $item['book_price'];
    $order_item_stmt->bind_param("iiid", $order_id, $item['book_id'], $item['order_quantity'], $subtotal);
    $order_item_stmt->execute();
    $order_item_stmt->close();
}

// Clear the shopping cart
$clear_cart_sql = "DELETE FROM shoppingcart WHERE user_id = ?";
$clear_cart_stmt = $conn->prepare($clear_cart_sql);
$clear_cart_stmt->bind_param("i", $user_id);
$clear_cart_stmt->execute();
$clear_cart_stmt->close();

$conn->close();

header("Location: receipt.php?order_id=" . $order_id);
exit();
?>

