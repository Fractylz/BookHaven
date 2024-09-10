<?php
session_start();
include("dbConn.php");

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Get book ID from POST request
if (isset($_POST['bookId'])) {
    $book_id = $_POST['bookId'];

    // Check if the book is available
    $book_query = "SELECT book_quantity FROM book WHERE book_id = ?";
    $book_stmt = $conn->prepare($book_query);
    $book_stmt->bind_param("i", $book_id);
    $book_stmt->execute();
    $book_result = $book_stmt->get_result();

    if ($book_result->num_rows > 0) {
        $book = $book_result->fetch_assoc();
        $book_quantity = $book['book_quantity'];

        if ($book_quantity > 0) {
            // Reduce the book quantity by 1
            $new_quantity = $book_quantity - 1;
            $update_book_query = "UPDATE book SET book_quantity = ? WHERE book_id = ?";
            $update_book_stmt = $conn->prepare($update_book_query);
            $update_book_stmt->bind_param("ii", $new_quantity, $book_id);

            if ($update_book_stmt->execute()) {
                // Check if the book is already in the cart
                $cart_query = "SELECT * FROM shoppingcart WHERE user_id = ? AND book_id = ?";
                $cart_stmt = $conn->prepare($cart_query);
                $cart_stmt->bind_param("ii", $user_id, $book_id);
                $cart_stmt->execute();
                $cart_result = $cart_stmt->get_result();

                if ($cart_result->num_rows > 0) {
                    // Book is already in the cart, update the quantity and subtotal
                    $update_cart_query = "UPDATE shoppingcart 
                                          SET order_quantity = order_quantity + 1, 
                                              subtotal = subtotal + (SELECT book_price FROM book WHERE book_id = ?) 
                                          WHERE user_id = ? AND book_id = ?";
                    $update_cart_stmt = $conn->prepare($update_cart_query);
                    $update_cart_stmt->bind_param("iii", $book_id, $user_id, $book_id);
                } else {
                    // Book is not in the cart, insert a new row
                    $insert_cart_query = "INSERT INTO shoppingcart (user_id, book_id, order_quantity, subtotal) 
                                          VALUES (?, ?, 1, (SELECT book_price FROM book WHERE book_id = ?))";
                    $insert_cart_stmt = $conn->prepare($insert_cart_query);
                    $insert_cart_stmt->bind_param("iii", $user_id, $book_id, $book_id);
                }

                if (isset($update_cart_stmt) && !$update_cart_stmt->execute()) {
                    die("Error updating cart: " . $update_cart_stmt->error);
                }

                if (isset($insert_cart_stmt) && !$insert_cart_stmt->execute()) {
                    die("Error inserting into cart: " . $insert_cart_stmt->error);
                }
            } else {
                die("Error updating book quantity: " . $update_book_stmt->error);
            }
        } else {
            echo "Sorry, the book is out of stock.";
        }
    } else {
        echo "Invalid book ID.";
    }
}

// Redirect back to books.php
header("Location: books.php");
exit();
?>




