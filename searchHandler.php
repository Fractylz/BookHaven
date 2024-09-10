<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>BookHaven</title>
    <link rel="stylesheet" href="index.css" />
    <link rel="icon" href="media/BH_Logo.png" />
  </head>

  <body>
    <header>
      <div id="top-header">
        <div id="logo"><img src="media/BH_Logo.png" /></div>
      </div>
      <h1>Book Haven</h1>

      <li class="search-container">
        <form action="#">
          <input type="text" placeholder="Find books by title, author, ISBN" />
          <input type="submit" value="Search" />
        </form>
      </li>

      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="books.php">Books</a></li>
          <li><a href="cart.php">Cart</a></li>
          <li><a href="login.php">Login/Sign Up</a></li>
          <li><a href="aboutUs.html">About Us</a></li>
        </ul>
      </nav>
    </header>
    
    <section id="top-books">
      <h2>Cart</h2>
        <?php
            // Include your database connection file
            include("dbConn.php");

            if (isset($_GET['query'])) {
                // Get the search query from the form
                $searchQuery = mysqli_real_escape_string($conn, $_GET['query']);

                // Perform a search query on your database
                $sql = "SELECT * FROM book WHERE title LIKE '%$searchQuery%' OR author LIKE '%$searchQuery%' OR isbn LIKE '%$searchQuery%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Display search results
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="book">';
                        echo '<img src="' . $row['BookImage'] . '" class="book-image" alt="' . $row['Title'] . '" />'; 
                        echo '<h3>Title: ' . $row['Title'] . '</h3>';
                        echo '<p>ISBN: ' . $row['ISBN'] . '</p>';
                        echo '<p>Author: ' . $row['Author'] . '</p>';
                        echo '<p>Genre: ' . $row['Genre'] . '</p>';
                        echo '<p>Price: ' . $row['Price'] . '</p>';
                        echo '<p>Publication Year: ' . $row['PublicationYear'] . '</p>';
                        echo '<p>Quantity: ' . $row['Quantity'] . '</p>';
                        echo '<p>Book ID: ' . $row['bookID'] . '</p>';
                        // Add other details as needed
                        echo '</div>';
                    }
                } else {
                    echo 'No results found.';
                }

                // Close the database connection
                $conn->close();
            }
?>
</section>


