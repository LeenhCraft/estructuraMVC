<?php
class WebModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertar($dni, $nombre, $email, $token)
    {
        $return = $request = [];
        $sql = "SELECT * FROM web_usuarios WHERE usu_usuario like '$email'";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "INSERT INTO web_usuarios(usu_dni,usu_nombre,usu_usuario,usu_token,usu_activo) VALUES (?,?,?,?,?)";
            $arrData = array($dni, $nombre, $email, $token, 0);
            $response = $this->insert($sql, $arrData);
            if ($response > 0) {
                $return['status'] = true;
                $return['data'] = '';
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al intentar registrar el usuario.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'Ya existe una cuenta con este correo electronico. Por favor intente con otro.';
        }
        return $return;
    }

    public function validar($email, $token)
    {
        $return = $request = [];
        $sql = "SELECT * FROM web_usuarios WHERE usu_usuario like '$email' AND usu_token like '$token' AND usu_activo = 0 AND usu_estado = 1";
        $request = $this->select($sql);

        if (!empty($request)) {
            $return['status'] = true;
            $return['data'] = $request;
        } else {
            $return['status'] = false;
            $return['data'] = 'No existe un usuario con este DNI.';
        }
        return $return;
    }

    public function upd_cuenta($strEmail, $strToken, $pass)
    {
        $sql = "SELECT * FROM web_usuarios WHERE usu_usuario like '$strEmail' AND usu_token like '$strToken' AND usu_activo = 0 AND usu_estado = 1";
        $request = $this->select($sql);

        if (!empty($request)) {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "UPDATE web_usuarios SET usu_pass=?,usu_token=?, usu_activo=?, usu_factivo=? WHERE usu_usuario like '$strEmail' AND usu_token like '$strToken'";
            $arrData = array($pass, '', 1, date('Y-m-d H:i:s'));
            $request = $this->update($sql, $arrData);
            if ($request) {
                $return['status'] = true;
                $return['data'] = '';
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al tratar de actualizar el registro.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'No existe registros.';
        }
        return $return;
    }

    public function ins_preg($idusuario, $preg, $resp)
    {
        for ($i = 0; $i < count($preg); $i++) {
            $sql = "INSERT INTO sis_preguntas(pre_nombre) VALUES (?)";
            $arrData = array($preg[$i]);
            $request = $this->insert($sql, $arrData);

            $idpreg = $request;

            $sql = "INSERT INTO web_usu_preg(idwebusuario,idpregunta) VALUES (?,?)";
            $arrData = array($idusuario, $idpreg);
            $request = $this->insert($sql, $arrData);

            $sql = "INSERT INTO sis_respuestas(idpregunta,res_valor) VALUES (?,?)";
            $arrData = array($idpreg, $resp[$i]);
            $request = $this->insert($sql, $arrData);
        }
        if ($request) {
            $return['status'] = true;
            $return['data'] = '';
        } else {
            $return['status'] = false;
            $return['data'] = 'Ocurrio un error al tratar de registrar la pregunta y respuesta.';
        }
        return $return;
    }

    public function login($strEmail, $strPassword)
    {
        $sql = "SELECT * FROM web_usuarios WHERE usu_usuario like '$strEmail' AND usu_estado = 1 AND usu_activo = 1";
        $request = $this->select($sql);
        return $request;
    }

    public function first_time()
    {
        $return['primera'] = '0';
        $id = (isset($_SESSION['pe_u'])) ? intval($_SESSION['pe_u']) : 0;
        $sql = "SELECT usu_primera as primera FROM web_usuarios WHERE idwebusuario = '$id'";
        $request = $this->select($sql);

        if ($request > 0) {
            $return['primera'] = $request['primera'];
        }
        return $return;
    }


    public function upd_pswd($pas)
    {
        $idusuario = (isset($_SESSION['pe_u'])) ? intval($_SESSION['pe_u']) : 0;
        $sql = "SELECT * FROM web_usuarios WHERE idwebusuario = '$idusuario'";
        $request = $this->select($sql);

        if (!empty($request)) {
            $pass = password_hash($pas, PASSWORD_DEFAULT);
            $sql = "UPDATE web_usuarios SET usu_pass=?,usu_primera=? WHERE idwebusuario = '$idusuario'";
            $arrData = array($pass, 0);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $return['status'] = true;
                $return['data'] = '';
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al tratar de actualizar el registro.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'No existe registros.';
        }
        return $return;
    }

    public function recuperar($email, $token)
    {
        $return = $request = [];
        $sql = "SELECT * FROM web_usuarios WHERE usu_activo = 1 AND usu_estado = 1 AND usu_usuario like '$email'";
        $request1 = $this->select($sql);

        if (!empty($request1)) {
            // $sql = "UPDATE web_usuarios SET usu_token=?,usu_primera=? WHERE usu_usuario like '$email'";
            $sql = "UPDATE web_usuarios SET usu_token=? WHERE usu_usuario like '$email'";
            $arrData = array($token);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $return['status'] = true;
                $return['data'] = $request1;
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al tratar de actualizar el registro.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'Usuario incorrecto.';
        }
        return $return;
    }

    public function validar2($email, $token)
    {
        $return = $request = [];
        $sql = "SELECT * FROM web_usuarios WHERE usu_usuario like '$email' AND usu_token like '$token' AND usu_activo = 1 AND usu_estado = 1";
        $request = $this->select($sql);

        if (!empty($request)) {
            $return['status'] = true;
            $return['data'] = $request;
        } else {
            $return['status'] = false;
            $return['data'] = 'Usuario incorrecto.';
        }
        return $return;
    }

    public function getPreguntas($idusuario)
    {
        $return = $request = [];
        $sql = "SELECT
                    b.idpregunta,
                    b.pre_nombre AS pregunta
                FROM
                    web_usu_preg a
                INNER JOIN sis_preguntas b ON
                    a.idpregunta = b.idpregunta
                WHERE
                    a.idwebusuario = '$idusuario'";
        $request = $this->select_all($sql);

        if (!empty($request)) {
            $return['status'] = true;
            $return['data'] = $request;
        } else {
            $return['status'] = false;
            $return['data'] = 'No existe usuario .';
        }
        return $return;
    }

    public function validar_respuestas($idwebusuario, $preguntas, $respuestas)
    {
        $return = $request = [];
        $coun = 0;
        for ($i = 0; $i < count($preguntas); $i++) {

            $sql = "SELECT
                        *
                    FROM
                        web_usu_preg a
                    INNER JOIN sis_preguntas b ON
                        a.idpregunta = b.idpregunta
                    INNER JOIN sis_respuestas c ON
                        b.idpregunta = c.idpregunta
                    WHERE
                        a.idwebusuario = '$idwebusuario' AND b.idpregunta = '$preguntas[$i]' AND c.res_valor LIKE '$respuestas[$i]'";
            $request = $this->select($sql);
            if (!empty($request)) {
                $coun++;
            }
        }

        if ($coun >= 2) {
            $return['status'] = true;
            $return['data'] = '';
        } else {
            $sql = "SELECT * FROM sis_intentos WHERE idwebusuario = '$idwebusuario' AND int_delete = 0 ORDER BY idintento DESC LIMIT 1";
            $request = $this->select($sql);
            if (!empty($request)) {
                if ($request['int_veces'] == '3') {

                    switch ($request['int_intento']) {
                        case '1':
                            $h = 0;
                            $m = 15;
                            $sql = "UPDATE sis_intentos SET  int_veces = 0,int_timeHrs = ?,int_timeMin=?,int_intento = 2,int_fechahora=? WHERE idintento = ?";
                            break;
                        case '2':
                            $h = 24;
                            $m = 0;
                            $sql = "UPDATE sis_intentos SET  int_veces = 0,int_timeHrs = ?,int_timeMin=?,int_intento = 3,int_fechahora=? WHERE idintento = ?";
                            break;
                        case '3':
                            $h = 0;
                            $m = 0;
                            $sql = "UPDATE sis_intentos SET  int_veces = 0,int_timeHrs = ?,int_timeMin=?,int_intento = 0,int_fechahora=? WHERE idintento = ?";
                            break;
                        default:
                            $h = 0;
                            $m = 5;
                            $sql = "UPDATE sis_intentos SET  int_veces = 0,int_timeHrs = ?,int_timeMin=?,int_intento = 1,int_fechahora=? WHERE idintento = ?";
                            break;
                    }
                    // dep($sql, 1);
                    // $sql = "UPDATE sis_intentos SET int_timeHrs = ?,int_timeMin=? WHERE idintento = ?";
                    $arrData = array($h, $m, date('Y-m-d H:i:s'), $request['idintento']);
                    $request = $this->update($sql, $arrData);


                    $return['status'] = false;
                    $return['limite_superado'] = '1';
                    $return['data'] = 'Ha superado el número de intentos permitidos.';
                } else {
                    $intentos = $request['int_veces'] + 1;
                    $sql = "UPDATE sis_intentos SET int_veces = ?,int_fechahora=? WHERE idwebusuario = ?";
                    $arrData = array($intentos, date('Y-m-d H:i:s'), $idwebusuario);
                    $request = $this->update($sql, $arrData);

                    $return['status'] = false;
                    $return['limite_superado'] = '0';
                    $return['data'] = 'No podemos corroborar su información, por favor verifique sus respuestas.';
                }
            } else {
                $sql = "INSERT INTO sis_intentos (idwebusuario, int_veces) VALUES (?,?)";
                $arrData = array($idwebusuario, 1);
                $request = $this->insert($sql, $arrData);

                $return['status'] = false;
                $return['limite_superado'] = '0';
                $return['data'] = 'No podemos corroborar su información, por favor verifique sus respuestas.';
            }
        }
        return $return;
    }

    public function upd_recuperar($idwebusuario, $pass)
    {
        $return = $request = [];
        $sql = "SELECT * FROM web_usuarios WHERE usu_activo = 1 AND usu_estado = 1 AND idwebusuario = '$idwebusuario'";
        $request1 = $this->select($sql);

        if (!empty($request1)) {
            $pass = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "UPDATE web_usuarios SET usu_pass=?,usu_token=?,usu_primera=? WHERE idwebusuario = '$idwebusuario'";
            $arrData = array($pass, '', 1);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $sql = "SELECT * FROM sis_intentos WHERE idwebusuario = '$idwebusuario' AND int_delete = 0 ORDER BY idintento DESC LIMIT 1";
                $request = $this->select($sql);
                if (!empty($request)) {
                    $sql = "UPDATE sis_intentos SET int_delete=? WHERE idwebusuario = ?";
                    $arrData = array(1, $idwebusuario);
                    $request = $this->update($sql, $arrData);
                }
                $return['status'] = true;
                $return['data'] = $request1;
            } else {
                $return['status'] = false;
                $return['data'] = 'Ocurrio un error al tratar de actualizar el registro.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'No existe usuario.';
        }
        return $return;
    }

    public function estado_recu($email)
    {
        $return = $request = [];
        $h = $m = $id = 0;
        $estado = false;
        $sql = "SELECT b.idwebusuario AS id,a.int_timeHrs as 'H', a.int_timeMin as 'M' FROM sis_intentos a
        INNER JOIN web_usuarios b ON b.idwebusuario=a.idwebusuario
        WHERE b.usu_usuario = '$email' AND a.int_delete = 0 AND a.int_veces <= 3 AND a.int_intento <=3 ORDER BY a.idintento DESC LIMIT 1";
        $request = $this->select($sql);

        if (!empty($request)) {
            $id = $request['id'];
            $h = $request['H'];
            $m = $request['M'];
            $sql = "SELECT
                        b.*
                    FROM
                        sis_intentos a
                    INNER JOIN web_usuarios b ON
                        a.idwebusuario = b.idwebusuario
                    WHERE
                        a.idwebusuario = '$id' AND a.int_fechahora >= DATE_SUB(
                            NOW(), INTERVAL '$h:$m' HOUR_MINUTE) AND a.int_delete = 0
                        ORDER BY
                            a.idintento
                        DESC
                    LIMIT 1";
            $request = $this->select($sql);
            if (empty($request)) {
                //desbloquear
                $estado = true;
            }
        } else {
            $estado = true;
        }

        if ($estado) {
            $sql = "SELECT * FROM web_usuarios WHERE usu_activo = 1 AND usu_estado = 1 AND usu_usuario like '$email'";
            $request1 = $this->select($sql);

            if (!empty($request1)) {
                $return['status'] = true;
                $return['data'] = $request1;
            } else {
                $return['status'] = false;
                $return['data'] = 'Usuario incorrecto.';
            }
        } else {
            $return['status'] = false;
            $return['data'] = 'Este usuario se encuentra temporalmente bloqueado, para recuperar su contraseña por favor intente más tarde.';
        }


        return $return;
    }
}
