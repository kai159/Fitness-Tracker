<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
?>
<!doctype html>
<html lang="de">

<head>
    <title>Train</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/train.js"></script>
    <?php include 'includes/navbar.php'; ?>

    <style>
        .hide{
            display: none;
        }        
        .d-lg-block {
            border: none;
        }
        @media only screen and (max-width: 450px) {
            input {
                max-width: 100px;
            }
        }
      
    </style>
</head>

<body class="b_body">

    <div class="container text-center">
        <h2 onclick="extra_hidden()">Training</h2>
        <?php
        include 'includes/functions.php';
        //Erstellt einen neuen Eintrag
        $result_exercises = get_active_exercises();
        if ($result_exercises->num_rows > 0) {
            if (!isset($_GET['tid']) && !isset($_GET['time'])) {
                $result = get_last_training_all_sets($_SESSION['tid']);
                //Continue Training
                if($result->num_rows > 0){
                    $tmp_name = NULL;
                    $tmp_int = 0;
                    $count = 0;
                    echo '<form id="train_table" method="POST" action="includes/train.inc.php">';
                    foreach ($result as $item) {
                        if ($tmp_name == NULL) {
                            $tmp_name = $item['name'];
                            $row_ex = $result_exercises->fetch_assoc();
                            echo '
                            <div class="table-responsive text-center mt-2">
                            <table class="table table-bordered b_table" id="' . $row_ex["id"] . '"> 
                            <tr> 
                            <th class="d-none d-lg-block">' . $row_ex["name"] . '</th>
                            <th>Wiederholung</th>
                            <th>Gewicht</th>
                            <th class="hide">Art</th>
                            <th class="hide">Kommentar</th>
                            </tr>';
                        }
                        if ($tmp_name != $item['name'] | !isset($item['name'])) {
                            $count = 0;
                            echo '</tr></table> </div>
                            <button class="btn btn-secondary mb-2" type="button" id="' . $row_ex["id"] . '_add" onClick="set_add(this.id, this.name)" name="' . $row_ex["name"] . '">+</button>
                            <button class="btn btn-secondary mb-2" type="button" id="' . $row_ex["id"] . '_sub_' . $tmp_int  . '" onClick="set_sub(this.id)" name="reduce_set">-</button>
                            <br>';

                            $tmp_name = $item['name'];
                            $row_ex = $result_exercises->fetch_assoc();
                            if(!isset($row_ex['name'])){
                                goto end;
                            }
                            echo '
                            <div class="table-responsive text-center mt-2">
                            <table class="table table-bordered b_table" id="' . $row_ex["id"] . '"> 
                            <tr> 
                            <th class="d-none d-lg-block">' . $row_ex["name"] . '</th>
                            <th>Wiederholung</th>
                            <th>Gewicht</th>
                            <th class="hide">Art</th>
                            <th class="hide">Kommentar</th>
                            </tr>';
                        }
                        echo '
                            <input type="hidden" name="' . $row_ex["id"] . '_fkex_' . $count++ . '"/input>
                            <tr>
                            <td class="d-none d-lg-block" style="min-width: 140px">Satz ' . $count . '</td>
                            <td><input type="number" name="' . $row_ex["name"] . '_rep_' . $count  . '" value="' . $item['rep'] . '"</input></td>
                            <td><input type="number" name="' . $row_ex["name"] . '_weight_' . $count  . '" value="' . $item['weight'] . '" step="0.001"</input></td>
                            <td class="hide"><input type="text" name="' . $row_ex["name"] . '_type_' . $count  . '" value="' . $item['type'] . '"</input></td>
                            <td class="hide"><input type="text" name="' . $row_ex["name"] . '_comment_' . $count  . '" value="' . $item['comment'] . '"</input></td>
                            </tr>';
                        $tmp_int = $item['number'];
                    }
                    //Lestes Element der Foreach Schleife
                    echo '</tr> </table> </div>
                        <button class="btn btn-secondary mb-2" type="button" id="' . $row_ex["id"] . '_add" onClick="set_add(this.id, this.name)" name="' . $row_ex["name"] . '">+</button>
                        <button class="btn btn-secondary mb-2" type="button" id="' . $row_ex["id"] . '_sub_' . $tmp_int  . '" onClick="set_sub(this.id)" name="reduce_set">-</button>
                        <br>';

                    //For added exercises 
                    while ($row_ex = $result_exercises->fetch_assoc()){
                        fresh_train_output($row_ex['name'], $row_ex['id']);
                    }
                    end:
                    //Für den Submit Button
                    echo '
                    <input type="hidden" name="a_tid_a" value="' . $_SESSION["tid"] . '"/input>
                    <input type="hidden" name="a_id_a" value="' . $_SESSION["id"] . '"/input>
                    <button class="btn btn-secondary mt-2" type="submit" name="train_submit">Save</button>
                    </from>';
                } else {
                    //First Training
                    echo '<form id="train_table" method="POST" action="includes/train.inc.php">';
                    while ($row_ex = $result_exercises->fetch_assoc()) {
                        fresh_train_output($row_ex['name'], $row_ex['id']);
                    }
                    echo '
                        <input type="hidden" name="a_tid_a" value="' . $_SESSION["tid"] . '"/input>
                        <input type="hidden" name="a_id_a" value="' . $_SESSION["id"] . '"/input>
                        <button class="btn btn-secondary mb-2" type="submit" name="train_submit">Save</button>
                        </from>';
                }
            } else { //training edit
                $tid = htmlspecialchars($_GET['tid']);
                $time = htmlspecialchars($_GET['time']);
                $modified_time = substr_replace($time, ' ', 10, 1);
                $result = get_training_all_sets($_SESSION['id'], $tid, $modified_time);
                $tmp_name = NULL;
                $tmp_int = 0;
                $result_exercises = get_active_exercises();
                echo '<form id="train_table" method="POST" action="includes/train.inc.php">';
                foreach ($result as $item) {
                    if ($tmp_name == NULL) {
                        $tmp_name = $item['name'];
                        $row_ex = $result_exercises->fetch_assoc();
                        echo '
                        <div class="table-responsive text-center mt-2">
                        <table class="table table-bordered b_table" id="' . $row_ex["id"] . '"> 
                        <tr> 
                        <th class="d-none d-lg-block">' . $row_ex["name"] . '</th>
                        <th>Wiederholung</th>
                        <th>Gewicht</th>
                        <th class="hide">Art</th>
                        <th class="hide">Kommentar</th>
                        </tr>';
                    }
                    if ($tmp_name != $item['name'] | !isset($item['name'])) {
                        echo '</tr></table> </div>
                        <button class="btn btn-secondary mb-2" type="button" id="' . $row_ex["id"] . '_add" onClick="set_add(this.id, this.name)" name="' . $row_ex["name"] . '">+</button>
                        <button class="btn btn-secondary mb-2" type="button" id="' . $row_ex["id"] . '_sub_' . $tmp_int  . '" onClick="set_sub_edit(this.id)" name="reduce_set">-</button>
                        <br>';

                        $tmp_name = $item['name'];
                        $row_ex = $result_exercises->fetch_assoc();
                        echo '
                        <div class="table-responsive text-center mt-2">
                        <table class="table table-bordered b_table" id="' . $row_ex["id"] . '"> 
                        <tr> 
                        <th class="d-none d-lg-block">' . $row_ex["name"] . '</th>
                        <th>Wiederholung</th>
                        <th>Gewicht</th>
                        <th class="hide">Art</th>
                        <th class="hide">Kommentar</th>
                        </tr>';
                    }
                    echo '
                        <input type="hidden" name="' . $row_ex["id"] . '_fkex_' . $item['number'] . '"/input>
                        <tr>
                        <td class="d-none d-lg-block" style="min-width: 140px">Satz ' . $item['number'] . '</td>
                        <td><input type="number" name="' . $row_ex["name"] . '_rep_' . $item['number']  . '" value="' . $item['rep'] . '"</input></td>
                        <td><input type="number" name="' . $row_ex["name"] . '_weight_' . $item['number']  . '" value="' . $item['weight'] . '" step="0.001"</input></td>
                        <td class="hide"><input type="text" name="' . $row_ex["name"] . '_type_' . $item['number']  . '" value="' . $item['type'] . '"</input></td>
                        <td class="hide"><input type="text" name="' . $row_ex["name"] . '_comment_' . $item['number']  . '_' . $item['id'] . '" value="' . $item['comment'] . '"</input></td>
                        </tr>';
                    $tmp_int = $item['number'];
                }
                //Lestes Element der Foreach Schleife
                echo '</tr> </table> </div>
                    <button class="btn btn-secondary mb-2" type="button" id="' . $row_ex["id"] . '_add" onClick="set_add(this.id, this.name)" name="' . $row_ex["name"] . '">+</button>
                    <button class="btn btn-secondary mb-2" type="button" id="' . $row_ex["id"] . '_sub_' . $tmp_int  . '" onClick="set_sub_edit(this.id)" name="reduce_set">-</button>
                    <br>';
                //Für den Submit Button
                echo '
                    <input type="hidden" name="a_tid_a" value="' . $_SESSION["tid"] . '"/input>
                    <input type="hidden" name="a_id_a" value="' . $_SESSION["id"] . '"/input>
                    <input type="hidden" name="a_time_a" value="' . $modified_time . '"/input>
                    <button class="btn btn-secondary mt-2" type="submit" name="train_submit">Save</button>
                    </from>';
            }
        } else {
            echo '<p>Bitte fügen Sie dem Training zuerst <a href="exercise.php">Übungen</a> hinzu.</p>';
        }
        ?>
    </div>
</body>

</html>