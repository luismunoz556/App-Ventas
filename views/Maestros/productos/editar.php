<?php 
$titulo_pagina = 'Editar Producto';
$descripcion_pagina = 'editar un producto';
$boton_formulario = 'Editar Producto';
$action_formulario = '/maestros/productos/editar?id=' . $producto->id;
$cantidad = $producto->cantidad ?? 0;
require_once __DIR__ . '/formulario.php';
?>