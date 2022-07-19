# Fitness-Tracker von Kai Erik Jesse und Dennis Thomas Wach

Für die Benutzung unter einer NICHT XAMPP Umgebung muss man includes/dbcon.inc.php mit passenden Daten füllen:

```php
<?php
$con = mysqli_connect('DATENBANK_IP/localhost', 'DATENBANK_USERNAME', 'DATENBANK_PASSWD', 'DATENBANK_NAME');
```

Import der Datenbank:

- Login mysql:

```sh
mysql -u USERNAME -p
```

- Datenbank erstellen:

```sql
CREATE DATABASE DATENBANK_NAME;
```

mit "exit" die shell verlassen

- import SQL:

```sh
mysql -u USERNAME -p DATENBANK_NAME < export.sql
```

Anmelde Daten des Admin Users im Export:

- Username: "admin"

- Passwort: "adminpasswd"

Live-Demo unter : <https://hosting.iem.thm.de/user/dtwc79/wk1611/>

(Die Live-Demo benutzt ein anderes Admin Passwort)

Bildquelle des Defaultbildes:
<https://unsplash.com/photos/FP7cfYPPUKM>

Bildquelle des Logos/Favicons:
<https://freesvg.org/dumbbell-vector-image>
