<?php
class Actas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
        $this->permisos = getPermisos(get_class($this));
        if (!isset($_SESSION['login']) || $this->permisos['perm_r'] != 1) {
            header('Location: ' . base_url() . 'login');
        }
    }

    public function actas()
    {
        $data['titulo_web']   = "Actas- Biblio Web 2.0";
        $data['js'] = ['js/app/nw_actas.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Actas', "actas", $data);
    }

    public function ajax($param)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET") {
            switch ($param) {
                case 'op1':
                    // $this->otra_clase('Ajax/Actas', 'ajax_actas');
                    // $return = $this->oClass->mdlProveedor();
                    // $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'ok', "text" => '', 'data' => $return);
                    // echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
                    break;
                case 'op3':
                    $this->otra_clase('Ajax/Actas', 'ajax_actas');
                    $return = $this->oClass->cod_acta();
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'ok', "text" => '', 'data' => $return);
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

    public function buscar($param)
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_r'] == 1) {
                $ndoc = (!empty($param) && is_numeric($param)) ? intval($param) : 0;
                if (!empty($ndoc)) {
                    $dataUsu = $this->model->buscar($ndoc);
                    if (!empty($dataUsu)) {
                        $dataUsu['name'] = !empty($dataUsu['pro_nombrecompleto']) ? $dataUsu['pro_nombrecompleto'] : $dataUsu['pro_razonsocial'];
                        $dataUsu['doc'] = !empty($dataUsu['pro_dni']) ? $dataUsu['pro_dni'] : $dataUsu['pro_ruc'];
                    }
                    $dataTable = $this->model->bsc_fichas($ndoc);
                    $tbody = '';
                    if (!empty($dataTable)) {
                        foreach ($dataTable as $row) {
                            $cant = $this->model->cont_libros($row['iddonacion']);
                            $tbody .= '<tr>
                                            <td><strong>' . $row['iddonacion'] . '</strong></td>
                                            <td class="text-primary text-center">' . $row['don_cod'] . '</td>
                                            <td>' . $row['tpro_nombre'] . '</td>
                                            <td>Donante</td>
                                            <td class="fw-bold text-dark">' . (!empty($row['pro_nombrecompleto']) ? $row['pro_nombrecompleto'] : $row['pro_razonsocial']) . '</td>
                                            <td class="text-center">' . $cant['cant'] . '</td>
                                            <td>' . $row['don_fecha'] . '</td>
                                            <td><button type="button" class="btn btn-outline-warning btn-sm" onclick="ver_det(' . $row['iddonacion'] . ')">Ver mas...</button></td>
                                        </tr>';
                        }
                    } else {
                        $tbody = '<tr><td colspan="8" class="text-center text-capitalize">sin datos</td></tr>';
                    }
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'ok', "text" => '', 'data' => ['usu' => $dataUsu, 'fichas' => $tbody]);
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'El número de documento no es válido.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            exit();
        } else {
            header('Location: ' . base_url());
        }
    }

    public function detalle()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_r'] == 1) {
                $idDona = !empty($_POST['cod']) ? intval($_POST['cod']) : 0;
                if ($idDona != 0) {
                    $response = $this->model->det_donacion($idDona);
                    $tbody = '';
                    if (!empty($response)) {
                        foreach ($response as $row) {
                            $tbody .= '<tr>
                                            <td>' . $row['don_cod'] . '</td>
                                            <td>' . $row['art_cod'] . '</td>
                                            <td>' . $row['art_isbn'] . '</td>
                                            <td>' . $row['art_nombre'] . '</td>
                                            <td>' . $row['detd_cantidad'] . '</td>
                                        </tr>';
                        }
                    } else {
                        $tbody = '<tr><td colspan="5" class="text-center text-capitalize">sin datos</td></tr>';
                    }
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'ok', "text" => '', 'data' => $tbody);
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No se encontró el código de donación.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url());
        }
    }

    public function registrar()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_w'] == 1) {
                $codFicha = (isset($_POST['codActa'])) ? intval($_POST['codActa']) : $this->model->codigo();
                $usu_id = $_SESSION['lnh_id'];
                $idDona = !empty($_POST['idDona']) ? intval($_POST['idDona']) : 0;
                $estado = 1;

                if ($idDona) {
                    $response = $this->model->registrar($codFicha, $usu_id, $idDona, $estado);
                    if ($response['status']) {
                        $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => 'Acta generada.');
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => $response['text']);
                    }
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'Seleccione un donante y una ficha de donación.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url());
        }
    }
}
