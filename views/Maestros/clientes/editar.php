<?php 
$titulo_pagina = 'Editar Cliente';
$descripcion_pagina = 'editar un cliente';
$boton_formulario = 'Editar Cliente';
$action_formulario = '/maestros/clientes/editar?id=' . $cliente->id;
require_once __DIR__ . '/formulario.php';
?>