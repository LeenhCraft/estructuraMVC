<?php 
class Permisos extends Controllers
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

    public function permisos()
    {
        $data['titulo_web']   = "Permisos";
        $data['js'] = ['js/app/nw_permisos.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Permisos', "permisos", $data);
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
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntView('.$arrData[$i]['idpermisos'].')" title="Ver Permisos"><i class="far fa-eye"></i></button>'  ;
                }
                if ($this->permisos['perm_u'] == 1) {
                    $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit('.$arrData[$i]['idpermisos'].')" title="Editar Permisos"><i class="fas fa-pencil-alt"></i></button>'  ;
                }
                if ($this->permisos['perm_d'] == 1) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDel('.$arrData[$i]['idpermisos'].')" title="Eliminar Permisos"><i class="far fa-trash-alt"></i></button>'  ;
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
            if (empty($_POST['idrol'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idpermisos=(isset($_POST['idpermisos'])&&!empty($_POST['idpermisos']))?strClean($_POST['idpermisos']):'';$idrol=(isset($_POST['idrol'])&&!empty($_POST['idrol']))?strClean($_POST['idrol']):'';$idsubmenu=(isset($_POST['idsubmenu'])&&!empty($_POST['idsubmenu']))?strClean($_POST['idsubmenu']):'';$perm_r=(isset($_POST['perm_r'])&&!empty($_POST['perm_r']))?strClean($_POST['perm_r']):'';$perm_w=(isset($_POST['perm_w'])&&!empty($_POST['perm_w']))?strClean($_POST['perm_w']):'';$perm_u=(isset($_POST['perm_u'])&&!empty($_POST['perm_u']))?strClean($_POST['perm_u']):'';$perm_d=(isset($_POST['perm_d'])&&!empty($_POST['perm_d']))?strClean($_POST['perm_d']):'';
                $response ='';

                if (empty($idpermisos)) {                    
                    if ($this->permisos['perm_w'] == 1) {
                        $response = $this->model->insertar(
                            $idrol,$idsubmenu,$perm_r,$perm_w,$perm_u,$perm_d
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
                            $idpermisos,$idrol,$idsubmenu,$perm_r,$perm_w,$perm_u,$perm_d
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
