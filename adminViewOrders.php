<?php


include("dbConn.php");

// Fetch all orders
$order_sql = "SELECT 
                o.order_id,
                o.payment_mode,
                o.amount_paid,
                o.order_date,
                u.user_username,
                u.user_email,
                u.user_fullname,
                u.user_address,
                u.user_phoneNo
            FROM 
                orders o
            JOIN 
                users u ON o.user_id = u.user_id
            ORDER BY 
                o.order_date DESC";

$order_result = $conn->query($order_sql);

if (!$order_result) {
    die("Error fetching orders: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin View Orders - BookHaven</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="media/BH_Logo.png">
</head>
<body>
<header>
    <div id="top-header">
        <div id="logo"><img src="media/BH_Logo.png" alt="Book Haven Logo"></div>
    </div>
    <h1>Book Haven Admin</h1>

    <nav>
        <ul>
        <li><a href="adminPage.php">Dashboard</a></li>
         <li><a href="adminManageBooks.php">Manage Books</a></li>
         <li><a href="adminViewBooks.php">View Books</a></li>
         <li><a href="adminViewOrders.php">View Orders</a></li>
         <li><a href="adminUser.php">Manage Users</a></li>
         <li><a href="index.php">Logout</a></li>
        </ul>
    </nav>
</header>

<section id="admin-orders">
    <h2>All Orders</h2>

    <?php
    if ($order_result->num_rows > 0) {
        while ($order = $order_result->fetch_assoc()) {
            echo '<div class="order">';
            echo '<h3>Order ID: ' . htmlspecialchars($order['order_id']) . '</h3>';
            echo '<p>Username: ' . htmlspecialchars($order['user_username']) . '</p>';
            echo '<p>Email: ' . htmlspecialchars($order['user_email']) . '</p>';
            echo '<p>Full Name: ' . htmlspecialchars($order['user_fullname']) . '</p>';
            echo '<p>Address: ' . htmlspecialchars($order['user_address']) . '</p>';
            echo '<p>Phone No: ' . htmlspecialchars($order['user_phoneNo']) . '</p>';
            echo '<p>Payment Mode: ' . htmlspecialchars($order['payment_mode']) . '</p>';
            echo '<p>Amount Paid: RM' . htmlspecialchars($order['amount_paid']) . '</p>';
            echo '<p>Order Date: ' . htmlspecialchars($order['order_date']) . '</p>';

            // Fetch items for each order
            $items_sql = "SELECT 
                            oi.quantity,
                            b.book_title,
                            b.book_price,
                            b.book_img
                        FROM 
                            order_items oi
                        JOIN 
                            book b ON oi.book_id = b.book_id
                        WHERE 
                            oi.order_id = ?";
            $items_stmt = $conn->prepare($items_sql);

            if (!$items_stmt) {
                die("Error preparing statement for order items: " . $conn->error);
            }

            $items_stmt->bind_param("i", $order['order_id']);
            $items_stmt->execute();
            $items_result = $items_stmt->get_result();

            if (!$items_result) {
                die("Error executing statement for order items: " . $items_stmt->error);
            }

            if ($items_result->num_rows > 0) {
                echo '<h4>Order Items</h4>';
                while ($item = $items_result->fetch_assoc()) {
                    echo '<div class="order-item">';
                    echo '<img src="' . htmlspecialchars($item['book_img']) . '" class="book-image" alt="' . htmlspecialchars($item['book_title']) . '">';
                    echo '<p>Title: ' . htmlspecialchars($item['book_title']) . '</p>';
                    echo '<p>Quantity: ' . htmlspecialchars($item['quantity']) . '</p>';
                    echo '<p>Price: RM' . htmlspecialchars($item['book_price']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p>No items in this order.</p>';
            }

            $items_stmt->close();
            echo '</div>';
        }
    } else {
        echo '<p>No orders found.</p>';
    }

    $conn->close();
    ?>
</section>

</body>
</html>
