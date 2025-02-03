<?php
// 🚀 Fehler abfangen & Debugging aktivieren
ini_set('display_errors', 1);
error_reporting(E_ALL);
ob_start();
session_start();

// 🚀 Verbindung zur MySQL-Datenbank
$host = "db";  // WICHTIG: Name des MySQL-Containers aus docker-compose.yml
$dbname = "user_database";
$username = "user";
$password = "userpassword";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("❌ Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}

// 🚀 Debugging: POST-Daten ausgeben
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = trim($_POST['username'] ?? '');
    $inputPassword = trim($_POST['password'] ?? '');

    echo "📌 Debug: Benutzername: $inputUsername <br>";
    echo "📌 Debug: Passwort: $inputPassword <br>";

    if (!empty($inputUsername) && !empty($inputPassword)) {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE username = :username");
        $stmt->execute(['username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "✅ Benutzer gefunden: $inputUsername <br>";

            if (password_verify($inputPassword, $user['password_hash'])) {
                echo "✅ Passwort korrekt. Setze Session... <br>";
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $inputUsername;

                // 🚀 Weiterleitung zur Hauptseite
                echo "<script>window.location.href='/Webserver-main/index.html';</script>";
                exit;
            } else {
                echo "❌ Passwort falsch! <br>";
            }
        } else {
            echo "❌ Benutzer nicht gefunden! <br>";
        }
    } else {
        echo "❌ Bitte Benutzername und Passwort eingeben. <br>";
    }
} else {
    echo "⚠️ Ungültiger Zugriff auf login.php <br>";
}

// 🚀 Output-Buffer leeren
ob_end_flush();
?>
