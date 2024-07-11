<?php 
	include('../config/db.php');

	if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Retrieve data from the login form
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Validate the data (perform additional validation as needed)
        if (empty($email) || empty($password)) {
            // Handle validation errors, redirect back to the login form with an error message, etc.
            echo "Email and password are required.";
            exit;
        }
        try {
            // Check the connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            // Escape the input to prevent SQL injection
            $email = $conn->real_escape_string($email);
            // Prepare the SQL statement
            $sql = "SELECT id, password, name FROM tbluser WHERE email = '$email'";
            // Execute the statement
            $result = $conn->query($sql);
            // Check if the user exists
            if ($result && $result->num_rows > 0) {
                $user = $result->fetch_assoc();
                // Verify the password
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['admin_logged_in'] = true;
                    // Redirect to the dashboard or user-specific page
                    header("Location: https://dyorindustries.com/admin/");
                    exit;
                } else {
                    // Password is incorrect
                    echo "Invalid password.";
                    exit;
                }
            } else{
                // User does not exist
                echo "Invalid email.";
                exit;
            }
        } catch (Exception $e) {
            // Handle other exceptions, redirect back to the login form with an error message, etc.
            echo "Error: " . $e->getMessage();
            exit;
        }
    } 
    else {
        // Redirect to the login form if accessed directly without a form submission
        header("Location: login.php");
        exit;
    }

?>