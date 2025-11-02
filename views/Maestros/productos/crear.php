<?php 
$titulo_pagina = 'Crear Nuevo Producto';
$descripcion_pagina = 'crear un nuevo producto';
$boton_formulario = 'Crear Producto';
$action_formulario = '/maestros/productos/crear';

$cantidad = $_GET['cantidad'] ?? 0;
require_once __DIR__ . '/formulario.php';
?>
