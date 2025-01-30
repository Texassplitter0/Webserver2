<?php
// Verhindert Probleme mit bereits gesendeten Headers
ob_start();
session_start();

// Verbindung zur MySQL-Datenbank
$host = "db"; // Name des MySQL-Containers aus docker-compose.yml
$dbname = "user_database";
$username = "user";
$password = "userpassword";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}

// Überprüfung der Benutzerdaten
$inputUsername = trim($_POST['username'] ?? '');
$inputPassword = trim($_POST['password'] ?? '');

if (!empty($inputUsername) && !empty($inputPassword)) {
    $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE username = :username");
    $stmt->execute(['username' => $inputUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($inputPassword, $user['password_hash'])) {
        // Login erfolgreich, Session setzen
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $inputUsername;

        // Weiterleitung zur Startseite des Webservers
        header("Location: /Webserver-main/index.html");
        exit;
    } else {
        echo "Falscher Benutzername oder Passwort.";
    }
} else {
    echo "Bitte Benutzername und Passwort eingeben.";
}

// Beendet den Output-Buffer, um Header-Probleme zu vermeiden
ob_end_flush();
?>
