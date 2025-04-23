<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "charts");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed: ' . $conn->connect_error]));
}

$asset = $_GET['asset'] ?? 'gold';
$limit = $_GET['limit'] ?? 60; 

// Prepare the SQL query to get  data
$stmt = $conn->prepare("SELECT price, UNIX_TIMESTAMP(updated_at) * 1000 as timestamp 
                        FROM prices 
                        WHERE asset = ? 
                        ORDER BY updated_at ASC 
                        LIMIT ?");
$stmt->bind_param("si", $asset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [(float)$row['timestamp'], (float)$row['price']];
}

echo json_encode($data);

$stmt->close();
$conn->close();
?>