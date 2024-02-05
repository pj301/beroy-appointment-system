<?php
include 'includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patientId = $_POST['edit_patient_id'];
    $updatedName = $_POST['edit_patient_name'];
    $updatedEmail = $_POST['edit_patient_email'];

    $updateQuery = $conn->prepare("UPDATE patient SET p_name = :updatedName, p_email = :updatedEmail WHERE p_id = :patientId");
    $updateQuery->bindParam(':updatedName', $updatedName, PDO::PARAM_STR);
    $updateQuery->bindParam(':updatedEmail', $updatedEmail, PDO::PARAM_STR);
    $updateQuery->bindParam(':patientId', $patientId, PDO::PARAM_INT);

    if ($updateQuery->execute()) {
        echo "Patient updated successfully!";
    } else {
        echo "Error updating patient: " . print_r($updateQuery->errorInfo(), true);
    }
}

// Redirect to the main page after updating
header("Location: form.php");
exit();
?>
