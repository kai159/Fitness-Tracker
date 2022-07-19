<!doctype html>
<html lang="de">

<head>
    <title>Training Starten</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/alternate.css">
    <link rel="stylesheet" href="css/training.css">
    <link rel="stylesheet" href="css/show_form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/show_form.js"></script>
    <?php include 'includes/navbar.php'; ?>
</head>

<body>
    <h2>Training</h2>
    <div class="element margin_left margin_right heading_container">
        <?php
        $tid = isset($_GET['training']) ? $_GET['training'] : NULL;
        if (isset($_SESSION['tid']) || isset($tid)) {
            include 'includes/functions.php';
            $result = isset($tid) ? get_single_training_active($tid) : get_single_training_active($_SESSION['tid']);
            $row = $result->fetch_assoc();
            $tid = $row['fk_training'];
            echo '
                <h3>' . $row['name'] . '</h3>
                <p>' . $row['description'] . '</p> ';
            if ((isset($_GET['training']) and (($row['fk_user'] == $_SESSION['id'])) or ($_SESSION['user'] == 'admin') or $_SESSION['tid'] == $row['id'])) {
                echo '<div class="div_left2right">
                    <a class="col_blue" href="javascript:show_form_desc();">Beschreibung ändern</a>
                    <form class="form_desc"enctype="multipart/form-data" action="includes/training.inc.php" method="post">
                    <input type="text" name="changed_descr" placeholder="Beschreibung ändern"> <br>
                    <input type="hidden" name="name_tr" value="' . $row['name'] . '">
                    <input type="hidden" name="id_tr" value="' . $row['id'] . '">
                    <button type="submit" name="update_descr">Ändern</button> <br>
                    </form></div>
                    ';
            }
            echo '
                <img class="picture" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/>';
            if ((isset($_GET['training']) and (($row['fk_user'] == $_SESSION['id'])) or ($_SESSION['user'] == 'admin') or $_SESSION['tid'] == $row['id'])) {
                echo '<div class="div_left2right">
                <a class="col_blue" href="javascript:show_form_img();">Bild ändern</a>
                <form class="form_img"enctype="multipart/form-data" action="includes/training.inc.php" method="post">
                <label for="file">Wählen Sie ein Bild aus:</label><br>
                <input name="file" id="file" type="file" accept=".jpg, .jpeg, .png" style="margin-top:5px;border:none;" /> <br>
                <input type="hidden" name="name_tr" value="' . $row['name'] . '">
                <input type="hidden" name="id_tr" value="' . $row['id'] . '">
                <button type="submit" name="update_img">Ändern</button> <br>
                </form></div>
                ';
            }
            echo '<br>';


            if (isset($_GET['training']) === $_SESSION['tid'] || $_SESSION['tid'] == $row['id']) {
                echo '<form action="train.php">
                    <button type="submit">Starten</button> <br>
                </form>';
            }
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
            echo '<div class="margin_left margin_right">';
            $arr_big = sort_training_view_array($row['id']);
            if (!empty($arr_big)) {
                echo '<p class="pre_training"><strong>Vorheriges Training:</strong></p>';
            }
            if (count($arr_big) > 0) {

                $ctn = 0;
                //Ausgabe
                foreach ($arr_big as $key => $ar) {

                    if ($key == 1) {
                        echo '<p class="pre_training"><strong>Alte Trainings:</strong></p>';
                    }
                    $max_sets = $ar[0];
                    //Holt das Ausführungs-Datum und transformiert dieses in dd.mm.yyyy
                    if (!is_null($ar[2])) {
                        $tmp_explode_1 = explode("_", $ar[2])[0];
                        $tmp_explode_2 = explode("-", $tmp_explode_1);
                        $set_time = $tmp_explode_2[2] . '.' . $tmp_explode_2[1] . '.' . $tmp_explode_2[0];
                    }
                    //Tabellenkopf. max_sets bestimmt die Sätze der Tabelle
                    echo '<div class="table_container">
                    <table>          
                        <tr>';
                    if (isset($_GET['training']) === $_SESSION['tid'] || $_SESSION['tid'] == $row['id']) {
                        echo '<th><a class="col_blue" href="train.php?tid=' . $ar[1] . '&time=' . $ar[2] . '">Übung:</a> ' . $set_time . '</th>';
                    } else {
                        echo '<th>Übung: ' . $set_time . '</th>';
                    }

                    for ($i = 0; $i < $max_sets; $i++) {
                        echo '<th colspan="4">Satz ' . ($i + 1) . '</th>';
                        if ($i == $max_sets) {
                            echo '</tr>';
                        }
                    }
                    //Tabellenreihen
                    foreach ($ar as $item) {
                        //max_sets ist kein Array. Deswegen wird es übersprungen.
                        if (is_array($item)) {
                            //Legt für jede Reihe die Einträge an
                            for ($i = 0; $i < $max_sets; $i++) {
                                if ($i == 0) {
                                    $c = 1;
                                    echo '<tr>';
                                    echo '<td>' . $item[0] . '</td>';
                                }
                                if (isset($item[$c])) {
                                    echo '
                                    <td>' . $item[$c++] . '</td>
                                    <td>' . $item[$c++] . '</td>
                                    <td>' . $item[$c++] . '</td>
                                    <td>' . $item[$c++] . '</td>';
                                } else {
                                    echo '
                                <td> 0 </td>
                                <td> 0 </td>
                                <td> - </td>
                                <td> </td>';
                                }
                                if ($i == $max_sets) {
                                    echo '</tr>';
                                }
                            }
                        }
                    }
                    echo '</table> </div> <br>';
                }
            } else {
                echo '<p class="text_center">Führen Sie zunächst Ihr Training aus.</p>';
            }
        } else {
            echo '<p class="text_center">Bitte setzten Sie zunächst Ihr aktives Training fest.
         Diese finden Sie unter Training => Alle <a class="col_blue" href="training_overview.php">Trainings</a>.</p>';
        }
        echo '</div> </div>';
        ?>

</body>

</html>