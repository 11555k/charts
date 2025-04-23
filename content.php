<?php include 'header.php'; ?>

<?php
$chartType = $_GET['chart'] ?? 'gold';
$chartTitle = strtoupper($chartType) . " / USD";
?>

<h2 style="text-align: center; margin-top: 100px;">Live <?php echo $chartTitle; ?> Price</h2>
<div id="container" style="max-width: 900px; height: 450px; margin: 0 auto;"></div>

<!-- Highcharts CDN -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
let chart;

function fetchLatestPriceAndUpdateChart() {
  fetch('get_price.php?asset=<?php echo $chartType; ?>')
    .then(res => res.json())
    .then(data => {
      const price = parseFloat(data.price);
      const now = (new Date()).getTime();
      if (!isNaN(price)) {
        chart.series[0].addPoint([now, price], true, chart.series[0].data.length >= 60);
      }
    })
    .catch(err => {
      console.error("Error fetching price:", err);
    });
}

function initializeChart(historicalData) {
  chart = Highcharts.chart('container', {
    chart: {
      type: 'spline',
      backgroundColor: '#ffffff',
      zoomType: 'x'
    },
    title: {
      text: '<?php echo $chartTitle; ?>',
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
      name: '<?php echo $chartTitle; ?>',
      data: historicalData,
      color: '#FFA500',
      marker: { enabled: false }
    }]
  });

  // Refresh price every 3 seconds
  setInterval(fetchLatestPriceAndUpdateChart, 3000);
}

// Fetch the  data from the database
fetch('get_historical_data.php?asset=<?php echo $chartType; ?>')
  .then(res => res.json())
  .then(data => {
    const historicalData = data.length > 0 ? data : [];
    initializeChart(historicalData);
  })
  .catch(err => {
    console.error("Error fetching historical data:", err);
    initializeChart([]);
  });
</script>