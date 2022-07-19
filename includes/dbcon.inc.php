<?php
// Verbindung zur Datenbank
$con = mysqli_connect('localhost', 'root', '', 'fitnesstracker');
// sollte die Verbindung nicht funktionieren, dann wird eine Fehlermeldung ausgegeben
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}