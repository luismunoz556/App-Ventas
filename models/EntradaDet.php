<?php

namespace Model;

class EntradaDet extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'entrada_det';    
    protected static $columnasDB = ['id', 'id_prod', 'cantidad'];
    public $id;
    public $id_prod;
    public $cantidad;
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_prod = $args['id_prod'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
    }
}