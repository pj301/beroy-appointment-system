<?php
include 'includes/db_connection.php';
// Retrieve appointment ID from the URL
if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];

    // Delete appointment from the database
    $deleteQuery = $conn->prepare("DELETE FROM appointment WHERE a_id = :appointmentId");
    $deleteQuery->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);

    if ($deleteQuery->execute()) {
       // Redirect to the main page after form submissions
    header("Location: view_appointment.php");
    exit();
    } else {
        // Handle deletion error
        echo "Error deleting appointment: " . print_r($deleteQuery->errorInfo(), true);
        exit();
    }
} else {
    // Handle missing ID case
    echo "Appointment ID is missing!";
    exit();
}
?>
