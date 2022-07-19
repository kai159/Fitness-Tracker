<!doctype html>
<html lang="de">

<head>
    <title>Übungen</title>
    <link rel="stylesheet" href="css/alternate.css">
    <link rel="stylesheet" href="css/show_form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/exercise.js"></script>
    <script src="js/show_form.js"></script>
    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <?php
    if (isset($_GET['name'])) {
        echo '<h2 style="text-align: center;">Übung</h2>';
    } else {
        echo '<h2 style="text-align: center;">Alle Übungen</h2>';
    }

    ?>
    <div class="main">
        <?php

        include 'includes/functions.php';
        $result = get_exercises();
        if ($result->num_rows > 0) {
            $result_training = get_all_training_id_name();

            while ($row = $result->fetch_assoc()) {
                echo '<div class="element">
            <div class="searchable">';
                if (isset($_GET['name'])) {
                    echo '<h3>' . $row['name'] . '</h3>';
                } else {
                    echo '<h3><a class="col_blue" href="exercise.php?name=' . $row['name'] . '">' . $row['name'] . '</a></h3>';
                }
                echo '
            <p>' . $row['description'] . '</p>';
                if (isset($_GET['name']) and (($row['fk_user'] == $_SESSION['id']) or ($_SESSION['user'] == 'admin'))) {
                    echo '<div class="div_left2right">
                    <a class="col_blue" href="javascript:show_form_desc();">Beschreibung ändern</a>
                    <form class="form_desc"enctype="multipart/form-data" action="includes/exercise.inc.php" method="post">
                    <input type="text" name="changed_descr" placeholder="Beschreibung ändern"> <br>
                    <input type="hidden" name="name_ex" value="' . $row['name'] . '">
                    <input type="hidden" name="id_ex" value="' . $row['id'] . '">
                    <button type="submit" name="update_descr">Ändern</button> <br>
                    </form></div>
                    ';
                }
                echo '
            </div>
            <img style="width:400px; height:150px;" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/> <br>';
                if (isset($_GET['name']) and (($row['fk_user'] == $_SESSION['id']) or ($_SESSION['user'] == 'admin'))) {
                    echo '<div class="div_left2right">
                <a class="col_blue" href="javascript:show_form_img();">Bild ändern</a>
                <form class="form_img"enctype="multipart/form-data" action="includes/exercise.inc.php" method="post">
                <label for="file">Wählen Sie ein Bild aus:</label><br>
                <input name="file" id="file" type="file" accept=".jpg, .jpeg, .png" style="margin-top:5px;border:none;" /> <br>
                <input type="hidden" name="name_ex" value="' . $row['name'] . '">
                <input type="hidden" name="id_ex" value="' . $row['id'] . '">
                <button type="submit" name="update_img">Ändern</button> <br>
                </form></div>
                ';
                }
                echo '
            <form>        
            <select id="select_' . $row['id'] . '" name="option_training">    
            <label for="training"></label>';
                foreach ($result_training as $row_training) {
                    if ($_SESSION['tid'] != $row_training['id']) {
                        echo '<option value="' . $row_training['id'] . '">' . $row_training['name'] . '</option>';
                    } else {
                        echo '<option selected="selected" value="' . $row_training['id'] . '">' . $row_training['name'] . '</option>';
                    }
                }
                echo '        
            </select> <br>
            <input type="hidden" name="name_ex" value="' . $row['id'] . '">
            <button  id="' . $row['id'] . '" onClick="training_add_submit(this.id)" name="training_add" type="button">Hinzufügen</button>
            </form>';
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
                        case 'success':
                            echo '<p>Operation erfolgreich ausgeführt<p>';
                            break;
                        case 'format':
                            echo '<p>Falsches Format<p>';
                            break;
                        case 'size':
                            echo '<p>Bild zu Groß!<p>';
                            break;
                        case 'error':
                            echo '<p>Fehler, Bitte ein Bild hochladen!<p>';
                            break;
                        case 'long':
                            echo '<p>Eingabe zu lang!<p>';
                            break;
                    }
                }
                echo '</div>';
            }
        } else {
            echo '<p>Bitte legen Sie zunächst eine Übung an.
        Diese finden Sie unter Übungen => <a class="col_blue" href="exercise_create.php">Übung</a> erstellen.</p>';
        }
        ?>
    </div>
</body>

</html>