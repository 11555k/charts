<?php include 'header.php'; ?>

<h2>Admin Panel: Set Prices</h2>
<form method="POST" action="update_price.php" class="container" style="max-width: 400px;">
  <div class="mb-3">
    <label for="asset" class="form-label">Select Asset</label>
    <select class="form-select" name="asset" required>
      <option value="gold">Gold</option>
      <option value="silver">Silver</option>
      <option value="egp">EGP</option>
    </select>
  </div>
  <div class="mb-3">
    <label for="price" class="form-label">Price (USD)</label>
    <input type="number" class="form-control" step="0.01" name="price" required>
  </div>
  <button type="submit" class="btn btn-primary">Update Price</button>
</form>
</body>
</html>
