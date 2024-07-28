<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <div class="nav-left">
                <a href="home.php" class="brand">MyBlog</a>
            </div>
            <div class="nav-right">
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="create_post.php" class="nav-link">Create New Post</a>
                    <a href="logout.php" class="nav-link">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="nav-link">Login</a>
                    <a href="register.php" class="nav-link">Register</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <div class="container">
        <aside class="sidebar">
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="explore.php">Explore</a></li>
                <li><a href="notifications.php">Notifications</a></li>
                <li><a href="messages.php">Messages</a></li>
                <li><a href="bookmarks.php">Bookmarks</a></li>
                <li><a href="profile.php">Profile</a></li>
            </ul>
        </aside>
        <main class="content">
            <?php
            $result = $conn->query("SELECT posts.id, title, content, name, profile_picture, (SELECT COUNT(*) FROM likes WHERE likes.post_id = posts.id) as likes, (SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id) as comments FROM posts JOIN users ON posts.author_id = users.id");
            while ($row = $result->fetch_assoc()) {
                echo "<article class='tweet'>";
                echo "<h2 class='tweet-title'>{$row['title']}</h2>";
                echo "<div class='tweet-author'>";
                echo "<img src='profile_pictures/{$row['profile_picture']}' alt='Profile Picture' class='profile-pic'>";
                echo "<span>{$row['name']}</span>";
                echo "</div>";
                echo "<p class='tweet-content'>{$row['content']}</p>";
                echo "<div class='tweet-actions'>";
                echo "<a href='like_post.php?id={$row['id']}' class='tweet-link'>Like ({$row['likes']})</a>";
                echo "<a href='comment_post.php?id={$row['id']}' class='tweet-link'>Comment ({$row['comments']})</a>";
                echo "</div>";
                echo "</article>";
            }
            $conn->close();
            ?>
        </main>
    </div>
</body>
</html>
