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

// Handle book deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_book'])) {
    $book_id = $_POST['book_id'];

    // SQL to delete a book from the database
    $sql = "DELETE FROM books WHERE book_id = '$book_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Book deleted successfully";
    } else {
        echo "Error deleting book: " . $conn->error;
    }
}

// Fetch all books to display in a select dropdown for deletion
$sql_select_books = "SELECT book_id, book_name FROM books";
$result = $conn->query($sql_select_books);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="button-container">
        <button onclick="location.href='admin_dashboard.php';" class="btn-nav">Back to Dashboard</button>
        <button onclick="location.href='all_books.php';" class="btn-nav">All Books</button>
        <button onclick="location.href='latest_books.php';" class="btn-nav">Latest Books</button>
    </div>

    <div class="container">
        <h2>Delete Book</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="book_id">Select Book to Delete:</label><br>
            <select id="book_id" name="book_id">
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['book_id'] . "'>" . $row['book_name'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No books found</option>";
                }
                ?>
            </select><br><br>

            <button type="submit" name="delete_book">Delete Book</button>
        </form>
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
