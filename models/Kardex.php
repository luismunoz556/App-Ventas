<?php

namespace Model;

class Kardex extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'kardex';
    protected static $columnasDB = ['id', 'id_prod', 'fecha', 'tipo', 'cantidad', 'saldo'];
    public $id;
    public $id_prod;
    public $fecha;
    public $tipo;
    public $cantidad;
    public $saldo;


    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_prod = $args['id_prod'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->tipo = $args['tipo'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->saldo = $args['saldo'] ?? null;
    }

    public function validar() {
        self::$alertas = [];

        if(!$this->id_prod) {
            self::$alertas['error'][] = 'El ID del producto es obligatorio';
        } elseif(!is_numeric($this->id_prod)) {
            self::$alertas['error'][] = 'El ID del producto no es válido';
        }
    }

    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id' && !is_null($this->id)) {
                $atributos[$columna] = $this->$columna;
            } elseif($columna !== 'id') {
                $atributos[$columna] = $this->$columna;
            }
        }
        return $atributos;
 
 
    }

    public function guardar() {
        return $this->crear();
    }

    public static function insertarKardex($id_prod,$cantidad,$tipo,$cantidadAnt) {
        $kardex = new Kardex();
        $kardex->id_prod = $id_prod;
        $kardex->fecha = date('Y-m-d H:i:s');
        $kardex->tipo = $tipo;
        $kardex->cantidad = $cantidad;
        $kardex->saldo = $cantidadAnt + $cantidad;
        return $kardex->guardar();
    }
}