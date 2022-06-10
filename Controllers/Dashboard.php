<?php
class Dashboard extends Controllers
{
    private $permisos;

    public function __construct()
    {
        // session_start();
        if (!isset($_SESSION['login'])) {
            header('Location: ' . base_url() . 'login');
        }
        parent::__construct();
        $this->permisos = getPermisos(get_class($this));
    }

    public function dashboard()
    {
        $data['titulo_web'] = 'Biblio Web';
        // if ($primera['primera'] == '0') {
        $data['permisos'] = $this->permisos;
        $data['primera'] = $this->model->first_time();
        $this->views->getView('App/Dashboard', "dashboard", $data);
        // } else {
        //     $this->views->getView('App/Dashboard', "cambiar_pass", $data);
        // }
    }

    public function demo()
    {
        // dep(strtolower(get_class($this)));
        // dep(password_hash(321321, PASSWORD_DEFAULT));
        // dep(getPermisos(get_class($this)));
        // dep($_SESSION);     
        $this->views->getView('Errors', "404");
    }

    public function add()
    {
        if (strtoupper($_SERVER['REQUEST_METHOD']) === "POST") {
            $arrResponse = array("status" => false, 'icon' => 'info', 'title' => 'Atención!!', "text" => 'No tiene los permisos necesarios.');
            if ($this->permisos['perm_w'] == 1) {
                $cod = (isset($_POST['cod'])) ? strClean($_POST['cod']) : '';
                $title = (isset($_POST['title'])) ? strClean($_POST['title']) : '';
                $des = (isset($_POST['des'])) ? strClean($_POST['des']) : '';
                $isbn = (isset($_POST['isbn'])) ? strClean($_POST['isbn']) : '';
                $stock = 3;
                $idtipoart = 1;
                $request = $this->model->add($cod, $title, $des, $stock, $idtipoart, $isbn);
                if ($request['status']) {
                    $arrResponse = array("status" => true, 'icon' => 'success', 'title' => 'Exito!!', "text" => 'Se registro el articulo correctamente.');
                } else {
                    $arrResponse = array("status" => false, 'icon' => $request['icon'], 'title' => 'Atención!!', "text" => $request['data']);
                }
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        } else {
            header('Location: ' . base_url() . 'dashboard');
        }
        die();
    }
}
