<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>BookHaven</title>
  <link rel="stylesheet" href="adminManageBooks.css" />
  <link rel="icon" href="media/BH_Logo.png" />
</head>
<body>
  <header>
    <div id="top-header">
      <div id="logo"><img src="media/BH_Logo.png" /></div>
    </div>
    <h1>Book Haven Admin</h1>

    <form class="search-container" action="#">
      <input type="text" placeholder="Find books by title, author, ISBN" />
      <input type="submit" value="Search" />
    </form>

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

  <div class="add-books-container">
    <h2>Add Book</h2>
    <form action="adminManageBooksHandler.php" method="post" enctype="multipart/form-data">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title" required />

      <label for="isbn">ISBN:</label>
      <input type="text" id="isbn" name="isbn" required />

      <label for="author">Author:</label>
      <input type="text" id="author" name="author" required />

      <label for="genre">Genre:</label>
      <input type="text" id="genre" name="genre" required />

      <label for="price">Price:</label>
      <input type="text" id="price" name="price" required />

      <label for="publicationYear">Publication Year:</label>
      <input type="text" id="publicationYear" name="publicationYear" required />

      <label for="quantity">Quantity:</label>
      <input type="text" id="quantity" name="quantity" required />

      <label for="bookImage">Book Image:</label>
      <input type="file" id="bookImage" name="bookImage" required accept="image/*" />

      <button type="submit">Add Book</button>
    </form>
  </div>
</body>
</html>