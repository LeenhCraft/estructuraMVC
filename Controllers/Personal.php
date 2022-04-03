<?php
class Personal extends Controllers
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

    public function personal()
    {
        $data['titulo_web']   = "Usuarios - Biblio Web 2.0";
        $data['js'] = ['js/app/fn_personal.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Usuarios', "personal", $data);
    }

    public function lst()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST" && $this->permisos['perm_r'] == 1) {
            $arrData = $this->model->lstPersonal();
            $nmr = 1;
            for ($i = 0; $i < count($arrData); $i++) {
                $arrData[$i]['nmr'] = $nmr;
                $nmr++;
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['estado'] == 1) {
                    $arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                }
                if ($this->permisos['perm_u'] == '1') {
                    $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrData[$i]['id'] . ')" title="Editar Autor"><i class="fas fa-pencil-alt"></i></button>';
                } else {
                    $btnEdit = '<button class="btn btn-success btn-sm" title="Editar Autor" disabled><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($this->permisos['perm_d'] == '1') {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onclick="fntDel(' . $arrData[$i]['id'] . ')" title="Eliminar Autor"><i class="far fa-trash-alt"></i></button>';
                } else {
                    $btnDelete = '<button class="btn btn-danger btn-sm" title="Eliminar Autor" disabled><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['opciones'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function acc()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST" && $this->permisos['perm_r'] == 1) {
            if (empty($_POST['txtsearch']) || empty($_POST['txtnombre'])) {
                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No deje campos vacios.');
            } else {
                $id = (isset($_POST['item']) && !empty($_POST['item'])) ? intval($_POST['item']) : 0;
                $dni = (isset($_POST['txtsearch']) && !empty($_POST['txtsearch'])) ? intval($_POST['txtsearch']) : 0;
                $nombre = (isset($_POST['txtnombre']) && !empty($_POST['txtnombre'])) ? strClean($_POST['txtnombre']) : '';
                $cel = (isset($_POST['txtcel']) && !empty($_POST['txtcel'])) ? intval($_POST['txtcel']) : 0;
                $dir = (isset($_POST['txtdir']) && !empty($_POST['txtdir'])) ? strClean($_POST['txtdir']) : '';
                $estado = (isset($_POST['txtestado']) && !empty($_POST['txtestado'])) ? intval($_POST['txtestado']) : 1;
                $response = "";
                $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
                if ($id == 0) {
                    if ($this->permisos['perm_w'] == 1) {
                        $response = $this->model->insertar($dni, $nombre, $cel, $dir, $estado);
                        if ($response['status']) {
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => $response['data']);
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
                        }
                    }
                } else {
                    if ($this->permisos['perm_u'] == 1) {
                        $response = $this->model->actualizar($id, $dni, $nombre, $cel, $dir, $estado);
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

    public function persona($parametros = 0)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET" && $this->permisos['perm_r'] == 1) {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            $id = (!empty($parametros)) ? intval($parametros) : 0;
            if ($id != 0) {
                if ($this->permisos['perm_u'] == 1) {
                    $response = $this->model->persona($id);
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

    public function eliminar($parametros = 0)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST" && $this->permisos['perm_r'] == 1) {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            $id = (!empty($parametros)) ? intval($parametros) : 0;
            if ($id != 0) {
                if ($this->permisos['perm_d'] == 1) {
                    $response = $this->model->perxuser($id);
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
