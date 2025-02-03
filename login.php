<?php
// 🚀 Fehler-Reporting aktivieren
error_reporting(E_ALL);
ini_set('display_errors', 1);

// **Fix für Header-Probleme**
ob_start();
session_start();

// Verbindung zur MySQL-Datenbank
$host = "db"; // Name des MySQL-Containers in docker-compose.yml
$dbname = "user_database";
$username = "user";
$password = "userpassword";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}

// **POST-Daten abfangen**
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = trim($_POST['username'] ?? '');
    $inputPassword = trim($_POST['password'] ?? '');

    if (!empty($inputUsername) && !empty($inputPassword)) {
        // Benutzer abrufen
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE username = :username");
        $stmt->execute(['username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($inputPassword, $user['password_hash'])) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $inputUsername;

                // **Weiterleitung zum 2. Webserver**
                header("Location: http://mein-2-webserver.local");
                exit;
            } else {
                echo "❌ Passwort falsch!";
            }
        } else {
            echo "❌ Benutzer nicht gefunden!";
        }
    } else {
        echo "❌ Bitte Benutzername und Passwort eingeben.";
    }
}

// **Beende Output-Buffer, um Header-Probleme zu verhindern**
ob_end_flush();
?>
