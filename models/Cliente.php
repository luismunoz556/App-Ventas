<?php

namespace Model;

class Cliente extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'cliente';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido del cliente es obligatorio';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'El telefono del cliente es obligatorio';
        }
    }
}