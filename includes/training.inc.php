<?php
// dieser Code ermöglicht es die Beschreibung zu ändern
if (isset($_POST['update_descr'])) {
    require 'dbcon.inc.php';
    session_start();
    $name_ex = htmlspecialchars($_POST['name_tr']);
    $descr_new = htmlspecialchars($_POST['changed_descr']);
    $id_tr = htmlspecialchars($_POST['id_tr']);
    if (empty($descr_new) || strlen(trim($descr_new)) == 0) {
        $descr_new = '&nbsp;';
    }
    if (strlen($descr_new) >= 255) {
        header('Location: ../training.php?training=' . $id_tr . '&ms=long');
        exit();
    }
    $stmt = $con->prepare("UPDATE training SET description=? WHERE id=?");
    $stmt->bind_param('ss', $descr_new, $id_tr);
    $stmt->execute();
    if ($stmt) {
        header('Location: ../training.php?ms=success&training=' . $id_tr);
    }
    $stmt->close();
    $con->close();
}
// dieser Code ermöglicht es das Bild zu ändern
if (isset($_POST['update_img'])) {
    require 'dbcon.inc.php';
    session_start();
    $name_ex = htmlspecialchars($_POST['name_tr']);
    $id_tr = htmlspecialchars($_POST['id_tr']);
    $file = $_FILES['file'];
    $blob = check_file($file);
    $stmt = $con->prepare("UPDATE training SET picture=? WHERE id=?");
    $stmt->bind_param('ss', $blob, $id_tr);
    $stmt->execute();
    if ($stmt) {
        header('Location: ../training.php?ms=success&training=' . $id_tr);
    }
    $stmt->close();
    $con->close();
}
//Dient als Validierung des Files. Prüft ob der Upload erfolgreich war,
//die Größe passt, das Format stimmt.
function check_file($file)
{
    $id_tr = htmlspecialchars($_POST['id_tr']);
    $filter_arr = array('png', 'jpg', 'jpeg');
    $strip = explode('.', $file['name']);
    $file_extension = end($strip);
    if ($file['error'] !== 0) {
        header('Location: ../training.php?ms=error&training=' . $id_tr . '');
        exit();
    }
    if ($file['size'] > 3000000) {
        header('Location: ../training.php?ms=size&training=' . $id_tr . '');
        exit();
    }
    if (!in_array($file_extension, $filter_arr)) {
        header('Location: ../training.php?ms=format&training=' . $id_tr . '');
        exit();
    }
    return file_get_contents($file['tmp_name']);
}