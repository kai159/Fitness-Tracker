<?php
//"bindet" das Training und die Übung zusammen
if (isset($_POST['id_training']) && isset($_POST['id_exercise'])) {
    include 'dbcon.inc.php';
    $id_training = $_POST['id_training'];
    $id_exercise = $_POST['id_exercise'];
    $stmt = $con->prepare("SELECT * FROM training_exercise WHERE fk_training=? AND fk_exercise=?;");
    $stmt->bind_param('ii', $id_training, $id_exercise);
    $stmt->execute();
    $stmt->store_result();
    $result = $stmt->num_rows();
    $stmt->close();
    if ($result > 0) {
        exit();
    }
    $stmt = $con->prepare("INSERT INTO training_exercise (fk_exercise, fk_training) VALUES (?, ?);");
    if (!$stmt) {
        header('Location: ../register.php?ms=db&name=' . $name);
        exit();
    }
    $stmt->bind_param('ii', $id_exercise, $id_training);
    $stmt->execute();
    $stmt->close();
}
// dieser Code ermöglicht es die Beschreibung zu ändern
if (isset($_POST['update_descr'])) {
    require 'dbcon.inc.php';
    session_start();
    $name_ex = htmlspecialchars($_POST['name_ex']);
    $descr_new = htmlspecialchars($_POST['changed_descr']);
    $id_ex = htmlspecialchars($_POST['id_ex']);
    if (empty($descr_new) || strlen(trim($descr_new)) == 0) {
        $descr_new = '&nbsp;';
    }
    if (strlen($descr_new) >= 255) {
        header('Location: ../exercise.php?name=' . $name_ex . '&ms=long');
        exit();
    }
    $stmt = $con->prepare("UPDATE exercise SET description=? WHERE id=?");
    $stmt->bind_param('ss', $descr_new, $id_ex);
    $stmt->execute();
    if ($stmt) {
        header('Location: ../exercise.php?ms=success&name=' . $name_ex);
    }
    $stmt->close();
    $con->close();
}
// dieser Code ermöglicht es das Bild zu ändern
if (isset($_POST['update_img'])) {
    require 'dbcon.inc.php';
    session_start();
    $name_ex = htmlspecialchars($_POST['name_ex']);
    $id_ex = htmlspecialchars($_POST['id_ex']);
    $file = $_FILES['file'];
    $blob = check_file($file);
    $stmt = $con->prepare("UPDATE exercise SET picture=? WHERE id=?");
    $stmt->bind_param('ss', $blob, $id_ex);
    $stmt->execute();
    if ($stmt) {
        header('Location: ../exercise.php?ms=success&name=' . $name_ex);
    }
    $stmt->close();
    $con->close();
}
//Dient als Validierung des Files. Prüft ob der Upload erfolgreich war,
//die Größe passt, das Format stimmt.
function check_file($file)
{
    $name_ex = htmlspecialchars($_POST['name_ex']);
    $filter_arr = array('png', 'jpg', 'jpeg');
    $strip = explode('.', $file['name']);
    $file_extension = end($strip);
    if ($file['error'] !== 0) {
        header('Location: ../exercise.php?ms=error&name=' . $name_ex . '');
        exit();
    }
    if ($file['size'] > 3000000) {
        header('Location: ../exercise.php?ms=size&name=' . $name_ex . '');
        exit();
    }
    if (!in_array($file_extension, $filter_arr)) {
        header('Location: ../exercise.php?ms=format&name=' . $name_ex . '');
        exit();
    }
    return file_get_contents($file['tmp_name']);
}