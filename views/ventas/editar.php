<?php 

$titulo_pagina = 'Editar Venta';
$info = 'Venta';
$descripcion_pagina = 'editar una venta';
$boton_formulario = 'Editar Venta';
$action_formulario = '/ventas/editar?id=' . $venta->id;
require_once __DIR__ . '/formulario.php';
?>