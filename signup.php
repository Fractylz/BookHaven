<?php
include("dbConn.php");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Escape user inputs for security
  $username = $conn->real_escape_string($_POST['username']);
  $name = $conn->real_escape_string($_POST['name']);
  $email = $conn->real_escape_string($_POST['email']);
  $password = $conn->real_escape_string($_POST['password']);
  $address = $conn->real_escape_string($_POST['address']);
  $phoneNumber = $conn->real_escape_string($_POST['phoneNumber']);

  // Assign access level value
  $accessLevel = "Customer";

  // Insert user data into the database with access level
  $sql = "INSERT INTO users (user_username, user_fullname, user_email, user_password, user_address, user_phoneNo, user_al)
  VALUES ('$username', '$name', '$email', '$password', '$address', '$phoneNumber', '$accessLevel')";

  if ($conn->query($sql) === true) {
    // Display popup message using JavaScript
    echo "<script>alert('You have successfully signed up. You are now logged in.'); window.location.href='login.php';</script>";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>BookHaven</title>
    <link rel="stylesheet" href="signup.css" />
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
    <div class="signup-container">
      <h2>Sign Up</h2>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required />
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required />
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required />
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required />
        <label for="address">Address:</label>
        <input type="text" id="address" name="address" required />
        <label for="phoneNumber">Phone Number:</label>
        <input type="tel" id="phoneNumber" name="phoneNumber" pattern="[0-9]{10}" required title="Please enter a valid phone number with 10 digits" />
        <button type="submit">Sign Up</button>
      </form>
    </div>
    <script>
      function validateForm() {
        var phoneNumber = document.getElementById("phoneNumber").value;
        var phonePattern = /^[0-9]{10}$/;
        if (!phonePattern.test(phoneNumber)) {
          alert("Please enter a valid phone number with 10 digits.");
          return false;
        }
        return true;
      }
    </script>
  </body>
</html>
