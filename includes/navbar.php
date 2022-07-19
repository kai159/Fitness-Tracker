<!doctype html>
<html lang="de">

<head>
    <script src="js/search.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="./css/logo.css" />
    <link rel="stylesheet" href="./css/navbar.css" />
    <link rel="icon" href="./svg/dumbell.svg" />
    <?php include 'login_session.php'; ?>
</head>

<body>
    <header>
        <div class="logo_container">
            <div class="logo_item">
                <img style="transform: rotate(-30deg)" src="./svg/dumbell.svg" width="100" height="75" />
            </div>
            <div class="logo_item">
                <h1>Fitness-Tracker</h1>
            </div>
            <div class="logo_item">
                <img style="transform: rotate(30deg)" src="./svg/dumbell.svg" width="100" height="75" />
            </div>
        </div>
        <?php
        if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'register.php' && basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'login.php') {

            echo '
            <div class="nav_container">
                <div class="training_item nav_item">
                <a>Training</a>
                <div class="training_dropdown">
                    <a class="nav_item" href="training.php">Übersicht</a>
                    <a class="nav_item" href="training_overview.php">Alle Trainings</a>
                    <a class="nav_item" href="training_create.php">Training erstellen</a>
                </div>
            </div>
        <div class="uebung_item nav_item">
            <a>&Uumlbungen</a>
            <div class="uebung_dropdown">
                <a class="nav_item" href="exercise.php">Übersicht</a>
                <a class="nav_item" href="exercise_create.php">Übung erstellen</a>
            </div>
        </div>
        <a class="logged_in"> Eingeloggt als: ' . $_SESSION['user'] . '</a>';
            if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) == 'exercise.php' || basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) == 'training_overview.php') {
                echo ' <input id="search" size="9" onkeyup="search()" type="text" name="search" placeholder="Suche" autofocus class="nav_searchbar">
        <a class="nav_item" href="profil.php">Profil</a> <a class="nav_item last_item" href="includes/logout.inc.php">Ausloggen</a></div>';
            } else {
                echo '<a class="nav_item right" href="profil.php">Profil</a> <a class="nav_item last_item" href="includes/logout.inc.php">Ausloggen</a></div>';
            }
        }
        ?>
    </header>
</body>

</html>