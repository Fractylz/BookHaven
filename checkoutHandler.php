<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include("dbConn.php");

$user_id = $_SESSION['user_id'];

// Fetch user details
$user_sql = "SELECT user_username, user_email, user_address, user_phoneNo, user_fullname FROM users WHERE user_id = ?";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_details = $user_result->fetch_assoc();
$user_stmt->close();

// Fetch cart details
$cart_sql = "SELECT 
                sc.order_quantity,
                b.book_title,
                b.book_price,
                b.book_img
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - BookHaven</title>
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

<section id="checkout">
    <h2>Receipt</h2>

    <div class="user-details">
        <h3>User Details</h3>
        <p>Username: <?php echo htmlspecialchars($user_details['user_username']); ?></p>
        <p>Email: <?php echo htmlspecialchars($user_details['user_email']); ?></p>
        <p>Full Name: <?php echo htmlspecialchars($user_details['user_fullname']); ?></p>
        <p>Address: <?php echo htmlspecialchars($user_details['user_address']); ?></p>
        <p>Phone No: <?php echo htmlspecialchars($user_details['user_phoneNo']); ?></p>
    </div>

    <div class="cart-details">
        <h3>Cart Details</h3>
        <?php
        if ($cart_result->num_rows > 0) {
            while ($row = $cart_result->fetch_assoc()) {
                echo '<div class="cart-item">';
                echo '<img src="' . htmlspecialchars($row['book_img']) . '" class="book-image" alt="' . htmlspecialchars($row['book_title']) . '" />';
                echo '<h3>' . htmlspecialchars($row['book_title']) . '</h3>';
                echo '<p>Quantity: ' . htmlspecialchars($row['order_quantity']) . '</p>';
                echo '<p>Price: RM' . htmlspecialchars($row['book_price']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No items in cart.</p>';
        }
        ?>
    </div>

    <form action="completeOrder.php" method="post">
        <button type="submit">Complete Order</button>
    </form>

    <?php
    $cart_stmt->close();
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
