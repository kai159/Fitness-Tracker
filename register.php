<!doctype html>
<html lang="de">

<head>
    <title>Registrieren</title>
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'includes/navbar.php'; ?>
</head>

<body class="b_body">

    <div class="container mt-5">
        <div class="row">            
            <div class="col-md-6 text-center offset-md-3">
                <h2>Registrierung</h2>
                <form action="includes/register.inc.php" method="post">
                    <div class="row">
                        <div class="col-6 offset-3">
                            <?php
                            if (!isset($_GET['name'])) {
                                echo '<input class="form-control mt-3 text-center" type="text" name="name" placeholder="Benutzername" autofocus>';
                            } else {
                                echo '<input class="form-control mt-3 text-center" type="text" name="name" value="' . $_GET['name'] . '" autofocus>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 offset-3">
                            <input class="form-control text-center" type="password" name="password" placeholder="Passwort">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-6 offset-3">
                            <input class="form-control text-center" type="password" name="password_again" placeholder="Passwort wdh.">
                        </div>
                    </div>
                        <button class="btn btn-primary mt-2" type="submit" name="register_submit">Best&aumltigen</button>
                </form>
                <a class="col_blue" href="login.php">Zurück</a>
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
                            echo '<p>Passwort stimmt nicht überein</p>';
                            break;
                        case 'db';
                            echo '<p>Fehler an der Datenbank. Bitte versuchen Sie es später erneut</p>';
                            break;
                        case 'taken';
                            echo '<p>Benutzer ist vergeben </p>';
                            break;
                        case 'fail';
                            echo '<p>Bitte versuchen Sie es später erneut</p>';
                            break;
                    }
                }
                ?>                
            </div>
        </div>
    </div>
</body>

</html>