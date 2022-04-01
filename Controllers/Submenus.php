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
            $nmr = 0;
            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = "";
                $btnEdit = "";
                $btnDelete = "";
                $nmr++;
                if ($this->permisos['perm_r'] == 1) {
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntView(' . $arrData[$i]['id'] . ')" title="Ver Submenus"><i class="far fa-eye"></i></button>';
                }
                if ($this->permisos['perm_u'] == 1) {
                    $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrData[$i]['id'] . ')" title="Editar Submenus"><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($this->permisos['perm_d'] == 1) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDel(' . $arrData[$i]['id'] . ')" title="Eliminar Submenus"><i class="far fa-trash-alt"></i></button>';
                }
                if ($arrData[$i]['ver'] == 1) {
                    // $arrData[$i]['ver'] = '<span class="badge badge-success px-3 p-y2">Si</span>';
                    $arrData[$i]['ver'] = '
                    <div class="toggle-flip">
                        <label>
                        <input type="checkbox" checked><span class="flip-indecator" data-toggle-on="Si" data-toggle-off="No"></span>
                        </label>
                    </div>';
                } else {
                    // $arrData[$i]['ver'] = '<span class="badge badge-danger px-3 py-2">No</span>';
                    $arrData[$i]['ver'] = '
                    <div class="toggle-flip">
                        <label>
                        <input type="checkbox"><span class="flip-indecator" data-toggle-on="Si" data-toggle-off="No"></span>
                        </label>
                    </div>';
                }
                $arrData[$i]['options'] = '<div class="btn-group text-center" role="group" aria-label="Basic example">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                $arrData[$i]['menu'] = '<i class="app-menu__icon ' . $arrData[$i]['icono2'] . '"></i> ' . ucwords($arrData[$i]['menu']);
                $arrData[$i]['url'] = strtolower($arrData[$i]['submenu']);
                $arrData[$i]['submenu'] = '<i class="app-menu__icon ' . $arrData[$i]['icono'] . '"></i> ' . ucfirst($arrData[$i]['submenu']);
                $arrData[$i]['nmr'] = $nmr;
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
            if (empty($_POST['txtSub_nombre']) || empty($_POST['txtSub_url'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idmenu = (isset($_POST['txtIdmenu']) && !empty($_POST['txtIdmenu'])) ? strClean($_POST['txtIdmenu']) : '0';
                $idsubmenu = (isset($_POST['item']) && !empty($_POST['item'])) ? strClean($_POST['item']) : 0;
                $sub_nombre = (isset($_POST['txtSub_nombre']) && !empty($_POST['txtSub_nombre'])) ? strClean($_POST['txtSub_nombre']) : '';
                $sub_url = (isset($_POST['txtSub_url']) && !empty($_POST['txtSub_url'])) ? strClean($_POST['txtSub_url']) : '#';
                $sub_controlador = (isset($_POST['txtSub_controlador']) && !empty($_POST['txtSub_controlador'])) ? strClean($_POST['txtSub_controlador']) : '';
                $sub_icono = (isset($_POST['txtSub_icono']) && !empty($_POST['txtSub_icono'])) ? strClean($_POST['txtSub_icono']) : 'fa-solid fa-circle-notch';
                $sub_orden = (isset($_POST['txtSub_orden']) && !empty($_POST['txtSub_orden'])) ? strClean($_POST['txtSub_orden']) : '0';
                $sub_visible = (isset($_POST['txtSub_visible'])) ? strClean($_POST['txtSub_visible']) : '1';
                $response = '';

                if ($idsubmenu == 0) {
                    if ($this->permisos['perm_w'] == 1) {
                        $response = $this->model->insertar(
                            $idmenu,
                            $sub_nombre,
                            $sub_url,
                            $sub_controlador,
                            $sub_icono,
                            $sub_orden,
                            $sub_visible
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
                            $idsubmenu,
                            $sub_nombre,
                            $sub_url,
                            $sub_controlador,
                            $sub_icono,
                            $sub_orden,
                            $sub_visible
                        );
                        if ($response['status']) {
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => 'Registro actualizado.');
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
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
                $arrResponse = array("status" => false, 'warning' => 'info', 'title' => 'Atención!!', "text" => 'Esta intentando una petición sin parametros.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        exit();
    }

    public function menus()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            if ($this->permisos['perm_r']) {
                $arrData = $this->model->menus();
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
}
