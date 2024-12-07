<?php
include 'config.php';
session_start();

if(!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    if ($image != '') {
        move_uploaded_file($image_tmp, $image_folder);
        $query = "UPDATE users SET name='$name', email='$email', image='$image' WHERE id=$user_id";
    } else {
        $query = "UPDATE users SET name='$name', email='$email' WHERE id=$user_id";
    }

    mysqli_query($con, $query);
    header('Location: home.php');
}

$select = mysqli_query($con, "SELECT * FROM users WHERE id = $user_id");
$fetch = mysqli_fetch_assoc($select);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .update-profile-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .profile-img img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        input[type="text"], input[type="email"], input[type="file"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #3498db;
            color: #fff;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .logout-btn {
            background-color: #e74c3c;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="update-profile-container">
        <form action="" method="post" enctype="multipart/form-data">
            <h3>Update Profile</h3>
            <div class="profile-img">
                <?php
                    if ($fetch['image'] == '') {
                        echo '<img src="images/360_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg" alt="Default Image">';
                    } else {
                        echo '<img src="uploaded_img/' . $fetch['image'] . '" alt="User Image">';
                    }
                ?>
            </div>
            <input type="text" name="name" value="<?php echo $fetch['name']; ?>" required>
            <input type="email" name="email" value="<?php echo $fetch['email']; ?>" required>
            <input type="file" name="image">
            <input type="submit" name="update" value="Update Profile" class="btn">
        </form>
        <a href="home.php" class="btn logout-btn">Back to Home</a>
    </div>
</body>
</html>
