<?php
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
    $name = $_POST['name'];
    $email = $_POST['email'];
    $contact_no = $_POST['contact_no'];
    $department = $_POST['department'];
    $password = $_POST['password'];

    $sql = "INSERT INTO employees (employee_id, name, email, contact_no, department, password) 
            VALUES ('$employee_id', '$name', '$email', '$contact_no', '$department', '$password')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
