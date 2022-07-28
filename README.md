# Fitness-Tracker
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