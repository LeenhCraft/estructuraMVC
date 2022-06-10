<?php
class Reqcompra extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        // session_start();
        $this->permisos = getPermisos(get_class($this));
        if (!isset($_SESSION['login']) || $this->permisos['perm_r'] != 1) {
            header('Location: ' . base_url() . 'login');
        }
    }

    public function reqcompra()
    {
        $data['titulo_web']   = "Requerimientocompra - Biblio Web 2.0";
        $data['js'] = ['js/app/nw_reqcompra.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Reqcompra', "reqcompra", $data);
    }

    public function listar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                $arrResponse = $this->model->listar();
                //
                for ($i = 0; $i < count($arrResponse); $i++) {
                    $btnEdit = '';
                    $btn = '';

                    //
                    //$arrResponse[$i]['id'] = '';
                    //
                    $btn = '<input type="number" id="cant' . $arrResponse[$i]['id'] . '" class="form-control text-center" value="1">';

                    $btnEdit = '<button type="button" class="btn btn-success btn-sm" onClick="agregarDetalle(' . $arrResponse[$i]['id'] . ',' . $arrResponse[$i]['isbn'] . ',' . "'" . $arrResponse[$i]['titulo'] . "'" . ',' . "'" . $arrResponse[$i]['autor'] . "'" . ',' . ')" title=""><i class="bx bx-add-to-queue"></i></button>';

                    // $btnEdit = '<button type="button" class="btn btn-success btn-sm" onClick="agregarDetalle(' . $arrResponse[$i]['id'] . ',' . $arrResponse[$i]['isbn'] . ',' . "'" . $arrResponse[$i]['titulo'] . "'" . ',' . "'" . $arrResponse[$i]['autor'] . "'" . ','.')" title=""><i class="bx bx-add-to-queue"></i></button>';


                    //opciones
                    $arrResponse[$i]['options'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btnEdit . '' . $btn . '</div>';
                }
                //
                // dep($arrResponse,1);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }



    public function registrar()
    {
        //dep($_POST,1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_w'] == 1) {
                //asiganamos variables
                $libros = (isset($_POST['libro'])) ? $_POST['libro'] : [];
                $cant = (isset($_POST['cant'])) ? $_POST['cant'] : [];
                //esto es un if chiquito, el isset comprueba si existe y es diferente de null, si existe le asigna el valor que llega por post (desues del ?), si no le crea uno (despues del :)
                $codReq = (isset($_POST['ficha_cod'])) ? $_POST['ficha_cod'] : $this->model->codigo(); //lo cambien porque ya teniamos una fucion que lo generaba y lo comprobaba si es unico
                $idusuario = $_SESSION['lnh_id'];
                $estado = 1; //1 es activo (true )0 es inactivo (false)
                //$fecha = date('');//no es necesario hacer una fecha desde aca, la bd esta configurdad que la fecha sea automatica

                //validamos que la cantidad y el libro sean correctos
                for ($i = 0; $i < count($libros); $i++) {
                    //(!empty($libros[$i])) -> si no esta vacio
                    $libros[$i] = (!empty($libros[$i])) ? intval($libros[$i]) : exit(json_encode(["status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Ocurrio un error con los libros seleccionados.'], JSON_UNESCAPED_UNICODE));
                    //(intval($cant[$i]) > 0) -> si la cantidad es diferente de 0, no acetaremos reque con cantidad cero :v
                    $cant[$i] = (intval($cant[$i]) > 0) ? intval($cant[$i]) : exit(json_encode(["status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'La cantidad de libros es errónea.'], JSON_UNESCAPED_UNICODE));
                }
                //validamos

                if (!empty($libros)) { //vemos si tenemos libros
                    if (!empty($cant)) { //vemos si las cantidades son != 0
                        //registrar
                        $request = $this->model->registrar($libros, $cant, $codReq, $idusuario, $estado);
                        if ($request['status']) {
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Se registro el prestamo correctamente.');
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Ocurrio un error al registrar el prestamo.');
                        }
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No selecciono ninguna cantidad.');
                    }
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No selecciono ningun libro.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function op3()
    {
        $return = $this->model->codigo(); //para generar un codigo primero debemos de ver si no esta en la bd osea si no existe, queremos que sea unico
        $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'ok', "text" => '', 'data' => $return);
        // y ya solo queda retornar a la vista el codigo
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }
}
