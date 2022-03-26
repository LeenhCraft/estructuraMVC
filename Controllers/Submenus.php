<?php 
class Submenus extends Controllers
{
    private $permisos;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->permisos = getPermisos(get_class($this));
        if (!isset($_SESSION['login']) || $this->permisos['perm_r'] != 1) {
            header('Location: ' . base_url() . 'login');
        }
    }

    public function submenus()
    {
        $data['titulo_web']   = "Submenus";
        $data['js'] = ['js/app/nw_submenus.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Submenus', "submenus", $data);
    }

    public function listar()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST" && $this->permisos['perm_r'] == 1) {
            $arrData = $this->model->listar();
            // dep($arrData);exit;
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = "";
                $btnEdit = "";
                $btnDelete = "";
                if ($this->permisos['perm_r'] == 1) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntView('.$arrData[$i]['idsubmenu'].')" title="Ver Submenus"><i class="far fa-eye"></i></button>'  ;
                }
                if ($this->permisos['perm_u'] == 1) {
                    $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit('.$arrData[$i]['idsubmenu'].')" title="Editar Submenus"><i class="fas fa-pencil-alt"></i></button>'  ;
                }
                if ($this->permisos['perm_d'] == 1) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDel('.$arrData[$i]['idsubmenu'].')" title="Eliminar Submenus"><i class="far fa-trash-alt"></i></button>'  ;
                }

                $arrData[$i]['options'] = '<div class="btn-group text-center" role="group" aria-label="Basic example">' .$btnView. ' ' .$btnEdit. ' ' .$btnDelete. '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function buscar($parametros)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET" && $this->permisos['perm_r'] == 1) {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            $id = (!empty($parametros)) ? intval($parametros) : 0;
            if ($id != 0) {
                if ($this->permisos['perm_u'] == 1) {
                    $response = $this->model->buscar($id);
                    if (!empty($response)) {
                        $arrResponse = array("status" => true, 'icon' => '', 'title' => '', "data" => $response);
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No se encontraron registros.');
                    }
                }
            } else {
                $arrResponse = array("status" => false, 'warning' => 'info', 'title' => 'Atención!!', "text" => 'Esta intentando una petición sin parametros.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }

    public function acc()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            if (empty($_POST['idmenu'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idsubmenu=(isset($_POST['idsubmenu'])&&!empty($_POST['idsubmenu']))?strClean($_POST['idsubmenu']):'';$idmenu=(isset($_POST['idmenu'])&&!empty($_POST['idmenu']))?strClean($_POST['idmenu']):'';$sub_nombre=(isset($_POST['sub_nombre'])&&!empty($_POST['sub_nombre']))?strClean($_POST['sub_nombre']):'';$sub_url=(isset($_POST['sub_url'])&&!empty($_POST['sub_url']))?strClean($_POST['sub_url']):'';$sub_controlador=(isset($_POST['sub_controlador'])&&!empty($_POST['sub_controlador']))?strClean($_POST['sub_controlador']):'';$sub_icono=(isset($_POST['sub_icono'])&&!empty($_POST['sub_icono']))?strClean($_POST['sub_icono']):'';$sub_orden=(isset($_POST['sub_orden'])&&!empty($_POST['sub_orden']))?strClean($_POST['sub_orden']):'';$sub_visible=(isset($_POST['sub_visible'])&&!empty($_POST['sub_visible']))?strClean($_POST['sub_visible']):'';$sub_fecha=(isset($_POST['sub_fecha'])&&!empty($_POST['sub_fecha']))?strClean($_POST['sub_fecha']):'';
                $response ='';

                if (empty($idsubmenu)) {                    
                    if ($this->permisos['perm_w'] == 1) {
                        $response = $this->model->insertar(
                            $idmenu,$sub_nombre,$sub_url,$sub_controlador,$sub_icono,$sub_orden,$sub_visible,$sub_fecha
                        );
                        if ($response['status']) {
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => $response['data']);
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
                        }
                    }
                } else {
                    if ($this->permisos['perm_u'] == 1) {
                        $response = $this->model->actualizar(
                            $idsubmenu,$idmenu,$sub_nombre,$sub_url,$sub_controlador,$sub_icono,$sub_orden,$sub_visible,$sub_fecha
                        );
                        if ($response) {
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => 'Registro actualizado.');
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Ocurrio un error al intentar actualizar.');
                        }
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function eliminar($parametros)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST" && $this->permisos['perm_r'] == 1) {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            $id = (!empty($parametros)) ? intval($parametros) : 0;
            if ($id != 0) {
                if ($this->permisos['perm_d'] == 1) {
                    $response=['status'=>true,'data'=>''];
                    //$response = $this->model->buscarid($id);
                    if ($response['status']) {
                        $response = $this->model->eliminar($id);
                        if ($response['status']) {
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => $response['data']);
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
                        }
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
                    }
                }
            } else {
                $arrResponse = array("status" => false, 'warning' => 'info', 'title' => 'Atención!!', "text" => 'Esta intentando una petición sin parametros.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }
}
