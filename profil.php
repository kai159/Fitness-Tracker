<!doctype html>
<html lang="de">

<head>
    <title>Profil</title>
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/navbar.php'; ?>
</head>

<body class="b_body">
    <div class="container mt-5 text-center">
        <h2>Profil ändern</h2>
        <div class="row">            
            <div class="col-lg-5 text-center offset-lg-1">
                <form action="includes/profil.inc.php" method="post">
                    <div class="row">
                        <div class="col-6 offset-3">
                            <label class="form-label fs-5">Passwort &aumlndern</label>
                        </div>
                        <div class="col-6 offset-3">
                            <input class="form-control mt-3 text-center" type="password" name="password_current" placeholder="Aktuelles Passwort" autofocus>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 offset-3">
                            <input class="form-control text-center" type="password" name="password" placeholder="Neues Passwort">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 offset-3">
                            <input class="form-control text-center" type="password" name="password_again" placeholder="Passwort wdh.">
                        </div>
                    </div>
                    <button class="btn btn-primary mt-2" type="submit" name="change_pwd_submit">Passwort &aumlndern</button>
                </form>
            </div>
            <div class="col-lg-5 text-center">
                <form action="includes/profil.inc.php" method="post">
                    <div class="row">
                        <div class="col-6 offset-3">
                            <label class="form-label fs-5">Namen &aumlndern</label>
                        </div>
                        <div class="col-6 offset-3">
                            <input class="form-control mt-3 text-center" type="text" name="name" placeholder="Wunschname" autofocus>
                            <button class="btn btn-primary mt-2" type="submit" name="change_user_submit">Namen &aumlndern</button>
                        </div>
                    </div>
                </form>
            </div>
        <br>
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