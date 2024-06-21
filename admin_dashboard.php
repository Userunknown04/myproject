<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: admin_login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <div class="button-container">
        <button onclick="location.href='all_books.php';" class="btn-nav">All Books</button>
        <button onclick="location.href='add_book.php';" class="btn-nav">Add Book</button>
        <button onclick="location.href='delete_book.php';" class="btn-nav">Delete Book</button>
        <button onclick="location.href='transactions.php';" class="btn-nav">Transactions</button>
        <button onclick="location.href='latest_books.php';" class="btn-nav">Latest Books</button>
        <button onclick="location.href='logout.php';" class="btn-nav">Logout</button>
    </div>

    <script>
        function scrollToSection(sectionId) {
            document.getElementById(sectionId).scrollIntoView({ behavior: 'smooth' });
        }
    </script>
</body>
</html>
