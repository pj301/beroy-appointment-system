<?php include_once 'templates/header.php'; ?>

<style>
    /* Add your custom styles here if needed */
    .left-container,
    .right-container {
        width: 100%;
    }

    .table-divider-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        margin-bottom: 100px;
    }

    .form-group,
    h2 {
        margin-left: 20px;
        margin-right: 20px;
    }

    .button-adjust {
        margin-left: 20px;
    }

    .cards-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
        /* Set the desired space between cards */
        max-width: 100%;
        padding-bottom: 100px;
        padding-top: 30px;
        margin-left: 30px;
        transition: margin-left 0.5s ease;
        /* Add smooth transition */
    }

    .Card a {
        text-decoration: none;
        color: inherit;
        /* This inherits the color from the parent, adjust as needed */
        font-size: 100px;
        font-weight: bold;
    }

    .Card {
        background-color: rgba(52, 152, 219, 0.7);
        /* Transparent blue color, adjust as needed */
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 20px;
        height: 300px;
        margin-top: 20px;
        transition: transform 0.3s ease-in-out;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .Card:hover {
        transform: scale(1.05);
    }

    .Category {
        font-size: 18px;
        margin-top: 10px;
    }

    .Card img {
        width: 100px;
        height: 100px;
        padding: 10px;
    }

    .Card:nth-child(1) {
        background-color: #d0db34bb;
        /* Transparent blue color for the first card */
        color: #ffffff;
        /* Set the text color for the first card */
    }

    .Card:nth-child(2) {
        background-color: #e74d3ca4;
        /* Transparent red color for the second card */
        color: #ffffff;
        /* Set the text color for the second card */
    }

    /* Table styling */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 12px;
        text-align: left;
        border: 3px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #f5f5f5;
    }
</style>


<?php
include 'includes/db_connection.php';

// Check if the patient ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $patientId = $_GET['id'];

    // Fetch patient details based on the provided ID
    $query = $conn->prepare("SELECT * FROM patient WHERE p_id = :patientId");
    $query->bindParam(':patientId', $patientId, PDO::PARAM_INT);
    $query->execute();
    $patient = $query->fetch(PDO::FETCH_ASSOC);

    // Check if the patient exists
    if ($patient) {
        // Handle form submission for updating patient data
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Sanitize and validate the updated data (you may need to enhance this part)
            $updatedName = $_POST['updated_name'];
            $updatedEmail = $_POST['updated_email'];

            // Update patient data in the database
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
    }
}
?>


<body>
    <div class="container mt-5">

        <!-- Cards Container -->
        <div class="cards-container">

            <!-- Patient Form Card -->
            <div class="Card">
                <a href="#" data-toggle="modal" data-target="#patientFormModal">
                    <img src="images/menu-unscreen.gif" alt="">
                    <div class="Category">Add Patient Data Here</div>
                </a>
            </div>

            <!-- Schedule Form Card -->
            <div class="Card">
                <a href="#" data-toggle="modal" data-target="#scheduleFormModal">
                    <img src="images/school-unscreen.gif" alt="">
                    <div class="Category">Create Schedule?</div>
                </a>
            </div>
        </div>

        <!-- Patient Form Modal -->
        <div class="modal fade" id="patientFormModal" tabindex="-1" role="dialog" aria-labelledby="patientFormModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Patient Form Content Goes Here -->
                    <!-- Patient Form -->
                    <form action="appointment.php" method="post" class="mb-4">
                        <h2>Patient Form</h2>
                        <div class="form-group">
                            <label for="p_name">Name:</label>
                            <input type="text" name="p_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="p_email">Email:</label>
                            <input type="email" name="p_email" class="form-control" required>
                        </div>

                        <div class="button-adjust"><button type="submit" name="submit_patient" class="btn btn-primary">Submit</button></div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Schedule Form Modal -->
        <div class="modal fade" id="scheduleFormModal" tabindex="-1" role="dialog" aria-labelledby="scheduleFormModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Schedule Form Content Goes Here -->
                    <!-- Schedules Form -->
                    <form action="appointment.php" method="post" class="mb-4">
                        <h2>Create Schedule</h2>
                        <div class="form-group">
                         
                            <label for="s_date">Date:</label>
                            <input type="date" name="s_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="s_time">Time:</label>
                            <input type="time" name="s_time" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="s_status">Status:</label>
                            <!-- Disabled input field for 'Pending' status -->
                            <input type="text" name="s_status" class="form-control" value="Pending" disabled>
                        </div>
                        <div class="button-adjust"><button type="submit" name="submit_schedule" class="btn btn-primary">Submit</button></div>
                    </form>

                </div>
            </div>
        </div>
       <!-- Left Container - Existing Patients -->
     <div class="table-divider-container">
         <div class="left-container">
          
                <h2>Patient List</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $existingPatients = $conn->query("SELECT * FROM patient");
                        foreach ($existingPatients as $patient) {
                            echo "<tr>";
                            echo "<td>{$patient['p_id']}</td>";
                            echo "<td>{$patient['p_name']}</td>";
                            echo "<td>{$patient['p_email']}</td>";
                            echo "<td>
                                    <button onclick='editPatient(\"{$patient['p_id']}\", \"{$patient['p_name']}\", \"{$patient['p_email']}\")' class='btn btn-primary'>Edit</button>
                                    <a href='includes/delete_patient.php?id={$patient['p_id']}' class='btn btn-danger'>Delete</a>
                                </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            <!-- Your JavaScript function to update form fields -->
            <script>
                function editPatient(name, email) {
                    // Update the form fields with the patient's data
                    document.getElementById('updated_name').value = name;
                    document.getElementById('updated_email').value = email;

                    // Scroll to the form
                    scrollToForm();
                }
            </script>

         </div>
                    <!-- Your HTML form -->
                    <!-- Edit Patient Modal -->
            <div class="modal fade" id="editPatientModal" tabindex="-1" role="dialog" aria-labelledby="editPatientModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editPatientModalLabel">Edit Patient</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Edit Patient Form -->
                            <form action="update_patient.php" method="post">
                                <input type="hidden" id="edit_patient_id" name="edit_patient_id">
                                <div class="form-group">
                                    <label for="edit_patient_name">Name:</label>
                                    <input type="text" id="edit_patient_name" name="edit_patient_name" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="edit_patient_email">Email:</label>
                                    <input type="email" id="edit_patient_email" name="edit_patient_email" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
           </div>
                <script>
                    function editPatient(patientId, patientName, patientEmail) {
                        // Update the form fields with the patient's data
                        document.getElementById('edit_patient_id').value = patientId;
                        document.getElementById('edit_patient_name').value = patientName;
                        document.getElementById('edit_patient_email').value = patientEmail;

                        // Show the edit patient modal
                        $('#editPatientModal').modal('show');
                    }
                </script>
            <!-- Right Container - Schedule Form -->
          <div class="right-container">
                    
                        <h2>Schedule List</h2>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                        $scheduleData = $conn->query("SELECT * FROM schedule");
                        foreach ($scheduleData as $schedule) {
                            echo "<tr>";
                            echo "<td>{$schedule['s_id']}</td>";
                            echo "<td>{$schedule['s_date']}</td>";
                            echo "<td>{$schedule['s_time']}</td>";
                            echo "<td>{$schedule['s_status']}</td>";

                            // Add Edit and Delete buttons
                            echo "<td>
                                    <button onclick='editSchedule(\"{$schedule['s_id']}\", \"{$schedule['s_date']}\", \"{$schedule['s_time']}\", \"{$schedule['s_status']}\")' class='btn btn-primary'>Edit</button>
                                    <a href='delete_schedule.php?s_id={$schedule['s_id']}' class='btn btn-danger'>Delete</a>
                                    </td>";

                            echo "</tr>";
                        }
                        ?>


                            </tbody>
                        </table>
                    
                    <!-- Your Schedule Form Modal here -->
<!-- Edit Schedule Modal -->
<div class="modal fade" id="editScheduleModal" tabindex="-1" role="dialog" aria-labelledby="editScheduleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editScheduleModalLabel">Edit Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Edit Schedule Form -->
                <form action="update_schedule.php" method="post">
                    <input type="hidden" id="edit_schedule_id" name="edit_schedule_id">
                    <div class="form-group">
                        <label for="edit_schedule_date">Date:</label>
                        <input type="date" id="edit_schedule_date" name="edit_schedule_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_schedule_time">Time:</label>
                        <input type="time" id="edit_schedule_time" name="edit_schedule_time" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_schedule_status">Status:</label>
                        <input type="text" id="edit_schedule_status" name="edit_schedule_status" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>



                    <script>
    function editSchedule(scheduleId, scheduleDate, scheduleTime, scheduleStatus) {
        // Update the form fields with the schedule's data
        document.getElementById('edit_schedule_id').value = scheduleId;
        document.getElementById('edit_schedule_date').value = scheduleDate;
        document.getElementById('edit_schedule_time').value = scheduleTime;
        document.getElementById('edit_schedule_status').value = scheduleStatus;

        // Show the edit schedule modal
        $('#editScheduleModal').modal('show');
    }
</script>

                </div>
            </div>
     </div>              
</div>
    <!-- Your Existing Scripts and Libraries -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>

    <?php include_once 'templates/footer.php'; ?>
</body>

</html>
