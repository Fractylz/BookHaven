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
    <h1>Book Haven Admin</h1>

    <li class="search-container">
      <form action="#">
        <input type="text" placeholder="Find books by title, author, ISBN" />
        <input type="submit" value="Search" />
      </form>
    </li>

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

  <section id="top-books">
    <h2>Product List</h2>

    <?php
    include("dbConn.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST['updateQuantity'])) {
          $bookId = mysqli_real_escape_string($conn, $_POST['bookId']);
          $newQuantity = mysqli_real_escape_string($conn, $_POST['newQuantity']);
  
          $updateSql = "UPDATE book SET book_quantity = '$newQuantity' WHERE book_id = '$bookId'";
          if ($conn->query($updateSql) === TRUE) {
              echo "Quantity updated successfully!";
          } else {
              echo "Error updating quantity: " . $conn->error;
          }
      } elseif (isset($_POST['removeBook'])) {
          $bookId = mysqli_real_escape_string($conn, $_POST['book_id']);
  
          echo "Attempting to remove book with ID: $bookId<br>";
  
          // First delete related records in order_items table
          $deleteOrderItemsSql = "DELETE FROM order_items WHERE book_id = '$bookId'";
          if ($conn->query($deleteOrderItemsSql) === TRUE) {
              // Now delete the book
              $deleteSql = "DELETE FROM book WHERE book_id = '$bookId'";
              if ($conn->query($deleteSql) === TRUE) {
                  echo "Book removed successfully!";
              } else {
                  echo "Error removing book: " . $conn->error;
              }
          } else {
              echo "Error removing related order items: " . $conn->error;
          }
      }
  }

    $sql = "SELECT * FROM book ORDER BY book_price ASC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '<div class="book">';
        echo '<img src="' . $row['book_img'] . '" class="book-image" alt="' . $row['book_title'] . '" />';
        echo '<h3>' . $row['book_title'] . '</h3>';
        echo '<p>ISBN: ' . $row['book_isbn'] . '</p>';
        echo '<p>Author: ' . $row['book_author'] . '</p>';
        echo '<p>Genre: ' . $row['book_genre'] . '</p>';
        echo '<p>Price: ' . $row['book_price'] . '</p>';
        echo '<p>Publication Year: ' . $row['book_year'] . '</p>';
        echo '<p>Quantity: ' . $row['book_quantity'] . '</p>';
        echo '<form method="post" action="">';
        echo '<input type="hidden" name="book_id" value="' . $row['book_id'] . '" />';
        echo '<label for="newQuantity">New Quantity:</label>';
        echo '<input type="number" id="newQuantity" name="newQuantity" min="0" required />';
        echo '<button type="submit" name="updateQuantity">Update Quantity</button>';
        echo '<button type="submit" name="removeBook">Remove Book</button>';
        echo '</form>';
        echo '</div>';
      }
    } else {
      echo "0 results";
    }
    $conn->close();
    ?>
  </section>
</body>
</html>
