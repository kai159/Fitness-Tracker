<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if (isset($_POST['training_overview_submit'])) {
    require 'dbcon.inc.php';
    $id_training = intval($_POST['training_id']);
    $id_user = $_SESSION['id'];
    $stmt = $con->prepare("UPDATE user SET active_training=? WHERE id=?");
    $stmt->bind_param('ii', $id_training, $id_user);
    $stmt->execute();
    // if ($stmt) {
    //     header('Location: ../success.php');
    //     exit();
    // }
    $stmt->close();
    $_SESSION['tid'] = $id_training;
    header('Location: ../training.php');
    exit();
}