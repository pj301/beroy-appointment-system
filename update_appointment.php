<?php
include 'includes/db_connection.php';
// Retrieve appointment data based on the provided ID
if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];
    
    // Fetch appointment details
    $query = $conn->prepare("
        SELECT a.a_id, p.p_name, s.s_date, s.s_time, s.s_status
        FROM appointment a
        JOIN patient p ON a.p_id = p.p_id
        JOIN schedule s ON a.s_id = s.s_id
        WHERE a.a_id = :appointmentId
    ");
    $query->bindParam(':appointmentId', $appointmentId, PDO::PARAM_INT);
    $query->execute();
    
    $appointment = $query->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {
        // Handle not found case
        echo "Appointment not found!";
        exit();
    }
} else {
    // Handle missing ID case
    echo "Appointment ID is missing!";
    exit();
}
?>

<!-- Create an edit form with fields pre-filled with appointment data -->
<!-- Use a similar form as your add form with an additional hidden input for appointment ID -->
