<?php
function connectDB() {
    $host = "localhost";
    $dbname = "medical_db";
    $username = "root";
    $password = "123456";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }

    return null;
}

// Call the function to establish the connection
$conn = connectDB();
?>
