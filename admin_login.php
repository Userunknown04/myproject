<?php
session_start();
$servername = "localhost";
$db_username = "root";
$db_password = "12345";
$dbname = "librarian_db";


$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $employee_id = $_POST['employee_id'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE employee_id='$employee_id' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['employee_id'] = $employee_id;
        header("Location: admin_dashboard.php");
    } else {
        echo "Invalid employee ID or password";
    }
}

$conn->close();
?>
