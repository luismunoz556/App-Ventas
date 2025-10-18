<?php

$db = mysqli_connect($_ENV['BD_HOSTD'], $_ENV['BD_USERD'], $_ENV['BD_PASSD'], $_ENV['BD_NAMED']);
//$db = mysqli_connect('localhost', 'root', 'root', 'AppVentas');
//$db = mysqli_connect('db5018828644.hosting-data.io', 'dbu680890', 'D4t0s2025s0lar1x*', 'dbs14868710');
$db->set_charset('utf8');



if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}
