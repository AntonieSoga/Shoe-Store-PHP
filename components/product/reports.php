<?php
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/shoes/";

require_once($path . 'connectPDO.php');

// Retrieve product data from the database
$ReadSql = "SELECT * FROM `products`";
$res = $pdo->query($ReadSql);

// Prepare data for the chart
$chartData = array();
$brandData = array();
$priceData = array();

while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
    $brand = $row['brand'];
    $price = $row['price'];

    if (!isset($chartData[$brand])) {
        $chartData[$brand] = 1;
        $brandData[] = $brand;
        $priceData[$brand] = $price;
    } else {
        $chartData[$brand]++;
        $priceData[$brand] += $price;
    }
}

// Calculate average price for each brand
$averagePriceData = array();
foreach ($chartData as $brand => $count) {
    $averagePriceData[$brand] = $priceData[$brand] / $count;
}

// Sort brands based on average price
arsort($averagePriceData);

?>

<?php require($path . 'templates/header.php') ?>

<div class="container-fluid my-4">
    <div class="row my-2">
        <h2>Antonie Shoes Shop - Report</h2>
    </div>
    <div class="row">
        <div class="col-md-6">
            <canvas id="brandChart"></canvas>
        </div>
        <div class="col-md-6">
            <table class="table">
                <thead>
                    <tr>
                        <th>Brand</th>
                        <th>Product Count</th>
                        <th>Average Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($averagePriceData as $brand => $averagePrice) : ?>
                        <tr>
                            <td><?php echo $brand; ?></td>
                            <td><?php echo $chartData[$brand]; ?></td>
                            <td><?php echo '$' . number_format($averagePrice, 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Chart.js configuration
    var ctx = document.getElementById('brandChart').getContext('2d');
    var brandChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($brandData); ?>,
            datasets: [{
                label: 'Product Count',
                data: <?php echo json_encode(array_values($chartData)); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Average Price',
                data: <?php echo json_encode(array_values($averagePriceData)); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!-- Footer here -->
<?php require($path . 'templates/footer.php') ?>
