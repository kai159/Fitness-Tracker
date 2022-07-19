<?php
if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'register.php' && basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'login.php') {
    ini_set('session.gc_maxlifetime', 8 * 60 * 60);
    session_start();
    if (!isset($_SESSION['user'])) {
        header('Location: ./login.php');
    }
}