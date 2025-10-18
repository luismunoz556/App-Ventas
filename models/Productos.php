<?php

namespace Model;

class Productos extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'productos';
    protected static $columnasDB = ['ID_PRO', 'NOMBRE', 'PRECIO', 'CANTIDAD'];
    public $ID_PRO;
    public $NOMBRE;
    public $PRECIO;
    public $CANTIDAD;
    public function __construct($args = []) {
        $this->ID_PRO = $args['ID_PRO'] ?? null;
        $this->NOMBRE = $args['NOMBRE'] ?? '';
        $this->PRECIO = $args['PRECIO'] ?? '';
        $this->CANTIDAD = $args['CANTIDAD'] ?? '';
    }
}