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
                if (is_numeric($param)) {
                    $request = $this->model->buscar(intval($param));
                    if (!empty($request)) {
                        $request['usu_foto'] = !empty($request['usu_foto']) ? media() . '/img/usu_web/' . $request['usu_foto'] . '.jpg' : 'https://via.placeholder.com/180x270';
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
                $count = 0;
                
                for ($i = 0; $i < count($request); $i++) {
                    $detpres = $this->model->lst_detpres($request[$i]['idreserva']);
                    $count++;
                    $arrResponse[$i]['cant_libros'] = count($detpres);
                    $arrResponse[$i]['numero'] = $count;
                    if ($request[$i]['estado'] == 1) {
                        $arrResponse[$i]['options'] = '';
                        $arrResponse[$i]['estado'] = '<div class="h6 p-0 m-0"><span class="badge rounded-pill bg-dark" title="Esta reserva ya fue atendida">Atendido</span></div>';
                    } else {
                        $arrResponse[$i]['options'] = '<div class="btn-group" role="group"><button type="button" class="btn btn-sm btn-outline-success">Atender</button></div>';
                        $arrResponse[$i]['estado'] = '<div class="h6 p-0 m-0"><span class="badge rounded-pill bg-success" title="listo para generar un prestamo">Reservado</span></div>';
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

    public function getServices($dni)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrResponse = [];
            if ($this->permisos['perm_r'] == 1) {
                $arrResponse = $this->views->getView('App/Prestamos', "step2");
            }
            echo $arrResponse;
        }
        die();
    }

    public function lstlibros()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $arrResponse = [];
            $html = '<option value="">Seleccione</option>';
            if ($this->permisos['perm_r'] == 1) {
                $arrResponse = $this->model->lstlibros();
                foreach ($arrResponse as $key) {
                    $html .= '<option value="' . $key['idarticulo'] . '">' . $key['art_nombre'] . '</option>';
                }
            }
            echo $html;
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
                // $fpres = (isset($_POST['fpres'])) ? $_POST['fpres'] : date('Y-m-d H:i:s');
                $fpres = date('Y-m-d');
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
}
