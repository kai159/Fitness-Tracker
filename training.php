<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<!doctype html>
<html lang="de">

<head>
    <title>Training Starten</title>
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/show_form.js"></script>
    <script src="js/training.js"></script>
    <?php include 'includes/navbar.php'; ?>
    <style>
        td{min-width: 80px; width: 80px;}
        tr td:first-child {min-width: 100px;}
        .hide{ display: none;}  
    </style>
</head>

<body class="b_body">
    <div class="container text-center">
        <h2 onclick="extra_hidden()">Training</h2>
        <?php
        $tid = isset($_GET['training']) ? $_GET['training'] : NULL;
        if (isset($_SESSION['tid']) || isset($tid)) {
            include 'includes/functions.php';
            $result = isset($tid) ? get_single_training_active($tid) : get_single_training_active($_SESSION['tid']);
            $row = $result->fetch_assoc();
            $tid = $row['fk_training'];
            echo '
                <h3 onclick="extra_hidden()">' . $row['name'] . '</h3>
                <p>' . $row['description'] . '</p> 
                <div class="row">
                    <div class="col-xxl-4 col-lg-6 shadow-sm px-4 mt-3" style="min-width: 350px;">
                    <img onclick="show_form_both()" class="mb-2" style="width:270px; height:120px;" src="data:image/jpeg;base64,' . base64_encode($row['picture']) . '"/>';
            if (isset($_GET['training']) === $_SESSION['tid'] || $_SESSION['tid'] == $row['id']) {
                echo '
                <div class="row">
                    <div class="col-6">
                        <form action="train.php">
                            <button class="btn btn-secondary mb-2" type="submit">Starten</button>
                        </form>
                    </div>
                    <div class="col-6 text-left">
                        <form action="training_edit.php">
                            <button class="btn btn-secondary mb-2" type="submit">Editieren</button>
                        </form>
                    </div>
                </div>';               
            } else{
                echo '
                    <form action="training_edit.php">
                        <button class="btn btn-secondary mb-2" type="submit">Editieren</button>
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
            if ((isset($_GET['training']) and (($row['fk_user'] == $_SESSION['id'])) or ($_SESSION['user'] == 'admin') or $_SESSION['tid'] == $row['id'])) {
                echo '
                <div class="col-xxl-4 col-lg-0 order-first"></div>
                <div class="col-xxl-4 d-none d-xxl-block"></div>
                <div class="col-xxl-4 d-none d-xxl-block"></div>
                <div class="col-xxl-4 col-lg-6 mt-3">
                <div class="div_left2right">            
                    <form class="form_desc"enctype="multipart/form-data" style="display: none" action="includes/training.inc.php" method="post">
                        <input type="text" name="changed_descr" placeholder="Beschreibung ändern"> <br>
                        <input type="hidden" name="name_tr" value="' . $row['name'] . '">
                        <input type="hidden" name="id_tr" value="' . $row['id'] . '">
                        <button type="submit" name="update_descr">Ändern</button> <br>
                    </form>
                </div>
                <form class="form_img" style="display: none" enctype="multipart/form-data" action="includes/training.inc.php" method="post">
                <label for="file">Wählen Sie ein Bild aus:</label><br>
                <input name="file" id="file" type="file" accept=".jpg, .jpeg, .png" style="margin-top:5px;border:none;" /> <br>
                <input type="hidden" name="name_tr" value="' . $row['name'] . '">
                <input type="hidden" name="id_tr" value="' . $row['id'] . '">
                <button type="submit" name="update_img">Ändern</button> <br>
                </form></div>
                ';
                
            }

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
                    echo '
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered b_table">          
                        <tr>';
                    if (isset($_GET['training']) === $_SESSION['tid'] || $_SESSION['tid'] == $row['id']) {
                        echo '<th><a href="train.php?tid=' . $ar[1] . '&time=' . $ar[2] . '">Übung:</a> ' . $set_time . '</th>';
                    } else {
                        echo '<th>Übung: ' . $set_time . '</th>';
                    }

                    for ($i = 0; $i < $max_sets; $i++) {
                        echo '<th class="table_col" colspan="2">Satz ' . ($i + 1) . '</th>';
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
                                    <td class="hide">' . $item[$c++] . '</td>
                                    <td class="hide">' . $item[$c++] . '</td>';
                                } else {
                                    echo '
                                <td> 0 </td>
                                <td> 0 </td>
                                <td class="hide"> - </td>
                                <td class="hide"> </td>';
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
         Diese finden Sie unter Training => Alle <a href="training_overview.php">Trainings</a>.</p>';
        }
        echo '</div>';
        ?>
    </div>

</body>

</html>