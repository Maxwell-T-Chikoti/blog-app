<?php
include 'config.php';
session_start();

if (isset($_SESSION['user_id']) && isset($_POST['comment']) && isset($_GET['id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $_GET['id'];
    $comment = $_POST['comment'];

    $conn->query("INSERT INTO comments (post_id, user_id, comment) VALUES ($post_id, $user_id, '$comment')");

    header("Location: homepage.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Comment on Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="comment_post.php?id=<?php echo $_GET['id']; ?>" method="post">
        <textarea name="comment" required></textarea>
        <button type="submit">Post Comment</button>
    </form>
</body>
</html>
