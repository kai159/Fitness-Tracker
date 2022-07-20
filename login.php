<!doctype html>
<html lang="de">

<head>
    <title>Login</title>
    <!-- <link rel="stylesheet" href="css/logregdivs.css"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <div class="container mt-5">
        <div class="row">            
            <div class="col-md-6 text-center offset-md-3">
                <h2>Anmeldung</h2>
                <form action="includes/login.inc.php" method="post">
                    <div class="row">
                        <div class="col-6 offset-3">
                            <input class="form-control mt-3 text-center" type="text" name="name" placeholder="Benutzername" autofocus>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 offset-3">
                            <input class="form-control text-center" type="password" name="password" placeholder="Passwort">
                        </div>
                    </div>
                        <button class="btn btn-primary mt-2" type="submit" name="login_submit">Best&aumltigen</button>
                </form>
                <a href="register.php">Registrieren</a>
                <br>
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
        </div>
    </div>
</body>

</html>