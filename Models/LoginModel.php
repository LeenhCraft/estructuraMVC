<?php
class LoginModel extends Mysql
{

	private $intIdUsuario;
	private $strUsuario;
	private $strPassword;
	private $strToken;

	public function __construct()
	{
		parent::__construct();
	}

	public function loginUser(string $usuario, string $password = "")
	{
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$sql = "SELECT * FROM sis_usuarios WHERE 
				usu_usuario like '$this->strUsuario'";
		$request = $this->select($sql);
		return $request;
	}

	public function sessionLogin(int $iduser)
	{
		$this->intIdUsuario = $iduser;
		// Busca roles
		$sql = "SELECT p.usu_id,
						p.usu_dni,
						p.usu_nombre,
						p.usu_apellidos,
						p.usu_celular,
						p.usu_usuario,
						p.usu_estado,
						r.rol_id,
						r.rol_nombre
				FROM sis_usuarios p
				INNER JOIN bib_rol r 
				ON p.rol_id = r.rol_id
				WHERE p.usu_id = $this->intIdUsuario";
		$request = $this->select($sql);
		$_SESSION['userData'] = $request;
		return $request;
	}

	public function getUserEmail(string $email)
	{
		$sql = "SELECT * FROM sis_usuarios a
		INNER JOIN bib_personal b ON b.idpersona=a.idpersona
		WHERE a.usu_usuario like '$email'";
		$request = $this->select($sql);
		return $request;
	}

	public function setTokenUser(string $email, string $token)
	{
		$sql = "UPDATE sis_usuarios SET usu_token = ? WHERE usu_usuario like '$email'";
		$arrData = array($token);
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function getUsuario(string $email, string $token, int $usu_id)
	{
		$this->intIdUsuario = $usu_id;
		$this->strUsuario = $email;
		$this->strToken = $token;

		if (empty($this->intIdUsuario)) {
			$sql = "SELECT usu_id FROM sis_usuarios WHERE usu_usuario = '$this->strUsuario' AND usu_token = '$this->strToken' AND usu_estado = 1";
		} else {
			$sql = "SELECT usu_id FROM sis_usuarios WHERE usu_usuario = '$this->strUsuario' AND usu_token = '$this->strToken' AND usu_id = '$this->intIdUsuario' AND usu_estado = 1";
		}
		$request = $this->select($sql);
		return $request;
	}

	public function insertPassword(int $idpersona, string $password)
	{
		$this->intIdUsuario = $idpersona;
		$this->strPassword = $password;

		$sql = "UPDATE sis_usuarios SET usu_pass =?, usu_token =? WHERE usu_id = $this->intIdUsuario";
		$arrData = array($this->strPassword, "");
		$request = $this->update($sql, $arrData);
		return $request;
	}

	public function regusu($usu, $pass, $token)
	{
		$request = "";
		$sql = "SELECT * FROM sis_usuarios WHERE usu_usuario='{$usu}'";
		$request = $this->select_all($sql);
		if (empty($request)) {
			$query_insert = "INSERT INTO sis_usuarios(usu_usuario,usu_pass,usu_token,usu_estado) VALUES (?,?,?,?)";
			$arrData = [$usu, $pass, $token, 1];
			$request_insert = $this->insert($query_insert, $arrData);
			$request_insert > 0 ? $request = 'ok' : $request = 'no';
		} else {
			$request = "exist";
		}
		return $request;
	}

	public function activar($email, $token)
	{
		$sql = "UPDATE sis_usuarios SET usu_token = '', usu_activo=1 WHERE usu_token like '$token' and usu_usuario like '$email'";
		$arrData = [];
		$request = $this->update($sql, $arrData);
		return $request;
	}
}
