<?php
class Web extends Controllers
{
	private $primera;

	public function __construct()
	{
		// session_start();
		parent::__construct();
		$this->primera = $this->model->first_time();
	}

	public function web()
	{
		if ($this->primera['primera'] == '1') {
			header('Location: ' . BASE_URL . 'web/password');
		}
		$data['titulo_web'] = "LEENHCRAFT | WEB";
		$data['meta_content'] = "sistemas, nueva cajamarca, pagina web, leenh";
		$data['js'] = ['js/web/fn_lg.js'];
		$data['cant'] = can_carrito();
		$data['items_banner'] = $this->items_banner();
		$this->views->getView('Web', "web", $data);
	}

	public function consultar($parametro)
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "GET") {
			$dni = intval(strClean($parametro));
			$response = consultaDNI($dni);
			echo $response;
		}
		die();
	}

	public function registrar()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
			$dni = (isset($_POST['txtdni']) && !empty($_POST['txtdni'])) ? intval($_POST['txtdni']) : 0;
			$nombre = (isset($_POST['txtnombre']) && !empty($_POST['txtnombre'])) ? strClean($_POST['txtnombre']) : '';
			$email = (isset($_POST['txtemail']) && !empty($_POST['txtemail'])) ? strClean($_POST['txtemail']) : '';
			$dt = (isset($_POST['dt']) && !empty($_POST['dt'])) ? strClean($_POST['dt']) : '';
			if (empty($dni) || empty($nombre) || empty($email)) {
				$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No deje campos vacios.');
			} else {
				// $token = md5(uniqid(rand(), true));
				$token = generar_letras(20);
				$response = $this->model->insertar($dni, $nombre, $email, $token);
				if ($response['status']) {
					$url_recovery = base_url() . 'web/confirmar/' . $email . '/' . $token . '==';
					$dataUsuario = array(
						'nombre' => $nombre,
						'email' => $email,
						'asunto' => NOMBRE_EMPRESA . ' - Validación de Registro',
						'url_recovery' => $url_recovery
					);
					$response_email = enviarEmail($dataUsuario, 'conf_reg');
					$req_car = $this->model->upd_carrito($response['data']);
					$req_vis = $this->model->upd_visita($response['data']);
					if (!empty($dt)) {
						ob_start();
						require_once __DIR__ . '/../Views/Web/Carrito/con_reg.php';
						$mensaje = ob_get_clean();
						$mensaje = str_replace('{{nombre}}', $nombre, $mensaje);
						$mensaje = str_replace('{{val}}', $response['data'], $mensaje);
						$html = $mensaje;
					} else {
						$html = 'Se envio un email a su correo electronico para completar su registro, por favor revise su bandeja de entrada.';
					}
					$arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => $html);
				} else {
					$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
				}
			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function confirmar($parametro)
	{
		if (empty($parametro)) {
			header('Location: ' . base_url());
		} else {
			$arrParams = explode(',', $parametro);
			$strEmail = strClean($arrParams[0]);
			$strToken = strClean($arrParams[1]);

			$response = $this->model->validar($strEmail, $strToken);
			if ($response['status']) {
				// $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Se valido su registro, por favor inicie sesión.');
				$data['titulo_web'] = "LEENHCRAFT | WEB";
				$data['css'] = ['css/styles.css', 'css/web/styles.css'];
				$data['js'] = ['js/web/fn_confusu.js'];
				$data['url'] = [$strEmail, $strToken];
				$data['cant'] = 0;
				$this->views->getView('Web/Usuarios', "confirmar", $data);
			} else {
				header('Location: ' . base_url());
			}
		}
		exit();
	}

	public function activar()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
			$strEmail = (isset($_POST['stremail']) && !empty($_POST['stremail'])) ? strClean($_POST['stremail']) : '';
			$strToken = (isset($_POST['strtoken']) && !empty($_POST['strtoken'])) ? strClean($_POST['strtoken']) : '';
			$v1 = (isset($_POST['txtpre1']) && !empty($_POST['txtpre1'])) ? strClean($_POST['txtpre1']) : '';
			$v2 = (isset($_POST['txtre1']) && !empty($_POST['txtre1'])) ? strClean($_POST['txtre1']) : '';
			$v3 = (isset($_POST['txtpre2']) && !empty($_POST['txtpre2'])) ? strClean($_POST['txtpre2']) : '';
			$v4 = (isset($_POST['txtre2']) && !empty($_POST['txtre2'])) ? strClean($_POST['txtre2']) : '';
			$v5 = (isset($_POST['txtpre3']) && !empty($_POST['txtpre3'])) ? strClean($_POST['txtpre3']) : '';
			$v6 = (isset($_POST['txtre3']) && !empty($_POST['txtre3'])) ? strClean($_POST['txtre3']) : '';
			$preg = [$v1, $v3, $v5];
			$resp = [$v2, $v4, $v6];

			$response = $this->model->validar($strEmail, $strToken);
			$nombre = $response['data']['usu_nombre'];
			// dep($response,1);

			if ($response['status']) {
				if (!empty($v1) && !empty($v2) && !empty($v3) && !empty($v4) && !empty($v5) && !empty($v6)) {
					$response = $this->model->ins_preg($response['data']['idwebusuario'], $preg, $resp);
					if ($response['status']) {
						$pass = '123456';
						$response = $this->model->upd_cuenta($strEmail, $strToken, $pass);
						if ($response['status']) {
							$dataUsuario = array(
								'nombre' => $nombre,
								'email' => $strEmail,
								'asunto' => NOMBRE_EMPRESA . ' - Cuenta Activada',
								'usuario' => $strEmail,
								'password' => $pass
							);
							$response = enviarEmail($dataUsuario, 'cuenta_activa');
							$arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Su cuenta ha sido activada y se envio un email con las credenciales de acceso.');
						} else {
							$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'No se pudo activar su cuenta.');
						}
					} else {
						$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
					}
				} else {
					$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Por favor complete los campos.');
				}
			} else {
				header('Location: ' . base_url());
			}

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		} else {
			header('Location: ' . base_url());
		};
		die();
	}

	public function login()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
			$strEmail = (isset($_POST['txtusu']) && !empty($_POST['txtusu'])) ? strClean($_POST['txtusu']) : '';
			$strPassword = (isset($_POST['txtpas']) && !empty($_POST['txtpas'])) ? strClean($_POST['txtpas']) : '';

			if (!empty($strEmail) && !empty($strPassword)) {
				$response = $this->model->login($strEmail, $strPassword);
				if (!empty($response)) {
					if (password_verify($strPassword, $response['usu_pass'])) {
						$req_car = $this->model->upd_carrito($response['idwebusuario']);
						$req_vis = $this->model->upd_visita($response['idwebusuario']);
						$_SESSION['pe_u'] = $response['idwebusuario'];
						$arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Bienvenido.');
					} else {
						$arrResponse = array('status' => false, 'title' => '', 'icon' => 'warning', 'text' => 'Contraseña incorrecta');
					}
				} else {
					$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'El usuario no existe.');
				}
			} else {
				$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Por favor complete los campos.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		} else {
			header('Location: ' . base_url());
		};
		die();
	}

	public function password()
	{
		if (isset($_SESSION['pe_u']) && $_SESSION['pe_u'] != 0 && $this->primera['primera'] == 1) {
			$data['titulo_web'] = "LEENHCRAFT | WEB";
			// $data['css'] = ['css/styles.css'];
			$data['js'] = ['js/web/fn_pasupd.js'];
			$data['cant'] = 0;
			$this->views->getView('Web/Usuarios', "cambiar_clave", $data);
		} else {
			header('Location: ' . base_url());
		}
	}

	public function actualizar()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
			$pas = (isset($_POST['txtpas']) && !empty($_POST['txtpas'])) ? strClean($_POST['txtpas']) : '';
			$cpas = (isset($_POST['txtcpas']) && !empty($_POST['txtcpas'])) ? strClean($_POST['txtcpas']) : '';

			if (!empty($pas) && !empty($cpas)) {
				if ($pas == $cpas) {
					$mensaje = '';
					if (validar_clave($pas, $mensaje)) {
						$response = $this->model->upd_pswd($pas);
						if ($response['status']) {
							$arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Su contraseña ha sido actualizada.');
						} else {
							$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
						}
					} else {
						$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $mensaje);
					}
				} else {
					$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Las contraseñas no coinciden.');
				}
			} else {
				$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Por favor complete los campos.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		} else {
			header('Location: ' . base_url());
		};
		die();
	}

	public function recover()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
			$usu = (isset($_POST['txtusu']) && !empty($_POST['txtusu'])) ? strClean($_POST['txtusu']) : '';
			if (!empty($usu)) {
				$response = $this->model->estado_recu($usu);
				if ($response['status']) {
					if ($response['data']['usu_token'] == '') {
						$token = generar_letras(20);
						$response = $this->model->recuperar($usu, $token);
						if ($response['status']) {
							$url_recovery = base_url() . 'web/recuperar/' . $usu . '/' . $token . '==';
							// $dataUsuario = array(
							// 	'nombre' => $response['data']['usu_nombre'],
							// 	'nombreUsuario' => $response['data']['usu_nombre'],
							// 	'email' => $usu,
							// 	'asunto' => NOMBRE_EMPRESA . ' - Recuperar Contraseña',
							// 	'url_recovery' => $url_recovery
							// );
							// $response = enviarEmail($dataUsuario, 'email_cambioPassword');
							// if ($response['status']) {
							$arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => '', 'url' => $url_recovery);
							// } else {
							// 	$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
							// }
						} else {
							$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
						}
					} else {
						$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Este usuario ya tiene un proceso de recuperación activo.', 'url' => base_url() . 'web/recuperar/' . $usu . '/' . $response['data']['usu_token'] . '==');
					}
				} else {
					$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data'], 'url' => base_url());
				}
			} else {
				$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Por favor complete los campos.');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
	}

	public function recuperar($parametro)
	{
		if (empty($parametro)) {
			header('Location: ' . base_url());
		} else {
			$arrParams = explode(',', $parametro);
			$strEmail = strClean($arrParams[0]);
			$strToken = strClean($arrParams[1]);
			$response = $this->model->validar2($strEmail, $strToken);
			if ($response['status']) {
				$preguntas = $this->model->getPreguntas($response['data']['idwebusuario']);
				// $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Se valido su registro, por favor inicie sesión.');
				$data['titulo_web'] = "LEENHCRAFT | WEB";
				// $data['css'] = ['css/styles.css', 'css/web/styles.css'];
				$data['js'] = ['js/web/fn_recuperar.js'];
				$data['url'] = [$strEmail, $strToken];
				$data['preguntas'] = $preguntas;
				$data['cant'] = 0;
				$this->views->getView('Web/Usuarios', "recuperar", $data);
			} else {
				header('Location: ' . base_url());
			}
		}
		exit();
	}

	public function validar()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
			$strEmail = (isset($_POST['stremail']) && !empty($_POST['stremail'])) ? strClean($_POST['stremail']) : '';
			$strToken = (isset($_POST['strtoken']) && !empty($_POST['strtoken'])) ? strClean($_POST['strtoken']) : '';
			$pregunta1 = (isset($_POST['pregunta1']) && !empty($_POST['pregunta1'])) ? intval($_POST['pregunta1']) : '';
			$pregunta2 = (isset($_POST['pregunta2']) && !empty($_POST['pregunta2'])) ? intval($_POST['pregunta2']) : '';
			$pregunta3 = (isset($_POST['pregunta3']) && !empty($_POST['pregunta3'])) ? intval($_POST['pregunta3']) : '';
			$respuesta1 = (isset($_POST['respuesta1']) && !empty($_POST['respuesta1'])) ? strClean($_POST['respuesta1']) : '';
			$respuesta2 = (isset($_POST['respuesta2']) && !empty($_POST['respuesta2'])) ? strClean($_POST['respuesta2']) : '';
			$respuesta3 = (isset($_POST['respuesta3']) && !empty($_POST['respuesta3'])) ? strClean($_POST['respuesta3']) : '';

			$preguntas = [$pregunta1, $pregunta2, $pregunta3];
			$respuestas = [$respuesta1, $respuesta2, $respuesta3];

			if (!empty($pregunta1) && !empty($pregunta2) && !empty($pregunta3) && !empty($respuesta1) && !empty($respuesta2) && !empty($respuesta3)) {
				$response = $this->model->validar2($strEmail, $strToken);
				if ($response['status']) {
					$idwebusuario = $response['data']['idwebusuario'];
					$response = $this->model->validar_respuestas($idwebusuario, $preguntas, $respuestas);
					if ($response['status']) {
						$pass = '123456';
						$response = $this->model->upd_recuperar($idwebusuario, $pass);
						$dataUsuario = array(
							'nombre' => $response['data']['usu_nombre'],
							'email' => $strEmail,
							'asunto' => NOMBRE_EMPRESA . ' - Recuperación de contraseña',
							'usuario' => $strEmail,
							'password' => $pass
						);
						$response = enviarEmail($dataUsuario, 'rec_pass');
						if ($response['status']) {
							$arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Hemos enviado un correo con su nueva contraseña.');
						} else {
							$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
						}
					} else {
						if ($response['limite_superado'] == '1') {
							$url = BASE_URL;
						} else {
							$url = '';
						}
						$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data'], 'url' => $url);
					}
				} else {
					$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => $response['data']);
				}
			} else {
				$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Por favor complete los campos.', 'url' => '');
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		} else {
			header('Location: ' . base_url());
		}
	}

	public function items_banner()
	{
		// if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
		$response = $this->model->items(4);
		$html = '';
		if ($response['status']) {
			foreach ($response['data'] as $row) {
				$html .= '
					<div class="single_banner_slider">
                        <div class="row">
                            <div class="col-lg-5 col-md-8">
                                <div class="banner_text">
                                    <div class="banner_text_iner">
                                        <h1>' . $row['art_nombre'] . '</h1>
                                        <p>' . substr($row['art_descri'], 0, 100) . '...</p>
                                        <a href="#" class="btn_2" onclick="return add_carrito(this,' . $row['idarticulo'] . ')">Reservar</a>
                                    </div>
                                </div>
                            </div>
							<div class="banner_img d-none d-lg-block" style="max-width: 300px; right: 15%;">
								<img src="https://web.cosmobook.pe/app/img/20220103_48iV.jpg" alt="Cargando...">
							</div>
                        </div>
                    </div>
					';
			}
		}
		return $html;
		// } else {
		// 	header('Location: ' . base_url());
		// }
	}

	public function add()
	{
		if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
			$id = (isset($_POST['id'])) ? intval($_POST['id']) : 0;
			$cant = (isset($_POST['cant'])) ? intval($_POST['cant']) : 1;
			if (!empty($id)) {
				$existe = $this->model->existe($id);
				if (!empty($existe)) {
					$hay_cant = $this->model->stock($id, $cant);
					if (!empty($hay_cant)) {
						$ya_add = $this->model->ya_add($id, $_SESSION['vi']);
						if (!empty($ya_add)) {
							$arrResponse = array("status" => false, 'icon' => 'info', 'title' => '', "text" => 'El articulo ya esta agregado.');
							// $cant = $ya_add['car_cantidad'] + $cant;
							// $response = $this->model->upd_cant($id, $cant, $_SESSION['vi']);
						} else {
							$response = $this->model->add($_SESSION['vi'], $id, $cant);
							if ($response['status']) {
								$arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Se ha agregado al carrito.', 'data' => $response['data']);
							}
						}
						// if ($response['status']) {
						// 	$arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Se ha agregado al carrito.', 'data' => $response['data']);
						// }
						//  else {
						// 	$arrResponse = array("status" => false, 'icon' => 'warning', 'title' => 'Atención!!', "text" => 'Ocurrio un error al agregar al carrito.');
						// }
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
}
