<?php

class Carrito extends Controllers
{
    public function _construct()
    {
        parent::__construct();
    }

    public function carrito()
    {
        $data['titulo_web'] = 'Carrito';
        $data['css'] = ['css/web/style.css'];
        $data['js'] = ['js/web/fn_lg.js', 'js/web/fn_car.js'];
        $data['cant'] = can_carrito();
        $this->views->getView('Web/Carrito', "carrito", $data);
    }

    public function articulos()
    {
        $res_pen = $this->model->hay_pendientes();
        require_once __DIR__ . '/../Views/Web/includes/tbody.php';
        if (empty($res_pen[0])) {
            $articulos = $this->model->articulos($_SESSION['vi']);
            $request = articulos($articulos);
            $paso2 = '';
            if ($request[1] > 0) {
                ob_start();
                require_once __DIR__ . '/../Views/Web/Carrito/paso_2.php';
                $paso2 = ob_get_clean();
            }
            if (isset($_SESSION['pe_u']) && $request[1] > 0) {
                $idwebusuario = $_SESSION['pe_u'];
                $usu_data = getName2($idwebusuario);
                ob_start();
                require_once __DIR__ . '/../Views/Web/Carrito/con_lg.php';
                $paso2 = ob_get_clean();
                $paso2 = str_replace('{{nombre}}', $usu_data['usu_nombre'], $paso2);
                $paso2 = str_replace('{{val}}', $usu_data['idwebusuario'], $paso2);
            }
            $arrResponse = ['status' => true, 'data' => $request[0], 'data2' => $paso2];
        } else {
            $request = articulos2($res_pen[0]);
            $usu_data = getName2($res_pen[1]);
            ob_start();
            require_once __DIR__ . '/../Views/Web/Carrito/con_reg.php';
            $paso2 = ob_get_clean();
            $paso2 = str_replace('{{nombre}}', $usu_data['usu_nombre'], $paso2);
            $paso2 = str_replace('{{val}}', $usu_data['idwebusuario'], $paso2);
            $arrResponse = ['status' => false, 'data' => $request, 'data2' => $paso2];
        }

        // if (isset($_SESSION['pe_u'])) {
        //     $idwebusuario = $_SESSION['pe_u'];
        //     $usu_data = getName2($idwebusuario);
        //     ob_start();
        //     require_once __DIR__ . '/../Views/Web/Carrito/con_lg.php';
        //     $paso2 = ob_get_clean();
        //     $paso2 = str_replace('{{nombre}}', $usu_data['usu_nombre'], $paso2);
        //     $paso2 = str_replace('{{val}}', $usu_data['idwebusuario'], $paso2);
        // }
        // $arrResponse = ['status' => false, 'data' => $request, 'data2' => $paso2];
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
    }

    public function upd()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'No se puedo actualizar.', "text" => '', 'data' => can_carrito());
            $id = (isset($_POST['id'])) ? intval($_POST['id']) : 0;
            $cant = (isset($_POST['cant'])) ? intval($_POST['cant']) : 0;
            if (!empty($id)) {
                $existe = $this->model->existe($id);
                if (!empty($existe)) {
                    $hay_cant = $this->model->stock($id, $cant);
                    if (!empty($hay_cant)) {
                        $response = $this->model->upd_cant($id, $cant);
                        if ($response['status']) {
                            $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Cantidad actualizada', "text" => 'Se ha agregado al carrito.', 'data' => can_carrito());
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data'], 'data' => can_carrito());
                        }
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No hay stock suficiente.');
                    }
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Este producto no existe.');
                }
            } else {
                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Por favor seleccione un producto.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url());
        }
    }

    public function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'No se puedo eliminar.', "text" => '');
            $id = (isset($_POST['id'])) ? intval($_POST['id']) : 0;
            if (!empty($id)) {
                $request = $this->model->eliminar($id);
                if ($request['status']) {
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Articulo eliminado.', "text" => '', 'data' => can_carrito());
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => $request['data'], "text" => '', 'data' => can_carrito());
                }
            } else {
                $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'No selecciono un articulo.', "text" => '');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url());
        }
    }

    public function reservar()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'No se puedo reservar.', "text" => '');
            $idwebusuario = isset($_POST['item']) ? intval($_POST['item']) : 0;
            $usu_id = (isset($_SESSION['lnh_id'])) ? $_SESSION['lnh_id'] : 0;
            $estado = 0;
            if (!empty($idwebusuario)) {
                $request = $this->model->header_reserva($idwebusuario, $usu_id, $estado);
                $num_reserva = $request['data'];
                $nom_usu = getName2($idwebusuario);
                if ($num_reserva > 0) {
                    ob_start();
                    require_once __DIR__ . '/../Views/Web/Carrito/con_res.php';
                    $mensaje = ob_get_clean();
                    $mensaje = str_replace('{{num_res}}', $num_reserva, $mensaje);
                    $mensaje = str_replace('{{usu}}', $nom_usu['usu_nombre'], $mensaje);
                    $html = $mensaje;
                    unset($_SESSION['vi']);
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Reserva realizada.', "text" => '', 'data' => $html);
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'No se puedo reservar.', "text" => '');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url());
        }
    }
}
