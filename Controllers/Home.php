<?php

class Home extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    //Vista principal Home.php
    public function home()
    {
        $data['page_tag'] = "Borgwarner";
        $data['page_title'] = "Pagina principal";
        $data['page_name'] = "Control de inventarios";
        $data['page_functions_js'] = "funci.js";
        $this->views->getView($this, "home", $data);
    }

    //Metodo para extraer los registros a la tabla 
    public function getRegistros()
    {
        // Recuperar los datos de la base de datos
        $arrData = $this->model->selectRegistros();

        // Para mostrar la cantidad de registros, creamos un forEach para iterar sobre cada elementos del array. 
        foreach ($arrData as &$row) {
            // Creamos el boton para ver la informacion del registro
            $btnView =
                '<button class="btn btn-sm" style="background: #454545; color:#fff;" onclick="btnView(' . $row['idInventario'] . ')" title="Ver Informacion"><i class="fas fa-eye"></i></button>';

            // Creamos el boton para actualizar la informacion 
            $btnUpdate =
                '<button class="btn btn-sm" style="background: #739072; color:#fff;" onclick="btnUpdate(this,' . $row['idInventario'] . ')" title="Actualizar registro"><i class="fas fa-edit"></i></button>';

            // Creamos el boton para eliminar el registro
            $btnDelete =
                '<button class="btn btn-sm" style="background: #800000; color:#fff;" onclick="btnDelete(' . $row['idInventario'] . ')" title="Eliminar registro"><i class="fas fa-trash"></i></button>';

            $row['options'] = '<div class="text-center">'
                . $btnView . ' ' . $btnUpdate . ' ' . $btnDelete . '</div>';
        }

        // Convertir el arreglo completo a JSON y enviarlo al cliente
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);

        die(); // Terminamos el proceso
    }

    //Metodo para extraer los numeros de parte 
    public function getOpciones()
    {
        $arrData = $this->model->selectOpciones();
        $options = [];

        if (count($arrData) > 0) {
            for ($i = 0; $i < count($arrData); $i++) {
                if ($arrData[$i]['status'] == 1) {
                    $options[] = [
                        'id' => $arrData[$i]['idParte'],
                        'codigo' => $arrData[$i]['Codigo'],
                        'costo' => $arrData[$i]['Costo']
                    ];
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($options);
        die();
    }


    //Metodo para agregar registros a la bd 
    public function setRegistro()
    {
        //Validamos si realmente existe una peticion al servidor
        if ($_POST) {
            //Validamos que los campos no vayan vacios del lado del backEnd
            if (empty($_POST['txtCantidad']) || empty($_POST['txtParte']) || empty($_POST['txtCosto']) || empty($_POST['txtUbicacion']) || empty($_POST['txtLinea']) || empty($_POST['txtResponsable']) || empty($_POST['txtDescripcion']) || empty($_POST['txtCostoTotal'])) {
                //Creamos nuestro arreglo de daos con un tipo false
                $arrResponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                //En caso contrario que los datos esten correctos pasamos los names de los campos a variables para pasarlas al metodo que se enviara al modelo para realizar la consulta 
                $intCantidad = intval(strClean($_POST['txtCantidad']));
                $intParte = intval(strClean($_POST['txtParte']));
                $intCosto = strClean($_POST['txtCosto']);
                $strUbicacion = strClean($_POST['txtUbicacion']);
                $strLinea = strClean($_POST['txtLinea']);
                $strResponsable = strClean($_POST['txtResponsable']);
                $strDescripcion = strClean($_POST['txtDescripcion']);
                $intCostoTotal = strClean($_POST['txtCostoTotal']);
                //Creamos la variable para almacenar el metodo que ocuparemos en el modelo y le pasamos cada uno de nuestras variables
                $request = $this->model->insertRegistro($intCantidad, $intParte, $intCosto, $strUbicacion, $strLinea, $strResponsable, $strDescripcion, $intCostoTotal);
                //Creamos las validaciones correspondientes en caso que este correcta la respuesta devuelta por el modelo 
                if ($request > 0) {
                    $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error, algo paso en el procesoooooo, revisar el código');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
    }

    //Metodo para visualizar la informacion del registro
    public function getRegistro($idInventario)
    {
        //Creamos una variable que nos va a servir para identificar a cada registro por su id
        $id = intval($idInventario);
        //Validamos si la variable tiene algo
        if ($id > 0) {
            $arrData = $this->model->selectRegistro($id);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para actualizar la informacion del registro
    public function updateRegistro($idInventario)
    {
        
        $id = intval($idInventario);
        //Validamos que haya una repuesta de tipo POST
        if ($_POST && $id > 0) {
            //Validamos que cada dato no se encuentre vacio 
            if (empty($_POST['txtParteUpdate']) || empty($_POST['txtLineaUpdate']) || empty($_POST['txtUbicacionUpdate']) || empty($_POST['txtDescripcionUpdate']) || empty($_POST['txtResponsableUpdate']) || empty($_POST['txtCantidadUpdate']) || empty($_POST['txtCostoUpdate']) || empty($_POST['txtCostoTotalUpdate'])) {
                //Creamos una variable donde almacenamos un array con el estado y lo punteamos a false y agregamos un mensaje de error
                $arrReponse = array('status' => false, 'msg' => 'Datos incorrectos');
            } else {
                $intCantidad = intval(strClean($_POST['txtCantidadUpdate']));
                $intParte = intval(strClean($_POST['txtParteUpdate']));
                $intCosto = strClean($_POST['txtCostoUpdate']);
                $strUbicacion = strClean($_POST['txtUbicacionUpdate']);
                $strLinea = strClean($_POST['txtLineaUpdate']);
                $strResponsable = strClean($_POST['txtResponsableUpdate']);
                $strDescripcion = strClean($_POST['txtDescripcionUpdate']);
                $intCostoTotal = strClean($_POST['txtCostoTotalUpdate']);
                $request_Registro = "";
                //Creamos la variable para acceder a la invocacion del metodo que sera creado en el modelo para ejecutar la consulta a la base de datos juntos con los parametros
                $request_Registro = $this->model->updateRegistro($id, $intCantidad, $intParte, $intCosto, $strUbicacion, $strLinea, $strResponsable, $strDescripcion, $intCostoTotal);
                //Validamos la variable que request_user para los mensajes de error como usuario repetido o correo repetido
                if ($request_Registro > 0) {
                    $arrReponse = array('status' => true, 'msg' => 'Datos actualizados correctamente');
                } else {
                    $arrReponse = array('status' => false, 'msg' => '!Error¡ Algo paso en el proceso, revisar el código.');
                }
            }
            echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    //Metodo para eliminar el registro
    public function deleteRegistro($idInventario)
    {
        $id = intval($idInventario);
        if ($id <= 0) {
            $arrResponse = array('status' => false, 'msg' => 'Id invalido');
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        }
        $request_Delete = $this->model->deleteRegistro($id);
        if ($request_Delete == 'ok') {
            $arrReponse = array('status' => true, 'msg' => 'El registro ha sido eliminado.');
        } else {
            $arrReponse = array('status' => false, 'msg' => 'No es posible eliminar este registro.');
        }

        // Devolver una respuesta JSON al cliente
        echo json_encode($arrReponse, JSON_UNESCAPED_UNICODE);
    }
}
