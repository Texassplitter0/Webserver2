
<?php
session_start();

// Simulate a simple login mechanism (adjust to real DB connection if needed)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Hardcoded credentials for demo purposes (replace with DB validation)
    if ($username === 'user' && $password === 'pass') {
        $_SESSION['loggedin'] = true;
        header('Location: /dashboard.html'); // Redirect to dashboard or main app
        exit;
    } else {
        echo 'Invalid credentials';
    }
} else {
    echo 'Unauthorized access';
}
?>
