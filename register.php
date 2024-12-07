<?php
include('config.php');

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pass = mysqli_real_escape_string($con, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($con, md5($_POST['cpassword']));

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = 'uploaded_img/' . $image;
    } else {
        $image = '';
        $image_size = 0;
    }

    $select = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'User already exists';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password not matched!';
        } elseif ($image_size > 2000000) {
            $message[] = 'Image size is too large';
        } else {
            $insert = mysqli_query($con, "INSERT INTO users(name, email, password, image) 
            VALUES('$name', '$email', '$pass', '$image')") or die("Query failed");

            if ($insert) {
                if (!empty($image)) {
                    move_uploaded_file($image_tmp_name, $image_folder);
                }
                $message[] = 'Registration successful';
                header('Location: login.php');
            } else {
                $message[] = 'Registration failed';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css"> 
</head>
<body>
    <div class="form-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Register Now</h3>
            <?php 
            if (isset($message)) {
                foreach ($message as $msg) {
                    echo '<div class="message">' . $msg . '</div>';
                }
            }
            ?>
            <input type="text" name="name" placeholder="Enter your username" class="box" required>
            <input type="email" name="email" placeholder="Enter your email" class="box" required>
            <input type="password" name="password" placeholder="Enter your password" class="box" required>
            <input type="password" name="cpassword" placeholder="Confirm your password" class="box" required>
            <input type="file" name="image" class="box">
            <input type="submit" name="submit" value="Register Now" class="btn">
            <p>Already have an account? <a href="login.php">Login now</a></p>
        </form>
    </div>
</body>
</html>
