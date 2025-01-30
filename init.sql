CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Admin-User einfügen (Passwort gehasht mit bcrypt)
INSERT INTO users (username, password_hash)
VALUES ('Admin', '$2y$10$yWm9qv5/hH68ZJ3SmgdpUuvS/iAE8JB9hHp54QOpVle2NDGc9WJ6m')
ON DUPLICATE KEY UPDATE password_hash=VALUES(password_hash);
