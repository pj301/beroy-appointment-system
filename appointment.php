<?php
include 'includes/db_connection.php';

// Function to fetch patients from the database
// Function to fetch patients from the database
function fetchPatientsFromDatabase() {
    global $conn;

    $patients = array();
    $result = $conn->query("SELECT * FROM patient");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $patients[] = $row;
        }
    }

    return $patients;
}

// Function to fetch schedules from the database
function fetchSchedulesFromDatabase() {
    global $conn;

    $schedules = array();
    $result = $conn->query("SELECT * FROM schedule");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $schedules[] = $row;
        }
    }

    return $schedules;
}
// Function to fetch appointments from the database
function fetchAppointmentsFromDatabase() {
 
    $appointments = array();
    $result = $conn->query("SELECT * FROM appointment");

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    }

    return $appointments;
}
// Process Patient Form Submission
if (isset($_POST['submit_patient'])) {
    $p_name = $_POST['p_name'];
    $p_email = $_POST['p_email'];

    // Use prepared statement to insert patient data into the database
    $stmt = $conn->prepare("INSERT INTO patient (p_name, p_email) VALUES (?, ?)");
    $stmt->bindParam(1, $p_name);
    $stmt->bindParam(2, $p_email);

    if ($stmt->execute()) {
        echo "Patient record created successfully";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }

    header("Location: form.php");
    exit();
}

// Process Schedules Form Submission
if (isset($_POST['submit_schedule'])) {
    $s_date = $_POST['s_date'];
    $s_time = $_POST['s_time'];

    // Use prepared statement to insert schedule data into the database
    $stmt = $conn->prepare("INSERT INTO schedule (s_date, s_time) VALUES (?, ?)");
    $stmt->bindParam(1, $s_date);
    $stmt->bindParam(2, $s_time);

    if ($stmt->execute()) {
        echo "Schedule record created successfully";
      
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
    header("Location: form.php");
    exit();
}
// Process Appointment Form Submission
if (isset($_POST['submit_appointment'])) {
    $p_id = $_POST['p_id'];
    $s_id = $_POST['s_id'];
    $s_status = $_POST['s_status']; // New status from the form

    // Use prepared statement to insert appointment data into the database
    $stmt = $conn->prepare("INSERT INTO appointment (p_id, s_id) VALUES (?, ?)");
    $stmt->bindParam(1, $p_id);
    $stmt->bindParam(2, $s_id);

    if ($stmt->execute()) {
        // Update the status in the schedule table
        $updateStatusStmt = $conn->prepare("UPDATE schedule SET s_status = ? WHERE s_id = ?");
        $updateStatusStmt->bindParam(1, $s_status);
        $updateStatusStmt->bindParam(2, $s_id);

        if ($updateStatusStmt->execute()) {
            echo "Appointment record created successfully, and schedule status updated";
        } else {
            echo "Error updating schedule status: " . $updateStatusStmt->errorInfo()[2];
        }

        $updateStatusStmt->closeCursor();
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }

    $stmt->closeCursor();

    // Redirect to the main page after form submissions
    header("Location: view_appointment.php");
    exit();
}


?>