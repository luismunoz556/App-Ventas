<?php

namespace Model;

class Entrada extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'entrada';
    protected static $columnasDB = ['id', 'fecha', 'id_usu'];

    public $id;
    public $fecha;
    public $id_usu;
    public $usuario_nombre;
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->id_usu = $args['id_usu'] ?? '';
    }

    public function obtenerDetalles() {
        return EntradaDet::obtenerDetallesConProductos($this->id);
    }

    public static function allConUsuario() {
        $query = "SELECT e.*, u.nombre as usuario_nombre 
                  FROM " . static::$tabla . " e 
                  INNER JOIN usuarios u ON e.id_usu = u.id";
        return self::consultarSQL($query);
    }
}