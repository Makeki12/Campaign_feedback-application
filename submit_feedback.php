<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $feedback = $_POST['feedback'];
    $rating = $_POST['rating'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'campaign_feedback');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        // Prepare the SQL statement without the Id (auto-increment field)
        $stmt = $conn->prepare("INSERT INTO feedback (name, email, feedback, rating, submission_date) VALUES (?, ?, ?, ?, NOW())");
        
        // Bind parameters (s = string, i = integer)
        $stmt->bind_param("sssi", $name, $email, $feedback, $rating);
        
        // Execute the statement
        if ($stmt->execute()) {
            echo "Feedback saved successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    echo "No POST data received.";
}
?>
