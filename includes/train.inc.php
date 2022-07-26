<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if (isset($_POST['train_submit'])) {
    include 'dbcon.inc.php';
    $count = 0;
    $id = $_POST['a_id_a'];
    $tid = $_POST['a_tid_a'];
    $time = (isset($_POST['a_time_a'])) ? $_POST['a_time_a'] : date('Y-m-d H:i:s');
    foreach ($_POST as $key => $value) {
        var_dump($key);
        echo'<br>';
        $expl = explode('_', $key);
        if (isset($expl[2])){
            switch ($expl[1]) {
                case 'fkex':
                    $fk_exercise = $expl[0];
                    break;
                case 'rep':
                    $rep = (isset($value)) ? htmlspecialchars($value) : 0;
                    break;
                case 'weight':
                    $weight = (isset($value)) ? htmlspecialchars($value) : 0;
                    break;
                case 'comment':
                    $comment = (isset($value)) ? htmlspecialchars($value) : '';
                    break;
                case 'type':
                    $type = (isset($value)) ? htmlspecialchars($value) : '';
                    break;
                default:
                break;
            }
            $count++;
            if ($count > 4) {
                if (!isset($expl[3]) && !isset($_POST['a_time_a'])){
                    $stmt = $con->prepare("INSERT INTO eset (rep, weight, fk_exercise, fk_training, comment, type, number, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
                    $stmt->bind_param('idiissis', $rep, $weight, $fk_exercise, $tid, $comment, $type, $expl[2], $time);
                    $stmt->execute();
                    $stmt->close();
                    $count = 0;
                } else {
                    if(!isset($expl[3])){
                        $stmt = $con->prepare("INSERT INTO eset (rep, weight, fk_exercise, fk_training, comment, type, number, time) VALUES (?, ?, ?, ?, ?, ?, ?, ?);");
                        $stmt->bind_param('idiissis', $rep, $weight, $fk_exercise, $tid, $comment, $type, $expl[2], $time);
                        
                    } else{
                        $stmt = $con->prepare("UPDATE eset SET rep=?, weight=?, fk_exercise=?, fk_training=?, comment=?, type=?, number=?, time=? WHERE eset.id =?;");
                        $stmt->bind_param('idiissisi', $rep, $weight, $fk_exercise, $tid, $comment, $type, $expl[2], $time, $expl[3]);
                    }
                    $stmt->execute();
                    $stmt->close();
                    $count = 0;
                }
            }
        }
    }
    if (!isset($expl[3]) && !isset($_POST['a_time_a'])){
        $stmt = $con->prepare("INSERT INTO user_training (fk_user, fk_training, time) VALUES (?, ?, ?);");
        $stmt->bind_param('iis', $id, $tid, $time);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: ../training.php?');
    exit();
}