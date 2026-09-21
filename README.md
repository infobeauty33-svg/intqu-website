# IntQu.net – International Quality Network

PHP-Website für das Beauty-Netzwerk. Enthält Startseite, Mitglieds-/Partneranfragen und den NEXA-Showroom.

## Betrieb

- PHP 8.2 oder neuer mit PDO SQLite, Fileinfo und GD (für Foto-Uploads).
- HTTPS verwenden; Webroot ist dieses Verzeichnis. GitHub Pages führt PHP nicht aus.
- `INTQU_SETUP_KEY` serverseitig als Umgebungsvariable setzen: mindestens 32 zufällige Zeichen. Keine Schlüssel oder Passwörter in Git eintragen. Der zuvor im ZIP enthaltene Schlüssel ist zu ersetzen.
- Der Server benötigt Schreibrechte im übergeordneten Verzeichnis für den bestehenden privaten Speicher `.intqu-private-*`. Dieser darf nicht über andere Webroots erreichbar sein. Bei einem vorhandenen Betrieb denselben absoluten PHP-Pfad und Speicher beibehalten; vor Umzügen Daten sichern und separat migrieren.
- `/intqu-anmeldung.php?setup=1` öffnen und mit dem neuen Schlüssel ein Verwaltungspasswort einrichten. Bei bestehender Einrichtung bleibt das Verwaltungspasswort erhalten.
- Unter `?admin=1` Datenschutzhinweise und Ablauf vervollständigen, Formular testen und freigeben. Ohne Server-Schlüssel bleibt das Formular geschlossen. Bestehende Freigabeeinstellungen werden nicht geändert.
- Anfragen werden intern gespeichert; es gibt keinen automatischen Mailversand oder öffentliche Mitgliederprofile.

## Änderungen

Klarerer Community-Einstieg, getrennte Mitglieds- und Partnerwege, Showroom früh sichtbar, kürzere Navigation und Entfernung doppelter Angebotsübersichten. Bestehende Farben, Marke und Inhalte zu Cleopatra Marinescu bleiben erhalten. Geplante Funktionen sind als solche gekennzeichnet. Eingebettete Bilder und Schriften liegen dedupliziert in `assets/`.

Das NEXA-Anwendungsfoto fehlte im ZIP und konnte von der Live-Seite nicht abgerufen werden. Bis zur Bereitstellung des Originalfotos verwenden Startseite und Showroom eine Textfläche. Das vorhandene Porträt wird wiederverwendet.

## Prüfung und Veröffentlichung

Statisch geprüft: lokale Links und Bildpfade vorhanden, keine doppelten HTML-IDs. Browserprüfung noch offen: In der Arbeitsumgebung fehlt ein Chromium-Browser. PHP-Prüfung noch offen: PHP ist dort nicht installiert. Frontend auf Desktop und Mobilgeräten vor Live-Schaltung prüfen. Für den Server: `php -l index.php`, `php -l intqu-anmeldung.php`, `php -l showroom/nexa-uv-system/index.php` sowie Einrichtung, Mitglieds-/Partneranfrage, NEXA/Event-Anfrage und Foto-Upload in einer isolierten Testumgebung prüfen.

Ein GitHub-Commit allein veröffentlicht diese Website nicht auf IntQu.net. Ein Hosting-Deployment ist hier nicht eingerichtet.
