<!doctype html>
<html lang="de">

<head>
    <script src="js/search.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./css/logo.css" />
    <link rel="stylesheet" href="./css/navbar.css" />
    <link rel="icon" href="./svg/dumbell.svg" />
    <?php include 'login_session.php'; ?>
</head>

<body>
    <header>
        <?php
        if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'register.php' && basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'login.php') {
        echo '
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Training
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="training.php">Übersicht</a></li>
                        <li><a class="dropdown-item" href="training_overview.php">Alle Trainings</a></li>
                        <li><a class="dropdown-item" href="training_create.php">Training erstellen</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        &Uumlbungen
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="exercise.php">Übersicht</a></li>
                        <li><a class="dropdown-item" href="exercise_create.php">Übung erstellen</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link logged_in">'. $_SESSION['user'] .'</a>
                </li>';
                if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) == 'exercise.php' 
                || basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) == 'training_overview.php') {
                    echo '<input id="search" size="9" onkeyup="search()" type="text" name="search" placeholder="Suche" autofocus>';
                    }
                echo '
                    <li class="nav-item">
                        <a class="nav-link" href="profil.php">Profil</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="includes/logout.inc.php">Ausloggen</a>
                    </li>
                </nav>
            <header>';
        }
    


        // <a class="logged_in"> Eingeloggt als: ' . $_SESSION['user'] . '</a>';
        //     if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) == 'exercise.php' || basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) == 'training_overview.php') {
        //         echo ' <input id="search" size="9" onkeyup="search()" type="text" name="search" placeholder="Suche" autofocus class="nav_searchbar">
        // <a class="nav_item" href="profil.php">Profil</a> <a class="nav_item last_item" href="includes/logout.inc.php">Ausloggen</a></div>';
        //     } else {
        //         echo '<a class="nav_item right" href="profil.php">Profil</a> <a class="nav_item last_item" href="includes/logout.inc.php">Ausloggen</a></div>';
        //     }
        // }
        ?>
    </header>
</body>

</html>