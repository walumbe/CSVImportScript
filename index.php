<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = 'localhost';
$password = 'P@ssW0rd';
$db = 'test';
$username = 'root';

$conn = new mysqli($host, $username, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}else {
    echo "connected";
}

$sql = "INSERT INTO winning_histories(id,prize_id,station_show_prize_id,reference_code,station_id,presenter_id,station_show_id,amount,transaction_cost,conversation_id,transaction_reference,status,remember_token, created_at, updated_at, deleted_at, notified, unique_field) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);


$csvFile = 'bruno.csv';
$file = fopen($csvFile, 'r');

while (($row = fgetcsv($file)) !== false) {
    $row = array_map(function ($value) {
        return ($value === '\N') ? null : $value;
    }, $row);
    $stmt->bind_param('ssssssssssssssssss', ...$row); 
    if ($stmt->execute()) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $conn->error; 
    }
}


fclose($file);

$stmt->close();
$conn->close();
?>



