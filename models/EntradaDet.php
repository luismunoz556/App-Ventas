<?php

namespace Model;

class EntradaDet extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'entrada_det';
    protected static $columnasDB = ['ID_ENT', 'ID_PROD', 'CANTIDAD'];
    public $ID_ENT;
    public $ID_PROD;
    public $CANTIDAD;
    public function __construct($args = []) {
        $this->ID_ENT = $args['ID_ENT'] ?? null;
        $this->ID_PROD = $args['ID_PROD'] ?? null;
        $this->CANTIDAD = $args['CANTIDAD'] ?? null;
    }
}