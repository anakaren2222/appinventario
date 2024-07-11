<?php

class homeModel extends Mysql
{
    //Propiedades
    private $intIdRegistro;
    private $intNoParte;
    private $strLinea;
    private $strUbicacion;
    private $strDescripcion;
    private $strResponsable;
    private $intCantidad;
    private $intStatus;
    private $intCosto;
    private $intCostoTotal;

    public function __construct()
    {
        parent::__construct();
    }

    //Metodo para extraer los registros de la base de datos 
    public function selectRegistros()
    {
        //Creamos una variable a la que se le almacenara la consulta a l bd
        $sql = "SELECT i.idInventario, i.No_Parte_id, CONCAT('$', FORMAT(i.Costo, 2)) AS CostoFormato, CONCAT('$', FORMAT(i.CostoTotal, 2)) as costoTotalformato, i.Linea, i.Ubicacion, i.Descripcion, i.Responsable, i.Cantidad, i.Status, i.CreateDate as FechaCreacion, i.UpdateDate as FechaActualizacion, n.idParte, n.Codigo, n.Costo FROM inventario i INNER JOIN nopartes n ON i.No_Parte_id = n.idParte WHERE i.Status != 0";
        //Creamos una variable para pasar la consulta a nuestro metodo "select_all que es un  metodo que esta siendo heredado de la clase Mysql"
        $request = $this->select_All($sql);
        //Retornamos la variable al controlador para que pueda ser leida
        return $request;
    }

    //Metodo para extraer las opciones de lo numeros de parte
    public function selectOpciones()
    {
        $sql = "SELECT idParte, Codigo, Costo, status FROM nopartes WHERE status != 0 ORDER BY Codigo ASC";
        $request = $this->select_All($sql);
        return $request;
    }

    //Metodo para agregar registros
    public function insertRegistro(int $Cantidad, int $Parte, float $costo, string $Ubicacion, string $Linea, string $Responsable, string $Descripcion, float $costoTotal)
    {
        //Asignamos los valores a los propiedades
        $this->intCantidad = $Cantidad;
        $this->intNoParte = $Parte;
        $this->intCosto = $costo;
        $this->strUbicacion = $Ubicacion;
        $this->strLinea = $Linea;
        $this->strResponsable = $Responsable;
        $this->strDescripcion = $Descripcion;
        $this->intCostoTotal = $costoTotal;

        //Si esta vacia, realizamos la consulta para insertar el registro nuevo a la base
        $query_insert = "INSERT INTO inventario(Cantidad, No_Parte_id, Costo, Ubicacion,Linea,Responsable,Descripcion,CostoTotal) VALUES (?,?,?,?,?,?,?,?)";
        $arrData = array($this->intCantidad, $this->intNoParte, $this->intCosto, $this->strUbicacion, $this->strLinea, $this->strResponsable, $this->strDescripcion, $this->intCostoTotal);
        $request_insert = $this->insert($query_insert, $arrData);
        $return = $request_insert;

        return $return;
    }

    //Metodo para visualizar la informacion del registro
    public function selectRegistro(int $idInventario)
    {
        //Asignamos el valor a la propiedad
        $this->intIdRegistro = $idInventario;
        $sql = "SELECT i.No_Parte_id, i.Linea, i.Costo, i.CostoTotal, i.Ubicacion,i. Descripcion, i.Responsable, i.Cantidad, i.CreateDate as FechaCreacion, i.UpdateDate as FechaActualizacion, n.idParte, n.Codigo, n.Costo FROM inventario i INNER JOIN nopartes n ON i.No_Parte_id = n.idParte WHERE i.idInventario = $this->intIdRegistro AND i.Status != 0";
        $request = $this->select($sql);
        return $request;
    }

    //Metodo para actualizar la informacion del registro
    public function updateRegistro(int $id, int $Cantidad, int $Parte, float $costo, string $Ubicacion, string $Linea, string $Responsable, string $Descripcion, float $costoTotal)
    {
        //Asignamos los valores de los parametros a las propiedades 
        $this->intIdRegistro = $id;
        $this->intCantidad = $Cantidad;
        $this->intNoParte = $Parte;
        $this->intCosto = $costo;
        $this->strUbicacion = $Ubicacion;
        $this->strLinea = $Linea;
        $this->strResponsable = $Responsable;
        $this->strDescripcion = $Descripcion;
        $this->intCostoTotal = $costoTotal;

        $sql = "UPDATE inventario SET Cantidad = ?, No_Parte_id = ?, Costo = ?, Ubicacion = ?, Linea = ?, Responsable = ?, Descripcion = ?, CostoTotal = ?, UpdateDate = NOW() WHERE idInventario = $this->intIdRegistro";
        $arrData = array($this->intCantidad, $this->intNoParte, $this->intCosto, $this->strUbicacion, $this->strLinea, $this->strResponsable, $this->strDescripcion, $this->intCostoTotal);
        $request = $this->update($sql, $arrData);
        return $request;
    }

    //Metodo para eliminar el registro 
    public function deleteRegistro(int $idInventario)
    {
        // Asignamos el valor del parámetro a la propiedad
        $this->intIdRegistro = $idInventario;
        $sql = "UPDATE inventario SET Status = ?, DeleteDate = Now() WHERE idInventario = ?";
        $arrData = array(0, $this->intIdRegistro);
        $request = $this->update($sql, $arrData);
        if ($request === true) {
            return 'ok';
        } else {
            return 'error';
        }
    }
}
