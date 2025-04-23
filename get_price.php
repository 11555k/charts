<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "charts");

if ($conn->connect_error) {
    echo json_encode(['price' => null]);
    exit;
}

$asset = $_GET['asset'] ?? 'gold';

$stmt = $conn->prepare("SELECT price FROM prices WHERE asset = ? ORDER BY updated_at DESC LIMIT 1");
$stmt->bind_param("s", $asset);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['price' => $row['price'] ?? null]);
$stmt->close();
$conn->close();
?>