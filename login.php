<?php
session_start();

// Datenbankverbindung herstellen
$host = "db"; // Name des MySQL-Containers (laut docker-compose.yml)
$dbname = "user_database";
$username = "user";
$password = "userpassword";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Verbindung zur Datenbank fehlgeschlagen: " . $e->getMessage());
}

// Benutzerdaten aus Formular holen
$inputUsername = $_POST['username'] ?? '';
$inputPassword = $_POST['password'] ?? '';

// Benutzer in der Datenbank suchen
$stmt = $pdo->prepare("SELECT password_hash FROM users WHERE username = :username");
$stmt->execute(['username' => $inputUsername]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($inputPassword, $user['password_hash'])) {
    // Erfolgreicher Login
    $_SESSION['loggedin'] = true;
    $_SESSION['username'] = $inputUsername;

    // Weiterleitung zum Webserver
    header("Location: /Webserver-main/welcome.html");
    exit;
} else {
    echo "Falscher Benutzername oder Passwort.";
}
?>
