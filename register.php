<?php
// Check if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    // Simple validation
    if (empty($email) || empty($password) || empty($confirm)) {
        exit("All fields are required. <a href='register.html'>Go back</a>");
    }

    if ($password !== $confirm) {
        exit("Passwords do not match. <a href='register.html'>Try again</a>");
    }

    // Check if email already exists
    if (file_exists('users.txt')) {
        $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($users as $user) {
            list($savedEmail) = explode(':', $user);
            if ($savedEmail === $email) {
                exit("Email already registered. <a href='register.html'>Try again</a>");
            }
        }
    }

    // Hash password
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    // Save to file
    $line = $email . ':' . $hashed . "\n";
    file_put_contents('users.txt', $line, FILE_APPEND);

    // Redirect to login page
    header('Location: login.html');
    exit();
} else {
    // Not a POST request
    header('Location: register.html');
    exit();
}
?>
