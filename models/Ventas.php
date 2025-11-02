<?php

namespace Model;

class Ventas extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'ventas';
    protected static $columnasDB = ['id', 'fecha', 'id_cli', 'tipo_pago', 'credito', 'total', 'id_usu'];
    public $id;
    public $fecha;
    public $id_cli;
    public $tipo_pago;
    public $credito;
    public $total;
    public $id_usu;
    public $cliente_nombre;
    public $usuario_nombre;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->id_cli = $args['id_cli'] ?? '';
        $this->tipo_pago = $args['tipo_pago'] ?? '';
        $this->credito = $args['credito'] ?? 0;
        $this->total = $args['total'] ?? '';
        $this->id_usu = $args['id_usu'] ?? '';
    }

    public function validar() {
        self::$alertas = [];

        if(!$this->fecha) {
            self::$alertas['error'][] = 'La fecha es obligatoria';
        }

        if(!$this->id_cli) {
            self::$alertas['error'][] = 'Debe seleccionar un cliente';
        } elseif(!is_numeric($this->id_cli)) {
            self::$alertas['error'][] = 'El ID del cliente no es válido';
        }

        if(!$this->tipo_pago) {
            $this->tipo_pago = 'contado';
        } else {
            $tiposPagoValidos = ['contado', 'tarjeta', 'transferencia', 'credito'];
            if(!in_array($this->tipo_pago, $tiposPagoValidos)) {
                self::$alertas['error'][] = 'El tipo de pago no es válido';
            }
        }

        if($this->tipo_pago === 'credito') {
            if(!is_numeric($this->credito) || $this->credito < 0) {
                self::$alertas['error'][] = 'El crédito debe ser un número válido mayor o igual a 0';
            }
        } else {
            $this->credito = 0;
        }

        if(!is_numeric($this->total) || $this->total < 0) {
            self::$alertas['error'][] = 'El total debe ser un número válido mayor o igual a 0';
        }

        if(!$this->id_usu) {
            self::$alertas['error'][] = 'El ID del usuario es obligatorio';
        } elseif(!is_numeric($this->id_usu)) {
            self::$alertas['error'][] = 'El ID del usuario no es válido';
        }

        return self::$alertas;
    }

    // Obtener el cliente asociado a la venta
    public function obtenerCliente() {
        if(!$this->id_cli) {
            return null;
        }
        return Cliente::find($this->id_cli);
    }

    // Obtener los detalles de la venta con información de productos
    public function obtenerDetalles() {
        return VentasDet::obtenerDetallesConProductos($this->id);
    }

    public static function allConCliente() {
        $query = "SELECT v.*, c.nombre as cliente_nombre, u.nombre as usuario_nombre 
                  FROM " . static::$tabla . " v 
                  LEFT JOIN cliente c ON v.id_cli = c.id
                  INNER JOIN USUARIOS U ON V.ID_USU = U.ID";
       
        return self::consultarSQL($query);
    }
}   