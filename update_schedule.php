<?php
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $scheduleId = $_POST['edit_schedule_id'];
    $updatedDate = $_POST['edit_schedule_date'];
    $updatedTime = $_POST['edit_schedule_time'];
    $updatedStatus = $_POST['edit_schedule_status'];

    $updateQuery = $conn->prepare("UPDATE schedule SET s_date = :updatedDate, s_time = :updatedTime, s_status = :updatedStatus WHERE s_id = :scheduleId");
    $updateQuery->bindParam(':updatedDate', $updatedDate, PDO::PARAM_STR);
    $updateQuery->bindParam(':updatedTime', $updatedTime, PDO::PARAM_STR);
    $updateQuery->bindParam(':updatedStatus', $updatedStatus, PDO::PARAM_STR);
    $updateQuery->bindParam(':scheduleId', $scheduleId, PDO::PARAM_INT);

    if ($updateQuery->execute()) {
        echo "Schedule updated successfully!";
    } else {
        echo "Error updating schedule: " . print_r($updateQuery->errorInfo(), true);
    }
}

// Redirect to the main page after updating
header("Location: form.php");
exit();
?>
