<?php
include 'config/db.php';
include 'models/risk_engine.php';
include 'includes/header.php';

$district = $_POST['district'];
$environments = $_POST['environment'] ?? [];

$districtRisk = getDistrictRisk($conn, $district);
$timeRisk = getTimeRisk();
$environmentRisk = getEnvironmentRisk($environments);
$finalRisk = calculateFinalRisk($districtRisk, $timeRisk, $environmentRisk);
?>

<h3>Risk Evaluation Summary</h3>

<div class="risk-card <?php echo strtolower($finalRisk); ?>">
    FINAL RISK LEVEL: <?php echo $finalRisk; ?>
</div>

<br>

<?php
$districtData = [];
$districtCases = [];

$query1 = $conn->query("SELECT district, SUM(total_reported_cases) as total FROM theft_data GROUP BY district LIMIT 8");

while ($row = $query1->fetch_assoc()) {
    $districtData[] = $row['district'];
    $districtCases[] = $row['total'];
}

$years = [];
$yearCases = [];

$query2 = $conn->query("SELECT year, SUM(total_reported_cases) as total FROM theft_data GROUP BY year ORDER BY year");

while ($row = $query2->fetch_assoc()) {
    $years[] = $row['year'];
    $yearCases[] = $row['total'];
}
?>

<canvas id="districtChart"></canvas>
<canvas id="yearChart"></canvas>

<script>
new Chart(document.getElementById("districtChart"), {
    type: "bar",
    data: {
        labels: <?php echo json_encode($districtData); ?>,
        datasets: [{
            label: "District Theft Distribution",
            data: <?php echo json_encode($districtCases); ?>,
            backgroundColor: "#6C5CE7"
        }]
    }
});

new Chart(document.getElementById("yearChart"), {
    type: "line",
    data: {
        labels: <?php echo json_encode($years); ?>,
        datasets: [{
            label: "Year-wise Theft Trend",
            data: <?php echo json_encode($yearCases); ?>,
            borderColor: "#E17055",
            fill: false
        }]
    }
});
</script>

<?php include 'includes/footer.php'; ?>