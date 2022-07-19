<?php
if (isset($_POST['train_submit'])) {
    include 'dbcon.inc.php';
    $count = 0;
    $id = $_POST['a_id_a'];
    $tid = $_POST['a_tid_a'];
    $time = (isset($_POST['a_time_a'])) ? $_POST['a_time_a'] : date('Y-m-d H:i:s');


    foreach ($_POST as $key => $value) {
        $expl = explode('_', $key);
        if ($expl[2] != NULL){
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
}


// $stmt = $con->prepare("SELECT * FROM user_training WHERE fk_user=?");
// $stmt->bind_param('i', $id);
// $stmt->execute();
// $stmt->store_result();
// $result = $stmt->num_rows();
// $stmt->close();
// if($result > 0){
//     $stmt = $con->prepare("UPDATE user_training SET fk_training=? WHERE fk_user=?;");
//     $stmt->bind_param('ii', $tid, $id);
//     $stmt->execute();
//     $stmt->close();
// }else{
//     $stmt = $con->prepare("INSERT INTO user_training (fk_user, fk_training) VALUES (?, ?);");
//     $stmt->bind_param('ii', $id, $tid);
//     $stmt->execute();
//     $stmt->close();
// }