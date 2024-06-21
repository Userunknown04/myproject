<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: admin_login.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "librarian_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM books";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="button-container">
        <button onclick="location.href='admin_dashboard.php';" class="btn-nav">Back to Dashboard</button>
        <button onclick="location.href='latest_books.php';" class="btn-nav">Latest Books</button>
        <button onclick="location.href='logout.php';" class="btn-nav">Logout</button>
    </div>

    <div class="container">
        <h2>All Books</h2>
        <table>
            <thead>
                <tr>
                    <th>Book ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>ISBN</th>
                    <th>Image</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["book_id"] . "</td>";
                        echo "<td>" . $row["title"] . "</td>";
                        echo "<td>" . $row["author"] . "</td>";
                        echo "<td>" . $row["isbn"] . "</td>";
                        echo "<td><img src='" . $row["image_path"] . "' height='100'></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No books found.</td></tr>";
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
