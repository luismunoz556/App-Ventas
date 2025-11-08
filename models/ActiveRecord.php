<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    // Obtener la conexión a la BD
    public static function getDB() {
        return self::$db;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);
        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;
        //debuguear($registro);
        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            // Manejar null correctamente - no usar escape_string con null
            if(is_null($value)) {
                $sanitizado[$key] = null;
            } else {
                $sanitizado[$key] = self::$db->escape_string($value);
            }
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function guardar() {
        $resultado = '';
        if(!is_null($this->id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE id = {$id}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    public static function where($campo, $valor) {
        $query = "SELECT * FROM " . static::$tabla  ." WHERE ". $campo . " = '{$valor}'";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT {$limite}";
        $resultado = self::consultarSQL($query);
        return array_shift( $resultado ) ;
    }

    // crea un nuevo registro
    public function crear() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        //debuguear($atributos);
        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (";
        
        // Construir valores manejando NULL correctamente
        $valores = [];
        foreach($atributos as $value) {
            if(is_null($value)) {
                $valores[] = "NULL";
            } else {
                $valores[] = "'" . $value . "'";
            }
        }
        $query .= join(", ", $valores);
        $query .= ") ";
        
        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function actualizar() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD, manejando NULL correctamente
        $valores = [];
        foreach($atributos as $key => $value) {
            if(is_null($value)) {
                $valores[] = "{$key}=NULL";
            } else {
                $valores[] = "{$key}='{$value}'";
            }
        }

        // Consulta SQL
        $query = "UPDATE " . static::$tabla ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function eliminar() {
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public static function joinMultiple($tabela1, $campo1, $tabela2, $campo2,$valor2,$tabela3='', $campo3='',$valor3='') {
        $query = "SELECT  ";
        $query .= " C1.*,C2.".$valor2;
        if($tabela3) {
            $query .= " C3.".$valor3;
        }
        $query .= " FROM " . $tabela1 . " C1 ";
        $query .= " JOIN " . $tabela2 . " C2 ON C1." . $campo1 . " = C2." . $campo2 . " ";
        if($tabela3) {
            $query .= " JOIN " . $tabela3 . " C3 ON C1." . $campo1 . " = C3." . $campo3 . " ";
        }
        //debuguear($query);
        $resultado = self::consultarSQL($query);
        return $resultado;

    }

    public static function buscaCampoValor($campo,$llave,$valor) {
        $query = "SELECT ".$campo." FROM " . static::$tabla  ." WHERE ". $llave . " = '{$valor}'";
        //debuguear($query);
        $resultado = self::$db->query($query);
        
        if($resultado && $resultado->num_rows > 0) {
            $registro = $resultado->fetch_assoc();
            $resultado->free();
            return $registro[$campo] ?? null;
        }
        
        return null;
    }

}    