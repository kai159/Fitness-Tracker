<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
//"bindet" das Training und die Übung zusammen
if (isset($_POST['id_training']) && isset($_POST['id_exercise'])) {
    include 'dbcon.inc.php';
    $id_training = $_POST['id_training'];
    $id_exercise = $_POST['id_exercise'];
    $stmt = $con->prepare("DELETE FROM training_exercise WHERE fk_training=? AND fk_exercise=?;");
    $stmt->bind_param('ii', $id_training, $id_exercise);
    $stmt->execute();
    $stmt->store_result();
    $result = $stmt->num_rows();
    $stmt->close();
}
