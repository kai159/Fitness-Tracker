<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
?>
<?php include 'login_session.php'; ?>
<!doctype html>
<html lang="de">

<head>
    <script src="js/search.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
        .b_nav{
            background: rgb(0,0,0);
            background: linear-gradient(31deg, rgba(0,0,0,1) 0%, rgba(87,87,87,1) 91%);
        }
    </style>
</head>

<body >
    <header>
        <?php
        if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'register.php' && basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'login.php') {
        echo '
        <nav class="navbar navbar-expand-lg navbar-dark b_nav">
            <div class="container-fluid">
                <a class="navbar-brand" href="training.php">Fitness-Tracker</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
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
                    </ul>
                </div>
            </div>
        </nav>';       
        }
    

        ?>
    </header>
</body>

</html>