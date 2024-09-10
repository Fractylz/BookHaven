<?php
include 'dbConn.php';

$query = "SELECT DATE_FORMAT(added_date, '%M') as month, COUNT(*) as count FROM books GROUP BY DATE_FORMAT(added_date, '%M')";
$result = $conn->query($query);

$booksData = array();
while($row = $result->fetch_assoc()) {
    $booksData[$row['month']] = $row['count'];
}

echo json_encode($booksData);
?>
