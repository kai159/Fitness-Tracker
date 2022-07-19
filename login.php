<!doctype html>
<html lang="de">

<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/logregdivs.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <div class="center borderpadding">
        <h2>Anmeldung</h2>
        <form action="includes/login.inc.php" method="post">
            <input type="text" name="name" placeholder="Benutzername" autofocus><br>
            <input type="password" name="password" placeholder="Passwort"> <br>
            <button type="submit" name="login_submit">Best&aumltigen</button> <br>
        </form>
        <a class="col_blue" href="register.php">Registrieren</a>
        <?php
        // Fehlermeldungen
        isset($_GET['ms']) ? $message = $_GET['ms'] : $message = '';
        if ($message !== '') {
            switch ($message) {
                case 'empty':
                    echo '<p>Eingabefelder sind unvollständig</p>';
                    break;
                case 'db';
                    echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                    break;
                case 'wrong';
                    echo '<p>Falsche Anmeldedaten</p>';
                    break;
                case 'notfound';
                    echo '<p>Benutzer existiert nicht</p>';
                    break;
            }
        }
        ?>
    </div>
</body>

</html>