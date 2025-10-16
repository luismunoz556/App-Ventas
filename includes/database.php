<?php

$db = mysqli_connect('localhost', 'root', 'root', '');
//$db = mysqli_connect('db5018820364.hosting-data.io', 'dbu4255947', 'Eduardo5568265*/2025', '');



if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
