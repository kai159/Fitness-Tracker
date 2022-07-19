<?php
//Dient als Validierung des Files. Prüft ob der Upload erfolgreich war,
//die Größe passt, das Format stimmt.
function check_file($file)
{
    $filter_arr = array('png', 'jpg', 'jpeg');
    $strip = explode('.', $file['name']);
    $file_extension = end($strip);
    if ($file['error'] !== 0) {
        header('Location: ../exercise_create.php?ms=error');
        exit();
    }
    if ($file['size'] > 3000000) {
        header('Location: ../exercise_create.php?ms=size');
        exit();
    }
    if (!in_array($file_extension, $filter_arr)) {
        header('Location: ../exercise_create.php?ms=format');
        exit();
    }
    return file_get_contents($file['tmp_name']);
}

//Hier wird der Name der Übung mit den vorhandenen Übungen verglichen.
//Kommt diser schon vor, wird eine Meldung für den Benutzer generiert.
function compare_ex_name($name_ex)
{
    require 'dbcon.inc.php';
    $stmt = $con->prepare("SELECT * FROM exercise WHERE name=?;");
    if (!$stmt) {
        header('Location: ../exercise_create.php?ms=db');
        exit();
    }
    $stmt->bind_param('s', $name_ex);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    if (is_null($result)) {
        return;
    }
    $name_low = strtolower($name_ex);
    $result_low = strtolower($result['name']);
    if ($name_low === $result_low) {
        header('Location: ../exercise_create.php?ms=taken');
        exit();
    }
}
// Hier ist der Code um eine Übung zu erstellen und diese in die Datenbank zu legen.
if (isset($_POST['exercise_submit'])) {
    require 'dbcon.inc.php';
    session_start();
    $name = $_SESSION['user'];
    $id = $_SESSION['id'];
    $name_ex = htmlspecialchars($_POST['name_ex']);
    $description = htmlspecialchars($_POST['description']);
    if (!empty($_FILES['file'])) {
        $file = $_FILES['file'];
    }
    if (empty($description) || strlen(trim($description)) == 0) {
        $description = '&nbsp;';
    }
    if (empty($name_ex)) {
        header('Location: ../exercise_create.php?ms=empty');
        exit();
    }

    compare_ex_name($name_ex);

    if (!empty($file['name'])) {
        $blob = check_file($file);
    } else {
        $blob = file_get_contents('tmp/pic.png');
    }

    $stmt = $con->prepare("INSERT INTO exercise (name, description, fk_user, picture) VALUES (?, ?, ?, ?);");
    if (!$stmt) {
        header('Location: ../exercise_create.php?ms=db');
        exit();
    }
    $stmt->bind_param('ssss', $name_ex, $description, $id, $blob);
    $stmt->execute();
    if (!$stmt) {
        header('Location: ../exercise_create.php?ms=fail');
        exit();
    }
    header('Location: ../exercise_create.php?ms=success');
    $stmt->close();
    $con->close();
}