<?php
class Usuarios extends Controllers
{
    private $permisos;
    public function __construct()
    {
        parent::__construct();
        // session_start();
        $this->permisos = getPermisos(get_class($this));
        if (!isset($_SESSION['login']) || $this->permisos['perm_r'] != 1) {
            header('Location: ' . base_url() . 'login');
        }
    }

    public function usuarios()
    {
        $data['titulo_web']   = "Usuarios - Biblio Web 2.0";
        $data['titulo_web2'] = "USUARIOS - <small>Biblio Web</small>";
        $data['js'] = ['js/app/fn_usu.js'];
        $data['permisos']  = $this->permisos;
        $this->views->getView('App/Usuarios', "usuarios", $data);
    }

    public function setUsuario()
    {
        if ($_POST) {
            if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario         = intval($_POST['idUsuario']);
                $strIdentificacion = intval(strClean($_POST['txtIdentificacion']));
                $strNombre         = ucwords(strClean($_POST['txtNombre']));
                $strApellido       = ucwords(strClean($_POST['txtApellido']));
                $intTelefono       = intval(strClean($_POST['txtTelefono']));
                $strEmail          = strtolower(strClean($_POST['txtEmail']));
                $intTipoId         = intval(strClean($_POST['listRolid']));
                $intStatus         = intval(strClean($_POST['listStatus']));
                $request_user = "";

                if ($idUsuario == 0) {
                    $option = 1;
                    $strPassword  = empty($_POST['txtPassword']) ? hash("SHA256", passGenerator()) : hash("SHA256", $_POST['txtPassword']);
                    if ($_SESSION['permisosMod']['perm_w']) {
                        $request_user = $this->model->insertUsuario($strIdentificacion, $strNombre, $strApellido, $intTelefono, $strEmail, $strPassword, $intTipoId, $intStatus);
                    }
                } else {
                    $option = 2;
                    $strPassword  = empty($_POST['txtPassword']) ? "" : hash("SHA256", $_POST['txtPassword']);
                    if ($_SESSION['permisosMod']['perm_u']) {
                        $request_user = $this->model->updateUsuario($idUsuario, $strIdentificacion, $strNombre, $strApellido, $intTelefono, $strEmail, $strPassword, $intTipoId, $intStatus);
                    }
                }

                if ($request_user > 0) {
                    if ($option == 1) {
                        $arrResponse = array("status" => true, 'msg' => 'Datos Guardados correctamente.');
                    } else {
                        $arrResponse = array("status" => true, 'msg' => 'Datos Actualizados correctamente.');
                    }
                } else if ($request_user == 'exist') {
                    $arrResponse = array("status" => false, 'msg' => '¡Atención! el email o la identificación ya existe, porfavor ingrese otro.');
                } else {
                    $arrResponse = array("status" => false, 'msg' => 'No es posible almacenar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }


    public function getUsuarios()
    {
        if ($_SESSION['permisosMod']['perm_r']) {
            $arrData = $this->model->selectUsuarios();
            // var_dump($arrData);exit;

            for ($i = 0; $i < count($arrData); $i++) {
                $btnView = '';
                $btnEdit = '';
                $btnDelete = '';

                if ($arrData[$i]['usu_estado'] == 1) {
                    $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
                } else {
                    $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
                }

                if ($_SESSION['permisosMod']['perm_r']) {
                    $btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario(' . $arrData[$i]['usu_id'] . ')" title="Ver usuario"><i class="far fa-eye"></i></button>';
                }

                if ($_SESSION['permisosMod']['perm_u']) {
                    if (
                        $_SESSION['idUser'] == 1 && $_SESSION['userData']['rol_id'] == 1 ||
                        ($_SESSION['userData']['rol_id'] == 1 && $arrData[$i]['rol_id'] != 1)
                    ) {

                        $btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario(this,' . $arrData[$i]['usu_id'] . ')" title="Editar usuario"><i class="fas fa-pencil-alt"></i></button>';
                    } else {
                        $btnEdit = '<button class="btn btn-secondary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';
                    }
                }
                if ($_SESSION['permisosMod']['perm_d']) {
                    if (
                        $_SESSION['idUser'] == 1 && $_SESSION['userData']['rol_id'] == 1 ||
                        ($_SESSION['userData']['rol_id'] == 1 && $arrData[$i]['rol_id'] != 1) and
                        ($_SESSION['userData']['usu_id'] != $arrData[$i]['usu_id'])
                    ) {
                        $btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onclick="fntDelUsuario(' . $arrData[$i]['usu_id'] . ')" title="Eliminar usuario"><i class="far fa-trash-alt"></i></button>';
                    } else {
                        $btnDelete = '<button class="btn btn-secondary btn-sm" disabled><i class="far fa-trash-alt"></i></button>';
                    }
                }

                $arrData[$i]['options'] =
                    '<div class="text-center">
                ' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '
                </div>';
            }

            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }

    public function getUsuario($idpersona)
    {
        if ($_SESSION['permisosMod']['perm_r']) {
            $idusuario = intval($idpersona);
            if ($idusuario > 0) {
                $arrData = $this->model->selectUsuario($idusuario);
                // var_dump($arrData);
                if (empty($arrData)) {
                    $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
                } else {
                    $arrResponse = array('status' => true, 'data' => $arrData);
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function delUsuario()
    {
        if ($_POST) {
            if ($_SESSION['permisosMod']['perm_d']) {
                $intIdpersona = intval($_POST['idUsuario']);
                $requestDelete = $this->model->deleteUsuario($intIdpersona);
                if ($requestDelete) {
                    $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario.');
                } else {
                    $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
                }
                echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function perfil()
    {
        $data['tag_page']   = "Perfil - Biblio Web 2.0"; //nombre que aparece en lo alto
        $data['page_title'] = "Perfil de Usuario";
        $data['page_name']  = "perfil";
        $data['page_functions_js'] = "functions_perfil.js";
        $this->views->getView($this, "perfil", $data);
    }

    public function putPerfil()
    {
        if ($_POST) {
            if (empty($_POST['txtIdentificacion']) || empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono'])) {
                $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
            } else {
                $idUsuario = $_SESSION['idUser'];
                $strIdentificacion = strClean($_POST['txtIdentificacion']);
                $strNombre = strClean($_POST['txtNombre']);
                $strApellido = strClean($_POST['txtApellido']);
                $intTelefono = intval(strClean($_POST['txtTelefono']));
                $strPassword = "";
                if (!empty($_POST['txtPassword'])) {
                    $strPassword = hash("SHA256", $_POST['txtPassword']);
                }
                $request_user = $this->model->updatePerfil(
                    $idUsuario,
                    $strIdentificacion,
                    $strNombre,
                    $strApellido,
                    $intTelefono,
                    $strPassword
                );
                if ($request_user) {
                    // sessionUser($_SESSION['idUser']);
                    $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                } else {
                    $arrResponse = array("status" => false, "msg" => 'No es posible actualizar los datos.');
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }



    public function lst()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            if ($this->permisos['perm_r'] == 1) {
                $arrData = $this->model->lstUser();
                $nmr = 1;
                for ($i = 0; $i < count($arrData); $i++) {
                    $arrData[$i]['nmr'] = $nmr;
                    $nmr++;
                    $btnEdit = '';
                    $btnDelete = '';

                    if ($arrData[$i]['estado'] == 1) {
                        $arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
                    } else {
                        $arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
                    }
                    if ($this->permisos['perm_u'] == '1') {
                        $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrData[$i]['id'] . ')" title="Editar Autor"><i class="fas fa-pencil-alt"></i></button>';
                    } else {
                        $btnEdit = '<button class="btn btn-success btn-sm" title="Editar Autor" disabled><i class="fas fa-pencil-alt"></i></button>';
                    }
                    if ($this->permisos['perm_d'] == '1') {
                        $btnDelete = '<button class="btn btn-danger btn-sm" onclick="fntDel(' . $arrData[$i]['id'] . ')" title="Eliminar Autor"><i class="far fa-trash-alt"></i></button>';
                    } else {
                        $btnDelete = '<button class="btn btn-danger btn-sm" title="Eliminar Autor" disabled><i class="far fa-trash-alt"></i></button>';
                    }
                    $arrData[$i]['opciones'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btnEdit . ' ' . $btnDelete . '</div>';
                }
                echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
            }
        }
        die();
    }

    public function personal()
    {
        // strtoupper($_SERVER['REQUEST_METHOD']) === "POST" && 
        if ($this->permisos['perm_r'] == 1) {
            $arrData = $this->model->lstPersonal();
            $nmr = 1;
            for ($i = 0; $i < count($arrData); $i++) {
                $arrData[$i]['nmr'] = $nmr;
                $nmr++;
                $btnEdit = '';
                $btnDelete = '';

                if ($this->permisos['perm_u'] == '1') {
                    $btnEdit = '<button class="btn btn-success btn-sm" onClick="fntEdit(' . $arrData[$i]['id'] . ')" title="Editar Autor"><i class="fas fa-pencil-alt"></i></button>';
                } else {
                    $btnEdit = '<button class="btn btn-success btn-sm" title="Editar Autor" disabled><i class="fas fa-pencil-alt"></i></button>';
                }
                if ($this->permisos['perm_d'] == '1') {
                    $btnDelete = '<button class="btn btn-danger btn-sm" onclick="fntDel(' . $arrData[$i]['id'] . ')" title="Eliminar Autor"><i class="far fa-trash-alt"></i></button>';
                } else {
                    $btnDelete = '<button class="btn btn-danger btn-sm" title="Eliminar Autor" disabled><i class="far fa-trash-alt"></i></button>';
                }
                $arrData[$i]['opciones'] = '<div class="btn-group" role="group" aria-label="Basic example">' . $btnEdit . ' ' . $btnDelete . '</div>';
            }
            echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
