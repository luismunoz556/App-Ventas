<?php

namespace Model;

class VentasDet extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'ventas_det';
    protected static $columnasDB = ['ID_VENTA', 'ID_PROD', 'CANTIDAD', 'PRECIO'];
    public $ID_VENTA;
    public $ID_PROD;
    public $CANTIDAD;
    public $PRECIO;

    public function __construct($args = []) {
        $this->ID_VENTA = $args['ID_VENTA'] ?? null;
        $this->ID_PROD = $args['ID_PROD'] ?? null;
        $this->CANTIDAD = $args['CANTIDAD'] ?? null;
        $this->PRECIO = $args['PRECIO'] ?? null;
    }
}