<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $post_id = $_POST['post_id'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO comments (post_id, author_id, content) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $post_id, $author_id, $content);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: index.php");
}
?>
