<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>BookHaven</title>
    <link rel="stylesheet" href="login.css" />
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
          <li><a href="aboutUs.php">About Us</a></li>
        </ul>
      </nav>
    </header>

    <section>

    <div class="login-container">
      <h2>Login</h2>
      <form action="loginHandler.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />

        <button type="submit">Login</button><br />
        <p>
          Don't have an account?
          <a href="signup.php">Sign up</a>
        </p>
      </form>
    </div>
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
