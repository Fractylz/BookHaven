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
    <meta charset="UTF-8" />
    <title>BookHaven</title>
    <link rel="stylesheet" href="aboutUs.css" />
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
          <?php echo $navigation; ?>
          <li><a href="aboutUs.php">About Us</a></li>
        </ul>
      </nav>
    </header>

    <main>
      <h1>About Us</h1>

      <!-- HTML structure for the About Us page -->
<section class="about-us">
    <div class="card">
      <img src="media/ariff.jpg" alt="Developer 1" style ="width: 150px; height: 150px;" />
      <h3>Muhammad Ariff bin Norhisham (2022172865)</h3>
      <p>Overworked and Underpaid Senior developer and project leader, responsible for coding the front-end and back-end and overseeing the production of the web application</p>
    </div>
    <div class="card">
      <img src="media/hanafi.jpg" alt="Developer 2" style="width: 150px; height: 150px;"/>
      <h3>Hanafi</h3>
      <p>Front end developer and vice project leader, responsible for aiding with front-end development</p>
    </div>
    <div class="card">
      <img src="media/min.jpg" alt="Developer 4"style ="width: 150px; height: 150px;" />
      <h3>Muhaimin</h3>
      <p>Front end developer</p>
    </div>
    <div class="card">
      <img src="media/ariffhaikal.jpg" alt="Developer 5"style ="width: 150px; height: 150px;" />
      <h3>Ariff Haikal Arifin (2022991913)</h3>
      <p>Front end developer</p>
    </div>
    <div class="card">
      <img src="media/saby.jpg" alt="Developer 6"style ="width: 150px; height: 150px;" />
      <h3>Nursabihah Aqilah (2022770315)</h3>
      <p>Backend developer, responsible for maintaining database infrastructure and security</p>
    </div>
  </section>
  
      </div>
    </main>

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
