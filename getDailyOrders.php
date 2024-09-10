<?php
include 'dbConn.php';

$query = "SELECT DATE(order_date) as date, COUNT(*) as count FROM orders GROUP BY DATE(order_date)";
$result = $conn->query($query);

$dailyData = array();
while($row = $result->fetch_assoc()) {
    $dailyData[$row['date']] = $row['count'];
}

echo json_encode($dailyData);
?>
