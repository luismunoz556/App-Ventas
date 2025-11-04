<?php

namespace Model;

class Productos extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'productos';
    protected static $columnasDB = ['id', 'nombre', 'precio', 'cantidad'];
    public $id;
    public $nombre;
    public $precio;
    public $cantidad;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->cantidad = $args['cantidad'] ?? '';
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
}