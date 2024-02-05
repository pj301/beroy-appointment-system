<?php
include 'db_connection.php';

// Check if the patient ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $patientId = $_GET['id'];

    // Delete patient from the database
    $deleteQuery = $conn->prepare("DELETE FROM patient WHERE p_id = :patientId");
    $deleteQuery->bindParam(':patientId', $patientId, PDO::PARAM_INT);

    if ($deleteQuery->execute()) {
        echo "Patient deleted successfully!";
    } else {
        echo "Error deleting patient: " . print_r($deleteQuery->errorInfo(), true);
    }
} else {
    echo "Invalid patient ID!";
}
// Redirect to the main page after form submissions



// Redirect to the main page after form submissions
header("Location: ../form.php");
exit();

?>
