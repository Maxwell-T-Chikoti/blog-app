<?php
include 'config.php';
session_start();

$post_id = $_GET['id'];
$stmt = $conn->prepare("SELECT title, content FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$stmt->bind_result($title, $content);
$stmt->fetch();
$stmt->close();

$comments_result = $conn->query("SELECT name, content FROM comments JOIN users ON comments.author_id = users.id WHERE post_id = $post_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Post Details</title>
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <p><?php echo $content; ?></p>

    <h2>Comments</h2>
    <?php while ($row = $comments_result->fetch_assoc()): ?>
        <p><strong><?php echo $row['name']; ?>:</strong> <?php echo $row['content']; ?></p>
    <?php endwhile; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <form action="add_comment.php" method="post">
            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
            <label>Comment: <textarea name="content" required></textarea></label><br>
            <button type="submit">Add Comment</button>
        </form>
    <?php else: ?>
        <p>You need to <a href="login.php">login</a> to comment.</p>
    <?php endif; ?>

    <a href="index.php">Back to Home</a>
</body>
</html>
