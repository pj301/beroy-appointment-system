<?php
include 'includes/db_connection.php';

// Check if the request method is GET and 's_id' is set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['s_id'])) {
    $scheduleIdToDelete = $_GET['s_id'];

    try {
        // Use the function to get a PDO connection
        $conn = connectDB();

        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement for deletion
        $sql = "DELETE FROM schedule WHERE s_id = :s_id";
        $stmt = $conn->prepare($sql);

        // Bind the parameter using bindParam to prevent SQL injection
        $stmt->bindParam(':s_id', $scheduleIdToDelete, PDO::PARAM_INT);

        // Execute the statement
        $stmt->execute();

        // Check if any row was affected (i.e., if the schedule was deleted)
        if ($stmt->rowCount() > 0) {
            // Redirect back to the user data page after successful deletion
            header("Location: form.php");
            exit();
        } else {
            echo "Schedule not found or already deleted.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Always close the connection
        if ($conn) {
            $conn = null;
        }
    }
} else {
    echo "Invalid request.";
}
?>
