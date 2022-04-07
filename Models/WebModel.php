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
            $sql = "UPDATE web_usuarios SET usu_token=?,usu_primera=? WHERE usu_usuario like '$email'";
            $arrData = array($token, 1);
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
            $return['data'] = 'No existe usuario.';
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
            $return['data'] = 'No existe usuario.';
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
            $return['status'] = false;
            $return['data'] = 'No podemos corroborar su información, por favor verifique sus respuestas.';
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
}
