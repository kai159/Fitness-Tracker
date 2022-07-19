<!doctype html>
<html lang="de">

<head>
    <title>Train</title>
    <link rel="stylesheet" href="css/table.css">
    <link rel="stylesheet" href="css/alternate.css">
    <link rel="stylesheet" href="css/train.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/train.js"></script>
    <?php include 'includes/navbar.php'; ?>
</head>

<body>

    <h2>Training</h2>
    <div class="main text_align">
        <?php
        include 'includes/functions.php';
        //Erstellt einen neuen Eintrag
        $result_exercises = get_active_exercises();
        if ($result_exercises->num_rows > 0) {
            if (!isset($_GET['tid']) && !isset($_GET['time'])) {
                while ($row_ex = $result_exercises->fetch_assoc()) {
                    echo '
                        <form id="train_table" method="POST" action="includes/train.inc.php">
                        <table id="' . $row_ex["id"] . '"> 
                        <tr> 
                        <th>' . $row_ex["name"] . '</th>
                        <th>Wiederholung</th>
                        <th>Gewicht</th>
                        <th>Art</th>
                        <th>Kommentar</th>
                        </tr>';
                    $count = 0;
                    for ($i = 1; $i <= 3; $i++) {
                        echo '
                            <input type="hidden" name="' . $row_ex["id"] . '_fkex_' . $i . '"/input>
                            <tr>
                            <td>Satz ' . $i . '</td>
                            <td><input type="number" name="' . $row_ex["name"] . '_rep_' . $i . '"/input></td>
                            <td><input type="number" name="' . $row_ex["name"] . '_weight_' . $i . '" step="0.001"/input></td>
                            <td><input type="text" name="' . $row_ex["name"] . '_type_' . $i . '" value="Standard"/input></td>
                            <td><input type="text" name="' . $row_ex["name"] . '_comment_' . $i . '"/input></td>
                            </tr>';
                    }
                    echo '</table> <br> 
                        <button type="button" id="' . $row_ex["id"] . '_add" onClick="set_add(this.id, this.name)" name="' . $row_ex["name"] . '">+</button>
                        <button type="button" id="' . $row_ex["id"] . '_sub" onClick="set_sub(this.id)" name="reduce_set">-</button>
                        <br>';
                }
                echo '
                    <input type="hidden" name="a_tid_a" value="' . $_SESSION["tid"] . '"/input>
                    <input type="hidden" name="a_id_a" value="' . $_SESSION["id"] . '"/input>
                    <button type="submit" name="train_submit">Save</button>
                    </from>';
            } else {
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
                        <table id="' . $row_ex["id"] . '"> 
                        <tr> 
                        <th>' . $row_ex["name"] . '</th>
                        <th>Wiederholung</th>
                        <th>Gewicht</th>
                        <th>Art</th>
                        <th>Kommentar</th>
                        </tr>';
                    }
                    if ($tmp_name != $item['name'] | !isset($item['name'])) {
                        echo '</tr></table> <br> 
                        <button type="button" id="' . $row_ex["id"] . '_add" onClick="set_add(this.id, this.name)" name="' . $row_ex["name"] . '">+</button>
                        <button type="button" id="' . $row_ex["id"] . '_sub_' . $tmp_int  . '" onClick="set_sub_edit(this.id)" name="reduce_set">-</button>
                        <br>';

                        $tmp_name = $item['name'];
                        $row_ex = $result_exercises->fetch_assoc();
                        echo '
                        <table id="' . $row_ex["id"] . '"> 
                        <tr> 
                        <th>' . $row_ex["name"] . '</th>
                        <th>Wiederholung</th>
                        <th>Gewicht</th>
                        <th>Art</th>
                        <th>Kommentar</th>
                        </tr>';
                    }
                    echo '
                        <input type="hidden" name="' . $row_ex["id"] . '_fkex_' . $item['number'] . '"/input>
                        <tr>
                        <td>Satz ' . $item['number'] . '</td>
                        <td><input type="number" name="' . $row_ex["name"] . '_rep_' . $item['number']  . '" value="' . $item['rep'] . '"/input></td>
                        <td><input type="number" name="' . $row_ex["name"] . '_weight_' . $item['number']  . '" value="' . $item['weight'] . '" step="0.001"/input></td>
                        <td><input type="text" name="' . $row_ex["name"] . '_type_' . $item['number']  . '" value="' . $item['type'] . '"/input></td>
                        <td><input type="text" name="' . $row_ex["name"] . '_comment_' . $item['number']  . '_' . $item['id'] . '" value="' . $item['comment'] . '"/input></td>
                        </tr>';
                    $tmp_int = $item['number'];
                }
                //Lestes Element der Foreach Schleife
                echo '</tr></table> <br> 
                    <button type="button" id="' . $row_ex["id"] . '_add" onClick="set_add(this.id, this.name)" name="' . $row_ex["name"] . '">+</button>
                    <button type="button" id="' . $row_ex["id"] . '_sub_' . $tmp_int  . '" onClick="set_sub_edit(this.id)" name="reduce_set">-</button>
                    <br>';
                //Für den Submit Button
                echo '
                    <input type="hidden" name="a_tid_a" value="' . $_SESSION["tid"] . '"/input>
                    <input type="hidden" name="a_id_a" value="' . $_SESSION["id"] . '"/input>
                    <input type="hidden" name="a_time_a" value="' . $modified_time . '"/input>
                    <button type="submit" name="train_submit">Save</button>
                    </from>';
            }
        } else {
            echo '<p>Bitte fügen Sie dem Training zuerst <a class="col_blue" href="exercise.php">Übungen</a> hinzu.</p>';
        }
        ?>
    </div>
</body>

</html>