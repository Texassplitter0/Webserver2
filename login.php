<?php
// Start output buffering to prevent premature output
ob_start();
session_start(); 

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection setup
$host = "db"; 
$dbname = "user_database";
$username = "user";
$password = "userpassword";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}

// Process login only on POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = trim($_POST['username'] ?? '');
    $inputPassword = trim($_POST['password'] ?? '');

    if (!empty($inputUsername) && !empty($inputPassword)) {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE username = :username");
        $stmt->execute(['username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($inputPassword, $user['password_hash'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $inputUsername;
            
            // Redirect properly using header() instead of echoing JavaScript
            header("Location: /Webserver-main/index.html");
            exit;
        } else {
            echo "❌ Benutzername oder Passwort falsch!";
        }
    } else {
        echo "❌ Bitte Benutzername und Passwort eingeben.";
    }
} else {
    echo "⚠️ Ungültiger Zugriff auf login.php";
}

ob_end_flush(); // Flush buffer at the very end
?>
