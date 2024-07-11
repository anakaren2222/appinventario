<?php

class Parte extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function parte()
    {
        $data['page_tag'] = "Borgwarner - No. Parte";
        $data['page_title'] = "Pagina principal";
        $data['page_name'] = "Control de inventarios";
        $data['page_functions_js'] = "funP.js";
        $this->views->getView($this, "parte", $data);
    }

    //Metodo para mostrar los registros en la tabla 
    public function getRegistros()
    {
        $arrData = $this->model->selectRegistros();
        for ($i = 0; $i < count($arrData); $i++) {

            //Creamos variables para los botones
            $btnUpdate = "";
            $btnDelete = "";

            if ($arrData[$i]['status'] == 1) {
                $arrData[$i]['status'] = '<span class="bagde" style="color:#004610;"><i class="fas fa-check-circle fa-2x"></i></span>';
            } else {
                $arrData[$i]['status'] = '<span class="bagde" style="color:#560000;"><i class="fas fa-times-circle fa-2x"></i></span>';
            }
            $btnUpdate =
                '<button class="btn btn-sm" style="background: #9BA4B5; color:#fff;" onclick="btnUpdateParte(this,' . $arrData[$i]['idParte'] . ')" title = "Actualizar Parte"><i class="fas fa-edit"></i></button>';
            $btnDelete =
                '<button class="btn btn-sm" style="background: #560000; color:#fff;" onclick="btnDeletedParte(' . $arrData[$i]['idParte'] . ')" title = "Eliminar Parte"><i class="fas fa-trash"></i></button>';

            $arrData[$i]['options'] = '<div class="text-center">'
                . $btnUpdate . ' ' . $btnDelete . ' </div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Agregar registros
    public function setRegistros()
    {
        if ($_POST) {
            if (empty($_POST['txtCodigo']) || empty($_POST['txtCosto']) || empty($_POST['intStatus'])) {
                $arrResponse = array('status' => false, 'msg' => "Todos los datos se requieren");
            } else {
                $intCodigo = intval(strClean($_POST['txtCodigo']));
                $intCosto = strClean($_POST['txtCosto']);
                $intStatus = intval(strClean($_POST['intStatus']));

                $request = $this->model->insertRegistros($intCodigo, $intCosto, $intStatus);

                if ($request > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'No se pudo completar el proceso, verificar codigo');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Eliminar registos
    public function deleteParte($idParte)
    {
        // Convertir idQueja en un entero
        $id = intval($idParte);

        // Validar que $idUsuario sea un número entero positivo
        if ($id <= 0) {
            $arrReponse = array('status' => false, 'msg' => 'Invalid role ID');
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
            die();
        }

        // Si llegamos aquí, el ID de rol es válido, proceder con la eliminación
        $request_Delete = $this->model->deleteParte($id);
        if ($request_Delete == 'ok') {
            $arrReponse = array('status' => true, 'msg' => 'El No. parte se ha eliminado');
        } else {
            $arrReponse = array('status' => false, 'msg' => 'No es posible eliminar');
        }

        // Devolver una respuesta JSON al cliente
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        die();
    }

    //Extraer informacion del registro
    public function getParte($idParte)
    {
        $id = intval($idParte);
        //validamos si la variable es mayor a 0, es decir, si tiene algun valor creamos el arreglo de datos y accedemos al invocacion del metodo en el modelo y le pasamos el parametro del id 
        if ($id > 0) {
            $arrData = $this->model->selectParte($id);
            //Si el arreglo esta vacio mostrara un msj de error
            if (empty($arrData)) {
                $arrReponse = array('status' => false, 'msg' => 'Data no found');
                //En caso contrario imprimira el arreglo de datos
            } else {
                $arrReponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Acrtualizar registro
    public function updateParte($idParte)
    {
        $id = intval($idParte);
        //Validamos que haya una repuesta de tipo POST y validamos la variable que tiene el id del registro sea mayor a 0 
        if ($_POST && $id > 0) {
            //Validamos que cada dato no se encuentre vacio 
            if (empty($_POST['txtCodigoUpdate']) || empty($_POST['txtCostoUpdate']) || empty($_POST['intStatusUpdate'])) {
                //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                //Creamos las variables determinadamos de los names de los inputs de los formularios vamos utilizar un metodo que se encuentra en el helper (strClean) que nos permite limpiar cada campo por cuestion de seguridad y otras funciones de PHP como ucwords e intVal
                $intCodigo = intval(strClean($_POST['txtCodigoUpdate']));
                $floatCosto = strClean($_POST['txtCostoUpdate']);
                $intStatus = intval(strClean($_POST['intStatusUpdate']));
                //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                $request_user = $this->model->updateParte($id, $intCodigo, $floatCosto, $intStatus);
                //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                if ($request_user > 0) {
                    $arrReponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                } else {
                    $arrReponse = array('status' => false, 'msg' => 'Algo paso en el proceso, revisar codigo');
                }
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
