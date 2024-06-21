<?php
session_start();
if (!isset($_SESSION['employee_id'])) {
    header("Location: admin_login.html");
    exit();
}

// Assuming you have a database connection already established
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "librarian_db";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_name = $_POST['book_name'];
    $author = $_POST['author'];
    $category = $_POST['category'];
    $publisher = $_POST['publisher'];

    // Upload image handling
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Upload the file if everything is ok
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
            
            // Insert book into database
            $sql = "INSERT INTO books (book_name, author, category, image_path, publisher) 
                    VALUES ('$book_name', '$author', '$category', '$target_file', '$publisher')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="styles1.css">
</head>
<body>
    <div class="button-container">
        <button onclick="location.href='admin_dashboard.php';" class="btn-nav">Back to Dashboard</button>
        <button onclick="location.href='latest_books.php';" class="btn-nav">Latest Books</button>
    </div>

    <div class="container">
        <h2>Add Book</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="book_name">Book Name:</label><br>
            <input type="text" id="book_name" name="book_name" required><br><br>

            <label for="author">Author:</label><br>
            <input type="text" id="author" name="author" required><br><br>

            <label for="category">Category:</label><br>
            <input type="text" id="category" name="category" required><br><br>

            <label for="publisher">Publisher:</label><br>
            <input type="text" id="publisher" name="publisher" required><br><br>

            <label for="image">Select Image:</label><br>
            <input type="file" id="image" name="image" accept="image/*" required><br><br>

            <button type="submit" name="submit">Add Book</button>
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
