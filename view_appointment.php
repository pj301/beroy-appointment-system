
<?php include_once 'templates/header.php'; ?>
<style>
    /* Add this CSS to your existing styles or create a new CSS file */

    /* Table Styles */
    table {
        border-collapse: collapse;
        width: 100%;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #3498db;
        color: #fff;
    }

    /* 3D Effect Styles */
    th, td {
        position: relative;
    }

    th::after, td::after {
        content: '';
        position: absolute;
        background: linear-gradient(to bottom, #fff, #f2f2f2);
        height: 50%;
        width: 100%;
        top: 50%;
        left: 0;
        z-index: -1;
    }

    /* Hover Effect */
    tr:hover {
        background-color: #f5f5f5;
    }
</style>
<?php include 'includes/db_connection.php'; ?>

<body>
    <div class="container mt-5" style="padding-bottom: 500px;">
        <!-- Add Entry Button -->
        <button class="btn btn-primary" data-toggle="modal" data-target="#appointmentModal">Add Entry</button>

        <!-- Appointment Modal -->
        <div class="modal fade" id="appointmentModal" tabindex="-1" role="dialog" aria-labelledby="appointmentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="appointmentModalLabel">Appointment Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Appointment Form -->
                        <form action="appointment.php" method="post">
                            <div class="form-group">
                                <label for="p_id">Patient:</label>
                                <select name="p_id" class="form-control" required>
                                    <!-- Fetch and display patient options from the database -->
                                    <?php
                                    $patients = $conn->query("SELECT * FROM patient");
                                    foreach ($patients as $patient) {
                                        echo "<option value='{$patient['p_id']}'>{$patient['p_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="s_id">Schedule:</label>
                                <select name="s_id" class="form-control" required>
                                    <!-- Fetch and display schedule options from the database -->
                                    <?php
                                    $schedules = $conn->query("SELECT * FROM schedule");
                                    foreach ($schedules as $schedule) {
                                        echo "<option value='{$schedule['s_id']}'>{$schedule['s_date']} {$schedule['s_time']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="s_status">Status:</label>
                                <select name="s_status" class="form-control" required>
                                    <?php
                                    // Fetch default status from the schedule table
                                    $defaultStatus = $conn->query("SELECT DISTINCT s_status FROM schedule")->fetchColumn();
                                    
                                    // Display default status and additional options
                                    echo "<option value='PENDING'>PENDING</option>";
                                    echo "<option value='CONFIRMED'>CONFIRMED</option>";
                                    echo "<option value='CANCELLED'>CANCELLED</option>";
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="submit_appointment" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>

        <!-- Appointments View Page -->
        <div>
            <h2>Appointments</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Schedule Date</th>
                        <th>Schedule Time</th>
                        <th>Schedule Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch and display appointments from the database -->
                    <?php
                    $appointments = $conn->query("
                        SELECT a.a_id, p.p_name, s.s_date, s.s_time, s.s_status
                        FROM appointment a
                        JOIN patient p ON a.p_id = p.p_id
                        JOIN schedule s ON a.s_id = s.s_id
                    ");
                   foreach ($appointments as $appointment) {
    echo "<tr>";
    echo "<td>{$appointment['a_id']}</td>";
    echo "<td>{$appointment['p_name']}</td>";
    echo "<td>{$appointment['s_date']}</td>";
    echo "<td>{$appointment['s_time']}</td>";
    echo "<td>{$appointment['s_status']}</td>";
    echo "<td><a href='delete_appointment.php?id={$appointment['a_id']}' class='btn btn-danger'>Delete</a></td>";
    echo "</tr>";
}
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <?php include_once 'templates/footer.php'; ?>
</body>
</html>
