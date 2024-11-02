<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
    require_once '../config/database.php';

    // Get the input values from the form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate username
    if (empty($username) || !is_string($username)) {
        echo "<script>alert('Username must be a non-empty string.'); window.location.href = '../auth/signup.php';</script>";
        exit();
    }

    // Validate email
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address.'); window.location.href = '../auth/signup.php';</script>";
        exit();
    }

    // Validate password length and content
    if (strlen($password) < 8 || !preg_match('/[0-9]/', $password)) {
        echo "<script>alert('Password must be at least 8 characters long and contain at least one number.'); window.location.href = '../auth/signup.php';</script>";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Prepare an insert statement
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Redirect to the main page
            header("location: ../index.php");
            exit();
        } else {
            echo "<script>alert('Something went wrong. Please try again later.'); window.location.href = '../auth/signup.php';</script>";
        }

        // Close statement
        $stmt->close();
    }

    // Close connection
    $conn->close();
}
?>