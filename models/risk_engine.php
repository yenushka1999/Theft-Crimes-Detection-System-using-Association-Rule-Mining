<?php

function getDistrictRisk($conn, $district) {

    $query = "
        SELECT SUM(total_reported_cases) as total_cases
        FROM theft_data
        WHERE district = '$district'
    ";

    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $cases = $row['total_cases'];

    if ($cases > 15000) return "High";
    if ($cases > 7000) return "Medium";
    return "Low";
}

function getTimeRisk() {

    $hour = date("H");

    if ($hour >= 17 && $hour < 21) return "High";
    if ($hour >= 12 && $hour < 17) return "Medium";
    return "Low";
}

function getEnvironmentRisk($environments) {

    $score = 0;

    foreach ($environments as $env) {

        switch ($env) {

            case "Bus Stand":
            case "Train Station":
            case "Inside Bus - Normal":
            case "Inside Train - 3rd Class":
                $score += 2;
                break;

            case "Inside Bus - AC":
            case "Inside Train - 2nd Class":
            case "Shopping Mall":
            case "Supermarket":
                $score += 1;
                break;

            case "Inside Train - 1st Class":
            case "Hospital":
                $score += 0;
                break;
        }
    }

    if ($score >= 3) return "High";
    if ($score >= 1) return "Medium";
    return "Low";
}

function calculateFinalRisk($districtRisk, $timeRisk, $environmentRisk) {

    $score = 0;

    if ($districtRisk == "High") $score += 2;
    if ($districtRisk == "Medium") $score += 1;

    if ($timeRisk == "High") $score += 2;
    if ($timeRisk == "Medium") $score += 1;

    if ($environmentRisk == "High") $score += 2;
    if ($environmentRisk == "Medium") $score += 1;

    if ($score >= 5) return "High";
    if ($score >= 3) return "Medium";
    return "Low";
}
?>