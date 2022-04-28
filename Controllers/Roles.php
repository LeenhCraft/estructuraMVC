<?php
class Roles extends Controllers
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

    public function roles()
    {
        $data['titulo_web']   = "Rol";
        $data['js'] = ['js/app/nw_rol.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Roles', "roles", $data);
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
                    $btnView = '<button class="btn btn-info btn-sm" onClick="fntView(' . $arrData[$i]['idrol'] . ')" title="Ver Rol"><i class="bx bx-show-alt"></i></button>';
                }
                if ($this->permisos['perm_u'] == 1) {
                    $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrData[$i]['idrol'] . ')" title="Editar Rol"><i class="bx bxs-edit-alt"></i></button>';
                }
                if ($this->permisos['perm_d'] == 1) {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onClick="fntDel(' . $arrData[$i]['idrol'] . ')" title="Eliminar Rol"><i class="bx bxs-trash-alt" ></i></button>';
                }
                if ($arrData[$i]['rol_estado'] == 1) {
                    // $arrData[$i]['ver'] = '<span class="badge badge-success px-2 p-y1">Si</span>';
                    $arrData[$i]['rol_estado'] = '
                    <div class="text-center">
                        <span class="badge bg-success">Activo</span>
                    </div>
                    ';
                } else {
                    // $arrData[$i]['ver'] = '<span class="badge badge-danger px-2 py-1">No</span>';
                    $arrData[$i]['rol_estado'] = '
                    <div class="text-center">
                        <span class="badge bg-danger">Inactivo</span>
                    </div>
                    ';
                }

                $arrData[$i]['options'] = '<div class="btn-group text-center" role="group" aria-label="Basic example">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function buscar($parametros)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            $id = (!empty($parametros)) ? intval($parametros) : 0;
            if ($id != 0) {
                if ($this->permisos['perm_r'] == 1) {
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
            if (empty($_POST['txtRol_nombre'])) {
                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Debe ingresar un nombre de rol.');
            } else {
                $idrol = (isset($_POST['idIdrol']) && !empty($_POST['idIdrol'])) ? intval($_POST['idIdrol']) : 0;
                $rol_nombre = (isset($_POST['txtRol_nombre']) && !empty($_POST['txtRol_nombre'])) ? strClean($_POST['txtRol_nombre']) : '';
                $rol_cod = (isset($_POST['txtRol_cod']) && !empty($_POST['txtRol_cod'])) ? strClean($_POST['txtRol_cod']) : '';
                $rol_descripcion = (isset($_POST['txtRol_descripcion']) && !empty($_POST['txtRol_descripcion'])) ? strClean($_POST['txtRol_descripcion']) : '';
                $rol_estado = (isset($_POST['txtRol_estado'])) ? intval($_POST['txtRol_estado']) : 1;
                $response = '';

                if (empty($idrol)) {
                    if ($this->permisos['perm_w'] == 1) {
                        $response = $this->model->insertar(
                            $rol_nombre,
                            $rol_cod,
                            $rol_descripcion,
                            $rol_estado
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
                            $idrol,
                            $rol_nombre,
                            $rol_cod,
                            $rol_descripcion,
                            $rol_estado
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
