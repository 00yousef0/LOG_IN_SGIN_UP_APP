<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)) {
    header('location:login.php');
}
if(isset($_GET['logout'])){
    unset($user_id);
    session_destroy();
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        :root {
            --blue: #3498db;
            --dark-blue: #2980b9;
            --red: #e74c3c;
            --dark-red: #c0392b;
            --black: #333;
            --white: #FFF;
            --light-bg: #eee;
            --box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: var(--light-bg);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: var(--white);
            box-shadow: var(--box-shadow);
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .profile img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        h3 {
            font-size: 22px;
            margin-bottom: 20px;
            color: var(--black);
        }

        .btn, .delete-btn {
            width: 100%;
            border-radius: 5px;
            padding: 15px 20px;
            display: block;
            color: var(--white);
            text-align: center;
            cursor: pointer;
            font-size: 20px;
            margin: 10px 0;
        }

        .btn {
            background-color: var(--blue);
        }

        .btn:hover {
            background-color: var(--dark-blue);
        }

        .delete-btn {
            background-color: var(--red);
        }

        .delete-btn:hover {
            background-color: var(--dark-red);
        }

        p a {
            color: var(--blue);
        }

        p a:hover {
            text-decoration: underline;
        }

        .message {
            margin: 5px 0;
            width: 100%;
            border-radius: 5px;
            padding: 10px;
            text-align: center;
            background-color: var(--white);
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile">
        <?php
        $select = mysqli_query($con , "SELECT * FROM users WHERE id =$user_id")or die("Query Error");
        if(mysqli_num_rows($select) > 0) {
            $fetch = mysqli_fetch_assoc($select);
        }

        if($fetch['image'] == '') {
            echo '<img src="images/360_F_215844325_ttX9YiIIyeaR7Ne6EaLLjMAmy4GvPC69.jpg" alt="Image">';
        } else {
            echo '<img src="uploaded_img/' . $fetch['image'] . '" alt="User Image">';
        }
        ?>

        <h3><?php echo $fetch['name']; ?></h3>
        <a href="update_profile.php" class="btn">Update Profile</a>
        <a href="home.php?logout=<?php echo $user_id;?>" class="delete-btn">LOG OUT</a>
        <p>new <a href="login.php">login</a> or <a href="register.php">register</a></p>
    </div>
</div>

</body>
</html>
