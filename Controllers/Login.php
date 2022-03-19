<?php

class Login extends Controllers
{

    public function __construct()
    {
        session_start();
        if (isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'dashboard');
        }
        parent::__construct();
    }

    public function login()
    {
        $data['tag_page']     = "Login - Biblio Web 2.0";
        $data['titulo_web']   = "Biblio Web";
        $data['page_name']    = "login";
        $data['css'] = ['css/custom.css'];
        $data['js'] = ['js/app/fn_lg.js'];
        $this->views->getView($this, "login", $data);
    }

    public function loginUser()
    {
        if ($_POST) {
            if (empty($_POST['usuario']) || empty($_POST['pass'])) {
                $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'No deje campos vacios');
            } else {
                $strUsuario  =  strtolower(strClean($_POST['usuario']));
                $strPassword = hash("SHA256", $_POST['pass']);
                $requestUser = $this->model->loginUser($strUsuario, $strPassword);
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Usuario o contraseña incorrectas');
                } else {
                    $arrData = $requestUser;
                    if ($arrData['usu_activo'] == 1 && $arrData['usu_estado'] == 1) {
                        // $_SESSION['idUser'] = $arrData['usu_id'];
                        // $_SESSION['login'] = true;
                        // $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                        $arrResponse = array('status' => false, 'icon' => 'success', 'text' => 'Bienvenido');
                    } else if ($arrData['usu_activo'] == 0 && $arrData['usu_estado'] == 1) {
                        $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Usuario sin confirmar, revise su email para confirmar su cuenta.');
                    } else {
                        $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Usuario bloqueado');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function registrar()
    {
        if ($_POST) {
            $usu = strClean($_POST['regusu']);
            $pass = strClean($_POST['regpass']);
            $conpas = strClean($_POST['regconpass']);
            if (empty($usu) || empty($pass) || empty($conpas)) {
                $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'No deje campos vacios');
            } else {
                if ($pass === $conpas) {
                    $token = passGenerator(32);
                    $request = $this->model->regusu($usu, hash("SHA256", $pass), $token);
                    if ($request === 'ok') {
                        $url = BASE_URL . 'login/activar/' . $usu . '/' . $token . '==';
                        $data['email'] = $usu;
                        $data['asunto'] = 'Link de activación de cuenta';
                        $data['nombre'] = 'LEENH';
                        $data['token'] = $url;
                        $senmail = enviarEmail($data, 'email');
                        if ($senmail['status']) {
                            $arrResponse = array('status' => true, 'icon' => 'success', 'text' => 'Usuario registrado, se envió un link de activación a su correo');
                        } else {
                            $arrResponse = array('status' => false, 'icon' => 'error', 'text' => 'No se puedo enviar el email');
                        }
                    } else if ($request === 'no') {
                        $arrResponse = array('status' => false, 'icon' => 'error', 'text' => 'Ocurrio un error al intentar registrar');
                    } else if ($request === 'exist') {
                        $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'El usuario ya existe');
                    }
                } else {
                    $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Las contraseñas no coinciden');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function activar(string $params)
    {
        // REQUEST_METHOD

        if (empty($params)) {
            header('Location: ' . base_url());
        } else {
            $arrParams = explode(',', $params);
            $strEmail = (!empty($arrParams[0])) ? strClean($arrParams[0]) : '';
            $strToken = (!empty($arrParams[1])) ? strClean($arrParams[1]) : '';
            if (empty($strEmail) || empty($strToken)) {
                header('Location: ' . base_url());
            } else {


                $arrResponse = $this->model->getUsuario($strEmail, $strToken, 0);
                if (empty($arrResponse)) {
                    header('Location: ' . base_url());
                } else {
                    $request = $this->model->activar($strEmail, $strToken);
                    if ($request) {
                        $data['content'] = 'cuenta activa';
                    } else {
                        $data['content'] = 'ocurrio un error';
                    }
                    $data['tag_page']     = "Login - Biblio Web 2.0";
                    $data['titulo_web']   = "Biblio Web";
                    $data['page_name']    = "login";
                    $data['css'] = ['css/custom.css'];
                    $data['js'] = ['js/app/fn_lg.js'];
                    $this->views->getView($this, "activacion", $data);
                }
            }
        }
        die();
    }

    /*
    

    public function resetPass()
    {

        if ($_POST) {

            if (empty($_POST['txtEmailReset'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $token = token();
                $strEmail = strtolower(strClean($_POST['txtEmailReset']));
                $arrData = $this->model->getUserEmail($strEmail);

                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Usuario no encontrado.');
                } else {
                    $idpersona = $arrData['usu_id'];
                    $nombreUsuario = $arrData['usu_nombre'] . ' ' . $arrData['usu_apellidos'];

                    $url_recovery = base_url() . 'login/confirmUser/' . $strEmail . '/' . $token;

                    $requestUpdate = $this->model->setTokenUser($idpersona, $token);

                    $dataUsuario = array(
                        'nombreUsuario' => $nombreUsuario,
                        'email' => $strEmail,
                        'asunto' => 'Recuperar cuenta - ' . NOMBRE_REMITENTE,
                        'url_recovery' => $url_recovery
                    );

                    if ($requestUpdate) {

                        // $sendEmail = sendEmail($dataUsuario, 'email_cambioPassword');
                        $sendEmail = enviarEmail($dataUsuario, 'email_cambioPassword');
                        // dep($sendEmail);
                        // exit;

                        if ($sendEmail) {
                            $arrResponse = array('status' => true, 'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');
                        } else {
                            $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.2');
                        }
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intenta más tarde.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    

    public function setPassword()
    {
        $l = '1';
        // echo '<pre>' . var_dump($data) . '</pre>';exit;
        // if (empty($_POST['idUsuario']) || empty($_POST['txtPassword']) || empty($_POST['txtPasswordConfirm']) || empty($_POST['txtEmail']) || empty($_POST['txtToken'])) {
        if ($l === '11') {
            $arrResponse = array('status' => false, 'msg' => 'Error de datos 1');
        } else {
            $intIdpersona = intval($_POST['idUsuario']);
            $strPassword = $_POST['txtPassword'];
            $strPasswordConfirm = $_POST['txtPasswordConfirm'];
            $strEmail = strClean($_POST['txtEmail']);
            $strToken = strClean($_POST['txtToken']);

            if ($strPassword != $strPasswordConfirm) {
                $arrResponse = array('status' => false, 'msg' => 'Las contraseñas no son iguales.');
            } else {
                $arrResponseUser = $this->model->getUsuario($strEmail, $strToken, $intIdpersona);
                if (empty($arrResponseUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'Error de datos.');
                } else {

                    $strPassword = hash("SHA256", $strPassword);
                    $requestPass =  $this->model->insertPassword($intIdpersona, $strPassword);

                    if ($requestPass) {
                        $arrResponse = array('status' => true, 'msg' => 'Contraseña actualizada con exito.');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'No es posible realizar el proceso, intente más tarde.');
                    }
                }
            }
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        die();
    }
    */
}
