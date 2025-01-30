<?php
ob_start();
session_start();

$host = "db";
$dbname = "user_database";
$username = "user";
$password = "userpassword";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Datenbankverbindung fehlgeschlagen: " . $e->getMessage());
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $inputUsername = trim($_POST['username'] ?? '');
    $inputPassword = trim($_POST['password'] ?? '');

    echo "Benutzername: $inputUsername <br>";
    echo "Passwort: $inputPassword <br>";

    if (!empty($inputUsername) && !empty($inputPassword)) {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE username = :username");
        $stmt->execute(['username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            echo "Benutzer gefunden! Prüfe Passwort...<br>";
            if (password_verify($inputPassword, $user['password_hash'])) {
                echo "✅ Passwort korrekt. Weiterleitung...";
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $inputUsername;
                header("Location: /Webserver-main/index.html");
                exit;
            } else {
                echo "❌ Passwort falsch!";
            }
        } else {
            echo "❌ Benutzer nicht gefunden!";
        }
    } else {
        echo "❌ Bitte alle Felder ausfüllen.";
    }
}

ob_end_flush();
?>
