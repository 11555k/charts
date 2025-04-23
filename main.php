<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <?php include 'header.php'; ?>
  <title>Live Asset Price Chart</title>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <style>
    body {
      background-color: rgb(210, 210, 210);
      color: #000;
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 20px;
      text-align: center;
    }

    #container {
      max-width: 900px;
      margin: 0 auto;
    }

    h2 {
      color: #333;
    }
    
    .asset-selector {
      margin: 20px 0;
    }
    
    .asset-selector button {
      padding: 8px 16px;
      margin: 0 5px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    
    .asset-selector button:hover {
      background-color: #45a049;
    }
    
    .asset-selector button.active {
      background-color: #2E8B57;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <?php
  // Get available assets from the database
  $conn = new mysqli("localhost", "root", "", "charts");
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }
  
  // Get distinct assets from the database
  $result = $conn->query("SELECT DISTINCT asset FROM prices");
  $assets = [];
  while ($row = $result->fetch_assoc()) {
    $assets[] = $row['asset'];
  }
  
  // Default to gold if no assets found
  if (empty($assets)) {
    $assets = ['gold'];
  }
  
  // Randomly select an asset if not specified
  $selectedAsset = $_GET['asset'] ?? $assets[array_rand($assets)];
  ?>

  <h2>Live <span id="asset-title"><?= ucfirst($selectedAsset) ?></span> Price Chart</h2>
  
  <div class="asset-selector">
    <?php foreach ($assets as $asset): ?>
      <button 
        class="asset-btn <?= ($asset == $selectedAsset) ? 'active' : '' ?>" 
        data-asset="<?= $asset ?>"
      >
        <?= ucfirst($asset) ?>
      </button>
    <?php endforeach; ?>
  </div>
  
  <div id="container" style="height: 450px; margin-top: 20px;"></div>

  <script>
    // Initialize chart with empty data
    const chart = Highcharts.chart('container', {
      chart: {
        type: 'spline',
        backgroundColor: '#ffffff',
        zoomType: 'x'
      },
      title: {
        text: '<?= ucfirst($selectedAsset) ?> Price',
        style: { color: '#222' }
      },
      xAxis: {
        type: 'datetime',
        title: { text: 'Time' },
        labels: { style: { color: '#444' } }
      },
      yAxis: {
        title: {
          text: 'Price (USD)',
          style: { color: '#444' }
        },
        labels: { style: { color: '#444' } }
      },
      tooltip: {
        xDateFormat: '%Y-%m-%d %H:%M:%S',
        valueDecimals: 2,
        shared: true
      },
      legend: {
        itemStyle: { color: '#333' }
      },
      credits: { enabled: false },
      series: [{
        name: '<?= ucfirst($selectedAsset) ?> Price',
        data: [],
        color: '#FFA500',
        marker: {
          enabled: false
        }
      }]
    });

    // Function to fetch latest price from database
    function fetchLatestPrice() {
      fetch(`get_price.php?asset=<?= $selectedAsset ?>`)
        .then(response => response.json())
        .then(data => {
          if (data.price !== null) {
            const now = (new Date()).getTime();
            chart.series[0].addPoint([now, parseFloat(data.price)], true, chart.series[0].data.length >= 60);
          }
        })
        .catch(error => console.error('Error fetching latest price:', error));
    }

    // Function to load historical data
    function loadHistoricalData() {
      fetch(`get_historical_data.php?asset=<?= $selectedAsset ?>`)
        .then(response => response.json())
        .then(data => {
          if (data.length > 0) {
            // Clear existing data and load historical data
            chart.series[0].setData(data, true);
          } else {
            console.log("No historical data available");
          }
        })
        .catch(error => console.error('Error loading historical data:', error));
    }
    
    // Load historical data when page loads
    loadHistoricalData();
    
    // Update price every 5 seconds if new data is available
    setInterval(fetchLatestPrice, 5000);
    
    // Add event listeners to asset selector buttons
    document.querySelectorAll('.asset-btn').forEach(button => {
      button.addEventListener('click', function() {
        const asset = this.getAttribute('data-asset');
        window.location.href = `?asset=${asset}`;
      });
    });
  </script>

</body>
</html>