<?php

namespace Model;

class ComboDet extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'combo_detalle';
    protected static $columnasDB = ['id_combo', 'id_producto', 'cantidad'];
    public $id_combo;
    public $id_producto;
    public $cantidad;

    public function __construct($args = []) {
        $this->id_combo = $args['id_combo'] ?? null;
        $this->id_producto = $args['id_producto'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
    }

    public function validar() {
        self::$alertas = [];

        // id_combo puede ser null durante la validación previa (se asigna después de guardar el producto)
        // Solo validar si está presente
        if(!is_null($this->id_combo) && !is_numeric($this->id_combo)) {
            self::$alertas['error'][] = 'El ID del combo no es válido';
        }

        if(!$this->id_producto) {
            self::$alertas['error'][] = 'El ID del producto es obligatorio';
        } elseif(!is_numeric($this->id_producto)) {
            self::$alertas['error'][] = 'El ID del producto no es válido';
        }

        if(!$this->cantidad || !is_numeric($this->cantidad) || $this->cantidad <= 0) {
            self::$alertas['error'][] = 'La cantidad debe ser un número mayor a 0';
        }

        return self::$alertas;
    }

    // Obtener todos los componentes de un combo
    public static function obtenerComponentes($idCombo) {
        if(!$idCombo || !is_numeric($idCombo)) {
            return [];
        }
        
        $query = "SELECT cd.*, p.nombre as producto_nombre, p.precio as precio_producto 
                 FROM " . static::$tabla . " cd 
                 LEFT JOIN productos p ON cd.id_producto = p.id 
                 WHERE cd.id_combo = " . self::$db->escape_string(intval($idCombo));
        
        $resultado = self::$db->query($query);
        $detalles = [];
        
        while($registro = $resultado->fetch_assoc()) {
            $detalles[] = $registro;
        }
        
        $resultado->free();
        return $detalles;
    }

    // Eliminar todos los componentes de un combo
    public static function eliminarPorCombo($idCombo) {
        if(!$idCombo || !is_numeric($idCombo)) {
            return false;
        }
        
        $query = "DELETE FROM " . static::$tabla . " WHERE id_combo = " . self::$db->escape_string(intval($idCombo));
        $resultado = self::$db->query($query);
        
        return $resultado;
    }
}