<?php
session_start();

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

include("dbConn.php");

$order_id = $_GET['order_id'];

// Fetch order details
$order_sql = "SELECT 
                o.payment_mode,
                o.amount_paid,
                u.user_username,
                u.user_email,
                u.user_fullname,
                u.user_address,
                u.user_phoneNo
            FROM 
                orders o
            JOIN 
                users u ON o.user_id = u.user_id
            WHERE 
                o.order_id = ?";
$order_stmt = $conn->prepare($order_sql);
$order_stmt->bind_param("i", $order_id);
$order_stmt->execute();
$order_result = $order_stmt->get_result();
$order_details = $order_result->fetch_assoc();
$order_stmt->close();

// Fetch order items
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
$items_stmt->bind_param("i", $order_id);
$items_stmt->execute();
$items_result = $items_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receipt - BookHaven</title>
    <link rel="stylesheet" href="index.css">
    <link rel="icon" href="media/BH_Logo.png">
</head>
<body>
<header>
    <div id="top-header">
        <div id="logo"><img src="media/BH_Logo.png" alt="Book Haven Logo"></div>
    </div>
    <h1>Book Haven</h1>

    <div class="search-container">
        <form action="#">
            <input type="text" placeholder="Find books by title, author, ISBN">
            <input type="submit" value="Search">
        </form>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="books.php">Books</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="checkout.php">Checkout</a></li>
            <li><a href="logout.php">Logout</a></li>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
    </nav>
</header>

<section id="receipt">
    <h2>Receipt</h2>

    <div class="user-details">
        <h3>User Details</h3>
        <p>Username: <?php echo htmlspecialchars($order_details['user_username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($order_details['user_email']); ?></p>
        <p>Full Name: <?php echo htmlspecialchars($order_details['user_fullname']); ?></p>
        <p>Address: <?php echo htmlspecialchars($order_details['user_address']); ?></p>
        <p>Phone No: <?php echo htmlspecialchars($order_details['user_phoneNo']); ?></p>
    </div>

    <div class="order-details">
        <h3>Order Details</h3>
        <p>Payment Mode: <?php echo htmlspecialchars($order_details['payment_mode']); ?></p>
        <p>Amount Paid: RM<?php echo htmlspecialchars($order_details['amount_paid']); ?></p>
    </div>

    <div class="cart-details">
        <h3>Order Items</h3>
        <?php
        if ($items_result->num_rows > 0) {
            while ($row = $items_result->fetch_assoc()) {
                echo '<div class="cart-item">';
                echo '<img src="' . htmlspecialchars($row['book_img']) . '" class="book-image" alt="' . htmlspecialchars($row['book_title']) . '" />';
                echo '<h3>' . htmlspecialchars($row['book_title']) . '</h3>';
                echo '<p>Quantity: ' . htmlspecialchars($row['quantity']) . '</p>';
                echo '<p>Price: RM' . htmlspecialchars($row['book_price']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No items in order.</p>';
        }
        ?>
    </div>

    <?php
    $items_stmt->close();
    $conn->close();
    ?>
</section>

<footer>
      <h3>BookHaven.com</h3>
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="books.php">Catalog</a></li>
        <li><a href="cart.php">Cart</a></li>
        <li><a href="login.php">Login/Sign Up</a></li>
        <li><a href="aboutUs.html">About Us</a></li>
      </ul>
      <p>Copyright BookHaven Sdn Bhd &copy;2024 All Rights Reserved</p>
      </footer>
      
</body>
</html>
