<?php

$db = mysqli_connect($_ENV['BD_HOSTD'], $_ENV['BD_USERD'], $_ENV['BD_PASSD'], $_ENV['BD_NAMED']);
$db->set_charset('utf8');



if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
