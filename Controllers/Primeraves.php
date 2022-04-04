<?php
class Primeraves extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function primeraves()
    {
        $data['titulo_web'] = 'Resetear Contraseña';
        $this->views->getView('App/Firsttime', "firsttime", $data);
    }

    public function reset()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $pass = (isset($_POST['txtPass']) && !empty($_POST['txtPass'])) ? $_POST['txtPass'] : '';
            $cpass = (isset($_POST['txtConPass']) && !empty($_POST['txtConPass'])) ? $_POST['txtConPass'] : '';
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No cuenta con los permisos necesarios.');
            if (!empty($pass) && !empty($cpass)) {
                if ($pass == $cpass) {
                    if (validar_clave($pass, $mensaje)) {
                        $arrData = $this->model->verificar();
                        if (!empty($arrData)) {
                            $request = $this->model->upd_pass(password_hash($pass, PASSWORD_DEFAULT));
                            if ($request['status']) {
                                $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Contraseña actualizada correctamente!!', "text" => 'Contraseña actualizada correctamente.');
                            } else {
                                $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Excelente!!', "text" => 'Ocurrio un error al actualizar');
                            }
                        } else {
                            $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No se encontraron registros.');
                        }
                    } else {
                        $arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $mensaje);
                    }
                } else {
                    $arrResponse = array("status" => false, 'icon' => 'info', 'warning' => 'Atención!!', "text" => 'Las contraseñas no son iguales.');
                }
            } else {
                $arrResponse = array("status" => false, 'icon' => 'info', 'warning' => 'Atención!!', "text" => 'Campos vacios.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
