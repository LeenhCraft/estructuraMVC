<?php
class Devolucion extends Controllers
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

    public function devolucion()
    {
        $data['titulo_web']   = "Devolucion - Biblio Web 2.0";
        $data['js'] = ['js/app/nw_devolucion.js'];
        $data['permisos']  = $this->permisos;


        
        $this->views->getView('App/Devolucion', "devolucion", $data);
    }

    public function buscar($param)
    {
        $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
        if ($this->permisos['perm_r'] == 1) {
            if (!empty($param)) {
                if (is_numeric($param)) {
                    $request = $this->model->buscar(intval($param));
                    if (!empty($request)) {
                        $request['usu_foto'] = !empty($request['usu_foto']) ? media() . '/img/usu_web/' . $request['usu_foto'] . '.png': 'https://via.placeholder.com/180x200';
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
                $request = $this->model->lstreservas($dni);
                $arrResponse = $request;
                
                for ($i = 0; $i < count($request); $i++) {
                    $btnEdit = '';
                    $detpres = $this->model->lst_detpres($request[$i]['id']);
                    $arrResponse[$i]['cantidad'] = count($detpres);
                    switch ($arrResponse[$i]['estado']) {
                        case 0:
                            $arrResponse[$i]['estado'] = '<span class="badge bg-primary">Prestado</span>';
                            $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrResponse[$i]['id'] . ')" title="Actualizar Estado"><i class="bx bxs-edit-alt"></i></button>';
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

                    
                       //opciones
                        $arrResponse[$i]['opciones'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btnEdit . '</div>';
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function act(){
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            //$id = (!empty($parametros)) ? intval($parametros) : 0;
            $dev = (isset($_POST['dev'])) ? intval($_POST['dev']) : 0;

            if ($dev != 0) {
                if ($this->permisos['perm_u'] == 1) {
                    $response = $this->model->actualizar($dev);
                    if ($response['status']) {
                        $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'estado actualizado', "data" => '');
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'ocurrio un error al actualizar.');
                    }
                }
            } else {
                $arrResponse = array("status" => false, 'warning' => 'info', 'title' => 'Atención!!', "text" => 'Esta intentando una petición sin parametros.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);


        }else{
            header('Location: ' . base_url());

        }
        
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
   
    /*public function lstlibros()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                $arrResponse = $this->model->lstlibros();
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }*/
    public function lstdetalledev($dni)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                //todas las incidencias
                $request = $this->model->lstdetalledevolucion($dni);
                $arrResponse = $request;
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }



}
