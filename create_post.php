<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO posts (title, content, author_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $title, $content, $author_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <h2>Create Post</h2>
    <form action="create_post.php" method="post">
        <label>Title: <input type="text" name="title" required></label><br>
        <label>Content: <textarea name="content" required></textarea></label><br>
        <button type="submit">Create Post</button>
    </form>
    <a href="homepage.php">Back to Home</a>
</body>
</html>
