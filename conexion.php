<?php
$mysqli = new mysqli("localhost", "database", "password", "user");
if ($mysqli->connect_errno) {
    echo "Fallo al conectar con la base de datos MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
$mysqli->set_charset("utf8");
?>