<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
if (isset($_POST['login_submit'])) {
    require 'dbcon.inc.php';
    $name = $_POST['name'];
    $password = $_POST['password'];
    if (empty($name) || empty($password)) {
        header('Location: ../login.php?ms=empty&name=' . $name);
        exit();
    } else {
        include 'dbcon.inc.php';
        $stmt = $con->prepare("SELECT * FROM user WHERE name=?;");
        if (!$stmt) {
            header('Location: ../login.php?ms=db&name=' . $name);
            exit();
        }
        $stmt->bind_param('s', $name);
        $stmt->execute();

        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        if (!$stmt) {
            header('Location: ../login.php?ms=notfound&true=' . $name);
            exit();
        } else {
            $check = password_verify($password, $row['passwordhash']);
        }

        if (!$check) {
            header('Location: ../login.php?ms=wrong&name=' . $name);
            exit();
        } else {
            $_SESSION['user'] = $row['name'];
            $_SESSION['id'] = $row['id'];
            if (!is_null($row['active_training'])) {
                $_SESSION['tid'] = $row['active_training'];
            }
            header('Location: ../index.php');
        }
        $stmt->close();
        $con->close();
        exit();
    }
}