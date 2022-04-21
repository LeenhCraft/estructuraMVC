<?php
class Permisos extends Controllers
{
    private $permisos;

    public function __construct()
    {
        $url = !empty($_GET['url']) ? $_GET['url'] : 'web/web';
        $arrUrl = explode("/", $url);
        if (isset($arrUrl[1]) && $arrUrl[1] === 'toggle') {
            exit;
        }
        parent::__construct();
        // session_start();
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
            $num = 0;
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = "";
                $btnEdit = "";
                $btnDelete = "";
                $num++;
                // if ($this->permisos['perm_r'] == 1) {
                //     $btnView = '<button class="btn btn-info btn-sm" onClick="fntView(' . $arrData[$i]['idpermisos'] . ')" title="Ver Permisos"><i class="far fa-eye"></i></button>';
                // }
                // if ($this->permisos['perm_u'] == 1) {
                //     $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrData[$i]['idpermisos'] . ')" title="Editar Permisos"><i class="fas fa-pencil-alt"></i></button>';
                // }
                $arrData[$i]['r'] = $this->toggle($arrData[$i]['r'], $arrData[$i]['id'], 20);
                $arrData[$i]['w'] = $this->toggle($arrData[$i]['w'], $arrData[$i]['id'], 21);
                $arrData[$i]['u'] = $this->toggle($arrData[$i]['u'], $arrData[$i]['id'], 22);
                $arrData[$i]['d'] = $this->toggle($arrData[$i]['d'], $arrData[$i]['id'], 23);

                if ($this->permisos['perm_d'] == 1) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDel(' . $arrData[$i]['id'] . ')" title="Eliminar Permisos"><i class="bx bx-minus-circle"></i></button>';
                }

                $arrData[$i]['options'] = '<div class="btn-group text-center" role="group" aria-label="Basic example">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                $arrData[$i]['nmr'] = $num;
                $arrData[$i]['menu'] = ucwords($arrData[$i]['menu']);
                $arrData[$i]['submenu'] = ucwords($arrData[$i]['submenu']);
                $arrData[$i]['rol'] = ucwords($arrData[$i]['rol']);
            }
            // dep($arrData, 1);
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
            $idpermisos = (isset($_POST['idIdpermisos']) && !empty($_POST['idIdpermisos'])) ? intval($_POST['idIdpermisos']) : '0';
            $idrol = (isset($_POST['txtIdrol']) && !empty($_POST['txtIdrol'])) ? intval($_POST['txtIdrol']) : '0';
            $idsubmenu = (isset($_POST['txtIdsubmenu']) && !empty($_POST['txtIdsubmenu'])) ? strClean($_POST['txtIdsubmenu']) : '0';
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            if ($idrol == '0' || $idsubmenu == '0') {
                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Datos incorrectos!');
            } else {
                $perm_r = (isset($_POST['perm_r']) && !empty($_POST['perm_r'])) ? strClean($_POST['perm_r']) : '0';
                $perm_w = (isset($_POST['perm_w']) && !empty($_POST['perm_w'])) ? strClean($_POST['perm_w']) : '0';
                $perm_u = (isset($_POST['perm_u']) && !empty($_POST['perm_u'])) ? strClean($_POST['perm_u']) : '0';
                $perm_d = (isset($_POST['perm_d']) && !empty($_POST['perm_d'])) ? strClean($_POST['perm_d']) : '0';
                $response = '';

                if (empty($idpermisos)) {
                    if ($this->permisos['perm_w'] == 1) {
                        $response = $this->model->insertar(
                            $idrol,
                            $idsubmenu,
                            $perm_r,
                            $perm_w,
                            $perm_u,
                            $perm_d
                        );
                        if ($response['status']) {
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => $response['data']);
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
                        }
                    }
                    // } else {
                    //     if ($this->permisos['perm_u'] == 1) {
                    //         $response = $this->model->actualizar(
                    //             $idpermisos,
                    //             $idrol,
                    //             $idsubmenu,
                    //             $perm_r,
                    //             $perm_w,
                    //             $perm_u,
                    //             $perm_d
                    //         );
                    //         if ($response) {
                    //             $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => 'Registro actualizado.');
                    //         } else {
                    //             $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Ocurrio un error al intentar actualizar.');
                    //         }
                    //     }
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
                    $response = ['status' => true, 'data' => ''];
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
                $arrResponse = array("status" => false, 'warning' => 'info', 'title' => 'Atención!!', "text" => 'Esta intentando una acción sin parametros.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }

    public function roles()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            if ($this->permisos['perm_r']) {
                $arrData = $this->model->roles();
                if (empty($arrData)) {
                    $arrData['id'] = 0;
                    $arrData['nombre'] = 'Sin información';
                }
                $arrResponse = array("status" => true, 'icon' => 'success', 'title' => '', "text" => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function submenus()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            if ($this->permisos['perm_r']) {
                $arrData = $this->model->submenus();
                if (empty($arrData)) {
                    $arrData['id'] = 0;
                    $arrData['nombre'] = 'Sin información';
                }
                $arrResponse = array("status" => true, 'icon' => 'success', 'title' => '', "text" => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function activar()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            $id = (isset($_POST['id'])) ? intval($_POST['id']) : '0';
            $ac = (isset($_POST['ac'])) ? intval($_POST['ac']) : '0';
            $estado = (isset($_POST['ab'])) ? strClean($_POST['ab']) : 'false';
            $estado = ($estado == 'true') ? '1' : '0';

            switch ($ac) {
                case $ac == 20:
                    $ac = 'perm_r=';
                    break;
                case $ac == 21:
                    $ac = 'perm_w=';
                    break;
                case $ac == 22:
                    $ac = 'perm_u=';
                    break;
                case $ac == 23:
                    $ac = 'perm_d=';
                    break;
                default:
                    $ac = 'perm_r=0,perm_w=0,perm_u=0,perm_d=0';
                    break;
            }
            // if ($this->permisos['perm_r']) {
            $arrData = $this->model->up_perm($id, $ac . $estado);
            if ($arrData['status']) {
                //         $arrData['id'] = 0;
                //         $arrData['nombre'] = 'Sin información';
                //     }
                $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Actualizado', "text" => $arrData['data']);
            } else {
                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => '', "text" => $arrData['data']);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    private function toggle($arr, $id, $acc)
    {
        $activo = '';
        /*<div class="form-check form-switch mb-2">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
            <label class="form-check-label" for="flexSwitchCheckDefault">Default switch checkbox input</label>
        </div> */
        $toggle = '<div class="form-check form-switch"><input class="form-check-input" type="checkbox"';
        $end_toggle = ' onclick="fntActv(this,' . $id . ',' . $acc . ')" ></div>';
        if ($arr == 1) {
            $activo = 'checked';
            $arr =  $toggle . $activo . $end_toggle;
        } else {
            $activo = '';
            $arr =  $toggle . $activo . $end_toggle;
        }
        return $arr;
    }
}
