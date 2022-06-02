<?php
class Donacion extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->permisos = getPermisos(get_class($this));
        if (!isset($_SESSION['login']) || $this->permisos['perm_r'] != 1) {
            header('Location: ' . base_url() . 'login');
        }
    }

    public function donacion()
    {
        $data['titulo_web']   = "Donacion - Biblio Web 2.0";
        $data['js'] = ['js/app/nw_donacion.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Donacion', "donacion", $data);
    }

    public function ajax($param)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET") {
            switch ($param) {
                case 'op1':
                    $this->otra_clase('Ajax/Donacion', 'ajax_donacion');
                    $return = $this->oClass->paso1();
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'ok', "text" => '', 'data' => $return);
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    break;
                case 'op2':
                    $this->otra_clase('Ajax/Donacion', 'ajax_donacion');
                    $return = $this->oClass->paso2();
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'ok', "text" => '', 'data' => $return);
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    break;
                case 'op3':
                    $this->otra_clase('Ajax/Donacion', 'ajax_donacion');
                    $return = $this->oClass->cod_dona();
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'ok', "text" => '', 'data' => $return);
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    break;
                case 'proveedor':
                    $doc = $_GET['a'];
                    $request = $this->model->persona($doc);
                    if (!empty($request)) {
                        $request['nombre'] = !empty($request['pro_nombrecompleto']) ? $request['pro_nombrecompleto'] : $request['pro_razonsocial'];
                        $request['doc'] = !empty($request['pro_dni']) ? $request['pro_dni'] : $request['pro_ruc'];
                        $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => '', 'data' => $request);
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No se encontraron resultados', 'data' => '');
                    }
                    echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    break;
                default:
                    header('Location: ' . base_url());
                    break;
            }
            exit();
        } else {
            header('Location: ' . base_url());
        }
    }

    public function registrar()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_w'] == 1) {
                //asignar variables
                $idproveedor = (isset($_POST['idprove'])) ? intval($_POST['idprove']) : 0;
                $libros = (isset($_POST['libro'])) ? $_POST['libro'] : [];
                $cant = (isset($_POST['cant'])) ? $_POST['cant'] : [];
                $codFicha = (isset($_POST['cod_ficha'])) ? intval($_POST['cod_ficha']) : generar_numeros(5);
                $idusuario = $_SESSION['lnh_id'];
                $estado = 1;

                //sanitizar
                for ($i = 0; $i < count($libros); $i++) {
                    $libros[$i] = (!empty($libros[$i])) ? intval($libros[$i]) : exit(json_encode(["status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Ocurrio un error con los libros seleccionados.'], JSON_UNESCAPED_UNICODE));
                    $cant[$i] = (intval($cant[$i]) > 0) ? intval($cant[$i]) : exit(json_encode(["status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'La cantidad de libros es errónea.'], JSON_UNESCAPED_UNICODE));
                }
                //validar
                if (!empty($idproveedor)) {
                    if (!empty($libros)) {
                        if (!empty($cant)) {
                            //registrar
                            $request = $this->model->registrar($idproveedor, $idusuario, $libros, $cant, $codFicha, $estado);
                            if ($request['status']) {
                                $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Se registro la donación correctamente.');
                            } else {
                                $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Ocurrio un error al registrar el prestamo.');
                            }
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No selecciono ninguna cantidad.');
                        }
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No selecciono ningun libro.');
                    }
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Debe seleccionar a un proveedor o donante.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url());
        }
    }
}
