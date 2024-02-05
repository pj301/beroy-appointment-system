<?php
include 'db_connection.php';

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-container label {
            font-weight: bold;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }

        .form-container button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="form-container">
                    <h2 class="mb-4">Edit Patient</h2>
                    <form action="" method="post">
                        <div class="form-group">
                            <label for="updated_name">Updated Name:</label>
                            <input type="text" name="updated_name" class="form-control" value="<?= $patient['p_name']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="updated_email">Updated Email:</label>
                            <input type="email" name="updated_email" class="form-control" value="<?= $patient['p_email']; ?>" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Patient</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
