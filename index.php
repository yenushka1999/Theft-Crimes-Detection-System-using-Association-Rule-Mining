<?php
include 'config/db.php';
include 'includes/header.php';
?>

<h3>Select Context to Evaluate Theft Risk</h3>

<form action="result.php" method="POST">

<label>District:</label>
<select name="district" required>
<?php
$result = $conn->query("SELECT DISTINCT district FROM theft_data");

while ($row = $result->fetch_assoc()) {
    echo "<option value='".$row['district']."'>".$row['district']."</option>";
}
?>
</select>

<br><br>

<h4>Location Context:</h4>

<div class="checkbox-group">
<input type="checkbox" name="environment[]" value="Bus Stand"> Public Bus Stand
<input type="checkbox" name="environment[]" value="Train Station"> Train Station
<input type="checkbox" name="environment[]" value="Inside Bus - Normal"> Bus (Normal)
<input type="checkbox" name="environment[]" value="Inside Bus - AC"> Bus (AC)
<input type="checkbox" name="environment[]" value="Inside Train - 1st Class"> Train 1st Class
<input type="checkbox" name="environment[]" value="Inside Train - 2nd Class"> Train 2nd Class
<input type="checkbox" name="environment[]" value="Inside Train - 3rd Class"> Train 3rd Class
<input type="checkbox" name="environment[]" value="Shopping Mall"> Shopping Mall
<input type="checkbox" name="environment[]" value="Supermarket"> Supermarket
<input type="checkbox" name="environment[]" value="Hospital"> Hospital
</div>

<br>

<button type="submit">Analyze Risk</button>

</form>

<?php include 'includes/footer.php'; ?>