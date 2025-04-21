<?php
@include 'config.php';

if (isset($_POST['submit'])) {
    // Register new user
    $filter_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $name = mysqli_real_escape_string($conn, $filter_name);
    $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $email = mysqli_real_escape_string($conn, $filter_email);
    $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    $pass = mysqli_real_escape_string($conn, md5($filter_pass));
    $filter_cpass = filter_var($_POST['cpass'], FILTER_SANITIZE_STRING);
    $cpass = mysqli_real_escape_string($conn, md5($filter_cpass));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('Query failed');

    if (mysqli_num_rows($select_users) > 0) {
        
        $message[] = 'User already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password does not match!';
        } else {
            mysqli_query($conn, "INSERT INTO `users`(name, email, password) VALUES ('$name', '$email', '$pass')") or die('Query failed');
            $message[] = 'Registered successfully!';
            header('location:admin_page.php');
            exit;
        }
    }
}

if (isset($_POST['login'])) {
    // User login
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    $check_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'") or die('Query failed');

    if (mysqli_num_rows($check_user) > 0) {
        $message[] = 'Login successful!';
        // You can redirect to dashboard or another page here
    } else {
        $message[] = 'Incorrect email or password!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login and Register Form</title>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>'.$msg.'</span>
            <i class="bx bx-x" onclick="this.parentElement.style.display=`none`;"></i>
        </div>
        ';
    }
}
?>

<div class="container">
    <div class="form-box login">
        <form action="" method="POST">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" name="email" placeholder="Email" required>
                <i class="bx bxs-envelope"></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
                <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="forgot-link">
                <a href="#">Forgot password?</a>
            </div>
            <button type="submit" name="login" class="btn">Login</button>
            <p>or login with social platforms</p>
            <div class="social-icons">
                <a href="#"><i class="bx bxl-google"></i></a>
                <a href="#"><i class="bx bxl-facebook"></i></a>
                <a href="#"><i class="bx bxl-github"></i></a>
                <a href="#"><i class="bx bxl-linkedin"></i></a> 
            </div>
        </form>
    </div>

    <div class="form-box register">
        <form action="" method="POST">
            <h1>Registration</h1>
            <div class="input-box">
                <input type="text" name="name" placeholder="Username" required>
                <i class="bx bxs-user"></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class="bx bxs-envelope"></i>
            </div>
            <div class="input-box">
                <input type="password" name="pass" placeholder="Password" required>
                <i class="bx bxs-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="password" name="cpass" placeholder="Confirm Password" required>
                <i class="bx bxs-lock-alt"></i>
            </div>
            <button type="submit" name="submit" class="btn">Register</button>
            <p>or register with social platforms</p>
            <div class="social-icons">
                <a href="#"><i class="bx bxl-google"></i></a>
                <a href="#"><i class="bx bxl-facebook"></i></a>
                <a href="#"><i class="bx bxl-github"></i></a>
                <a href="#"><i class="bx bxl-linkedin"></i></a> 
            </div>
        </form>
    </div>

    <div class="toggle-box">
        <div class="toggle-panel toggel-left">
            <h1>Hello, Welcome!</h1>
            <p>Don't have an account?</p>
            <button class="btn register-btn">Register</button>
        </div>
        <div class="toggle-panel toggel-right">
            <h1>Hello, Welcome!</h1>
            <p>Already have an account?</p>
            <button class="btn login-btn">Login</button>
        </div>
    </div>
</div>

<script src="js/script.js"></script>
</body>
</html>
