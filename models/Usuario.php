<?php

namespace Model;

class Usuario extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['ID_USU', 'NOMBRE', 'APELLIDO', 'EMAIL','PASSWORD', 'TELEFONO', 'ADMIN', 'CONFIRMADO', 'TOKEN'];

    public $ID_USU;
    public $NOMBRE;
    public $APELLIDO;
    public $EMAIL;
    public $PASSWORD;
    public $TELEFONO;
    public $ADMIN;
    public $CONFIRMADO;
    public $TOKEN;

    public function __construct($args = []) {
        $this->ID_USU = $args['ID_USU'] ?? null;
        $this->NOMBRE = $args['NOMBRE'] ?? '';
        $this->APELLIDO = $args['APELLIDO'] ?? '';
        $this->EMAIL = $args['EMAIL'] ?? '';
        $this->PASSWORD = $args['PASSWORD'] ?? '';
        $this->TELEFONO = $args['TELEFONO'] ?? '';
        $this->ADMIN = $args['ADMIN'] ?? 0;
        $this->CONFIRMADO = $args['CONFIRMADO'] ?? 0;
        $this->TOKEN = $args['TOKEN'] ?? '';

    }


    //Validaciones para la creación de una cuenta
    public function validarNuevaCuenta() {
        if(!$this->NOMBRE) {
            self::$alertas['error'][] = 'El Nombre es Obligatorio';
        }
        if(!$this->APELLIDO) {
            self::$alertas['error'][] = 'El Apellido es Obligatorio';
        }
        if(!$this->EMAIL) {
            self::$alertas['error'][] = 'El Email es Obligatorio';
        }
        if(!$this->PASSWORD) {
            self::$alertas['error'][] = 'El Password es Obligatorio';
        }
        if(strlen($this->PASSWORD) < 6) {
            self::$alertas['error'][] = 'El Password debe tener al menos 6 caracteres';
        }
        
        return self::$alertas;
    }

    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE EMAIL = '" . $this->EMAIL . "' LIMIT 1";
        $resultado = self::$db->query($query);
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El Usuario ya esta registrado';
        }
        return $resultado;
    
    }

    public function hashPassword() {

        $this->PASSWORD = password_hash($this->PASSWORD, PASSWORD_BCRYPT);
        return $this->PASSWORD;
    }

    public function generarToken() {
        $this->TOKEN = uniqid();
        return $this->TOKEN;
    }
}