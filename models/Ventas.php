<?php

namespace Model;

class Ventas extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'ventas';
    protected static $columnasDB = ['ID_VEN', 'FECHA', 'ID_CLI', 'TIPO_PAGO', 'CREDITO', 'TOTAL', 'ID_USU'];
    public $ID_VEN;
    public $FECHA;
    public $ID_CLI;
    public $TIPO_PAGO;
    public $CREDITO;
    public $TOTAL;
    public $ID_USU;

    public function __construct($args = []) {
        $this->ID_VEN = $args['ID_VEN'] ?? null;
        $this->FECHA = $args['FECHA'] ?? '';
        $this->ID_CLI = $args['ID_CLI'] ?? '';
        $this->TIPO_PAGO = $args['TIPO_PAGO'] ?? '';
        $this->CREDITO = $args['CREDITO'] ?? 0;
        $this->TOTAL = $args['TOTAL'] ?? '';
        $this->ID_USU = $args['ID_USU'] ?? '';
    }
}   