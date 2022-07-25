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
    $stmt->close();
}

if(isset($_POST['delete_submit'])){
    include 'dbcon.inc.php';
    $id_training = $_POST['id_tr'];
    $stmt = $con->prepare("DELETE FROM training_exercise WHERE fk_training=?;");
    $stmt->bind_param('i', $id_training);
    $stmt->execute();
    $stmt = $con->prepare("DELETE FROM eset WHERE fk_training=?;");
    $stmt->bind_param('i', $id_training);
    $stmt->execute();
    $stmt = $con->prepare("DELETE FROM user_training WHERE fk_training=?;");
    $stmt->bind_param('i', $id_training);
    $stmt->execute();
    $stmt = $con->prepare("DELETE FROM training WHERE id=?;");
    $stmt->bind_param('i', $id_training);
    $stmt->execute();
    $_SESSION['tid'] = NULL;
    header('Location: ../training_overview.php');
    exit();
}
