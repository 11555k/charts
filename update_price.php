<?php
// Make sure the user is authenticated if necessary
session_start();

// You can add authentication check here if you require login to access this page

// Database connection
$conn = new mysqli("localhost", "root", "", "charts");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $asset = $_POST['asset'] ?? '';
    $price = $_POST['price'] ?? '';

    // Validate data
    if (empty($asset) || empty($price) || !is_numeric($price)) {
        echo "Invalid input.";
        exit;
    }

    // Prepare the SQL query to update the price
    $stmt = $conn->prepare("INSERT INTO prices (asset, price, updated_at) VALUES (?, ?, NOW()) ON DUPLICATE KEY UPDATE price = ?, updated_at = NOW()");
    $stmt->bind_param("sds", $asset, $price, $price);

    // Execute the query
    if ($stmt->execute()) {
        echo "Price updated successfully!";
    } else {
        echo "Error updating price: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Price</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Update Asset Price</h2>
    <form action="update_price.php" method="POST">
        <div class="form-group">
            <label for="asset">Asset</label>
            <select name="asset" id="asset" class="form-control">
                <option value="gold">Gold</option>
                <option value="silver">Silver</option>
                <option value="egp">EGP</option>
            </select>
        </div>
        <div class="form-group">
            <label for="price">Price (USD)</label>
            <input type="text" name="price" id="price" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Price</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
