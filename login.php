<?php
// 🚀 WICHTIG: Output-Buffer aktivieren, um unerwartete Ausgaben zu vermeiden
ob_start();
session_start();

// Datenbankverbindung
$host = "db"; // MySQL-Container aus docker-compose.yml
$dbname = "user_database";
$username = "user";
$password = "userpassword";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}

// 🚀 Debugging: Wurde das Formular gesendet?
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = trim($_POST['username'] ?? '');
    $inputPassword = trim($_POST['password'] ?? '');

    // 🚀 Debugging: Zeigt eingegebene Daten (nur für Fehleranalyse)
    error_log("Login-Versuch: Benutzername: $inputUsername");
    
    if (!empty($inputUsername) && !empty($inputPassword)) {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE username = :username");
        $stmt->execute(['username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            error_log("Benutzer gefunden: $inputUsername");

            if (password_verify($inputPassword, $user['password_hash'])) {
                error_log("✅ Passwort korrekt für Benutzer: $inputUsername");
                
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $inputUsername;

                // 🚀 Umleitung zur Startseite des Webservers
                header("Location: /Webserver-main/index.html");
                exit;
            } else {
                error_log("❌ Falsches Passwort für Benutzer: $inputUsername");
                echo "❌ Passwort falsch!";
            }
        } else {
            error_log("❌ Benutzer nicht gefunden: $inputUsername");
            echo "❌ Benutzer nicht gefunden!";
        }
    } else {
        echo "❌ Bitte Benutzername und Passwort eingeben.";
    }
} else {
    error_log("⚠️ Ungültiger Aufruf von login.php");
    echo "⚠️ Diese Seite darf nur per POST aufgerufen werden.";
}

// 🚀 Output-Buffer leeren, um Header-Probleme zu vermeiden
ob_end_flush();
?>
