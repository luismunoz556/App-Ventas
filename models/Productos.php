<?php

namespace Model;

class Productos extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'productos';
    protected static $columnasDB = ['id', 'nombre', 'precio', 'cantidad','activo','fecha_creacion','imagen','descripcion','escombo'];
    public $id;
    public $nombre;
    public $precio;
    public $cantidad;
    public $activo;
    public $fecha_creacion;
    public $imagen;
    public $descripcion;
    public $escombo;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
        $this->activo = $args['activo'] ?? 0;
        $this->fecha_creacion = $args['fecha_creacion'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->escombo = $args['escombo'] ?? 0;
    }
    
    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre del producto es obligatorio';
        }
        
        if(!$this->precio) {
            self::$alertas['error'][] = 'El precio es obligatorio';
        } elseif(!is_numeric($this->precio) || $this->precio < 0) {
            self::$alertas['error'][] = 'El precio debe ser un número válido mayor o igual a 0';
        }
        
        if(!is_numeric($this->cantidad) || $this->cantidad < 0) {
            self::$alertas['error'][] = 'La cantidad debe ser un número válido mayor o igual a 0';
        }
        
        return self::$alertas;
    }

    public static function actualizaInventario($id,$cantidad,$cantiHis){
        $nuevaCant = $cantiHis + $cantidad;
        $query = "UPDATE productos SET cantidad = {$nuevaCant} WHERE id = {$id}";
        $resultado = self::$db->query($query);
        return $resultado;
        
    }

    public static function allConCantidad() {
        $query = "SELECT p.* FROM " . static::$tabla .  " p WHERE p.cantidad > 0";
        $query .= " union ";
        $query .= "SELECT r.* FROM " . static::$tabla .  " r WHERE r.escombo = 1";
        return self::consultarSQL($query);
    }
}