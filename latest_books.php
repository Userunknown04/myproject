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

$sql = "SELECT book_name, author, image_path FROM books ORDER BY book_id DESC LIMIT 10";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest Books</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="button-container">
        <button onclick="location.href='admin_dashboard.php';" class="btn-nav">Back to Dashboard</button>
        <button onclick="location.href='all_books.php';" class="btn-nav">All Books</button>
        <button onclick="location.href='add_book.html';" class="btn-nav">Add Book</button>
    </div>

    <div class="container">
        <h2>Latest Books</h2>
        <div class="books-grid">
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='book-card'>
                            <img src='" . $row['image_path'] . "' alt='" . $row['book_name'] . "' class='book-image'>
                            <div class='book-info'>
                                <h3>" . $row['book_name'] . "</h3>
                                <p>by " . $row['author'] . "</p>
                            </div>
                          </div>";
                }
            } else {
                echo "<p>No latest books found</p>";
            }
            ?>
        </div>
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
