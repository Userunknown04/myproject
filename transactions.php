<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "librarian_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all transactions
$sql = "SELECT t.transaction_id, t.book_id, b.book_name, t.employee_id, e.name as employee_name, 
        t.transaction_type, t.transaction_date 
        FROM transactions t 
        JOIN books b ON t.book_id = b.book_id 
        JOIN employees e ON t.employee_id = e.employee_id 
        ORDER BY t.transaction_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="button-container">
        <button onclick="location.href='admin_dashboard.php';" class="btn-nav">Back to Dashboard</button>
    </div>

    <div class="container">
        <h2>Transactions</h2>
        <table>
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Book ID</th>
                    <th>Book Name</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Type</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['transaction_id']}</td>
                                <td>{$row['book_id']}</td>
                                <td>{$row['book_name']}</td>
                                <td>{$row['employee_id']}</td>
                                <td>{$row['employee_name']}</td>
                                <td>{$row['transaction_type']}</td>
                                <td>{$row['transaction_date']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No transactions found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
