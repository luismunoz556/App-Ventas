<?php

namespace Model;

class Cliente extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'cliente';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'activo', 'fecha_creacion', 'imagen'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $activo;
    public $fecha_creacion;
    public $imagen;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->activo = $args['activo'] ?? 0;
        $this->fecha_creacion = $args['fecha_creacion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
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