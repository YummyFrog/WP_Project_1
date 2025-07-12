<?php
session_start();

// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate
    if (empty($email) || empty($password)) {
        exit("All fields are required. <a href='login.html'>Go back</a>");
    }

    if (!file_exists('users.txt')) {
        exit("No users registered yet. <a href='register.html'>Register here</a>");
    }

    $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($users as $user) {
        list($savedEmail, $savedHash) = explode(':', $user, 2);
        $savedEmail = trim($savedEmail);
        
        if ($savedEmail === $email) {
            if (password_verify($password, $savedHash)) {
                // Correct login
                $_SESSION['email'] = $email;
                header('Location: menu.php');
                exit();
            } else {
                exit("Incorrect password. <a href='login.html'>Try again</a>");
            }
        }
    }

    // If no email matched
    exit("Email not found. <a href='register.html'>Register here</a>");
} else {
    // Not a POST request
    header('Location: login.html');
    exit();
}
?>
