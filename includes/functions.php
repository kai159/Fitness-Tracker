<?php
if(!isset($_SESSION)) 
{ 
session_start(); 
} 

function get_exercises()
{
    include 'dbcon.inc.php';
    if (isset($_GET['name'])) {
        $stmt = $con->prepare("SELECT * FROM exercise WHERE name=?;");
        $stmt->bind_param('s', $_GET['name']);
    } else {
        $stmt = $con->prepare("SELECT * FROM exercise;");
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_all_training_id_name()
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT DISTINCT(user_training.fk_training), training.id, training.name
    FROM user_training
    JOIN training ON training.id = user_training.fk_training
    WHERE user_training.fk_user=?;");
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_all_training()
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT DISTINCT(user_training.fk_training), training.id, training.name,
    training.description, training.picture
    FROM user_training
    JOIN training ON training.id = user_training.fk_training
    WHERE user_training.fk_user=?;");
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_single_training_active($tid)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT DISTINCT(user_training.fk_training), training.id, training.name,
    training.description, training.picture,user_training.fk_user
    FROM user_training
    JOIN training ON training.id = user_training.fk_training
    WHERE user_training.fk_training=? AND user_training.fk_user=?;");
    $stmt->bind_param('ii', $tid, $_SESSION['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_active_exercises()
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT exercise.name, exercise.id FROM training_exercise 
    JOIN exercise on exercise.id = training_exercise.fk_exercise 
    WHERE training_exercise.fk_training=?");
    $stmt->bind_param('i', $_SESSION['tid']);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_training_all_sets($id, $tid, $time)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT exercise.name, eset.id, eset.rep, eset.weight, eset.number, user_training.time, eset.type, eset.comment
    FROM training    
    JOIN user_training on user_training.fk_training = training.id
    JOIN eset on eset.time = user_training.time
    JOIN exercise on eset.fk_exercise = exercise.id
    where user_training.fk_user =? AND user_training.time =? AND user_training.fk_training =?");
	// where user_training.time = (SELECT max(user_training.time) FROM user_training WHERE user_training.fk_training =?)  
    
    $stmt->bind_param('isi', $id, $time, $tid);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_training_all_all_sets($tid)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT exercise.name, eset.id, eset.rep, eset.weight, eset.number, user_training.time, eset.type, eset.comment, eset.time
    FROM training    
    JOIN user_training on user_training.fk_training = training.id
    JOIN eset on eset.time = user_training.time
    JOIN exercise on eset.fk_exercise = exercise.id
	WHERE user_training.fk_training =?
    ORDER BY eset.time, exercise.name, eset.id;");
    // -- ORDER BY eset.time, exercise.name, eset.id;");
    $stmt->bind_param('i', $tid);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_training_count_names($tid)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT exercise.name, eset.id, eset.rep, eset.weight, eset.number,
    user_training.time, eset.type, eset.comment, eset.time, eset.time
    FROM training    
    JOIN user_training on user_training.fk_training = training.id
    JOIN eset on eset.time = user_training.time
    JOIN exercise on eset.fk_exercise = exercise.id
	WHERE user_training.fk_training =?
    GROUP BY exercise.name
    ORDER BY eset.id;");
    $stmt->bind_param('i', $tid);
    $stmt->execute();
    $result = $stmt->get_result()->num_rows;
    $stmt->close();
    return $result;
}

function get_training_single_count_names($tid, $date)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT exercise.name, eset.id, eset.rep, eset.weight, eset.number, user_training.time, eset.type, eset.comment, eset.time
    FROM training    
    JOIN user_training on user_training.fk_training = training.id
    JOIN eset on eset.time = user_training.time
    JOIN exercise on eset.fk_exercise = exercise.id
	WHERE user_training.fk_training =? AND eset.time =?
    GROUP BY exercise.name
    ORDER BY eset.id;");
    $stmt->bind_param('is', $tid, $date);
    $stmt->execute();
    $result = $stmt->get_result()->num_rows;
    $stmt->close();
    return $result;
}

function get_single_training_id($name)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT training.id FROM training where name=? ORDER BY id DESC LIMIT 1;");
    $stmt->bind_param('s', $name);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result['id'];
}

function add_user_training($id, $tid)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("INSERT INTO user_training (fk_user, fk_training) VALUES (?, ?);");
    $stmt->bind_param('ii', $id, $tid);
    $stmt->execute();
    $stmt->close();
}

//Hier werden die Spalten in Zeilen Transformiert
//Alle Sätze werden in die einzelnen Traingingseinheiten aufgeteilt
//Dann werden die einzelnen Trainingseinheiten arr_big zugeweiesen. Dieses Stellt immer eine Tabelle dar.
//Alle Sets für ein Training
function sort_training_view_array($training_id)
{
    $result = get_training_all_all_sets($training_id);
    $data = $result->fetch_all();
    $arr_tmp = array(); //Kleines Array für jeden einzelnen Satz
    $arr = array(); //arr_tmp wird in dieses Array eingesetzt, wenn voll
    $arr_big = array(); //arr wird in dieses Array eingesetzt(dient als logische Tabelle für die Ausgabe)
    $tmp = ''; //vergleicht ob sich trainings_id geändert hat
    $i = 0; //Counter für 
    $ctn = 0; //Counter für Anzahl der Übungen pro Training
    $max_sets = 0; //Bestimmt die Maximalen Sets             
    $data_count_max = count($data); //Maximale länge des Arrays
    $data_count = 0; //Für die Bestimmung, dann die Maximale Array länge gefunden ist            
    $count_row = 0; //Für die Anzahlder Reihen
    $time = NULL;
    foreach ($data as $item) {
        if ($count_row == 0) {
            $count_row = get_training_single_count_names($training_id, $item[8]);
        }
        //Sobald eine tmp einen anderen Namen bekommt 
        //oder die maximale Satzanzahl erreicht ist, wird geprüft,
        //ob es sich um ein Initialwert handelt.
        if ($tmp != $item[0] || ($data_count + 1) == $data_count_max) {
            //Ist es kein Initalwert wird das Array in das Ausgabearray gespeichert                    
            if (count($arr_tmp) > 0) {
                //Für den letzen Satz pro Training
                if (($data_count + 1) == $data_count_max) {
                    $arr_tmp[$i++] = $item[2];
                    $arr_tmp[$i++] = $item[3];
                    $arr_tmp[$i++] = $item[6];
                    $arr_tmp[$i++] = $item[7];
                    $max_sets = ($max_sets < $item[4]) ? $item[4] : $max_sets;
                }
                //Satz 1-n wird dem Array für das einzelne Training zugewiesen
                array_push($arr, $arr_tmp);
                $arr_tmp = array();
                $i = 0;
                //Wenn die Satzanzahl erreicht ist, wird der maximale Satz für die jeweilige Tabelle bestimmt.
                //Dies wird für die Ausgabe benötigt. Danach wird eine Trainingseinheit das arr_big gepusht. 
                $ctn++;
                if ($ctn == $count_row) {
                    $modified_time = substr_replace($time, '_', 10, 1);
                    array_unshift($arr, $modified_time);
                    array_unshift($arr, $training_id);
                    array_unshift($arr, $max_sets);
                    array_unshift($arr_big, $arr);
                    $max_sets = 0;
                    $ctn = 0;
                    $arr = array();
                    $count_row = 0;
                    $time = NULL;
                }
            }
            $arr_tmp[$i++] = $item[0];
            $tmp = $item[0];
        }
        //Daten werden für die Sätze pro Übung in einem Training gesammelt und gebündelt
        $arr_tmp[$i++] = $item[2];
        $arr_tmp[$i++] = $item[3];
        $arr_tmp[$i++] = $item[6];
        $arr_tmp[$i++] = $item[7];

        $data_count++;
        //Bestimmt den Maximalen Satz
        $max_sets = ($max_sets < $item[4]) ? $item[4] : $max_sets;
        if ($time == NULL)  {
            $time = $item[8];
        }
    }
    return $arr_big;
}

function get_active_exercises_by_tid($training_id)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT exercise.name, exercise.id FROM exercise 
    JOIN training_exercise on exercise.id = training_exercise.fk_exercise 
    WHERE training_exercise.fk_training=?");
    $stmt->bind_param('i', $training_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function get_last_training_all_sets($tid)
{
    include 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT exercise.name, eset.id, eset.rep, eset.weight, eset.number, user_training.time, eset.type, eset.comment
    FROM training    
    JOIN user_training on user_training.fk_training = training.id
    JOIN eset on eset.time = user_training.time
    JOIN exercise on eset.fk_exercise = exercise.id
	where user_training.time = (SELECT max(user_training.time) FROM user_training WHERE user_training.fk_training =?)");
    // GROUP BY eset.id
    // ORDER BY eset.time, exercise.name, eset.id;");
    $stmt->bind_param('i', $tid);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

function fresh_train_output($ex_name, $ex_id, $table_tmp = NULL){
    $table_id = (isset($table_tmp)) ? '' : $table_tmp;
    echo '    
        <div class="d-block d-lg-none"><h5>' . $ex_name . '</h5> </div>
        <div class="table-responsive text-center mt-2">
            <table class="table table-bordered b_table"  id="' . $ex_id . '"> 
            <tr> 
            <th class="d-none d-lg-block">' . $ex_name . '</th>
            <th>Wiederholung</th>
            <th>Gewicht</th>
            <th class="hide">Art</th>
            <th class="hide">Kommentar</th>
            </tr>';
    $count = 0;
    for ($i = 1; $i <= 3; $i++) {
        echo '
            <input type="hidden" name="' . $ex_id . '_fkex_' . $i . '"</input>
            <tr>
            <td class="d-none d-lg-block" style="min-width: 140px">Satz ' . $i . ' </td>
            <td><input type="number" name="' . $ex_name . '_rep_' . $i . '" </input></td>
            <td><input type="number" name="' . $ex_name . '_weight_' . $i . '" step="0.001" </input></td>
            <td class="hide"><input type="text" name="' . $ex_name . '_type_' . $i . '" value="Standard" </input></td>
            <td class="hide"><input type="text" name="' . $ex_name . '_comment_' . $i . '" </input></td>
            </tr>';
    }
    echo '</table> 
    </div>
    <button class="btn btn-secondary mb-2" type="button" id="' . $ex_name . '_add" onClick="set_add(this.id, this.name)" name="' . $ex_name . '">+</button>
    <button class="btn btn-secondary mb-2" type="button" id="' .$ex_name . '_sub" onClick="set_sub(this.id)" name="reduce_set">-</button>
    <br>';
}