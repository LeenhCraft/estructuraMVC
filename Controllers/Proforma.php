<?php
class Proforma extends Controllers
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

    public function proforma()
    {
        $data['titulo_web']   = "Proforma - Biblio Web 2.0";
        $data['js'] = ['js/app/nw_proforma.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Proforma', "proforma", $data);
    }

    public function buscar($param)
    {
        $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
        if ($this->permisos['perm_r'] == 1) {
            if (!empty($param)) {
                if (is_numeric($param)) {
                    $request = $this->model->buscar(intval($param));
                    if (!empty($request)) {
                        //$request['usu_foto'] = !empty($request['usu_foto']) ? media() . '/img/usu_web/' . $request['usu_foto'] . '.jpg' : 'https://via.placeholder.com/180x270';
                        $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => '', 'data' => $request);
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'El documento ingresado no esta registrado.');
                    }
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'El documento ingresado no es un número.');
                }
            } else {
                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No deje campos vacios.');
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }
    public function listarreq()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                $arrResponse = $this->model->listar();
                //
                for ($i = 0; $i < count($arrResponse); $i++) {
                    $btnEdit = '';
                    $btn = '';

                    //
                    //$arrResponse[$i]['id'] = '';
                    //
                    $btn = '<input type="number" id="cant' . $arrResponse[$i]['id'] . '" class="form-control text-center" value="1">';

                    $btnEdit = '<button type="button" class="btn btn-success btn-sm" onClick="agregarDetalle(' . $arrResponse[$i]['id'] . ',' . $arrResponse[$i]['isbn'] . ',' . "'" . $arrResponse[$i]['titulo'] . "'" . ',' . "'" . $arrResponse[$i]['autor'] . "'" . ',' . ')" title=""><i class="bx bx-add-to-queue"></i></button>';

                    // $btnEdit = '<button type="button" class="btn btn-success btn-sm" onClick="agregarDetalle(' . $arrResponse[$i]['id'] . ',' . $arrResponse[$i]['isbn'] . ',' . "'" . $arrResponse[$i]['titulo'] . "'" . ',' . "'" . $arrResponse[$i]['autor'] . "'" . ','.')" title=""><i class="bx bx-add-to-queue"></i></button>';


                    //opciones
                    $arrResponse[$i]['options'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btnEdit . '' . $btn . '</div>';
                }
                //
                // dep($arrResponse,1);
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
                $arrResponse = $this->views->getView('App/Prestamos', "step1", $data);
            }
            echo $arrResponse;
        }
        die();
    }

    public function registrar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_w'] == 1) {
                //asignar variables
                $idlector = (isset($_POST['detlec'])) ? intval($_POST['detlec']) : 0;
                $libros = (isset($_POST['libro'])) ? $_POST['libro'] : [];
                $cant = (isset($_POST['cant'])) ? $_POST['cant'] : [];
                $codPrestamo = generar_numeros(5);
                $idusuario = $_SESSION['lnh_id'];
                $fpres = (isset($_POST['fpres'])) ? $_POST['fpres'] : '';
                $fdev = (isset($_POST['fdev'])) ? $_POST['fdev'] : '';
                $estado = 0;

                //sanitizar
                for ($i = 0; $i < count($libros); $i++) {
                    $libros[$i] = (!empty($libros[$i])) ? intval($libros[$i]) : exit(json_encode(["status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Ocurrio un error con los libros seleccionados.'], JSON_UNESCAPED_UNICODE));
                    $cant[$i] = (intval($cant[$i]) > 0) ? intval($cant[$i]) : exit(json_encode(["status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'La cantidad de libros es errónea.'], JSON_UNESCAPED_UNICODE));
                }
                //validar
                if (!empty($idlector)) {
                    if (!empty($libros)) {
                        if (!empty($cant)) {
                            if (!empty($fpres) && !empty($fdev) && $fpres == date('Y-m-d') && $fdev >= $fpres) {
                                //registrar
                                $request = $this->model->registrar($idlector, $libros, $cant, $codPrestamo, $idusuario, $fpres, $fdev, $estado);
                                if ($request['status']) {
                                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Se registro el prestamo correctamente.');
                                } else {
                                    $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Ocurrio un error al registrar el prestamo.');
                                }
                            } else {
                                $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Debe ingresar la fecha de prestamo valida.');
                            }
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No selecciono ninguna cantidad.');
                        }
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No selecciono ningun libro.');
                    }
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Debe seleccionar a un lector.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function requerimientos($codReq)
    {
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            // $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                //todas las incidencias
                $request = $this->model->listar($codReq);
               $arrResponse = $request;
               for ($i = 0; $i < count($arrResponse); $i++) {
                $btnEdit = '';
                $btn = '';

                //
                //$arrResponse[$i]['id'] = '';
                //
                $btn = '<input type="number" id="cant' . $arrResponse[$i]['id'] . '" class="form-control text-center" value="1">';

                $btnEdit = '<button type="button" class="btn btn-success btn-sm" onClick="agregarDetalle(' . $arrResponse[$i]['id'] . ',' . $arrResponse[$i]['cod'] . ',' . "'" . $arrResponse[$i]['titulo'] . "'" . ',' . $arrResponse[$i]['cantidad'] . ',' . ')" title=""><i class="bx bx-add-to-queue"></i></button>';



                //opciones
                $arrResponse[$i]['options'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btn . '' . $btnEdit . '</div>';
            }

            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }



}
