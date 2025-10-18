<?php

namespace Model;

class Entrada extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'entrada';
    protected static $columnasDB = ['ID_ENT', 'FECHA', 'ID_USU'];

    public $ID_ENT;
    public $FECHA;
    public $ID_USU;

    public function __construct($args = []) {
        $this->ID_ENT = $args['ID_ENT'] ?? null;
        $this->FECHA = $args['FECHA'] ?? '';
        $this->ID_USU = $args['ID_USU'] ?? '';
    }
}