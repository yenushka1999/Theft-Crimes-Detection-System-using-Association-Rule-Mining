<?php
$conn = new mysqli("localhost", "root", "root", "theft_awareness_system");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>