<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
// Verbindung zur Datenbank
$con = mysqli_connect('localhost', 'root', '', 'fitnesstracker');
// sollte die Verbindung nicht funktionieren, dann wird eine Fehlermeldung ausgegeben
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}


// $con = mysqli_connect('db', 'user', 'password', 'fitnesstracker');
// // sollte die Verbindung nicht funktionieren, dann wird eine Fehlermeldung ausgegeben
// if (!$con) {
//     die("Connection failed: " . mysqli_connect_error());
// }