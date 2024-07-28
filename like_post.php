<?php
include 'config.php';
session_start();

if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $_GET['id'];

    // Check if user already liked the post
    $check_like = $conn->query("SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id");
    if ($check_like->num_rows == 0) {
        $conn->query("INSERT INTO likes (post_id, user_id) VALUES ($post_id, $user_id)");
    }

    header("Location: homepage.php");
}
?>
