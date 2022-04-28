<?php
class Menus extends Controllers
{
    private $permisos;
    public function __construct()
    {
        parent::__construct();
        // session_start();
        $this->permisos = getPermisos(get_class($this));
        if (!isset($_SESSION['login']) || $this->permisos['perm_r'] != 1) {
            header('Location: ' . base_url() . 'login');
        }
    }

    public function menus()
    {
        $data['titulo_web']   = "Menus";
        $data['js'] = ['js/app/nw_menus.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Menus', "menus", $data);
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
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntView(' . $arrData[$i]['idmenu'] . ')" title="Ver Menus"><i class="bx bx-show-alt"></i></button>';
                }
                if ($this->permisos['perm_u'] == 1) {
                    $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrData[$i]['idmenu'] . ')" title="Editar Menus"><i class="bx bxs-edit-alt"></i></button>';
                }
                if ($this->permisos['perm_d'] == 1) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDel(' . $arrData[$i]['idmenu'] . ')" title="Eliminar Menus"><i class="bx bxs-trash-alt" ></i></button>';
                }
                if ($arrData[$i]['men_visible'] == 1) {
                    // $arrData[$i]['ver'] = '<span class="badge badge-success px-2 p-y1">Si</span>';
                    $arrData[$i]['ver'] = '
                    <div class="border-0 d-flex justify-content-center">
                        <div class="input-group-text border-0">
                            <input class="form-check-input mt-0" type="checkbox" checked>
                        </div>
                    </div>
                    ';
                } else {
                    // $arrData[$i]['ver'] = '<span class="badge badge-danger px-2 py-1">No</span>';
                    $arrData[$i]['ver'] = '
                    <div class="border-0 d-flex justify-content-center">
                        <div class="input-group-text border-0">
                            <input class="form-check-input mt-0" type="checkbox">
                        </div>
                    </div>';
                }

                $arrData[$i]['options'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
                $arrData[$i]['nmr'] = $nmr;
                $arrData[$i]['men_nombre'] = '<i class="me-1 bx ' . $arrData[$i]['men_icono'] . '"></i>' . ucwords($arrData[$i]['men_nombre']);
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
                        $response['men_url_si'] = ($response['men_url_si'] == 1) ? true : false;
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
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            if (empty($_POST['txtMen_nombre'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idmenu = (isset($_POST['idIdmenu']) && !empty($_POST['idIdmenu'])) ? strClean($_POST['idIdmenu']) : 0;
                $men_nombre = (isset($_POST['txtMen_nombre']) && !empty($_POST['txtMen_nombre'])) ? strClean($_POST['txtMen_nombre']) : '';
                $men_icono = (isset($_POST['txtMen_icono']) && !empty($_POST['txtMen_icono'])) ? strClean($_POST['txtMen_icono']) : 'bx-circle';
                $men_url_si = (isset($_POST['txtMen_url_si']) && !empty($_POST['txtMen_url_si'])) ? strClean($_POST['txtMen_url_si']) : '';
                $men_url_si = ($men_url_si === 'on') ? 1 : 0;
                $men_url = (isset($_POST['txtMen_url']) && !empty($_POST['txtMen_url'])) ? strClean($_POST['txtMen_url']) : '#';
                $men_controlador = (isset($_POST['txtMen_controlador']) && !empty($_POST['txtMen_controlador'])) ? strClean($_POST['txtMen_controlador']) : '';
                $men_orden = (isset($_POST['txtMen_orden']) && !empty($_POST['txtMen_orden'])) ? strClean($_POST['txtMen_orden']) : 0;
                $men_orden = ($men_orden < 0) ? $men_orden * -1 : $men_orden;
                $men_visible = (isset($_POST['txtMen_visible'])) ? intval($_POST['txtMen_visible']) : 1;
                $response = '';

                if ($idmenu == 0) {
                    if ($this->permisos['perm_w'] == 1) {
                        $response = $this->model->insertar(
                            $men_nombre,
                            $men_icono,
                            $men_url_si,
                            $men_url,
                            $men_controlador,
                            $men_orden,
                            $men_visible
                        );
                        if ($response['status']) {
                            if ($men_url_si == '1') {
                                parent::otro('Submenus');
                                $idmenu = $response['data'];
                                $sub_nombre = $men_nombre;
                                $sub_url = $men_url;
                                $sub_controlador = $men_controlador;
                                $sub_icono = $men_icono;
                                $sub_orden = $sub_visible = '1';
                                $response = $this->other->insertar($idmenu, $sub_nombre, $sub_url, $sub_controlador, $sub_icono, $sub_orden, $sub_visible);
                            }
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => $response['data']);
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
                        }
                    }
                } else {
                    if ($this->permisos['perm_u'] == 1) {
                        $response = $this->model->actualizar(
                            $idmenu,
                            $men_nombre,
                            $men_icono,
                            $men_url_si,
                            $men_url,
                            $men_controlador,
                            $men_orden,
                            $men_visible
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
}
