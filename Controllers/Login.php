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
        $data['css'] = ['css/custom.css', 'css/main.css'];
        $data['js'] = ['js/plugins/main.js', 'js/app/fn_lg.js'];
        $this->views->getView('App/Login', "login", $data);
    }

    public function loginUser()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            if (empty($_POST['usuario']) || empty($_POST['pass'])) {
                $arrResponse = array('status' => false, 'title' => '', 'icon' => 'warning', 'text' => 'No deje campos vacios');
            } else {
                $strUsuario  =  strtolower(strClean($_POST['usuario']));
                // password_verify($pas, $consulta['contrasena'])
                // $strPassword = hash("SHA256", $_POST['pass']);
                $strPassword = $_POST['pass'];
                $requestUser = $this->model->loginUser($strUsuario);
                if (empty($requestUser)) {
                    $arrResponse = array('status' => false, 'title' => 'Atención!', 'icon' => 'warning', 'text' => 'El usuario es invalido, por favor vuelva a intentarlo');
                } else {
                    if (password_verify($strPassword, $requestUser['usu_pass'])) {
                        $arrData = $requestUser;
                        if ($arrData['usu_activo'] == 1 && $arrData['usu_estado'] == 1) {
                            $_SESSION['lnh_id'] = $arrData['usu_id'];
                            $_SESSION['lnh_r'] = $arrData['idrol'];
                            $_SESSION['login'] = true;
                            // $arrData = $this->model->sessionLogin($_SESSION['idUser']);
                            $arrResponse = array('status' => true, 'title' => 'Excelente!!', 'icon' => 'success', 'text' => 'Bienvenido');
                        } else if ($arrData['usu_activo'] == 0 && $arrData['usu_estado'] == 1) {
                            $arrResponse = array('status' => false, 'title' => '', 'icon' => 'warning', 'text' => 'Usuario sin confirmar, revise su email para confirmar su cuenta.');
                        } else {
                            $arrResponse = array('status' => false, 'title' => '', 'icon' => 'warning', 'text' => 'Usuario bloqueado');
                        }
                    } else {
                        $arrResponse = array('status' => false, 'title' => '', 'icon' => 'warning', 'text' => 'Contraseña incorrecta');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function registrar()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $usu = strClean($_POST['regusu']);
            $pass = strClean($_POST['regpass']);
            $conpas = strClean($_POST['regconpass']);
            if (empty($usu) || empty($pass) || empty($conpas)) {
                $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'No deje campos vacios');
            } else {
                if ($pass === $conpas) {
                    $token = passGenerator(32);
                    $request = $this->model->regusu($usu, password_hash($pass, PASSWORD_DEFAULT), $token);
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

    public function activar($params)
    {
        // REQUEST_METHOD

        // if (empty($params)) {
        //     header('Location: ' . base_url());
        // } else {
        //     $arrParams = explode(',', $params);
        //     $strEmail = (!empty($arrParams[0])) ? strClean($arrParams[0]) : '';
        //     $strToken = (!empty($arrParams[1])) ? strClean($arrParams[1]) : '';
        //     if (empty($strEmail) || empty($strToken)) {
        //         header('Location: ' . base_url());
        //     } else {
        //         $arrResponse = $this->model->getUsuario($strEmail, $strToken, 0);
        //         if (empty($arrResponse)) {
        //             header('Location: ' . base_url());
        //         } else {
        //             $request = $this->model->activar($strEmail, $strToken);
        //             if ($request) {
        //                 $data['content'] = 'cuenta activa';
        //             } else {
        //                 $data['content'] = 'ocurrio un error';
        //             }
        //             $data['tag_page']     = "Login - Biblio Web 2.0";
        //             $data['titulo_web']   = "Biblio Web";
        //             $data['page_name']    = "login";
        //             $data['css'] = ['css/custom.css'];
        //             $data['js'] = ['js/app/fn_lg.js'];
        //             $this->views->getView($this, "activacion", $data);
        //         }
        //     }
        // }
        die();
    }

    public function resetPass()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            if (empty($_POST['txtEmailReset'])) {
                $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Error de datos');
            } else {
                $strEmail = strtolower(strClean($_POST['txtEmailReset']));
                $arrData = $this->model->getUserEmail($strEmail);

                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Usuario no encontrado.');
                } else {
                    if ($arrData['usu_estado'] == 1) {
                        if ($arrData['usu_activo'] == 0) {
                            $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Esta intentando reestablecer una cuenta sin activar.');
                        } else {
                            $token = passGenerator(15);
                            $url_recovery = base_url() . 'login/recover/' . $strEmail . '/' . $token . '==';
                            $request = $this->model->setTokenUser($strEmail, $token);
                            $dataUsuario = array(
                                'nombre' => $arrData['per_nombre'],
                                'nombreUsuario' => $arrData['per_nombre'],
                                'email' => $strEmail,
                                'asunto' => 'Recuperar cuenta - ' . NOMBRE_EMPRESA,
                                'url_recovery' => $url_recovery
                            );
                            if ($request) {
                                $sendEmail = enviarEmail($dataUsuario, 'email_cambioPassword');
                                if ($sendEmail) {
                                    $arrResponse = array('status' => true, 'icon' => 'success', 'text' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.');
                                } else {
                                    $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'No es posible realizar el proceso, intenta más tarde.2');
                                }
                            } else {
                                $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'No es posible realizar el proceso, intenta más tarde.');
                            }
                        }
                    } else {
                        $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Cuenta inactiva, imposible reestablecer');
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function recover($params)
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
                $data['titulo_web']   = "Cambiar Contraseña";
                $data['page_name']    = "cambiar_contraseña";
                $data['email']     = $strEmail;
                $data['token']     = $strToken;
                $data['idpersona']    = $arrResponse['usu_id'];
                $data['js'] = ['js/plugins/jquery.validate.min.js', 'js/app/demo.js', 'js/app/fn_lg.js'];
                $data['css'] = ['css/main.css', 'css/custom.css'];
                $this->views->getView('App/Login', "cambiar_password", $data);
            }
        }
        exit();
    }
    
    public function setPassword()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $l = '1';
            if ($l === '11') {
                $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Error de datos 1');
            } else {
                $intIdpersona = intval(strClean($_POST['idUsuario']));
                $strPassword = $_POST['txtPassword'];
                $strPasswordConfirm = $_POST['txtPasswordConfirm'];
                $strEmail = strClean($_POST['txtEmail']);
                $strToken = strClean($_POST['txtToken']);

                if ($strPassword != $strPasswordConfirm) {
                    $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Las contraseñas no son iguales.');
                } else {
                    $mensaje = '';
                    if (validar_clave($strPassword, $mensaje)) {
                        $arrResponseUser = $this->model->getUsuario($strEmail, $strToken, $intIdpersona);
                        if (empty($arrResponseUser)) {
                            $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'Error de datos.');
                        } else {
                            $strPassword = password_hash($strPassword, PASSWORD_DEFAULT);
                            $requestPass =  $this->model->insertPassword($intIdpersona, $strPassword);

                            if ($requestPass) {
                                $arrResponse = array('status' => true, 'icon' => 'success', 'text' => 'Contraseña actualizada con exito.');
                            } else {
                                $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => 'No es posible realizar el proceso, intente más tarde.');
                            }
                        }
                    } else {
                        $arrResponse = array('status' => false, 'icon' => 'warning', 'text' => $mensaje);
                    }
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            die();
        } else {
            header('Location: ' . base_url() . 'dashboard');
        }
    }

    public function patrones()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $request = $this->model->p();
            if (!empty($request)) {
                $arrResponse = array('status' => true, 'cant' => count($request), 'data' => $request);
            } else {
                $arrResponse = array('status' => false, 'icon' => 'error', 'title' => 'Sin patrones de validación', 'text' => '');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function demo()
    {
        dep([exec('getmac'), strtok(exec('getmac'), ''), exec('whoami'), substr(php_uname(), 0, 7)]);
        $pasword = 'DJ-leenh-1';
        dep($pasword);
        $error_encontrado = "";
        dep(validar_clave($pasword, $error_encontrado));
        dep($error_encontrado);
        dep(password_hash('123456', PASSWORD_DEFAULT));
    }
}
