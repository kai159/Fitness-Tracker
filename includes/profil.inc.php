<?php
if (isset($_POST['change_pwd_submit'])) {
    require 'dbcon.inc.php';
    session_start();
    $name = $_SESSION['user'];
    $password_current = htmlspecialchars($_POST['password_current']);
    $password = htmlspecialchars($_POST['password']);
    $password_again = htmlspecialchars($_POST['password_again']);
    if (empty($password_current) || empty($password) || empty($password)) {
        header('Location: ../profil.php?ms=empty');
        exit();
    }
    if ($password !== $password_again) {
        header('Location: ../profil.php?ms=even');
        exit();
    }
    $stmt = $con->prepare("SELECT * FROM user WHERE name=?;");
    if (!$stmt) {
        header('Location: ../profil.php?ms=db');
        exit();
    }
    $stmt->bind_param('s', $name);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../profil.php?ms=db');
        exit();
    }
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $check = password_verify($password_current, $row['passwordhash']);
    if (!$check) {
        header('Location: ../profil.php?ms=wrong');
        exit();
    }
    $passwordhash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->close();
    $stmt = $con->prepare("UPDATE user SET passwordhash=? WHERE name=?");
    $stmt->bind_param('ss', $passwordhash, $name);
    $stmt->execute();
    if ($stmt) {
        header('Location: ../profil.php?ms=success');
        exit();
    }
    $con->close();
}

if (isset($_POST['change_user_submit'])) {
    require 'dbcon.inc.php';
    session_start();
    $name = $_SESSION['user'];
    $name_new = htmlspecialchars($_POST['name']);

    if (empty($name_new)) {
        header('Location: ../profil.php?ms=empty');
        exit();
    }
    $stmt = $con->prepare("SELECT * FROM user WHERE name=?;");
    if (!$stmt) {
        header('Location: ../profil.php?ms=db');
        exit();
    }
    $stmt->bind_param('s', $name_new);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../profil.php?ms=db');
        exit();
    }
    $stmt->store_result();
    $result = $stmt->num_rows();
    if ($result > 0) {
        header('Location: ../profil.php?ms=taken&name=' . $name_new);
        exit();
    } else {
        $stmt->close();
        $stmt = $con->prepare("UPDATE user SET name=? WHERE name=?");
        $stmt->bind_param('ss', $name_new, $name);
        $stmt->execute();
        if ($stmt) {
            $_SESSION['user'] = $name_new;
            header('Location: ../profil.php?ms=success');
        }
        $stmt->close();
        $con->close();
    }
}