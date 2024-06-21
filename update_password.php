<?php
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "librarian_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];

    $sql = "SELECT * FROM employees WHERE username='$user' AND password='$old_pass'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $update_sql = "UPDATE employees SET password='$new_pass' WHERE username='$user'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Password updated successfully";
        } else {
            echo "Error updating password: " . $conn->error;
        }
    } else {
        echo "Invalid username or password";
    }
}

$conn->close();
?>
