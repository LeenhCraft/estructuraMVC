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
        $data['page_title']   = "Biblio Web";
        $data['page_name']    = "login";
        $data['page_functions_js'] = "functions_login.js";
        $this->views->getView($this, "login", $data);
    }

    public function loginUser()
    {
        //dep($_POST);
        if ($_POST) {
            if (empty($_POST['txtEmail']) || empty($_POST['txtPassword'])) {
                $arrResponse = array('status' => false, 'msg' => 'Error de datos');
            } else {
                $strUsuario  =  strtolower(strClean($_POST['txtEmail']));
                $strPassword = hash("SHA256", $_POST['txtPassword']);
                $requestUser = $this->model->loginUser($strUsuario, $strPassword);
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.');
                } else {
                    $arrData = $requestUser;
                    if ($arrData['usu_estado'] == 1) {
                        $_SESSION['idUser'] = $arrData['usu_id'];
                        $_SESSION['login'] = true;

                        $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                        //$_SESSION['userData'] = $arrData;

                        $arrResponse = array('status' => true, 'msg' => 'ok');
                    } else {
                        $arrResponse = array('status' => false, 'msg' => 'Usuario inactivo.');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

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

    public function confirmUser(string $params)
    {
        if (empty($params)) {
            header('Location: ' . base_url());
        } else {
            $arrParams = explode(',', $params);
            $strEmail = strClean($arrParams[0]);
            $strToken = strClean($arrParams[1]);

            $arrResponse = $this->model->getUsuario($strEmail, $strToken, 0);

            if (empty($arrResponse)) {
                header('Location: ' . base_url());
            } else {
                $data['tag_page']     = "Cambiar contraseña";
                $data['page_title']   = "Cambiar Contraseña";
                $data['page_name']    = "cambiar_contraseña";
                $data['email']     = $strEmail;
                $data['token']     = $strToken;
                $data['idpersona']    = $arrResponse['usu_id'];
                $data['page_functions_js'] = "functions_login.js";
                $this->views->getView($this, "cambiar_password", $data);
            }
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
}
