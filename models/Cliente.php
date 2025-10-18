<?php

namespace Model;

class Cliente extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'cliente';
    protected static $columnasDB = ['ID_CLI', 'NOMBRE', 'APELLIDO', 'TELEFONO'];

    public $ID_CLI;
    public $NOMBRE;
    public $APELLIDO;
    public $TELEFONO;

    public function __construct($args = []) {
        $this->ID_CLI = $args['ID_CLI'] ?? null;
        $this->NOMBRE = $args['NOMBRE'] ?? '';
        $this->APELLIDO = $args['APELLIDO'] ?? '';
        $this->TELEFONO = $args['TELEFONO'] ?? '';
    }
}