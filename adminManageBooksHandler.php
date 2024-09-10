<?php

include("dbConn.php");

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $publicationYear = mysqli_real_escape_string($conn, $_POST['publicationYear']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);

    // Handle uploaded image
    $targetDirectory = "../BookHaven/bookImg"; // Define the directory to store uploaded images
    $targetFile = $targetDirectory . basename($_FILES["bookImage"]["name"]);
    
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["bookImage"]["tmp_name"]);
    if ($check !== false) {
        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["bookImage"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["bookImage"]["name"])). " has been uploaded.";
            
            // Process other book details and database insertion
            // Connect to your database and insert the book details including the image file path or name
            // Example:
             $imageFilePath = $targetFile; // Store the image path in the database
             $sql = "INSERT INTO book (book_title, book_isbn, book_author, book_genre, book_price, book_year, book_quantity, book_img) 
                     VALUES ('$title', '$isbn', '$author', '$genre', '$price', '$publicationYear', $quantity, '$imageFilePath')";
            
            if ($conn->query($sql) === true) {
                echo "Book added successfully";
              } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
              }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close the connection
$conn->close();
?>
