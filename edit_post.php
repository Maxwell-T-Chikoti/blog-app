<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: index.php");
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT title, content FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($title, $content);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Edit Post</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h2>Edit Post</h2>
    <form action="edit_post.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label>Title: <input type="text" name="title" value="<?php echo $title; ?>" required></label><br>
        <label>Content: <textarea name="content" required><?php echo $content; ?></textarea></label><br>
        <button type="submit">Update Post</button>
    </form>
    <a href="index.php">Back to Home</a>
</body>
</html>
