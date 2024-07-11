<?php
//Creamos la clase conexion 
class Conexion {
    //propiedades
    private $conect;

    //constructor
    public function __construct()
    {
        //variable que contiene las propiedades "host y la base"
        $conectionString = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";DB_CHARSET.";

        try {
            $this->conect = new PDO($conectionString, DB_ROOT, DB_PASSWORD);
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            // Lanza una excepción en lugar de asignar una cadena
            throw new Exception("Error de conexión: " . $e->getMessage());
        }
    }

    //Creamos un metodo para poder utilizar la conexion en otros archivos mediante el constuctor 
    public function connect(){
        return $this->conect;
    }
}
?>