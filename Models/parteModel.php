<?php

class parteModel extends Mysql
{
    //Propiedades
    private $intIdParte;
    private $intCodigo;
    private $floatCosto;
    private $intStatus;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los registros de la base de datos 
    public function selectRegistros()
    {
        //Creamos una variable a la que se le almacenara la consulta a l bd
        $sql = "SELECT idParte, Codigo, CONCAT('$', FORMAT(Costo, 2)) AS CostoFormato, status, createDate FROM nopartes WHERE status != 0 ";
        //Creamos una variable para pasar la consulta a nuestro metodo "select_all que es un  metodo que esta siendo heredado de la clase Mysql"
        $request = $this->select_All($sql);
        //Retornamos la variable al controlador para que pueda ser leida
        return $request;
    }

    //Agregar registros
    public function insertRegistros(int $codigo, float $costo, int $status)
    {
        //Asignamos los valores de los parametos a las propiedades
        $this->intCodigo = $codigo;
        $this->floatCosto = $costo;
        $this->intStatus = $status;
        $return = 0;
        //Validamos si la variable creada esta vacia entonces hacer la insertacion del rol

        //creamos la variables con el script de la consulta para insertar el rol
        $query_insert = "INSERT INTO nopartes(Codigo,Costo,status) VALUES (?,?,?)";
        //creamos un arreglo para almacenar los valores de las propiedades 
        $arrData = array($this->intCodigo, $this->floatCosto, $this->intStatus);
        //creamos una variable para acceder a la invocacion del metodo insert y le pasamos la variable de la consulta y la variable del arreglo
        $request_insert = $this->insert($query_insert, $arrData);
        $return =  $request_insert;
        return $return;
    }

    //Extraer informacion de registro
    public function selectParte(int $id)
    {
        //Asignamos el valor del parametro ala propiedad
        $this->intIdParte = $id;
        //Cremos la variable de consulta hacia la base 
        $sql = "SELECT idParte, Codigo, Costo, status FROM nopartes WHERE idParte = $this->intIdParte";
        $request = $this->select($sql);
        return $request;
    }

    //Actualizar registros
    public function updateParte(int $id, int $intCodigo, float $floatCosto, int $intStatus)
    {
        //Asignamos los valores de los parametos a las propiedades 
        $this->intIdParte = $id;
        $this->intCodigo = $intCodigo;
        $this->floatCosto = $floatCosto;
        $this->intStatus = $intStatus;


        //creamos la consulta ya para actualizar el registro en la base
        $sql = "UPDATE nopartes SET Codigo = ?, Costo = ?, status = ? WHERE idParte = $this->intIdParte";
        $arrData = array($this->intCodigo, $this->floatCosto, $this->intStatus);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    //Eliminar registros
    public function deleteParte(int $id)
    {
        // Asignamos el valor del parámetro a la propiedad
        $this->intIdParte = $id;
        // Consulta SQL para actualizar el estado del rol
        $sql = "UPDATE nopartes SET status = ? WHERE idParte = ?";
        // Arreglo de datos para la consulta preparada
        $arrData = array(0, $this->intIdParte);
        // Ejecutar la consulta SQL
        $request = $this->update($sql, $arrData);
        // Verificar si la consulta fue exitosa y devolver el resultado
        if ($request === true) {
            return 'ok';
        } else {
            return 'error';
        }
    }
}
