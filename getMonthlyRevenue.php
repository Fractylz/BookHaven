<?php
include 'dbConn.php';

$query = "SELECT DATE_FORMAT(order_date, '%M') as month, SUM(total_amount) as revenue FROM orders GROUP BY DATE_FORMAT(order_date, '%M')";
$result = $conn->query($query);

$revenueData = array();
while($row = $result->fetch_assoc()) {
    $revenueData[$row['month']] = $row['revenue'];
}

echo json_encode($revenueData);
?>
