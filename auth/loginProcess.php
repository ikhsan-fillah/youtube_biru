<?php

session_start();
require_once '../config/database.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are not empty
    if (!empty($email) && !empty($password)) {
        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Set session variables and redirect to index.php
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: ../pages/index.php");
                exit();
            } else {
                echo "Invalid password.";
            }
        } else {
            echo "No user found with this email.";
        }
    } else {
        echo "Please fill in all fields.";
    }
}
?>