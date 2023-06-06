<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the submitted username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Perform your authentication logic here
    // Replace the code below with your actual authentication code
    if ($username === "admin" && $password === "password") {
        // Redirect to the dashboard or desired page on successful authentication
        header("Location: dashboard.html");
        exit(); // Make sure to exit after the redirect
    } else {
        // Display an error message if authentication fails
        echo "Invalid username or password.";
    }
}
?>

