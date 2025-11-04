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

    public function validar() {
        self::$alertas = [];

        if(!$this->id_prod) {
            self::$alertas['error'][] = 'El ID del producto es obligatorio';
        } elseif(!is_numeric($this->id_prod)) {
            self::$alertas['error'][] = 'El ID del producto no es válido';
        }

        if(!$this->cantidad || !is_numeric($this->cantidad) || $this->cantidad <= 0) {
            self::$alertas['error'][] = 'La cantidad debe ser un número mayor a 0';
        }

        return self::$alertas;
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

    public static function obtenerDetallesConProductos($idEntrada) {
        $query = "SELECT ed.*, p.nombre as producto_nombre, p.precio as precio_producto 
                 FROM " . static::$tabla . " ed 
                 LEFT JOIN productos p ON ed.id_prod = p.id 
                 WHERE ed.id = " . self::$db->escape_string($idEntrada);
        $resultado = self::$db->query($query);
        $detalles = [];
        while($registro = $resultado->fetch_assoc()) {
            $detalles[] = $registro;
        }
        $resultado->free();
        return $detalles;
    }

    // Eliminar todos los detalles de una entrada
    public static function eliminarPorEntrada($idEntrada) {
        if(!$idEntrada || !is_numeric($idEntrada)) {
            return false;
        }
        
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string(intval($idEntrada));
        $resultado = self::$db->query($query);
        
        return $resultado;
    }
}