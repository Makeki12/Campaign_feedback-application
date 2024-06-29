# Campaign_feedback-application
### README for Feedback Web Application

---

## Feedback Web Application

This web application allows users to submit feedback through a form. The feedback data is stored in a MySQL database. The application is built using HTML for the form and PHP for server-side processing.

### Prerequisites

1. **XAMPP** (or any other web server with PHP and MySQL support)
2. Basic knowledge of HTML, PHP, and SQL

### Installation

#### 1. Install XAMPP

Download and install XAMPP from [Apache Friends](https://www.apachefriends.org/index.html).

#### 2. Start Apache and MySQL

Open the XAMPP Control Panel and start the Apache and MySQL services.

### Setup

#### 1. Database Setup

1. Open phpMyAdmin (usually at `http://localhost/phpmyadmin/`).
2. Create a new database named `campaign_feedback`.
3. Run the following SQL queries to create the `feedback` table:

```sql
CREATE DATABASE campaign_feedback;

USE campaign_feedback;

CREATE TABLE feedback (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    feedback TEXT,
    rating INT,
    submission_date DATETIME DEFAULT CURRENT_TIMESTAMP
);
```

#### 2. Project Files

1. Download or clone the project files.
2. Place the HTML and PHP files in the `htdocs` directory of your XAMPP installation (usually `C:\xampp\htdocs\`).

### Project Structure

```
/xampp/htdocs/
    ├── feedback_form.html
    ├── submit_feedback.php
```

#### feedback_form.html

This file contains the HTML form for submitting feedback.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
</head>
<body>
    <form action="submit_feedback.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br>
        <label for="feedback">Feedback:</label>
        <textarea id="feedback" name="feedback" required></textarea><br>
        <label for="rating">Rating:</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br>
        <input type="submit" value="Submit Feedback">
    </form>
</body>
</html>
```

#### submit_feedback.php

This file processes the form data and inserts it into the MySQL database.

```php
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
```

### Testing

1. Open your web browser and navigate to `http://localhost/feedback_form.html`.
2. Fill out the form and submit it.
3. If configured correctly, you should see a success message, and the data should be stored in the database.

### Troubleshooting

1. **PHP Code Displayed Instead of Executed:**
   - Ensure the file has a `.php` extension.
   - Ensure Apache is running.
   - Ensure the file is placed in the `htdocs` directory.

2. **Database Connection Errors:**
   - Ensure MySQL is running.
   - Ensure the database credentials in `submit_feedback.php` are correct.
   - Check the error message for specific issues.

3. **No Data in Database:**
   - Ensure the form uses the `POST` method.
   - Check for errors in the `submit_feedback.php` script.

### Conclusion

By following these instructions, you should have a working feedback form that stores data in a MySQL database. For any issues, ensure all configurations are correct and refer to the troubleshooting section.

---

Feel free to modify this README file according to your specific needs and any additional features you may add to your application.
