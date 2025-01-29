# Webserver

## Überblick
Dies ist ein einfacher Webserver, der ein Frontend für eine Webanwendung bereitstellt. Das Projekt umfasst mehrere HTML-Seiten, ein Stylesheet und verschiedene Ressourcen wie Bilder. Es ist für die Bereitstellung über Docker konfiguriert.

## Enthaltene Features
- **Mehrere HTML-Seiten**:
  - `index.html`: Startseite
  - `login.html`: Login-Seite
  - `registration.html`: Registrierungsseite
  - Weitere Seiten für spezifische Inhalte wie `memecoin.html`, `minecraft.html`, etc.
- **CSS-Stylesheet**: Enthält das Design für die gesamte Anwendung.
- **Bilder**: Verschiedene Hintergrundbilder und Ressourcen für die Webseiten.
- **Docker-Unterstützung**: Bereitstellung des Webservers über Docker.

## Voraussetzungen
- [Docker](https://www.docker.com/) muss auf dem System installiert sein.
- Optional: Ein lokaler Webserver wie Apache oder Nginx zur direkten Bereitstellung ohne Docker.

## Installation
### Mit Docker
1. Stellen Sie sicher, dass Docker installiert ist.
2. Klonen Sie das Repository oder entpacken Sie die Dateien.
3. Führen Sie den folgenden Befehl aus, um den Webserver zu starten:
   ```bash
   docker-compose up -d
   ```
4. Der Webserver ist nun unter `http://localhost:80` erreichbar.

### Ohne Docker
1. Kopieren Sie alle Dateien in einen lokalen Webserver-Ordner (z. B. `/var/www/html/` für Apache).
2. Starten Sie den Webserver.
3. Navigieren Sie zu `http://localhost/`, um die Anwendung anzuzeigen.

## Projektstruktur
```
Project/
|— docker-compose.yml         # Docker-Compose-Konfigurationsdatei
|— Dockerfile                 # Dockerfile für den Webserver
|— styles.css                # Hauptstylesheet
|— *.html                    # HTML-Dateien
|— images/                   # Bilderressourcen
```

## Anpassungen
- **HTML**: Sie können die HTML-Seiten direkt bearbeiten, um Inhalte anzupassen.
- **CSS**: Styles über die Datei `styles.css` anpassen.
- **Docker**: Aktualisieren Sie die `Dockerfile` oder `docker-compose.yml`, um benutzerdefinierte Einstellungen vorzunehmen.

## Lizenz
Dieses Projekt steht unter keiner spezifischen Lizenz und kann frei verwendet werden.

