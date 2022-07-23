<?php
if (basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'register.php' && basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']) != 'login.php') {
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    if (!isset($_SESSION['user'])) {
        header('Location: ./login.php');
        exit();
    }
}