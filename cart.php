<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $navigation = '<li><a href="profile.php">' . $username . '</a></li>';
    $navigation .= '<li><a href="logout.php">Logout</a></li>';
} else {
    $navigation = '<li><a href="login.php">Login/Sign Up</a></li>';
}

if (isset($_SESSION['username'])) {
    $button_disabled = '';
} else {
    $button_disabled = 'disabled';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BookHaven</title>
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
            <li><a href="checkoutHandler.php">Checkout</a></li>
            <?php echo $navigation; ?>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
    </nav>
</header>

<section id="top-books">
    <h2>Cart</h2>

    <?php
    include("dbConn.php");

    if (!isset($_SESSION['username'])) {
        header("Location: login.php");
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if (isset($_POST['removeFromCart'])) {
        $book_id = $_POST['bookId'];
        
        // Remove the book from the cart
        $query = "DELETE FROM shoppingcart WHERE user_id = ? AND book_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $book_id);
        
        if (!$stmt->execute()) {
            die("Error removing item from cart: " . $stmt->error);
        }
        
        $stmt->close();
    }

    // Fetch the updated cart items
    $sql = "SELECT 
                sc.order_quantity,
                b.book_title,
                b.book_price,
                b.book_img,
                b.book_id
            FROM 
                shoppingcart sc
            JOIN 
                book b ON sc.book_id = b.book_id
            WHERE 
                sc.user_id = ?";
            
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        die("Error executing statement: " . $stmt->error);
    }

    $result = $stmt->get_result();
    ?>

    <section id="top-books">
        

        <?php
        // Display the cart items here (same code as above)
        if ($result->num_rows > 0) {
            echo "Found " . $result->num_rows . " items in cart<br>"; // Debugging statement
            echo '<h2>Your Cart</h2>';
            while ($row = $result->fetch_assoc()) {
                echo '<div class="cart-item">';
                echo '<img src="' . $row['book_img'] . '" class="book-image" alt="' . $row['book_title'] . '" />';
                echo '<h3>' . $row['book_title'] . '</h3>';
                echo '<p>Quantity: ' . $row['order_quantity'] . '</p>';
                echo '<p>Price: RM' . $row['book_price'] . '</p>';
                echo '<form method="post" action="cart.php">';
                echo '<input type="hidden" name="bookId" value="' . $row['book_id'] . '">';
                echo '<button type="submit" name="removeFromCart">Remove</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo '<p>No items in cart.</p>';
        }

        $stmt->close();
        $conn->close();
        ?>

    </section>
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

