<?php
class Prestamos extends Controllers
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

    public function prestamos()
    {
        $data['titulo_web']   = "Prestamos - Biblio Web 2.0";
        $data['js'] = ['js/app/nw_prestamos.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Prestamos', "prestamos", $data);
    }

    public function buscar($param)
    {
        $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
        if ($this->permisos['perm_r'] == 1) {
            if (!empty($param)) {
                $request = $this->model->buscar(intval($param));
                if (!empty($request)) {
                    $request['usu_foto'] = !empty($request['usu_foto']) ? media() . '/img/usu_web/' . $request['usu_foto'] . '.jpg' : 'https://via.placeholder.com/180x270';
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => '', 'data' => $request);
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'El DNI ingresado no esta registrado.');
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
                $request = $this->model->lstreservas($dni);
                $arrResponse = $request;
                for ($i = 0; $i < count($request); $i++) {
                    $detpres = $this->model->lst_detpres($request[$i]['id']);
                    $arrResponse[$i]['cantidad'] = count($detpres);
                    switch ($arrResponse[$i]['estado']) {
                        case 0:
                            $arrResponse[$i]['estado'] = '<span class="badge bg-primary">Prestado</span>';
                            break;
                        case 1:
                            $arrResponse[$i]['estado'] = '<span class="badge bg-success">Devuelto</span>';
                            break;
                        case 2:
                            $arrResponse[$i]['estado'] = '<span class="badge bg-info">Reservado</span>';
                            break;

                        default:
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
}
