<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center">Sign Up</h2>
                        <form id="signupForm" action="signup.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control" name="profile_picture" accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </form>
                        <p class="text-center mt-3">Already have an account? <a href="index.php">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function validateForm() {
            var password = document.getElementById('password').value;
            if (password.length < 6) {
                alert('Password must be at least 6 characters long.');
                return false;
            }
            return true;
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $profile_picture = $_FILES['profile_picture'];

    // Check if email already exists
    $check_email_query = "SELECT email FROM users WHERE email='$email'";
    $result = $conn->query($check_email_query);

    if ($result->num_rows > 0) {
        echo "Email already exists. <a href='index.php'>Login here</a>";
    } else {
        // Handle file upload
        $target_dir = "profile_pictures/";
        
        // Check if directory exists, if not, create it
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $target_file = $target_dir . basename($profile_picture["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($profile_picture["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($profile_picture["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // If everything is ok, try to upload file
        } else {
            if (move_uploaded_file($profile_picture["tmp_name"], $target_file)) {
                $profile_picture_name = $profile_picture["name"];
                $sql = "INSERT INTO users (name, email, password, profile_picture) VALUES ('$name', '$email', '$password', '$profile_picture_name')";

                if ($conn->query($sql) === TRUE) {
                    echo "Registration successful. <a href='index.php'>Login here</a>";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

    $conn->close();
}
?>
