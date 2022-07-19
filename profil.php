<!doctype html>
<html lang="de">

<head>
    <title>Profil</title>
    <link rel="stylesheet" href="css/logregdivs.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <div class="center borderpadding" style="top: 40%;">
        <h2>Profil ändern</h2>
        <form action="includes/profil.inc.php" method="post">
            <button type="submit" name="change_pwd_submit">Passwort &aumlndern</button>
            <input type="password" name="password_current" placeholder="Aktuelles Passwort" value="">
            <input type="password" name="password" placeholder="Neues Passwort" value="">
            <input type="password" name="password_again" placeholder="Passwort wdh." value=""> <br>
        </form>
        <form action="includes/profil.inc.php" method="post">
            <button type="submit" name="change_user_submit">Namen &aumlndern</button>
            <input type="text" name="name" placeholder="Wunschname" value="">
        </form>

        <?php
        // Fehlermeldungen
        isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
        if ($message !== '') {
            switch ($message) {
                case 'empty':
                    echo '<p>Eingabefelder sind unvollständig</p>';
                    break;
                case 'even':
                    echo '<p>Passwörter stimmen nicht überein</p>';
                    break;
                case 'db';
                    echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                    break;
                case 'taken';
                    echo '<p>Benutzer ' . $_GET['name'] . ' ist vergeben </p>';
                    break;
                case 'success':
                    echo '<p>Operation erfolgreich ausgeführt<p>';
                    break;
                case 'wrong':
                    echo '<p>Aktuelles Passwort falsch<p>';
                    break;
            }
        }
        ?>
    </div>
</body>

</html>