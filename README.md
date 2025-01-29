# Path to the README file
readme_path = os.path.join(new_extraction_path, 'README.md')

# Updated content for the README file
readme_content = """
# Projekt: Gamerdiver Community Portal

## Übersicht
Dieses Projekt enthält ein Webportal für die Gamerdiver-Community. Es bietet einen Einstiegspunkt (`welcome.html`), der zu einem Webserver (`Webserver-main`) umleitet. Der Webserver bietet Inhalte wie Community-Seiten, Login- und Registrierungsmöglichkeiten.

## Projektstruktur
- **welcome.html**: Die Startseite des Projekts.
- **Webserver-main**: Enthält den Hauptinhalt und die Login-Mechanismen.
- **Dockerfile**: Baut das Docker-Image für den Webserver.
- **docker-compose.yml**: Startet den Webserver und eine MySQL-Datenbank.

## Anforderungen
- Docker
- Docker Compose

## Installation und Nutzung
1. Klone dieses Repository oder lade es als ZIP-Datei herunter und entpacke es.
2. Stelle sicher, dass Docker und Docker Compose auf deinem System installiert sind.
3. Baue und starte die Container mit:
   ```bash
   docker-compose up --build
