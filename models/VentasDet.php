<?php

namespace Model;

class VentasDet extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'ventas_det';
    protected static $columnasDB = ['id', 'id_prod', 'cantidad', 'precio'];
    public $id;
    public $id_prod;
    public $cantidad;
    public $precio;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->id_prod = $args['id_prod'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->precio = $args['precio'] ?? null;
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

        if(!$this->precio || !is_numeric($this->precio) || $this->precio < 0) {
            self::$alertas['error'][] = 'El precio debe ser un número válido mayor o igual a 0';
        }

        return self::$alertas;
    }

    // Sobrescribir atributos para incluir el id cuando está establecido (es FK a ventas)
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            // Incluir el id si está establecido (es FK, no auto-increment)
            if($columna === 'id' && !is_null($this->id)) {
                $atributos[$columna] = $this->$columna;
            } elseif($columna !== 'id') {
                $atributos[$columna] = $this->$columna;
            }
        }
        return $atributos;
    }

    // Sobrescribir guardar para forzar crear cuando el id es FK
    public function guardar() {
        // En VentasDet, el campo id es FK a ventas, no PK auto-increment
        // Cuando id está establecido, siempre creamos un nuevo registro con ese id
        // Si no hay id establecido, usar comportamiento normal (crear sin id)
        return $this->crear();
    }

    // Obtener los detalles de una venta con información del producto
    public static function obtenerDetallesConProductos($idVenta) {
        $query = "SELECT vd.*, p.nombre as producto_nombre, p.precio as precio_producto 
                 FROM " . static::$tabla . " vd 
                 LEFT JOIN productos p ON vd.id_prod = p.id 
                 WHERE vd.id = " . self::$db->escape_string($idVenta);
        
        $resultado = self::$db->query($query);
        $detalles = [];
        
        while($registro = $resultado->fetch_assoc()) {
            $detalles[] = $registro;
        }
        
        $resultado->free();
        return $detalles;
    }

    // Eliminar todos los detalles de una venta
    public static function eliminarPorVenta($idVenta) {
        if(!$idVenta || !is_numeric($idVenta)) {
            return false;
        }
        
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string(intval($idVenta));
        $resultado = self::$db->query($query);
        
        return $resultado;
    }
}