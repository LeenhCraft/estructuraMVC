<?php
class Incidencias extends Controllers
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

    public function incidencias()
    {
        $data['titulo_web']   = "Incidencias - Biblio Web 2.0";
        $data['js'] = ['js/app/nw_incidencias.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Incidencias', "incidencias", $data);
    }

    public function buscar($param)
    {
        $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
        if ($this->permisos['perm_r'] == 1) {
            if (!empty($param)) {
                if (is_numeric($param)) {
                    $request = $this->model->buscar(intval($param));
                    if (!empty($request)) {
                        $request['usu_foto'] = !empty($request['usu_foto']) ? media() . '/img/usu_web/' . $request['usu_foto'] . '.png' : 'https://via.placeholder.com/180x200';
                        $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => '', 'data' => $request);
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'El DNI ingresado no esta registrado.');
                    }
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'El DNI ingresado no es un número.');
                }
            } else {
                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No deje campos vacios.');
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    public function lstreservas($dni)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrResponse = [];
            // $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_r'] == 1) {
                $btn = '';
                $request = $this->model->lstreservas($dni);
                $arrResponse = $request;
                for ($i = 0; $i < count($request); $i++) {
                    $detpres = $this->model->lst_detpres($request[$i]['id']);
                    $arrResponse[$i]['cantidad'] = count($detpres);
                    switch ($arrResponse[$i]['estado']) {
                        case 0:
                            $arrResponse[$i]['btn'] = '';

                            $arrResponse[$i]['estado'] = '<span class="badge bg-primary">Prestado</span>';
                            break;
                        case 1:
                            $arrResponse[$i]['btn'] = '<button class="btn btn-outline-info btn-sm" onclick="ver_libros(this,' . $arrResponse[$i]['id'] . ',' . "'" . $arrResponse[$i]['cod'] . "'" . ')" title="Ver libros"><i class="bx bxs-edit-alt"></i></button>';
                            $arrResponse[$i]['estado'] = '<span class="badge bg-success">Devuelto</span>';
                            break;
                        case 2:
                            $arrResponse[$i]['btn'] = '';

                            $arrResponse[$i]['estado'] = '<span class="badge bg-info">Reservado</span>';
                            break;

                        default:
                            $arrResponse[$i]['btn'] = '';

                            $arrResponse[$i]['estado'] = 'Pendiente';
                            break;
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function lstincidentes($dni)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                //todas las incidencias
                $request = $this->model->lstincidentes($dni);
                $arrResponse = $request;
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function motivos()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            if ($this->permisos['perm_r']) {
                $arrData = $this->model->motivos();
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



    public function first()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                $data['permisos']  = $this->permisos;
                $arrResponse = $this->views->getView('App/Incidencias', "step3", $data);
            }
            echo $arrResponse;
        }
        die();
    }

    public function insertinci()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            if ($this->permisos['perm_r'] == 1 && $this->permisos['perm_w'] == 1) {
                $idarticulo = isset($_POST['item_book']) ? intval($_POST['item_book']) : 0;
                $idprestamo = isset($_POST['pres_cod']) ? intval($_POST['pres_cod']) : 0;
                $idmotivo = isset($_POST['txtIdmotivos']) ? intval($_POST['txtIdmotivos']) : 0;
                $det1 = isset($_POST['det_1']) ? strClean($_POST['det_1']) : '';
                $det2 = isset($_POST['det_2']) ? strClean($_POST['det_2']) : '';
                $det3 = isset($_POST['det_3']) ? strClean($_POST['det_3']) : '';
                if (empty($idprestamo)) {
                    $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Debe seleccionar un prestamo realizado.');
                } else {
                    if (empty($idarticulo)) {
                        $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Debe de seleccionar un articulo para continuar.');

                        // exit(json_encode(["status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Debe de seleccionar un articulo para continuar.'],JSON_UNESCAPED_UNICODE));
                    } else {
                        if (empty($idmotivo) || (empty($det1) && empty($det2) && empty($det3))) {
                            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Es necesario un motivo y un detalle para continuar.');
                        } else {
                            $estado = 0;
                            $detalle = $det1 . ' ' . $det2 . ' ' . $det3;
                            $request = $this->model->inert_inci($_SESSION['lnh_id'], $idprestamo, $estado, $idarticulo, $idmotivo, $detalle);
                            if ($request['status']) {
                                $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => 'Se registro correctamente.');
                            } else {
                                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $request['text']);
                            }
                        }
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url());
        }
        die();
    }

    public function lstlibros()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                $arrResponse = $this->model->lstlibros();
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function det()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_r'] == 1) {
                $idprestamo = isset($_POST['a']) ? intval($_POST['a']) : 0;
                $request = $this->model->lst_detpres($idprestamo);
                $arrResponse = array("status" => true, 'icon' => 'success', 'title' => '', "text" => '', 'data' => $request);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url() . 'login');
        }
    }
}
