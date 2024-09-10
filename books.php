<?php
session_start();

// Check if user is logged in
if (isset($_SESSION['username'])) {
    // User is logged in, display username
    $username = $_SESSION['username'];
    $navigation = '<li><a href="profile.php">' . $username . '</a></li>';
    $navigation .= '<li><a href="logout.php">Logout</a></li>';
} else {
    // User is not logged in, display login/signup links
    $navigation = '<li><a href="login.php">Login/Sign Up</a></li>';
}

if (isset($_SESSION['username'])) {
    // User is logged in, enable the button
    $button_disabled = ''; // Empty string to enable the button
} else {
    // User is not logged in, disable the button
    $button_disabled = 'disabled'; // Set to 'disabled' to disable the button
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
        <form action="searchHandler.php" method="get">
            <input type="text" name="query" placeholder="Find books by title, author, ISBN">
            <input type="submit" value="Search">
        </form>
    </div>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="books.php">Catalog</a></li>
            <li><a href="cart.php">Cart</a></li>
            <?php echo $navigation; ?>
            <li><a href="aboutUs.php">About Us</a></li>
        </ul>
    </nav>
</header>

<section id="top-books">
    <h2>Catalog</h2>

    <?php
    include("dbConn.php");

    $sql = "SELECT * FROM book ORDER BY book_id ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo '<div class="book">';
            echo '<img src="' . $row['book_img'] . '" class="book-image" alt="' . $row['book_title'] . '">';
            echo '<h3>Title: ' . $row['book_title'] . '</h3>';
            echo '<p>ISBN: ' . $row['book_isbn'] . '</p>';
            echo '<p>Author: ' . $row['book_author'] . '</p>';
            echo '<p>Genre: ' . $row['book_genre'] . '</p>';
            echo '<p>Price: ' . $row['book_price'] . '</p>';
            echo '<p>Publication Year: ' . $row['book_year'] . '</p>';
            echo '<p>Quantity: ' . $row['book_quantity'] . '</p>';
            echo '<p>Book ID: ' . $row['book_id'] . '</p>';
            echo '<form method="post" action="addToCart.php">';
            echo '<input type="hidden" name="bookId" value="' . $row['book_id'] . '">';
            echo '<button type="submit" name="addToCart" ' . $button_disabled . '>Add To Cart</button>';
            echo '</form>';
            echo '</div>';
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>

</section>

<footer>
    <h3>BookHaven.com</h3>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="books.php">Catalog</a></li>
        <li><a href="cart.php">Cart</a></li>
        <?php echo $navigation; ?>
        <li><a href="aboutUs.html">About Us</a></li>
    </ul>
    <p>Copyright BookHaven Sdn Bhd &copy;2024 All Rights Reserved</p>
</footer>

</body>
</html>
